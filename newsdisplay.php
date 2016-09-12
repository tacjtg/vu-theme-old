<?php
/**
 * @package WordPress
 * @subpackage vanderbilt brand - NEWS FEED DISPLAY CHOICE
 */
 ?>

<div class="rssnews">
<h3><?php echo get_option('vubrand_newstitle');?></h3>

<?php // if using vanderbilt news feed is chosen - show it
if ( get_option('vubrand_othernewsfeed') <> "" ) { 

$externalfeed = get_option('vubrand_othernewsfeed');
// Get RSS Feed(s)
	include_once(ABSPATH . WPINC . '/feed.php');
	 $rss = fetch_feed($externalfeed);
	if (!is_wp_error( $rss ) ) : 
   		$maxitems = $rss->get_item_quantity(6); 
   		$rss_items = $rss->get_items(0, $maxitems); 
	endif;
?>
<ul>
	<?php if ($maxitems == 0) echo '<li>No items to display.</li>'; 
		else foreach ( $rss_items as $item ) : ?>
			<li><a href='<?php echo $item->get_permalink(); ?>'><?php echo $item->get_title(); ?></a></li>
		<?php endforeach; ?>
</ul>

<?php } //otherwise show this sites posts as the feed
else { ?>

<ul>
<?php query_posts('posts_per_page=7'); ?>
<?php while (have_posts()) : the_post(); ?>
<li><a class="clearfix" href="<?php the_permalink() ?>"><?php the_title(); ?> <small>&raquo;&nbsp;<?php the_time('n.j.y') ?></small></a></li>
<?php endwhile; ?>
</ul>

<?php // end choice of news feed options
} ?>

</div>
