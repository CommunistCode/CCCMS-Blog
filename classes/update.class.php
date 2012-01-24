<?php

  require_once($fullPath."/classes/pdoConn.class.php");
  require_once($fullPath."/classes/dbTools.class.php");
  require_once($fullPath."/classes/versionTools.class.php");

  class updateBlog {

    private $module = "blog";
    private $latestVersion = "1.1.0.";

    private $pdoConn;
    private $dbTools;
    private $vt;

    function __construct() {

      $this->pdoConn = new pdoConn();
      $this->dbTools = new dbTools();
      $this->vt = new versionTools();

    }

    function update() {

      if (!$this->vt->isVersionGreater($this->module,$this->latestVersion)) {

        echo("Already up-to-date at version ".$this->latestVersion."<br />");
        return;

      } else {

        echo("Current version is ".$this->vt->getVersion($this->module)." - updating! <br />");

      }

      if ($this->update_1_1_0()) {

        echo("Not all updates were successful!<br />");

      } else {

        echo("All updates were successful!<br />");

      }

    }

    /********************************************************************
    * Update 1.1.0
    * -------------------------------------------------------------------
    * Create new comments table and alter table names
    ********************************************************************/

    private function update_1_1_0() {

      $version = "1.1.0";

      if (!$this->vt->isVersionGreater($this->module,$version)) {

        return 1;

      }

      $error = 0;

      $query = "ALTER TABLE blog RENAME TO blog_posts";
      $customReturn = $this->pdoConn->customQuery($query);

      if ($customReturn['error'] == 1) {

        echo($customReturn['message']);
        $error = 1;

      }

      $name = "blog_comments";
      
      $column[0]['name'] = "commentID";
      $column[0]['definition'] = "INT AUTO_INCREMENT";

      $column[1]['name'] = "memberID";
      $column[1]['definition'] = "INT";

      $column[2]['name'] = "commentText";
      $column[2]['definition'] = "TEXT";

      $column[3]['name'] = "blogPostID";
      $column[3]['definition'] = "INT";

      $column[4]['name'] = "commentDate";
      $column[4]['definition'] = "INT";

      $primaryKey = "commentID";

      $newTableReturn = $this->dbTools->newTable($name, $column, $primaryKey);

      if ($newTableReturn['error']) {

        $error = 1;

        echo($newTableReturn['message']);

      } else {

        echo("New table ".$name." was successfully created!");

      }

      if (!$error) {

        if ($this->vt->updateVersion($this->module,$version)) {

          echo("<strong>Updated to ".$version."</strong><br />");

        } else {

          $error = 1;

          echo("<strong>Update to ".$version." complete but could
                not update version table!</strong>");

        }

      }

      return $error;

    }

  }

?>
