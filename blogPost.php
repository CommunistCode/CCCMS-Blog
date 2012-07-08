<?php

	require_once("includes/blogGlobal.inc.php");
  require_once(FULL_PATH."/membership/classes/member.class.php");

	$blogArray = $blogTools->getBlogPost($_GET['blogPostID']);

  if (isset($_POST['submitComment']) && strtolower($_POST['spamTest']) == "no") {

    $blogTools->newComment($_POST['blogPostID'],$_POST['comment']);
    header("Location: ".$_SERVER['PHP_SELF']."?blogPostID=".$_GET['blogPostID']);

  }

  $page->set("title",$blogArray['title']);
  $page->set("heading",$blogArray['title']);

	$page->addInclude("includes/blogPost.inc.php",array("blogArray"=>$blogArray));
  $page->render("corePage.inc.php");

?>
