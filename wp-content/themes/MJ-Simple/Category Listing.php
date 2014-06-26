<?php 
 
 /*
Template Name: Category Listing

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
        <header class="entry-header">
          <h1 class="entry-title">
            <?php the_title(); ?>
          </h1>
        </header>
        <div class="entry-content">
          <?php
                       	$args=array('orderby' => 'name','order' => 'ASC');
                       	$categories=get_categories($args);
                       	foreach($categories as $category)
                       	{ 
                    ?>
          <div class="mj-grid72">
            <?php
                          	echo '<p>Category: <a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf(  "View all posts in %s" , $category->name ) . '" ' . '>' . $category->name.'</a> </p> ';
                           	echo '<p> Description:'. $category->description . '</p>'; 
                     	?>
            <?php    
                           	echo '<p> Post Count: '. $category->count . '</p>'; 
                       	?>
          </div>
          <div class="mj-grid24"> <img src="<?php echo z_taxonomy_image_url($category->term_id); ?>" width="200px"  height="100px" /> </div>
          <div class="line"></div>
          <br />
          <?php 
                        	} 
                    	?>
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
