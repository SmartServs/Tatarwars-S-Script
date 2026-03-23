<?php
error_reporting(0);
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
require_once( MODEL_PATH."payment.php" );
class GPage extends WebService
{

    public function load( )
    {
        $AppConfig = $GLOBALS['AppConfig'];
        if ( $this->isPost( ) )
        {
            $usedPackage = NULL;
            foreach ( $AppConfig['plus']['packages'] as $package )
            {
                if ( $package['cost'] == $_POST['amount'] )
                {
                    $usedPackage = $package;
                }
            }
            $merchant_id = $AppConfig['plus']['payments']['cashu']['merchant_id'];
            $usedPayment = NULL;
            foreach ( $AppConfig['plus']['payments'] as $payment )
            {
                if ( $payment['merchant_id'] == $merchant_id )
                {
                    $usedPayment = $payment;
                }
            }
            if ( !isset( $_GET[$usedPayment['returnKey']] ) )
            {
                return;
            }
            if ( $usedPackage != NULL && $usedPayment != NULL && $_POST['token'] == md5( sprintf( "%s:%s:%s:%s", $merchant_id, $_POST['amount'], strtolower( $_POST['currency'] ), $_POST['test_mode'] ? $usedPayment['testKey'] : $usedPayment['key'] ) ) )
            {
                $playerId = base64_decode( $_POST['session_id'] );
				$transID = $_POST['trn_id'];
				$m = new PaymentModel();
				$userid = $m->getPlayerDataById ($playerId);
			    $usernam = $userid['name'];
			    $cost = $_POST['amount'];
			    $currency = $_POST['currency'];
				$type = 'cashu';
                $goldNumber = $usedPackage['gold'];
                $m = new PaymentModel();
                $m->incrementPlayerGold( $playerId, $goldNumber );
				$m->InsertMoneyLog( $transID, $usernam, $goldNumber, $cost, $currency, $type );
				$m->updatetotalcashu( $goldNumber, $cost );
                $m->dispose();
				$URL = $AppConfig['system']['social_url'];
                ?>
                <META HTTP-EQUIV="refresh" CONTENT="0; URL=<? echo $URL;?>plus.php?t=2">
                <?php
            }
            else
            {
                $URL = $AppConfig['system']['social_url'];
                ?>
                <META HTTP-EQUIV="refresh" CONTENT="0; URL=<? echo $URL;?>plus.php">
                <?php
            }
        }
    }

}

$p = new GPage();
$p->run();
?>
