<?php 
/* 
Template Name: Blog or News Page
*/
get_header(); ?>

<?php if (function_exists('vu_breadcrumbs')) vu_breadcrumbs(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
	 $show_category = get_post_meta($post->ID, 'show_category', $single = true);
	?>

	<h1 class="plain"><?php the_title(); ?></h1>

<div class="secmain">

	<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
	<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

<?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
// $wp_query->query('cat=$whatcategory&showposts=15'.'&paged='.$paged);
if($show_category!='') { $wp_query->query('showposts=15&category_name='.$show_category.'&paged='.$paged); }
else { $wp_query->query('showposts=15'.'&paged='.$paged); }
?>
<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

<a href="<?php the_permalink() ?>">
<?php if(has_post_thumbnail()) { the_post_thumbnail(array(150,150), array("class" => "blogthumb left")); } 
else { echo '<img src="'; bloginfo('stylesheet_directory'); echo '/functions/images/defaultpost.jpg" height="150" width="150" class="blogthumb left">'; } 
?></a>

<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

<p><?php echo get_the_excerpt(); ?>...
<a href="<?php the_permalink(); ?>">KEEP READING</a></p>
	
<p><small>Posted on <?php the_time('l, F jS, Y') ?> in <?php the_category(', ') ?> | <?php the_tags('Tags: ', ', ', ''); ?> <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></small></p>

<hr /> 


<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

<?php $wp_query = null; $wp_query = $temp;?>


</div><!-- /secmain -->

</div><!-- /seccontent-->


<?php get_sidebar(); ?>
<?php get_footer(); ?>