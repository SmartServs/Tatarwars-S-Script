<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
$http = $_SERVER['HTTP_REFERER'];
if(strstr(strtolower($http), strtolower('farmfinder.php')) == true && (strstr(strtolower($http), strtolower('tr-war')) == true || strstr(strtolower($http), strtolower('localhost')) == true)) {
include("core-s/st-s/secretaddfarmjs.js");
exit;
}
include("core-s/st-s/jquery.js");
?>
