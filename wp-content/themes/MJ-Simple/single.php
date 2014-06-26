<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Mj-simple
 */

get_header(); ?>

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
      <div class="mj-full">
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="mj-grid96 plist">
          <div class="mj-grid24 mj-leftimage"> <img src="<?php echo home_url(); ?><?php echo get_post_meta($post->ID, 'thumbnail', true) ?>" alt="" /> </div>
          <div class="mj-grid72 mj-rightcontent">
            <h1 class="">
              <?php the_title(); ?>
            </h1>
            <p>
              <?php the_content(); ?>
            </p>
          </div>
          <div class="mj-full socialsingle ">
            <div class="meta">
              <p class="written"><a rel="author" title="" href="">
                <?php the_author_posts_link(); ?>
                </a></p>
              <p class="time"><a href="#">
                <?php the_date(); ?>
                </a></p>
              <p class="tag">
                <?php $tag = get_the_tags(); if (! $tag) { ?>
                <a href="#">No tags here.</a>
                <?php } else { ?>
                <a href="#">
                <?php the_tags(' ', ' | ', ''); ?>
                </a>
                <?php } ?>
              </p>
              <p class="comments"><a title="" href="<?php the_permalink() ?>#comments">
                <?php comments_number( ); ?>
                </a></p>
            </div>
          </div>
        </div>
        <?php comments_template('', true); ?>
      </div>
      <div class="line"></div>
      <div id="nav-below" class="navigation">
        <div class="nav-previous">
          <?php previous_post_link(__('&laquo; %link', 'blogtxt')) ?>
        </div>
        <div class="nav-next">
          <?php next_post_link(__('%link &raquo;', 'blogtxt')) ?>
        </div>
      </div>
    </div>
    <?php endwhile; // end of the loop. ?>
  </div>
</div>
</div>
<!-- #content -->
</div>
<!-- #primary -->
<?php get_footer(); ?>
