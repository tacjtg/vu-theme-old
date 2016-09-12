<?php
/**
 * @package WordPress
 * @subpackage vanderbilt brand
 */
$themename = "Vanderbilt Brand";
$shortname = "vubrand";
automatic_feed_links();
add_theme_support('post-thumbnails');
		add_image_size( 'feat-slider', 650, 300, true );
// This theme styles the visual editor with editor-style.css to match the theme style.
add_editor_style();
/* remove RSS widget because it is causing major issues on the server and SEARCH widget because its built into the templates already */
add_action('widgets_init', 'remove_default_widgets',0);
//add secure youtube oembed
wp_oembed_add_provider( '#https://(www\.)?youtube\.com/watch.*#i', 'https://www.youtube.com/oembed', true );
//Embed Video Fix
function add_secure_video_options($html) {
   if (strpos($html, "<iframe" ) !== false) {
    	$search = array('src="http://www.youtu','src="http://youtu');
		$replace = array('src="https://www.youtu','src="https://youtu');
		$html = str_replace($search, $replace, $html);

   		return $html;
   } else {
        return $html;
   }
}
add_filter('the_content', 'add_secure_video_options', 10);

function remove_default_widgets() {
	if(function_exists('unregister_widget')) {
		unregister_widget('WP_Widget_Search');
		unregister_widget('WP_Widget_RSS');
	}
}
// disable wordpress update notifications for users
add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
if (function_exists('register_sidebar'))
	register_sidebar(array(
		'name' => __( 'Right Sidebar - All Pages', 'vanderbilt brand' ),
		'id' => 'all-sidebar-widgets',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
		register_sidebar(array(
		'name' => __( 'Right Sidebar - Home', 'vanderbilt brand' ),
		'id' => 'home-sidebar-widgets',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => __( 'Right Sidebar - Pages', 'vanderbilt brand' ),
		'id' => 'pages-sidebar-widgets',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => __( 'Footer - Quicklinks 1', 'vanderbilt brand' ),
		'id' => 'footer-widget-one',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h4 id="hidetitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => __( 'Footer - Quicklinks 2', 'vanderbilt brand' ),
		'id' => 'footer-widget-two',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h4 id="hidetitle">',
		'after_title' => '</h4>',
	));
// disable XML-RPC PING
add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );
function remove_xmlrpc_pingback_ping( $methods ) {
   unset( $methods['pingback.ping'] );
   return $methods;
} ;
// Lets remove all that extra junk from the wordpress header
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Displays the links to the extra feeds such as category feeds
// remove_action( 'wp_head', 'feed_links', 2 ); // Displays the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Displays the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Displays the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Displays relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Displays the XHTML generator that is generated on the wp_head hook, WP version
// always show custom fields
add_action( 'admin_head', 'showhiddencustomfields' );
function showhiddencustomfields() {
	echo "<style type='text/css'>#postcustom .hidden { display: table-row; }</style>\n";
}
//Custom Login Screen
function my_custom_login_logo() {
    echo '<style type="text/css">h1 a { background-image:url('.get_bloginfo('template_directory').'/Vanderbilt-WP.jpg) !important; }</style>';
	}
add_action('login_head', 'my_custom_login_logo');
// add tags to pages
add_action( 'init', 'my_taxonomies_for_objects' );

function my_taxonomies_for_objects() {
	register_taxonomy_for_object_type( 'post_tag', 'page' );
}
// this makes sure tagged pages show up on those tag pages
add_filter('request', 'my_expanded_request');

function my_expanded_request($q) {
	if (isset($q['tag']) || isset($q['category_name']))
                $q['post_type'] = array('post', 'page');
	return $q;
}
// cleanup dashboard
function example_remove_dashboard_widgets() {
global $wp_meta_boxes;
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );
// custom excerpt ellipses for 2.9+
function custom_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'custom_excerpt_more');
// list childpages with shortcode
function child_pages_shortcode() {
   global $post;
   return '<ul class="childpages">'.wp_list_pages('echo=0&depth=0&title_li=&sort_column=menu_order&child_of='.$post->ID).'</ul>';
}
add_shortcode('showchildren', 'child_pages_shortcode');
// shortcode to add customfield info to post by using [field name=customfieldname] where you want unaltered code to appear
function field_func($atts) {
   global $post;
   $name = $atts['name'];
   if (empty($name)) return;

   return get_post_meta($post->ID, $name, true);
}
add_shortcode('field', 'field_func');
// create comma delimited list of post tags for use for meta
function csv_tags() {
	$posttags = get_the_tags();
	foreach((array)$posttags as $tag) {
		$csv_tags .= $tag->name . ',';
	}
	echo '<meta name="keywords" content="'.$csv_tags.', vanderbilt, vanderbilt university, nashville, research, university, news" />';
}
// add thumbnails to rss feed as enclosures
function feed_thumbnails() {
  if ( function_exists( 'get_the_image' ) and ( $thumb = get_the_image('format=array&echo=0') ) ) {
      $thumb[0] = $thumb['url'];
  } else if ( function_exists( 'has_post_thumbnail' ) and has_post_thumbnail() ) {
      $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
  } else if ( function_exists( 'get_post_thumbnail_src' ) ) {
      $thumb = get_post_thumbnail_src();
      if ( preg_match( '|^<img src="([^"]+)"|', $thumb[0], $m ) )
          $thumb[0] = $m[1];
  } else {
      $thumb = false;
  }
  if ( !empty( $thumb ) ) {
      echo "\t" . '<enclosure url="' . $thumb[0] . '" />' . "\n";
  }
}
add_action( 'rss2_item', 'feed_thumbnails' );
// TAG CLOUD
function get_my_tags()
{
	$smallest = 14;
	$largest = 26;
	$tags = get_tags();
	$counts = array();
	foreach($tags as $key => $tag)
	{
		if($tag->count < 2)
		{
			unset($tags[$key]);
		}
	}
	foreach ( (array) $tags as $key => $tag )
	{
		$counts[ $key ] = $tag->count;
	}
	$min_count = min($counts);
	$spread = max($counts) - $min_count;
	if ( $spread <= 0 )
	{
		$spread = 1;
	}
	$font_spread = $largest - $smallest;
	if ( $font_spread < 0 )
	{
		$font_spread = 1;
	}
	$font_step = $font_spread / $spread;
	$html = '<p>';
	foreach($tags as $tag)
	{
		$html .= '<a href="'.get_bloginfo('url').'/tag/' . $tag->slug . '/" style="font-size:' . round($smallest + ($tag->count - $min_count) * $font_step) . 'px">' . $tag->name . '</a> ';
	}
	$html .= '</p>';
	return $html;
}

