<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="EventsBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class EventsBlock extends CWidget
{

    public $eventsType = null;
    public $filter = '';
    public $pageSize = 5;
    public $showInternal = true;
    public $subjectId = null;

    public function run()
    {
        $dataProvider = EventsLog::getEvents(
          $this->subjectId,
          $this->eventsType,
          $this->pageSize,
          false,
          $this->showInternal,
          $this->filter
        );
        $blockId = 'events-' . $this->subjectId;
        $this->render(
          'application.modules.' . Yii::app()->controller->module->id . '.views.widgets.EventsBlock.EventsBlock',
          [
            'dataProvider' => $dataProvider,
            'blockId'      => $blockId,
          ]
        );
    }
}
