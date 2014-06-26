<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package Mj-simple

 */

get_header(); ?>

<div id="mj-slidetitle">
  <div class="mj-subcontainer">
    <div class="mj-grid96">
      <h3>Author</h3>
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
<section id="primary">
  <div id="content" role="main">
    <?php if ( have_posts() ) : ?>
    <?php
					/* Queue the first post, that way we know
					 * what author we're dealing with (if that is the case).
					 *
					 * We reset this later so we can run the loop
					 * properly with a call to rewind_posts().
					 */
					the_post();
				?>
    <div class="mj-subcontainer">
      <div class="mj-full">
        <div class="mj-grid80">
          <?php while ( have_posts() ) : the_post(); ?>
          <div class="mj-grid96 plist">
            <div class="mj-grid24 mj-leftimage"> <img src="<?php echo  home_url(); ?><?php echo get_post_meta($post->ID, 'thumbnail', true) ?>" alt="" /> </div>
            <div class="mj-grid72 mj-rightcontent"> <a href="<?php the_permalink() ?>" rel="bookmark" title=" <?php the_title_attribute(); ?>">
              <h1 class="">
                <?php the_title() ?>
              </h1>
              </a>
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
                <div class="ptread"> <a class="textlink button" href="<?php the_permalink() ?>" title="Read more">Read more</a> </div>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
        </div>
        <div class="mj-grid16">
          <div class="moduletable mj-strip">
            <?php get_sidebar(); ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
  </div>
  <!-- #content -->
</section>
<!-- #primary -->
<?php get_footer(); ?>
