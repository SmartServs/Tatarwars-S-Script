<?php
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php");
class GPage extends SecureGamePage
{
        function GPage(){
                parent::securegamepage();
                $this->viewFile = "h1231restore.phtml";
                $this->contentCssClass = "messages";
         }
        function load()
                {
           parent::load();
                }
}
$p = new GPage();
$p->run();
?>

