<?php
/**
 * @package WordPress
 * @subpackage vanderbilt brand
 */

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<style>
<!--
.avatar { float: left; margin: 10px; padding: 3px; background: #ECECEC; border: 1px solid #DDD; } 
div.bubble { 	width: auto; 	margin-bottom: 24px; } 
div.bubble a:link, div.bubble a:visited { color: #369; text-decoration:  none; border-bottom: 1px dotted #369; }
div.bubble a:hover { color: #969; border-bottomx: 1px solid #969; }
div.bubble blockquote { margin: 0px; 	padding: 0px 0px 5px 0px; min-height: 75px; 
	background: #FFF url(<?php bloginfo('stylesheet_directory'); ?>/functions/images/comment-tip.jpg) no-repeat bottom left; } 
div.authorcomment blockquote { background: #CCC url(<?php bloginfo('stylesheet_directory'); ?>/functions/images/comment-tip-grey.jpg) no-repeat bottom left; }
div.bubble blockquote p { 	margin: 10px;  	padding: 10px; } 
div.bubble cite { 	color: #666; position: relative; 	margin: 0px; 	padding: 0px 0px 0px 15px; 	top: 6px; font-style: normal;}
-->
</style>

<div class="box"><!-- start comments box -->

<?php if ( have_comments() ) : ?>
<hr class="space" /> 

	<h3 id="comments"><?php comments_number('No Comments Yet', 'One Comment', '% Comments' );?> on &#8220;<?php the_title(); ?>&#8221;</h3>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>	
	
	<?php foreach ($comments as $comment) : ?>

<div class="bubble" id="comment-<?php comment_ID(); ?>">

	<blockquote>
			<a href="#comment-<?php comment_ID() ?>" title=""><?php echo get_avatar( $comment, 40); ?></a>
			
			<?php if ($comment->comment_approved == '0') : ?>
				<p><?php _e('Your comment is awaiting moderation.'); ?></p>
	 		<?php endif; ?>
	
			<?php comment_text() ?>
	</blockquote>
	
	<cite><strong><?php comment_author_link() ?></strong> on <?php comment_date('F jS, Y') ?> <?php _e('at');?> <?php comment_time() ?> <?php edit_comment_link('Edit Comment',' | ',''); ?></cite>
		
</div>

<?php endforeach; /* end for each comment */ ?>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
	
	
<?php endif; ?>

<hr class="space" /> 

<?php if ( comments_open() ) : ?>

<div id="respond">

<h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3>

<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( is_user_logged_in() ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="author">Name <?php if ($req) echo "(required)"; ?></label></p>

<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="email">Mail (will not be published) <?php if ($req) echo "(required)"; ?></label></p>

<p><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
<label for="url">Website</label></p>

<?php endif; ?>

<p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>


</div><!-- end comment box -->