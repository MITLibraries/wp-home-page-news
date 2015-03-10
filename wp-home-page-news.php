<?php
/**
 * Plugin Name:   WP Home Page News
 * Plugin URI:    
 * Text Domain:   
 * Domain Path:   
 * Description:   Displays news selected for the home page in the dashboard
 * Author:        Melissa Spiegel
 * Version:       0.1.0
 * Licence:       GPL2
 * Author URI:    
 * Last Change:   03/09/2015
 */

defined('ABSPATH') or die("No script kiddies, please!");

// Add dashboard widgets
function home_page_news_widget() {
	// Admin-level users only
	if (current_user_can('add_users')){
		// Add a pending posts dashboard widget
		wp_add_dashboard_widget(
			'homepage-news_widget',         // Widget slug.
			'Posts sent to the homepage',         // Title.
			'homepage_news_widget_function' // Display function.
		);
	}
}

add_action( 'wp_dashboard_setup', 'home_page_news_widget' );

// Build the Pending posts dashboard widget
function homepage_news_widget_function() {

	$args = array(
	  'post_type' => array('post', 'bibliotech', 'spotlight'),
	  'orderby'   => 'title',
	  'order'     => 'ASC',
	  'post_status' => 'published',
	  'posts_per_page' => -1,
	  'meta_query'             => array(
		array(
			'key'       => 'featuredArticle',
			'value'     => 'True',
			'compare'   => '=',
		),
	),
	);

	$homePagePosts = new WP_Query( $args );

	// The Loop
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