// lets get rid of weird brs and ps inside shortcodes
function parse_shortcode_content( $content ) { 
    /* Parse nested shortcodes and add formatting. */ 
    $content = trim( wpautop( do_shortcode( $content ) ) );  
    /* Remove '</p>' from the start of the string. */ 
    if ( substr( $content, 0, 4 ) == '</p>' ) 
        $content = substr( $content, 4 );  
    /* Remove '<p>' from the end of the string. */ 
    if ( substr( $content, -3, 3 ) == '<p>' ) 
        $content = substr( $content, 0, -3 );  
    /* Remove any instances of '<p></p>'. */ 
    $content = str_replace( array( '<p></p>' ), '', $content );  
    return $content; 
} 

// accordion
function accordion_open_tag(  $atts, $content = null ) {
	$content = parse_shortcode_content( $content );
	
  return "<link rel='stylesheet' type='text/css' href='".get_stylesheet_directory_uri()."/accordion.css' media='screen' /><script type='text/javascript' src='".get_stylesheet_directory_uri()."/accordion.js'></script><ul class='accordion collapsible'>".do_shortcode($content)."</ul>";
}

function accordion_section(  $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => 'no title entered',
	), $atts) );
	$content = parse_shortcode_content($content);

  return "<li><a href='#'>".$title."</a><div class='acitem'>".$content."</div></li>";
}

add_shortcode( 'accordions', 'accordion_open_tag' );
add_shortcode( 'accordion', 'accordion_section' );


