<?php 

	require_once("../../config/config.php");
	require_once($fullPath."/admin/includes/global.inc.php");
	require_once($fullPath."/admin/includes/checkLogin.inc.php");
	require_once($fullPath."/classes/pageTools.class.php");
	require_once($fullPath."/blog/classes/blogTools.class.php");

	$blogTools = new blogTools();
  $pageTools = new pageTools();

  $title = "Admin Area : Update Blog Post";
  $heading = "Update Blog Post";

	if (isset($_POST['updatePost'])) {
				
		if ($blogTools->updatePost($_POST['postSelection'],$_POST['title'],$_POST['text'])) {
			
      $content = "<p><font color='green'>Succesful update!</font></p>";
  
		}
	
  	else {
	
  		$content = "<font color='red'><p>Unsuccesful update!</p></font>";

		}
  
  }	else if (isset($_POST['postSelection'])) {
		
		$pageTools = new pageTools();
		
		$blogPost = $blogTools->getPostContent($_POST['postSelection']);
		
		$tags = include($fullPath."/admin/includes/showTags.inc.php");
	
    $content = $tags;	
		$content .= "<p>Your are currently editing <strong>".$blogPost['title']."</strong></p>\n";
		$content .= "<form method='post' action='updatePost.php' name='editPage'>\n";
		$content .= "<table>\n";
		$content .= "<tr>\n";
		$content .= "<td width='100'>Title</td>\n";
		$content .= "<td><input type='text' name='title' value='".$blogPost['title']."' size='61'/></td>\n";
		$content .= "</tr>\n";
		$content .= "<tr>\n";
		$content .= "<td>Body</td>\n";
		$content .= "<td><textarea rows='30' cols='70' name='text'>".$blogPost['body']."</textarea></td>\n";
		$content .= "</tr>\n";
		$content .= "<tr>\n";
		$content .= "<td></td>\n";
		$content .= "<td><br /><input type='submit' name='updatePost' id='updatePost' value='Update Post' /></td>\n";
		$content .= "</tr>\n";
		$content .= "</table>\n";
		$content .= "<input type='hidden' name='postSelection' id='postSelection' value='".$_POST['postSelection']."' />\n";
		$content .= "</form>\n";
	}

	else {
		
		$content = "<form name='updatePost' method='post'>\n";
		$content .= "<p>Select the post you wish to update from the list below:</p>\n";
		$content .= $blogTools->renderPostList();
		$content .= "<input type='submit' name='submit' id='submit' value='Edit Page'/>\n";
		$content .= "</form>\n";

	}

  require_once($fullPath."/admin/themes/".$pageTools->getTheme("admin")."/templates/corePage.inc.php");

?>
