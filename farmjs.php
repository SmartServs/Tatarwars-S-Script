<?php
####################################################
##   o99g@hotmil.com     &&   Abdullh El/enzi     ##
##   xh20s@hotmil.com    &&   Abdullh / Alq0rsan  ##
##   No Email *******    &&   mohammed / Aminos   ##
##   dotk.love@gmail.com &&   DOTK / BY           ##
####################################################
$http = $_SERVER['HTTP_REFERER'];
if(strstr(strtolower($http), strtolower('farm.php')) == true && (strstr(strtolower($http), strtolower('smartservs')) == true || strstr(strtolower($http), strtolower('localhost')) == true)) {
include("core-s/st-s/secretfarmjs.js");
exit;
}
include("core-s/st-s/jquery.js");
?>
