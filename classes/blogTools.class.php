<?php

  class blogTools {

    private $pdoConn;

    function __construct() {

      $this->pdoConn = new pdoConn();

    }

    public function getComments($start,$limit,$blogPostID) {

      $fields = array("memberID","commentText","commentDate");
      $table = "blog_comments";
      
      $where[0]['column'] = "blogPostID";
      $where[0]['value'] = $blogPostID;

      $orderBy="commentDate DESC";

      $result = $this->pdoConn->select($fields,$table,$where,$orderBy);

      return $result;

    }

    public function newComment($blogPostID, $commentText) {

      $db = new dbConn();

      if (isset($_SESSION['member'])) {

        $member = unserialize($_SESSION['member']);
        $memberID = $member->getID();

      } else {

        $memberID = -1;

      } 

      $table = "blog_comments";

      $insertArray[0]['field'] = "memberID";
      $insertArray[0]['value'] = $memberID;

      $insertArray[1]['field'] = "commentText";
      $insertArray[1]['value'] = $commentText;

      $insertArray[2]['field'] = "blogPostID";
      $insertArray[2]['value'] = $blogPostID;

      $insertArray[3]['field'] = "commentDate";
      $insertArray[3]['value'] = time();

      $result = $this->pdoConn->insert($table,$insertArray);

      if (!$result) {

        return 1;
    
      }

      return;

    }

    public function newPost($title, $body) {

      $db = new dbConn();

      $title = addslashes($title);
      $body = addslashes($body);

      $admin = unserialize($_SESSION['admin']);

      if($db->insert( "blog_posts",
                      "adminID,dateCreated,title,body",
                      "".$admin->getID().",".time().",'".$title."','".$body."'",
                      0
                    )) {

        return "<p>New post was created sucessfully!</p>";

      }
      else {

        return "<p>Post could not be created! ".$db->mysqli->error."</p>";

      }

    }

    public function getBlogPost($blogPostID) {

      $fields = array("aU.adminUser","title","body","dateCreated","b.blogPostID");
      $tables = array("adminUsers aU","blog_posts b");

      $where[0]['column'] = "blogPostID";
      $where[0]['value'] = $blogPostID;

      $result = $this->pdoConn->select($fields,$tables,$where);

      return $result[0];

    }

    public function renderLatestPosts($limit, $charLimit = 200) {

      $field = "blogPostID";
      $table = "blog_posts";
      $orderBy = "dateCreated DESC";
      $limit = $limit;

      $latestPosts = $this->pdoConn->select($field,$table,NULL,$orderBy,$limit);  
    
      if(count($latestPosts) == 0) {

        return "<br />No blog posts created yet!<br />";

      }

      else {

        $output = ""; 
        
        foreach($latestPosts as $row) {

          $blogPost = $this->getBlogPost($row['blogPostID']);

          $output .= $this->renderBlogPost($blogPost, $charLimit);

        }

        return $output;

      }

    }

    public function renderBlogPost($blogArray, $limit = NULL) {

      $pageTools = new pageTools();

      $dateCreated = date("F j, Y (H:m)", $blogArray['dateCreated']); 
    
      $blogBody = stripslashes($blogArray['body']);
      
      if ($limit != NULL) {

        $blogLength = strlen($blogBody);
        $blogBodyOriginal = $blogBody;

        $blogBody = substr($blogBody, 0 ,$limit);

        if ($blogLength > $limit) {
      
          if (substr($blogBodyOriginal,$limit,1) == " ") {

            $blogBody .= " ";

          }

          $blogBody .= "<a href='blogPost.php?blogPostID=".$blogArray['blogPostID']."'>&hellip; </a>";

        }

      }

      $blogBody = $pageTools->matchTags($blogBody);

      $string = <<<EOD

<div class='blogPreview'>
  <div class='heading'>
    <div class='left'>
      <a class='linkHeader' href='blogPost.php?blogPostID={$blogArray['blogPostID']}'>{$blogArray['title']}</a>
    </div>
    <div class='right'>
      <h2><i>Posted by:</i> <strong>{$blogArray['adminUser']}</strong></h2>
      <h3>{$dateCreated}</h3></td>
    </div>
  </div>
  <div class='clear'></div>
  <div class='text'>
    <p>{$blogBody}</p>
  </div>
</div>

EOD;

      return $string;

    }

    public function renderDateLinks($numMonths) {

      $nextMonth = date("n",time()) + 1;
      $currentYear = date("Y",time());

      $dateLinksHTML = "<ul>";

      for($i=1; $i<=$numMonths; $i++) {
  
        $monthTime = mktime(0,0,0,$nextMonth,1,$currentYear);
        $originalMonth = date("F", mktime(0,0,0,($nextMonth-1),1,$currentYear));
        
        if ($nextMonth == 1) {

          $nextMonth = 12;
          $currentYear--;

        } else {

          $nextMonth--;

        }

        $previousMonth = mktime(0,0,0,$nextMonth,1,$currentYear);

        $field = "COUNT(*) as postCount";
        $table = "blog_posts";

        $where[0]['column'] = "dateCreated";
        $where[0]['operator'] = ">";
        $where[0]['value'] = $previousMonth;

        $where[1]['column'] = "dateCreated";
        $where[1]['operator'] = "<=";
        $where[1]['value'] = $monthTime;

        $result = $this->pdoConn->select($field,$table,$where);
      
        foreach($result as $row) {

          $dateLinksHTML .= "<li><a href=''>".$originalMonth." (".$row['postCount'].")</a></li>";

        }

      }

      $dateLinksHTML .= "</ul>";

      echo($dateLinksHTML);

    }

    public function renderPostList() {

      $fields = array("blogPostID","title");
      $table = "blog_posts";
      $orderBy = "dateCreated DESC";

      $result = $this->pdoConn->select($fields,$table,NULL,$orderBy);

      $render = "<select name='postSelection'>\n";

      foreach($result as $resultArray) {

        $render .= "<option value='".$resultArray['blogPostID']."'>".$resultArray['title']."</option>\n";

      }

      $render .= "</select>\n";

      return $render;

    }

    public function getPostContent($postID) {

      $fields = array("title","body");
      $table = "blog_posts";
      
      $where[0]['column'] = "blogPostID";
      $where[0]['value'] = $postID;

      $result = $this->pdoConn->select($fields,$table,$where);

      return $result[0];

    }

    public function updatePost($postID,$title,$body) {

      $table = "blog_posts";
      
      $set[0]['column'] = "title";
      $set[0]['value'] = $title;

      $set[1]['column'] = "body";
      $set[1]['value'] = $body;

      $set[2]['column'] = "dateUpdated";
      $set[2]['value'] = time();

      $where[0]['column'] = "blogPostID";
      $where[0]['value'] = $postID;

      $updateReturn = $this->pdoConn->update($table,$set,$where);
      
      return $updateReturn['error'];

    }

    public function deletePost($postID) {

      $db = new dbConn();

      return $db->delete("blog_posts","blogPostID=".$postID."",0);

    }

  }

?>
