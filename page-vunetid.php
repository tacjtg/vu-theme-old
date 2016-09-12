<?php
/*
Template Name: VUnetID Protected
*/
include('/var/www/my.vanderbilt.edu/offline/sessions.php');
session_start();
include(TEMPLATEPATH . '/header-vunetid.php');

 ?>

<?php // if is home page and slider option is ON
if ( (get_option('vubrand_slideron') == 'true') && (is_front_page()) ) { include(TEMPLATEPATH . '/slider.php'); } ?>

 <?php wp_reset_query(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php if (function_exists('vu_breadcrumbs')) vu_breadcrumbs(); ?>

<?php if (!is_front_page()) {  // show page title
	echo '<h1 class=plain>'; the_title(); echo '</h1>'; } ?>

<div class="secmain">
<?php
edit_post_link('<img src=https://www4.vanderbilt.edu/asset/i/editthis.jpg>', '<p>', '</p>');
the_content('<p class="serif">Read the rest of this page &raquo;</p>');
wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
if ( comments_open() ) {
  comments_template();
}
?>
</div><!-- /secmain -->

<?php endwhile; endif; ?>

</div><!-- /seccontent-->


<?php get_sidebar(); ?>


<?php get_footer(); ?>