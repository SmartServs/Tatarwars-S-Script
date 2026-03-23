<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require("." . DIRECTORY_SEPARATOR . "core-s" . DIRECTORY_SEPARATOR . "smartservs-tcex-boot.php");
require_once(MODEL_PATH . "msg.php");
require_once(MODEL_PATH."wordsfilter.php");
require_once( MODEL_PATH."notes.php" );
class GPage extends SecureGamePage
    {
    public $saved = NULL;
    var $showList;
    var $selectedTabIndex;
    var $errorText;
    var $receiver;
    var $subject;
    var $body;
    var $messageDate;
    var $messageTime;
    var $showFriendPane;
    var $friendsList;
    var $viewOnly;
    var $isInbox;
    var $sendMail;
    var $dataList;
    var $pageSize = 20;
    var $pageCount;
    var $pageIndex;
    function GPage()
        {
        parent::securegamepage();
        $this->viewFile        = "msg.phtml";
        $this->contentCssClass = "messages";
        }
    function load()
        {
        parent::load();
if ($this->data['player_type'] == PLAYERTYPE_ADMIN)
{
if (isset($_GET['id'])) {
//exit;
}
}
        $this->Filter           = new FilterWordsModel();
        $this->sendMail         = TRUE;
        $this->isInbox          = TRUE;
        $this->viewOnly         = FALSE;
        $this->showFriendPane   = FALSE;
        $this->errorText        = "";
        $this->showList         = !(isset($_GET['t']) && is_numeric($_GET['t']) && intval($_GET['t']) == 1);
        $this->selectedTabIndex = isset($_GET['t']) && is_numeric($_GET['t']) && 1 <= intval($_GET['t']) && intval($_GET['t']) <= 3 ? intval($_GET['t']) : 0;
        $this->friendList       = array();
        $friends_player_ids     = trim($this->data['friend_players']);
        if ($friends_player_ids != ""){
            $friends_player_ids = explode("\n", $friends_player_ids);
            foreach ($friends_player_ids as $friend){
                list($playerId, $playerName) = explode(' ', $friend);
                $this->friendList[$playerId] = $playerName;
            }
        }
        if ($this->selectedTabIndex == 3){
            if ( !$this->data['active_plus_account'] ) {
                exit( 0 );
            }else{
                 $this->saved = FALSE;
                 if ( $this->isPost( ) && isset( $_POST['notes'] ) ){
                    $this->data['notes'] = $_POST['notes'];
                    $m = new NotesModel( );
                    $m->changePlayerNotes( $this->player->playerId, $this->data['notes'] );
                    $m->dispose( );
                    $this->saved = TRUE;
                }
            }
        }
        $m = new MessageModel();
        if (!$this->isPost()){
            if (isset($_GET['uid']) && is_numeric($_GET['uid']) && 0 < intval($_GET['uid'])){
                $this->receiver = $m->getPlayerNameById(intval($_GET['uid']));
                $this->showList         = FALSE;
                $this->selectedTabIndex = 1;
            }else if (isset($_GET['id']) && is_numeric($_GET['id']) && 0 < intval($_GET['id'])){
                $result = $m->getMessage($this->player->playerId, intval($_GET['id']));
                if ($result->next()){
                    $this->viewOnly = TRUE;
                    $this->showList = FALSE;
                    $this->isInbox = $result->row['to_player_id'] == $this->player->playerId;
                    $this->sendMail = !$this->isInbox;
                    $this->receiver = $this->isInbox ? $result->row['from_player_name'] : $result->row['to_player_name'];
                    $this->subject  = $result->row['msg_title'];
                    if ($this->player->playerId == 1 or $result->row['from_player_name'] == $GLOBALS['AppConfig']['system']['adminName'] or $result->row['to_player_name'] == $GLOBALS['AppConfig']['system']['adminName']) {
                         $this->body = $result->row['msg_body'];
                    }else{
                        $this->body = $this->getFilteredText($result->row['msg_body']);
                    }
                    $this->messageDate = $result->row['mdate'];
                    $this->messageTime = $result->row['mtime'];
                    $this->selectedTabIndex = $this->isInbox ? 0 : 2;
                    if ($this->isInbox && !$result->row['is_readed'] && !$this->player->isSpy){
                        $m->markMessageAsReaded($this->player->playerId, intval($_GET['id']));
                        --$this->data['new_mail_count'];
                    }
                }else{
                    $this->showList = TRUE;
                    $this->selectedTabIndex = 0;
                }
                $result->free();
            }
        }else if (isset($_POST['sm'])){
            $filter = new FilterWordsModel();
            $this->receiver = (strip_tags(trim($_POST['an'])));
            $this->subject  = ($filter->FilterWords(strip_tags(trim($_POST['be']))));
            $this->body     = (strip_tags(trim($_POST['message'])));
            $timeout =  date('Y/n/d  - h:i:s',$time);
            $hi = $this->data['blocked_time'];
            $p = $this->data['total_people_count'];
            $time =  $this->data['blocked_time'];
            include( APP_PATH.'flood.php' );
            $cliprz = new cliprz_flood(); 
            $cliprz->cliprz_session(); 
            $des = $cliprz->cliprz_request();
            $slmt = $cliprz->check_sndlmt();
            if($slmt){
                include(MODEL_PATH.'A-D-E-D-S.php');
                $admn = new AdminCp();
                $time = time()+(60*60*9999);
                $reason = "مخالفة شروط اللعبه";
                $playername = $m->getPlayerNameById($this->player->playerId);
                $this->player->playerId = 1; 
                $admn = new AdminCp();
                 $admn->provider->executeQuery( "UPDATE p_players p SET p.blocked_time='%s', p.blocked_reason='%s' WHERE p.name='%s'", array($time, $reason, $playername) );
                
           
                /*if ($this->subject == ""){
                    $this->subject = messages_p_emptysub;
                }
                if (trim($this->body) == ""){
                    $this->showList         = FALSE;
                    $this->selectedTabIndex = 1;
                    $this->errorText        = messages_p_nobody . "<p></p>";
                    $m->dispose();
                }else{
                    $receiverPlayerId = 1;
                    $this->receiver = $m->getPlayerNameById($receiverPlayerId);
                    $m->sendMessage($this->player->playerId, $this->data['name'], $receiverPlayerId, $this->receiver, $this->subject, $this->body);
                    $this->showList         = TRUE;
                    $this->selectedTabIndex = 2;
                }*/
            }else{
                        
            $_SESSION['cliprz_request'] = time();
            if (($hi > time()) and ($this->player->playerId != 1) and ($_POST['an'] != $GLOBALS['AppConfig']['system']['adminName'])){
                $this->showList         = FALSE;
                $this->selectedTabIndex = 1;
                $this->redirect ('banned.php');
                return null;
                $m->dispose();
            }else  if (($p <= 900) and ($this->player->playerId != 1) and ($_POST['an'] != $GLOBALS['AppConfig']['system']['xx3413234'])){
                $this->showList         = FALSE;
                $this->selectedTabIndex = 1;
                $this->errorText        = "لايمكنك ارسال رسالة وسكانك اقل من 900<p></p>";
                $m->dispose();
            }else if (trim($this->receiver) == ""){
                $this->showList         = FALSE;
                $this->selectedTabIndex = 1;
                $this->errorText        = messages_p_noreceiver . "<p></p>";
                $m->dispose();
            }else if (trim($this->body) == ""){
                $this->showList         = FALSE;
                $this->selectedTabIndex = 1;
                $this->errorText        = messages_p_nobody . "<p></p>";
                $m->dispose();
            }else if (strtolower(trim($this->receiver)) == "[ally]" && 0 < intval($this->data['alliance_id']) && $this->hasAllianceSendMessageRole()){
                $pids = trim($m->getAlliancePlayersId(intval($this->data['alliance_id'])));
                if ($pids != ""){
                    if ($this->subject == ""){
                        $this->subject = messages_p_emptysub;
                    }
                    $arr = explode(",", $pids);
                    foreach ($arr as $apid) {
                        if ($apid == $this->player->playerId){
                            continue;
                        }
                        $m->sendMessage($this->player->playerId, $this->data['name'], $apid, $m->getPlayerNameById($apid), $this->subject, $this->body);
                    }
                    $this->showList = TRUE;
                    $this->selectedTabIndex = 2;
                }
            }else if (strtolower(trim($this->receiver)) == "[ally]" && !$this->hasAllianceSendMessageRole()) {
                $this->showList  = FALSE;
                $this->selectedTabIndex = 1;
                $this->errorText= "<b>انت لاتملك هذه الخاصيه</b><p></p>";
            }else{
                $receiverPlayerId = $m->getPlayerIdByName($this->receiver);
                if (0 < intval($receiverPlayerId)){
                    if ($receiverPlayerId == $this->player->playerId){
                        $this->showList         = FALSE;
                        $this->selectedTabIndex = 1;
                        $this->errorText        = "<b>" . messages_p_noloopback . "</b><p></p>";
                    }else{
                        if ($this->subject == ""){
                            $this->subject = messages_p_emptysub;
                        }
                        session_start();  
                        $_SESSION['last_msg_send'] = time();
                        if ($receiverPlayerId == 1){
                            $to = "f5@hotmail.com"; 
                            $you = "virus@topmail.com"; 
                            $v = "".$this->data['name']."-"; 
                            $v .= $this->subject; 
                            mail ( "$to" , "$v" , "$this->body" , "Form:$you" );
                        }
                        
                        $m->sendMessage($this->player->playerId, $this->data['name'], $receiverPlayerId, $this->receiver, $this->subject, $this->body);
                        $this->showList         = TRUE;
                        $this->selectedTabIndex = 2;
                    }
                }else{
                    $this->showList         = FALSE;
                    $this->selectedTabIndex = 1;
                    $this->errorText        = messages_p_notexists . " <b>" . $this->receiver . "</b><p></p>";
                }
            }
         }
       } else if (isset($_POST['fm']))
            {
            $this->receiver         = (strip_tags(trim($_POST['an'])));
            $this->subject          = (strip_tags(trim($_POST['be'])));
            $this->body             = (strip_tags(trim($_POST['message'])));
            $this->showList         = FALSE;
            $this->selectedTabIndex = 1;
            $this->showFriendPane   = TRUE;
            if ($_POST['fm'] != "" && is_numeric($_POST['fm']))
                {
                $playerId = intval($_POST['fm']);
                if (0 < $playerId && isset($this->friendList[$playerId]))
                    {
                    unset($this->friendList[$playerId]);
                    }
                }
            else if (isset($_POST['mfriends']))
                {
                foreach ($_POST['mfriends'] as $friendName)
                    {
                    $friendName = trim($friendName);
                    if ($friendName == "")
                        {
                        continue;
                        }
                    $playerId = intval($m->getPlayerIdByName($friendName));
                    if (0 < $playerId && !isset($this->friendList[$playerId]) && $playerId != $this->player->playerId)
                        {
                        $this->friendList[$playerId] = $friendName;
                        }
                    }
                }
            $friends = "";
            foreach ($this->friendList as $k => $v)
                {
                if ($friends != "")
                    {
                    $friends .= "\n";
                    }
                $friends .= $k . " " . $v;
                }
            $m->saveFriendList($this->player->playerId, $friends);
            }
        else if (isset($_POST['rm']))
            {
            $filter = new FilterWordsModel();
            $this->receiver = (strip_tags(trim($_POST['an'])));
            $this->subject  = ($filter->FilterWords(strip_tags(trim($_POST['be']))));
            $this->body     = PHP_EOL . PHP_EOL . "- - - - - - - - - - - - - - -" . PHP_EOL . text_from_lang . " " . $this->receiver . ":" . PHP_EOL . PHP_EOL . (strip_tags(trim($_POST['message'])));
            preg_match("/^(رد)\\^?([0-9]*):([\\w\\W]*)\$/", $this->subject, $matches);
            if (sizeof($matches) == 4)
                {
                $this->subject = ("رد^" . ($matches[2] + 1)) . ":" . $matches[3];
                }
            else
                {
                $this->subject = "رد: " . $this->subject;
                }
            $this->showList         = FALSE;
            $this->selectedTabIndex = 1;
            }
        else if (isset($_POST['dm']) && isset($_POST['dm']))
            {
            foreach ($_POST['dm'] as $messageId)
                {
                if ($m->deleteMessage($this->player->playerId, $messageId))
                    {
                    --$this->data['new_mail_count'];
                    }
                }
            }
        if ($this->showList)
            {
            $rowsCount       = $m->getMessageListCount($this->player->playerId, $this->selectedTabIndex == 0);
            $this->pageCount = 0 < $rowsCount ? ceil($rowsCount / $this->pageSize) : 1;
            $this->pageIndex = isset($_GET['p']) && is_numeric($_GET['p']) && intval($_GET['p']) < $this->pageCount ? intval($_GET['p']) : 0;
            $this->dataList  = $m->getMessageList($this->player->playerId, $this->selectedTabIndex == 0, $this->pageIndex, $this->pageSize);
            if (0 < $this->data['new_mail_count'])
                {
                $this->data['new_mail_count'] = $m->syncMessages($this->player->playerId);
                }
            }
        $m->dispose();
        }
    function getFilteredText($text)
        {
        $filter = new FilterWordsModel();
        return $filter->FilterWords($text);
        return $filter->FilterWords($_POST['an']);
                        
        }
    function _hasAllianceRole($role)
        {
        $alliance_roles = trim($this->data['alliance_roles']);
        if ($alliance_roles == "")
            {
            return FALSE;
            }
        list($roleNumber, $roleName) = explode(' ', $alliance_roles, 2);
        return $roleNumber & $role;
        }
    function hasAllianceSendMessageRole()
        {
        return $this->_hasAllianceRole(ALLIANCE_ROLE_SENDMESSAGE);
        }
    function preRender()
        {
        parent::prerender();
        if (isset($_GET['uid']))
            {
            $this->villagesLinkPostfix .= "&uid=" . intval($_GET['uid']);
            }
        if (isset($_GET['id']))
            {
            $this->villagesLinkPostfix .= "&id=" . intval($_GET['id']);
            }
        if (isset($_GET['p']))
            {
            $this->villagesLinkPostfix .= "&p=" . intval($_GET['p']);
            }
        if (0 < $this->selectedTabIndex)
            {
            $this->villagesLinkPostfix .= "&t=" . $this->selectedTabIndex;
            }
        }
    function getNextLink()
        {
        $text = "»";
        if ($this->pageIndex + 1 == $this->pageCount)
            {
            return $text;
            }
        $link = "";
        if (0 < $this->selectedTabIndex)
            {
            $link .= "t=" . $this->selectedTabIndex;
            }
        if ($link != "")
            {
            $link .= "&";
            }
        $link .= "p=" . ($this->pageIndex + 1);
        $link = "msg.php?" . $link;
        return "<a href=\"" . $link . "\">" . $text . "</a>";
        }
    function getPreviousLink()
        {
        $text = "«";
        if ($this->pageIndex == 0)
            {
            return $text;
            }
        $link = "";
        if (0 < $this->selectedTabIndex)
            {
            $link .= "t=" . $this->selectedTabIndex;
            }
        if (1 < $this->pageIndex)
            {
            if ($link != "")
                {
                $link .= "&";
                }
            $link .= "p=" . ($this->pageIndex - 1);
            }
        if ($link != "")
            {
            $link = "?" . $link;
            }
        $link = "msg.php" . $link;
        return "<a href=\"" . $link . "\">" . $text . "</a>";
        }
    }
$p = new GPage();
$p->run();
?>