<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
class cliprz_flood {
    function cliprz_session(){ 
    if (!isset($_SESSION)) { 
    session_start();
        } 
    }
    function cliprz_request(){ 
        if($_SESSION['cliprz_request'] > time() - 5){
            return true;
        }else{
            return false;
        }
    } 
    
    function check_sndlmt(){ 
        if((time() - $_SESSION['msgs_priod'] >  60*1) || ($_SESSION['sent_msgs'] == 0)){
            $_SESSION['msgs_priod'] = time();
            $_SESSION['sent_msgs'] = 0;
        }
        
        if((time() - $_SESSION['msgs_priod'] <  60*1) && ($_SESSION['sent_msgs'] < 10)){
            $_SESSION['sent_msgs']++;
            return false;
        }else{
            return true;
        }
    } 

} 

/* 
include( APP_PATH.'flood.php' );
$cliprz = new cliprz_flood(); 
$cliprz->cliprz_session(); 
$cliprz->cliprz_request();
$_SESSION['cliprz_request'] = time();
*/  

/*exit('<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><center><h2><font color="red"> يتعذر الاتصال (انت تستخدم برامج ضارة بالموقع) شكرا لتفهمكم </font></center></h2>');*/
          // if( $_SESSION['sent_msgs'] > 0)
            //    return true;
          //  else
?>
