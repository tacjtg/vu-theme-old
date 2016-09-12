<?php
/**
 * @package WordPress
 * @subpackage vanderbilt brand
 */
?>

</div><!-- /container -->
</div><!-- /content -->

<div id="footer">
<div class="container">

<div class="footgroup">

<div id="yourvu" class="round">
<h4><?php if ( get_option('vubrand_footlinkheader') <> "" ) { echo get_option('vubrand_footlinkheader'); } 
	else { echo 'Your Vanderbilt'; } ?></h4>

<?php if(is_active_sidebar('footer-widget-one')) { dynamic_sidebar('footer-widget-one'); } else { ?>
<ul>
	<li><a href="http://www.vanderbilt.edu/alumni/">Alumni</a></li>
	<li><a href="http://www.vanderbilt.edu/student/">Current Students</a></li>
	<li><a href="http://www.vanderbilt.edu/faculty-staff/">Faculty & Staff</a></li>
	<li><a href="http://www.vanderbilt.edu/isss/">International Students</a></li>
	<li><a href="http://news.vanderbilt.edu/">Media</a></li>
</ul>
<?php } ?>

<?php if(is_active_sidebar('footer-widget-two')) { dynamic_sidebar('footer-widget-two'); } else { ?>
<ul>
	<li><a href="http://www.vanderbilt.edu/families/">Parents & Family</a></li>
	<li><a href="http://www.vanderbilt.edu/prospective/">Prospective Students</a></li>
	<li><a href="http://research.vanderbilt.edu/">Researchers</a></li>
	<li><a href="http://www.vucommodores.com">Sports Fans</a></li>
	<li><a href="http://www.vanderbilt.edu/community/">Visitors & Neighbors</a></li>
</ul>
<?php } ?>

</div>

<div id="social">	

<?php if (get_option('vubrand_footersocialshow') != 'no') { ?>

<h4><?php if ( get_option('vubrand_connectwith') <> "" ) { echo get_option('vubrand_connectwith'); } else { echo 'Connect with Vanderbilt'; } ?></h4>
<ul>

<?php if ( get_option('vubrand_twitterurl') <> "" ) : ?>
	<li id="socialtwitter"><a target="_blank" href="<?php echo get_option('vubrand_twitterurl');?>" title="follow us on twitter">Twitter</a></li>
<?php endif; ?>

<?php if ( get_option('vubrand_facebookurl') <> "" ) : ?>
	<li id="socialfacebook"><a target="_blank" href="<?php echo get_option('vubrand_facebookurl');?>" title="like us on facebook">Facebook</a></li>
<?php endif; ?>

<?php if ( get_option('vubrand_youtubeurl') <> "" ) : ?>
	<li id="socialyoutube"><a target="_blank" href="<?php echo get_option('vubrand_youtubeurl');?>" title="watch our youtube videos">YouTube</a></li>
<?php endif; ?>

<?php if ( get_option('vubrand_pinterest') <> "" ) : ?>
	<li id="socialpinterest"><a target="_blank" href="<?php echo get_option('vubrand_pinterest');?>" title="view our pins">Pinterest</a></li>
<?php endif; ?>

<?php if ( get_option('vubrand_instagram') <> "" ) : ?>
	<li id="socialinstagram"><a target="_blank" href="<?php echo get_option('vubrand_instagram');?>" title="view our photos">Instagram</a></li>
<?php endif; ?>

<?php if ( get_option('vubrand_flickrurl') <> "" ) : ?>
	<li id="socialflickr"><a target="_blank" href="<?php echo get_option('vubrand_flickrurl');?>" title="view our photo album">Flickr</a></li>
<?php endif; ?>

<?php if ( get_option('vubrand_linkedin') <> "" ) : ?>
	<li id="sociallinkedin"><a target="_blank" href="<?php echo get_option('vubrand_linkedin');?>" title="join us on LinkedIn">LinkedIn</a></li>
<?php endif; ?>

<?php if ( get_option('vubrand_googleplus') <> "" ) : ?>
	<li id="socialgplus"><a target="_blank" href="<?php echo get_option('vubrand_googleplus');?>" title="Join our Circles">Google+</a></li>
<?php endif; ?>

<li id="socialrss"><a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe to our rss feed">RSS Feed</a></li>
</ul>

<?php } ?>


<p><a style="border: 0;" href="<?php echo wp_login_url(); ?>">&copy;</a><?php $time = time (); $year= date("Y",$time);  echo $year;?> Vanderbilt University &middot;

<?php // get theme options Footer Information
$var = get_option('vubrand_footer_text'); echo stripslashes(get_option('vubrand_footer_text'));?><br />
<a href="http://web.vanderbilt.edu">Site Development: University Web Communications</a>
</p>

</div>

</div><!-- /footgroup -->
</div>
</div><!-- /footer -->
</div><!-- /vanderbilt -->

<?php wp_footer(); 
// get theme options Google Analytics Code
$var = get_option('vubrand_ga_code'); echo stripslashes(get_option('vubrand_ga_code'));
?>

</body>
</html>
<?php
if($vunetidprotect=='yes') { }
?>
