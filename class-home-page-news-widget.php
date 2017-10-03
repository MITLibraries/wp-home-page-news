<?php
/**
 * Class that defines a dashboard widget.
 *
 * @package WP Home Page News
 * @since 2.0.0
 */

namespace mitlib;

/**
 * Defines base widget
 */
class Home_Page_News_Widget {

	/**
	 * The id of this widget.
	 */
	const WID = 'home_page_news';

	/**
	 * Hook to wp_dashboard_setup to add the widget.
	 */
	public static function init() {
		if ( current_user_can( 'add_users' ) ) {
			wp_add_dashboard_widget(
				self::WID, // A unique slug/ID
				__( 'Content published to home page', 'nouveau' ), // Visible name for the widget.
				array( 'mitlib\Home_Page_News_Widget', 'widget' )  // Callback for the main widget content.
			);
		}
	}

	/**
	 * Load the widget code
	 */
	public static function widget() {
		// Get list of published posts that have the featuredArticle flag set.
		$args = array(
			'post_type'       => array( 'post', 'bibliotech', 'Spotlights' ),
			'orderby'         => 'title',
			'order'           => 'ASC',
			'post_status'     => 'publish',
			'posts_per_page'  => 25,
			'meta_query'      => array(
				array(
					'key'         => 'featuredArticle',
					'value'       => 'True',
					'compare'     => '=',
				),
			),
		);
		$home_page_posts = new \WP_Query( $args );

		// If there are any posts, use the template. If not, a simple message.
		if ( $home_page_posts->have_posts() ) {
			require_once( 'widget.php' );
		} else {
			echo '<p>No content published to home page.</p>';
		}

		// Reset post data.
		wp_reset_postdata();

	}
}
