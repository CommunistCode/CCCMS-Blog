<?php

	require_once("../config/config.php");
	require_once($fullPath."/classes/pageTools.class.php");
	require_once($fullPath."/blog/classes/blogTools.class.php");
	require_once($fullPath."/includes/global.inc.php");

	$blogTools = new blogTools();

  $pageTitle = "Blog";
	$heading = "Recent Blog Posts";
	$content = $blogTools->renderLatestPosts(10); 

	require_once($fullPath."/blog/themes/".$pageTools->getTheme("blog")."/templates/template.inc.php");

?>
