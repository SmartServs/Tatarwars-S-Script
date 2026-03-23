<?php
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php");
require_once(MODEL_PATH."index.php");
class GPage extends DefaultPage{

        public $data = NULL;
        public $error = NULL;
        public $errorState = -1;
        public $name = NULL;
        public $password = NULL;

        public function GPage(){
                parent::defaultpage();
                $this->viewFile = "priv.phtml";
                $this->layoutViewFile = "layout".DIRECTORY_SEPARATOR."form.phtml";
                $this->contentCssClass = "login";
                }

}
$p = new GPage();
$p->run();
?>
