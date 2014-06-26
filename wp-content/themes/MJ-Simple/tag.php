<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package Mj-simple
 */

get_header(); ?>

<div id="mj-slidetitle">
  <div class="mj-subcontainer">
    <div class="mj-grid96">
      <h3>
        <?php single_tag_title(); ?>
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
<section id="primary">
  <div id="content" role="main">
    <?php if ( have_posts() ) : ?>
    <div class="mj-subcontainer">
      <div class="mj-full">
        <div class="mj-grid80">
          <div class="mj-grid96">
            <header class="page-header">
              <h3 class="page-title">
                <?php
					printf( __( 'Tag Archives: %s', 'mjsimple' ), '<span>' . single_tag_title( '', false ) . '</span>' );
				?>
              </h3>
              <?php
					$tag_description = tag_description();
					if ( ! empty( $tag_description ) )
						echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
				?>
            </header>
            <?php mjsimple_content_nav( 'nav-above' ); ?>
            <?php /* Start the Loop */ ?>
          </div>
          <?php while ( have_posts() ) : the_post(); ?>
          <div class="mj-grid96 plist">
            <div class="mj-grid24 mj-leftimage"> <img src="<?php echo home_url(); ?><?php echo get_post_meta($post->ID, 'thumbnail', true) ?>" alt="" /> </div>
            <div class="mj-grid72 mj-rightcontent">
              <h1 class=""><a href="<?php the_permalink() ?>" rel="bookmark" title=" <?php the_title_attribute(); ?>">
                <?php the_title(); ?>
                </a></h1>
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
          <?php //comments_template(); ?>
          <!--</div>-->
          <?php endwhile; ?>
          <?php endif; ?>
        </div>
        <div class="mj-grid16">
          <div class="moduletable mj-strip">
            <?php get_sidebar(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- #content -->
</section>
<!-- #primary -->
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
