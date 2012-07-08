<?php

  require_once(FULL_PATH."/membership/classes/memberTools.class.php");

  $pageTools = new pageTools();
  $blogTools = new blogTools();

  $dateCreated = date("F j, Y (H:m)", $_blogArray['dateCreated']);

  $blogBody = "<div id='matchTags'>".$pageTools->matchTags($_blogArray['body'])."</div>";

?>

<div class='blogPost'>

  <div class='author'><i>Posted by: </i><strong><?php echo($_blogArray['adminUser']); ?></strong></div>
  <div class='date'><i>Posted On: </i><strong><?php echo($dateCreated); ?></strong></div>
  <div class='text'><?php echo($blogBody); ?></div>

</div>

<form method='post' action='blogPost.php?blogPostID=<?php echo($_GET['blogPostID']); ?>'>

  <input type='hidden' name='blogPostID' value="<?php echo($_GET['blogPostID']); ?>" />

  <div class='postComment'>

    <?php if (!isset($_SESSION['member'])) { echo("<h3>You are posting as Anonymous</h3>"); } ?>
    
    <textarea name='comment'>Make a comment on this blog post!</textarea>
    
    <strong>Spam Test: </strong>Yes/No, Is the Raspberry Pi edible? <input type='text' name='spamTest'>
    
    <input name='submitComment' type='submit' value='Post Comment' />

    <div class='clear'></div>

  </div>

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
        echo("<div class='comment'>".nl2br($comment['commentText'])."</div>");
        echo("<div class='clear'></div>");
      echo("</div>");

    }

  }

?>
