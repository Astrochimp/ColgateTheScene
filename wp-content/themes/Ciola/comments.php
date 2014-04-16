<?php /* Comments page */

  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if ( post_password_required() ) { ?>
  	<div class="alert help">
    	<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", "cubell"); ?></p>
  	</div>
  <?php
    return;
  }
?>

<?php if ( have_comments() ) : ?>

	<h3 id="comments" class="cb-module-title"><?php comments_number(__("<span>No</span> Responses", "cubell"), __("<span>One</span> Response", "cubell"), _n('<span>%</span> Response', '<span>%</span> Responses', get_comments_number(),'cubell') );?></h3>

	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
	 	</ul>
	</nav>
	
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=cb_comments'); ?>
	</ol>
	
	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
		</ul>
	</nav>
  
	<?php else : // this is displayed if there are no comments so far ?>
	
	<?php if ( comments_open() ) : ?>
    
    	<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
	
		<!-- If comments are closed. -->

	<?php endif; ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>


<?php comment_form(
					array(
					'cancel_reply_link' => __( 'Cancel reply', 'cubell' ),
					'label_submit' => __( 'Submit', 'cubell' ),
					'comment_notes_after' => ''
					)
	); ?>
<?php endif; // if you delete this the sky will fall on your head ?>
