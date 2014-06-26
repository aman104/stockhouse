<?php


/*-----------------------------------------------------------------------------------*/
/*	Clearer
/*-----------------------------------------------------------------------------------*/

if (!function_exists('MJ_clearer')) {
	function MJ_clearer( $atts= null ) {
	   return '<div class="clear" /></div>';
	}
	add_shortcode('MJ_clearer', 'MJ_clearer');
}



/*-----------------------------------------------------------------------------------*/
/*	Horizontal Line
/*-----------------------------------------------------------------------------------*/

if (!function_exists('MJ_horizontal_line')) {
	function MJ_horizontal_line( $atts = null ) {
	   return '<hr class="MJ_hline" />';
	}
	add_shortcode('MJ_horizontal_line', 'MJ_horizontal_line');
}


/*-----------------------------------------------------------------------------------*/
/*	Accordian
/*-----------------------------------------------------------------------------------*/
if (!function_exists('MJ_accordian')) {
	function MJ_accordian( $atts,$content = null ) {
	extract(shortcode_atts(array(
			'titles' => '#'
			
	    ), $atts));
	

	   return '<div id="accordion-container"><h2 class="accordion-header">'.$titles.'</h2>  <div class="accordion-content">'.do_shortcode($content).'</div></div>';
	}
	add_shortcode('MJ_accordian', 'MJ_accordian');
}

/*-----------------------------------------------------------------------------------*/
/*	Buttons
/*-----------------------------------------------------------------------------------*/

if (!function_exists('MJ_button')) {
	function MJ_button( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'url' => '#',
			'style' => 'grey',
			'size' => 'small',
			'target' => '_blank',
			'type' => '',
	    ), $atts));
		
	   return '<a target="'.$target.'" class="button '.$size.' '.$style.' '. $type .'" href="'.$url.'">' . do_shortcode($content) . '</a>';
	}
	add_shortcode('MJ_button', 'MJ_button');
}


/*-----------------------------------------------------------------------------------*/
/*	Alerts
/*-----------------------------------------------------------------------------------*/

if (!function_exists('MJ_box')) {
	function MJ_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'type'   => 'alert'
	    ), $atts));
		
	   return '<div class="box '.$type.'">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('MJ_box', 'MJ_box');
}


/*-----------------------------------------------------------------------------------*/
/*	Lists
/*-----------------------------------------------------------------------------------*/

if (!function_exists('MJ_lists')) {
	function MJ_lists( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style'   => 'arrow'
	    ), $atts));
		
	   return '<div class="list '.$style.'">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('MJ_lists', 'MJ_lists');
}

/*-----------------------------------------------------------------------------------*/
/*	Toggle Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('zilla_toggle')) {
	function zilla_toggle( $atts, $content = null ) {
	    extract(shortcode_atts(array(
			'title'    	 => 'Title goes here',
			'state'		 => 'open'
	    ), $atts));
	
		return "<div data-id='".$state."' class=\"zilla-toggle\"><span class=\"zilla-toggle-title\">". $title ."</span><div class=\"zilla-toggle-inner\">". do_shortcode($content) ."</div></div>";
	}
	add_shortcode('zilla_toggle', 'zilla_toggle');
}


/*-----------------------------------------------------------------------------------*/
/*	Tabs Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('zilla_tabs')) {
	function zilla_tabs( $atts, $content = null ) {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		
		STATIC $i = 0;
		$i++;

		// Extract the tab titles for use in the tab widget.
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		
		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		
		$output = '';
		
		if( count($tab_titles) ){
		    $output .= '<div id="zilla-tabs-'. $i .'" class="zilla-tabs"><div class="zilla-tab-inner">';
			$output .= '<ul class="zilla-nav zilla-clearfix">';
			
			foreach( $tab_titles as $tab ){
				$output .= '<li><a href="#zilla-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
			}
		    
		    $output .= '</ul>';
		    $output .= do_shortcode( $content );
		    $output .= '</div></div>';
		} else {
			$output .= do_shortcode( $content );
		}
		
		return $output;
	}
	add_shortcode( 'zilla_tabs', 'zilla_tabs' );
}

if (!function_exists('zilla_tab')) {
	function zilla_tab( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );
		
		return '<div id="zilla-tab-'. sanitize_title( $title ) .'" class="zilla-tab">'. do_shortcode( $content ) .'</div>';
	}
	add_shortcode( 'zilla_tab', 'zilla_tab' );
}

?>