<?php
/**
 * @package WordPress
 * @subpackage vanderbilt brand
 */

get_header(); ?>

<?php if (function_exists('vu_breadcrumbs')) vu_breadcrumbs(); ?>

<h1 class="plain">Search Results</h1>

<div class="secmain">	

<p>Search Term: <strong><?php the_search_query(); ?></strong></p>

	<?php if (have_posts()) : ?>
	
<ul>	
		<?php while (have_posts()) : the_post(); ?>

<li><h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
<?php the_excerpt(); ?>
</li>

<?php endwhile; ?>
</ul>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

<?php else : ?>

<h2 class="center">No posts found. Try a different search?</h2>
<?php get_search_form(); ?>

<?php endif; ?>

</div><!-- /secmain -->
</div><!-- /seccontent-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
