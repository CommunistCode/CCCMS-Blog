<html>

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

		<title><?php echo($title); ?> : Blog</title>

    <link href="../themes/<?php echo($pageTools->getTheme("base")); ?>/stylesheets/cssReset.css" rel="stylesheet" />
    <link href="../themes/<?php echo($pageTools->getTheme("base")); ?>/stylesheets/base.css" rel="stylesheet" />
		<link href="themes/<?php echo($pageTools->getTheme("blog")); ?>/stylesheets/blogStyle.css" rel="stylesheet" />

	</head>

	<body>

		<div id="mainContainer">

			<div id="title">

				<?php 
					require_once($fullPath."/themes/".$pageTools->getTheme("base")."/templates/title.inc.php"); 
  			?>
			</div>
	
  		<div id='navBar'>
	
  			<?php 
					require_once($fullPath."/themes/".$pageTools->getTheme("base")."/templates/links.inc.php"); 
				?>
	
  		</div>

			<div id='bodyContainer'>

				<div class='blogLinks'>

					<?php
						require_once($fullPath."/blog/includes/blogLinks.inc.php");
					?>

				</div>
	
				<div class="blogBody">
		
					<h1>
						<?php echo($heading); ?>
					</h1>	

					<?php 
	
						if (isset($content)) {
								
								echo($content);					

						}

						if (isset($include)) {

							include($include);

						}

					?>

				</div>

			</div>

   	</div>

		<div id="footer">
		
   		<?php 
				require_once($fullPath."/themes/".$pageTools->getTheme("base")."/templates/footer.inc.php"); 
			?>
	
	
  	</div>
	
  </body>

</html>
