<?php 
/* 
Template Name: Sitemap Page
*/
get_header(); ?>

<?php if (function_exists('vu_breadcrumbs')) vu_breadcrumbs(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<h1 class="plain"><?php the_title(); ?></h1>

<div class="secmain">

	<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
	<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

<ul>
  <?php wp_list_pages('sort_column=menu_order&exclude=&title_li='); ?>
</ul>

<h2>Alphabetical</h2>
        <ul>
        <?php wp_list_pages('sort_column=post_title&depth=-1&exclude=&title_li='); ?>
        </ul>
</div><!-- /secmain -->

</div><!-- /seccontent-->


<?php get_sidebar(); ?>
<?php get_footer(); ?>