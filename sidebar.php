<?php
/**
 * @package WordPress
 * @subpackage vanderbilt brand SIDEBAR
 */
?>

<div id="secnav">

<?php // show home button if not on homepage
if (!is_front_page()) { ?>
<p class="home"><a href="<?php bloginfo('url'); ?>">Back Home&nbsp;&nbsp;&nbsp;</a></p>
<?php }

// Widgetized sidebar, if you have the plugin installed.
if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) :  endif;

// if graphic header chosen and Wordpress Search - show search in right nav
if (get_option('vubrand_graphicheader') == 'true') : ?>
	<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/" class="round">
   <input type="text" value="SEARCH" onfocus="clearDefault(this)" name="s" id="s" class="searchfield" />
   <button class="btn" title="Submit Search">GO</button>
	</form>

<?php endif;

// is this site behind vunetid
$vunetidprotect = get_option('vubrand_vunetidprotect');
if($vunetidprotect=='yes') {

echo "<p>Welcome ".$_SESSION['myvefirstname']." ".$_SESSION['myvelastname'].".<br />";
echo "<a style='text-decoration: none; border: 0;' href='/mylogin/logout.php'><img src='/mylogin/logout.jpg' border='0' /></a></p>";

}

if (get_option('vubrand_socialsharelinks') != 'no') {
?>

<div class="sidebaraddthis addthis_toolbox addthis_32x32_style addthis_default_style">
    <a class="addthis_button_facebook"></a>
    <a class="addthis_button_twitter"></a>
    <a class="addthis_button_email"></a>
    <a class="addthis_button_print"></a>
    <a class="addthis_button_google"></a>
    <a class="addthis_button_compact"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#username=vanderbilt"></script>


<?php
}

// show homepage widgets
if ( (is_active_sidebar('home-sidebar-widgets')) && (is_front_page()) ) : dynamic_sidebar('home-sidebar-widgets'); endif;

// show widgets - but not on home
if ( (is_active_sidebar('pages-sidebar-widgets')) && (!is_front_page()) ) : dynamic_sidebar('pages-sidebar-widgets'); endif;

// show widgets on all
if (is_active_sidebar('all-sidebar-widgets')) : dynamic_sidebar('all-sidebar-widgets'); endif;

// if right navigation style is chosen
if (get_option('vubrand_navstyle') == 'right') { include(TEMPLATEPATH . '/rightnav.php'); }

if(get_option('vubrand_calendaron') == 'true') { ?>
<h4>Upcoming Events</h4>
<ul>
<?php
$xslpath = get_bloginfo('stylesheet_directory')."/parse-vu-calendar.xsl";
$caltag = get_option('vubrand_calendartag');
$xp = new XSLTProcessor();
$xsl = new DomDocument;
// XSL displays date, time and event title
$xsl->load($xslpath);
$xp->importStylesheet($xsl);
$xml_doc = new DomDocument;
// XML for group of events you want to display -
$xml_doc->load('https://events.vanderbilt.edu/calendar/rss/3?xtags='.$caltag);
if ($html = $xp->transformToXML($xml_doc)) { echo $html; }
// else  { trigger_error('XSL transformation failed.', E_USER_ERROR); }
?>
<li class="more"><a href="http://events.vanderbilt.edu/calendar/list?xtags=<?php echo $caltag;?>&tagname=<?php bloginfo('name'); ?> Events">More events &raquo;</a></li>
</ul>
<?php }

// TAG CLOUD  - turned off by default
// echo '<h4>Tag Cloud</h4>';
// echo get_my_tags();

// if is a page AND top nav chosen AND it is not the homepage - show subpages
if ( (get_option('vubrand_navstyle') == 'top') && (!is_front_page()) && (is_page()) ) { include(TEMPLATEPATH . '/rightchildpages.php'); }

// display a news feed in the right column
if (get_option('vubrand_newsrightcol') == 'true') { include(TEMPLATEPATH . '/newsdisplay.php'); }

?>
</div><!-- /secnav -->