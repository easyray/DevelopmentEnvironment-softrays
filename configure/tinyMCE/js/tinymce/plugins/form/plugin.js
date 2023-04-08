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

console.log("We are going nuts here");

function TinyMCE_Form_Plugin() {
    
    var url, editor;

    var formSubmit = function () {
        // Top most window object
        var win = editor.windowManager.getWindows()[0];

        // Insert the contents of the dialog.html textarea into the editor

        editor.insertContent(
            win.getContentWindow().document.getElementById('content').value);

        // Close the window
        win.close();
    };

    var clickThing = function () {
        // Top most window object
        
        var win = editor.windowManager.getWindows()[0];
        var FunctionName;


        // Insert the contents of the dialog.html textarea into the editor
        if (win.getContentWindow().document.getElementById('choose-recset').checked) {
            code_tent = win.getContentWindow().document.getElementById('content2').value;

            FunctionName = win.getContentWindow().document.getElementById('recordset-fn-name').value;
            if ('' != code_tent.trim()) {
                code_tent = "\n\n<!--?php \n" +
                    "function " + FunctionName +
                    '( ){' +
                    code_tent +
                    '\n}\n ?-->';
                code_tent += '\n<?php $recordset = ' + FunctionName + '(); ?>\n';
                /////////////
                code_tent = code_tent.replace(
                    "$recordset",
                    win.getContentWindow().document.getElementById('recordset-name').value
                );
                code_tent = code_tent.replace(
                    "$record",
                    win.getContentWindow().document.getElementById('record-name').value
                );
            }
            form_code ="";
        } else {
	        form_code = win.getContentWindow().document.getElementById('content').value;


	        form_code = form_code.replace(
	            "$recordset",
	            win.getContentWindow().document.getElementById('recordset-name').value
	        );

	        form_code = form_code.replace(
	            "$record",
	            win.getContentWindow().document.getElementById('record-name').value
	        );

            code_tent = "";
        }

        editor.insertContent(
            form_code + code_tent
        );

        // Close the window
        win.close();
    };

    var winOpen = function () {
        // Open window
        editor.windowManager.open({
            title: 'TinyMCE site',
            url: url + '/dialog.php',
            width: 600,
            height: 400,
            onsubmit: formSubmit,
            buttons: [{
                    text: 'Insert',
                    onclick: clickThing
                },

                {
                    text: 'Close',
                    onclick: 'close'
                }
            ]
        });

    };

    var addForm = function(_editor, _url) {
    	
    	editor = _editor;
        url    = _url;
        // Add a button that opens a window
        editor.addButton(
            'formbtn', {
                title: 'My Form',
                text : 'Forms',
                image: false,
                onclick: winOpen
            }
        );

        // Adds a menu item to the tools menu
        editor.addMenuItem(
            'myform', {
                text: 'Form Items',
                context: 'tools',
                onclick: winOpen
            }
        );
    };

    tinymce.PluginManager.add('form', addForm );

}

TinyMCE_Form_Plugin();