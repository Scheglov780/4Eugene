<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ModuleNewsBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div class="comment-block" style="top:-20px;">
  <div class="comment-btn">
      <?php
      $this->widget(
        'booster.widgets.TbButton',
        [
          'buttonType'  => 'button',
          'type'        => 'primary',
          'icon'        => 'ok white',
          'label'       => Yii::t('main', 'Создать'),
          'htmlOptions' => [
            'class'   => 'btn btn-info btn-mini btn-primary',
            'onclick' => '$("#new-message-' . $id . '").dialog("open");false;',
          ],
        ]
      );
      ?>
  </div>
    <?php $this->widget(
      'booster.widgets.TbGridView',
      [
        'id'              => 'grid-' . $id,
        'dataProvider'    => $dataProvider,
        'type'            => 'striped bordered condensed',
        'template'        => '{items}{pager}', //{summary}{pager}
        'responsiveTable' => true,
        'columns'         => [
            /*      array('name'=>'username',
                        'htmlOptions'=>array('style'=>'width:50px;font-size:0.9em;'),
                  ),
                  array('name'=>'date',
                        'htmlOptions'=>array('style'=>'width:45px;font-size:0.9em;'),
                  ),
            */
          [
            'name'        => 'message',
            'type'        => 'html',
            'htmlOptions' => ['style' => 'width:auto;'],
            'value'       => function ($data) {
                $res = '<strong>' . $data->username . '&nbsp;&nbsp;' . $data->date . '</strong><br/>' . $data->message;
                return $res;
            },
          ],
        ],
      ]
    );
    ?>
</div>
<div id="new-message-<?= $id ?>" title="<?= Yii::t('main', 'Новое сообщение') ?>" style="display: none;">
  <form id="new-message-form-<?= $id ?>">
    <input type="hidden" name="ModuleNews[uid]" value="<?= Yii::app()->user->id ?>"/>
    <textarea cols="80" rows="3" name="ModuleNews[message]" id="message-<?= $id ?>"></textarea>
  </form>
  <br/>
  <button id="change" onclick="
      $('#new-message-<?= $id ?>').dialog('close');
      var msg = $('#new-message-form-<?= $id ?>').serialize();
      $.post('/<?= Yii::app()->controller->module->id ?>/ModuleNews/create',msg, function(){
      $('#message-<?= $id ?>').val('');
      $.fn.yiiGridView.update('grid-<?= $id ?>');
      },'text');
      return false;"><?= Yii::t('main', 'Сохранить') ?></button>
  &nbsp;&nbsp;
  <button id="cancel" onclick="$('#new-message-<?= $id ?>').dialog('close');
      $('#message-<?= $id ?>').val('');
      return false;"><?= Yii::t('main', 'Отмена') ?></button>
  <br><br>
</div>
<script type="text/javascript">
    $("#new-message-<?=$id?>").dialog({
        autoOpen: false,
        width: 'auto',
        modal: true,
        resizable: false
    });
</script>

