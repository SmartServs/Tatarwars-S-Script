<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
####################################################

class Widget extends WebService
{

    public $viewFile = NULL;
    public $layoutViewFile = NULL;

    public function printContent( )
    {
        require( VIEW_PATH.$this->viewFile );
    }

    public function preRender( )
    {
    }

    public function run( )
    {
        $this->load( );
        $this->preRender( );
        if ( $this->layoutViewFile != NULL )
        {
            require( VIEW_PATH.$this->layoutViewFile );
        }
        else if ( $this->viewFile != NULL )
        {
            require( VIEW_PATH.$this->viewFile );
        }
        $this->unload( );
        unset( $this );
    }

}
?>
