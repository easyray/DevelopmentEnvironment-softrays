<?php
    echo'<pre>';
        print_r ($_POST);
    echo '</pre>';
    

   exec (
        '"C:\\Program Files (x86)\\Mozilla Firefox\\firefox.exe " '.str_replace("/","\\", $_POST['filename'])
    );

    if(isset($_POST['griffon-transfer'])){

        $Code =file_get_contents($_POST['filename']);
        
 
        $Code = str_replace("<?", "<!--", $Code);
        $Code = str_replace("?>", "?-->" , $Code); 
 
    }

if( 
         isset($_POST["task"]) &&
        "save-file" == $_POST["task"]
    ){
        $_POST['elm1'] = str_replace("<!--php", "<?php", $_POST['elm1']);
        $_POST['elm1'] = str_replace("?-->", "?>", $_POST['elm1']);

        file_put_contents($_POST['filename'], $_POST['elm1']);

    }    
?><!DOCTYPE html>
<html>
<head>
    <title>Full featured example - TinyMCE 4</title>
    <meta charset="utf-8">

    <script type="text/javascript" src="jscripts/tinymce4/tinymce.min.js"></script>
    <script type="text/javascript" src="jscripts/tinymce4/plugins/improvedcode/plugin.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea#elm1",
		width: 1000,
		height: 600,    
            plugins: [
                "improvedcode,advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen  form code_wrap change_node insert_code table"
            ],
            //external_plugins: { "improvedcode" : "/jscripts/tinymce4/plugins/improvedcode/plugin.min.js" },
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code_wrap change_node insert_code",
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

<form method="post" >
    <div>
        <h3>Full Featured Editor (full page)</h3>


        <!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
        <div>
            <textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 80%"><?php 
            if(isset($_POST['griffon-transfer'])){
              echo $Code; 
            }
            ?></textarea>
        </div>

            <input type="button" id="save-file" value="  JS Code  " />
            <input type="button" id="save-file-2" value=" PHP Code " />
            <input type="button" id="save-file-3" value=" PHP Code 2" />
    </div>
</form>
<div id="code-result">
    <textarea rows="25" cols="80"></textarea>
</div>
<script type="text/javascript">
        
        function saveFile(){
            var Str ;
            Str = tinyMCE.activeEditor.getContent() ;
            Str = Str.replace(/'/g, "\\'");
            Str = "stuff = '"+Str;
            Str = Str.replace(/\n/g, "'+\n'");
            Str = Str.replace(/_dat/g, "'+dat+'");
            Str = Str.replace(/<!--\?php/g, " ' ;  \n");
            Str = Str.replace(/\?-->/g, "\n stuff += '");           
            $("#code-result textarea").html(Str);
            //console.log(Str);
        }
        
        

        function saveFile2(){
            var Str ;
            Str = tinyMCE.activeEditor.getContent() ;
            Str = Str.replace(/_dat/g, "<?php echo  '<?php echo $stuff; ?>'; ?>");
            Str = Str.replace(/<!--\?/g, <?php echo '" \n <?"'; ?>);
            Str = Str.replace(/\?-->/g, "\n ?>");
            $("#code-result textarea").html(Str);
            //console.log(Str);
        }               

        function saveFile3(){
            var Str ;
            Str = tinyMCE.activeEditor.getContent() ;
            Str = Str.replace(/'/g, "\\'");
            Str = "$Str = '"+Str;
            Str = Str.replace(/\n/g, "'.\n'");
            Str = Str.replace(/_dat/g, "'.$stuff.'");
            Str = Str.replace(/<!--\?php/g, " ' ;  \n");
            Str = Str.replace(/\?-->/g, "\n $Str .= '");            
            $("#code-result textarea").html(Str);
            //console.log(Str);
        }

        $("#save-file-2"  ).bind("click",saveFile2);
        $("#save-file"  ).bind("click",saveFile);        
        $("#save-file-3"  ).bind("click",saveFile3);


    if (document.location.protocol == 'file:') {
        alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
    }
</script>
</body>
</html>