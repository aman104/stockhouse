<?php 
 /*
Template Name: portfolio
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
      <div id="mj-contentarea" class="mj-grid96">
        <h1 class="entry-title">
          <?php the_title(); ?>
        </h1>
        <div class="mj-full mj-dotted">
          <div class="imageRow">
            <?php
			                   // $cat_id= 3;
            			        query_posts("cat_name=Portfolio&post_per_page=100");
                   				 // start the wordpress loop!
								if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="mj-grid32 portfoli">
              <h3><a href="<?php the_permalink();?>">
                <?php the_title(); ?>
                </a></h3>
              <div class="single"> <a href="<?php the_permalink(); ?>"><img src="<?php echo home_url();?><?php echo get_post_meta($post->ID, 'thumbnail', true) ?>" alt="" /></a>
                <p class="portfolioparag"><?php echo excerpt(30); ?></p>
                <p><a class="button pt" href="<?php the_permalink(); ?>">Learn more</a></p>
              </div>
            </div>
            <?php endwhile; endif; // done our wordpress loop. Will start again for each category ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
