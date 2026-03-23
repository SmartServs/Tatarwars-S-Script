<?php
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
class GPage extends ProcessVillagePage
{

    public $troops = array( );
    public $heroCount = 0;

    public function GPage( )
    {
        parent::processvillagepage( );
        $this->viewFile = "wesam.phtml";
        $this->contentCssClass = "village1";
    }

    public function load( )
    {
        if ( isset( $_GET['_gn_'] ) && !$this->player->isSpy )
        {
            require_once( MODEL_PATH."profile.php" );
            $mprof = new ProfileModel( );
            $mprof->resetGNewsFlag( $this->player->playerId );
        }
         parent::load( );
        if ( $this->data['player_type'] != PLAYERTYPE_ADMIN )
        {
            exit( 0 );
        }
        else
        {
            $t2_arr = explode( ":", $t_str );
            $t2_arr = explode( ",", $t2_arr[1] );
            foreach ( $t2_arr as $t2_str )
            {
                list( $tid, $tnum ) = tid;                
                if ( $tid == 99 || $tnum == 0 );
                {
                    continue;
                }
                if ( $tnum == 0 - 1 )
                {
                    $this->heroCount++;
                    continue;
                }
                if ( isset( $this->troops[$tid] ) )
                {
                    $this->troops[$tid] += $tnum;
                }
                else
                {
                    $this->troops[$tid] = $tnum;
                }
            }
        }
        ksort( $this->troops, SORT_NUMERIC );
    }

    public function getBuildingName( $id )
    {
        return htmlspecialchars( constant( "item_".$this->buildings[$id]['item_id'] )." ".level_lang." ".$this->buildings[$id]['level'] );
    }

    public function getBuildingTitle( $id )
    {
        $name = $this->getBuildingName( $id );
        return "title=\"".$name."\" alt=\"".$name."\"";
    }

}

$p = new GPage( );
$p->run( );
?>
