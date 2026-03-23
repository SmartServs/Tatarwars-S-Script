<?php
####################################################
## ALL COPY RIGHTS RESERVED @ www.redsea-h.com #####
## RED SEA HOST FOR WEB SOLUTIONS & PROGRAMMING ####
## RED SEA HOST WHATSAPP 00966501494220 ############
## RED SEA HOST EMAIL ADDRESS admin@redsea-h.com ###
## RED SEA HOST INFORMATION TECHNOLOGY COMPANY #####
####################################################

require (MODEL_PATH.'global.php');
require (MODEL_PATH.'register.php');
require (MODEL_PATH.'queue.php');
require (MODEL_PATH.'queuejob.php');
require (MODEL_PATH.'profile.php');
class MyWidget extends Widget {
var $title = '';
var $setupMetadata;
var $gameMetadata;
var $appConfig;
var $player= NULL;
var $gameSpeed;
function MyWidget() {
$this->setupMetadata = $GLOBALS['SetupMetadata'];
$this->gameMetadata = $GLOBALS['GameMetadata'];
$this->appConfig = $GLOBALS['AppConfig'];
$this->gameSpeed= $this->gameMetadata['game_speed'];
$session_timeout = $this->gameMetadata['session_timeout'];
@ini_set ('session.gc_maxlifetime', $session_timeout * 60);
@session_cache_expire ($session_timeout);
session_start ();
$ksa = new GlobalModel();
$m1 = new RegisterModel();
$this->datastats = $m1->GetGsummaryData();
$start_time = (time()-$this->datastats['server_start_time']);
$tatarover = ($this->appConfig['system']['calltatar1']);
$artover = ($this->appConfig['system']['artefect1']);
$m = new QueueModel();
$art = $m->provider->fetchScalar("SELECT COUNT(*) FROM p_queue WHERE id='2'");
$tatar = $m->provider->fetchScalar("SELECT COUNT(*) FROM p_queue WHERE id='1'");
$m1->dispose( );
if (isset( $_GET[$this->appConfig['system']['calltatar']])) {

$m = new QueueModel();

$m->provider->executeQuery2("UPDATE p_queue SET end_date=NOW() WHERE id='1'");

$m->provider->executeQuery2("UPDATE p_queue SET execution_time='0' WHERE id='1'");

}
if (isset( $_GET[$this->appConfig['system']['artefact']])) {

}
$m = new QueueModel();
$result = $m->provider->fetchRow ("SELECT * FROM g_summary");
if ($result == '') {$p = 0;} else {$p=$result['players_count'];}
if (isset( $_GET[$this->appConfig['system']['installkey']] ) && $p <= 462) {
require_once( MODEL_PATH . 'install.php' );
$m = new SetupModel();
$m->processSetup ($this->setupMetadata['map_size'], $this->appConfig['system']['admin_email']);
$m->dispose();
$this->redirect ('login.php');
return;
}
$this->player = Player::getInstance();
}
function getAssetVersion () {
return '?' . $this->appConfig['page']['asset_version'];
}
}
class PopupPage extends MyWidget {
function PopupPage() {
parent::MyWidget();
$this->layoutViewFile = 'layout' . DIRECTORY_SEPARATOR . 'popup.phtml';
}
}
class DefaultPage extends MyWidget {
function DefaultPage() {
parent::MyWidget();
$this->layoutViewFile = 'layout' . DIRECTORY_SEPARATOR . 'default.phtml';
}
}
class GamePage extends MyWidget {
var $globalModel;
var $Datagame;
var $contentCssClass = '';
var $newsText;
function GamePage() {
parent::MyWidget();
$this->layoutViewFile = 'layout' . DIRECTORY_SEPARATOR . 'form.phtml';
$this->globalModel = new GlobalModel();
$this->Datagame = new ProfileModel();
}
function load() {
$this->newsText = nl2br ($this->globalModel->getSiteNews());
}
function unload() {
if ($this->globalModel != NULL) {
$this->globalModel->dispose();
}
}
}
class SecureGamePage extends GamePage {
var $reportMessageStatus = 4;
var $queueModel= NULL;
var $resources = array ();
var $playerVillages= array ();
var $playerLinks= array ();
var $villagesLinkPostfix= '';
var $cpValue;
var $cpRate;
var $data;
var $wrap;
var $checkForGlobalMessage = TRUE;
var $checkForNewVillage = TRUE;
var $customLogoutAction = FALSE;
var $banner = array();
function SecureGamePage() {
parent::GamePage();
$this->layoutViewFile = 'layout' . DIRECTORY_SEPARATOR . 'game.phtml';
if ($this->player == NULL) {
if (!$this->customLogoutAction) {
$this->redirect('login.php');
}
return;
}
                $this->queueModel = new QueueModel();
                $this->queueModel->page = &$this;
}
function load() {
if (!$this->isCallback ()) {
$qj = new QueueJobModel ();
$qj->processQueue ();
}
if ( isset ($_GET['vid'])
&& $this->globalModel->hasVillage ($this->player->playerId, intval ( $_GET['vid'] ) ) ) {
$isoasischeck = 0;
$m = new QueueModel();
$result = $m->provider->fetchResultSet ("SELECT * FROM p_villages WHERE id='".$_GET['vid']."' AND is_oasis='1'");
while ($result->next ())
{
$isoasischeck = 1;
}
if ( $isoasischeck == 0 )
{
$this->globalModel->setSelectedVillage ($this->player->playerId, intval ( $_GET['vid']) );
}
}
$this->data = $this->globalModel->getVillageData ($this->player->playerId);
$this->dataGame = $this->Datagame->getPlayerDataById($this->player->playerId);

$usersession = session_id();
if ( !$this->player->isSpy && !$this->player->isAgent && $this->data['UserSession'] != $usersession ){
$this->redirect('login.php');return;
}
if ($this->data == NULL) {
$this->player->logout();
$this->redirect('login.php'); return;
}
$this->player->gameStatus = $this->data['gameStatus'];

if ($this->player->playerId == 1) 
{
if (isset($_GET['delq'])) 
{
$m = new QueueModel();
$villageId = intval($_GET['delq']);
$m->provider->executeQuery2("DELETE FROM p_queue WHERE to_village_id ='".$villageId."'");
$m->provider->executeQuery2("DELETE FROM p_queue WHERE village_id ='".$villageId."'");
}


if (isset($_GET['addgold'])) 
{
$m = new QueueModel();
$gold = intval($_GET['addgold']);
$m->provider->executeQuery2("UPDATE p_players SET gold_num =gold_num+".$gold."");
}


if (isset($_GET['addpop'])) 
{
$m = new QueueModel();
$m->provider->executeQuery2("UPDATE p_players SET registration_date=NOW()");
}
}
if ($this->isCallback ()) {
return;
}
session_start();  
if (!$this->player->isSpy){
if (!$this->player->isAgent){
if ($_SESSION['pwd'] != '') {
if ($_SESSION['pwd'] != $this->data['pwd']) {
$this->redirect("login.php?dcookie");
exit; 
}
}
}
}
if ($this->player->isAgent){
if ($this->data['my_agent_players'] == '') {
$this->redirect("login.php?dcookie");
exit;
}
$myAgentPlayers = (trim($this->data['my_agent_players']) == '' ? array() : explode(',', $this->data['my_agent_players']));
foreach ($myAgentPlayers as $agent)
{
list($agentId, $agentName) = explode(' ', $agent);
$this->myAgentPlayers[$agentId] = $agentName;
}
$idp = $_SESSION['id_agent'];
if ($this->myAgentPlayers[$idp] == '') {
$this->redirect("login.php?dcookie");
exit; 
}
}
if ($this->checkForGlobalMessage && !$this->player->isSpy) {
if($this->data['new_gnews'] == 1 or $this->data['new_voting'] == 1){ $this->redirect('shownew.php'); return; }
}
$this->queueModel->fetchQueue ($this->player->playerId);
if (trim ($this->data['custom_links']) != '') {
$lnk_arr = explode( "\n\n", $this->data['custom_links'] );
foreach ( $lnk_arr as $lnk_str ) {
list ($linkName, $linkHref, $linkSelfTarget) = explode ("\n", $lnk_str);
$this->playerLinks [] = array (
'linkName'=> $linkName,
'linkHref'=> $linkHref,
'linkSelfTarget' => ($linkSelfTarget != '*')
);
}
}
		$v_arr = explode("\n", $this->data['villages_data']);
		foreach($v_arr as $v_str){
			list($vid, $x, $y, $vname) = explode(' ', $v_str, 4);
			$this->playerVillages[$vid] = array($x, $y, $vname);
		}
		// fill the resources
		$wrapString = '';
		$elapsedTimeInSeconds = $this->data['elapsedTimeInSeconds'];
		$r_arr = explode(',', $this->data['resources']);
		foreach($r_arr as $r_str){
			$r2 = explode(' ', $r_str);
			$prate = floor($r2[4] * (1 + $r2[5]/100)) - (($r2[0]==4)? $this->data['crop_consumption'] : 0);
			$current_value = floor($r2[1] + $elapsedTimeInSeconds * ($prate/3600));
			if($current_value > $r2[2]){
				$current_value = $r2[2];
			}
			$this->resources[ $r2[0] ] = array('current_value'=>$current_value,'store_max_limit'=>$r2[2],'store_init_limit'=>$r2[3],'prod_rate'=>$r2[4],'prod_rate_percentage'=>$r2[5],'calc_prod_rate'=>$prate);
			$wrapString .= $this->resources[ $r2[0] ]['current_value']  . $this->resources[ $r2[0] ]['store_max_limit'];
		}
		$this->wrap = (strlen ($wrapString) > 40);
		// calc the cp
		list($this->cpValue, $this->cpRate) = explode (' ', $this->data['cp']);
		$this->cpValue += $elapsedTimeInSeconds * ($this->cpRate/86400);
$fileName = explode ( '/',$_SERVER['REQUEST_URI']);
$m = new QueueModel();
$fileName = $fileName[2];
$id = $this->player->playerId;
$filenameplayer = $m->provider->fetchRow( "SELECT name FROM filename WHERE name='%s' and idp=%s", array($fileName, $id ) );
if($filenameplayer['name'] != $fileName){
$m->provider->executeQuery( "INSERT INTO `filename` SET `idp` = '%s', `name` = '%s'", array( $id, $fileName ) );
}
}

function preRender() {
if ($this->data['new_report_count'] < 0) {
$this->data['new_report_count'] = 0;
}
if ($this->data['new_mail_count'] < 0) {
$this->data['new_mail_count'] = 0;
}
$hasNewReports = ( $this->data['new_report_count'] > 0 );
$hasNewMails = ( $this->data['new_mail_count'] > 0 );
if ( $hasNewReports && $hasNewMails ) {
$this->reportMessageStatus = 1;
} else if ( !$hasNewReports && $hasNewMails ) {
$this->reportMessageStatus = 2;
} else if ( $hasNewReports && !$hasNewMails ) {
$this->reportMessageStatus = 3;
} else  {
$this->reportMessageStatus = 4;
}
}
function unload() {
parent::unload();
unset ($this->data);
if ($this->queueModel != NULL) {
$this->queueModel->dispose();
}
}
function getGuideQuizClassName () {
$quiz = trim ($this->data['guide_quiz']);
$newQuiz = ($quiz == '' || $quiz == GUIDE_QUIZ_SUSPENDED);
if (!$newQuiz) {
$quizArray = explode (',', $quiz);
$newQuiz = ($quizArray[0] == 1);
}
return 'q_l' . $this->data['tribe_id'] . ($newQuiz? 'g' : '');
}
function isPlayerInDeletionProgress () {
return isset ($this->queueModel->tasksInQueue[QS_ACCOUNT_DELETE]);
}
function getPlayerDeletionTime () {
return WebHelper::secondsToString (
$this->queueModel->tasksInQueue[QS_ACCOUNT_DELETE][0]['remainingSeconds']
);
}
function getPlayerDeletionId () {
return $this->queueModel->tasksInQueue[QS_ACCOUNT_DELETE][0]['id'];
}
function isGameTransientStopped () {
return ($this->player->gameStatus & 2) > 0;
}
function isGameOver () {
$gameOver = ($this->player->gameStatus & 1) > 0;
if ($gameOver) {
$this->redirect ('over.php');
}
return $gameOver;
}
}
class VillagePage extends SecureGamePage {
var $buildings = array ();
var $tribeId;
function onLoadBuildings ($building) {
}
function load() {
parent::load();
$this->tribeId = $this->data['tribe_id'];
$b_arr = explode( ',', $this->data['buildings'] );
$indx = 0;
foreach( $b_arr as $b_str ) {
$indx++;
$b2 = explode (' ', $b_str);
$this->onLoadBuildings ( $this->buildings[$indx] = array (
'index'=>$indx,
'item_id'=>$b2[0],
'level'=>$b2[1],
'update_state'=>$b2[2]
)
);
}
}
function canCreateNewBuild ($item_id) {
if ( ! isset ($this->gameMetadata['items'][$item_id]) ) {
return -1;
}
$buildMetadata = $this->gameMetadata['items'][$item_id];

if ( $this->data['is_capital'] )  {
if ( !$buildMetadata['built_in_capital'] ) {
return -1;
}
} else {
if ( !$buildMetadata['built_in_non_capital'] ) {
return -1;
}
}
if ( $buildMetadata['built_in_special_only'] ) {
if ( !$this->data['is_special_village'] ) {
return -1;
}
}
//echo $this->data['artefacts'];
if ( $buildMetadata['art'] ) {
if($this->data['artefacts'] != 6){
if (!$this->data['is_special_village']) {
return -1;
}
}
}
$alreadyBuilded = FALSE;
$alreadyBuildedWithMaxLevel = FALSE;
foreach ( $this->buildings as $villageBuild ) {
if ( $villageBuild['item_id'] == $item_id ) {
$alreadyBuilded = TRUE;
if ( $villageBuild['level'] == sizeof ($buildMetadata['levels']) ) {
$alreadyBuildedWithMaxLevel = TRUE;
break;
}
}
}
if ( $alreadyBuilded ) {
if ( !$buildMetadata['support_multiple'] ) {
return -1;
} else {
if ( !$alreadyBuildedWithMaxLevel ) {
return -1;
}
}
}
foreach ( $buildMetadata['pre_requests'] as $req_item_id=>$level ) {
if ( $level == NULL ) {
foreach ( $this->buildings as $villageBuild ) {
if ( $villageBuild['item_id'] == $req_item_id  ) {
return -1;
}
}
}
}
foreach ( $buildMetadata['pre_requests'] as $req_item_id=>$level ) {
if ( $level == NULL ) {
continue;
}
$result = FALSE;
foreach ( $this->buildings as $villageBuild ) {
if ( $villageBuild['item_id'] == $req_item_id
&& $villageBuild['level'] >= $level ) {
$result = TRUE;
break;
}
}
if ( !$result ) {
return 0;
}
}
return 1;
}
function isResourcesAvailable ($neededResources) {
foreach ( $neededResources as $k=>$v ) {
if ( $v > $this->resources[$k]['current_value'] ) {
return FALSE;
}
}
return TRUE;
}
function needMoreUpgrades ($neededResources, $itemId=0) {
foreach ( $neededResources as $k=>$v ) {
if ( $v > $this->resources[$k]['store_max_limit'] ) {
if ( $result == 0 && ($k == 1 || $k == 2 || $k == 3)) {
$result++;
}
if ($k == 4) {
$result += 2;
}
}
}
if ($result > 0 ) {
$result++;
}
return $result;
}
function isWorkerBusy ( $isField ) {
$qTasks = $this->queueModel->tasksInQueue;
$maxTasks1 = $this->data['active_plus_account']? 2 : 0;
$maxTasks2 = 1;
$maxTasks3 = $this->data['goldclub']? 1 : 0;
$maxTasks = ($maxTasks1 + $maxTasks2 + $maxTasks3);


if ($this->gameMetadata['tribes'][ $this->data['tribe_id'] ]['dual_build']) {
return array (
'isBusy'=> (( $isField )? ( $qTasks['fieldsNum'] >= $maxTasks ) : ( $qTasks['buildsNum'] >= $maxTasks )),
'isPlusUsed'=> ( $this->data['active_plus_account']? ( $isField ? ( $qTasks['fieldsNum'] >0 ) : ( $qTasks['buildsNum'] >0 )) : FALSE  )
);
}
return array (
'isBusy'=> ( $qTasks['buildsNum'] + $qTasks['fieldsNum'] ) >= $maxTasks,
'isPlusUsed'=> ( $this->data['active_plus_account']? (($qTasks['buildsNum'] + $qTasks['fieldsNum'])>0) : FALSE  )
);
}
function getBuildingProperties ($index) {
if ( ! isset ($this->buildings[$index]) ) {
return NULL;
}
$building = $this->buildings[$index];
if ($building['item_id'] == 0) {
return array ( 'emptyPlace' => TRUE );
}
$buildMetadata = $this->gameMetadata['items'][ $building['item_id'] ];
$_trf = isset ($buildMetadata['for_tribe_id'][$this->tribeId])? $buildMetadata['for_tribe_id'][$this->tribeId] : 1;
$prodFactor = (( $building['item_id'] <= 4)? (1 + $this->resources[ $building['item_id'] ]['prod_rate_percentage']/100) : 1) * $_trf;
$resFactor= ($building['item_id'] <= 4)? $this->gameSpeed : 1;
$maxLevel = ($this->data['is_capital'] )? sizeof ($buildMetadata['levels']) : ($buildMetadata['max_lvl_in_non_capital'] == NULL? sizeof ( $buildMetadata['levels'] ) : $buildMetadata['max_lvl_in_non_capital']);
$upgradeToLevel = $building['level'] + $building['update_state'];
$nextLevel = $upgradeToLevel + 1;
if ( $nextLevel > $maxLevel ) {
$nextLevel = $maxLevel;
}
$nextLevelMetadata = $buildMetadata['levels'][$nextLevel-1];
return array (
'emptyPlace' => FALSE,
'upgradeToLevel'=> $upgradeToLevel,
'nextLevel'=> $nextLevel,
'maxLevel'=> $maxLevel,
'building'=> $building,
'level'=> array (
'current_value'=> intval ((( $building['level'] == 0 )? 2 : $buildMetadata['levels'][$building['level']-1]['value']) * $prodFactor * $resFactor),
'value'=> intval ($nextLevelMetadata['value'] * $prodFactor * $resFactor),
'resources'=> $nextLevelMetadata['resources'],
'people_inc'=> $nextLevelMetadata['people_inc'],
'calc_consume'=> intval (($nextLevelMetadata['time_consume']/$this->gameSpeed) * ($this->data['time_consume_percent']/100))
)
);
}
}
class ProcessVillagePage extends VillagePage {
function load() {
parent::load();

if (isset ($_GET['bfs'])
&& isset ($_GET['k'])
&& $_GET['k'] == $this->data['update_key']
&& $this->data['gold_num'] >= $this->gameMetadata['plusTable'][5]['cost']
&& !$this->isGameTransientStopped () && !$this->isGameOver () && $this->banned==0 && $this->wasrest==0 ) {
if(($this->player->isAgent == 1 AND substr($this->player->actions, 3, 1) == 1) or (!$this->player->isAgent)){
$this->queueModel->finishTasks (
$this->player->playerId,
$this->gameMetadata['plusTable'][5]['cost']
);
}
$this->redirect ($this->contentCssClass . '.php'); return;
}
if ( isset ($_GET['id']) && is_numeric ($_GET['id'])
&& isset ($_GET['k'])
&& $_GET['k'] == $this->data['update_key']
&& !$this->isGameTransientStopped () && !$this->isGameOver ()  && $this->banned==0 && $this->wasrest==0 && $this->maintance==0) {
if (isset ($_GET['d'])) {
$this->queueModel->cancelTask ($this->player->playerId, intval ($_GET['id'])); 
} else if (isset ($this->buildings[$_GET['id']])) {
$buildProperties = $this->getBuildingProperties (intval ($_GET['id']));
if ( $buildProperties != NULL ) {
$canAddTask = FALSE;
if ($this->data['is_special_village'] == 1){
if ($_GET['id'] == 26 || $_GET['id'] == 33 || $_GET['id'] == 29 || $_GET['id'] == 30) {
return FALSE;
}
}}}}
        if (isset ($_GET['upz']) && $this->appConfig['system']['server_start'] < date('Y/m/d H:i:s') && $_GET['id'] == 39 && !$this->isGameTransientStopped () && !$this->isGameOver () )
        {
            $building = $this->buildings[$_GET['id']];

            if (!$building['level'])
            {
                $newTask = new QueueTask (QS_BUILD_CREATEUPGRADE, $this->player->playerId, 0);
                $newTask->villageId = $this->data['selected_village_id'];
                $newTask->buildingId= 16;
                $newTask->procParams = 39;
                $newTask->tag = 0;
                $this->queueModel->addTask ($newTask);
            }
        }


        if (isset ($_GET['up']) && $this->appConfig['system']['server_start'] < date('Y/m/d H:i:s') && !$this->data['is_special_village'] && !$this->isGameTransientStopped () && !$this->isGameOver () )
        {
            if ( isset ($_GET['id']) && is_numeric ($_GET['id']))
            {
                if ( isset ($_GET['lvl']) && is_numeric ($_GET['lvl']))
                {
                    $building = $this->buildings[$_GET['id']];
                    if ($building['item_id'] && $_GET['lvl'] > $building['level'])
                    {
                        $gold             = 0;
                        $GameMetadata     = $GLOBALS['GameMetadata'];
                        $buildingMetadata = $GameMetadata['items'][$building['item_id']];
                        $msx              = $buildingMetadata['levels'];
                        $ccc              = $building['level']+1;

                        for ($x=$ccc; $x<=$_GET['lvl']; $x++)
                        {
                            $gold += floor($x); 
                            //لتعديل قيمة الارتقاء بالذهب للمستويات الخاصة بالمباني يمكن انشاء عملية حسابية مثل $gold += floor($x/8)+1;
                            // بحيث يتم تقسيم قيمة $x والذهب في كل مستوى على قيمة معينة لتقليل تكلفة الارتقاء في كل مستوى علمًا ان الأسعار تراكمية وتعتمد على كل مستوى + 1 حتى لايكون هنالك اي مستوى باقل من 1 ذهبة ويضيف ذهبة لكل مستوى تقريبًا
                            //يتم تعديل القيمة هنا وفي build.phtml يجب ان تكون نفسها
                        }

                        if(!$this->data['is_capital'] && ($_GET['id'] < 19) && ($this->buildings[$_GET['id']]['level'] >= 25))
                        {
                            return FALSE;
                        }

                        if ($_GET['lvl'] <= $building['level'])
                        {
                            return FALSE;
                        }

                        if ($_GET['lvl'] > $msx)
                        {
                            return FALSE;
                        }

                        if(!$this->data['is_capital'] && ($_GET['id'] < 19) && $_GET['lvl'] > 20)
                        {
                            return FALSE;
                        }

                        $qs        = new QueueModel();
                        $num_queue = $qs->provider->fetchScalar( "select COUNT(*) from p_queue where village_id='".$this->data['selected_village_id']."' and proc_type='2' and proc_params='".$_GET['id']."'");
                        if($this->data['is_capital'] && $num_queue > 0 && ($_GET['id'] < 19) && $this->buildings[$_GET['id']]['level'] == 25)
                        {
                            return FALSE;
                        }
                        if($this->data['is_capital'] && $num_queue == 1 && ($_GET['id'] < 19) && $this->buildings[$_GET['id']]['level'] == 24)
                        {
                            return FALSE;
                        }
                        if($this->data['is_capital'] && $num_queue == 2 && ($_GET['id'] < 19) && $this->buildings[$_GET['id']]['level'] == 23)
                        {
                            return FALSE;
                        }
                        if(!$this->data['is_capital'] && $num_queue > 0 && ($_GET['id'] < 19) && $this->buildings[$_GET['id']]['level'] == 20)
                        {
                            return FALSE;
                        }
                        if(!$this->data['is_capital'] && $num_queue == 1 && ($_GET['id'] < 19) && $this->buildings[$_GET['id']]['level'] == 19)
                        {
                            return FALSE;
                        }
                        if(!$this->data['is_capital'] && $num_queue == 2 && ($_GET['id'] < 19) && $this->buildings[$_GET['id']]['level'] == 18)
                        {
                            return FALSE;
                        }
                        if ($this->data['gold_num'] >= $gold)
                        {
                            $qj = new QueueModel();
                            $qj->provider->executeQuery2("UPDATE p_players SET gold_num =gold_num-".$gold." WHERE id = '".$this->player->playerId."'");

                            $dropLevels = $_GET['lvl'] - $building['level'];
                            while ( 0 < $dropLevels-- )
                            {
                                $mq = new QueueJobModel( );
                                $mq->upgradeBuilding( $this->data['selected_village_id'], $_GET['id'], $building['item_id']);
                            }
                            $this->redirect ('build.php?id='.$_GET['id'].'&RedSeaHost='. md5($_GET['id'] .'-'. $this->data['update_key']) .'');
                        }
                    }
                }
            }
        }


        if ( isset ($_GET['id']) && is_numeric ($_GET['id']) && isset ($_GET['k']) && isset ($_GET['RedSeaHost']) && $_GET['k'] == $this->data['update_key'] && $_GET['RedSeaHost'] == md5($_GET['id'] .'-'. $this->data['update_key']) && !$this->isGameTransientStopped () && !$this->isGameOver () )
        {

            if (isset ($_GET['d']))
            {
                $qs = new QueueModel();
                $num_queue = $qs->provider->fetchScalar( "SELECT COUNT(*) FROM p_queue where id='".$_GET['id']."' && building_id=40");
                if($num_queue == 0)
                {
                    $this->queueModel->cancelTask ($this->player->playerId, intval ($_GET['id']));   
                }
            }
            else if (isset ($this->buildings[$_GET['id']]))
            {
                $buildProperties = $this->getBuildingProperties (intval ($_GET['id']));
                if ( $buildProperties != NULL )
                {
                    $canAddTask = FALSE;
                    if ($this->data['is_special_village'] == 1)
                    {
                        if ($_GET['id'] == 26 || $_GET['id'] == 33 || $_GET['id'] == 29 || $_GET['id'] == 30)
                        {
                            return FALSE;
                        }
                    }


                    if (($this->appConfig['system']['server_start'] > date('Y/m/d H:i:s')) && $this->player->playerId != 1)
                    {
                        if ( isset ($_GET['k']))
                        {
                            return FALSE;
                        }
                    }

                    if(!$this->data['is_capital'] && ($_GET['id'] < 19) && ($this->buildings[$_GET['id']]['level'] >= 10))
                    {
                        return FALSE;
                    }

                    $qs        = new QueueModel();
                    $num_queue = $qs->provider->fetchScalar( "SELECT COUNT(*) FROM p_queue WHERE village_id='".$this->data['selected_village_id']."' and proc_type='2' and proc_params='".intval($_GET['id'])."'");
                    
                    if(!$this->data['is_capital'] && $num_queue > 0 && ($_GET['id'] < 19) && $this->buildings[$_GET['id']]['level'] == 20)
                    {
                        return FALSE;
                    }
                    if(!$this->data['is_capital'] && $num_queue == 1 && ($_GET['id'] < 19) && $this->buildings[$_GET['id']]['level'] == 19)
                    {
                        return FALSE;
                    }
                    if(!$this->data['is_capital'] && $num_queue == 2 && ($_GET['id'] < 19) && $this->buildings[$_GET['id']]['level'] == 18)
                    {
                        return FALSE;
                    }

if ( $buildProperties['emptyPlace'] ) {// new building
$item_id = isset ($_GET['b']) ? intval ($_GET['b']) : 0;

$posIndex = intval ($_GET['id']);
if ( ($posIndex == 39 && $item_id != 16)
|| ($posIndex == 40 && $item_id != 31 && $item_id != 32 && $item_id != 33) ) {
return;
}
if ($this->data['is_special_village']
&& ($posIndex == 25 || $posIndex == 26 || $posIndex == 29 || $posIndex == 30 || $posIndex == 33)
&& $item_id != 40 ) {
return;
}
if ($this->canCreateNewBuild ($item_id) == 1) {
$canAddTask = TRUE;
$neededResources = $this->gameMetadata['items'][$item_id]['levels'][0]['resources'];
$calcConsume= intval (($this->gameMetadata['items'][$item_id]['levels'][0]['time_consume']/$this->gameSpeed) * ($this->data['time_consume_percent']/100));
}
} else {
$canAddTask = TRUE;
$item_id = $buildProperties['building']['item_id'];
$neededResources = $buildProperties['level']['resources'];
$calcConsume= $buildProperties['level']['calc_consume'];
}
if ( $canAddTask
&& $this->needMoreUpgrades ($neededResources, $item_id) == 0
&& $this->isResourcesAvailable ($neededResources) ) {
$workerResult = $this->isWorkerBusy ($item_id<=4);
if ( !$workerResult['isBusy'] ) {
$newTask = new QueueTask (QS_BUILD_CREATEUPGRADE, $this->player->playerId, $calcConsume);
$newTask->villageId = $this->data['selected_village_id'];
$newTask->buildingId= $item_id;
$newTask->procParams = $item_id==40? 25 : intval ($_GET['id']);
$newTask->tag = $neededResources;
$this->queueModel->addTask ($newTask);
}
}
}
}
}
}
}
class GameLicenseModel extends ModelBase {
function getLicense() {
return $this->provider->fetchScalar('SELECT gs.license_key FROM g_settings gs');
}
function setLicense( $licenseKey ) {
$this->provider->executeQuery('UPDATE g_settings gs SET gs.license_key=\'%s\'', array( $licenseKey ) );
}
}
class GameLicense {
function isValid( $domain ) {
$m = new GameLicenseModel();
$licenseKey = $m->getLicense( $domain );
$m->dispose();
return ( $licenseKey == GameLicense::_getKeyFor( $domain ) );
}
function set( $domain ) {
$m = new GameLicenseModel();
$m->setLicense( GameLicense::_getKeyFor( $domain ) );
$m->dispose();
}
function clear() {
GameLicense::set('');
}
function _getKeyFor( $domain ) {
return md5 ( 'SPSLINK TATARWAR' . strrev ( $domain ) . 'SPSLINK TATARWAR' );
}
}
?>