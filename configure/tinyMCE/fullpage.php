<?php
    if(isset($_POST['griffon-transfer2'])){

        $Code =file_get_contents($_POST['filename']);
        
        
        $Code = str_replace("<?", "<!--", $Code);
        $Code = str_replace("?>", "-->" , $Code); 
 
    }
?><!DOCTYPE html>
<html>
<head>
    <title>Full featured example - TinyMCE 4</title>
    <meta charset="utf-8">

    <script type="text/javascript" src="jscripts/tinymce4/tinymce.min.js"></script>
    <script type="text/javascript" src="jscripts/tinymce4/plugins/improvedcode/plugin.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea#elm1",
		width: 1000,
		height: 600,    
            plugins: [
                "improvedcode,advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen fullpage form"
            ],
            //external_plugins: { "improvedcode" : "/jscripts/tinymce4/plugins/improvedcode/plugin.min.js" },
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image ",
            toolbar2: "improvedcode",

            //HTML ImprovedCode
            improvedcode_options : {
                height: 580,
                indentUnit: 4,
                tabSize: 4,
                lineNumbers: true,
                autoIndent: true,
                theme: 'monokai'
            }
        });
    </script>

</head>
<body role="application">

<form method="post" action="saveStuff.php">
    <div>
        <h3>Full Featured Editor (full page)</h3>


        <!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
        <div>
            <textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 80%"><?php 
            if(isset($_POST['griffon-transfer2'])){
              echo $Code; 
            }
            ?></textarea>
        </div>

        <!-- Some integration calls -->


        <input type="submit" name="save" value="Submit" />
 
    </div>
</form>

<script type="text/javascript">
    if (document.location.protocol == 'file:') {
        alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
    }
</script>
</body>
</html>