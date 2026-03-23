<?php


require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php");


class GPage extends SecureGamePage

{



        function __construct(){

                parent::__construct();

                $this->viewFile = "copsys.phtml";

                $this->contentCssClass = "forum";

        }

        function load()

                {

           parent::load();



                }

}

$p = new GPage();

$p->run();
?> 