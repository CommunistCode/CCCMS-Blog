<html>

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

		<title><?php echo(SITE_NAME." : ".$_title); ?></title>

    <link href="../base/themes/<?php echo($_pageTools->getTheme("base")); ?>/stylesheets/cssReset.css" rel="stylesheet" />
    <link href="../base/themes/<?php echo($_pageTools->getTheme("base")); ?>/stylesheets/base.css" rel="stylesheet" />
    <link href="../base/themes/<?php echo($_pageTools->getTheme("base")); ?>/stylesheets/extendedBase.css" rel="stylesheet" />
    <link href="../base/themes/<?php echo($_pageTools->getTheme("base")); ?>/stylesheets/matchTags.css" rel="stylesheet" />

    <link href="themes/<?php echo($_pageTools->getTheme("blog")); ?>/stylesheets/blogStyle.css" rel="stylesheet" />

	</head>

	<body>

		<div id="mainContainer" class='faux'>

			<div id="title">

				<?php 
					require_once(FULL_PATH."/base/themes/".$_pageTools->getTheme("base")."/templates/title.inc.php"); 
  			?>
			</div>
	
  		<div id='navBar'>
	
  			<?php 
					require_once(FULL_PATH."/base/themes/".$_pageTools->getTheme("base")."/templates/links.inc.php"); 
				?>
	
  		</div>
      
      <div class='clear'></div>

			<div id='body'>

				<div class='sidebar'>

					<?php
						require_once(FULL_PATH."/blog/includes/blogLinks.inc.php");
					?>

				</div>
	
				<div class="sideBody">
		
					<h1>
						<?php echo($_heading); ?>
					</h1>	

					<?php 
	
						if (isset($_content)) {
								
								echo($_content);					

						}

						if (isset($_include)) {

							include($_include);

						}

					?>

				</div>

			</div>
      
      <div class='push'></div>

   	</div>

		<div id="footer">
		
   		<?php 
				require_once(FULL_PATH."/base/themes/".$_pageTools->getTheme("base")."/templates/footer.inc.php"); 
			?>
	
	
  	</div>
	
  </body>

</html>
