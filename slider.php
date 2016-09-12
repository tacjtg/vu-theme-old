<!-- SLIDESHOW -->
<div id="myslideshow" class="nivoSlider">	

<?php $sliderstories = new WP_Query('tag=featured&post_type=any&order_by=date'); 
	if ($sliderstories->have_posts()) : $post = $posts[0]; $c=0; 
	while($sliderstories->have_posts()) : $sliderstories->the_post();

 $featureimage = get_post_meta($post->ID, 'featureimage', $single = true); 
	$slidertext = get_post_meta($post->ID, 'featuretext', $single = true);
	$image_id = get_post_thumbnail_id();
	$image_url = wp_get_attachment_image_src($image_id,'feat-slider');
		$image_url = $image_url[0];
?> 


<a href="<?php the_permalink() ?>"><img src="<?php echo $image_url;?>" title="<?php if($slidertext != '') { echo addslashes($slidertext); } else { the_title_attribute(); } ?>" width="650" height="300" /></a>

<?php endwhile; endif;  wp_reset_query(); ?>

</div>

<hr class="space" />