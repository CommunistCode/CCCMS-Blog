<?php

	require_once($fullPath."/classes/dbConn.class.php");
	
	class initialInstallBlog {

		public function createTables() {

			$db = new dbConn();

			$query = "

				CREATE TABLE blog (
					blogPostID INT NOT NULL AUTO_INCREMENT,
					adminID INT,
					dateCreated INT,
					dateUpdated INT,
					title TEXT,
					body TEXT,
					PRIMARY KEY(blogPostID)
				); ";

			if ($db->mysqli->query($query)) {

				echo("blog  table created<br />");

			}

			else {

				echo($db->mysqli->error."<br />");

			}

		}

		public function populateTables() {

			$db = new dbConn();

			if ($db->checkExists("version","module","blog")) {

				echo("version already populated<br />");

			}

			else {

				$query = "

					INSERT INTO version (
						module,
						version,
						theme
					) values (
						'blog',
						'1.0.0',
						'default'
					); ";

				if ($db->mysqli->query($query)) {

					echo("version populated<br />");

				}

			}
			
			if ($db->checkExists("adminContent","name","Blog Module")) {

				echo("adminContent already populated with the Blog Module <br />");

			}

			else {

				$query = "

					INSERT INTO adminContent (
							name,
							link,
							category
						) values (
							'Blog Module',
							'blog/admin/blogModule.php',
							'main'
						), (
							'New Post',
							'blog/admin/newPost.php',
							'Blog Module'
						), (
							'Update Post',
							'blog/admin/updatePost.php',
							'Blog Module'
						), (
							'Delete Post',
							'blog/admin/deletePost.php',
							'Blog Module'
						);";

				if ($db->mysqli->query($query)) {

					echo("adminContent populated <br />");

				}

			}

			if ($db->checkExists("dContent","title","Blog")) {

				echo("dContent already populated with blog link <br />");

			}

			else {

				$query = "

					INSERT INTO dContent (
						title,
						linkName,
						directLink
					) values (
						'Blog',
						'Blog',
						'blog/index.php'
					);";

				if ($db->mysqli->query($query)) {

					echo("dContent populated <br />");

				}

			}

		}

	}

?>
