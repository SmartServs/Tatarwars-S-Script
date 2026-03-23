<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
error_reporting(0);
set_time_limit(0);

define( "ROOT_PATH", realpath( dirname( dirname( __FILE__ ) ) ).DIRECTORY_SEPARATOR );
define( "APP_PATH", ROOT_PATH."core-s".DIRECTORY_SEPARATOR );
define( "LIB_PATH", ROOT_PATH."core-s/sql-s".DIRECTORY_SEPARATOR );
define( "MODEL_PATH", APP_PATH."mod-s".DIRECTORY_SEPARATOR );
define( "VIEW_PATH", APP_PATH."ph-s".DIRECTORY_SEPARATOR );
@set_magic_quotes_runtime( FALSE );
if ( isset( $_SERVER['HTTP_ACCEPT_ENCODING'] ) && substr_count( $_SERVER['HTTP_ACCEPT_ENCODING'], "gzip" ) )
{
    ob_implicit_flush( 0 );
    if ( @ob_start( array( "ob_gzhandler", 9 ) ) )
    {
        header( "Content-Encoding: gzip" );
    }
}
///shadi


// start corn job alq0rsan
$ifile = "core-s/mod-s/smart/cornjob.txt";
if(!file_exists($ifile))
{
$ifile=fopen($ifile, "w");fclose($ifile);
} else {
if(filectime($ifile) >= 5)
{
unlink($ifile);
$dir = 'core-s/mod-s/smart/qqw/'; 
foreach(glob($dir.'*') as $v){ 
$last_modified = filectime($v);
$fm[$v] = filectime($v);
}
if(isset($fm) && count($fm)>0)
{
asort($fm);
$k = 0;
foreach($fm as $key => $value)
{
$k++;
if ($k <= 5) {
if(time()-$value >= 5) {
unlink($key);
}
}
}
}
}
}
header( "Date: ".gmdate( "D, d M Y H:i:s" )." GMT" );
header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
require( APP_PATH."conf-s/tcex-con.php" );
require( LIB_PATH."webservice.php" );
require( LIB_PATH."medals.php" );
require( LIB_PATH."widget.php" );
require( LIB_PATH."webhelper.php" );
require( APP_PATH."metadata.php" );
require( MODEL_PATH."base.php" );
require( APP_PATH."components.php" );
require( APP_PATH."mywidgets.php" );
$cookie = ClientData::getinstance( );
$AppConfig['system']['lang'] = "ar";
define( "LANG_PATH", APP_PATH."lang".DIRECTORY_SEPARATOR.$AppConfig['system']['lang'].DIRECTORY_SEPARATOR );
require( LANG_PATH."lang.php" );
$tempdata = explode( " ", microtime( ) );
$data1 = $tempdata[0];
$data2 = $tempdata[1];
$__scriptStart = ( double )$data1 + ( double )$data2;
if($_GET)
{
        foreach($_GET as $key=>$value)
        {
            if(is_array($_GET[$key]))
            {
                   array_map('protect',$_GET[$key]);
            }
            else
            {
                  $_GET[$key] = stripslashes(htmlspecialchars(addslashes(html_entity_decode(trim($value),UTF-8))));
            }
        }
}
?>
