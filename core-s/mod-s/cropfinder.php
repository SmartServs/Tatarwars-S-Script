<?php
########################################################################
##   Ab-9@Live.com    &&   Abdullah AL-Qadeeri    &&   TatarWar 2.1   ##
########################################################################
class modelCropfinder extends ModelBase{
    public function getVillagefarmfinder(){
        return $this->provider->fetchResultSet( "SELECT v.rel_x, v.rel_y, v.image_num, v.player_name, v.id FROM p_villages v where v.is_oasis=1");
    }
	
	public function num_oasis_farm($id){
        return $this->provider->fetchScalar( "SELECT tvq FROM p_players p where p.id=%s", array($id) );
    }
	
	public function up_oasis_farm($playerId){
        $this->provider->executeQuery( "UPDATE p_players p SET p.gold_num=p.gold_num-150, p.tvq=p.tvq+50 WHERE p.id=%s", array( $playerId ) );
    }

	

}
?>