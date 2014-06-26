<?php

/*
Accordian
*/

$zilla_shortcodes['accordian'] = array(
	'no_preview' => true,
	'params' => array(
		'titles' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Accordian title', 'textdomain'),
			'desc' => __('Accordian Title', 'textdomain')
		),
		'content' => array(
		'std' => '',
			'type' => 'textarea',
			'label' => __('Accoridia content', 'textdomain'),
			'desc' => __('Add the Accordian Content', 'textdomain'),
			),
		
	),
	'shortcode' => '[MJ_accordian titles="{{titles}}"] {{content}}  [/MJ_accordian]',

	'popup_title' => __('Insert Accordian Data', 'textdomain')
);



/*
Clearer
*/


$zilla_shortcodes['clear'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
		),
	),
	'shortcode' => '[MJ_clearer]',
	'popup_title' => __('Insert Clearer DIV', 'textdomain')
);
/*
Horizontal Line
*/

$zilla_shortcodes['line'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
		),
	),
	'shortcode' => '[MJ_horizontal_line]',
	'popup_title' => __('Insert Horizontal Line Shortcode', 'textdomain')
);


/*
Lists Config
*/

$zilla_shortcodes['lists'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __('List Style', 'textdomain'),
			'desc' => __('Select the button\'s style, ie the button\'s colour', 'textdomain'),
			'options' => array(
				'arrow' => 'Arrow',
				'bullet' => 'Bullet',
				'checklist' => 'Checklist',
				'roundarrow' => 'Round-arrow',
				'mj-bullet1' => 'mj-bullet1',
				'mj-bullet2' => 'mj-bullet2',
				'mj-bullet3' => 'mj-bullet3',
				'mj-bullet4' => 'mj-bullet4',
				'mj-bullet5' => 'mj-bullet5',
				'mj-bullet6' => 'mj-bullet6',
				'mj-bullet7' => 'mj-bullet7',
				'mj-bullet8' => 'mj-bullet8',
				'mj-bullet9' => 'mj-bullet9',
				'mj-bullet10' => 'mj-bullet10',
				'mj-bullet11' => 'mj-bullet11',
				'mj-special2' => 'mj-special2',
				'mj-special3' => 'mj-special3',
				'mj-special4' => 'mj-special4',
				'mj-special5' => 'mj-special5',
				'mj-special6' => 'mj-special6',
				'mj-special7' => 'mj-special7',
				'mj-special8' => 'mj-special8',
				'mj-special9' => 'mj-special9',
				'mj-special10' => 'mj-special10',
				'mj-special11' => 'mj-special11',
				'mj-special12' => 'mj-special12',

				
				
				
			)
		),
		'content' => array(
			'std' => 'List items',
			'type' => 'textarea',
			'label' => __('List Items', 'textdomain'),
			'desc' => __('Item per row. Format: &#60;li&#62;List item&#60;&#47;li&#62;', 'textdomain'),
		)
	),
	'shortcode' => '[MJ_lists style="{{style}}"] {{content}} [/MJ_lists]',
	'popup_title' => __('Insert Button Shortcode', 'textdomain')
);


/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', 'textdomain'),
			'desc' => __('Add the button\'s url eg http://example.com', 'textdomain')
		),
		'style' => array(
			'type' => 'select',
			'label' => __('Button Style', 'textdomain'),
			'desc' => __('Select the button\'s style, ie the button\'s colour', 'textdomain'),
			'options' => array(
  				'grey' => 'Grey',
			    'blue' => 'Blue',
				'cyan' => 'Cyan',
				'green' => 'Green',
				'orange' => 'Orange',	
				'pink' => 'Pink',
				'red' => 'Red',
				'yellow' => 'Yellow'				
			
				
				
				
			)
		),
		'size' => array(
			'type' => 'select',
			'label' => __('Button Size', 'textdomain'),
			'desc' => __('Select the button\'s size', 'textdomain'),
			'options' => array(
				'mini' => 'Mini',
				'normal' => 'Normal',
			)
		),
		'content' => array(
			'std' => 'Button Text',
			'type' => 'text',
			'label' => __('Button\'s Text', 'textdomain'),
			'desc' => __('Add the button\'s text', 'textdomain'),
		)
	),
	'shortcode' => '[MJ_button url="{{url}}" style="{{style}}" size="{{size}}"] {{content}} [/MJ_button]',
	'popup_title' => __('Insert Button Shortcode', 'textdomain')
);

