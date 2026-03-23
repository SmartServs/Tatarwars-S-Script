<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
####################################################

class LinksModel extends ModelBase
{

    public function changePlayerLinks( $playerId, $links )
    {
        $this->provider->executeQuery( "UPDATE p_players p SET p.custom_links='%s' WHERE p.id=%s", array(
            $links,
            $playerId
        ) );
    }

}

?>
