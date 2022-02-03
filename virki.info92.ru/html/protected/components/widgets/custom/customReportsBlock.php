<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ReportsBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customReportsBlock extends CustomWidget
{
    public $group = false;
    public $params = [];
    public $title;

    public function run()
    {
        if (!$this->group) {
            return;
        }
        $reports =
          ReportsSystem::model()->findAll(
            "\"group\"=:group and enabled=1 order by \"order\"",
            [':group' => $this->group]
          );;
        if ($reports) {
            $this->render(
              'application.modules.' . Yii::app()->controller->module->id . '.views.widgets.ReportsBlock.ReportsBlock',
              [
                'title' => $this->title,
                'reports' => $reports,
                'group' => $this->group,
                'params' => $this->params,
              ]
            );
        }
    }
}

?>