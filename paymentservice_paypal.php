<?php

require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
require_once( MODEL_PATH."payment.php" );
require_once( LIB_PATH."paypal.class.php" );
class GPage extends WebService
{

    public function load()
    {
        $AppConfig = $GLOBALS['AppConfig'];
        $p = new paypal_class();
        $m = new PaymentModel();
        if ( !isset( $_GET['action'] ) || empty( $_GET['action'] ) )
        {
            $_GET['action'] = "process";
        }
        switch ( $_GET['action'] )
        {
        case "process" :
          	print_r($p);
            return;
        case "success" :
           if ( $p->validate_ipn() )
            {
                
            }
            if ( $this->isPost() )
            {
                echo "<html><head><title>Success</title></head><body><h3>شكرا لطلبك.</h3>";
                 
                echo "</body></html>";
            }
            break;
        case "cancel" :
            echo "<html><head><title>Canceled</title></head><body><h3>تم إلغاء الطلب.</h3>";
            echo "</body></html>";
            break;
        case "ipn" :
            if ( $p->validate_ipn() )
            {
               
            }
            $subject = "إشعار الدفع الفوري - الدفع المستلم";
            $to = $AppConfig['system']['email'];
            $body = "تم استلام إشعار الدفع الفوري بنجاح\n";
            $body .= "from ".$p->ipn_data['payer_email']." on ".date( "m/d/Y" );
            $body .= " at ".date( "g:i A" )."\n\nDetails:\n";
            foreach ( $p->ipn_data as $key => $value )
            {
                $body .= "\n{$key}: {$value}";
            }
            @mail( $to, $subject, $body );
            $usedPackage = NULL;
            foreach ( $AppConfig['plus']['packages'] as $package )
            {
              
              if((int) @$package['goldplus'] > 0 ) {
            $package['gold'] = @$package['goldplus'];
        }
        
        if((int) @$package['costplus'] > 0 ) {
           // $orderData['cost'] = @$package['costplus'];
        }
              
                if ( $package['cost'] == $p->ipn_data['payment_gross'] )
                {
                    $usedPackage = $package['gold'];
                }
            }
            $Player = base64_decode( $p->ipn_data['custom'] );
            $m = new PaymentModel();
            $m->incrementPlayerGold( $Player, $usedPackage );
            $m->dispose(); 
        }
    }

}

$p = new GPage();
$p->run();
?>
