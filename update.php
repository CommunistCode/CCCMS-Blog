<?php

	require_once("../config/config.php");
	require_once("classes/update.class.php");

	$updateBlog = new updateBlog();

	$updateBlog->update();

?>