/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __('Alert Type', 'textdomain'),
			'desc' => __('Select the alert\'s style, ie the alert colour', 'textdomain'),
			'options' => array(
				'alert' => 'Alert',
				'success' => 'Success',
				'error' => 'Error/Delete',
				'help' => 'Help'
			)
		),
		'content' => array(
			'std' => 'Your Alert!',
			'type' => 'textarea',
			'label' => __('Alert Text', 'textdomain'),
			'desc' => __('Add the alert\'s text', 'textdomain'),
		)
		
	),
	'shortcode' => '[MJ_box type="{{style}}"] {{content}} [/MJ_box]',
	'popup_title' => __('Insert Alert Shortcode', 'textdomain')
);

/*-----------------------------------------------------------------------------------*/
/*	Toggle Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['toggle'] = array(
	'no_preview' => true,
	'params' => array(
		'title' => array(
			'type' => 'text',
			'label' => __('Toggle Content Title', 'textdomain'),
			'desc' => __('Add the title that will go above the toggle content', 'textdomain'),
			'std' => 'Title'
		),
		'content' => array(
			'std' => 'Content',
			'type' => 'textarea',
			'label' => __('Toggle Content', 'textdomain'),
			'desc' => __('Add the toggle content. Will accept HTML', 'textdomain'),
		),
		'state' => array(
			'type' => 'select',
			'label' => __('Toggle State', 'textdomain'),
			'desc' => __('Select the state of the toggle on page load', 'textdomain'),
			'options' => array(
				'open' => 'Open',
				'closed' => 'Closed'
			)
		),
		
	),
	'shortcode' => '[zilla_toggle title="{{title}}" state="{{state}}"] {{content}} [/zilla_toggle]',
	'popup_title' => __('Insert Toggle Content Shortcode', 'textdomain')
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$zilla_shortcodes['tabs'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[zilla_tabs] {{child_shortcode}}  [/zilla_tabs]',
    'popup_title' => __('Insert Tab Shortcode', 'textdomain'),
    
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Tab Title', 'textdomain'),
                'desc' => __('Title of the tab', 'textdomain'),
            ),
            'content' => array(
                'std' => 'Tab Content',
                'type' => 'textarea',
                'label' => __('Tab Content', 'textdomain'),
                'desc' => __('Add the tabs content', 'textdomain')
            )
        ),
        'shortcode' => '[zilla_tab title="{{title}}"] {{content}} [/zilla_tab]',
        'clone_button' => __('Add Tab', 'textdomain')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Columns Config
/*-----------------------------------------------------------------------------------*/

/*$zilla_shortcodes['columns'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns Shortcode', 'textdomain'),
	'no_preview' => true,
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __('Column Type', 'textdomain'),
				'desc' => __('Select the type, ie width of the column.', 'textdomain'),
				'options' => array(
					'MJ_one_half' => 'One Half',
					'MJ_one_half_last' => 'One Half Last',				
					'MJ_one_third' => 'One Third',
					'MJ_one_third_last' => 'One Third Last',
					'MJ_one_fourth' => 'One Fourth',
					'MJ_one_fourth_last' => 'One Fourth Last',
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Column Content', 'textdomain'),
				'desc' => __('Add the column content.', 'textdomain'),
			)
		),
		'shortcode' => '[{{column}}] {{content}} [/{{column}}] ',
		'clone_button' => __('Add Column', 'textdomain')
	)
);*/

?>