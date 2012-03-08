<?php

	require_once("includes/blogGlobal.inc.php");

  $page->set("title","Blog");
  $page->set("heading","Recent Blog Posts");
  
	$page->addContent($blogTools->renderLatestPosts(10));

  $page->render("corePage.inc.php");

?>
