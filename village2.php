<?php



####################################################

##   s@smartservs.com     &&   BASEL WAEL    ##

##   admin@smartservs.com    &&   Wael Seif  ##

##   jokar@smartservs.com    &&   mohamed joker   ##

##   skype : SmartServs &&   www.smartservs.com           ##

####################################################



 

require(".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."lic-s/ssk.php");

require( ".".DIRECTORY_SEPARATOR."core-s".DIRECTORY_SEPARATOR."smartservs-tcex-boot.php" );



class GPage extends ProcessVillagePage



{







    public $showLevelsStr = NULL;







    public function GPage()



    {



        parent::processvillagepage();



        $this->viewFile = "village2.phtml";



        $this->contentCssClass = "village2";



    }







    public function load()



    {



        parent::load();



        $cookie = ClientData::getinstance();



        $this->showLevelsStr = $cookie->showLevels ? "on" : "off";



    }







    public function getWallCssName()



    {



        if ( $this->buildings[40]['level'] == 0 && $this->buildings[40]['update_state'] == 0 )



        {



            return "d2_0";



        }



        return $this->gameMetadata['tribes'][$this->data['tribe_id']]['wall_css'];



    }







    public function getBuildingName( $id )



    {



        $emptyName = "";



        switch ( $id )



        {



        case 39 :



            $emptyName = buildin_place_railpoint;



            break;



        case 40 :



            $emptyName = buildin_place_wall;



            break;



                }



        $emptyName = $this->data['is_special_village'] && ( $id == 25 || $id == 26 || $id == 29 || $id == 30 || $id == 33 ) ? buildin_place_topbuild : buildin_place_empty; 



        return htmlspecialchars( $this->buildings[$id]['item_id'] == 0 ? $emptyName : constant( "item_".$this->buildings[$id]['item_id'] )." ".level_lang." ".$this->buildings[$id]['level'] );



    }







    public function getBuildingCssName( $id )



    {



        $cssName = "";



        switch ( $id )



        {



            case 39 :



                $e = "";



                if ( $this->buildings[$id]['level'] == 0 && 0 < $this->buildings[$id]['update_state'] )



                {



                    $e = "b";



                }



                else if ( $this->buildings[$id]['level'] == 0 )



                {



                    $e = "e";



                }



                $cssName = "g".$this->buildings[$id]['item_id'].$e;



                break;



            case 25 :



               



            case 26 :



                



            case 29 :



               



            case 30 :



               



            case 33 :   



       



        if ( $this->data['is_special_village'] )



        {



            $cssName = "g40";



            if ( 20 <= $this->buildings[$id]['level'] )



            {



                $cssName .= "_".floor( $this->buildings[$id]['level'] / 20 );



            }



            break;



        }



            case 19 :



        case 20 :



        case 21 :



        case 22 :



        case 23 :



        case 24 :



        case 25 :



           



        case 26 :



        case 27 :



        case 28 :



           



        case 29 :



            



        case 30 :



        case 31 :  



        case 32 :



            



        case 33 :



        case 34 : 



        case 35 :



        case 36 :



        case 37 :



        case 38 : 



        $e = $this->buildings[$id]['level'] == 0 && 0 < $this->buildings[$id]['update_state'] ? "b" : "";



        $cssName = $this->buildings[$id]['item_id'] == 0 ? "iso" : "g".$this->buildings[$id]['item_id'].$e;



        break;



         } 



        return $cssName;



    }







    public function getBuildingTitle( $id )



    {



        $name = $this->getBuildingName( $id );



        return "title=\"".$name."\" alt=\"".$name."\"";



    }







    public function getBuildingTitleClass( $id )



    {



        $name = $this->getBuildingName( $id );



        $cssClass = $this->getBuildingCssName( $id );



        return $cssClass."\" alt=\"".$name;



    }







}







$p = new GPage();



$p->run();



?>

