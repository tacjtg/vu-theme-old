<?php
/**
 * @package WordPress
 * @subpackage vanderbilt brand - CHILD PAGES ON RIGHT WITH TOP NAV
 */
$hidethese = get_option('vubrand_hidepages');
 
  if($post->post_parent) {
  $children = wp_list_pages("title_li=&depth=1&sort_column=menu_order&child_of=".$post->post_parent."&echo=0&exclude=".$hidethese);
  $titlenamer = get_the_title($post->post_parent);
  }

  else {
  $children = wp_list_pages("title_li=&depth=1&sort_column=menu_order&child_of=".$post->ID."&echo=0&exclude=".$hidethese);
  $titlenamer = get_the_title($post->ID);
  }
  if ($children) { ?>

  <h4> <? echo $titlenamer ?> </h4>
  <ul>
  <?php echo $children; ?>
  </ul>

<?php } ?>