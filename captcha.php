<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
session_start();
$rand_num = rand(1000000,9999999); 
$rand_new = substr($rand_num,0,4); 
$img = imagecreate(35, 20); 
$img_color = imagecolorallocate($img, 255, 255, 255); 
$textcolor = imagecolorallocate($img, 00, 000, 000); 
imagestring($img, 4, 0, 0, $rand_new, $textcolor); 
header("Content-type: image/jpeg"); 
imagejpeg($img);   
$_SESSION['cap_sess'] = $rand_new;   
?>
