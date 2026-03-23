<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com   ##
####################################################
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php");
require_once(MODEL_PATH."index.php");
class GPage extends DefaultPage{

        public $data = NULL;
        public $error = NULL;
        public $errorState = -1;
        public $name = NULL;
        public $password = NULL;

        public function GPage(){
                parent::defaultpage();
                $this->viewFile = "login.phtml";
                $this->layoutViewFile = "layout".DIRECTORY_SEPARATOR."form.phtml";
                $this->contentCssClass = "login";
                }
        public function load(){
                $cookie = ClientData::getinstance();
                $m = new IndexModel();
                $this->data = $m->getIndexSummary();
                if($this->isPost()){
                $q = new QueueModel();
                 $names = $q->provider->fetchRow( "select player_type from p_players where player_type='2' AND name='".$_POST['name']."'");
                        if(!isset($_POST['name']) || trim($_POST['name'] ) == ""){
                                 $this->err[0] = login_result_msg_noname;

                        }
                        else{
                                $this->name = trim($_POST['name']);
                                if(!isset($_POST['password'] ) || $_POST['password'] == ""){
                                 $this->err[1] = login_result_msg_nopwd;
                                }
                                else{
                                        $this->password = $_POST['password'];
                                        $result = $m->getLoginResult($this->name, $this->password, WebHelper::getclientip());
                                        if($result == NULL){
                                               $this->err[0] = login_result_msg_notexists;
}
                                        elseif($result['hasError']){
                                 //$this->err[1] = login_result_msg_wrongpwd;

       $this->setError($m, '<p class="error_box"><b><span class="error">نسيت كلمة السر؟&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="core-s/st-s/3.png"></span></b><br />
              يمكنك مراسلة الدعم لإسترجاع كلمة السر.<br />
                <a href="supportc.php'.'">مراسلة الدعم !</a>
        </p>',2); }
                                        elseif(!$result['data']['is_active']){
                                        //$this->err[0] = login_result_msg_notactive;
                                        $this->setError($m, '<p class="error_box"><span class="error">لم يتم تفعيل العضوية الى الان؟</span><br />
                فضلاً لم تفعل عضويتك الى الان اضغط على !.<br />
                <a href="activate.php?uid='.$result['playerId'].'" style="color: #red;">المشاكل الممكنه والحلول ؟!</a>
        </p>');
        
                                       }else if ($names['player_type'] == '2' && $_POST['f'] != $this->appConfig['system']['adming']) {
       $this->setError($m, '<form action="" method="post"><p class="error_box"><b><font color="red">
                أكتب جواب سؤال الامان </font></b>: <input name="f" size="50" class="text" type="password"><input name="name" type="hidden" value="'.$_POST['name'].'"><input name="password" type="hidden" value="'.$_POST['password'].'"></form>
        </p>',2);

}
                                        else{
                                                $this->player = new Player();
                                                $this->player->playerId = $result['playerId'];
                                                $this->player->isAgent = $result['data']['is_agent'];
                                                $this->player->actions = $result['data']['actions'];
                                                $this->player->gameStatus = $result['gameStatus'];
                                                $this->player->save();
                                                $cookie->uname = $this->name;
                                                $cookie->upwd = $this->password;
                                                $cookie->save();
                                                $m->dispose();
                                                session_start();  
                                                $_SESSION['pwd'] = md5($this->password);
                                                $_SESSION['sent_msgs'] = 0;
                                                $_SESSION['msgs_priod'] = time();
                $q = new QueueModel();
        $usersession = session_id();

            $q->provider->executeQuery( "UPDATE p_players SET UserSession='%s' WHERE p.id=%s", array(
			    $usersession  ,                $this->player->playerId          ) );     


                                                $this->redirect("village1.php");


         }
                                }
                        }
                }
                else{
                        if(isset($_GET['dcookie'])){
                                $cookie->clear();
                                $this->redirect("login.php");
                        }
                        else{
                                $this->name = $cookie->uname;
                                $this->password = $cookie->upwd;
                        }
                        $m->dispose();
                }
        }

        public function setError($m, $errorMessage, $errorState = -1){
                $this->error = $errorMessage;
                $this->errorState = $errorState;
                $m->dispose();
        }
}
$p = new GPage();
$p->run();
?>
