<?php

  require_once($fullPath."/membership/classes/memberTools.class.php");

  $dateCreated = date("F j, Y (H:m)", $blogArray['dateCreated']);

  $blogBody = $pageTools->matchTags($blogArray['body']);

?>

<table class='blogTable'>
  
  <tr>
    <td><h1><a href='blogPost.php?blogPostID=<?php echo($blogArray['blogPostID']); ?>'><?php echo($blogArray['title']); ?></a></h1></td>
    <td><h2><i>Posted by:</i> <strong><?php echo($blogArray['adminUser']); ?></strong></h2></td>
  </tr>
          
  <tr>
    <td class='date'><h3><?php echo($dateCreated); ?><h3></td>
  </tr>
    
  <tr>  
    <td colspan=2><div class='blogText'><?php echo($blogBody); ?></div></td>
  </tr>

</table>

<form method='post' action='blogPost.php?blogPostID=<?php echo($_GET['blogPostID']); ?>'>

  <input type='hidden' name='blogPostID' value="<?php echo($_GET['blogPostID']); ?>" />

  <table class='blogTable'>

    <tr>
      <td><h3>Post Comment:</h3></td>
    </tr>

    <tr>
      <td colspan=2><textarea class='commentTextarea' name='comment'>Make a comment on this blog post!</textarea></td>
    </tr>

    <tr>
      <td></td>
      <td class='commentButton'><input name='submitComment' type='submit' value='Post Comment' /></td>
    </tr>
        
  </table>

</form>

<?php

  $memberTools = new memberTools();

  $commentsArray = $blogTools->getComments(0,0,$_GET['blogPostID']);

  if (count($commentsArray) == 0) {

     echo("<div class='blogComment'>");
      echo("<td colspan=2>There have been no comments posted yet!</td>");
    echo("</div>");

  } else {

    foreach($commentsArray as $comment) {
  
      $username = "Anonymous";
      $datePosted = date("d M y, G:i",$comment['commentDate']);

      if ($comment['memberID'] != -1) {

        $username = $memberTools->getUsername($comment['memberID']);

      }

      echo("<div class='blogComment'>");
        echo("<div class='date'>".$datePosted."<br />");
        echo("<div class='poster'>".$username."</div></div>");
        echo("<div class='comment'>".$comment['commentText']."</div>");
        echo("<div class='clear'></div>");
      echo("</div>");

    }

  }

?>
