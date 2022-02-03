<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="EventsBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customEventsBlock extends CWidget
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
          'themeBlocks.EventsBlock.EventsBlock',
          [
            'dataProvider' => $dataProvider,
            'blockId'      => $blockId,
          ]
        );
    }
}
