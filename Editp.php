<?php
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");         
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php");
require_once(MODEL_PATH."A-D-E-D-S.php");
class GPage extends SecureGamePage
{
    var $PlayerList;
        var $VillagesList;
        var $VillageList;

        function GPage(){
//exit;
                parent::securegamepage();
                $this->viewFile = "A-D-E-D-S.phtml";
                $this->contentCssClass = "plus";
        }
                function load()
                {
        parent::load();
        //exit;
        if ( $this->data['player_type'] != PLAYERTYPE_ADMIN )
        {
           $this->redirect('village1.php');
        }
                $this->selectedTabIndex = isset( $_GET['t'] ) && is_numeric( $_GET['t'] ) && 0 <= intval( $_GET['t'] ) && intval( $_GET['t'] ) <= 8 ? intval( $_GET['t'] ) : 0;
                    if ( $this->selectedTabIndex == 0 )
                        {
                            if ( $this->isPost() || isset( $_GET['p'] ) )
                                {
                                    $m = new AdminCp();
                                        if (isset( $_GET['p'] )){
                                        $playerId = intval($_GET['p']);
                                        $this->PlayerList = $m->GetPlayerDataById ( $playerId );
                                        } else {
                                    $playerName = trim( $_POST['name'] );
                                    $this->PlayerList = $m->GetPlayerDataByName ($playerName);
                                        }
                                        if ($this->PlayerList == NULL )
                                        {
                                        $this->errorTable = login_result_msg_notexists;
                                        } else {
                                    if (empty($_POST['pwd']))
                                    {
                                        $pwd = $this->PlayerList['pwd'];
                                    } 
                                        else 
                                        {
                                        $pwd = md5 (trim($_POST['pwd']));
                                    }
                                    if ( trim($_POST['email']) != null )
                                    {
                                        $m->UpdatePlayerData( intval($_POST['id']), intval($_POST['tribe_id']), intval($_POST['alliance_id']), trim($_POST['alliance_name']), trim($_POST['name']), $pwd, trim($_POST['email']), intval($_POST['is_active']), intval($_POST['invite_by']), intval($_POST['is_blocked']), intval($_POST['player_type']), intval($_POST['active_plus_account']), trim($_POST['last_ip']), trim($_POST['house_name']), intval($_POST['gold_num']), intval($_POST['total_people_count']), intval($_POST['villages_count']), trim($_POST['villages_id']), intval($_POST['hero_troop_id']), intval($_POST['hero_level']), intval($_POST['hero_points']), trim($_POST['hero_name']), intval($_POST['hero_in_village_id']), intval($_POST['attack_points']), intval($_POST['defense_points']), trim($_POST['week_attack_points']), intval($_POST['week_defense_points']), intval($_POST['week_dev_points']), intval($_POST['week_thief_points']),$_POST['registration_date'], intval($_POST['id']) );
                                        $this->errorTable = LANGUI_ADCP_E1;
                                    }
                                        }
                            }        
                        }        
                        
                        if ( $this->selectedTabIndex == 1 )
                        {
                            if ( $this->isPost() )
                                {
                                    $m = new AdminCp();
                                        $playerName = trim( $_POST['player_name'] );
                                        $this->VillagesList = $m->GetVillagesDataByName ($playerName);
                                        if (isset( $_GET['v'] )) 
                                        {
                                        $VillageId = intval($_GET['v']);
                                    $this->VillageList = $m->GetVillageDataById ( $VillageId );
                                        }
                                        if ($this->VillageList == NULL and isset( $_GET['v'] ) )
                                        {
                                        $this->errorTable = login_result_msg_notexists;
                                        } else {
                                    if ( trim($_POST['resources']) != null and isset( $_GET['v'] ) )
                                    {
                        $m->UpdateVillageData( intval($_POST['id']), trim($_POST['rel_x']), trim($_POST['rel_y']), intval($_POST['tribe_id']), intval($_POST['player_id']), intval($_POST['alliance_id']), trim($_POST['player_name']), trim($_POST['village_name']), trim($_POST['alliance_name']), intval($_POST['is_capital']), intval($_POST['is_special_village']), intval($_POST['is_oasis']), intval($_POST['people_count']), trim($_POST['crop_consumption']), trim($_POST['resources']), trim($_POST['cp']), trim($_POST['buildings']), trim($_POST['troops_num']), trim($_POST['village_oases_id']), trim($_POST['troops_training']), trim($_POST['allegiance_percent']), intval($_POST['id']) );
                                                $this->errorTable = LANGUI_ADCP_E1;
                                        }
                                        }
                                }
                        }
                        
                        if ( $this->selectedTabIndex == 2 )
                        {
                            
                                $m = new AdminCp();
                                $this->summarylist = $m->GetGsummaryData ();
                                if ( $this->isPost() )
                                {
                                $m->UpdateGsummaryData ( intval($_POST['players_count']), intval($_POST['active_players_count']), intval($_POST['Dboor_players_count']), intval($_POST['Arab_players_count']), intval($_POST['Roman_players_count']), intval($_POST['Teutonic_players_count']), intval($_POST['Gallic_players_count']) );
                                $this->errorTable = LANGUI_ADCP_E1;
                                }
                        }
                        
                        if ( $this->selectedTabIndex == 3 )
                        {
                            if ( $this->isPost() )
                                {
                                $m = new AdminCp();
                                $goldnum = intval($_POST['goldnum']);
                                if (!empty($_POST['goldnum']))
                                {
                                $m->UpdatePlayergold ( $goldnum );
                                $this->errorTable = LANGUI_ADCP_E1;
                                }
                                }
                        }
            
                        if ( $this->selectedTabIndex == 4 )
                        {
                            $m = new AdminCp();
                $this->saved = FALSE;
                if ( $this->isPost() && isset( $_POST['news'] ) )
                {
                $this->siteNews = $_POST['news'];
                $this->saved = TRUE;
                $m->setGlobalPlayerNews( $this->siteNews );
                }
                else
                {
                $this->siteNews = $m->getGlobalSiteNews();
                } 
                $m->dispose();
                        }

                        if ( $this->selectedTabIndex == 5 )
                        {
                            $m = new AdminCp();
                            $this->saved = FALSE;
                if ( $this->isPost() && isset( $_POST['news'] ) )
                {
                $this->siteNews = $_POST['news'];
                $this->saved = TRUE;
                $m->setSiteNews( $this->siteNews );
                }
                else
                {
                $this->siteNews = $m->getSiteNews();
                }
                $m->dispose();
                        }
            
            if ( $this->selectedTabIndex == 6 )
                        {
                            if ( $this->isPost() )
                                {
                            $m = new AdminCp();        
                $paintime =  intval($_POST['painhours']);
                $time = time()+(60*60*$paintime);
                                $playername = trim($_POST['name']);
                                $reason = trim($_POST['reason']);
                $m->UpdatePlayerPainTime ( $playername, $time, $reason );
                                $this->errorTable = LANGUI_ADCP_E1;
                }
            }
            
            if ( $this->selectedTabIndex == 7 )
                        {        
                if ( $this->isPost() )
                                {
                                $m = new AdminCp();
                                $this->summarylist = $m->GetGsummaryData ();
                                $Trucetime = intval($_POST['Trucetime']);
                                $time = time()+(60*60*$Trucetime);
                                $reason = trim($_POST['reason']);
                                $m->UpdateTruceTime ( $time, $reason );
                                $this->errorTable = LANGUI_ADCP_E1;
                }
            }
                        
                        if ( $this->selectedTabIndex == 8 )
                        {        
                if ( $this->isPost() )
                                {
                                $m = new AdminCp();
                                $playerIb = trim($_POST['player_ib']);
                                $this->playerlistib = $m->GetPlayerDataByIB ( $playerIb );
                                }
                        }        
                }
        }
$p = new GPage( );
$p->run( );
 
?>