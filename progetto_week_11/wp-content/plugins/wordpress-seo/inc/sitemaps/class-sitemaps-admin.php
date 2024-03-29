<?php
/**
 * WPSEO plugin file.
 *
 * @package WPSEO\Admin\XML Sitemaps
 */

/**
 * Class that handles the Admin side of XML sitemaps.
 */
class WPSEO_Sitemaps_Admin {

	/**
	 * Post_types that are being imported.
	 *
	 * @var array
	 */
	private $importing_post_types = [];

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'transition_post_status', [ $this, 'status_transition' ], 10, 3 );
		add_action( 'admin_footer', [ $this, 'status_transition_bulk_finished' ] );

		WPSEO_Sitemaps_Cache::register_clear_on_option_update( 'wpseo_titles', '' );
		WPSEO_Sitemaps_Cache::register_clear_on_option_update( 'wpseo', '' );
	}

	/**
	 * Hooked into transition_post_status. Will initiate search engine pings
	 * if the post is being published, is a post type that a sitemap is built for
	 * and is a post that is included in sitemaps.
	 *
	 * @param string  $new_status New post status.
	 * @param string  $old_status Old post status.
	 * @param WP_Post $post       Post object.
	 *
	 * @return void
	 */
	public function status_transition( $new_status, $old_status, $post ) {
		if ( $new_status !== 'publish' ) {
			return;
		}

		if ( defined( 'WP_IMPORTING' ) ) {
			$this->status_transition_bulk( $new_status, $old_status, $post );

			return;
		}

		$post_type = get_post_type( $post );

		wp_cache_delete( 'lastpostmodified:gmt:' . $post_type, 'timeinfo' ); // #17455.

		// Not something we're interested in.
		if ( $post_type === 'nav_menu_item' ) {
			return;
		}

		// If the post type is excluded in options, we can stop.
		if ( WPSEO_Options::get( 'noindex-' . $post_type, false ) ) {
			return;
		}

		if ( ! YoastSEO()->helpers->environment->is_production_mode() ) {
			return;
		}

		$this->ping_search_engines();
	}

	/**
	 * Notify Google of the updated sitemap.
	 *
	 * @return void
	 */
	public function ping_search_engines() {

		if ( get_option( 'blog_public' ) === '0' ) { // Don't ping if blog is not public.
			return;
		}

		/**
		 * Filter: 'wpseo_allow_xml_sitemap_ping' - Check if pinging is not allowed (allowed by default).
		 *
		 * @param bool $allow_ping The boolean that is set to true by default.
		 */
		if ( apply_filters( 'wpseo_allow_xml_sitemap_ping', true ) === false ) {
			return;
		}

		$url = rawurlencode( WPSEO_Sitemaps_Router::get_base_url( 'sitemap_index.xml' ) );

		// Ping Google about our sitemap change.
		wp_remote_get( 'https://www.google.com/ping?sitemap=' . $url, [ 'blocking' => false ] );

		if ( ! defined( 'WPSEO_PREMIUM_FILE' ) || WPSEO_Options::get( 'enable_index_now' ) === false ) {
			wp_remote_get( 'https://www.bing.com/ping?sitemap=' . $url, [ 'blocking' => false ] );
		}
	}

	/**
	 * While bulk importing, just save unique post_types.
	 *
	 * When importing is done, if we have a post_type that is saved in the sitemap
	 * try to ping the search engines.
	 *
	 * @param string  $new_status New post status.
	 * @param string  $old_status Old post status.
	 * @param WP_Post $post       Post object.
	 *
	 * @return void
	 */
	private function status_transition_bulk( $new_status, $old_status, $post ) {
		$this->importing_post_types[] = get_post_type( $post );
		$this->importing_post_types   = array_unique( $this->importing_post_types );
	}

	/**
	 * After import finished, walk through imported post_types and update info.
	 *
	 * @return void
	 */
	public function status_transition_bulk_finished() {
		if ( ! defined( 'WP_IMPORTING' ) ) {
			return;
		}

		if ( empty( $this->importing_post_types ) ) {
			return;
		}

		$ping_search_engines = false;

		foreach ( $this->importing_post_types as $post_type ) {
			wp_cache_delete( 'lastpostmodified:gmt:' . $post_type, 'timeinfo' ); // #17455.

			// Just have the cache deleted for nav_menu_item.
			if ( $post_type === 'nav_menu_item' ) {
				continue;
			}

			if ( WPSEO_Options::get( 'noindex-' . $post_type, false ) === false ) {
				$ping_search_engines = true;
			}
		}

		// Nothing to do.
		if ( $ping_search_engines === false ) {
			return;
		}

		if ( WP_CACHE ) {
			do_action( 'wpseo_hit_sitemap_index' );
		}

		$this->ping_search_engines();
	}
}
