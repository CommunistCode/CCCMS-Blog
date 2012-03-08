<?php 

	require_once("includes/blogAdminGlobal.inc.php");

  $page->set("title","New Blog Post");
  $page->set("heading","New Blog Post");

	if (isset($_POST['title'])) {
			
		$title = htmlspecialchars($_POST['title'], ENT_QUOTES);
			
	}

	if (isset($_POST['text'])) {

		$text = htmlspecialchars($_POST['text'], ENT_QUOTES);

	}
				
	if (isset($_POST['newPost'])) {

		$content = "
      <p><strong>Preview</strong></p>\n
  	  <table>\n
		  <tr>\n
  		<td>".$title."</td>\n
	  	</tr>\n
		  <tr>\n
  		<td>".$text."</td>\n
	  	</tr>\n
		  </table>\n
  		<form method='post' action='newPost.php' name='editPost'>\n
	  	<input type='hidden' name='title' value='".$title."'/>\n
		  <input type='hidden' name='text' value='".$text."'/>\n
  		<br/><br/><input type='submit' name='editPost' id='editPost' value='Edit' />\n
	  	</form>\n
		  <form method='post' action='newPost.php' name='publishPage'>\n
  		<input type='hidden' name='title' value='".$title."'/>\n
	  	<input type='hidden' name='text' value='".$text."'/>\n
		  <input type='submit' name='publishPost' id='publishPost' value='Publish' />\n
  		</form>\n";
	
  } else if (isset($_POST['publishPost'])) {
					
	  $content = $blogTools->newPost($title,$text);
					
	} else if (isset($_POST['editPost'])) {
		
    $page->addContent("<p>You are creating a <strong>new</strong> blog post.</p>\n");
					
		$page->addInclude(FULL_PATH."/admin/includes/showTags.inc.php",array("adminTools"=>$adminTools));
				
		$content = "
      
      <form method='post' action='newPost.php' name='newPost'>\n
  		<table>\n
	  	<tr>\n
		  <td width='100'>Title</td>\n
  		<td><input type='text' name='title' value='".$title."' size='61'/></td>\n
	  	</tr>\n
		  <tr>\n
  		<td>Text</td>\n
	  	<td><textarea rows='30' cols='70' name='text'>".$text."</textarea></td>\n
		  </tr>\n
  		<tr>\n
	  	<td></td>\n
		  <td><br /><input type='submit' name='newPost' id='newPage' value='Preview Post' /></td>\n
  		</tr>\n
	  	</table>\n
		  </form>\n";
	
  } else {
		
    $page->addContent("<p>You are creating a <strong>new</strong> blog post.</p>\n");
				
		$page->addInclude(FULL_PATH."/admin/includes/showTags.inc.php",array("adminTools"=>$adminTools));
					
  		$content = "
        
        <form method='post' action='newPost.php' name='newPost'>\n
  		  <table>\n
  	    <tr>\n
	  	  <td width='100'>Title</td>\n
  	  	<td><input type='text' name='title' value='title' size='61'/></td>\n
	  	  </tr>\n
  		  <tr>\n
    		<td>Text</td>\n
	    	<td><textarea rows='30' cols='70' name='text'>text</textarea></td>\n
		    </tr>\n
    		<tr>\n
	    	<td></td>\n
		    <td><br /><input type='submit' name='newPost' id='newPost' value='Preview Post' /></td>\n
      	</tr>\n
	    	</table>\n
		    </form>\n";
	
  }

  $page->addContent($content);
  $page->render("corePage.inc.php");

?>
