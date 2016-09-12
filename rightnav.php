<?php
/**
 * @package WordPress
 * @subpackage vanderbilt brand - RIGHT NAVIGATION CHOICE
 */

// show initial nav on front page

	if (is_front_page()) {
	?>
	<h4>Explore</h4>

	<?php
    $menutype = get_option('vubrand_menusource');
    $whichmenu = get_option('vubrand_menuname');
    if($menutype=='Manual') {
      wp_nav_menu(array('container'=>'false', 'menu'=>$whichmenu, 'sort_column' => 'menu_order'));
    } else {
      echo "<ul>";
      wp_list_pages('title_li=&exclude='.$hidethese.'&depth=1');
      echo "</ul>";
    }
  ?>

<?php } elseif (is_page()) // show child pages on subpages
{ include(TEMPLATEPATH . '/rightchildpages.php'); } ?>
