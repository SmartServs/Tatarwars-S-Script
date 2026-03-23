<?php

class Payhis extends ModelBase{

    

	public function getPlayerDataByName( $playerName )

    {

        return $this->provider->fetchRow( "SELECT p.id FROM p_players p WHERE p.name='%s'", array(

            $playerName

        ) );

    }

	

	public function getTotalMoney()

    {

        return $this->provider->fetchRow( "SELECT total_gold, total_sms, total_cashu, total_onecard FROM money_total ");

    }

	

	public function PayhisByType( $type )

	{

	    return $this->provider->fetchResultSet("SELECT * FROM money_log WHERE type='%s'", array(

		$type

        ) );

    }

	

	

}

?>