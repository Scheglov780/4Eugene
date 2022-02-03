<?php

class AdminLevelsBlock extends CustomWidget
{

    public $id = 1;

    public function run()
    {
        $ret = [];
        $levelStep = MainMenu::model()->getLevelStep($this->id);
        $cnt = count($levelStep) - 1;

        $cat_text = 'Главная';
        $levels_row = '1';
        $levs = [];
        $i = 1;
        $levs[$i]['level'] = $i;
        $levs[$i]['opt'] = MainMenu::model()->getCatListRow(1);
        $levs[$i]['sel'] = 1;
        $i++;
        if ($cnt) {
            for ($j = $cnt; $j > 1; $j--) {
                $levs[$i]['level'] = $i;
                $levels_row .= ',' . $i;
                $levs[$i]['opt'] = MainMenu::model()->getCatListRow($levelStep[$j]);
                if (isset($levelStep[$j - 1])) {
                    $levs[$i]['sel'] = $levelStep[$j - 1];

                    [$a, $cat] = explode(') ', $levs[$i]['opt'][$levs[$i]['sel']]);
                    $cat_text .= ' / ' . $cat;
                }

                $i++;
            }
            $levs[($i - 1)]['child'] = count(MainMenu::model()->getCatListRow($this->id));
        }
        $ret['lev'] = $levs;
        $ret['cat_text'] = $cat_text;

        $this->render(
          'application.modules.' .
          Yii::app()->controller->module->id .
          '.views.widgets.AdminLevelsBlock.AdminLevelsBlock',
          [
            'levs' => $ret,
          ]
        );
    }
}
