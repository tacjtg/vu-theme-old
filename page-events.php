<?php 
/* 
Template Name: Events Listing Page
*/
get_header(); ?>

<style>
<!--
.eventslisting a { border: 0 !important; } 
.eventslisting ul { list-style:none; margin:0 0 15px 0; padding:0; clear:both; }
.eventslisting li { border-bottom:1px dotted #CCC; clear:left; }
.eventslisting li a { padding:10px 7px 10px 7px; color:#555; text-decoration:none; display:block; overflow:hidden; }
.eventslisting li a:hover { background:#ECECEC; color:#333; }
.moreevents a:link, .moreevents a:visited { display: block; text-decoration: none; text-align: right; color: #666; }
.moreevents a:hover { color: #000; }
-->
</style>

<?php if (function_exists('vu_breadcrumbs')) vu_breadcrumbs(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<h1 class="plain"><?php the_title(); ?></h1>

<div class="secmain">

	<?php 
	the_content('<p class="serif">Read the rest of this page &raquo;</p>'); 
	
	wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); 
	endwhile; endif; 
	edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

<?php
$xslpath = get_bloginfo('stylesheet_directory')."/parse-vu-calendar.xsl";
$caltag = get_option('vubrand_calendartag');
$xp = new XsltProcessor();
  $xsl = new DomDocument;
  // XSL displays date, time and event title
$xsl->load($xslpath);
$xp->importStylesheet($xsl);
  $xml_doc = new DomDocument; 
  // XML for group of events you want to display - 
$xml_doc->load('http://events.vanderbilt.edu/calendar/rss/set/25?xtags='.$caltag);  
  if ($html = $xp->transformToXML($xml_doc)) { 
  	if($html!='') { 
  	echo "<div class='eventslisting'><ul>"; 
  	echo $html; 
	echo "<li class='more'><a href='http://events.vanderbilt.edu/calendar/list?xtags=".$caltag."'>MORE &raquo;</a></li>"; 
	echo "</ul></div>"; 
  	}
  	} 
  // else  { trigger_error('XSL transformation failed.', E_USER_ERROR); }  
?>


</div><!-- /secmain -->

</div><!-- /seccontent-->


<?php get_sidebar(); ?>
<?php get_footer(); ?>