<?php
/* 
Template Name: Redirect Page
*/

$redir_url = get_post_meta($post->ID, 'redirect', true);
wp_redirect($redir_url);
exit();
?>