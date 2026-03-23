<?php
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
require_once( MODEL_PATH."ggold.php" );
class GPage  extends securegamepage
{

    public $saved = NULL;
    public $siteNews = NULL;

    public function GPage( )
    {
        parent::securegamepage( );
        $this->viewFile = "ggold.phtml";
        $this->contentCssClass = "reports";
    }

    public function load( )
    {
      $this->selectedTabIndex = !$this->player->isAgent && isset( $_GET['t'] ) && is_numeric( $_GET['t'] ) && 0 <= intval( $_GET['t'] ) && intval( $_GET['t'] ) <= 4 ? intval( $_GET['t'] ) : 0;
                if ( $this->selectedTabIndex == 4 && $this->data['player_type'] == PLAYERTYPE_TATAR )
                {
                    $this->selectedTabIndex = 0;
                }
        parent::load( );
        if ( $this->data['player_type'] != PLAYERTYPE_ADMIN )
        {
            exit( 0 );
        }
        else
        {
            $m = new NewsModel( );
            $this->saved = FALSE;
            if ( $this->isPost( ) && isset( $_POST['news'] ) )
            {
                $this->siteNews = $_POST['news'];
                $this->saved = TRUE;
                $m->setSiteNews( $this->siteNews );
            }
            else
            {
                $this->siteNews = $m->getSiteNews( );
            }
            $m->dispose( );
        }
    }

}


$p = new GPage( );
$p->run( );
?>