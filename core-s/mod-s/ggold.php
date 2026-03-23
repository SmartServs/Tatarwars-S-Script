<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class NewsModel extends ModelBase
{

    public function getSiteNews( )
    {
        return $this->provider->fetchScalar( "SELECT g.news_text1 FROM g_summary g" );
    }

    public function setSiteNews( $news )
    {
        $this->provider->executeQuery( "UPDATE p_players set gold_num=gold_num + '%s' where is_active='1'", array(
            $news
        ) );
    }

    public function getGlobalSiteNews( )
    {
        return $this->provider->fetchScalar( "SELECT g.gnews_text1 FROM g_summary g" );
    }

    public function setGlobalPlayerNews( $news )
    {
        $this->provider->executeQuery( "UPDATE p_players set gold_num=gold_num + '%s' where is_active='1'", array(
            $news
        ) );
        // $flag = trim( $news )
        // $this->provider->executeQuery( "UPDATE p_players set gold_num=gold_num + '%s' where is_active='1' );
    }

}

?>

