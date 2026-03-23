<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
require_once( MODEL_PATH."over.php" );
require_once( MODEL_PATH."index.php" );
class GPage extends ProcessVillagePage{

    public $playerData = NULL;

        public function GPage(){
                parent::processvillagepage( );
        $this->viewFile = "over.phtml";
        $this->contentCssClass = "messages";
    }

    public function load( )
    {
        parent::load( );
        if ( !$this->globalModel->isGameOver( ) )
        {
            exit( 0 );
        }
        else
        {
            $m = new OverGameModel( );
            $this->playerData = $m->getWinnerPlayer( );
            $this->TopOff = $m->getTopsAttacker( );
            $this->TopDef = $m->getTopsDeffer( );
            $this->TopPop = $m->getTopsPop( );
            $this->TopHero = $m->getTopsHero( );
            $m->dispose( );
                $m = new IndexModel();
                $this->datas = $m->getIndexSummary();
        }
    }

}


$p = new GPage( );
$p->run( );
?>
