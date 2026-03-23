<?php
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
require_once( MODEL_PATH."payment.php" );
class GPage extends WebService
{

    public function load()
    {
        $AppConfig = $GLOBALS['AppConfig'];
        if ( $this->isPost() )
        {
            foreach ( $AppConfig['plus']['packages'] as $package )
            {
                if ( $package['cost'] == $_POST['OneCard_Amount'] )
                {
                    $usedPackage = $package;
                }
            }

                $returnKey= base64_encode( $AppConfig['plus']['payment']['onecard']['returnKey'] );
                if ( $_POST['OneCard_Field2'] == $returnKey )
                { 
				    $playerId = base64_decode( $_POST['OneCard_Field1'] );
				    $transID = $_POST['OneCard_TransID'];
					$m = new PaymentModel();
                    $userid = $m->getPlayerDataById ($playerId);
			        $usernam = $userid['name'];
			        $cost = $usedPackage['cost'];
			        $currency = $_POST['OneCard_Currency'];
					$type = 'onecard';
                    $goldNumber = $usedPackage['gold'];
					$m = new PaymentModel();
					$m->updatetotalonecard( $goldNumber, $cost );
                    $m->incrementPlayerGold( $playerId, $goldNumber );
					$m = new PaymentModel();
					$m->InsertMoneyLog( $transID, $usernam, $goldNumber, $cost, $currency, $type );
					
                    header("Location: plus.php?t=2");
                }
                else
                {
                    header("Location: plus.php");
                }
        }

    }

}

$p = new GPage();
$p->run();
?>
