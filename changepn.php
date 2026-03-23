<?php
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php");
class GPage extends securegamepage{
public function GPage(){
		parent::securegamepage();
		$this->viewFile = "changepn.phtml";
		$this->contentCssClass = "forum";
	}
}
$p = new GPage();
$p->run();
?>