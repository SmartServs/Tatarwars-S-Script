<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
####################################################

require_once(MODEL_PATH . "report.php");
require_once(MODEL_PATH . "mutex.php");
class QueueJobModel extends ModelBase
    {
        function deleteInactivePlayers ()
        {
                $result = $this->provider->fetchResultSet ("SELECT id, name FROM p_players WHERE UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(registration_date)>432000 AND is_active = 0");
                while ($result->next())
                        $this->deletePlayer ($result->row["id"]);
                $this->provider->executeQuery ("UPDATE g_summary SET active_players_count = (SELECT COUNT(*) FROM p_players WHERE is_active = 1)");
                        // This crap will delete every unactivated player registered more than 3 days ago.
        }

    function processQueue()

        {

        $mutex = new MutexModel();

        $mutex->releaseOnTimeout();

        if ($mutex->lock())

            {

            $this->processTaskQueue();

            if (date('w') == 5)

                {

                $row = $this->provider->fetchRow('SELECT gs.cur_week w1, CEIL((TO_DAYS(NOW())-TO_DAYS(gs.start_date))/7) w2 FROM g_settings gs');

                if ($row['w1'] < $row['w2'])

                    {

                    $this->provider->executeQuery('UPDATE g_settings gs SET gs.cur_week=%s', array(

                        intval($row['w2'])

                    ));
                    $this->provider->executeQuery ('UPDATE p_players SET total_people_count = 0 WHERE total_people_count < 0');
                    $this->provider->executeQuery ('UPDATE p_villages SET people_count= 0 WHERE people_count < 0');
                             $this->artefacts = $this->provider->fetchRow( "SELECT `artefacts` FROM  `p_villages` WHERE type='1'" );
         $this->artefacts = $this->artefacts['artefacts'];
         $n = $this->artefacts+1;
         if ($n >= 6) {
         $n = 1;
         }
         $art = $n;
         $this->provider->executeQuery( "UPDATE p_villages SET artefacts='".$art."' WHERE type='1'");
         $this->provider->executeQuery( "UPDATE p_players SET gold_num = gold_num + 500");
                    $this->setWeeklyMedals(intval($row['w2']));

                    }

                }

            $mutex->release();

            }

        }
public function processTaskQueue()
 
 
 
 
 {
$result = $this->provider->fetchResultSet("SELECT \r\n\t\t\t\tq.id, q.player_id, q.village_id, q.to_player_id, q.to_village_id, q.proc_type, q.building_id, q.proc_params, q.threads, q.execution_time,\r\n\t\t\t\tTIME_TO_SEC(TIMEDIFF(q.end_date, NOW())) remainingTimeInSeconds\r\n\t\t\tFROM p_queue q\r\n\t\t\tWHERE\r\n\t\t\t\tTIME_TO_SEC(TIMEDIFF((q.end_date - INTERVAL (q.execution_time*(q.threads-1)) SECOND), NOW())) <= 0\r\n\t\t\tORDER BY\r\n\t\t\t\tTIME_TO_SEC(TIMEDIFF((q.end_date - INTERVAL (q.execution_time*(q.threads-1)) SECOND), NOW())) ASC");
        while ($result->next())
 {
     
     
 		    
  
     
if($result->row['proc_type'] == 14 OR $result->row['proc_type'] == 12 OR $result->row['proc_type'] == 13) {
    
    
 

$dontqueue = false;
$makefile = true;
 $remain = $result->row['remainingTimeInSeconds'];
 
 
 if ( $remain < 0 )
 {
 $remain = 0;
 }
  

 $fh="core-s/mod-s/smart/qqw/".$result->row['id'];

 
 if(file_exists($fh))
 {
	 
 $makefile = false;
 }
 if($makefile == true)
 {
 $fh=fopen($fh, "w");
 fclose($fh);
 $dontqueue = true;
 }
 if($dontqueue == true)
 {
 $result->row['threads_completed_num'] = $result->row['execution_time'] <= 0 ? $result->row['threads'] : floor(($result->row['threads'] * $result->row['execution_time'] - $remain) / $result->row['execution_time']);
           
		   if ( !$this->processTask( $result->row ) )
 {
 continue;
 }
 $result->free( );
 $this->processTaskQueue( );
 break;
 }
 
 
 }else{

            $remain = $result->row['remainingTimeInSeconds'];
            if ($remain < 0)
                {
                $remain = 0;
                }
 $result->row['threads_completed_num'] = $result->row['execution_time'] <= 0 ? $result->row['threads'] : floor(($result->row['threads'] * $result->row['execution_time'] - $remain) / $result->row['execution_time']);
                       if ($this->processTask($result->row))
                {
                $result->free();
                $this->processTaskQueue();
                break;
                }
            
 }
 }
 }       
    public function setWeeklyMedals( $week )
    {
        require_once( MODEL_PATH."statistics.php" );
        $keyArray = array( "week_dev_points" => 1, "week_attack_points" => 2, "week_defense_points" => 3, "week_thief_points" => 4 );
        $sm = new StatisticsModel( );
        foreach ( $keyArray as $columnName => $index )
        {
            $result = $sm->getTop10( TRUE, $columnName );
            if ( $result != NULL )
            {
                $i = 0;
                while ( $result->next( ) )
                {
$num = $this->provider->fetchRow( "SELECT * FROM p_players  WHERE id='%s'", array(
            $result->row['id']
                ) );

                $a = $num[''.$columnName.''];
                    $medal = $index.":".++$i.":".$week.":".$a;
                    $this->provider->executeQuery( "UPDATE p_players SET medals=CONCAT_WS(',', medals, '%s') WHERE id=%s", array(
                        $medal,
                        $result->row['id']
                    ) );
                }
            }
            $result = $sm->getTop10( FALSE, $columnName );
            if ( !( $result != NULL ) )
            {
                continue;
            }
            $i = 0;
            while ( $result->next( ) )
            {
$num = $this->provider->fetchRow( "SELECT * FROM p_alliances WHERE id='%s'", array(
            $result->row['id']
                ) );
                $a = $num[''.$columnName.''];
                $medal = ( $index + 4 ).":".++$i.":".$week.":".$a;
                $this->provider->executeQuery( "UPDATE p_alliances SET medals=CONCAT_WS(',', medals, '%s') WHERE id=%s", array(
                    $medal,
                    $result->row['id']
                ) );
            }
        }
        $this->provider->executeQuery( "UPDATE p_players   SET week_dev_points=0, week_attack_points=0, week_defense_points=0, week_thief_points=0" );
        $this->provider->executeQuery( "UPDATE p_alliances SET week_dev_points=0, week_attack_points=0, week_defense_points=0, week_thief_points=0" );
        $sm->dispose( );
    }    function processTask($taskRow)
        {
        $customAction = FALSE;
        switch ($taskRow['proc_type'])
        {
            case QS_ACCOUNT_DELETE:
                {
                $this->deletePlayer($taskRow['player_id']);
                break;
                }
            case QS_BUILD_CREATEUPGRADE:
                {
                $customAction = $this->executeBuildingTask($taskRow);
                break;
                }
            case QS_BUILD_DROP:
                {
                $customAction = $this->executeBuildingDropTask($taskRow);
                break;
                }
            case QS_TROOP_RESEARCH:
                {
                }
            case QS_TROOP_UPGRADE_ATTACK:
                {
                }
            case QS_TROOP_UPGRADE_DEFENSE:
                {
                $this->executeTroopUpgradeTask($taskRow);
                break;
                }
            case QS_TROOP_TRAINING:
                {
                $this->executeTroopTrainingTask($taskRow);
                break;
                }
            case QS_TROOP_TRAINING_HERO:
                {
                $this->executeHeroTask($taskRow);
                break;
                }
            case QS_TOWNHALL_CELEBRATION:
                {
                $this->executeCelebrationTask($taskRow);
                break;
                }
            case QS_MERCHANT_GO:
                {
                $customAction = $this->executeMerchantTask($taskRow);
                break;
                }
            case QS_MERCHANT_BACK:
                {
				$this->rebroadcastMerchant($taskRow);
                break;
                }
            case QS_WAR_REINFORCE:
                {
                }
            case QS_WAR_ATTACK:
                {
                }
            case QS_WAR_ATTACK_PLUNDER:
                {
                }
            case QS_WAR_ATTACK_SPY:
                {
                }
            case QS_CREATEVILLAGE:
                {
                $customAction = $this->executeWarTask($taskRow);
                break;
                }
            case QS_LEAVEOASIS:
                {
                $this->executeLeaveOasisTask($taskRow);
                break;
                }
            case QS_PLUS1:
                {
                $this->provider->executeQuery('UPDATE p_players p SET p.active_plus_account=0 WHERE p.id=%s', array(
                    intval($taskRow['player_id'])
                ));
                break;
                }
            case QS_PLUS2:
                {
                $this->executePlusTask($taskRow, 1);
                break;
                }
            case QS_PLUS3:
                {
                $this->executePlusTask($taskRow, 2);
                break;
                }
            case QS_PLUS4:
                {
                $this->executePlusTask($taskRow, 3);
                break;
                }
            case QS_PLUS5:
                {
                $this->executePlusTask($taskRow, 4);
                break;
                }
            case QS_TATAR_RAISE:
                {
                $this->createTatarVillages();
                break;
                }
           case QS_TATAR_ART:
                {
                $this->createTatarArt();
                break;
                }
            case QS_SITE_RESET:
                {
                $this->dispose();
                }
        }
        if (!$customAction)
            {
            $remaining_thread = $taskRow['threads'] - $taskRow['threads_completed_num'];
            if ($remaining_thread <= 0)
                {
                $this->provider->executeQuery("DELETE FROM p_queue WHERE id=%s", array(
                    intval($taskRow['id'])
                ));
                }
            else
                {
                $this->provider->executeQuery("UPDATE p_queue q SET q.threads=%s WHERE q.id=%s", array(
                    intval($remaining_thread),
                    intval($taskRow['id'])
                ));
                }
            }
        return $customAction;
        }
    public function cropBalance($playerId, $villageId)
        {
        $row = $this->provider->fetchRow("SELECT\r\n\t\t\t\tv.crop_consumption, \r\n\t\t\t\tv.people_count,\r\n\t\t\t\tv.resources, v.cp,\r\n\t\t\t\tv.troops_num, v.troops_out_num, v.troops_intrap_num,\r\n\t\t\t\tTIME_TO_SEC(TIMEDIFF(NOW(), v.last_update_date)) elapsedTimeInSeconds,\r\n\t\t\t\tTIME_TO_SEC(TIMEDIFF(NOW(), v.creation_date)) oasisElapsedTimeInSeconds\r\n\t\t\tFROM p_villages v \r\n\t\t\tWHERE v.id=%s AND v.player_id=%s", array(
            intval($villageId),
            intval($playerId)
        ));
        if ($row == NULL)
            {
            return;
            }
        }


    public function createTatarArt()
        {
        require_once(MODEL_PATH . "register.php");
        $map_siz = $GLOBALS['SetupMetadata']['map_size'];
        $mama        = new RegisterModel();
        $result   = $mama->createNewPlayer(tatar_tribe_player, "", "", 5, 0, tatar_tribe_villages, $map_siz, PLAYERTYPE_TATAR, 6);
        $this->provider->executeQuery("UPDATE p_players p SET p.total_people_count=3466, p.description1='%s', p.guide_quiz='-1' WHERE id=%s", array(
            tatar_tribe_desc2,
            intval($result['playerId'])
        ));
        $troop_ids = array();
        foreach ($GLOBALS['GameMetadata']['troops'] as $k => $v)
            {
            if ($v['for_tribe_id'] == 5)
                {
                $troop_ids[] = $k;
                }
            }
        $firstFla = TRUE;
        $s = 0;
        foreach ($result['villages'] as $createdVillage => $v)
            {
        $s++;
            $troops_num = "";
            foreach ($troop_ids as $tid)
                {
                if ($troops_num != "")
                    {
                    $troops_num .= ",";
                    }
if ($tid == 49 || $tid == 50) {
$num = 0;
}else if ($tid == 44 || $tid == 47 || $tid == 48) {
$num = mt_rand(3000, 10000);
}else {
$num = mt_rand(10000, 35000);
}
                $troops_num .= sprintf("%s %s", $tid, $num);
                }
$type = 0;
if  ($s == 1) {
$village_name = "تسريع القوات";
$k = 1;
}else if ($s == 2) {
$village_name = "الكشاف الماهر";
$k = 2;
}else if ($s == 3) {
$village_name = "تسريع تدريب القوات";
$k = 3;
}else if ($s == 4) {
$village_name = "المهندس المعماري";
$k = 4;
}else if ($s == 5) {
$village_name = "المخبأ الكبير";
$k = 5;
}else if ($s == 6) {
$village_name = "تحفة الجوكر";
$k = 3;
$type = 1;
}
            $troops_num = "-1:" . $troops_num;
            $buildings2 = "1 0 0,4 0 0,1 0 0,3 0 0,2 0 0,2 0 0,3 0 0,4 0 0,4 0 0,3 0 0,3 0 0,4 0 0,4 0 0,1 0 0,4 0 0,2 0 0,1 0 0,2 0 0,0 0 0,27 10 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0,15 16 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0,0 0 0";
            $this->provider->executeQuery("UPDATE p_villages v SET buildings='%s', village_name='%s', is_special_village='0', v.troops_num='%s', artefacts='%s', type='%s', is_artefacts='%s', v.is_capital=%s, v.people_count=%s WHERE v.id=%s", array(
                $buildings2,
                $village_name,
                $troops_num,
                $k,
                $type,
                1,
                $firstFla ? "1" : "0",
                $firstFla ? "863" : "163",
                intval($createdVillage)
            ));
            $firstFla = FALSE;
            }
        }
    public function createTatarVillages()
        {  
        $q = new QueueModel();
        $delete = $q->provider->fetchRow( "select id from p_players where name='التتار' AND player_type='3'");
        $this->deletePlayer ($delete["id"]);
        require_once(MODEL_PATH . "register.php");
        $map_size = $GLOBALS['SetupMetadata']['map_size'];
        $m        = new RegisterModel();
        $result   = $m->createNewPlayer(tatar_tribe_player, "", "", 5, 0, tatar_tribe_villages, $map_size, PLAYERTYPE_TATAR, 10);
        $this->provider->executeQuery("UPDATE p_players p SET p.total_people_count=3867, p.description1='%s', p.guide_quiz='-1' WHERE id=%s", array(
            tatar_tribe_desc,
            intval($result['playerId'])
        ));

$msgNatar = tatar_tribe_villages;
$NATARID = intval($result['playerId']);
$NATARPOP = 0;
$META = $GLOBALS["GameMetadata"];
$troop_ids = array();
foreach ($META['troops'] as $k => $v)
if ($v['for_tribe_id'] == 5)
$troop_ids[] = $k;        
$ISCAP = $META['TatarAttackinstall'];
if ($ISCAP == ON)
{
$NATARCAPIDSERCSH = mysql_query("SELECT id FROM p_villages WHERE tribe_id=5 and is_capital=1");
$natars = mysql_fetch_array($NATARCAPIDSERCSH);
$NATARCAPID =  $natars['id'];
list ($CAPX, $CAPY) = mysql_fetch_row (mysql_query ("SELECT rel_x, rel_y FROM p_villages WHERE id=$NATARCAPID"));
$ALLVIL = mysql_query ("SELECT id, player_id, rel_x, rel_y FROM p_villages WHERE player_id IS NOT NULL AND is_oasis = 0");
while ($ONEVIL = mysql_fetch_row ($ALLVIL))
{
$SCOUTZ = 25 * ( 1 + (rand (0, 1) == 0 ? 1 : -1) * mt_rand (0, 10 * 100)/10000 );
$TROOPZ = sprintf ("41 0,42 0,43 0,44 %s,14 0,46 0,47 0,48 0,49 0,50 0|0|1|||||0", $SCOUTZ);                                        
$PLAYERID = $ONEVIL[1];
$PLAYERVILID = $ONEVIL[0];
$VILX = $ONEVIL[2];
$VILY = $ONEVIL[3];
$DIST = sqrt (pow (($VILX - $CAPX),2) + pow (($VILY - $CAPY), 2));
$TIME = round ($DIST / $META["units"]["14"]["velocity"]);
mysql_query ("INSERT INTO p_queue (player_id,village_id,to_player_id,to_village_id,proc_type,proc_params,end_date,execution_time) VALUES ($NATARID,$NATARCAPID,$PLAYERID,$PLAYERVILID,15,'$TROOPZ',FROM_UNIXTIME(UNIX_TIMESTAMP(NOW())+1),$TIME)");

}
}

 $this->provider->executeQuery( "UPDATE p_players SET new_gnews=1");
 $this->provider->executeQuery( "UPDATE g_summary SET gnews_text='<h2>اعزائي لاعبي حرب التتار</h2>
لقد بدأت الحرب فقد اعلنت أشارة الحرب بين <b> التتار </b> و اللاعبين
انطلقت 10 قرى في مواقع معينة لديها معجزة العالم عليك عزيزي اللاعب ان تحاول  الحصول على احد من قراها حتى لايسبقك الجميع وهناك جيوش دفاعية متنوعة قوية للتتار عليك تدميرها للحصول على معجزة العالم والفوز باللعبة وتدافع عن قريتك ويساندك تحالفك حتى تصل الى المستوى 100 حتى تغلب الجميع وتحصل على جائزة من الذهب لسيرفر القادم.

<b>استراتجية قد تهمك في استحلال قرى من التتار</b>
بناء الجيوش بالاسطبل والثكنة والحصول على اكبر جيش ثم تقسم الهجوم الى هجومين هجوم استكشاف ثم هجوم تدميري ويجب ان يكون لديك جيوش طاحنة لسفح دماء التتار والقضاء عليهم وتدريب زعماء لاستحلال على القرية.

<b>فريق حرب التتار</b>'");

        $troop_ids = array();
        foreach ($GLOBALS['GameMetadata']['troops'] as $k => $v)
            {
            if ($v['for_tribe_id'] == 5)
                {
                $troop_ids[] = $k;
                }
            }
        $firstFlag = TRUE;
        foreach ($result['villages'] as $createdVillage => $v)
            {
            $troops_num = "";
            foreach ($troop_ids as $tid)
                {
                if ($troops_num != "")
                    {
                    $troops_num .= ",";
                    }
if ($tid == 49 || $tid == 50) {
$num = 0;
}else if ($tid == 44 || $tid == 47 || $tid == 48) {
$num = mt_rand(3000, 10000);
}else {
$num = mt_rand(40000, 80000);
}
                $troops_num .= sprintf("%s %s", $tid, $num);
                }
            $troops_num = "-1:" . $troops_num;
            $this->provider->executeQuery("UPDATE p_villages v SET v.troops_num='%s', v.is_capital=%s, v.people_count=%s WHERE v.id=%s", array(
                $troops_num,
                $firstFlag ? "1" : "0",
                $firstFlag ? "1362" : "263",
                intval($createdVillage)
            ));
            $firstFlag = FALSE;
            }
        }




    public function deletePlayer($playerId)
        {
        $playerId = intval($playerId);
        if ($playerId <= 0)
            {
            return;
            }
        $row = $this->provider->fetchRow("SELECT p.alliance_id, p.villages_id, p.tribe_id, p.is_active FROM p_players p WHERE id=%s", array(
            $playerId
        ));
        if ($row == NULL)
            {
            return;
            }
        $this->provider->executeQuery("UPDATE p_msgs m SET m.to_player_id=IF(m.to_player_id=%s, NULL, m.to_player_id), m.from_player_id=IF(m.from_player_id=%s, NULL, m.from_player_id)", array(
            $playerId,
            $playerId
        ));
        $this->provider->executeQuery("UPDATE p_rpts r SET r.to_player_id=IF(r.to_player_id=%s, NULL, r.to_player_id), r.from_player_id=IF(r.from_player_id=%s, NULL, r.from_player_id)", array(
            $playerId,
            $playerId
        ));
        if (0 < intval($row['alliance_id']))
            {
            $this->provider->executeQuery("UPDATE p_alliances SET player_count=player_count-1 WHERE id=%s", array(
                intval($row['alliance_id'])
            ));
            $_aRow = $this->provider->fetchRow("SELECT a.players_ids, a.player_count FROM p_alliances a WHERE a.id=%s", array(
                intval($row['alliance_id'])
            ));
            if ($_aRow['player_count'] <= 0)
                {
                $this->provider->executeQuery("DELETE FROM p_alliances WHERE id=%s", array(
                    intval($row['alliance_id'])
                ));
                }
            else
                {
                $aplayers_ids = $_aRow['players_ids'];
                if (trim($aplayers_ids) != "")
                    {
                    $newPlayers_ids  = "";
                    $aplayers_idsArr = explode(",", $aplayers_ids);
                    foreach ($aplayers_idsArr as $pid)
                        {
                        if ($pid == $playerId)
                            {
                            continue;
                            }
                        if ($newPlayers_ids != "")
                            {
                            $newPlayers_ids .= ",";
                            }
                        $newPlayers_ids .= $pid;
                        }
                    $this->provider->executeQuery("UPDATE p_alliances SET players_ids='%s' WHERE id=%s", array(
                        $newPlayers_ids,
                        intval($row['alliance_id'])
                    ));
                    }
                }
            }
        $this->provider->executeQuery("DELETE FROM p_merchants WHERE player_id=%s", array(
            $playerId
        ));
        $this->provider->executeQuery("UPDATE p_villages v \r\n\t\t\tSET \r\n\t\t\t\tv.tribe_id=IF(v.is_oasis=1, 4, 0),\r\n\t\t\t\tv.parent_id=NULL,\r\n\t\t\t\tv.player_id=NULL,\r\n\t\t\t\tv.alliance_id=NULL,\r\n\t\t\t\tv.player_name=NULL,\r\n\t\t\t\tv.village_name=NULL,\r\n\t\t\t\tv.alliance_name=NULL,\r\n\t\t\t\tv.is_capital=0,\r\n\t\t\t\tv.people_count=2,\r\n\t\t\t\tv.crop_consumption=2,\r\n\t\t\t\tv.time_consume_percent=100,\r\n\t\t\t\tv.offer_merchants_count=0,\r\n\t\t\t\tv.resources=NULL,\r\n\t\t\t\tv.cp=NULL,\r\n\t\t\t\tv.buildings=NULL,\r\n\t\t\t\tv.troops_training=NULL,\r\n\t\t\t\tv.child_villages_id=NULL,\r\n\t\t\t\tv.village_oases_id=NULL,\r\n\t\t\t\tv.troops_trapped_num=0,\r\n\t\t\t\tv.allegiance_percent=100,\r\n\t\t\t\tv.troops_num=IF(v.is_oasis=1, '-1:31 0,34 0,37 0', NULL),\r\n\t\t\t\tv.troops_out_num=NULL,\r\n\t\t\t\tv.troops_intrap_num=NULL,\r\n\t\t\t\tv.troops_out_intrap_num=NULL,\r\n\t\t\t\tv.creation_date=NOW()\r\n\t\t\tWHERE v.player_id=%s", array(
            $playerId
        ));
        $this->provider->executeQuery("DELETE FROM p_players WHERE id=%s", array(
            $playerId
        ));
        $this->provider->executeQuery("DELETE FROM p_profile WHERE userid=%s", array(
            $playerId
        ));
        $this->provider->executeQuery("DELETE FROM p_comment WHERE userid=%s OR to_userid=%s", array(
            $playerId,
            $playerId
        ));
        $this->provider->executeQuery("DELETE FROM p_friends WHERE playerid1=%s OR playerid2=%s", array(
            $playerId,
            $playerId
        ));
        $this->provider->executeQuery("UPDATE g_summary \r\n\t\t\tSET \r\n\t\t\t\tplayers_count=players_count-1,\r\n\t\t\t\tactive_players_count=active_players_count-%s,\r\n\t\t\t\tDboor_players_count=Dboor_players_count-%s,\r\n\t\t\t\tArab_players_count=Arab_players_count-%s,\r\n\t\t\t\tRoman_players_count=Roman_players_count-%s,\r\n\t\t\t\tTeutonic_players_count=Teutonic_players_count-%s,\r\n\t\t\t\tGallic_players_count=Gallic_players_count-%s", array(
            $row['is_active'] ? 1 : 0,
            $row['tribe_id'] == 6 ? 1 : 0,
            $row['tribe_id'] == 7 ? 1 : 0,
            $row['tribe_id'] == 1 ? 1 : 0,
            $row['tribe_id'] == 2 ? 1 : 0,
            $row['tribe_id'] == 3 ? 1 : 0
        ));
        }
    public function captureOasis($oasisId, $playerId, $villageId, $capture = TRUE)
        {
        $villageRow = $this->provider->fetchRow("SELECT\r\n\t\t\t\tv.player_id,\r\n\t\t\t\tv.tribe_id,\r\n\t\t\t\tv.alliance_id,\r\n\t\t\t\tv.player_name,\r\n\t\t\t\tv.alliance_name,\r\n\t\t\t\tv.resources,\r\n\t\t\t\tv.cp,\r\n\t\t\t\tv.crop_consumption,\r\n\t\t\t\tv.village_oases_id,\r\n\t\t\t\tTIME_TO_SEC(TIMEDIFF(NOW(), v.last_update_date)) elapsedTimeInSeconds \r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE v.id=%s", array(
            intval($villageId)
        ));
        if (intval($villageRow['player_id']) == 0 || intval($villageRow['player_id']) != $playerId)
            {
            return;
            }
        if ($capture)
            {
            $this->provider->executeQuery("UPDATE p_villages v\r\n\t\t\t\tSET\r\n\t\t\t\t\tv.parent_id=%s,\r\n\t\t\t\t\tv.tribe_id=%s,\r\n\t\t\t\t\tv.player_id=%s,\r\n\t\t\t\t\tv.alliance_id=%s,\r\n\t\t\t\t\tv.player_name='%s',\r\n\t\t\t\t\tv.alliance_name='%s',\r\n\t\t\t\t\tv.troops_num=NULL,\r\n\t\t\t\t\tv.troops_out_num=NULL,\r\n\t\t\t\t\tv.troops_intrap_num=NULL,\r\n\t\t\t\t\tv.troops_out_intrap_num=NULL,\r\n\t\t\t\t\tv.allegiance_percent=100,\r\n\t\t\t\t\tv.creation_date=NOW(),\r\n\t\t\t\t\tv.last_update_date=NOW()\r\n\t\t\t\tWHERE v.id=%s", array(
                intval($villageId),
                intval($villageRow['tribe_id']),
                intval($villageRow['player_id']),
                0 < intval($villageRow['alliance_id']) ? intval($villageRow['alliance_id']) : "NULL",
                $villageRow['player_name'],
                $villageRow['alliance_name'],
                intval($oasisId)
            ));
            }
        else
            {
            $this->provider->executeQuery("UPDATE p_villages v \r\n\t\t\t\tSET \r\n\t\t\t\t\tv.tribe_id=4,\r\n\t\t\t\t\tv.parent_id=NULL,\r\n\t\t\t\t\tv.player_id=NULL,\r\n\t\t\t\t\tv.alliance_id=NULL,\r\n\t\t\t\t\tv.player_name=NULL,\r\n\t\t\t\t\tv.village_name=NULL,\r\n\t\t\t\t\tv.alliance_name=NULL,\r\n\t\t\t\t\tv.troops_num='-1:31 0,34 0,37 0',\r\n\t\t\t\t\tv.troops_out_num=NULL,\r\n\t\t\t\t\tv.troops_intrap_num=NULL,\r\n\t\t\t\t\tv.troops_out_intrap_num=NULL,\t\t\t\t\t\r\n\t\t\t\t\tv.allegiance_percent=100,\r\n\t\t\t\t\tv.creation_date=NOW()\r\n\t\t\t\tWHERE v.id=%s", array(
                intval($oasisId)
            ));
            }
        $village_oases_id = "";
        if ($capture)
            {
            $village_oases_id = trim($villageRow['village_oases_id']);
            if ($village_oases_id != "")
                {
                $village_oases_id .= ",";
                }
            $village_oases_id .= $oasisId;
            }
        else if (trim($villageRow['village_oases_id']) != "")
            {
            $village_oases_idArr = explode(",", $villageRow['village_oases_id']);
            foreach ($village_oases_idArr as $oid)
                {
                if ($oid == $oasisId)
                    {
                    continue;
                    }
                if ($village_oases_id != "")
                    {
                    $village_oases_id .= ",";
                    }
                $village_oases_id .= $oid;
                }
            }
        $resultArr  = $this->_getResourcesArray($villageRow['resources'], $villageRow['elapsedTimeInSeconds'], $villageRow['crop_consumption'], $villageRow['cp']);
        $oasisIndex = $this->provider->fetchScalar("SELECT v.image_num FROM p_villages v WHERE v.id=%s", array(
            intval($oasisId)
        ));
        $oasisRes   = $GLOBALS['SetupMetadata']['oasis'][$oasisIndex];
        $factor     = $capture ? 1 : 0 - 1;
        foreach ($oasisRes as $k => $v)
            {
            $resultArr['resources'][$k]['prod_rate_percentage'] += $v * $factor;
            if ($resultArr['resources'][$k]['prod_rate_percentage'] < 0)
                {
                $resultArr['resources'][$k]['prod_rate_percentage'] = 0;
                }
            }
        $this->provider->executeQuery("UPDATE p_villages v \r\n\t\t\tSET\r\n\t\t\t\tv.resources='%s',\r\n\t\t\t\tv.cp='%s',\r\n\t\t\t\tv.village_oases_id='%s',\r\n\t\t\t\tv.last_update_date=NOW()\r\n\t\t\tWHERE v.id=%s", array(
            $this->_getResourcesString($resultArr['resources']),
            $resultArr['cp']['cpValue'] . " " . $resultArr['cp']['cpRate'],
            $village_oases_id,
            intval($villageId)
        ));
        }
    public function executeLeaveOasisTask($taskRow)
        {
        $this->captureOasis($taskRow['building_id'], $taskRow['player_id'], $taskRow['village_id'], FALSE);
        }
	public function rebroadcastMerchant($taskRow)
        {
        $merchantNum = explode( "|", $taskRow['proc_params'] );
        list( $merchantNum, $resStr, $send ) = $merchantNum;  
		$resStr = explode( " ", $resStr );
		if($send > 1 ){
		$village = $this->provider->fetchRow("SELECT v.resources FROM p_villages v WHERE v.id=%s", array( intval($taskRow['village_id']) ));

		$ifresources = explode(' ', $village['resources'] );
		if($resStr[0] < $ifresources[1] AND $resStr[1] < $ifresources[6] AND $resStr[2] < $ifresources[11] AND $resStr[3] < $ifresources[16]){
		$r_arr = explode( ",", $village['resources'] );
		$i = 1;
		$ir = 0;
		foreach ( $r_arr as $r_str ){
		$r2 = explode(' ', $r_str );
		$r22 = $r2[1]-$resStr[$ir];
		$res .= $r2[0].' '.$r22.' '.$r2[2].' '.$r2[3].' '.$r2[4].' '.$r2[5];
		if($i != 4){ $res .= ','; }
		$i++;
		$ir++;
		}
		$this->provider->executeQuery("UPDATE p_villages v SET v.resources='%s' WHERE v.id=%s", array( $res, intval($taskRow['village_id']) ));
		$newQueueModel = new QueueModel();
        $newTask = new QueueTask( QS_MERCHANT_GO, $taskRow['player_id'], $taskRow['execution_time'] );
		$newTask->villageId = $taskRow['village_id'];
		$newTask->toPlayerId = $taskRow['to_player_id'];
		$newTask->toVillageId = $taskRow['to_village_id'];
		$newTask->procParams = $merchantNum."|".( $resStr[0]." ".$resStr[1]." ".$resStr[2]." ".$resStr[3]."|".($send-1) );
		$newTask->tag = array( "1" => $resStr[0], "2" => $resStr[1], "3" => $resStr[2], "4" => $resStr[3] );
		$newQueueModel->addTask( $newTask );
		}
		}
		
        }
    public function executeMerchantTask($taskRow)
        {
        $villageRow = $this->provider->fetchRow("SELECT\r\n\t\t\t\tv.player_id,\r\n\t\t\t\tv.resources,\r\n\t\t\t\tv.cp,\r\n\t\t\t\tv.crop_consumption,\r\n\t\t\t\tTIME_TO_SEC(TIMEDIFF(NOW(), v.last_update_date)) elapsedTimeInSeconds \r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE v.id=%s", array(
            intval($taskRow['to_village_id'])
        ));
        if (0 < intval($villageRow['player_id']))
            {
            $resultArr = $this->_getResourcesArray($villageRow['resources'], $villageRow['elapsedTimeInSeconds'], $villageRow['crop_consumption'], $villageRow['cp']);
            list($merchantNum, $resourcesStr) = explode('|', $taskRow['proc_params']);
            $resources = explode(" ", $resourcesStr);
            $i         = 0;
            foreach ($resources as $v)
                {
                $resultArr['resources'][++$i]['current_value'] += $v;
                if ($resultArr['resources'][$i]['store_max_limit'] < $resultArr['resources'][$i]['current_value'])
                    {
                    $resultArr['resources'][$i]['current_value'] = $resultArr['resources'][$i]['store_max_limit'];
                    }
                }
            $this->provider->executeQuery("UPDATE p_villages v \r\n\t\t\t\tSET\r\n\t\t\t\t\tv.resources='%s',\r\n\t\t\t\t\tv.cp='%s',\r\n\t\t\t\t\tv.last_update_date=NOW()\r\n\t\t\t\tWHERE v.id=%s", array(
                $this->_getResourcesString($resultArr['resources']),
                $resultArr['cp']['cpValue'] . " " . $resultArr['cp']['cpRate'],
                intval($taskRow['to_village_id'])
            ));
            }
        if (intval($this->provider->fetchScalar("SELECT v.player_id FROM p_villages v WHERE v.id=%s", array(
            intval($taskRow['village_id'])
        ))) == 0)
            {
            return FALSE;
            }
        $this->provider->executeQuery("UPDATE p_queue q \r\n\t\t\tSET \r\n\t\t\t\tq.proc_type=%s,\r\n\t\t\t\tq.end_date=(q.end_date + INTERVAL q.execution_time SECOND)\r\n\t\t\tWHERE q.id=%s", array(
            QS_MERCHANT_BACK,
            intval($taskRow['id'])
        ));
        $timeInSeconds = $taskRow['remainingTimeInSeconds'];
        list($merchantsNum, $body) = explode('|', $taskRow['proc_params']);
        $res      = explode(" ", $body);
        $maxValue = 0;
        $maxIndex = 0 - 1;
        $n        = 0;
        foreach ($res as $v)
            {
            ++$n;
            if ($maxValue < $v)
                {
                $maxValue = $v;
                $maxIndex = $n;
                }
            }
        $reportResult = 10 + $maxIndex;
        $r            = new ReportModel();
        $r->createReport($taskRow['player_id'], $taskRow['to_player_id'], $taskRow['village_id'], $taskRow['to_village_id'], 1, $reportResult, $body, $timeInSeconds);
        return TRUE;
        }
    public function executeHeroTask($taskRow)
        {
        list($hero_troop_id, $hero_in_village_id) = explode(' ', $taskRow['proc_params']);
        $playerRow = $this->provider->fetchRow("SELECT p.villages_id, p.selected_village_id FROM p_players p WHERE p.id=%s", array(
            intval($taskRow['player_id'])
        ));
        if ($playerRow == NULL || trim($playerRow['villages_id']) == "")
            {
            return;
            }
        $hasVillage     = FALSE;
        $villages_idArr = explode(",", trim($playerRow['villages_id']));
        foreach ($villages_idArr as $pvid)
            {
            if ($pvid == $hero_in_village_id)
                {
                $hasVillage = TRUE;
                break;
                }
            }
        if (!$hasVillage)
            {
            $hero_in_village_id = $playerRow['selected_village_id'];
            }
        $this->provider->executeQuery("UPDATE p_players p SET p.hero_name=p.name, p.hero_troop_id=%s, p.hero_in_village_id=%s WHERE p.id=%s", array(
            intval($hero_troop_id),
            intval($hero_in_village_id),
            intval($taskRow['player_id'])
        ));
        }
    public function executeTroopTrainingTask($taskRow)
        {
        $villageRow = $this->provider->fetchRow("SELECT\r\n\t\t\t\tv.player_id,\r\n\t\t\t\tv.resources,\r\n\t\t\t\tv.cp,\r\n\t\t\t\tv.crop_consumption,\r\n\t\t\t\tv.time_consume_percent,\r\n\t\t\t\tv.troops_num,\r\n\t\t\t\tTIME_TO_SEC(TIMEDIFF(NOW(), v.last_update_date)) elapsedTimeInSeconds \r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE v.id=%s", array(
            intval($taskRow['village_id'])
        ));
        if (intval($villageRow['player_id']) == 0 || intval($villageRow['player_id']) != $taskRow['player_id'])
            {
            return;
            }
        $resultArr               = $this->_getResourcesArray($villageRow['resources'], $villageRow['elapsedTimeInSeconds'], $villageRow['crop_consumption'], $villageRow['cp']);
        $troopId                 = $taskRow['proc_params'];
        $troopsNumber            = $taskRow['threads_completed_num'];
        $troops_crop_consumption = $troopsNumber * $GLOBALS['GameMetadata']['troops'][$troopId]['crop_consumption'];
        $troopsArray             = $this->_getTroopsArray($villageRow['troops_num']);
        if (isset($troopsArray[0 - 1]))
            {
            if (isset($troopsArray[0 - 1][$troopId]))
                {
                $troopsArray[0 - 1][$troopId] += $troopsNumber;
                }
            else if ($troopId == 99)
                {
                $troopsArray[0 - 1][$troopId] = $troopsNumber;
                }
            }
        $troopTrainingStr = $this->_getTroopsString($troopsArray);
        $this->provider->executeQuery("UPDATE p_villages v \r\n\t\t\tSET\r\n\t\t\t\tv.resources='%s',\r\n\t\t\t\tv.cp='%s',\r\n\t\t\t\tv.crop_consumption=v.crop_consumption+%s,\r\n\t\t\t\tv.troops_num='%s',\r\n\t\t\t\tv.last_update_date=NOW()\r\n\t\t\tWHERE v.id=%s", array(
            $this->_getResourcesString($resultArr['resources']),
            $resultArr['cp']['cpValue'] . " " . $resultArr['cp']['cpRate'],
            $troops_crop_consumption,
            $troopTrainingStr,
            intval($taskRow['village_id'])
        ));
        }
    public function executeCelebrationTask($taskRow)
        {
        $villageRow = $this->provider->fetchRow("SELECT\r\n\t\t\t\tv.player_id,\r\n\t\t\t\tv.resources,\r\n\t\t\t\tv.cp,\r\n\t\t\t\tv.crop_consumption,\r\n\t\t\t\tTIME_TO_SEC(TIMEDIFF(NOW(), v.last_update_date)) elapsedTimeInSeconds \r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE v.id=%s", array(
            intval($taskRow['village_id'])
        ));
        if (intval($villageRow['player_id']) == 0)
            {
            return;
            }
        $resultArr       = $this->_getResourcesArray($villageRow['resources'], $villageRow['elapsedTimeInSeconds'], $villageRow['crop_consumption'], $villageRow['cp']);
        $celebrationType = $taskRow['proc_params'] == 1 ? "small" : "large";
        $resultArr['cp']['cpValue'] += $GLOBALS['GameMetadata']['items'][24]['celebrations'][$celebrationType]['value'];
        $this->provider->executeQuery("UPDATE p_villages v \r\n\t\t\tSET\r\n\t\t\t\tv.resources='%s',\r\n\t\t\t\tv.cp='%s',\r\n\t\t\t\tv.last_update_date=NOW()\r\n\t\t\tWHERE v.id=%s", array(
            $this->_getResourcesString($resultArr['resources']),
            $resultArr['cp']['cpValue'] . " " . $resultArr['cp']['cpRate'],
            intval($taskRow['village_id'])
        ));
        }
    public function executeTroopUpgradeTask($taskRow)
        {
        $villageRow = $this->provider->fetchRow("SELECT\r\n\t\t\t\tv.player_id,\r\n\t\t\t\tv.troops_training\r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE v.id=%s", array(
            intval($taskRow['village_id'])
        ));
        if (intval($villageRow['player_id']) == 0 || intval($villageRow['player_id']) != $taskRow['player_id'])
            {
            return;
            }
        $this->troopsUpgrade = array();
        $_arr                = explode(",", $villageRow['troops_training']);
        foreach ($_arr as $troopStr)
            {
            list($troopId, $researches_done, $defense_level, $attack_level) = explode(' ', $troopStr);
            $this->troopsUpgrade[$troopId] = array(
                "researches_done" => $researches_done,
                "defense_level" => $defense_level,
                "attack_level" => $attack_level
            );
            }
        switch ($taskRow['proc_type'])
        {
            case QS_TROOP_RESEARCH:
                {
                $tid = $taskRow['proc_params'];
                if (isset($this->troopsUpgrade[$tid]))
                    {
                    $this->troopsUpgrade[$tid]['researches_done'] = 1;
                    }
                break;
                }
            case QS_TROOP_UPGRADE_ATTACK:
                {
                list($tid, $level) = explode(' ', $taskRow['proc_params']);
                if (isset($this->troopsUpgrade[$tid]))
                    {
                    $this->troopsUpgrade[$tid]['attack_level'] = $level;
                    }
                break;
                }
            case QS_TROOP_UPGRADE_DEFENSE:
                {
                list($tid, $level) = explode(' ', $taskRow['proc_params']);
                if (isset($this->troopsUpgrade[$tid]))
                    {
                    $this->troopsUpgrade[$tid]['defense_level'] = $level;
                    }
                }
        }
        $troopTrainingStr = "";
        foreach ($this->troopsUpgrade as $k => $v)
            {
            if ($troopTrainingStr != "")
                {
                $troopTrainingStr .= ",";
                }
            $troopTrainingStr .= $k . " " . $v['researches_done'] . " " . $v['defense_level'] . " " . $v['attack_level'];
            }
        $this->provider->executeQuery("UPDATE p_villages v\r\n\t\t\tSET\r\n\t\t\t\tv.troops_training='%s'\r\n\t\t\tWHERE v.id=%s", array(
            $troopTrainingStr,
            intval($taskRow['village_id'])
        ));
        }

    public function executePlusTask($taskRow, $itemId)
        {
$this->player = Player::getInstance();
 $result = $this->provider->fetchResultSet ("SELECT * FROM p_villages WHERE player_id='".$taskRow['player_id']."'");
 while ($result->next ())
 {
 $iteming = ($itemId-1);
 $tempdata1 = $result->row['resources'];
 $tempdata2 = explode(",", $tempdata1);
 $tempdata3 = explode(" ", $tempdata2[$iteming]);
 $tempdata4 = $tempdata3[count($tempdata3)-1]-25;
 $tempdata5 = str_replace($tempdata2[$iteming], $tempdata3[0]." ".$tempdata3[1]." ".$tempdata3[2]." ".$tempdata3[3]." ".$tempdata3[4]." ".$tempdata4, $tempdata1);
 $this->provider->executeQuery( "UPDATE p_villages v SET v.resources='".$tempdata5."' WHERE v.id=".$result->row['id']);
 }

        }
    public function executeBuildingTask($taskRow, $drop = FALSE)
        {
        return $this->upgradeBuilding($taskRow['village_id'], $taskRow['proc_params'], $taskRow['building_id'], $drop);
        }
    public function executeBuildingDropTask($taskRow)
        {
        return $this->executeBuildingTask($taskRow, TRUE);
        }
    public function executeWarTask($taskRow)
        {
        require_once(MODEL_PATH . "battle.php");
        $m = new BattleModel();
        return $m->executeWarResult($taskRow);
        }
    public function upgradeBuilding($villageId, $bid, $itemId, $drop = FALSE)
        {
        $customAction = FALSE;
        $GameMetadata = $GLOBALS['GameMetadata'];
        $villageRow   = $this->provider->fetchRow("SELECT\r\n\t\t\t\tv.player_id,\r\n\t\t\t\tv.alliance_id,\r\n\t\t\t\tv.buildings,\r\n\t\t\t\tv.resources,\r\n\t\t\t\tv.cp,\r\n\t\t\t\tv.crop_consumption,\r\n\t\t\t\tv.time_consume_percent,\r\n\t\t\t\tTIME_TO_SEC(TIMEDIFF(NOW(), v.last_update_date)) elapsedTimeInSeconds \r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE v.id=%s", array(
            intval($villageId)
        ));
        if (intval($villageRow['player_id']) == 0)
            {
            return $customAction;
            }
        $buildings        = $this->_getBuildingsArray($villageRow['buildings']);
        $build            = $buildings[$bid];
        $buildingMetadata = $GameMetadata['items'][$itemId];
        if ($build['item_id'] != $itemId)
            {
            return $customAction;
            }
        if ($drop && $build['level'] <= 0)
            {
            return $customAction;
            }
        $LevelOffset      = $drop ? 0 - 1 : 1;
        $_resFactor       = $itemId <= 4 ? $GameMetadata['game_speed'] : 1;
        $buildingLevel    = $build['level'];
        $oldValue         = ($buildingLevel == 0 ? $itemId <= 4 ? 2 : 0 : $buildingMetadata['levels'][$buildingLevel - 1]['value']) * $_resFactor;
        $oldCP            = $buildingLevel == 0 ? 0 : $buildingMetadata['levels'][$buildingLevel - 1]['cp'];
        $newBuildingLevel = $buildingLevel + $LevelOffset;
        $newValue         = ($newBuildingLevel == 0 ? $itemId <= 4 ? 2 : 0 : $buildingMetadata['levels'][$newBuildingLevel - 1]['value']) * $_resFactor;
        $newCP            = $newBuildingLevel == 0 ? 0 : $buildingMetadata['levels'][$newBuildingLevel - 1]['cp'];
        $value_inc        = $newValue - $oldValue;
        $people_inc       = $drop ? 0 - 1 * $buildingMetadata['levels'][$buildingLevel - 1]['people_inc'] : $buildingMetadata['levels'][$newBuildingLevel - 1]['people_inc'];
        $resultArr        = $this->_getResourcesArray($villageRow['resources'], $villageRow['elapsedTimeInSeconds'], $villageRow['crop_consumption'], $villageRow['cp']);
        $resultArr['cp']['cpRate'] += $newCP - $oldCP;
        $allegiance_percent_inc = 0;
        switch ($itemId)
        {
            case 1:
            case 2:
            case 3:
            case 4:
                $resultArr['resources'][$itemId]['prod_rate'] += $value_inc;
                break;
            case 5:
            case 6:
            case 7:
            case 8:
                $resultArr['resources'][$itemId - 4]['prod_rate_percentage'] += $value_inc;
                break;
            case 9:
                $resultArr['resources'][4]['prod_rate_percentage'] += $value_inc;
                break;
            case 10:
            case 38:
                $newStorage = $resultArr['resources'][1]['store_max_limit'] == $resultArr['resources'][1]['store_init_limit'] ? 0 : $resultArr['resources'][1]['store_max_limit'];
                $newStorage = $newStorage + $value_inc;
                if ($newStorage < $resultArr['resources'][1]['store_init_limit'])
                    {
                    $newStorage = $resultArr['resources'][1]['store_init_limit'];
                    }
                $resultArr['resources'][1]['store_max_limit'] = $resultArr['resources'][2]['store_max_limit'] = $resultArr['resources'][3]['store_max_limit'] = $newStorage;
                break;
            case 11:
            case 39:
                $newStorage = $resultArr['resources'][4]['store_max_limit'] == $resultArr['resources'][4]['store_init_limit'] ? 0 : $resultArr['resources'][4]['store_max_limit'];
                $newStorage = $newStorage + $value_inc;
                if ($newStorage < $resultArr['resources'][4]['store_init_limit'])
                    {
                    $newStorage = $resultArr['resources'][4]['store_init_limit'];
                    }
                $resultArr['resources'][4]['store_max_limit'] = $newStorage;
                break;
            case 15:
                $villageRow['time_consume_percent'] = $newValue == 0 ? 300 : $newValue;
                break;
            case 18:
                if (0 < intval($villageRow['alliance_id']) && !$drop)
                    {
                    $this->provider->executeQuery("UPDATE p_alliances a\r\n\t\t\t\t\t\tSET\r\n\t\t\t\t\t\t\ta.max_player_count=%s\r\n\t\t\t\t\t\tWHERE a.id=%s AND a.creator_player_id=%s AND a.max_player_count<%s", array(
                        $newValue,
                        intval($villageRow['alliance_id']),
                        intval($villageRow['player_id']),
                        $newValue
                    ));
                    }
                break;
            case 25:
            case 26:
                if (!$drop)
                    {
                    $allegiance_percent_inc = 10;
                    }
                break;
            case 40:
                if ($newBuildingLevel == sizeof($buildingMetadata['levels']))
                    {
                $customAction = TRUE;
                $this->provider->executeQuery("DELETE FROM p_queue");
                require_once(MODEL_PATH . "queue.php");
                $resetTime  = 86400;
                $queueModel = new QueueModel();
                $queueModel->addTask(new QueueTask(QS_SITE_RESET, 0, $resetTime));
                $this->provider->executeQuery("UPDATE g_settings gs SET gs.game_over=1, gs.win_pid=%s", array(
                    intval($villageRow['player_id'])
                ));
                                }
        }
        $buildings[$bid]['level'] += $LevelOffset;
        if (!$drop)
            {
            --$buildings[$bid]['update_state'];
            }
        else if ($buildings[$bid]['level'] <= 0 && $buildings[$bid]['item_id'] != 40 && $buildings[$bid]['update_state'] == 0 && 4 < $buildings[$bid]['item_id'])
            {
            $buildings[$bid]['item_id'] = 0;
            }
        if ($buildings[$bid]['update_state'] < 0)
            {
            $buildings[$bid]['update_state'] = 0;
            }
        $buildingsString = $this->_getBuildingString($buildings);
        $this->provider->executeQuery("UPDATE p_villages v \r\n\t\t\tSET\r\n\t\t\t\tv.buildings='%s',\r\n\t\t\t\tv.resources='%s',\r\n\t\t\t\tv.cp='%s',\r\n\t\t\t\tv.crop_consumption=v.crop_consumption+%s,\r\n\t\t\t\tv.people_count=v.people_count+%s,\r\n\t\t\t\tv.time_consume_percent=%s,\r\n\t\t\t\tv.allegiance_percent=IF(v.allegiance_percent+%s>=100, 100, v.allegiance_percent+%s),\r\n\t\t\t\tv.last_update_date=NOW()\r\n\t\t\tWHERE v.id=%s", array(
            $buildingsString,
            $this->_getResourcesString($resultArr['resources']),
            $resultArr['cp']['cpValue'] . " " . $resultArr['cp']['cpRate'],
            $people_inc,
            $people_inc,
            $villageRow['time_consume_percent'],
            $allegiance_percent_inc,
            $allegiance_percent_inc,
            intval($villageId)
        ));
        $devPoint = $people_inc;
        $this->provider->executeQuery("UPDATE p_players p\r\n\t\t\tSET\r\n\t\t\t\tp.total_people_count=p.total_people_count+%s,\r\n\t\t\t\tp.week_dev_points=p.week_dev_points+%s\r\n\t\t\tWHERE p.id=%s", array(
            $people_inc,
            $devPoint,
            intval($villageRow['player_id'])
        ));
        if (0 < intval($villageRow['alliance_id']))
            {
            $this->provider->executeQuery("UPDATE p_alliances a\r\n\t\t\t\tSET\r\n\t\t\t\t\ta.week_dev_points=a.week_dev_points+%s\r\n\t\t\t\tWHERE a.id=%s", array(
                $devPoint,
                intval($villageRow['alliance_id'])
            ));
            }
        return $customAction;
        }
    public function _getTroopsString($troopsArray)
        {
        $result = "";
        foreach ($troopsArray as $vid => $troopsNumArray)
            {
            if ($result != "")
                {
                $result .= "|";
                }
            $innerResult = "";
            foreach ($troopsNumArray as $tid => $num)
                {
                if ($innerResult != "")
                    {
                    $innerResult .= ",";
                    }
                if ($tid == 0 - 1)
                    {
                    $innerResult .= $num . " " . $tid;
                    }
                else
                    {
                    $innerResult .= $tid . " " . $num;
                    }
                }
            $result .= $vid . ":" . $innerResult;
            }
        return $result;
        }
    public function _getTroopsArray($troops_num)
        {
        $troopsArray = array();
        $t_arr       = explode("|", $troops_num);
        foreach ($t_arr as $t_str)
            {
            $t2_arr            = explode(":", $t_str);
            $vid               = $t2_arr[0];
            $troopsArray[$vid] = array();
            $t2_arr            = explode(",", $t2_arr[1]);
            foreach ($t2_arr as $t2_str)
                {
                $t = explode(" ", $t2_str);
                if ($t[1] == 0 - 1)
                    {
                    $troopsArray[$vid][$t[1]] = $t[0];
                    }
                else
                    {
                    $troopsArray[$vid][$t[0]] = $t[1];
                    }
                }
            }
        return $troopsArray;
        }
    public function _getBuildingsArray($buildingsString)
        {
        $buildings = array();
        $b_arr     = explode(",", $buildingsString);
        $indx      = 0;
        foreach ($b_arr as $b_str)
            {
            ++$indx;
            $b2               = explode(" ", $b_str);
            $buildings[$indx] = array(
                "index" => $indx,
                "item_id" => $b2[0],
                "level" => $b2[1],
                "update_state" => $b2[2]
            );
            }
        return $buildings;
        }
    public function _getResourcesArray($resourceString, $elapsedTimeInSeconds, $crop_consumption, $cp)
        {
        $resources = array();
        $r_arr     = explode(",", $resourceString);
        foreach ($r_arr as $r_str)
            {
            $r2            = explode(" ", $r_str);
            $prate         = floor($r2[4] * (1 + $r2[5] / 100)) - ($r2[0] == 4 ? $crop_consumption : 0);
            $current_value = floor($r2[1] + $elapsedTimeInSeconds * ($prate / 3600));
            if ($r2[2] < $current_value)
                {
                $current_value = $r2[2];
                }
            $resources[$r2[0]] = array(
                "current_value" => $current_value,
                "store_max_limit" => $r2[2],
                "store_init_limit" => $r2[3],
                "prod_rate" => $r2[4],
                "prod_rate_percentage" => $r2[5]
            );
            }
        list($cpValue, $cpRate) = explode(' ', $cp);
        $cpValue += $elapsedTimeInSeconds * ($cpRate / 86400);
        return array(
            "resources" => $resources,
            "cp" => array(
                "cpValue" => round($cpValue, 4),
                "cpRate" => $cpRate
            )
        );
        }
    public function _getResourcesString($resources)
        {
        $result = "";
        foreach ($resources as $k => $v)
            {
            if ($result != "")
                {
                $result .= ",";
                }
            $result .= $k . " " . $v['current_value'] . " " . $v['store_max_limit'] . " " . $v['store_init_limit'] . " " . $v['prod_rate'] . " " . $v['prod_rate_percentage'];
            }
        return $result;
        }
    public function _getBuildingString($buildings)
        {
        $result = "";
        foreach ($buildings as $build)
            {
            if ($result != "")
                {
                $result .= ",";
                }
$update_state = $build['update_state'];
     //if ( $update_state == 1 )
          //              {
      //$update_state = 0;
        //                }
            $result .= $build['item_id'] . " " . $build['level'] . " " . $update_state;

            }
        return $result;
        }
    }
?>