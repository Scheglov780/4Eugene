<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CategoriesMenuBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customCategoriesMenuBlock extends CustomWidget
{
    public $adminMode = false;
    public $lang = false;
    public $topLevelCount = 1000;

    function run()
    {
        if (!$this->lang) {
            $lang = Utils::appLang();
        } else {
            $lang = $this->lang;
        }
        $cache = @Yii::app()->cache->get('MainMenu-getTree-' . $lang . '-' . $this->frontTheme);
        if (YII_DEBUG || $cache == false) {
            $mainMenu = MainMenu::getMainMenu(0, $lang, 1, [1, 3]);
            @Yii::app()->cache->set(
              'MainMenu-getTree-' . $lang . '-' . $this->frontTheme,
              [$mainMenu],
              60 * 60 * 4
            );
        } else {
            [$mainMenu] = $cache;
        }
        $this->render(
          'themeBlocks.CategoriesMenuBlock.CategoriesMenuBlock',
          ['mainMenu' => $mainMenu, 'adminMode' => $this->adminMode]
        );
    }

}