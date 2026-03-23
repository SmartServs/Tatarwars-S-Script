<?php
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" ); 
class GPage extends defaultpage
{

    public function GPage( )
    {
        parent::defaultpage( );
        $this->viewFile = "supportc.phtml";
        $this->contentCssClass = "plus";

          $this->layoutViewFile = "layout".DIRECTORY_SEPARATOR."form.phtml";

    }

}


$p = new GPage( );
$p->run( );
?>