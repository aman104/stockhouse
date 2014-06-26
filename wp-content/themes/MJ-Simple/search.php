<?php
/**
 * The template for displaying Search Results pages.
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
<section id="primary">
  <div id="content" role="main">
    <div class="mj-subcontainer searchpage">
      <?php if ( have_posts() ) : ?>
      <header class="page-header">
        <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'mjsimple' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
      </header>
      <?php mjsimple_content_nav( 'nav-above' ); ?>
      <?php /* Start the Loop */ ?>
      <?php while ( have_posts() ) : the_post(); ?>
      <?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>
      <?php endwhile; ?>
      <?php mjsimple_content_nav( 'nav-below' ); ?>
      <?php else : ?>
      <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
          <h1 class="entry-title ">
            <?php _e( 'Nothing Found', 'mjsimple' ); ?>
          </h1>
        </header>
        <!-- .entry-header -->
        <div class="entry-content">
          <p>
            <?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'mjsimple' ); ?>
          </p>
          <?php get_search_form(); ?>
        </div>
        <!-- .entry-content -->
      </article>
      <!-- #post-0 -->
      <?php endif; ?>
    </div>
  </div>
  <!-- #content -->
</section>
<!-- #primary -->
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
