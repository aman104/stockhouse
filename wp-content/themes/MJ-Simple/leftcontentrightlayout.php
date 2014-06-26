<?php
 /*
Template Name: LEFT + Content + Right Layout
*/
 ?>
<?php
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
    <div class="mj-subcontainer">
      <div id="mj-right" class="mj-grid24">
        <div class="moduletable mj-strip">
          <div id="secondary" class="widget-area" role="complementary">
            <?php dynamic_sidebar('Layoutpage left sidebar') ?>
          </div>
        </div>
      </div>
      <div id="" class="mj-grid48">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <!-- .entry-content -->
      <div id="mj-right" class="mj-grid24">
        <div class="moduletable mj-strip">
          <div id="secondary" class="widget-area" role="complementary">
            <?php dynamic_sidebar('Layoutpage right sidebar') ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<?php get_footer(); ?>
