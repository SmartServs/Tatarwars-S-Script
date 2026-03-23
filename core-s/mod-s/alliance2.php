<?php
class Alliance2Model extends ModelBase
{

function getAllianceData( $allianceId )  
{  
return $this->provider->fetchRow( "SELECT  a.*, SUM(p.total_people_count) score    FROM p_alliances a  INNER JOIN p_players p ON (p.alliance_id = a.id)  WHERE a.id=%s  GROUP BY a.id", array( $allianceId ) );  
}

## Function War
public function removeAlliancewar( $allianceId1, $allianceId2 )
{
$war_alliance_id2 = $this->provider->fetchScalar( "SELECT a.war_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId1 ) );
$war2 = "";
if ( trim( $war_alliance_id2 ) != "" )
{
$arr = explode( ",", $war_alliance_id2 );
foreach ( $arr as $arrStr )
{
$aStatus = explode( " ", $arrStr );
$aid = explode( " ", $arrStr );
list( $aid, $aStatus ) = $aid; 
if ( $aid == $allianceId2 )
{
continue;
}
if ( $war2 != "" )
{
$war2 .= ",";
}
$war2 .= $arrStr;
}
}
$this->provider->executeQuery( "UPDATE p_alliances a SET a.war_alliance_id='%s' WHERE a.id=%s", array( $war2, $allianceId1 ) );
}
public function acceptAlliancewar( $allianceId1, $allianceId2 )
{
$war_alliance_id1 = $this->provider->fetchScalar( "SELECT a.war_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId1 ) );
$war_alliance_id2 = $this->provider->fetchScalar( "SELECT a.war_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId2 ) );
$war1 = "";
if ( trim( $war_alliance_id1 ) != "" )
{
$arr = explode( ",", $war_alliance_id1 );
foreach ( $arr as $arrStr )
{
$aStatus = explode( " ", $arrStr );
$aid = explode( " ", $arrStr );
list( $aid, $aStatus ) = $aid;
if ( $aid == $allianceId2 ){ $aStatus = 0; }
if ( $war1 != "" ){ $war1 .= ","; }

$war1 .= $aid." ".$aStatus;
}
}
$war2 = "";
if ( trim( $war_alliance_id2 ) != "" )
{
$arr = explode( ",", $war_alliance_id2 );
foreach ( $arr as $arrStr )
{
$aStatus = explode( " ", $arrStr );
$aid = explode( " ", $arrStr );
list( $aid, $aStatus ) = $aid;
if ( $aid == $allianceId1 ) { $aStatus = 0; }
if ( $war2 != "" ) { $war2 .= ","; }

$war2 .= $aid." ".$aStatus;
}
}
$this->provider->executeQuery( "UPDATE p_alliances a SET a.war_alliance_id='%s' WHERE a.id=%s", array( $war1, $allianceId1 ) );
$this->provider->executeQuery( "UPDATE p_alliances a SET a.war_alliance_id='%s' WHERE a.id=%s", array( $war2, $allianceId2 ) );
}
public function addAlliancewar( $allianceId1, $allianceId2 )
{
$war_alliance_id1 = $this->provider->fetchScalar( "SELECT a.war_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId1 ) );
$war_alliance_id2 = $this->provider->fetchScalar( "SELECT a.war_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId2 ) );
$war1 = $war_alliance_id1;
if ( $war1 != "" ){ $war1 .= ","; }

$war1 .= $allianceId2." 1";
$war2 = $war_alliance_id2;
if ( $war2 != "" ){ $war2 .= ","; }

$war2 .= $allianceId1." 2";
$this->provider->executeQuery( "UPDATE p_alliances a SET a.war_alliance_id='%s' WHERE a.id=%s", array( $war1, $allianceId1 ) );
$this->provider->executeQuery( "UPDATE p_alliances a SET a.war_alliance_id='%s' WHERE a.id=%s", array( $war2, $allianceId2 ) );
}
public function removeAllianceally( $allianceId1, $allianceId2 )
{
$ally_alliance_id1 = $this->provider->fetchScalar( "SELECT a.ally_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId1 ) );
$ally_alliance_id2 = $this->provider->fetchScalar( "SELECT a.ally_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId2 ) );
$ally1 = "";
if ( trim( $ally_alliance_id1 ) != "" )
{
$arr = explode( ",", $ally_alliance_id1 );
foreach ( $arr as $arrStr )
{
$aStatus = explode( " ", $arrStr );
$aid = explode( " ", $arrStr );
list( $aid, $aStatus ) = $aid;  
if ( $aid == $allianceId2 )
{
continue;
}
if ( $ally1 != "" )
{
$ally1 .= ",";
}
$ally1 .= $arrStr;
}
}
$ally2 = "";
if ( trim( $ally_alliance_id2 ) != "" )
{
$arr = explode( ",", $ally_alliance_id2 );
foreach ( $arr as $arrStr )
{
$aStatus = explode( " ", $arrStr );
$aid = explode( " ", $arrStr );
list( $aid, $aStatus ) = $aid; 
if ( $aid == $allianceId1 )
{
continue;
}
if ( $ally2 != "" )
{
$ally2 .= ",";
}
$ally2 .= $arrStr;
}
}
$this->provider->executeQuery( "UPDATE p_alliances a SET a.ally_alliance_id='%s' WHERE a.id=%s", array( $ally1, $allianceId1 ) );
$this->provider->executeQuery( "UPDATE p_alliances a SET a.ally_alliance_id='%s' WHERE a.id=%s", array( $ally2, $allianceId2 ) );
}

public function acceptAllianceally( $allianceId1, $allianceId2 )
{
$ally_alliance_id1 = $this->provider->fetchScalar( "SELECT a.ally_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId1 ) );
$ally_alliance_id2 = $this->provider->fetchScalar( "SELECT a.ally_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId2 ) );
$ally1 = "";
if ( trim( $ally_alliance_id1 ) != "" )
{
$arr = explode( ",", $ally_alliance_id1 );
foreach ( $arr as $arrStr )
{
$aStatus = explode( " ", $arrStr );
$aid = explode( " ", $arrStr );
list( $aid, $aStatus ) = $aid;
if ( $aid == $allianceId2 )
{
$aStatus = 0;
}
if ( $ally1 != "" )
{
$ally1 .= ",";
}
$ally1 .= $aid." ".$aStatus;
}
}
$ally2 = "";
if ( trim( $ally_alliance_id2 ) != "" )
{
$arr = explode( ",", $ally_alliance_id2 );
foreach ( $arr as $arrStr )
{
$aStatus = explode( " ", $arrStr );
$aid = explode( " ", $arrStr );
list( $aid, $aStatus ) = $aid;
if ( $aid == $allianceId1 )
{
$aStatus = 0;
}
if ( $ally2 != "" )
{
$ally2 .= ",";
}
$ally2 .= $aid." ".$aStatus;
}
}
$this->provider->executeQuery( "UPDATE p_alliances a SET a.ally_alliance_id='%s' WHERE a.id=%s", array( $ally1, $allianceId1 ) );
$this->provider->executeQuery( "UPDATE p_alliances a SET a.ally_alliance_id='%s' WHERE a.id=%s", array( $ally2, $allianceId2 ) );
}
public function addAllianceally( $allianceId1, $allianceId2 )
{
$ally_alliance_id1 = $this->provider->fetchScalar( "SELECT a.ally_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId1 ) );
$ally_alliance_id2 = $this->provider->fetchScalar( "SELECT a.ally_alliance_id FROM p_alliances a WHERE a.id=%s", array( $allianceId2 ) );
$ally1 = $ally_alliance_id1;
if ( $ally1 != "" )
{
$ally1 .= ",";
}
$ally1 .= $allianceId2." 1";
$ally2 = $ally_alliance_id2;
if ( $ally2 != "" )
{
$ally2 .= ",";
}
$ally2 .= $allianceId1." 2";
$this->provider->executeQuery( "UPDATE p_alliances a SET a.ally_alliance_id='%s' WHERE a.id=%s", array( $ally1, $allianceId1 ) );
$this->provider->executeQuery( "UPDATE p_alliances a SET a.ally_alliance_id='%s' WHERE a.id=%s", array( $ally2, $allianceId2 ) );
}


public function get_alliance_id_to($caid)
{
return $this->provider->fetchScalar( "SELECT a.war_alliance_id FROM p_alliances a WHERE a.id=%s", array( $caid ) );
}


public function GetAllianceNewsCount( $alliances_id ) {
return $this->provider->fetchScalar( "SELECT COUNT(*) FROM p_alliances_news WHERE pid=%s", array( $alliances_id ) );
}
public function GetAllianceNews( $pageIndex, $pageSize, $alliances_id ) {
return $this->provider->fetchResultSet( "SELECT * FROM p_alliances_news WHERE pid=%s order by id desc LIMIT %s,%s", array( $alliances_id, $pageIndex, $pageSize ) );
}

public function GetNamePlayer( $id ) {
return $this->provider->fetchScalar( "SELECT v.name FROM p_players v WHERE v.id=%s", array( $id ) ); 
}
public function GetNameAlliance( $id ){
return $this->provider->fetchScalar( "SELECT a.name FROM p_alliances a WHERE a.id=%s", array( $id ) );
}

public function AddNewsAlliance($pid, $type, $aidp){
$data = date('Y/m/d h:i');
$this->provider->executeQuery( "INSERT INTO p_alliances_news SET pid='%s', type='%s', aidp='%s', data='%s'", array( $pid, $type, $aidp, $data ) );
}




public function allianceExists( $allianceName ){
return 0 < intval( $this->provider->fetchScalar( "SELECT a.id FROM p_alliances a WHERE a.name='%s'", array( $allianceName ) ) );
}
public function editalliancename( $name, $name2, $id ){
$this->provider->executeQuery( "UPDATE p_alliances a SET a.%s='%s' WHERE a.id=%s", array( $name, $name2, $id ) );
if($name == 'name'){
$this->provider->executeQuery( "UPDATE p_players p SET p.alliance_name='%s' WHERE p.alliance_id=%s", array($name2, $id ) );
}
}

public function getAllianceRank( $allianceId, $score ){
return $this->provider->fetchScalar( "SELECT ( (SELECT COUNT(*) FROM p_alliances a WHERE  (a.rating*100+a.player_count)>%s) + (SELECT  COUNT(*) FROM p_alliances a WHERE  (a.rating*100+a.player_count)=%s AND a.id<%s) ) + 1 rank", array( $score, $score, $allianceId ) );
}

}
?>