<?php
/**
 * The template for the home page news widget.
 *
 * @package WP Home Page News
 * @since 2.0.0
 */

?>
<table class="widefat">
	<thead>
		<tr>
			<th class="row-title" scope="col">Title</th>
			<th>Author</th>
		</tr>
	</thead>
	<tbody>
<?php
while ( $home_page_posts->have_posts() ) {
	$home_page_posts->the_post();
?>
		<tr>
			<td class="row-title">
				<a href="<?php echo esc_url( get_edit_post_link() ); ?>">
					<?php echo esc_html( get_the_title() ); ?>
				</a>
			</td>
			<td><?php echo esc_html( get_the_author() ); ?></td>
		</tr>
<?php
}
?>
	</tbody>
</table>
