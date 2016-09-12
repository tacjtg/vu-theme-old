<?php
/**
 * @package WordPress
 * @subpackage vanderbilt brand
 */
/*
Template Name: Archives
*/

get_header(); ?>

<div class="secmain">	

<?php get_search_form(); ?>

<h2>Archives by Month:</h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>

<h2>Archives by Subject:</h2>
	<ul>
		 <?php wp_list_categories(); ?>
	</ul>

</div><!-- /secmain-->
</div><!-- /seccontent-->

<?php get_footer(); ?>
