(function() {
	tinymce.create('tinymce.plugins.modulePlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mcemodule', function() {
				ed.windowManager.open({
					file : url + '/module_popup.php', // file that contains HTML for our modal window
					width : 280 + parseInt(ed.getLang('button.delta_width', 0)), // size of our window
					height : 180 + parseInt(ed.getLang('button.delta_height', 0)), // size of our window
					inline : 1
				}, {
					plugin_url : url
				});
			});
			 
			// Register buttons
			ed.addButton('module', {title : 'Insert Category Module', cmd : 'mcemodule', image: url + '/images/module.png' });
		}
	});
	 
	// Register plugin
	// first parameter is the button ID and must match ID elsewhere
	// second parameter must match the first parameter of the tinymce.create() function above
	tinymce.PluginManager.add('module', tinymce.plugins.modulePlugin);

})();