<?php 
 /*
Template Name: blogroll

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
      <div id="mj-left" class="mj-grid16">
        <div class="moduletable mj-strip">
          <?php get_sidebar() ?>
        </div>
      </div>
      <div id="mj-contentarea" class="mj-grid80">
        <header class="entry-header">
          <h1 class="entry-title">
            <?php the_title(); ?>
          </h1>
        </header>
        <div class="entry-content">
          <div class="mj-full">
            <?php
                            $args=array('orderby' => 'name','order' => 'ASC');
                            $categories=get_categories($args);
                            foreach($categories as $category)
                            { 
                        ?>
            <?php
                            echo '<p><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf(  "View all posts in %s" , $category->name ) . '" ' . '>' . $category->name.'&nbsp;&nbsp;('. $category->count . ')</a> </p> ';
                        ?>
            <?php 
                            } 
                        ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