// shortcode to list posts within a post or page
function showMyPosts( $atts )
{
	extract( shortcode_atts( array(
		'category' => '',
		'num' => '5',
		'order' => 'ASC',
		'orderby' => 'date',
		'tag' => '',
	), $atts) );
	$out = '';
	$query = array();
	if ( $category != '' )
		$query[] = 'category=' . $category;
	if ( $tag != '' )
		$query[] = 'tag=' . $tag;
	if ( $num )
		$query[] = 'numberposts=' . $num;
	if ( $order )
		$query[] = 'order=' . $order;
	if ( $orderby )
		$query[] = 'orderby=' . $orderby;
	$posts_to_show = get_posts( implode( '&', $query ) );
	$out = '<ul>';
	foreach ($posts_to_show as $post_to_show) {
		$permalink = get_permalink( $post_to_show->ID );
		$out .= <<<HTML
		<li>
			<a href ="{$permalink}" title="{$post_to_show->post_title}">{$post_to_show->post_title}</a>
		</li>
HTML;
	}
	$out .= '</ul>';
    return $out;
}
add_shortcode('showposts', 'showMyPosts');
// add VU favicon
function mysite_favicon() { ?>
	<link rel="shortcut icon" href="https://www4.vanderbilt.edu/favicon.ico" />
<?php }
add_action('wp_head', 'mysite_favicon');
// breadcrumbs
function vu_breadcrumbs() {
  $delimiter = '&raquo;';
  $name = 'Home'; //text for the 'Home' link
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
  if ( !is_home() && !is_front_page() || is_paged() ) {
    echo '<p class="crumbs"><small>';
    global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . 'Archive by category &#39;';
      single_cat_title();
      echo '&#39;' . $currentAfter;
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
    } elseif ( is_single() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    } elseif ( is_search() ) {
      echo $currentBefore . 'Search results for &#39;' . get_search_query() . '&#39;' . $currentAfter;
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Posts tagged &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
    echo '</small></p>';
  }
}
// shortcode to display video from streaming server
function displayVUVideo( $atts )
{
	extract( shortcode_atts( array(
		'folder' => 'public_affairs',
		'file' => 'elvis_bowl.mp4',
		'image' => 'http://news.vanderbilt.edu/files/video-vanderbilt.jpg',
		'unique' => '',
		 'width' => '650',
		 'height' => '405',
	), $atts) );
	$out = '';
	if(empty($image)) { $image='http://news.vanderbilt.edu/files/video-vanderbilt.jpg'; }
	$out .= <<<HTML
		<hr class='space' />
		<script type="text/javascript" src="http://www.vanderbilt.edu/asset/video/swfobject.js"></script>
		<div id="vandyplayer$unique"></div>
		<script type="text/javascript">
	var so = new SWFObject('http://www.vanderbilt.edu/asset/video/flash/vuplayer.swf','mpl','$width','$height','9');
	so.addParam('allowscriptaccess','always');
	so.addParam('allowfullscreen','true');
	so.addParam('flashvars','&streamer=rtmp://flash.its.vanderbilt.edu/$folder&file=$file&image=$image&skin=http://www.vanderbilt.edu/asset/video/flash/vandy/vandy.xml&autostart=false&stretching=uniform&dock=true');
	so.write('vandyplayer$unique');
		</script>
		<hr class='space' />
HTML;

    return $out;
}
add_shortcode('vuvideo', 'displayVUVideo');
// shortcode to display iframe
function displayiFrame( $atts )
{
	extract( shortcode_atts( array(
		 'source' => '',
		 'width' => '650',
		 'height' => '405',
	), $atts) );
	$out = '';
	$out .= <<<HTML
		<hr class='space' />
		<iframe src="$source" width="$width" height="$height"></iframe>
		<hr class='space' />
HTML;

    return $out;
}
add_shortcode('vuiframe', 'displayiFrame');
// create theme options panel
$options = array (
array( "name" => $themename." Options",
	"type" => "title"),
array( "name" => "General Site Settings",
	"type" => "section"),
array( "type" => "open"),
array( "name" => "Brand Bar / School",
	"desc" => "Select the brand bar to use at the top of your website",
	"id" => $shortname."_brandbar",
	"type" => "select",
	"options" => array("Vanderbilt", "Blair","CAS","Divinity","Engineering","Graduate","Law","Medicine","Nursing","Owen","Peabody"),
	"std" => "Vanderbilt"),

array( "name" => "Password Protected",
	"desc" => "Put this ENTIRE SITE behind VUnetID.",
	"id" => $shortname."_vunetidprotect",
	"type" => "select",
	"options" => array("no", "yes"),
	"std" => "no"),
array( "name" => "Include slideshow on my homepage.",
	"desc" => "Display an image slideshow with captions based on page titles. Any post or page with a tag 'featured' will be put in the slider.",
	"id" => $shortname."_slideron",
	"type" => "checkbox",
	"std" => "true"),
array( "name" => "Navigation style",
	"desc" => "Select the type/location of your navigation",
	"id" => $shortname."_navstyle",
	"type" => "select",
	"options" => array("top", "right"),
	"std" => "top"),
array( "name" => "Navigation Built from",
	"desc" => "Use automatically built menus or manually build them using the Appearances->Menu screen",
	"id" => $shortname."_menusource",
	"type" => "select",
	"options" => array("Auto", "Manual"),
	"std" => "Auto"),
array( "name" => "Manual Menu Name",
	"desc" => "If using a manual menu, enter the menu name here",
	"id" => $shortname."_menuname",
	"type" => "text",
	"std" => ""),
array( "name" => "Pages to Hide in Navigation",
	"desc" => "Enter a comma-separated list of ID's that you'd like to exclude from the top navigation. (e.g. 12,23,27,44)",
	"id" => $shortname."_hidepages",
	"type" => "text",
	"std" => ""),
array( "name" => "Google Site Verification",
	"desc" => "Enter the VALUE ONLY of the meta content for Google Site Verification",
	"id" => $shortname."_googlesiteverify",
	"type" => "text",
	"std" => ""),
array( "type" => "close"),
array( "name" => "Design Options",
	"type" => "section"),
array( "type" => "open"),
array( "name" => "Use an image for your header instead of text.",
	"desc" => "",
	"id" => $shortname."_graphicheader",
	"type" => "checkbox",
	"std" => "false"),
array( "name" => "Header Image",
	"desc" => "Paste the URL of the image here. (maximum width: 950 pixels)",
	"id" => $shortname."_headerimage",
	"type" => "text",
	"std" => "https://www4.vanderbilt.edu/asset/i/Sample-header.jpg"),
array( "name" => "Header Background Color",
	"desc" => "What background color should be used behind the image? Use the full hex code (i.e. CCCCCC, FFCC66, 006699, etc.)",
	"id" => $shortname."_headercolor",
	"type" => "text",
	"std" => "CCCCCC"),
array( "name" => "Custom Styles",
	"desc" => "Want to add any custom CSS code? Put in here, and the rest is taken care of. Caution: This overrides other stylesheets. eg: a.button{color:green}",
	"id" => $shortname."_customcss",
	"type" => "textarea",
	"std" => ""),

array( "type" => "close"),
array( "name" => "Right column news and events",
	"type" => "section"),
array( "type" => "open"),
array( "name" => "Include news feed in right column?",
	"desc" => "",
	"id" => $shortname."_newsrightcol",
	"type" => "checkbox",
	"std" => "true"),
array( "name" => "News Feed Title",
	"desc" => "What will appear as the title of the news section (Recent News, by default)",
	"id" => $shortname."_newstitle",
	"type" => "text",
	"std" => "Recent News"),
array( "name" => "External news feed",
	"desc" => "Display another news feed INSTEAD of the POSTS from this website.",
	"id" => $shortname."_othernewsfeed",
	"type" => "text",
	"std" => ""),
array( "name" => "Include calendar events feed in right column?",
	"desc" => "",
	"id" => $shortname."_calendaron",
	"type" => "checkbox",
	"std" => "false"),
array( "name" => "Vanderbilt Calendar Tag to pull through",
	"desc" => "Contact www@vanderbilt.edu if you are not sure what to put here",
	"id" => $shortname."_calendartag",
	"type" => "text",
	"std" => "myvu"),
array( "type" => "close"),
array( "name" => "Social Media Links",
	"type" => "section"),
array( "type" => "open"),
array( "name" => "Show Social Media Share Links",
	"desc" => "Display sharing links in the right column",
	"id" => $shortname."_socialsharelinks",
	"type" => "select",
	"options" => array("yes", "no"),
	"std" => "yes"),
array( "name" => "Display Social Media Links in Footer?",
	"desc" => "Will hide or show the social media footer area.",
	"id" => $shortname."_footersocialshow",
	"type" => "select",
	"options" => array("no", "yes"),
	"std" => "yes"),
array( "name" => "Connect Section Title",
	"desc" => "what should we call the social media icon section",
	"id" => $shortname."_connectwith",
	"type" => "text",
	"std" => "Connect with Vanderbilt"),
array( "name" => "Facebook",
	"desc" => "Full URL to facebook page",
	"id" => $shortname."_facebookurl",
	"type" => "text",
	"std" => ""),
array( "name" => "Twitter",
	"desc" => "Full URL to twitter page",
	"id" => $shortname."_twitterurl",
	"type" => "text",
	"std" => ""),
array( "name" => "YouTube",
	"desc" => "Full URL to youtube page",
	"id" => $shortname."_youtubeurl",
	"type" => "text",
	"std" => ""),
array( "name" => "Google+",
	"desc" => "Full URL to google+ page",
	"id" => $shortname."_googleplus",
	"type" => "text",
	"std" => ""),
array( "name" => "Pinterest",
	"desc" => "Full URL to Pinterest page",
	"id" => $shortname."_pinterest",
	"type" => "text",
	"std" => ""),
array( "name" => "Instagram",
	"desc" => "Full URL to Instagram profile page or hashtag",
	"id" => $shortname."_instagram",
	"type" => "text",
	"std" => ""),
array( "name" => "LinkedIn",
	"desc" => "Full URL to LinkedIn page",
	"id" => $shortname."_linkedin",
	"type" => "text",
	"std" => ""),
array( "name" => "Flickr",
	"desc" => "Full URL to flickr page",
	"id" => $shortname."_flickrurl",
	"type" => "text",
	"std" => ""),
array( "name" => "Flickr User ID",
	"desc" => "Find your flickr user id at http://idgettr.com/",
	"id" => $shortname."_flickrid",
	"type" => "text",
	"std" => ""),
array( "type" => "close"),
array( "name" => "Footer",
	"type" => "section"),
array( "type" => "open"),
array( "name" => "Footer Link List Heading",
	"desc" => "What should the footer link list be titled?",
	"id" => $shortname."_footlinkheader",
	"type" => "text",
	"std" => ""),
array( "name" => "Footer copyright text",
	"desc" => "Enter text used in the right side of the footer. It can be HTML",
	"id" => $shortname."_footer_text",
	"type" => "textarea",
	"std" => ""),
array( "name" => "Google Analytics Code",
	"desc" => "Paste your Google Analytics or other tracking code in this box.",
	"id" => $shortname."_ga_code",
	"type" => "textarea",
	"std" => ""),
array( "type" => "close")
);
// create viewable page for theme options
function mytheme_add_admin() {
global $themename, $shortname, $options;
if ( $_GET['page'] == basename(__FILE__) ) {
	if ( 'save' == $_REQUEST['action'] ) {
		foreach ($options as $value) {
		update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options as $value) {
	if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
	header("Location: admin.php?page=functions.php&saved=true");
die;
}
else if( 'reset' == $_REQUEST['action'] ) {
	foreach ($options as $value) {
		delete_option( $value['id'] ); }
	header("Location: admin.php?page=functions.php&reset=true");
die;
}
}
add_theme_page($themename, $themename, 'edit_theme_options', basename(__FILE__), 'mytheme_admin');
}
function mytheme_add_init() {
$file_dir=get_bloginfo('template_directory');
wp_enqueue_style("functions", $file_dir."/functions/functions.css", false, "1.0", "all");
wp_enqueue_script("rm_script", $file_dir."/functions/rm_script.js", false, "1.0");
}
// admin theme
function mytheme_admin() {
global $themename, $shortname, $options;
$i=0;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>
<div class="wrap rm_wrap">
<h2><?php echo $themename; ?> Settings</h2>
<div class="rm_opts">
<form method="post">
<?php foreach ($options as $value) {
switch ( $value['type'] ) {
case "open":
?>
<?php break;
case "close":
?>
</div>
</div>
<br />
<?php break;
case "title":
?>
<p>To easily use the <?php echo $themename;?> theme, you can use the menu below.</p>
<?php break;
case 'text':
?>
<div class="rm_input rm_text">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
 	<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
 <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 </div>
<?php
break;
case 'textarea':
?>
<div class="rm_input rm_textarea">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
 	<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
 <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 </div>
<?php
break;
case 'select':
?>
<div class="rm_input rm_select">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
		<option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
</select>
	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
</div>
<?php
break;
case "checkbox":
?>
<div class="rm_input rm_checkbox">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 </div>
<?php break;
case "section":
$i++;
?>
<div class="rm_section">
<div class="rm_title"><h3><img src="<?php bloginfo('template_directory')?>/functions/images/trans.gif" class="inactive" alt="""><?php echo $value['name']; ?></h3><span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="Save changes" />
</span><div class="clearfix"></div></div>
<div class="rm_options">
<?php break;
}
}
?>
<input type="hidden" name="action" value="save" />
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
 </div>
<?php
}
add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');
?>