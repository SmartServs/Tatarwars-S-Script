<?php
####################################################
##   s@smartservs.com     &&   BASEL WAEL    ##
##   admin@smartservs.com    &&   Wael Seif  ##
##   jokar@smartservs.com    &&   mohamed joker   ##
##   skype : SmartServs &&   www.smartservs.com           ##
####################################################
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
require_once MODEL_PATH . 'v2v.php';
class GPage extends ProcessVillagePage
{
public function GPage( )
{
parent::processvillagepage( );
$this->viewFile = "farm.phtml";
$this->contentCssClass = "plus";
}
public function load( )
{
parent::load( );
if ( $this->dataGame['blocked_time'] > time() ){
$this->redirect ('banned.php');
return null;
}

if(isset($_POST['list']))
{
if(is_array($_POST['list']))
{
foreach ($_POST['list'] as $key => $value) {
echo $value;
echo "<br>";
}
}
}
if(isset($_GET['x']) && isset($_GET['y']) && isset($_GET['t1']) && isset($_GET['t2']))
{
if( abs($_GET['x']) > (($GLOBALS['SetupMetadata']['map_size']-1)/2) )
{
header ("Location: farm.php");
exit;
}
if( abs($_GET['y']) > (($GLOBALS['SetupMetadata']['map_size']-1)/2) )
{
header ("Location: farm.php");
exit;
}

if($_GET['t1'] < 1)
{
header ("Location: farm.php");
exit;
}
if($_GET['t2'] < 1)
{
header ("Location: farm.php");
exit;
}
$x = $_GET['x'];
if ($GLOBALS['SetupMetadata']['map_size'] <= $x)
{
$x -= $GLOBALS['SetupMetadata']['map_size'];
}
else
{
if ($x < 0)
{
$x = $GLOBALS['SetupMetadata']['map_size'] + $x;
}
}
$y = $_GET['y'];
if ($GLOBALS['SetupMetadata']['map_size'] <= $y)
{
$y -= $GLOBALS['SetupMetadata']['map_size'];
}
else
{
if ($y < 0)
{
$y = $GLOBALS['SetupMetadata']['map_size'] + $y;
}
}
$vid = ($x*$GLOBALS['SetupMetadata']['map_size']+($y + 1));
$r = $this->queueModel->provider->fetchScalar ("SELECT COUNT(*) FROM p_farm WHERE pid='".$this->player->playerId."' AND vid='".$this->data['selected_village_id']."'"); // order by id DESC");
if ($r < 50) {
$this->queueModel->provider->executeQuery2 ("INSERT INTO p_farm (id,pid,vid,avid,x,y,troops) VALUES (NULL,'".$this->player->playerId."','".$this->data['selected_village_id']."','".$vid."','".$_GET['x']."','".$_GET['y']."','".$_GET['t1']."=".$_GET['t2']."');");
header ("Location: farm.php");
exit;
}
}
if(isset($_GET['edit']))
{
if($_GET['edit'] >= 1)
{
if (isset($_GET['t1'])) {
$this->queueModel->provider->executeQuery2 ("UPDATE p_farm set troops='".$_GET['t1']."=".$_GET['t2']."' WHERE id='".$_GET['edit']."' AND pid='".$this->player->playerId."';");

header ("Location: farm.php");
exit;
}
}
}

if(isset($_GET['delall']))
{
if ($_SESSION['is_agent'] == 1) {
header ("Location: farm.php");
exit;
}
$this->queueModel->provider->executeQuery2 ("DELETE FROM p_farm WHERE pid='".$this->player->playerId."' AND vid='".$this->data['selected_village_id']."';");
header ("Location: farm.php");
exit;
}

if(isset($_GET['del']))
{
if($_GET['del'] >= 1)
{
$this->queueModel->provider->executeQuery2 ("DELETE FROM p_farm WHERE id='".$_GET['del']."' AND pid='".$this->player->playerId."';");
header ("Location: farm.php");
exit;
}
}
}
public function calldata( )
{
$start = 0;
if($this->data['tribe_id'] == 2)
{
$start = 10;
}
if($this->data['tribe_id'] == 3)
{
$start = 20;
}
if($this->data['tribe_id'] == 6)
{
$start = 50;
}
if($this->data['tribe_id'] == 7)
{
$start = 99;
}
if($this->data['tribe_id'] == 8)
{
$start = 60;
}
if($this->data['tribe_id'] == 9)
{
$start = 70;
}
$indata = NULL;
$ii = 0;
$result = $this->queueModel->provider->fetchResultSet ("SELECT * FROM p_farm WHERE pid='".$this->player->playerId."' AND vid='".$this->data['selected_village_id']."' AND avid>=1"); // order by id DESC");
while ($result->next ())
{
$vid= $this->queueModel->provider->fetchRow("SELECT village_name,people_count FROM p_villages WHERE id='".$result->row['avid']."'");
$ii += 1;
$troop = explode('=', $result->row['troops']);
if ($vid['village_name'] == '') {
$vname = 'واحة';
$pp = "-";
}else {
$vname = $vid['village_name'];
$pp = $vid['people_count'];
}
$troopName = htmlspecialchars( constant( "troop_".($start+$troop[0]) ) );
$indata .= "<tr><td id='a".$ii."'><center><input class='check' type='checkbox' name='list[]' id='list' value='".$result->row['avid']."|".$result->row['x']."|".$result->row['y']."|".($start+$troop[0])."|".$troop[1]."'></center></td><td id='b".$ii."'><a href='village3.php?id=".$result->row['avid']."'>(".$result->row['x']."|".$result->row['y'].") ".$vname."</a></td><td id='c".$ii."'><center>".$pp."</center></td><td id='d".$ii."'><center><img class='unit u".($start+$troop[0])."' src='core-s/st-s/x.gif' alt='".$troopName."' title='".$troopName."'> ".$troop[1]."</center></td><td id='e".$ii."'><center><a href='farm.php?del=".$result->row['id']."'><img class='del' src='core-s/st-s/x.gif'></a></center></td></tr>";
}
return $indata;
}
}
$p = new GPage( );
$p->run( );


?>