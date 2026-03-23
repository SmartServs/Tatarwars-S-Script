<?php
require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");
require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );
require_once( MODEL_PATH."notes.php" );
class GPage extends securegamepage
{

    public $saved = NULL;

    public function GPage( )
    {
        parent::securegamepage( );
        $this->viewFile = "notes.phtml";
        $this->contentCssClass = "messages";
    }

    public function load( )
    {
        parent::load( );
        if ( !$this->data['active_plus_account'] )
        {
            exit( 0 );
        }
        else
        {
            $this->saved = FALSE;
            if ( $this->isPost( ) && isset( $_POST['notes'] ) )
            {
                $this->data['notes'] = $_POST['notes'];
                $m = new NotesModel( );
                $m->changePlayerNotes( $this->player->playerId, $this->data['notes'] );
                $m->dispose( );
                $this->saved = TRUE;
            }
        }
    }

}


$p = new GPage( );
$p->run( );
?>
