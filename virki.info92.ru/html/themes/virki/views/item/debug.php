<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="debug.php">
 * </description>
 * Рендеринг работы парсера в режиме отладки
 * var $debugMessages - dataProvider
 **********************************************************************************************************************/
?>
<br/>
<br/>
<br/>
<br/>
<hr/>
<div translate="no">
    <?
    $this->widget(
      'booster.widgets.TbGridView',
      [
        'id'           => 'dsg-debug-grid',
        'dataProvider' => $debugMessages,
        'type'         => 'striped bordered condensed',
        'template'     => '{summary}<br/>{pager}{items}{pager}',
        'columns'      => [
          'function',
          [
            'name'  => 'param_name',
            'type'  => 'raw',
            'value' => function ($data) {
                //$res=preg_replace("/(.{128,256})\s.*/s","\1\.\.\.",$data["param_value"]);
                $res = '<textarea rows="3" cols="20">' . htmlspecialchars($data['param_name']) . '</textarea>';
                return $res;
            },
          ],
          [
            'name'  => 'param_value',
            'type'  => 'raw',
            'value' => function ($data) {
                //$res=preg_replace("/(.{128,256})\s.*/s","\1\.\.\.",$data["param_value"]);
                $res = '<textarea rows="3" cols="20">' . htmlspecialchars($data['param_value']) . '</textarea>';
                return $res;
            },
          ],
          [
            'name'  => 'subject',
            'type'  => 'raw',
            'value' => function ($data) {
                $res = '<textarea rows="3" cols="20">' . htmlspecialchars($data['subject']) . '</textarea>';
                return $res;
            },
          ],
          [
            'name'  => 'result',
            'type'  => 'raw',
            'value' => function ($data) {
                $res = '<textarea rows="3" cols="20">' . htmlspecialchars($data['result']) . '</textarea>';
                return $res;
            },
          ],
          [
            'name'  => 'valid',
            'type'  => 'raw',
            'value' => function ($data) {
                $res = ($data['valid']) ? 'true' : '<span style="color: red;"><strong>false</strong></span>';
                return $res;
            },
          ],
        ],
      ]
    );
    ?>
</div>