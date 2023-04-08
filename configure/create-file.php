<?php
	include ("functions.php");

		$RelativePath = "modules/article_search/pr_fetchArticle.php";
		
		$Paths = explode("/", $RelativePath);
		
		$L = sizeof($Paths);
		
		$current = '..';
		for($c=0; $c<($L-1); $c++){
			if(!is_dir("$current/".$Paths[$c]   )){
				
				mkdir("$current/".$Paths[$c]);
				
			}
			$current = "$current/".$Paths[$c];
		}
		
		
		file_put_contents("$current/".$Paths[$c],"<?php echo 'Hello';  ?>");
		
		echo "$current/".$Paths[$c];