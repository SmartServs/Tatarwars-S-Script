<?php

class wingoldModel extends ModelBase{

    public function getwingoldplayerid($id){
	return $this->provider->fetchResultSet( "SELECT * FROM wingold WHERE idplayer='%s' order by id desc", array( $id ) );
    }   
    public function counts($id,$data){
	return $this->provider->fetchScalar( "SELECT COUNT(*) FROM wingold WHERE idplayer=%s AND data = '%s'", array( $id,$data ) );
    }    
    public function geturl($url){
	return $this->provider->fetchRow( "SELECT id FROM wingold WHERE url='%s'", array( $url ) );
    }       	
	public function updatewingoldplayerid ( $idplayer, $url, $approval, $data )
	{
	 $this->provider->executeQuery( "INSERT INTO `wingold` SET `idplayer` = '%s', `url` = '%s', `approval` = '%s', `show` = '0', `data` = '%s'", array( $idplayer, $url, $approval, $data ) );
	}
	
	public function getwingoldAdmin(){
	return $this->provider->fetchResultSet( "SELECT * FROM wingold p WHERE p.show='0'  order by id desc");
    }   
	
	public function getPlayerNameById( $playerId ){
	return $this->provider->fetchRow( "SELECT p.name FROM p_players p WHERE p.id=%s", array( $playerId ) );
	}
	
	public function AddGold( $playerId ){
    $this->provider->executeQuery( "UPDATE p_players p SET p.gold_num=p.gold_num+5 WHERE p.id=%s", array( $playerId ));
    }
	
	public function EndWinGold( $id, $approval){
    $this->provider->executeQuery2( "UPDATE wingold p SET p.approval='%s', p.show='1' WHERE p.id=%s", array( $approval, $id ));
    }
}
?>
