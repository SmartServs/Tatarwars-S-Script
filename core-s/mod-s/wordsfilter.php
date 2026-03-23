<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
####################################################

class FilterWordsModel extends ModelBase
{
public function FilterWords( $text = "", $replace = "*" )
{
$patterns = array( "/([A-Z0-9._%+-]+)@([A-Z0-9.-]+)\\.([A-Z]{2,4})(\\((.+?)\\))?/i", "/\\b(?:(?:https?|ftp):\\/\\/|www\\.)[-a-z0-9+&@#\\/%?=~_|!:,.;]*[-a-z0-9+&@#\\/%=~_|]/i" );
foreach ( $GLOBALS['AppConfig']['system']['words'] as $sword )
{
$patterns[] = sprintf( "/(?<!\\pL)(%s)(?!\\pL)/u", $sword['name'] );
}
return  $textnew = preg_replace( $patterns, $replace, $text );
}
}

?>