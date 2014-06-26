(function ()
{
	// create zillaShortcodes plugin
	tinymce.create("tinymce.plugins.zillaShortcodes",
	{
		init: function ( ed, url )
		{
			ed.addCommand("zillaPopup", function ( a, params )
			{
				var popup = params.identifier;
				
				// load thickbox
				tb_show("Insert MJ Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
			});
		},
		createControl: function ( btn, e )
		{
			if ( btn == "zilla_button" )
			{	
				var a = this;
				
				var btn = e.createSplitButton('zilla_button', {
                    title: "Insert MJ Shortcode",
					image: "../wp-content/themes/Mj-simple/includes/shortcodes/tinymce/images/icon_minimal.png",
                });

                btn.onRenderMenu.add(function (c, b)
				{					
					 a.addWithPopup( b, "Alerts", "alert" );
					 a.addWithPopup( b, "Buttons", "button" );
					 a.addWithPopup( b, "Accordian", "accordian" );
					   a.addWithPopup( b, "tabs", "tabs" );
					 a.addWithPopup( b, "Lists", "lists" );					
					 a.addWithPopup( b, "Horizontal Line", "line" );
					 a.addWithPopup( b, "Clear", "clear" );
					  a.addWithPopup( b, "toggle", "toggle" );
					
					 
				});
                
                return btn;
			}
			
			return null;
		},
		addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("zillaPopup", false, {
						title: title,
						identifier: id
					})
				}
			})
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		},
		getInfo: function () {
			return {
				longname: 'Zilla Shortcodes',
				author: 'Orman Clark',
				authorurl: 'http://themeforest.net/user/ormanclark/',
				infourl: 'http://wiki.moxiecode.com/',
				version: "1.0"
			}
		}
	});
	
	// add zillaShortcodes plugin
	tinymce.PluginManager.add("zillaShortcodes", tinymce.plugins.zillaShortcodes);
})();