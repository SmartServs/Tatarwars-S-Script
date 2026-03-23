<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
require_once( MODEL_PATH."adminweb.php" );
class GPage extends ProcessVillagePage{
    public $saved = NULL;
    public $siteNews = NULL;



        public function GPage(){
                parent::processvillagepage( );
$this->viewFile = "shownew.phtml";

        $this->contentCssClass = "messages";

        $this->checkForGlobalMessage = FALSE;

        $this->checkForNewVillage = FALSE;

    }



       public function load()
    {
        parent::load();
        if ( intval( $this->data['new_gnews'] ) == 0 AND intval( $this->data['new_voting'] ) == 0 || $this->player->isSpy ) { $this->redirect( "village1.php" ); exit; }
        else
        {
		$m = new AdminWebModel();
		if(intval( $this->data['new_gnews'] ) == 1){
            $New = $m->getGlobalSiteNews();

            $g1 = "/{playerName}/";

            $g2 = "/{playerId}/";

            $g3 = "/{erngold}/";

            $domain = WebHelper::getdomain();

            $site = "http://".$domain."";

            $link = ''.$site.'register.php?ref='.$this->player->playerId.'';

            $t = preg_replace( $g1, $this->data['name'], $New );

            $t2 = preg_replace( $g3, $link, $t );

            $this->siteNews = preg_replace( $g2, $this->player->playerId, $t2 );
		}else{
		$this->siteNews = $m->getGlobalSitevoting();
		}
            $m->dispose();
        }
    }


}

$p = new GPage();

$p->run();

?>

