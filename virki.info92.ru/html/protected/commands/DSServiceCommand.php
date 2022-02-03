<?php

/**
 * Created by PhpStorm.
 * User: Alexys
 * Date: 08.05.2016
 * Time: 19:32
 */
class DSServiceCommand extends CConsoleCommand

{

    public function actionImportItems()
    {
        $recsId = Yii::app()->db->createCommand("select id from temp_items")->queryAll();
        $totalCount = count($recsId);
        $process = 0;
        foreach ($recsId as $recId) {
            $recordId = $recId['id'];
            $rec = Yii::app()->db->createCommand("select val from temp_items where id=:id")->queryRow(true,
              [
                ':id' => $recordId,
              ]
            );
            $item = unserialize($rec['val']);
            print_r($item);
            die;
            $process = $process + 1;
            if ($process / 100 == (int) $process / 100) {
                $percent = (int) (($process / $totalCount) * 100);
                print 'Progress: ' . $process . " from $totalCount, $percent% \r\n";
            }
        }
        print "Complete\r\n";
    }

}