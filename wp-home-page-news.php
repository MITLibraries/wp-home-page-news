<?php
/**
 * Plugin Name:   WP Home Page News
 * Plugin URI:    https://github.com/MITLibraries/wp-home-page-news
 * Text Domain:
 * Domain Path:
 * Description:   Displays news selected for the home page in the dashboard
 * Author:        Melissa Spiegel
 * Version:       1.0.0
 * Licence:       GPL2
 * Author URI:    https://github.com/melissaspiegel
 * Last Change:   03/09/2015
 * @package WP Home Page News
 * @author Melissa Spiegel
 * @link https://github.com/MITLibraries/wp-home-page-news
 */

defined( 'ABSPATH' ) or die( 'No script kiddies, please!' );

/**
 * Add dashboard widgets.
 */
function home_page_news_widget() {
	// Admin-level users only.
	if ( current_user_can( 'add_users' ) ) {
		// Add a pending posts dashboard widget.
		wp_add_dashboard_widget(
			'homepage_news_widget',         // Widget slug.
			'Posts sent to the homepage',   // Title.
			'homepage_news_widget_function' // Display function.
		);
	}
}
add_action( 'wp_dashboard_setup', 'home_page_news_widget' );

/**
 * Build widget.
 */
function homepage_news_widget_function() {

	// Get list of featured/promoted posts.
	$args = array(
	  'post_type'       => array( 'post', 'bibliotech', 'Spotlights' ),
	  'orderby'         => 'title',
	  'order'           => 'ASC',
	  'post_status'     => 'any',
	  'posts_per_page'  => 25,
	  'meta_query'      => array(
			array(
				'key'         => 'featuredArticle',
				'value'       => 'True',
				'compare'     => '=',
			),
		),
	);
	$homePagePosts = new WP_Query( $args );

	// The Loop.
	if ( $homePagePosts->have_posts() ) {

		get_edit_post_link();
		echo  '<table class="widefat">' .
						'<thead>' .
							'<tr>' .
								'<th class="row-title">Post title</th>' .
								'<th>Post author</th>' .
							'</tr>' .
						'</thead>' .
						'<tbody>';
		while ( $homePagePosts->have_posts() ) {
			$homePagePosts->the_post();
			echo  '<tr>' .
							'<td class="row-title"><a href="' . get_edit_post_link() . '">' . get_the_title() . '</a></td>' .
							'<td>' . get_the_author() . '</td>' .
						'</tr>';
		}
		echo    '</tbody>' .
					'</table>';
	} else {
		echo 'Nothing on the homepage.';
	}

	wp_reset_postdata();

}

?>
