<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="address.php">
 * </description>
 **********************************************************************************************************************/
?>
<section class="servicesDetails">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="page-title">
          <h2><?= $this->pageTitle ?></h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-sm-4 col-xs-12">
          <? // Виджет меню кабинета
          $this->widget('application.components.widgets.cabinetMenuBlock'); ?>
      </div><!--/col-->
      <div class="col-lg-9 col-sm-8 col-xs-12">
        <div class="tab-content">
          <div class="form">
              <?
              $form = $this->beginWidget(
                'booster.widgets.TbActiveForm',
                [
                  'id'                     => 'form-email-events',
                  'enableAjaxValidation'   => false,
                  'enableClientValidation' => false,
                  'method'                 => 'post',
                  'action'                 => Yii::app()->createUrl('/cabinet/profile/mailevents', []),
                    /* 'htmlOptions'            => array(
                    'onsubmit' => "return false;",// Disable normal form submit
                    ),
                    */
                  'clientOptions'          => [
                    'validateOnType'   => false,
                    'validateOnSubmit' => false,
                  ],
                ]
              );
              $this->widget(
                'booster.widgets.TbGridView',
                [
                  'id'            => 'EventsAndSubscroptionsForUser-grid',
                  'type'          => 'striped',
                  'dataProvider'  => $eventsAndSubscroptionsForUserDataProvider,
                  'enableSorting' => false,
                  'template'      => '{items}',
                  'columns'       => [
                    [
                      'name'   => 'name',
                      'header' => Yii::t('main', 'Событие'),
                      'type'   => 'raw',
                      'value'  => function ($data) {
                          $result = Yii::t('main', $data['name']);
                          if (preg_match('/(?:manager|менеджер|закупщик)/ius', $result)) {
                              $result = "<strong>{$result}</strong>";
                          }
                          return $result;
                      },
                    ],
                    [
                      'name'   => 'enable',
                      'type'   => 'raw',
                      'header' => Yii::t('main', 'Включено'),
                      'value'  => function ($data) {
                          ?>
                        <input name='events[<?= $data['id'] ?>][subscribe]'
                               type="checkbox" <?= ($data['enable'] ? ' checked="checked"' : '') ?>/>
                          <?
                      },
                    ],
                  ],
                ]
              );
              ?>
            <div class="row buttons">
              <div class="col-md-12">
                <input type="submit" form="form-email-events"
                       value="<?= Yii::t('main', 'Сохранить') ?>"
                       name="aplyEmailEvents"
                       class="btn pull-right"/>
              </div>
            </div>
              <? $this->endWidget('booster.widgets.TbActiveForm'); ?>
          </div>
        </div>

      </div><!--/col-->

    </div><!--/row-->
  </div><!--/container-->
  <br/><br/>
</section>