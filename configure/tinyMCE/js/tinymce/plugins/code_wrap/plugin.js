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
tinymce.PluginManager.add('code_wrap', function(editor, url) {
	// Add a button that opens a window
	
	editor.addButton('code_wrap', {
		//text: 'My button',
		title: 'wrap selection with code',
		image: url+'/icon/codeWrap.png',
		onclick: function() {
			// Open window
			editor.windowManager.open({
				title: 'Wrap with code',
				body: [
					{type: 'textbox', name: 'prefix', label: 'Pre'},
					{type: 'textbox', name: 'postfix', label: 'Post'}
				],
				onsubmit: function(e) {
					// Insert content when the window form is submitted
					//editor.insertContent('Title: ' + e.data.title);
					
					var LeftCode  = e.data.prefix;
					var RightCode = e.data.postfix;

					var Original = editor.selection.getNode().outerHTML;

					editor.selection.getNode().outerHTML = "<!--?php "+LeftCode+"?-->"+Original+"<!--?php "+RightCode+" ?--> ";
				}
			});

		}
	});

	// Adds a menu item to the tools menu
	editor.addMenuItem('code_wrap', {
		text: 'Code Wrapper',
		context: 'tools',
		onclick: function() {
			// Open window with a specific url
			editor.windowManager.open({
				title: 'TinyMCE site',
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
							
						var LeftCode  = win.getContentWindow().document.getElementById('content1').value;
						var RightCode = win.getContentWindow().document.getElementById('content2').value;

						var Original = editor.selection.getNode().outerHTML;

						editor.selection.getNode().outerHTML = "<!--?php "+LeftCode+"?-->"+Original+"<!--?php "+RightCode+" ?--> ";
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