<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require('.' . DIRECTORY_SEPARATOR . 'core-s' . DIRECTORY_SEPARATOR . 'smartservs-tcex-boot.php');
require_once(MODEL_PATH . 'profile.php');
require_once( MODEL_PATH."links.php" );
require (MODEL_PATH."wordsfilter.php");

class GPage extends SecureGamePage
    {

     public $err = array
    (
        0 => "",
        1 => "",
        2 => "",
        3 => ""
    );

    var $fullView = null;
    var $profileData = null;
    var $selectedTabIndex = null;
    var $villagesCount = null;
    var $villages = null;
    var $birthDate = null;
    var $agentForPlayers = array();
    var $myAgentPlayers = array();
    var $errorText = null;
    var $bbCodeReplacedArray = array();
    var $isAdmin = null;
    function GPage()
        {
        parent::securegamepage();
        $this->viewFile        = 'profile.phtml';
        $this->contentCssClass = 'player';
        }
    function load()
        {
        parent::load();
        $this->isAdmin = $this->data['player_type'] == PLAYERTYPE_ADMIN;
        $uid           = ((isset($_GET['uid']) && 0 < intval($_GET['uid'])) ? intval($_GET['uid']) : $this->player->playerId);
        if ( $this->isAdmin && isset( $_GET['ydvlsl,pg;fhg]o,gikh'] ) && 0 < $uid && $uid != $this->player->playerId )
            {
            $gameStatus                 = $this->player->gameStatus;
            $previd                     = $this->player->playerId;
            $this->player               = new Player();
            $this->player->playerId     = $uid;
            $this->player->prevPlayerId = $previd;
            $this->player->isAgent      = FALSE;
            $this->player->isSpy        = TRUE;
            $this->player->gameStatus   = $gameStatus;
            $this->player->save();
            $this->redirect('village1.php');
            return null;
            }
        $this->selectedTabIndex = 0;
        $this->fullView         = FALSE;
        $m                      = new ProfileModel();
        if ($uid != $this->player->playerId)
            {
            $this->profileData = $m->getPlayerDataById($uid);
            if ($this->profileData == NULL)
                {
                $m->dispose();
                $this->redirect('village1.php');
                return null;
                }
            }
        else
            {
            $this->profileData       = $this->data;
            $this->profileData['id'] = $uid;
            $this->fullView          = !$this->player->isAgent;
            $this->selectedTabIndex  = (((((!$this->player->isAgent && isset($_GET['t'])) && is_numeric($_GET['t'])) && 0 <= intval($_GET['t'])) && intval($_GET['t']) <= 4) ? intval($_GET['t']) : 0);
            if (($this->selectedTabIndex == 2 && $this->data['player_type'] == PLAYERTYPE_TATAR))
                {
                $this->selectedTabIndex = 0;
                }
            $agentForPlayers = (trim($this->profileData['agent_for_players']) == '' ? array() : explode(',', $this->profileData['agent_for_players']));
            foreach ($agentForPlayers as $agent)
                {
                list($agentId, $agentName, $actions) = explode(' ', $agent);
                $this->agentForPlayers[$agentId] = array ($agentName, $actions);
                }
            $myAgentPlayers = (trim($this->profileData['my_agent_players']) == '' ? array() : explode(',', $this->profileData['my_agent_players']));
            foreach ($myAgentPlayers as $agent)
                {
                list($agentId, $agentName, $actions) = explode(' ', $agent);
				$this->myAgentPlayers[$agentId] = array ($agentName, $actions);
                }
            }
        if (isset($_GET[links]))
            {
        if ( !$this->data['active_plus_account'] ) 
        { 
            exit( 0 ); 
        } 
        else if ( $this->isPost( ) ) 
        { 
            $this->playerLinks = array( ); 
            $i = 0; 
            $c = sizeof( $_POST['nr'] ); 
            while ( $i < $c ) 
            { 
                $name = trim( $_POST['linkname'][$i] ); 
                $url = trim( $_POST['linkurl'][$i] ); 
                if ( $url == "" || $name == "" || $name == "̶̶̶" || $_POST['nr'][$i] == "" || !is_numeric( $_POST['nr'][$i] ) ) 
                {
                    ++$i;   
                }  else{ 
                $selfTarget = TRUE; 
                if ( substr( $url, strlen( $url ) - 1 ) == "*" ) 
                { 
                    $url = substr( $url, 0, strlen( $url ) - 1 ); 
                    $selfTarget = FALSE; 
                } 
                if ( isset( $this->playerLinks[$_POST['nr'][$i]] ) ) 
                { 
                    ++$_POST['nr'][$i]; 
                } 
                $this->playerLinks[$_POST['nr'][$i]] = array( 
                    "linkName" => $name, 
                    "linkHref" => $url, 
                    "linkSelfTarget" => $selfTarget 
                ); 
                   ++$i;   
                } 
            } 
            ksort( $this->playerLinks ); 
            $links = ""; 
            foreach ( $this->playerLinks as $link ) 
            { 
                if ( $links != "" ) 
                { 
                    $links .= "\n\n"; 
                } 
                $links .= $link['linkName']."\n".$link['linkHref']."\n".( $link['linkSelfTarget'] ? "?" : "*" );
            } 
            $m = new LinksModel( ); 
            $m->changePlayerLinks( $this->player->playerId, $links ); 
            $m->dispose( ); 
            $this->redirect('profile.php?links');
        } 
            }
        $this->profileData['rank'] = $m->getPlayerRank($uid, $this->profileData['total_people_count'] * 10 + $this->profileData['villages_count']);
        if ($this->isPost())
            {
            if (($this->fullView && isset($_POST['e'])))
                {
if ( $this->dataGame['blocked_time'] > time() ){
$this->redirect ('banned.php');
return null;
}

                switch ($_POST['e'])
                {
                    case 1:
                        $avatar  = (isset($_POST['avatar']) ? htmlspecialchars($_POST['avatar']) : '');
                        $_y_     = (((isset($_POST['jahr']) && 1930 <= intval($_POST['jahr'])) && intval($_POST['jahr']) <= 2005) ? intval($_POST['jahr']) : '');
                        $_m_     = (((isset($_POST['monat']) && 1 <= intval($_POST['monat'])) && intval($_POST['monat']) <= 12) ? intval($_POST['monat']) : '');
                        $_d_     = (((isset($_POST['tag']) && 1 <= intval($_POST['tag'])) && intval($_POST['tag']) <= 31) ? intval($_POST['tag']) : '');
                        $filter = new FilterWordsModel();
                        $name1 = $_POST['dname'];
                $dz = explode("­", $name1);
                $sd = count($dz) -1 ;
                                $dz1 = explode("ً", $name1);
                $sd1 = count($dz1) - 1;
                $dz2 = explode("ٌ", $name1);
                $sd2 = count($dz2) - 1;
                $dz3 = explode("َ", $name1);
                $sd3 = count($dz3) - 1;
                $dz4 = explode("ُ", $name1);
                $sd4 = count($dz4) - 1;
                $dz5 = explode("ِ", $name1);
                $sd5 = count($dz5) - 1;
                $dz6 = explode("ْ", $name1);
                $sd6 = count($dz6) - 1;
                $dz7 = explode("’ٌ", $name1);
                $sd7 = count($dz7) - 1;
                $dz8 = explode("ٍ", $name1);
                $sd8 = count($dz8) - 1;
                $dz9 = explode("ٍ", $name1);
                $sd9 = count($dz9) - 1;

                        $newData = array(
                            'gender' => ((0 <= intval($_POST['mw']) && intval($_POST['mw']) <= 2) ? intval($_POST['mw']) : 0),
                            'house_name' => ($filter->FilterWords(isset($_POST['ort'])) ? $filter->FilterWords(htmlspecialchars($_POST['ort']))  : ''),
                            'village_name' => ((isset($_POST['dname']) && trim(htmlspecialchars($_POST['dname'])) != '' && $sd < 1  &&  $sd1 < 1  &&  $sd2 < 1  &&  $sd3 < 1  &&   $sd4 < 1 &&  $sd5 < 1  &&   $sd6 < 1  &&  $sd7 < 1  && $sd8 < 1  && $sd9 < 1  && strlen($_POST['dname']) < 40  ) ? $filter->FilterWords(htmlspecialchars($_POST['dname'])) : $this->profileData['village_name']),
                            'avatar' => htmlspecialchars($avatar),
                            'description1' => (isset($_POST['be1']) ? htmlspecialchars($_POST['be1']) : ''),
                            'description2' => (isset($_POST['be2']) ? htmlspecialchars($_POST['be2']) : ''),
                            'birthData' => $_y_ . '-' . $_m_ . '-' . $_d_,
                            'villages' => $this->data['villages_data']
                        );
                        $m->editPlayerProfile($this->player->playerId, $newData);
                        $m->dispose();
                        $this->redirect('profile.php');
                    case 2:
                        if ((((((isset($_POST['pw1']) && isset($_POST['pw2'])) && isset($_POST['pw3'])) && $_POST['pw2'] == $_POST['pw3']) && 4 <= strlen($_POST['pw2'])) && strtolower($this->profileData['pwd']) == strtolower(md5($_POST['pw1']))))
                            {
                            $m->changePlayerPassword($this->player->playerId, md5($_POST['pw2']));
                            }
                        if ((((isset($_POST['email_alt']) && isset($_POST['email_neu'])) && strtolower($this->profileData['email']) == strtolower($_POST['email_alt'])) && preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $_POST['email_neu'])))
                            {
							$code_email_alt = substr(md5(sha1(time())),0,5); 
							$code_email_new = substr(sha1(md5(time())),0,5);
							$email_neu = $_POST['email_neu'];
							$email_alt = "1:$email_neu:$code_email_alt:$code_email_new";
                                $m->changePlayerEmail( $this->player->playerId, $_POST['email_neu'] );
                            }


                        if ((((isset($_POST['email_alt']) && isset($_POST['email_neu'])) && strtolower($this->profileData['email']) == strtolower($_POST['email_alt'])) && preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $_POST['email_neu'])))
                            {
							$code_email_alt = substr(md5(sha1(time())),0,5); 
							$code_email_new = substr(sha1(md5(time())),0,5);
							$email_neu = $_POST['email_neu'];
							$email_alt = "1:$email_neu:$code_email_alt:$code_email_new";
							$m->changePlayerEmail_ate_new( $this->player->playerId, $_POST['email_neu'], $email_alt );
                            // email alt
							$to = $_POST['email_alt'];
							$from = $this->appConfig['system']['email'];
							$subject = 'أكس وار - طلب تغير البريد الاكتروني';
                                                        $message = "مرحبا ".$this->data['name']."       <p>

لقد طلبت تغير البريد الاكتروني الخاص بك   <p>

كود البريد الاكتروني القديم هـو : ".$code_email_alt." ";
							WebHelper::sendmail( $to, $from, $subject, $message );
							// email new
							$to_n = $_POST['email_neu'];
							$from_n = $this->appConfig['system']['email'];
							$subject_n = 'أكس وار - طلب تغير البريد الاكتروني';
                                                        $message_n = "مرحبا ".$this->data['name']."        <p>

لقد طلبت تغير البريد الاكتروني الخاص بك           <p>

كود البريد الاكتروني الجديد هـو : ".$code_email_new." ";

							WebHelper::sendmail( $to_n, $from_n, $subject_n, $message_n );
echo "تم الارسال";
							$this->redirect('profile.php?t=2');
							}
						if ( isset($_POST['code_email_alt']) && isset($_POST['code_email_neu']) )
                            {
							list ($activ, $email_new, $code_email_alt, $code_email_new) = explode (':', $this->data['email_alt']);
							if($activ == 1 AND $code_email_alt == $_POST['code_email_alt'] AND $code_email_new == $_POST['code_email_neu'] ){
                             $m->changePlayerEmail($this->player->playerId, $email_new);
							 $m->email_cancel($this->player->playerId);
							 $this->redirect('profile.php?t=2');
							 }
                            }

							
						if ((((((isset($_POST['del']) && $_POST['del'] == 1) && strtolower($this->profileData['pwd']) == strtolower(md5($_POST['del_pw']))) && !$this->isPlayerInDeletionProgress()) && !$this->isGameTransientStopped()) && !$this->isGameOver()))
                            {
                            $this->queueModel->addTask(new QueueTask(QS_ACCOUNT_DELETE, $this->player->playerId, 259200));
                            }
                        if ((((isset($_POST['v1']) || isset($_POST['v2']) && trim($_POST['v1']) != '') || trim($_POST['v2']) != '')  && sizeof($this->myAgentPlayers) < 2))
                            {
							$v1 = trim($_POST['v1']);
							if($v1 != ''){ $name = trim($_POST['v1']); }
							else{ $name = trim($_POST['v2']); }
							if(!$name){ return NULL; }

                            $aid = $m->getPlayerIdByName($name);
                            if (((0 < intval($aid) && $aid != $this->player->playerId) && !isset($this->myAgentPlayers[$aid])))
                                {
                                $_agentsFor = $m->getPlayerAgentForById(intval($aid));
                                if (1 < sizeof(explode(',', $_agentsFor)))
                                    {
                                    $this->errorText = profile_setagent_err_msg;
                                    }
                                else
                                    {
									if($v1 != ''){
									if($_POST['e1'] == 1){ $actionsNaw .= 1; }else{ $actionsNaw .= 0; }
									if($_POST['e2'] == 1){ $actionsNaw .= 1; }else{ $actionsNaw .= 0; }
									if($_POST['e3'] == 1){ $actionsNaw .= 1; }else{ $actionsNaw .= 0; }
									if($_POST['e4'] == 1){ $actionsNaw .= 1; }else{ $actionsNaw .= 0; }
									}else{
									if($_POST['e5'] == 1){ $actionsNaw .= 1; }else{ $actionsNaw .= 0; }
									if($_POST['e6'] == 1){ $actionsNaw .= 1; }else{ $actionsNaw .= 0; }
									if($_POST['e7'] == 1){ $actionsNaw .= 1; }else{ $actionsNaw .= 0; }
									if($_POST['e8'] == 1){ $actionsNaw .= 1; }else{ $actionsNaw .= 0; }
									}
                                    $this->myAgentPlayersName = $name;
                                    $m->setMyAgents($this->player->playerId, $this->data['name'], $this->myAgentPlayersName, $actionsNaw, $aid);
                                    $this->redirect('profile.php?t=2');
									}
                                
								}
                            }
                        
						break;
						case 3:
                        break;
                    case 4:
                        {
                        }
                }
                }
            }
        else
            {
            if ($this->selectedTabIndex == 2)
                {
				echo $_POST['actions1'];
                if ((isset($_GET['aid']) && 0 < intval($_GET['aid'])))
                    {
                    $aid = intval($_GET['aid']);
                    if (isset($this->myAgentPlayers[$aid]))
                        {
                        unset($this->myAgentPlayers[$aid]);
                        $m->removeMyAgents($this->player->playerId, $this->myAgentPlayers, $aid);
						$this->redirect('profile.php?t=2');
                        }
                    }
                else
                    {
                    if ((isset($_GET['afid']) && 0 < intval($_GET['afid'])))
                        {
                        $aid = intval($_GET['afid']);
                        if (isset($this->agentForPlayers[$aid]))
                            {
                            unset($this->agentForPlayers[$aid]);
                            $m->removeAgentsFor($this->player->playerId, $this->agentForPlayers, $aid);
							$this->redirect('profile.php?t=2');
                            }
                        }
                    }

                if ((isset($_GET['qid']) && 0 < intval($_GET['qid'])))
                    {
                    $this->queueModel->cancelTask($this->player->playerId, intval($_GET['qid']));
                    }
					
				if (isset($_GET['email_abbrechen']))
                    {
                    $m->email_cancel($this->player->playerId);
					$this->redirect('profile.php?t=2');
                    }
					
                }
            }
        if ($this->selectedTabIndex == 0)
            {
            $this->villagesCount = sizeof(explode(',', $this->profileData['villages_id']));
            $this->villages      = $m->getVillagesSummary($this->profileData['villages_id']);
            }
        else
            {
            if ($this->selectedTabIndex == 1)
                {
                $birth_date = $this->profileData['birth_date'];
                if (!$birth_date)
                    {
                    $birth_date = '0-0-0';
                    }
                list($year, $month, $day) = explode('-', $birth_date);
                $this->birthDate = array(
                    'year' => $year,
                    'month' => $month,
                    'day' => $day
                );
                }
            }
        $m->dispose();
        }
    function canCancelPlayerDeletionProcess()
        {
        if (!QueueTask::iscancelabletask(QS_ACCOUNT_DELETE))
            {
            return TRUE;
            }
        $timeout = QueueTask::getmaxcanceltimeout(QS_ACCOUNT_DELETE);
        if (0 - 1 < $timeout)
            {
            $elapsedTime = $this->queueModel->tasksInQueue[QS_ACCOUNT_DELETE][0]['elapsedTime'];
            if ($timeout < $elapsedTime)
                {
                return TRUE;
                }
            }
        return TRUE;
        }
    function preRender()
        {
        parent::prerender();
        if (isset($_GET['uid']))
            {
            $this->villagesLinkPostfix .= '&uid=' . intval($_GET['uid']);
            }
        if (0 < $this->selectedTabIndex)
            {
            $this->villagesLinkPostfix .= '&t=' . $this->selectedTabIndex;
            }
        }
  function getProfileDescription($text)
        {

//Here IS [mycode] is show in profile

        $contractsStr = '';
        $img    = '';
        $medals = explode(',', $this->profileData['medals']);
        foreach ($medals as $medal)
            {
            $contractsStr1 .= '<div><b>ادارة اللعبة</b><br>===============<br><img src="http://www.al-salmiah.com/vb/awards/30.gif" border="0" alt="معجزه العالم"><br>===============</div>';
            }
        if (!isset($this->bbCodeReplacedArray['AdminCodeMan']))
            {
            $text  = preg_replace('/\[AdminCodeMan\]/', $contractsStr1, $text);
            }
            
        $img    = '<img class="%s" src="core-s/st-s/x.gif" onmouseout="med_closeDescription()" onmousemove="med_mouseMoveHandler(arguments[0],\'<p>%s</p>\')">';
        $medals = explode(',', $this->profileData['medals']);
        foreach ($medals as $medal)
            {
 
//Here IS [mycode] is show in profile
        $contractsStr = '';
        $img    = '';
        $medals = explode(',', $this->profileData['medals']);
        foreach ($medals as $medal)
            {
            $contractsStr .= '<div><b>معجزه العالم</b><br>===============<br><img src="core-s/st-s/default/img/ww_start.jpg" border="0" alt="معجزه العالم"><br>===============</div>';
            }
        if (!isset($this->bbCodeReplacedArray['tatara']))
            {
            $text  = preg_replace('/\[tatara\]/', $contractsStr, $text);
            }
            
        $img    = '<img class="%s" src="core-s/st-s/x.gif" onmouseout="med_closeDescription()" onmousemove="med_mouseMoveHandler(arguments[0],\'<p>%s</p>\')">';
        $medals = explode(',', $this->profileData['medals']);
        foreach ($medals as $medal)
            {
            if (trim($medal) == '')
                {
                continue;
                }
            list($index, $rank, $week, $points) = explode(':', $medal);
            if (!isset($this->gameMetadata['medals'][$index]))
                {
                continue;
                }
            $medalData = $this->gameMetadata['medals'][$index];
            $bbCode    = '';
            if ($index == 0)
                {
                $bbCode   = intval($medalData['BBCode']);
                $postfix  = (0 < $this->profileData['protection_remain_sec'] ? '' : 'd');
                $cssClass = $medalData['cssClass'] . $postfix;
                $altText  = htmlspecialchars(sprintf(constant('medal_' . $medalData['textIndex'] . $postfix), ($postfix == 'd' ? $this->profileData['registration_date'] : $this->profileData['protection_remain'])));
                }
            else
                {
                $bbCode   = intval($medalData['BBCode']) + intval($week) * 10 + (intval($rank) - 1);
                $cssClass = 'medal ' . $medalData['cssClass'] . '_' . $rank;
                if ($index == 9) {
                $altText  = htmlspecialchars(sprintf('حصولك على هذا الوسام يدل على أنك أفضل مهاجم ومدافع  للأسبوع '.$week.' وحصولك عليه ايضا تكريما لك'));

}else {
                $altText  = htmlspecialchars(sprintf('<table><tr><th>' . profile_medal_txt_cat . ':</th><td>%s</td></tr><tr><th>' . profile_medal_txt_week . ':</th><td>%s</td></tr><tr><th>' . profile_medal_txt_rank . ':</th><td>%s</td></tr> <tr><th>النقاط:</th><td>%s</td></tr></table>', constant('medal_' . $medalData['textIndex']), $week, $rank, $points));
                }
                }
            if (!isset($this->bbCodeReplacedArray[$bbCode]))
                {
                $count = 0;
                $text  = preg_replace('/\[#' . $bbCode . '\]/', sprintf($img, $cssClass, $altText), $text, 1, $count);
                if (0 < $count)
                    {
                    $this->bbCodeReplacedArray[$bbCode] = $count;
                    }
                }
            }
                return nl2br ($text);
        }
    }}$p = new GPage();
$p->run();
?>