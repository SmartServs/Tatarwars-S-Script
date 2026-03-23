<?php

$Medals_TIME=($AppConfig['Game']['medalstime']);
$Bonous=($AppConfig['Game']['bonous']);;

include('core-s/conf-s/tcex-con.php');
$db_connect = mysql_connect($AppConfig['db']['webhost'],$AppConfig['db']['webuser'],$AppConfig['db']['webpassword']);
mysql_select_db($AppConfig['db']['webdatabase'], $db_connect);

$sql="SELECT * FROM g_settings";
$result=mysql_query($sql);
	if ($result) {
		$rest=mysql_query("SELECT * FROM g_settings" );   
		$row = mysql_fetch_assoc($rest); 
		$game_transient_stopped=$row['game_transient_stopped'];
		$LastMedal=$row['last_medal'];
		$cur_week=$row['cur_week'];
		$qlocked_date =$row['qlocked_date'];


		$Times=time();
		if($cur_week==0 && ($qlocked_date==null) ){
			mysql_query("UPDATE g_settings SET last_medal='$Times'")or die(mysql_error());
		}

		else{
			$TimerM=$Medals_TIME+$LastMedal;
			if((time()>$TimerM) && ($game_transient_stopped ==0 )){
				if (! file_exists("core-s/Prevention/medals.txt") ){
				
					$ourFileHandle = fopen("core-s/Prevention/medals.txt", 'w');
					fclose($ourFileHandle);

					$q = "SELECT * FROM g_settings order by cur_week DESC LIMIT 0, 1";
					   $result = mysql_query($q);
					   if(mysql_num_rows($result)) {
						   $row=mysql_fetch_assoc($result);
						   $week=($row['cur_week']+1);
						}
						else {
							$week='1';
						}
						$Khali='';

					//������
						$result = mysql_query("SELECT * FROM p_players WHERE id > 0 ORDER BY week_dev_points DESC Limit 10");
						$i1=0;
						while($row = mysql_fetch_array($result)){
							$i1++; 
							$devpoints=$row['week_dev_points'];
							$medal1 = "1:$i1:$week:$devpoints";
							$id = $row['id'];
							$devw = $row['devw'];
							$Gold = $row['gold_num'];
							$Goldj=($Bonous/$i1);
							$Golds1=$Gold+$Goldj;
							if($row['week_dev_points']!=0){
								$progress1[$i1-1]=$id;
								mysql_query("UPDATE p_players SET medals=CONCAT_WS(',', medals, '$medal1'),gold_num=$Golds1,goldchek=goldchek+'$Goldj',week_dev_points=0,devw=devw+1 WHERE id='$id'") or die(mysql_error());
								if($devw==2){
										$medalo1 = "5:$i1:$week:$Khali";
										mysql_query("UPDATE p_players SET medals=CONCAT_WS(',', medals, '$medalo1') WHERE id='$id'") or die(mysql_error());
								}
							}
						}

					//�����
						$result = mysql_query("SELECT * FROM p_players WHERE id > 0 ORDER BY week_attack_points DESC Limit 10");
						$i2=0;
						while($row = mysql_fetch_array($result)){
							$i2++;
							$attackpoints=$row['week_attack_points'];
							$medal2 = "2:$i2:$week:$attackpoints";
							$id = $row['id'];
							$attackw = $row['attackw'];
							$Goldj=($Bonous/$i2);
							$Gold = $row['gold_num'];
							$Golds2=$Gold+$Goldj;
							if($row['week_attack_points']!=0){
								$attack[$i2-1]=$id;
								mysql_query("UPDATE p_players SET medals=CONCAT_WS(',', medals, '$medal2'),gold_num=$Golds2,goldchek=goldchek+'$Goldj',week_attack_points=0,weekc='$week',attackw=attackw+1 WHERE id='$id'") or die(mysql_error());
								if($attackw==2){
										$medalo2 = "6:$i2:$week:$Khali";
										mysql_query("UPDATE p_players SET medals=CONCAT_WS(',', medals, '$medalo2') WHERE id='$id'") or die(mysql_error());
								}
							}
					   }

					// �����
						$result = mysql_query("SELECT * FROM p_players WHERE id > 0 ORDER BY week_defense_points DESC Limit 10");
						$i3=0;
						while($row = mysql_fetch_array($result)){
							$i3++;   
							$defpoints=$row['week_defense_points'];
							$medal3 = "3:$i3:$week:$defpoints";
							$id = $row['id'];
							$defensew = $row['defensew'];
							$weekc =($row['weekc']);
							$weekno =($row['weekno'])+1;
							$Goldj=($Bonous/$i3);
							$Gold = $row['gold_num'];
							$Golds3=$Gold+$Goldj;
							if($row['week_defense_points']!=0){
								$defence[$i3-1]=$id;
								mysql_query("UPDATE p_players SET medals=CONCAT_WS(',', medals, '$medal3'),gold_num=$Golds3,goldchek=goldchek+'$Goldj',week_defense_points=0,defensew=defensew+1 WHERE id='$id' ") or die(mysql_error());
								if($defensew==2){
									$medalo3 = "7:$i3:$week:$Khali";
									mysql_query("UPDATE p_players SET medals=CONCAT_WS(',', medals, '$medalo3') WHERE id='$id'") or die(mysql_error());
								}
							}
							if($weekc == $week){
								if( ($weekno==1) or ($weekno==2) or ($weekno==3) ){
									switch ($weekno) {
										case 1:
											$k=3;
											break;
										case 2:
											$k=2;
											break;
										case 3:
											$k=1;
											break;
									}
									$medals2 = "9:$k:$week:$Khali";
									mysql_query("UPDATE p_players SET medals=CONCAT_WS(',', medals, '$medals2'),weekno=weekno+1 WHERE id='$id'") or die(mysql_error());
								}
								
							}

						}

					// ����
						$result = mysql_query("SELECT * FROM p_players WHERE id > 0 ORDER BY week_thief_points DESC Limit 10");
						$i4=0;
						while($row = mysql_fetch_array($result)){
							$i4++;  
							$thiefpoints=$row['week_thief_points'];
							$medal4 = "4:$i4:$week:$thiefpoints";
							$id = $row['id'];
							$thiefw = $row['thiefw'];
							$Goldj=($Bonous/$i4);
							$Gold = $row['gold_num'];
							$Golds4=$Gold+$Goldj;
							if($row['week_thief_points']!=0){
								$loot[$i4-1]=$id;
								mysql_query("UPDATE p_players SET medals=CONCAT_WS(',', medals, '$medal4'),gold_num=$Golds4,goldchek=goldchek+'$Goldj',week_thief_points=0,thiefw=thiefw+1 WHERE id='$id'") or die(mysql_error());
								if($thiefw==2){
										$medalo4 = "8:$i4:$week:$Khali";
										mysql_query("UPDATE p_players SET medals=CONCAT_WS(',', medals, '$medalo4') WHERE id='$id'") or die(mysql_error());
								}
							}
						}


					// �������

					// 
					if ($week=="1"){
						mysql_query("UPDATE p_alliances SET medals='::'") or die(mysql_error());
					}
					  
					// ������ �������
					$result = mysql_query("SELECT * FROM p_alliances WHERE id > 0 ORDER BY week_dev_points DESC Limit 10");
						$i5=0;
							
						while($row = mysql_fetch_array($result)){
							$i5++;
							$devpoints=$row['week_dev_points'];
							$medal5 = "5:$i5:$week:$devpoints";
							$id = $row['id'];
							if($row['week_dev_points']!=0){
								mysql_query("UPDATE p_alliances SET medals=CONCAT_WS(',', medals, '$medal5'),week_dev_points=0 WHERE id='$id' ") or die(mysql_error());
							}
						}

					//����� �����
						$result = mysql_query("SELECT * FROM p_alliances WHERE id > 0 ORDER BY week_attack_points DESC Limit 10");
						$i6=0;
						while($row = mysql_fetch_array($result)){
							$i6++; 
							$attackpoints=$row['week_attack_points'];
							$medal6 = "6:$i6:$week:$attackpoints";
							$id = $row['id'];
							if($row['week_attack_points']!=0){
								mysql_query("UPDATE p_alliances SET medals=CONCAT_WS(',', medals, '$medal6'),week_attack_points=0 WHERE id='$id'") or die(mysql_error());
							}
						}

					// 
						$result = mysql_query("SELECT * FROM p_alliances WHERE id > 0 ORDER BY week_defense_points DESC Limit 10");
						$i7=0;
						while($row = mysql_fetch_array($result))
						{
							$i7++;
							$defpoints=$row['week_defense_points'];
							$medal7 = "7:$i7:$week:$defpoints";
							$id = $row['id'];
							if($row['week_defense_points']!=0){
								mysql_query("UPDATE p_alliances SET medals=CONCAT_WS(',', medals, '$medal7'),week_defense_points=0 WHERE id='$id' ") or die(mysql_error());
							}
						}

					// 
						$result = mysql_query("SELECT * FROM p_alliances WHERE id > 0 ORDER BY week_thief_points DESC Limit 10");
						$i8=0;
						 while($row = mysql_fetch_array($result)){
							$i8++;
							$thiefpoints=$row['week_thief_points'];
							$medal8 = "8:$i8:$thiefpoints";
							$id = $row['id'];
							if($row['week_thief_points']!=0){
								mysql_query("UPDATE p_alliances SET medals=CONCAT_WS(',', medals, '$medal8'),week_thief_points=0 WHERE id='$id' ") or die(mysql_error());
							}
						}
						

					// END Medals Con


					// 4+ Come Week
					mysql_query("UPDATE g_settings SET cur_week='$week'") or die(mysql_error());
					// END Come Week

					// 0 Players And Alliances Score
					mysql_query("UPDATE p_players   SET week_dev_points='0', week_attack_points='0', week_defense_points='0', week_thief_points='0'") or die(mysql_error());
					mysql_query("UPDATE p_alliances SET week_dev_points='0', week_attack_points='0', week_defense_points='0', week_thief_points='0'") or die(mysql_error());


					mysql_query("update `g_settings` set `last_medal` = '$Times' ");
				}
			}
		}
	}

	if(file_exists("webgame/Prevention/medals.txt") ) {
		unlink("webgame/Prevention/medals.txt");
	}


?>