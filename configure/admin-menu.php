<?php
    if( isset($_REQUEST["root-folder"]) ){
        $Folder = $_REQUEST["root-folder"].'/';
    }else{
	   $Folder = "";
    }

    $Folder_ = $Folder;
	if(! function_exists("pretty_r")){
		include "$Folder"."forbidden/db_connect.php";
	}	

	include ("functions.php");
	//include ("sharedobjects.php");

	//echo json_encode($_POST); die();
	
	if(isset($_POST['task']) && $_POST['task'] =="menu.create" ){
		createMenu();
	}elseif(isset($_POST['task']) && 
		$_POST['task'] =="menu.update"){
		updateMenu();
	}elseif(isset($_POST['task']) && 
		$_POST['task'] =="menu.saveup"){
		saveParents();
	}elseif (
		isset($_POST['task']) && 
		$_POST['task'] =="menu.construct") {
		
		$Result = fetchMainMenu();
		$str = "";

		foreach ($Result as $key => $value) {
			$str .= '<li><a href="javascript:;"><i class="fa fa-bolt"></i><span class="title">'.$value['string'].'</span> <span class="arrow "></span></a>';
			if(($sub=fetchSubMenu($value['id'])) !=''){
				$str .= $sub;
			}//end if
			$str.= '</li>'; 
		}
	}

	function fetchMainMenu(){
		
		global $PDO;
		
		$query = "SELECT * FROM admin_menu WHERE levl= '1' ";
		$Result = $PDO->query($query);
		$Result = $Result->fetchAll();

		return $Result;
	}

	function fetchSubMenu($parent){
		global $PDO;
		$query = "SELECT * FROM admin_menu WHERE parent= ? ";
		$pds    =  $PDO->prepare($query);
		$Result = $pds->execute(array($parent));
		
		if($Result){
			$Result = $pds->fetchAll();
		}else{
			$Result ="";
		}

		$str ='';
		if(is_array($Result)){
			$str  = '<ul class="sub-menu">' ;  
			foreach ($Result  as $key => $value) {
				$str .= '<li><a href="'.convertURL($value['url']).'">'.$value['string'].'</a></li>' ;  
			}
			$str  .= '</ul>';				
		}//end if
		return $str;
	}

	$Menus = getMenus();

 ?><!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div id="container">
        
        <div id="my-logo"><img src="pix/logo.png" /> </div>
		<?php include("menu.php"); ?>
		
        <div id="our-slide-show">
			
		<span id="title"><h2>Menu</h2></span>

  <table class="t-colapse" border="1">
	<tbody>
	<tr>
		<th>S/N</th>
		<th>&nbsp;</th>
		<th>Name</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>
	<?php
		$D = $PDO->prepare("SELECT * FROM url ");
		$D->execute(array() );
		$URLs = $D -> fetchAll(2);	

		
	?>
	<?php $SN = 1; ?>
	<?php foreach($Menus AS $Value) { ?>
	<tr>
		<td>&nbsp;<?php echo  $SN++; ?></td>
		<td>&nbsp;
			<input id="id-chk-menu-<?php echo  $Value["id"]; ?>" name="name[]" type="checkbox" value="<?php echo  $Value["id"]; ?>" />
		</td>
		<td>
			<span style="" id ="id-txt-menu-<?php echo  $Value["id"]; ?>">
				<input type="button" id="id-btn-menuedit-<?php echo  $Value['id']; ?>" value="Edit" onclick="editItem(this,'id-txt-menu-','id-spn-menu-update-')" />
				<?php echo  $Value['string']; ?>
				
			</span>
			
			<span style="display: none" id="id-spn-menu-update-<?php echo  $Value['id']; ?>" >
				<form method="post">			
				<table>
					<tbody>
						<tr>
							<td>Name</td>
							<td><input name="name" type="text" value="<?php echo  $Value['string']; ?>" /> &nbsp;
							</td>
						</tr>
						<tr>
							<td>level</td>
							<td><input name="level" type="text" value="<?php echo  $Value['levl']; ?>" /> &nbsp;</td>
						</tr>
						<tr>
							<td>URL</td>
							<td>
<?PHP							

	//pretty_r($G);

 	$KK = new DropdownCreator();
	$KK->setDataArray($URLs);
	$KK->setValuekey('string');
	$KK->setTextkey('string');
	$KK->setValue($Value['string']);
	$KK->setName("url");
	echo $KK->getDropdownstring();
/********/

?>
<!--<input name="url" type="text" value="<?php echo  $Value['url']; ?>" /> -->&nbsp;
</td>
						</tr>
							<td>Privilege</td>
							<td>
<?PHP							

		$D = $PDO->prepare("SELECT * FROM privileges");
		$D->execute(array() );
		$PRIV = $D -> fetchAll(2);	

 	$KK = new DropdownCreator();
	$KK->setDataArray($PRIV);
	$KK->setValuekey('code');
	$KK->setTextkey('CONSTANT_NAME');
	$KK->setValue($Value['privilege']);
	$KK->setName("privilege");
	echo $KK->getDropdownstring();
	//CREATE TABLE 'privileges' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'CONSTANT_NAME' TEXT, 'description' TEXT, 'code' INTEGER)
/********/

?>
<!--<input name="url" type="text" value="<?php echo  $Value['url']; ?>" /> -->&nbsp;
</td>
						</tr>						
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="submit" value="  Update  "  name="edit"/>
								<input type="submit" value="  Delete  "  name="del"/>

							</td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" name="task" value="menu.update"/>
				<input type="hidden" name="id" value="<?php echo  $Value['id']; ?>"/>
				</form>

			</span>			

		</td>
	<td>
		<?php echo  createList($Menus,'id-sel-'.$Value['id'],intval($Value['levl'])-1, $Value['parent'],"cls-sel-parent"); ?>&nbsp;
	</td>
	<td>&nbsp;</td>
	</tr>
	<?php } ?>
	</tbody>
</table>    
    <div style="margin-top: 30px" >
    <form method="post" style="display: inline-block;">
        <input type="text" name="name" />
        <input type="hidden" name="task" value="menu.create" />
        <input type="hidden" name="level" value="1" />
        <input type="submit" value="  Create  ">
    </form>
    <input type="button" value="Save up" onclick="saveup('cls-sel-parent')" />
    </div>
    <form id="saveup-form" method="post">
        <input type="hidden" name="parents" />
        <input type="hidden" name="task" value="menu.saveup" />
    </form>

    <form method ="post">
    	<input type="hidden"  name="task" value="menu.construct" />	
    	<input type="submit" value="Construct Menu" />
    </form>

    <form method ="post">
    	<input type="hidden"  name="task" value="menu.construct2" />	
    	<input type="submit" value="Construct Tab Menu" />
    </form>
    <?php 
    	if(  isset($_POST['task']) && 
    		(
    			$_POST['task'] =="menu.construct" ||
    			$_POST['task'] =="menu.construct2"
    		)	
    	){
    		echo htmlentities($str) ;
    	}
    ?>
<script type="text/javascript" src="js/cat.js"></script>
        </div>
	</div>

</body>
</html>