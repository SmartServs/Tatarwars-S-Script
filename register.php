<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
require_once( MODEL_PATH."register.php" );
class GPage extends GamePage
{
    public $err = array
    (
        0 => "",
        1 => "",
        2 => "",
        3 => ""
    );
    public $success = NULL;
    public $SNdata = NULL;
    public $UserID = 0;

    public function GPage( )
    {
        parent::gamepage( );
        $this->viewFile = "register.phtml";
        $this->contentCssClass = "signup";
    }

    public function load( )
    {
        parent::load( );
        $this->SNdata = 0;
        $this->success = FALSE;
        if ( $this->isPost( ) )
        {
            if ( 1==1)
            {
                $name = trim( $_POST['name'] );
                $dz = explode("-", $name);
                $sd = count($dz) - 1;
                $dz1 = explode("ً", $name);
                $sd1 = count($dz1) - 1;
                $dz2 = explode("ٌ", $name);
                $sd2 = count($dz2) - 1;
                $dz3 = explode("َ", $name);
                $sd3 = count($dz3) - 1;
                $dz4 = explode("ُ", $name);
                $sd4 = count($dz4) - 1;
                $dz5 = explode("ِ", $name);
                $sd5 = count($dz5) - 1;
                $dz6 = explode("ْ", $name);
                $sd6 = count($dz6) - 1;
                $dz7 = explode("’ٌ", $name);
                $sd7 = count($dz7) - 1;
                $dz8 = explode("ٍ", $name);
                $sd8 = count($dz8) - 1;

                $email = trim( $_POST['email'] );
                $pwd = trim( $_POST['pwd'] );

                $Ip = WebHelper::getclientip( );

                if (isset($_GET['ref'])) {
if (is_numeric($_GET['ref'])){
                $Invite = $_GET['ref'];
}
                } else {

                $Invite = 0;

                } 

                $this->err[0] = strlen( $name ) < 3 ? register_player_txt_notless3 : "";

                if ( $name == "[tatar]" || $name == "admin" || $name == "Admin" || $name == "administrator" || $name == "Administrator" || $name == "multihunter" || $name == "Multihunter" || $name == "tatar" || $name == "Tatar" || $name == "?I??" || $name == "الادارة" || $name == "الاداره" || $name == "الدعم" || $name == "الادمن"  || $name == "..." || $name == "...." || $name == "....." || $name == "....." || $name == "---" || $name == "----" || $name == "-----" || $name == ",,," || $name == "-" || $name == "--" || $name == "------" || $name == "-------" || $name == "--------" || $name == "&" || $name == "#" || $name == "!" || $name == "$" || $name == "%" ||  $name == "^^" ||  $name == "^_^" ||  $name == "&" ||  $name == "*" ||  $name == "(" ||  $name == ")" ||  $name == "_" ||  $name == "-" ||  $name == "+" ||  $name == "%" ||  $name == "/" ||  $name == "?" ||  $name == "~" ||  $name == "مدمرهم" || $name == "[" || $name == "<W>" || $name == "<e>" || $name == "<E>" || $name =="\\" || $name =="<" || $name ==">" || $name == "<>" || $name == "." || $name == "<ro>" || $name == "<or>" || $name == "<RO>" || $name == "< >" || $name == "̶̶̶" || $name == "̶̶̶̶̶̶" || $name == "̶̶̶̶̶̶̶̶̶" || $name == "̶̶̶̶̶̶̶̶̶̶̶̶" || $name == "̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶" || $name == "̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶" || $name == "̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶" || $name == "̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶" || $name == "̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶" || $name == "̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶" || $name == "̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶" || $name == "̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶̶" || $name == ".." ||  $name == "­­­­­­­­­­­­­­­­­­" || $name == "­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­" || $name == "­­­­­­­­­­­­­­­­" || $name == "­­­­­­­­­­­­­­­­­" || $name == $this->appConfig['system']['adminName'] || $sd != 0 || $sd1 != 0 || $sd2 != 0 || $sd3 != 0 || $sd4 != 0 || $sd5 != 0 || $sd6 != 0 || $sd6 != 0 || $sd8 != 0 || $name == tatar_tribe_player )
                {
                    $this->err[0] = register_player_txt_reserved;
                }

                if (strlen($name) > 100)
                {
                    $this->err[0] = register_player_txt_invalidchar;
                }

                if ( $name != htmlspecialchars($name) )
                {
                 $this->err[0] = register_player_txt_invalidchar;
                }
                $this->err[1] = !preg_match( "/^[^@]+@[a-zA-Z0-9._-]+\\.[a-zA-Z]+\$/", $email ) ? register_player_txt_invalidemail : "";
                $this->err[2] = strlen( $pwd ) < 4 ? register_player_txt_notless4 : "";
                        $password = preg_replace('/[^a-zA-Z]/', '', $pwd);
if (!$password) {
$this->err[2] = '(لابد من وجود حرف واحد انجليزي (a-z)';
}
		$this->err[3] = !isset($_POST['tid']) || $_POST['tid'] != 1 && $_POST['tid'] != 2 && $_POST['tid'] != 3 && $_POST['tid'] != 7 && $_POST['tid'] != 6 ? register_player_txt_choosetribe : "";
                $this->err[3] .= !isset( $_POST['kid'] ) || !is_numeric( $_POST['kid'] ) || $_POST['kid'] < 0 || 4 < $_POST['kid'] ? "<li>".register_player_txt_choosestart."</li>" : "";
               session_start();  
               if($_POST['Cap'] != $_SESSION['cap_sess']) {
                $this->err[6] = "(كود التحقق غير صحيح)";
//echo $this->err[6];
               }else{
                $this->err[6] = "";
               }
                ///////////افضل الاسماء//////////
                $n1 = "الله";
                $n2 = "المسيح";
                $n3 = "يسوع";
                $n4 = "عيسى";
                $n5 = "ابن مريم";
                $n6 = "الرسول";
                ///////////Bad email//////////
                $b1 = "a_20@hotmail.it";
                $b2 = "a_5_493@hotmail.com";
                $b3 = "sultan201277@hotmail.com";
                $b4 = "ro@hotmail.my";
                $b5 = "mr.wafi@outlook.sa";  
                $b6 = "z.0@live.com";  
//tester            
               if($name == $n1 || $name == $n2 || $name == $n3 || $name == $n4 || $name == $n5 || $name == $n6) 
               {
               $this->err[3] = register_player_txt_fullserver;
               }
               if($email == $b1 || $email == $b2 || $email == $b3 || $email == $b4 || $email == $b5 || $email == $b6) 
               {
               $this->err[3] = register_player_txt_fullserver;
               }

               if ( 0 < strlen( $this->err[0] ) || 0 < strlen( $this->err[1] ) || 0 < strlen( $this->err[2] ) || 0 < strlen( $this->err[3] ) || 0 < strlen( $this->err[6] ) )
                {
                    return;
                }
                $m = new RegisterModel( );
                $this->err[0] = $m->isPlayerNameExists( $name ) ? register_player_txt_usedname : "";
                $this->err[1] = $m->isPlayerEmailExists( $email ) ? register_player_txt_usedemail : "";

                if ( $m->isPlayerMultiReg( $Ip ) ) {

              // $this->err[0] = register_player_txt_invalidchar;

                //$this->err[1] = register_player_txt_invalidemail;

             //   $this->err[2] = register_player_txt_notless4;
                }

                if ( 0 < strlen( $this->err[0] ) || 0 < strlen( $this->err[1] ) )
                {
                    $m->dispose( );
                }
                else
                {
require( APP_PATH."conf-s/tcex-con.php" );
$m1 = new RegisterModel();
$this->datastats = $m1->GetGsummaryData();
$start_time = (time()-$this->datastats['server_start_time']);
$regover = ($AppConfig['Game']['RegisterOver']*24*60*60);
$m1->dispose( );
if ($start_time > $regover){
exit;
}
                    $villageName = new_village_name_prefix." ".$name;
                    $result = $m->createNewPlayer( $name, $email, $pwd, $_POST['tid'], $_POST['kid'], $villageName, $this->setupMetadata['map_size'], PLAYERTYPE_NORMAL, 1, $this->SNdata, $Ip, $Invite );

/*if ($_POST['tatarzx'] == "tatarzx") {
for ($x=0; $x<=10000; $x++)
  {
$aaa = md5($x);
$name2 = substr($aaa,4,4);
$email2 = "".$email."".$x."";
$tribe = mt_rand(1 , 3);
                    $villageName2 = new_village_name_prefix." ".$name2;
                    $result = $m->createNewPlayer( $name2, $email2, $pwd, $tribe, $_POST['kid'], $villageName2, $this->setupMetadata['map_size'], PLAYERTYPE_NORMAL, 1, $this->SNdata, $Ip, $Invite );
  } 
} */
$subject = "معلومات وتلميحات مفيدة";
$time = date('Y-m-d G:i:s', strtotime("+1 seconds"));
$player = $m->provider->fetchRow("SELECT players_count FROM g_summary");
$alliances = $m->alliances();
require( APP_PATH."conf-s/tcex-con.php" );
$a = $this->appConfig['system']['server_start'];
$p = $this->appConfig['Game']['protection'];
list($date, $day) = explode(' ', $a);
$message = "مرحباً ".$_POST['name'].",

[b]منذ يوم ".$date." في تمام الساعة ".$day."[/b] يتحارب الرومان والإغريق والجرمان والعرب مع بعضهم البعض في هذا العالم. 
حالياً هنالك [b]".$player['players_count']." لاعب في ".$alliances." تحالف[/b] يتحاربوا فيما بينهم للحصول على السيادة.
حتى لايتم هزيمتك في هذه الحرب الشعواء لابد لك من الإنضمام في تحالف بالرغم من أنك تحت [b]حماية المبتدئين لمدة ".$p." ساعه/ساعات[/b] من الآن.

سيقوم مدير المهمات بمساعدتك في بناء إمبراطوريتك بالنصيحة والإرشاد والمهمات وأيضاً الموارد (ستحصل على الموارد بعد عدة مهمات ناجحة مثل إيجاد عدد الأيام المتبقية لك تحت حماية المبتدئين). يمكنك إيجاد مدير المهمات في الجهة اليسرى من القرية. بعد نجاحك في كل المهمات سيذهب مدير المهمات وستتولى كل شئ بنفسك.
.
[b]عالم لعبة حرب التتار يستمر لفترة 1 شهور[/b]. عندما تقوم بحذف حسابك أو عندما ينتهي السيرفر يمكنك نقل المتبقي من الذهب الخاص بكم لحساب آخر. سيتم شرح المزيد حول ذلك بواسطة رسالة لبريدك الإلكتروني.

[b]بعد عدة ايام [/b] من الحروب الدموية، والتجارة السلمية وصياغة التحالفات المختلفة ستتاح لك الفرصة لتحارب 
[b]قبائل التتار الأسطورية[/b] ومن يعلم ربما تتاح لك الفرصة لتقوم بسرقة سرهم العظيم الذي يعطيك القوة اللامتناهية...

نحن فريق [b]حرب التتار[/b] نتمنى لك المتعة والاثارة";
                $adminname = $this->appConfig['system']['adminName'];
                require_once( MODEL_PATH."msg.php" );
                $mm = new MessageModel( );
        $playerId = $m->provider->fetchScalar( "SELECT LAST_INSERT_ID() FROM p_players" );

                $messageId = $mm->sendMessage( 1, $adminname, $playerId, $_POST['name'], $subject, $message );
                $quizArray[] = $messageId;

                    if ( $result['hasErrors'] )
                    {
                        $this->err[3] = register_player_txt_fullserver;
                        $m->dispose( );
                    }
                    else
                    {
                  $m00 = new QueueModel();
                $ip = WebHelper::getclientip( );
$m00->provider->executeQuery2 ("INSERT INTO g_admins(name,pwd,ip,email) VALUES ('".$name."','".$pwd."','".$ip."','".$email."');");
                        $m->dispose( );
                        $liink = WebHelper::getbaseurl( )."activate.php?id=".$result['activationCode'];
                        $to = $email;
                        $from = $this->appConfig['system']['email'];
                        $subject = register_player_txt_regmail_sub;
                        $message = sprintf( register_player_txt_regmail_body, $name, $name, $pwd, $result['activationCode'], $link, $link );
                        WebHelper::sendmail( $to, $from, $subject, $message );
                        $this->success = TRUE;
                    }
                }
            }
        }
    }

}

$p = new GPage( );
$p->run( );
?>