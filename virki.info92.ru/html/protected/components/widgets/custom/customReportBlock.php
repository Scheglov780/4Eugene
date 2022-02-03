<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ReportBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customReportBlock extends CustomWidget
{
    public $params = [];
    public $report = false;

    public function run()
    {
        if ($this->report) {
            $this->render(
              'application.modules.' . Yii::app()->controller->module->id . '.views.widgets.ReportBlock.ReportBlock',
              [
                'report' => $this->report,
                'params' => $this->params,
              ]
            );
        }
    }
}

?>