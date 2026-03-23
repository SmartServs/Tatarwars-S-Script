<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php");

class GPage extends SecureGamePage

{



        function GPage(){

                parent::securegamepage();

                $this->viewFile = "banned.phtml";

                $this->contentCssClass = "messages";

                $this->Playerblocked = FALSE;

        }

        function load()

                {

           parent::load();

                }

}

$p = new GPage();

$p->run();

?>

