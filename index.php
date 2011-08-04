<?php 

	require_once("../config/config.php");
	require_once($fullPath."/blog/classes/blogTools.class.php");
	require_once($fullPath."/classes/pageTools.class.php");

	$pageTools = new pageTools();
	$blogTools = new blogTools();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>CCCMS : Blog</title>
		<link href="../stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
		<link href="stylesheet/blogStyle.css" rel="stylesheet" type"text/css" />
	</head>
	<body>
		<div id="mainContainer">
			<div id="title">
				<?php 
					require_once("../includes/title.inc.php"); 
			?>
			</div>
			<div class='links'>
				<?php 
					require_once("../includes/links.inc.php"); 
				?>
			</div>
			<div class='blogLinks'>

				<?php
					require_once("includes/blogLinks.inc.php");
				?>

			</div>
			<div class="blogBody">
		
				<h1>Blog Posts</h1>	

				<?php 

					$blogTools->renderLatestPosts(10);
							
				?>

			</div>
			<div id="footer">
				<?php 
					require_once("../includes/footer.inc.php"); 
				?>
			</div>
		</div>
	</body>
</html>
