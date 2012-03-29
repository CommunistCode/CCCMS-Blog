<?php

	require_once("includes/blogGlobal.inc.php");

  $pageTools->getDynamicContent();

  $page->set("title","Blog");
  $page->set("heading","Recent Blog Posts");
  
	$page->addContent($blogTools->renderLatestPosts(10));

  $page->render("template.inc.php");

?>
