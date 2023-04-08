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
tinymce.PluginManager.add('mypictures', function(editor, url) {
	// Add a button that opens a window
	editor.addButton('my_picture', {
		title: 'Image Manager',
		image: url+'/image/pix-icon.ico',
		onclick: function() {
			// Open window with a specific url
			var win = editor.windowManager.open({
				title: 'Put HTML code',
				url: url + '/dialog.php',
				width: 600,
				height: 350,
				buttons: [
					{
						text: 'Insert',
						onclick: function() {
							// Top most window object
							var win = editor.windowManager.getWindows()[0];

							// Insert the contents of the dialog.html textarea into the editor
							var src = win.getContentWindow().document.getElementById('picture').value

							editor.insertContent('<img src="'+src+'"  />');

							// Close the window
							win.close();
						}
					},

					{text: 'Close', onclick: 'close'}
				]
			});

			//console.log(win);
			//window.win = win;
		}
	});

});

	// Adds a menu item to the tools menu
	/*
	editor.addMenuItem('insert_code', {
		text: 'Insert Code',
		context: 'tools',
		onclick: function() {
			// Open window with a specific url
			editor.windowManager.open({
				title: 'Put HTML code',
				url: url + '/dialog.html',
				width: 600,
				height: 350,
				buttons: [
					{
						text: 'Insert',
						onclick: function() {
							// Top most window object
							var win = editor.windowManager.getWindows()[0];

							// Insert the contents of the dialog.html textarea into the editor
							editor.insertContent(win.getContentWindow().document.getElementById('content').value);

							// Close the window
							win.close();
						}
					},

					{text: 'Close', onclick: 'close'}
				]
			});
		}
	});



//Add another menu item

	// Adds a menu item to the tools menu
	editor.addMenuItem('add_attribute', {
		text: 'Add Attribute',
		context: 'tools',
		onclick: function() {
			// Open window with a specific url
			var Original;
			editor.windowManager.open({
				title: 'Put HTML code',
				url: url + '/dialog.php',
				width: 600,
				height: 250,
				buttons: [
					{
						text: 'Insert',
						onclick: function() {
							// Top most window object
							var win  = editor.windowManager.getWindows()[0];
							Original = win.getContentWindow().document.getElementById('content').value;
							inner    = win.getContentWindow().document.getElementById('content2').value;

							var tagname = Original.match(/<(\w+)/)[1];
							console.log("tag: "+tagname);
							// Insert the contents of the dialog.html textarea into the editor
							editor.selection.getNode().outerHTML = Original + inner +'</'+tagname+'>';

							// Close the window
							win.close();
						}
					},

					{text: 'Close', onclick: 'close'}
				]
			});

			Original = tinyMCE.activeEditor.selection.getNode().outerHTML;
			var inner = tinyMCE.activeEditor.selection.getNode().innerHTML;
			var  index  = Original.indexOf(inner);
			Original = Original.substring(0,index);

			
			window.setTimeout(
				function(){
					insertToWindow(Original,inner);
				},500
			);

		}
	});

});


*/
function insertToWindow(Original, inner){
var win1 = tinyMCE.activeEditor.windowManager.getWindows()[0];
	win1.getContentWindow().document.getElementById('content').value = Original;	
	win1.getContentWindow().document.getElementById('content2').value = inner;	


}