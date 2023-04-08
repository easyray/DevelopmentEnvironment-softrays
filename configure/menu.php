<?php

    if( isset($_REQUEST["root-folder"]) ){
        $Folder = $_REQUEST["root-folder"].'/forbidden/db_connect.php';
    }else if(isset($_REQUEST["rotfolder"])){
	   $Folder = getAppFolder(  $_REQUEST["rotfolder"] );
       if(is_dir("$Folder/admin")){
            $Folder = "$Folder/admin";
       }
       $Folder = $Folder.'/forbidden/db_connect.php'; 
    }

	if(!function_exists("pretty_r")){
		include "$Folder";
	}


function getAppFolder($WorkingFolder){
    if(0 !=stripos($WorkingFolder, $_SERVER['DOCUMENT_ROOT'])){
        return $WorkingFolder;
    }
    $WorkingFolder = substr($WorkingFolder, strlen($_SERVER['DOCUMENT_ROOT'])+1 );
    $AppFolder = explode('/', $WorkingFolder)[0];
    $G = $_SERVER['DOCUMENT_ROOT'].'/'.$AppFolder;

    return str_replace("\\", '/', $G);
}

?><div id="praise-nav-bar">
    <span class="nav-item"><a href="index.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>">Home</a></span>
    <span class="nav-item"><a href="assign-template.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>">Assign Template</a></span>
    <span class="nav-item"><a href="default-modules.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>">Default Module</a></span>
    <span class="nav-item"><a href="module-routing.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>">Module Routing</a></span>
    <span class="nav-item"><a href="plugins.php?root-folder=<?php echo  $_REQUEST['root-folder'] ; ?>">Plugins</a></span>
</div>