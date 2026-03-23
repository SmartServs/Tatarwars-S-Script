<?php
/**
* @   PROJECT WAS MADE FOR TATARZX.COM ON APRIL @2021
* @   WHATS APP : 00966501494220 
* @   VISIT : AR.REDSEA-H.COM
* @   ALL COPY RIGHTS RESERVED PROGRAMMED BY RED SEA HOST 
* @   THIS PROJECT WAS MADE BY THE REGISTERED RED SEA HOST UNDER THE NAME OF WWW.REDSEA-H.COM 
* @   ALL COPY RIGHTS RESERVED TO RED SEA HOST ARABIC 
**/

require( '.' . DIRECTORY_SEPARATOR . 'core-s' . DIRECTORY_SEPARATOR . 'smartservs-tcex-boot.php' );
class GPage extends securegamepage{
public function GPage(){
		parent::securegamepage();
        $this->viewFile = "t_back.phtml";
        $this->contentCssClass = "forum";
	}
}
$p = new GPage();
$p->run();
?>