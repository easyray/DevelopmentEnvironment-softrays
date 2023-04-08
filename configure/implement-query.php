<?php
if( 
 	isset($_POST["task"]) &&
	"show-query" == $_POST["task"]
){
	$PDO = new QueryMGr();
	global $PDO;

	showQuery();
}

if( 
 	isset($_POST["task"]) &&
	"implement-query" == $_POST["task"]
){


	$selection1 = explode(",", $_POST['selection-1']);
	$selection2 = explode(",", $_POST['selection2']);

	$U =[];

	foreach ($selection1 as $key => $value) {
		# code...
		if("" !=ltrim(rtrim($value))){
			$U[$value]="";
		}
	}

	foreach ($selection2 as $key => $value) {
		# code...
		if("" !=ltrim(rtrim($value))){
			$U[$value]="";
		}

	}


	file_put_contents("imp-query.php", '<?php'."\n".$_POST["q-text"]."\n ?>");
}

?>
<?php if( 
 	isset($_POST["task"]) && "implement-query" == $_POST["task"]) : ?>
<form method="post">
	<table>
	<tbody>
		<tr>
			<td>indec</td>
			<td>input</td>
		</tr>
		 
		<?php foreach($U as $key => $value): ?>
		<tr>
			<td><?php echo $key; ?></td>
			<td><input name="<?php echo $key; ?>" /></td>
		</tr>	 
	 <?php endforeach; ?>
	</tbody>
	</table>
	<input type="hidden" name="task" value="show-query" />
	<input type="submit" value="show">
</form>
<?php endif; ?>
<?php

function showQuery(){
	
	include dirname(__FILE__)."/imp-query.php";		
}


class QueryMGr 
{
	

	function prepare($query){
		return new QeryExec($query);
	}
}

class QeryExec{
	public $Query;
	function __construct($query){
		$this->Query = $query;
	}

	function execute($stuff){
		echo $this->getPrepedQuery ($this->Query, $stuff);
	}

	function getPrepedQuery ($query, $stuff){

		$q = explode("?", $query);

		$k =0;
		foreach ($stuff as $key => $value) {
			
			$stuff[$key] = $this->escape_sql($value);
			
			$q[$k] .= '?';
			$q[$k] = str_replace('?', " '".$stuff[$key]."' ", $q[$k]);
			$k++;
		}

		return '<pre>'.implode("", $q).'</pre>';
	}	

	function escape_sql($str) {

	    $search = array("\\",  "\x00", "\n",  "\r",  "'", "\x1a");
	    $replace = array("\\\\","\\0","\\n", "\\r", "\'", "\\Z");

	    $ret = str_replace($search, $replace, $str);
	    
	    return $ret;
	}

}