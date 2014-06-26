<?php
/**
 * The template for displaying all pages.

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
      <?php if( is_page('color-style') || is_page('widget-variations')   )
			{ 
			?>
      <div id="mj-contentarea" class="mj-grid96">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <?php
			}
			else if(is_page('portfolio'))
			{?>
      <div id="mj-contentarea" class="mj-grid96">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <?php	}
			
			else if( is_page('features'))
			{
			?>
      <div class="mj-grid24">
        <?php dynamic_sidebar('Text content sidebar') ?>
      </div>
      <div id="mj-contentarea" class="mj-grid72">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <?php 
			} 
			
			else if( is_page('store'))
			{
			?>
      <div class="mj-grid24 moduletable mj-strip">
        <?php dynamic_sidebar('Ecwid store') ?>
      </div>
      <div id="mj-contentarea" class="mj-grid72">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php //get_template_part( 'content', 'page' ); ?>
        <?php the_content(); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <?php 
			} 
            else if( is_page('about-us') )
			{
			?>
      <div id="mj-contentarea" class="mj-grid72">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <div id="mj-left" class="mj-grid24">
        <div class="moduletable mj-strip">
          <div class="moduletable mj-strip">
            <h3> Menu </h3>
            <?php wp_nav_menu( array('menu' => 'mainmenu' , 'menu_class'=> 'nav1' )); ?>
          </div>
        </div>
      </div>
      <?php 
			} 
			
			 else if(  is_page('services') )
			{
			?>
      <div id="mj-contentarea" class="mj-grid72">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <div id="mj-left" class="mj-grid24">
        <div class="moduletable mj-strip">
          <div class="moduletable mj-simplemenu mj-strip">
            <h3> Menu </h3>
            <?php wp_nav_menu( array('menu' => 'mainmenu' , 'menu_class'=> 'menu' )); ?>
          </div>
        </div>
      </div>
      <?php 
			} 
			else if(is_page('left-content-right-layout'))
			{
			?>
      <div class="mj-grid24">
        <?php dynamic_sidebar('Text content sidebar') ?>
      </div>
      <div id="mj-contentarea" class="mj-grid48">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <div class="mj-grid24">
        <?php dynamic_sidebar('Text content sidebar') ?>
      </div>
      <?php 
			}
			else if( is_page('w-content'))
			{
			?>
      <style type="text/css">
					.entry-header
					{
						display:none;
					}
					.blog img
					{
						width:100%;
					}
				</style>
      <div id="mj-left" class="mj-grid16">
        <div class="moduletable mj-strip">
          <div class="moduletable mj-strip">
            <h3> Menu </h3>
            <?php wp_nav_menu( array('menu' => 'mainmenu' , 'menu_class'=> 'nav1' )); ?>
          </div>
        </div>
      </div>
      <div id="mj-contentarea" class="mj-grid80">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <?php		
			}
			elseif( is_page('column-block'))
			{
			?>
      <div id="mj-contentarea" class="mj-full">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <style type="text/css">
					header
					{
						height:0px;
					}
					.entry-header
					{
						display:none;
					}
				</style>
      <?php
			}
			
			elseif( is_page( 'contact-us') )
			{
			?>
      <div id="mj-contentarea" class="mj-grid72">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <div class="mj-grid24">
        <?php dynamic_sidebar('Contact page sidebar');?>
      </div>
      <?php
			}
			elseif( is_page( 'recent-products') || is_page('feature-products'))
			{
			?>
      <div id="mj-contentarea" class="mj-grid72">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <div id="mj-left" class="mj-grid24">
        <div class="moduletable mj-strip">
          <div class="moduletable mj-strip">
            <h3> Menu </h3>
            <?php wp_nav_menu( array('menu' => 'mainmenu' , 'menu_class'=> 'nav1' )); ?>
          </div>
        </div>
      </div>
      <?php
			}

			else
			{
			?>
      <div id="mj-contentarea" class="mj-grid80">
        <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', 'page' ); ?>
        <?php //comments_template( '', true ); ?>
        <?php endwhile; // end of the loop. ?>
      </div>
      <div id="mj-left" class="mj-grid16">
        <div class="moduletable ">
          <div class="moduletable ">
            <?php //wp_nav_menu( array('menu' => 'mainmenu' , 'menu_class'=> 'nav1' )); ?>
            <?php dynamic_sidebar('Woocommerce page sidebar'); ?>
          </div>
        </div>
      </div>
      <?php
			}
			?>
    </div>
  </div>
  <!-- #content -->
</div>
<!-- #primary -->
<?php get_footer(); ?>
