<?php 

	require_once("../../config/config.php");
	require_once($fullPath."/admin/includes/global.inc.php");
	require_once($fullPath."/admin/includes/checkLogin.inc.php");
	require_once($fullPath."/classes/pageTools.class.php");
	require_once($fullPath."/blog/classes/blogTools.class.php");

	$blogTools = new blogTools();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Area - Update Blog Post</title>
<link href="../../admin/stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="mainContainer">
	<div id="title">
	<?php require_once($fullPath."/admin/includes/title.inc.php"); ?>
	</div>

	<div id="body">
	<h1>Update Page</h1>
	<?php
	if (isset($_POST['updatePost'])) {
				
		if ($blogTools->updatePost($_POST['postSelection'],$_POST['title'],$_POST['text'])) {
			echo("<p><font color='green'>Succesful update!</font></p>");
		}
		else {
			echo("<font color='red'><p>Unsuccesful update!</p></font>");
		}
	}

	else if (isset($_POST['postSelection'])) {
		
		$pageTools = new pageTools();
		
		$blogPost = $blogTools->getPostContent($_POST['postSelection']);
		
		require_once($fullPath."/admin/includes/showTags.inc.php");
		
		echo("<p>Your are currently editing <strong>".$blogPost['title']."</strong></p>\n");
		echo("<form method='post' action='updatePost.php' name='editPage'>\n");
		echo("<table>\n");
		echo("<tr>\n");
		echo("<td width='100'>Title</td>\n");
		echo("<td><input type='text' name='title' value='".$blogPost['title']."' size='61'/></td>\n");
		echo("</tr>\n");
		echo("<tr>\n");
		echo("<td>Body</td>\n");
		echo("<td><textarea rows='30' cols='70' name='text'>".$blogPost['body']."</textarea></td>\n");
		echo("</tr>\n");
		echo("<tr>\n");
		echo("<td></td>\n");
		echo("<td><br /><input type='submit' name='updatePost' id='updatePost' value='Update Post' /></td>\n");
		echo("</tr>\n");
		echo("</table>\n");
		echo("<input type='hidden' name='postSelection' id='postSelection' value='".$_POST['postSelection']."' />\n");
		echo("</form>\n");
	}

	else {
		
		echo("<form name='updatePost' method='post'>\n");
		echo("<p>Select the post you wish to update from the list below:</p>\n");
		echo($blogTools->renderPostList());
		echo("<input type='submit' name='submit' id='submit' value='Edit Page'/>\n");
		echo("</form>\n");

	}

	?>

	</div>

	<div id="links">
	<?php 

	//Sublinks
	//1 = ManagePages
	//2 = ManageSite
	//3 = ManageAdmin

	$page=1;
	require_once($fullPath."/admin/includes/adminLinks.inc.php"); 

	?>
	</div>

	<div id="footer">
	<?php require_once($fullPath."/admin/includes/footer.inc.php"); ?>
	</div>
</div>
</body>
</html>

