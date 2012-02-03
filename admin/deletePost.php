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
<title>Admin Area - Delete Blog Post</title>
<link href="<?php echo($directoryPath); ?>/admin/stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="mainContainer">
	<div id="title">
	<?php require_once($fullPath."/admin/includes/title.inc.php"); ?>
	</div>

	<div id="body">
	<h1>Update Page</h1>
	<?php
	if (isset($_POST['deletePost'])) {
				
		if ($blogTools->deletePost($_POST['postSelection'])) {
			echo("<p><font color='green'>Post was deleted!</font></p>");
		}
		else {
			echo("<font color='red'><p>Post could not be deleted!</p></font>");
		}
	}

	else if (isset($_POST['postSelection'])) {
		
		$pageTools = new pageTools();
		
		$blogPost = $blogTools->getPostContent($_POST['postSelection']);
		
		echo("<p>Are you sure you wish to delete <strong>".$blogPost['title']."</strong>?</p>\n");
		echo("<form method='post' action='deletePost.php' name='editPage'>\n");
		echo("<input type='submit' name='deletePost' id='deletePost' value='Delete Post' />\n");
		echo("<input type='hidden' name='postSelection' id='postSelection' value='".$_POST['postSelection']."' />\n");
		echo("</form>\n");
	}

	else {
		
		echo("<form name='updatePost' method='post'>\n");
		echo("<p>Select the post you wish to delete from the list below:</p>\n");
		echo($blogTools->renderPostList());
		echo("<input type='submit' name='submit' id='submit' value='Delete Post'/>\n");
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

