<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Mj-simple
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta name="description" content="<?php echo ot_get_option("meta_description","Mj simple is Wordpress responsive theme with woocommerce."); ?>" />
<meta name="keywords" content="<?php echo ot_get_option("meta_keywords","Mj Simple"); ?>" />	
<meta name="author" content="Mojoomla" />
<link rel="shortcut icon" href="<?php echo ot_get_option("custom_favicon",get_template_directory_uri().'/images/favicon.ico'); ?>" />

<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged , $post;
	wp_title( '|', true, 'right' );
	// Add the blog name.
	bloginfo( 'name' );
	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'mjsimple' ), max( $paged, $page ) );
	?></title>


<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script type="text/javascript" src="//use.typekit.net/ptg4lyn.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	 global	$wptuts_option;
	wp_head();
?> 
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33524035-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
<body <?php body_class(); ?>> 
	<div class="hfeed">
		<div id="mj-container">
				<div id="mj-topbar">
    			<div class="mj-subcontainer">
    			<div class="mj-grid16 mj_call">
    			<p><?php _e( 'Call us:', 'woocommerce' ); ?> <?php echo ot_get_option("call_us","99999999"); ?></p>
        		</div>
				<div class="mj_headmenum mj-grid24">
				<div class="menu">
				<?php wp_nav_menu( array( 'theme_location' => 'top'  , 'menu_class'=> 'nav' )); ?>
                <?php     	global $woocommerce; 	?>
			   </div>
  				<div class="mj-search ">
				<div class="mainsearch">
				<div class="leftsearch">
				<div class="search mj-search mj-rspace">
    			<a href="#" class="show_hide searchhide">Search</a>
				<div class="slidingDiv1" style="display: none; ">
				<?php get_search_form(); ?>
				</div>
    			</div>
				</div>
				</div>
				</div>
    </div>
    

           
		</div>
    	</div>
			<div id="mj-header">
    			<div class="mj-subcontainer">
    				<div id="mj-logo">
        				<a href="<?php  echo home_url(); ?>" title="<?php bloginfo('description'); ?>"><img class="png" src="<?php echo ot_get_option("custom_logo",get_template_directory_uri().'/images/logo.png'); ?> " alt="<?php bloginfo('name'); ?>" /></a>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
							<h5><?php bloginfo( 'name' ); ?></h5></a><span class="tagline"><?php echo ot_get_option("tag_line","Responsive wordpress template"); ?></span>
        			</div>
       				<div id="mj-righttop">
    			 <!-- Main Nav -->
  				<div class="jsn-mainnav navbar">
    				<div class="jsn-mainnav-inner navbar-inner">
   						<div class="mainnav-toggle clearfix">
          					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"  onclick="displaybutton()"> 
          						<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
        				</div>
        				<div id="jsn-pos-mainnav1" class="abc">
							<?php wp_nav_menu( array( 'theme_location' => 'main' , 'menu_class'=> 'nav'  )); ?>
                            
								<div class="clearbreak"></div>
         				</div>
      			</div>
 			</div>
		</div>
     </div>
 </div>

</div>
</div>
	<div id="main">	<div align="center"><?php if ( function_exists( 'soliloquy_slider' ) ) soliloquy_slider( '92' ); ?></div>