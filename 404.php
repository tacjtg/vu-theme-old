<?php
/**
 * @package WordPress
 * @subpackage vanderbilt_brand
 */

get_header();
?>

<?php if (function_exists('vu_breadcrumbs')) vu_breadcrumbs(); ?>

<h1>Hmmm... We can't find that page.</h1>

<div class="secmain">

<h4>Here are a few suggestions:</h4>

  <ul>
    <li>Check the address for a typo.</li>
    <li>Check the navigation links above or to the right.</li>
    <li><a href="<?php bloginfo('url'); ?>/sitemap/">View the sitemap.</a></li>
    <li><a href="javascript:history.back()">Returning to the previous page.</a></li>
    <li>Searching our site:<br />
    <?php // if Wordpress Search
if ((get_option('vubrand_searchmethod') == 'Wordpress Search')) { ?>
	<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/" class="round">
   <input type="text" value="SEARCH" onfocus="clearDefault(this)" name="s" id="s" class="searchfield" />
   <button class="btn" title="Submit Search">GO</button>
	</form>
	
<?php } // if GSA 
elseif ((get_option('vubrand_searchmethod') == 'Google Search Appliance') ) { ?>		
	<form method="get" action="http://searchvu.vanderbilt.edu/search" class="round">
	<input class="searchbox" name="q" maxlength="256" value="SEARCH" type="text" onfocus="clearDefault(this)" tabindex="1" accesskey="4"/>
	<input type="hidden" name="site" value="default_collection" />
	<input type="hidden" name="client" value="default_frontend" />
	<input type="hidden" name="proxystylesheet" value="default_frontend" />
	<input type="hidden" name="output" value="xml_no_dtd" />
	<button class="btn" title="Submit Search">GO</button>	
	</form>
<?php } ?>	</li>
  </ul>



<p>&nbsp;</p>
<p>The vanderbilt.edu site and its related web pages are maintained by many different departments and organizations at Vanderbilt University. Every effort is made to keep this information updated and accurate. If you would like to assist us in resolving this error, we invite you to contact the department responsible for the page you visited.</p>



</div><!-- /secmain -->
</div><!-- /seccontent-->



<?php get_sidebar(); ?>

<?php get_footer(); ?>