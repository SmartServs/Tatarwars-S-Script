<?php

require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
class GPage extends SecureGamePage
{

    public $packageIndex = -1;
    public $plusTable = NULL;

    public function GPage( )
    {
        parent::securegamepage( );
        $this->viewFile = "last10.phtml";
        $this->contentCssClass = "plus";
        
    }

    public function load( )
    {
        parent::load( );
       
    }

    

}

$p = new GPage( );
$p->run( );
?>
