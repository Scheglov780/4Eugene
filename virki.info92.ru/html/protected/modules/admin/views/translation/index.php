<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/
?>
<? if (!$isAjax) { ?>
  <div id="translation-content" class="well form-translation">
<? } ?>
<?
$this->breadcrumbs = [
  Yii::t('main', 'Перевод интерфейса'),
];
?>
<?
/*
$startTime = microtime(true);
$toLang = 'zh';
 $records = Yii::app()->db->createCommand("SELECT * from cms_knowledge_base_img where {$toLang} IS NULL LIMIT 5000")
   ->queryAll();
 if ($records) {
     foreach ($records as $record) {
         $translated = Yii::app()->db->createCommand("
         select count(0) from cms_knowledge_base_img tt
         where tt.en = :src AND tt.{$toLang} is not null
         ")->queryScalar(array(':src'=>$record['en']));
         if (!$translated) {
             $translation = Yii::app()->ExternalTranslator->translateText($record['en'], 'en', $toLang);
             Yii::app()->db->createCommand(
               "
         UPDATE cms_knowledge_base_img tt
         SET tt.{$toLang} = :translation where
         tt.en = :src
         AND tt.{$toLang} is null
         "
             )->execute(array(':src' => $record['en'], ':translation' => $translation));
         }
     }
 }
$totalTime =  round(microtime(true) - $startTime);
echo ($records?count($records):0) .' / '.($totalTime).'<br/>';
*/
?>
  <div id="translation-search-n-change-tabs">
    <ul>
        <? if (Utils::appLang() != 'ru') { ?>
          <li><a href="#translation-search-n-change-tabs-list"><?= Yii::t('main', 'Список') ?></a></li>
        <? } ?>
      <li><a href="#translation-search-n-change-tabs-search"><?= Yii::t('main', 'Поиск и замена') ?></a></li>
    </ul>
      <? if (Utils::appLang() != 'ru') { ?>
        <div id="translation-search-n-change-tabs-list">
            <?
            $form = $this->beginWidget(
              'booster.widgets.TbActiveForm',
              [
                'id'                     => 'translation-correction-update-form',
                'enableAjaxValidation'   => false,
                'enableClientValidation' => false,
                'method'                 => 'post',
                'action'                 => ["translation/update"],
                'type'                   => 'horizontal',
                'htmlOptions'            => [
                  'onsubmit' => "return false;",
                    /* Disable normal form submit */
                    // 'onkeypress'=>" if(event.keyCode == 13){ update_accessrights (); } " /* Do ajax call when user presses enter key */
                ],

              ]
            ); ?>
            <?
            $TSourceMessage = new TSourceMessage('search');
            $TSourceMessage->unsetAttributes();
            $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'translation-correction-grid',
                'dataProvider'    => $TSourceMessage->search(),
                  //'filter'       => false,
                'type'            => 'striped bordered condensed',
                'template'        => '{pager}{summary}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                  'src_id',
                  'category',
                  [
                    'type'   => 'raw',
                    'name'   => 'dst_translation',
                    'header' => Yii::t('main', 'Перевод') . ' (' . Utils::appLang() . ')',
                    'value'  => function ($data) {
                        return Yii::t($data['category'], $data['message']);
                    },
                  ],
                  'message',
                  [
                    'type'        => 'raw',
                    'name'        => 'dst_translation',
                    'header'      => Yii::t('main', 'Новое значение'),
                    'htmlOptions' => ['width' => '450px'],
                    'value'       => function ($data) {
                        $result = <<<IN
<input name="translationList[{$data['src_id']}][src]" type="hidden" value="{$data['src_message']}">                            
<textarea name="translationList[{$data['src_id']}][{$data['dst_language']}]" size="256"  
style = "font-size: 13px !important; width:440px !important;" rows="1">{$data['dst_translation']}</textarea>
IN;
                        return $result;
                    },
                  ],
                  'dst_corrected',
                ],
              ]
            );
            ?>
          <div class="row-fluid">
            <div style="float:right; padding-right: 15px !important;">
                <?php
                $this->widget(
                  'booster.widgets.TbButton',
                  [
                    'buttonType'  => 'button',
                      //'id'=>'sub2',
                    'type'        => 'info',
                    'icon'        => 'ok white',
                    'label'       => Yii::t('main', 'Сохранить'),
                    'htmlOptions' => ['onclick' => 'update_translation_list();'],
                  ]
                );
                ?>
            </div><!--end modal footer-->
          </div>
            <?php $this->endWidget(); ?>
        </div>
        <script type="text/javascript">
            function update_translation_list() {

                var data = $('#translation-correction-update-form').serialize();

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl(
                      Yii::app()->controller->module->id . "/translation/update"
                    ); ?>',
                    data: data,
                    success: function (data) {
                        dsAlert(data, 'Сохранение', true);
                        if (data !== 'false') {
                            //$.fn.yiiGridView.update('translation-correction-grid', {});
                        }

                    },
                    error: function (data) { // if error occured
                        dsAlert(JSON.stringify(data), 'Error', true);

                    },
                    dataType: 'html'
                });

            }
        </script>
      <? } ?>
    <div id="translation-search-n-change-tabs-search">
      <div class="translation-form">
          <?php $this->renderPartial('_search', ['model' => $model]); ?>
      </div>
      <!-- search-form -->

        <?php
        if ($isAjax) {
            $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'translation-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                'dataProvider'    => $model->Replace(),
                  //'filter'       => FALSE,
                'type'            => 'striped bordered condensed',
                'template'        => '{summary}{items}',
                'responsiveTable' => true,
                'columns'         => [
                  [
                    'header' => Yii::t('main', 'Таблица'),
                    'type'   => 'raw',
                    'value'  => function ($data) {
                        return $data['table'];
                    },
                  ],
                  [
                    'header' => Yii::t('main', 'Изменено'),
                    'type'   => 'raw',
                    'value'  => function ($data) {
                        return $data['changed'];
                    },
                  ],
                  [
                    'header' => Yii::t('main', 'Похожие'),
                    'type'   => 'raw',
                    'value'  => function ($data) {
                        return $data['similar'];
                    },
                  ],
                ],
              ]
            );
        } else {
            ?>
          <div>
              <?= Yii::t(
                'main',
                'Введите текущий перевод (полностью) и его новый вариант (полностью) для замены. Для поиска - оставьте поле для замены пустым.'
              ); ?>
          </div>
        <? } ?>
    </div>
  </div>
  <script>
      $(function () {
          $('#translation-search-n-change-tabs').tabs();
      });
  </script>
<? if (!$isAjax) { ?>
  </div>
<? } ?>