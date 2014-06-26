<?php 
 /*
Template Name: sidebarlist
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
      <div id="mj-left" class="mj-grid24">
        <div class="moduletable mj-strip">
          <?php get_sidebar() ?>
        </div>
      </div>
      <div id="mj-contentarea" class="mj-grid72">
        <header class="entry-header">
          <h1 class="entry-title">
            <?php the_title(); ?>
          </h1>
        </header>
        <div class="entry-content">
          <div class="mj-grid24">
            <aside id="archives" class="widget">
              <h3 class="widget-title">
                <?php _e( 'Archives', 'mjsimple' ); ?>
              </h3>
              <ul>
                <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
              </ul>
            </aside>
          </div>
          <div class="mj-grid24">
            <aside id="archives" class="widget">
              <h3 class="widget-title">
                <?php _e( 'Recent Post', 'mjsimple' ); ?>
              </h3>
              <ul>
                <?php
                                        $recent_posts = wp_get_recent_posts();
                                        foreach( $recent_posts as $recent )
                                        {
                                            echo '<li><a href="'.get_permalink($recent["ID"]).'" title="'.esc_attr($recent["post_title"]).'" >'.$recent["post_title"].'</a> </li> ';
                                        }
                                    ?>
              </ul>
            </aside>
          </div>
          <div class="mj-grid24">
            <aside id="archives" class="widget">
              <h3 class="widget-title">
                <?php _e( 'Recent Categories', 'mjsimple' ); ?>
              </h3>
              <ul>
                <?php wp_list_categories('title_li='); ?>
              </ul>
            </aside>
          </div>
          <div class="mj-grid24">
            <aside id="archives" class="widget">
              <h3 class="widget-title">
                <?php _e( 'Recent Tags', 'mjsimple' ); ?>
              </h3>
              <ul>
                <?php list_tags('title_li='); ?>
              </ul>
            </aside>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
