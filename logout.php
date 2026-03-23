<?php

####################################################
##   s@smartservs.com     &&   BASEL WAEL         ##
##   admin@smartservs.com    &&   Wael Seif       ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com   ##
####################################################


require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );



class GPage extends securegamepage

{



    public function GPage( )

    {

        parent::securegamepage( );

        $this->viewFile = "logout.phtml";

        $this->contentCssClass = "logout";

    }



    public function load( )

    {

        if ( $this->player->isSpy )

        {

            $gameStatus = $this->player->gameStatus;

            $uid = $this->player->prevPlayerId;

            $this->player = new Player( );

            $this->player->playerId = $uid;

            $this->player->isAgent = FALSE;

            $this->player->gameStatus = $gameStatus;

            $this->player->save( );

            $this->redirect( "village1.php" );

        }

        else

        {

            $this->player->logout( );

			//unset( $FN_5697176['player'] );
			unset($_SESSION);

            $this->player = NULL;

        }

    }



    public function preRender( )

    {

    }



}



$p = new GPage( );

$p->run( );

?>

