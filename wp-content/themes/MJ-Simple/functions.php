<?php
ob_start();

/**
 * Mj-simple functions and definitions
 *

 * @package Mj-simple
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 584;

/**
 * Tell WordPress to run mjsimple_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'mjsimple_setup' );  

if ( ! function_exists( 'mjsimple_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override mjsimple_setup() in a child theme, add your own mjsimple_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, custom headers
 * 	and backgrounds, and post formats.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since mj simple 1.0
 */
 

function mjsimple_setup() {

	/* Make mj simple available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on mj simple, use a find and replace
	 * to change 'mjsimple' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'mjsimple', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up our theme options page and related code.
	//require( get_template_directory() . '/inc/theme-options.php' );

	// Grab mj simple's Ephemera widget.
	require( get_template_directory() . '/inc/widgets.php' );
	


	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	
register_nav_menus( array(
	'top' => __( 'Top Menu', 'mjsimple' ),
		'main' => __( 'Main Menu', 'mjsimple' ),
		'footer' => __( 'Footer Menu', 'mjsimple' ),
	) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

//	$theme_options = mjsimple_get_theme_options();
//	if ( 'dark' == $theme_options['color_scheme'] )
//		$default_background_color = '1d1d1d';
//	else
//		$default_background_color = 'f1f1f1';

	// Add support for custom backgrounds.
//	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		// This is dependent on our current color scheme.
//		'default-color' => $default_background_color,
//	) );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );
require_once (get_template_directory() . '/includes/shortcodes/zilla-shortcodes.php');
	// Add support for custom headers.
	$custom_header_support = array(
		// The default header text color.
		'default-text-color' => '000',
		// The height and width of our custom header.
		'width' => apply_filters( 'mjsimple_header_image_width', 1000 ),
		'height' => apply_filters( 'mjsimple_header_image_height', 288 ),
		// Support flexible heights.
		'flex-height' => true,
		// Random image rotation by default.
		'random-default' => true,
		// Callback for styling the header.
		'wp-head-callback' => 'mjsimple_header_style',
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'mjsimple_admin_header_style',
		// Callback used to display the header preview in the admin.
		'admin-preview-callback' => 'mjsimple_admin_header_image',
	);
	
	add_theme_support( 'custom-header', $custom_header_support );

	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', $custom_header_support['default-text-color'] );
		define( 'HEADER_IMAGE', '' );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
//		add_custom_image_header( $custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback'] );
		add_theme_support( 'custom-header',$custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback']);
	//	add_custom_background();
		 add_theme_support( 'custom-background', $args );
	}

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	// Add mj simple's custom image sizes.
	// Used for large feature (header) images.
	add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
	// Used for featured posts if a large-feature doesn't exist.
	add_image_size( 'small-feature', 500, 300 );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'wheel' => array(
			'url' => '%s/images/headers/wheel.jpg',
			'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Wheel', 'mjsimple' )
		),
		'shore' => array(
			'url' => '%s/images/headers/shore.jpg',
			'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Shore', 'mjsimple' )
		),
		'trolley' => array(
			'url' => '%s/images/headers/trolley.jpg',
			'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Trolley', 'mjsimple' )
		),
		'pine-cone' => array(
			'url' => '%s/images/headers/pine-cone.jpg',
			'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Pine Cone', 'mjsimple' )
		),
		'chessboard' => array(
			'url' => '%s/images/headers/chessboard.jpg',
			'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Chessboard', 'mjsimple' )
		),
		'lanterns' => array(
			'url' => '%s/images/headers/lanterns.jpg',
			'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Lanterns', 'mjsimple' )
		),
		'willow' => array(
			'url' => '%s/images/headers/willow.jpg',
			'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Willow', 'mjsimple' )
		),
		'hanoi' => array(
			'url' => '%s/images/headers/hanoi.jpg',
			'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Hanoi Plant', 'mjsimple' )
		)
	) );
}
endif; // mjsimple_setup

/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */

/**
 * Theme Options
 */
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-options.php' );

if ( ! function_exists( 'mjsimple_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since mj simple 1.0
 */
function mjsimple_header_style() {
	$text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( $text_color == HEADER_TEXTCOLOR )
		return;
		
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $text_color ) :
	?>
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo $text_color; ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // mjsimple_header_style





if ( ! function_exists( 'mjsimple_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in mjsimple_setup().
 *
 * @since mj simple 1.0
 */
function mjsimple_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		font-size: 14px;
		line-height: 23px;
		padding: 0 0 3em;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 1000px;
		height: auto;
		width: 100%;
	}
	</style>
<?php
}
endif; // mjsimple_admin_header_style

if ( ! function_exists( 'mjsimple_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in mjsimple_setup().
 *
 * @since mj simple 1.0
 */
function mjsimple_admin_header_image() { ?>
	<div id="headimg">
		<?php
		$color = get_header_textcolor();
		$image = get_header_image();
		if ( $color && $color != 'blank' )
			$style = ' style="color:#' . $color . '"';
		else
			$style = ' style="display:none"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( $image ) : ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // mjsimple_admin_header_image

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function mjsimple_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'mjsimple_excerpt_length' );




/**
 * Returns a "Continue Reading" link for excerpts
 */
function mjsimple_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'mjsimple' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and mjsimple_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function mjsimple_auto_excerpt_more( $more ) {
	return ' &hellip;' . mjsimple_continue_reading_link();
}
add_filter( 'excerpt_more', 'mjsimple_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function mjsimple_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= mjsimple_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'mjsimple_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function mjsimple_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'mjsimple_page_menu_args' );



/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since mj simple 1.0
 */
function mjsimple_widgets_init() {

	register_widget( 'mj_simple_Ephemera_Widget' );

	register_sidebar( array(
		'name' => __( 'Ecwid store', 'mjsimple' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Content page', 'mjsimple' ),
		'id' => 'sidebar-2',
		'description' => __( 'It show of in content menu page', 'mjsimple' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Latest Products footer', 'mjsimple' ),
		'id' => 'sidebar-4',
		'description' => __( 'its show in footer first area', 'mjsimple' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );


       register_sidebar( array(
		'name' => __( 'Text content sidebar', 'mjsimple' ),
		'id' => 'sidebar-6',
		'description' => __( 'Text side bar that shows in feature and some pages', 'mjsimple' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

   register_sidebar( array(
		'name' => __( 'Contact page sidebar', 'mjsimple' ),
		'id' => 'sidebar-7',
		'description' => __( 'contact us page sidebar', 'mjsimple' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
   register_sidebar( array(
		'name' => __( 'Home left sidebar', 'mjsimple' ),
		'id' => 'sidebar-8',
		'description' => __( 'Home page left sidebar', 'mjsimple' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	   register_sidebar( array(
		'name' => __( 'Home right sidebar', 'mjsimple' ),
		'id' => 'sidebar-9',
		'description' => __( 'Home page right sidebar', 'mjsimple' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	
	
	register_sidebar( array(
		'name' => __( 'Woocommerce page sidebar', 'mjsimple' ),
		'id' => 'sidebar-11',
		'description' => __( 'Its show in woocommerce pages', 'mjsimple' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
		register_sidebar( array(
		'name' => __( 'Layoutpage left sidebar', 'mjsimple' ),
		'id' => 'sidebar-12',
		'description' => __( 'use for layout pages left sidebar', 'mjsimple' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
		register_sidebar( array(
		'name' => __( 'Layoutpage right sidebar', 'mjsimple' ),
		'id' => 'sidebar-13',
		'description' => __( 'use for layout pages right sidebar', 'mjsimple' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	
}
add_action( 'widgets_init', 'mjsimple_widgets_init' );

function mytheme_fonts() {
   $protocol = is_ssl() ? 'https' : 'http';
   wp_enqueue_style( 'mytheme-opensans', "$protocol://fonts.googleapis.com/css?family=Open+Sans" );
   wp_enqueue_style( 'mytheme-oswald', "$protocol://fonts.googleapis.com/css?family=Oswald" );
   wp_enqueue_style( 'mytheme-ptsans', "$protocol://fonts.googleapis.com/css?family=PT+Sans" );
}
add_action( 'wp_enqueue_scripts', 'mytheme_fonts' ); 


 function theme_styles()  
{
  $data=  ot_get_option("sample_text","cyan"); 
  wp_enqueue_style( 'themecolor',get_template_directory_uri() . '/ColorCss/'.$data.'.css',array(),'','all' );
  wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_style( 'slideshow',get_template_directory_uri() . '/css/slideshow.css',array(),'','all' );
  wp_enqueue_style( 'mj-Ecwid',get_template_directory_uri() . '/css/mj-Ecwid.css',array(),'','all' );
  wp_enqueue_style( 'tab',get_template_directory_uri() . '/css/tab.css',array(),'','all' );
  wp_enqueue_style( 'accordian',get_template_directory_uri() . '/css/accordian.css',array(),'','all' );
  wp_enqueue_style( 'mj-general',get_template_directory_uri() . '/css/mj-general.css',array(),'','all' );
  wp_enqueue_style( 'mj-template',get_template_directory_uri() . '/css/mj-template.css',array(),'','all' );
  wp_enqueue_style( 'mj-layout',get_template_directory_uri() . '/css/mj-layout.css',array(),'','all' );
  wp_enqueue_style( 'mj-tab',get_template_directory_uri() . '/css/mj-tab.css',array(),'','all' );
  wp_enqueue_style( 'mj-mobile',get_template_directory_uri() . '/css/mj-mobile.css',array(),'','all' );
  wp_enqueue_style( 'mjmenu',get_template_directory_uri() . '/css/mjmenu.css',array(),'','all' );
  wp_enqueue_style( 'slide',get_template_directory_uri() . '/css/slide.css',array(),'','all' );
  wp_enqueue_style( 'button',get_template_directory_uri() . '/css/button.css',array(),'','all' );
  //home tab  
  wp_enqueue_style( 'hometabs',get_template_directory_uri() . '/css/hometabs.css',array(),'','all' );
}
add_action('wp_enqueue_scripts', 'theme_styles');


 function theme_js()  
 {
   wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.04022.js', false, '', false );
   wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', false, '', false );
   wp_enqueue_script( 'mj', get_template_directory_uri() . '/js/mj.js', false, '', false );
   wp_enqueue_script( 'organictabs', get_template_directory_uri() . '/js/organictabs.jquery.js', true, '', true );
   wp_enqueue_script( 'jquery1.7', get_template_directory_uri() . '/js/jquery-1.7.2.min.js', false, '', true );
   wp_enqueue_script( 'jquery-ui', get_template_directory_uri() . '/js/jquery-ui-1.8.20.custom.min.js', false, '', true );
   wp_enqueue_script( 'modernizr.cust', get_template_directory_uri() . '/js/modernizr.custom.29473.js', false, '', true );
   wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', false, '', true );
  if(is_page('FAQ') || is_page('FAQ Page') || is_page('Typography') )
  {
 	  wp_enqueue_script( 'vallenato', get_template_directory_uri() . '/js/vallenato.js', false, '', true );
  }
   wp_enqueue_script( 'css_browser_selector', get_template_directory_uri() . '/js/css_browser_selector.js', false, '', true );
    
 }
add_action('wp_enqueue_scripts', 'theme_js');




if ( ! function_exists( 'mjsimple_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function mjsimple_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'mjsimple' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'mjsimple' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'mjsimple' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // mjsimple_content_nav

/**
 * Return the URL for the first link found in the post content.
 *
 * @since mj simple 1.0
 * @return string|bool URL or false when no link is present.
 */
function mjsimple_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function mjsimple_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

if ( ! function_exists( 'mjsimple_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own mjsimple_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since mj simple 1.0
 */
function mjsimple_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'mjsimple' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'mjsimple' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'mjsimple' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'mjsimple' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'mjsimple' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'mjsimple' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'mjsimple' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for mjsimple_comment()

if ( ! function_exists( 'mjsimple_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own mjsimple_posted_on to override in a child theme
 *
 * @since mj simple 1.0
 */
function mjsimple_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'mjsimple' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'mjsimple' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since mj simple 1.0
 */
function mjsimple_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'mjsimple_body_classes' );

?>


<?php // Add Breadcrumb Navigation
function write_breadcrumb() {
	$pid = $post->ID;
	$trail = '<a href="/">'. __('Home', 'textdomain') .'</a>';

	if (is_front_page()) {
        // do nothing
	}
	elseif (is_page()) {
		$bcarray = array();
		$pdata = get_post($pid);
		$bcarray[] = ' &raquo; '.$pdata->post_title."\n";
	while ($pdata->post_parent) {
		$pdata = get_post($pdata->post_parent);
		$bcarray[] = ' &raquo; <a href="'.get_permalink($pdata->ID).'">'.$pdata->post_title.'</a>';
	}
	$bcarray = array_reverse($bcarray);
		foreach ($bcarray AS $listitem) {
			$trail .= $listitem;
		}
	}
	elseif (is_single()) {
		$pdata = get_the_category($pid);
		$adata = get_post($pid);
		if(!empty($pdata)){
			$data = get_category_parents($pdata[0]->cat_ID, TRUE, ' &raquo; ');
			$trail .= ' &raquo; '.substr($data,0,-8);
		}
		$trail.= ' &raquo; '.$adata->post_title."\n";
	}
   	elseif (is_category()) {
		$pdata = get_the_category($pid);
		$data = get_category_parents($pdata[0]->cat_ID, TRUE, ' &raquo; ');
		if(!empty($pdata)){
			$trail .= ' &raquo; '.substr($data,0,-8);
		}
   }
	$trail.="";
	return $trail;
} ?>

<?php 
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}
?>
<?php

/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */

if ( !function_exists( 'ot_get_option' ) ) {
function ot_get_option($name, $default = false) {
	
	$optionsframework_settings = get_option('Mj-simple settings');
	
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	if ( get_option($option_name) ) {
		$options = get_option($option_name);
	}
		
	if ( isset($options[$name]) ) {
		return $options[$name];
	} else {
		return $default;
	}
}
}
?>

<?php 
function mjsimple_breadcrumb() {
    global $post;
    echo '<div class="breadcrumb">';
	if (!is_front_page()) {
		echo '<a class="pathway" href="';
		echo home_url();
		echo '"> ';
		echo 'Home';
		echo "</a> ";
		if ( is_category() || is_single() ) {
			the_category(', ');
			if ( is_single() ) {
				echo " ";
					echo '<a class="dem" href="';echo '"> ';echo 'demo';	echo "</a> ";
				the_title();
			}
		} elseif ( is_page() && $post->post_parent ) {
			$home = get_page_by_title('home');
			for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
				if (($home->ID) != ($post->ancestors[$i])) {
					echo '<a class="pathway" href="';
					echo get_permalink($post->ancestors[$i]); 
					echo '">';
					echo get_the_title($post->ancestors[$i]);
					echo "</a>";
				}
			}
			echo the_title();
		} elseif (is_page()) {
			echo the_title();
			
		} 
		elseif (is_author()) {
echo "Author";
			
		} 
		elseif (is_tag()) {
			echo single_tag_title();
			}
			elseif (is_archive()) {
			  if ( is_day() ) : ?>
							<?php printf( __( 'Daily Archives: %s', 'mjsimple' ), '<span>' . get_the_date() . '</span>' ); ?>
						<?php elseif ( is_month() ) : ?>
							<?php printf( __( ' %s', 'mjsimple' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'mjsimple' ) ) . '</span>' ); ?>
						<?php elseif ( is_year() ) : ?>
							<?php printf( __( 'Yearly Archives: %s', 'mjsimple' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'mjsimple' ) ) . '</span>' ); ?>
						<?php else : ?>
							<?php _e( 'Blog Archives', 'mjsimple' ); ?>
						<?php endif; 
			}
		
		elseif (is_404()) {
			echo "404";
		}
	} else {
		bloginfo('name');
	}
	echo '</div>';
}

function breadcrumb_css() {
	echo "
	<style type='text/css'>
		.breadcrumb {
			
			font-size: 13px;
		}
	</style>
	";
}
add_action( 'wp_head', 'breadcrumb_css' );

?>

<?php add_action( 'wp_enqueue_scripts', 'frontend_scripts_include_lightbox' );
 
function frontend_scripts_include_lightbox() {
  global $woocommerce;
 
  $suffix      = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
  $lightbox_en = get_option( 'woocommerce_enable_lightbox' ) == 'yes' ? true : false;
 
  if ( $lightbox_en ) {
    wp_enqueue_script( 'prettyPhoto', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), '3.1.5', true );
    wp_enqueue_script( 'prettyPhoto-init', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto.init' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
    wp_enqueue_style( 'woocommerce_prettyPhoto_css', $woocommerce->plugin_url() . '/assets/css/prettyPhoto.css' );
  }
}
?>

<?php add_filter('woocommerce_get_price_html','members_only_price');
function members_only_price($price){
if( is_user_logged_in() ) {
if(!current_user_can('niezweryfikowany')){
    return $price;
} }
else return '<div style="font-size:10px"><a href="' .get_permalink(woocommerce_get_page_id('myaccount')). '">Zaloguj się<!--</a> lub <a href="'.site_url('/wp-login.php?action=register&redirect_to=' . get_permalink()).'">Zarejestruj</a>--!> aby zobaczyć cenę!</div>';
}
?>

<?php add_action( 'woocommerce_email_after_order_table', 'add_payment_method_to_admin_new_order', 15, 2 );
 
function add_payment_method_to_admin_new_order( $order, $is_admin_email ) {
  if ( $is_admin_email ) {
    echo '<p><strong>Payment Method:</strong> ' . $order->payment_method_title . '</p>';
  }
} ?>

<?php add_filter( 'woocommerce_currencies', 'add_my_currency' );
 
function add_my_currency( $currencies ) {
     $currencies['EU'] = __( 'Euro', 'woocommerce' );
     return $currencies;
}
 
add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);
 
function add_my_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'Eu': $currency_symbol = 'E'; break;
     }
     return $currency_symbol;
}?>

