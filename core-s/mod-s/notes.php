<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
####################################################

class NotesModel extends ModelBase{

        public function changePlayerNotes($playerId, $notes){
                $this->provider->executeQuery( "UPDATE p_players p SET p.notes='%s' WHERE p.id=%s", array( $notes, $playerId ) );
        }
}
?>
