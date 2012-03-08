<?php 

	require_once("includes/blogAdminGlobal.inc.php");

  $page->set("title","Blog Management");
  $page->set("heading","Blog Management");
  $page->addContent("Welcome to the Blog management module!");
  $page->render("corePage.inc.php");

?>
