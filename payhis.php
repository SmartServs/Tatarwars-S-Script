<?php
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php");
require_once(MODEL_PATH."payhis.php");

class GPage extends SecureGamePage{

	function GPage(){
		parent::securegamepage();
		$this->viewFile = "payhis.phtml";
		$this->contentCssClass = "plus";
	}

	function load(){
parent::load();
            $m = new Payhis();

			if ($_GET['t'] == 0) 
			{
			    $type = 'sms';
                $this->dataList = $m->PayhisByType($type);
			}
            if ($_GET['t'] == 1) 
			{
			    $type = 'cashu';
                $this->dataList = $m->PayhisByType($type);
			}
			if ($_GET['t'] == 2) 
			{
			    $type = 'onecard';
                $this->dataList = $m->PayhisByType($type);
			}
			$payhistotal = $m->getTotalMoney();

        $m->dispose();
		

	}
	
}

$p = new GPage();
$p->run();
?>	