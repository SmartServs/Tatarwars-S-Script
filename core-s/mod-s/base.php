<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
####################################################

require( LIB_PATH."mysql.php" );
class ModelBase extends MysqlModel
{

    public function ModelBase()
    {
        parent::mysqlmodel();
        $this->provider->debug = FALSE;
        $this->provider->properties = $GLOBALS['AppConfig']['db'];
    }

}

?>
