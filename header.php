<?php
include('/var/www/my.vanderbilt.edu/offline/sessions.php');
session_start();
// is this site behind vunetid
$vunetidprotect = get_option('vubrand_vunetidprotect');
if ($vunetidprotect=='yes') {
  // if yes -- then use the vunetid header that checks login
  include(TEMPLATEPATH . '/header-vunetid.php');
} else {
  // if not - then use the regular header
  include(TEMPLATEPATH . '/header-open.php');
}



/*
	if (have_posts()) : while (have_posts()) : the_post();
		if (has_tag('vunetid')) { 	include(TEMPLATEPATH . '/header-vunetid.php');  }
		// if not - then use the regular header
		else { include(TEMPLATEPATH . '/header-open.php'); }
	endwhile; endif;

*/


?>