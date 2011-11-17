<?php

	require_once($fullPath.'/classes/dbConn.class.php');

	class blogTools {

		public function newPost($title, $body) {

			$db = new dbConn();

			$title = addslashes($title);
			$body = addslashes($body);

			$admin = unserialize($_SESSION['admin']);

			if($db->insert(	"blog",
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

			$db = new dbConn();

			$result = $db->selectWhere("adminUsers.adminUser, title, body, dateCreated, blog.blogPostID","adminUsers, blog", "blogPostID=".$blogPostID." and blog.adminID = adminUsers.adminID",0);

			$row = $result->fetch_assoc();
			
			return $row;

		}

		public function renderLatestPosts($limit, $charLimit = 200) {

			$db = new dbConn();

			$latestPosts = $db->mysqli->query("SELECT blogPostID FROM blog ORDER BY dateCreated DESC LIMIT ".$limit);	
		
			if(!$latestPosts) {

				return "No blog posts created yet!<br />";

			}

			else {

				$output = "";	

				while ($row = $latestPosts->fetch_assoc()) {

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

			<div id='blogPost'>
			  <table width=730>
			    <tr>
			      <td><h1><a href='blogPost.php?blogPostID={$blogArray['blogPostID']}'>{$blogArray['title']}</a></h1></td>
			      <td><h2><i>Posted by:</i> <strong>{$blogArray['adminUser']}</strong></h2></td>
			    </tr>
					<tr>
						<td><h3>{$dateCreated}<h3></td>
					</tr>
				  <tr>
				    <td colspan=2><div class='blogText'>{$blogBody}</div></td>
				  </tr>
				</table>
			</div>

EOD;
			
			return $string;

		}

		public function renderDateLinks($numMonths) {

			$db = new dbConn();

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

				$result = $db->selectWhere('COUNT(*) as "postCount"','blog','dateCreated > '.$previousMonth.' AND dateCreated <= '.$monthTime.'',0);
			
				$row = $result->fetch_assoc();

				$dateLinksHTML .= "<li><a href=''>".$originalMonth." (".$row['postCount'].")</a></li>";

			}

			$dateLinksHTML .= "</ul>";

			echo($dateLinksHTML);

		}

		public function renderPostList() {

			$db = new dbConn();

	    $result = $db->select("blogPostID, title","blog", 0);

	    $render = "<select name='postSelection'>\n";

	    while ($resultArray=$result->fetch_array(MYSQLI_ASSOC)) {

	      $render .= "<option value='".$resultArray['blogPostID']."'>".$resultArray['title']."</option>\n";

	    }

	    $render .= "</select>\n";

	    return $render;

		}

		public function getPostContent($postID) {

			$db = new dbConn();

			$result = $db->selectWhere("title,body","blog","blogPostID=".$postID."",0);

			return $result->fetch_assoc();

		}

		public function updatePost($postID,$title,$body) {

			$db = new dbConn();

			$body = addslashes($body);

			return $db->update("blog","title='".$title."',body='".$body."',dateUpdated=".time()."","blogPostID=".$postID."",0);

		}

		public function deletePost($postID) {

			$db = new dbConn();

			return $db->delete("blog","blogPostID=".$postID."",0);

		}

	}

?>
