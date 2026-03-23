<?php
########################################################################
##   Ab-9@Live.com    &&   Abdullah AL-Qadeeri    &&   TatarWar 2.1   ##
########################################################################
require( APP_PATH."conf-s/tcex-con.php" );
class attack extends ModelBase{
public function attack_tatar($player_id, $village_id, $to_player_id, $to_village_id, $proc_type, $building_id, $proc_params, $threads, $end_date, $execution_time){
$this->provider->executeQuery('INSERT p_queue SET player_id=%s, village_id=%s, to_player_id="%s", to_village_id="%s", proc_type="%s", building_id="%s", proc_params="%s", threads="%s", end_date=(NOW() + INTERVAL %s SECOND), execution_time="%s" ',  array ($player_id, $village_id, $to_player_id, $to_village_id, $proc_type, $building_id, $proc_params, $threads, $execution_time*$threads, $execution_time) );
}
public function get_tatar_villages_capital(){
return $this->provider->fetchRow ("SELECT v.id, v.player_id, rel_x, rel_y FROM p_villages v WHERE v.is_special_village='1' AND v.is_capital='1'");
}
public function attack_tatar_village($id_village){
return $this->provider->fetchRow ('SELECT v.tatar, v.buildings FROM p_villages v WHERE v.id=%s', array ( $id_village) );
}
public function update_tatar_village($id_village, $tatar){
$this->provider->executeQuery( "UPDATE p_villages v SET v.tatar='%s' WHERE v.id=%s", array( $tatar, $id_village ) );
}
}
$m = new attack();
$playerId      = $this->player->playerId;
$my_id_village = $this->data['selected_village_id'];
$get_tatar_villages_capital = $m->get_tatar_villages_capital();
$tataridp = $get_tatar_villages_capital['player_id'];
$tataridv = $get_tatar_villages_capital['id'];
$tatarrel_x = $get_tatar_villages_capital['rel_x'];
$tatarrel_y = $get_tatar_villages_capital['rel_y'];
$attack_tatar_village = $m->attack_tatar_village($my_id_village);
$attack_tatar_tatar = $attack_tatar_village['tatar'];
$attack_tatar_buildings = $attack_tatar_village['buildings'];
$pos = strpos($attack_tatar_buildings,'40 ');
if($pos === false) { $miracle_level = 0; } else {
$miracle_level = split("40", $attack_tatar_buildings);
$miracle_level = split(" ", $miracle_level[1]);
$miracle_level = $miracle_level[1];
}
$distance = WebHelper::getdistance ($tatarrel_x, $tatarrel_y, $this->data['rel_x'], $this->data['rel_y'], $AppConfig['Game']['map'] / 2);
$execution_time = intval ($distance / (5 * $AppConfig['Game']['attack'] ) *  3600);
$proc_params =  '100 '.rand(1000000,880000).',101 '.rand(1000000,880000).',102 '.rand(1000000,880000).',103 0,104 '.rand(1000000,880000).',105 '.rand(1000000,880000).',106 '.rand(40000,90000).',107 '.rand(40000,90000).',108 '.rand(1,3).',109 0|0|0|1:40||||0';
//start
if($attack_tatar_tatar == 0 AND $miracle_level >= 5){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 1 AND $miracle_level >= 25){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 2 AND $miracle_level >= 50){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 3 AND $miracle_level >= 75){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 4 AND $miracle_level >= 90){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 4 AND $miracle_level >= 91){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 5 AND $miracle_level >= 92){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 6 AND $miracle_level >= 93){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 7 AND $miracle_level >= 94){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 8 AND $miracle_level >= 95){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 9 AND $miracle_level >= 96){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 10 AND $miracle_level >= 97){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 11 AND $miracle_level >= 98){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
elseif($attack_tatar_tatar == 12 AND $miracle_level >= 99){
$attack_tatar =  $m->attack_tatar($tataridp, $tataridv, $playerId, $my_id_village, 13, NULL, $proc_params, 2, $end_date, $execution_time);
$tatar = $m->update_tatar_village($my_id_village, $attack_tatar_tatar+1);
}
//end
?>
