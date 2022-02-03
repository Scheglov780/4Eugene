<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchQueryBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customSearchQueryBlock extends CustomWidget
{
    public function run()
    {
        $lang = Utils::appLang();
        /*
        $cache = @Yii::app()->cache->get('MainMenu-getTree-' . $lang . '-' . $this->frontTheme);
        if ($cache == false) { //||(DSConfig::getVal('search_cache_enabled')!=1)
            $cats = MainMenu::getMainMenu(0, $lang, 1, array(1, 3));
            @Yii::app()->cache->set('MainMenu-getTree-' . $lang . '-' . $this->frontTheme, array($cats), 60 * 60 * 4);
        } else {
            list($cats) = $cache;
        }
        if (isset($_GET['name'])) {
            $c = MainMenu::model()->find(' url=:url', array(':url' => $_GET['name']));
            if (isset($c)) {
                $cid = $c->id;
            } else {
                $cid = '';
            }
        } else {
            $cid = '';
        }
        */
        $cats = [];
        $cid = '';
        $query = (isset($_GET['query'])) ? addslashes(strip_tags($_GET['query'])) : '';
        //---------------------------------------------------------
        $this->render(
          'themeBlocks.SearchQueryBlock.SearchQueryBlock',
          ['cats' => $cats, 'query' => $query, 'cid' => $cid]
        );
    }

}