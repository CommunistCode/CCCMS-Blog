<?php 

	require_once("../../config/config.php");
	require_once($fullPath."/blog/classes/blogTools.class.php");
	require_once($fullPath."/admin/includes/global.inc.php");
	require_once($fullPath."/admin/includes/checkLogin.inc.php");

	$blogTools = new blogTools();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Admin Area - New Blog Post</title>
		<link href="<?php echo($directoryPath); ?>/admin/stylesheet/stylesheet.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="mainContainer">
			<div id="title">
				<?php require_once($fullPath."/admin/includes/title.inc.php"); ?>
			</div>
			<div id="body">
				<h1>New Blog Post</h1>
				<?php

				if (isset($_POST['title'])) {
			
					$title = htmlspecialchars($_POST['title'], ENT_QUOTES);
			
				}

				if (isset($_POST['text'])) {

					$text = htmlspecialchars($_POST['text'], ENT_QUOTES);

				}
				
				if (isset($_POST['newPost'])) {

					echo("<p><strong>Preview</strong></p>\n");
					echo("<table>\n");
					echo("<tr>\n");
					echo("<td>".$title."</td>\n");
					echo("</tr>\n");
					echo("<tr>\n");
					echo("<td>".$text."</td>\n");
					echo("</tr>\n");
					echo("</table>\n");
					echo("<form method='post' action='newPost.php' name='editPost'>\n");
					echo("<input type='hidden' name='title' value='".$title."'/>\n");
					echo("<input type='hidden' name='text' value='".$text."'/>\n");
					echo("<br/><br/><input type='submit' name='editPost' id='editPost' value='Edit' />\n");
					echo("</form>\n");
					echo("<form method='post' action='newPost.php' name='publishPage'>\n");
					echo("<input type='hidden' name='title' value='".$title."'/>\n");
					echo("<input type='hidden' name='text' value='".$text."'/>\n");
					echo("<input type='submit' name='publishPost' id='publishPost' value='Publish' />\n");
					echo("</form>\n");
				}
				else if (isset($_POST['publishPost'])) {
					
					echo($blogTools->newPost($title,$text));
					
				}
				else if (isset($_POST['editPost'])) {
					echo("<p>You are creating a <strong>new</strong> blog post.</p>\n");
					
					require_once($fullPath."/admin/includes/showTags.inc.php");
				
					echo("<form method='post' action='newPost.php' name='newPost'>\n");
					echo("<table>\n");
					echo("<tr>\n");
					echo("<td width='100'>Title</td>\n");
					echo("<td><input type='text' name='title' value='".$title."' size='61'/></td>\n");
					echo("</tr>\n");
					echo("<tr>\n");
					echo("<td>Text</td>\n");
					echo("<td><textarea rows='30' cols='70' name='text'>".$text."</textarea></td>\n");
					echo("</tr>\n");
					echo("<tr>\n");
					echo("<td></td>\n");
					echo("<td><br /><input type='submit' name='newPost' id='newPage' value='Preview Post' /></td>\n");
					echo("</tr>\n");
					echo("</table>\n");
					echo("</form>\n");
				}
				else {
					echo("<p>You are creating a <strong>new</strong> blog post.</p>\n");
					
					require_once($fullPath."/admin/includes/showTags.inc.php");
					
					echo("<form method='post' action='newPost.php' name='newPost'>\n");
					echo("<table>\n");
					echo("<tr>\n");
					echo("<td width='100'>Title</td>\n");
					echo("<td><input type='text' name='title' value='title' size='61'/></td>\n");
					echo("</tr>\n");
					echo("<tr>\n");
					echo("<td>Text</td>\n");
					echo("<td><textarea rows='30' cols='70' name='text'>text</textarea></td>\n");
					echo("</tr>\n");
					echo("<tr>\n");
					echo("<td></td>\n");
					echo("<td><br /><input type='submit' name='newPost' id='newPost' value='Preview Post' /></td>\n");
					echo("</tr>\n");
					echo("</table>\n");
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
					require_once($fullPath."/admin/includes/adminLinks.inc.php"); ?>
			</div>
			<div id="footer">
				<?php require_once($fullPath."/admin/includes/footer.inc.php"); ?>
			</div>
		</div>
	</body>
</html>
