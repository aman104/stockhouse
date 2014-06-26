<?php 
 
 /*
Template Name: commentslist
 * @package Mj-simple
*/


?>
<?php get_header(); ?>

<div id="mj-slidetitle">
  <div class="mj-subcontainer">
    <div class="mj-grid96">
      <h3>
        <?php the_title(); ?>
      </h3>
    </div>
  </div>
</div>
<div id="mj-featured1">
  <div class="mj-subcontainer">
    <div class="mj-grid96 breadcrumb">
      <div class="breadcrumbs mj-grid96 breadcrumb">
        <?php mjsimple_breadcrumb(); ?>
      </div>
    </div>
  </div>
</div>
<div id="primary">
  <div id="content" role="main">
    <div class="mj-subcontainer">
      <div id="mj-contentarea" class="mj-grid80">
        <?php $comments = get_comments('status=approve&number=3'); ?>
        <header class="entry-header">
          <h1 class="entry-title">
            <?php the_title(); ?>
          </h1>
        </header>
        <div class="entry-content">
          <?php $comments = get_comments('status=approve&number=5'); ?>
          <ul class="recomm">
            <?php foreach ($comments as $comment) { ?>
            <li class="recomm-wrapper comment-author vcard">
              <?php
        $title = get_the_title($comment->comment_post_ID);
        echo get_avatar( $comment, '68' );
        echo '<span class="recommauth">' . ($comment->comment_author) . '</span>';
        ?>
              said: <br />
              "
              <?php
        echo wp_html_excerpt( $comment->comment_content, 72 ); ?>
              .."
              on <a href="<?php echo get_permalink($comment->comment_post_ID); ?>"
           rel="external nofollow" title="<?php echo $title; ?>"> <?php echo $title; ?> </a> <?php echo  '<span class="recommauth">' .  $comment->comment_date .'</span>'; ?> </li>
            <?php }  ?>
          </ul>
        </div>
      </div>
      <div id="mj-left" class="mj-grid16">
        <div class="moduletable mj-strip">
          <?php get_sidebar() ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
