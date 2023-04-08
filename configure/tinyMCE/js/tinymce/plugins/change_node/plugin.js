/**
 * plugin.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/*jshint unused:false */
/*global tinymce:true */

/**
 * Example plugin that adds a toolbar button and menu item.
 */
tinymce.PluginManager.add('change_node', function(editor, url) {
	// Add a button that opens a window
	
	editor.addButton('change_node', {
		//text: 'My button',
		title: 'Change Tag Name',
		image: url+'/icon/change_node.png',
		onclick: function() {
			// Open window
			editor.windowManager.open({
				title: 'Change Tag name',
				body: [
					{type: 'textbox', name: 'newtag', label: 'New Tag'}
				],
				onsubmit: function(e) {
					// Insert content when the window form is submitted
					//editor.insertContent('Title: ' + e.data.title);
					
					var TagCode  = e.data.newtag;
					

					var Original = editor.selection.getNode().innerHTML;

					editor.selection.getNode().outerHTML = '<'+TagCode
					+'>'+Original+ '</'+TagCode+'>';
				}
			});

		}
	});

	// Adds a menu item to the tools menu
	editor.addMenuItem('change_node', {
		text: 'Change Node',
		context: 'tools',
		onclick: function() {
			// Open window with a specific url
			editor.windowManager.open({
				title: 'Change Selected Node Tag',
				url: url + '/dialog.html',
				width: 400,
				height: 200,
				buttons: [
					{
						text: 'Insert',
						onclick: function() {
							// Top most window object
							var win = editor.windowManager.getWindows()[0];

							// Insert the contents of the dialog.html textarea into the editor
							
						var TagCode  = win.getContentWindow().document.getElementById('content1').value;


					var Original = editor.selection.getNode().innerHTML;

					editor.selection.getNode().outerHTML = '<'+TagCode
					+'>'+Original+ '</'+TagCode+'>';
						//editor.insertContent(win.getContentWindow().document.getElementById('content').value);

							// Close the window
							win.close();
						}
					},

					{text: 'Close', onclick: 'close'}
				]
			});
		}
	});
});