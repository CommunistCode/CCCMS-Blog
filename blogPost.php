<?php

	require_once("../config/config.php");
	require_once($fullPath."/classes/pageTools.class.php");
  require_once($fullPath."/membership/classes/member.class.php");
	require_once($fullPath."/blog/classes/blogTools.class.php");
	require_once($fullPath."/includes/global.inc.php");

	$blogTools = new blogTools();
	$blogArray = $blogTools->getBlogPost($_GET['blogPostID']);

  if (isset($_POST['submitComment'])) {

    $blogTools->newComment($_POST['blogPostID'],$_POST['comment']);

  }

	$heading = $blogArray['title'];
	$include = "includes/blogPost.inc.php";

	require_once($fullPath."/blog/themes/".$pageTools->getTheme("blog")."/templates/template.inc.php");

?>
