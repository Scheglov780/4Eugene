<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="calculator.php">
 * </description>
 * Рендеринг калькулятора стоимости доставки
 **********************************************************************************************************************/
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="box-heading">
        <span><?= $this->pageTitle ?></span>
      </div>
    </div>
  </div>
  <div class="clearfix f-space10"></div>
  <div class="row">
    <div class="col-md-6">
      <div class="form">
        <div class="content">
          <div class="box-heading">
            <span><?= Yii::t('main', 'Расчет доставки на склад в вашей стране') ?></span>
          </div>

            <? $form = $this->beginWidget(
              'booster.widgets.TbActiveForm',
              [
                'id'                   => 'calc-form',
                'enableAjaxValidation' => false,
              ]
            ); ?>
          <div>
              <?= $form->labelEx($model, 'country'); ?>
              <? if ($selected_country) {
                  echo $form->dropDownList(
                    $model,
                    'country',
                    Deliveries::getCountries(true),
                    [
                      'class'   => 'form-control input3',
                      'style'   => 'height: 46px; position: relative;',
                      'options' => [
                        $selected_country => [
                          'selected' => true,
                        ],
                      ],
                    ]
                  );
              } else {
                  echo $form->dropDownList(
                    $model,
                    'country',
                    Deliveries::getCountries(true),
                    [
                      'class' => 'form-control input3',
                      'style' => 'height: 46px; position: relative;',
                    ]
                  );
              }
              ?>
              <?= $form->error($model, 'country'); ?>
          </div>
          <div>
              <?= $form->labelEx($model, 'weight'); ?>
              <?= $form->textField($model, 'weight', ['class' => 'form-control input3']); ?>
              <?= $form->error($model, 'weight'); ?>
          </div>
          <div class="f-space20"></div>
          <div class="row buttons">
              <?= CHtml::submitButton(
                Yii::t('main', 'Посчитать'),
                ['class' => 'btn btn-primary pull-right']
              ); ?>
          </div>
            <? $this->endWidget(); ?>
        </div>
      </div><!-- /form -->

        <? if ($res) { ?>
          <div class="clear"></div>
          <div class="row">
            <div class="col-md-12">
                <? if (count($delivery) > 0) { ?>
                  <table class="calculator">
                      <? foreach ($delivery as $i => $del) { ?>
                        <tr>
                          <th><? if ($del->summ > 0) {
                                  echo Formulas::priceWrapper(
                                    Formulas::convertCurrency(
                                      $del->summ,
                                      DSConfig::getSiteCurrency(),
                                      DSConfig::getCurrency()
                                    )
                                  );
                              } else {
                                  echo Yii::t('main', 'Рассчитывается при заказе');
                              } ?></th>
                          <td><b><?= Yii::t('main', $del->name) ?></b><br/>
                              <?= Yii::t('main', $del->description) ?>
                          </td>
                        </tr>
                      <? } ?>
                  </table>
                    <?
                } else {
                    ?>
                  <div class="alert alert-danger">
                    <h2>
                        <?= Yii::t(
                          'main',
                          'К сожалению, доставка в выбранную Вами страну или регион с указанными Вами параметрами временно не производится.'
                        ) ?>
                    </h2>
                  </div>
                <? } ?>
            </div>
          </div>
        <? } ?>
    </div><!-- /col-md-6 -->
    <div class="col-md-6">
      <div class="rospost">
        <img src="<?= $this->frontThemePath ?>/images/pochta_286x150.png" alt="почта россии"/>
      </div>
        <? $this->widget('application.components.widgets.PostcalcBlock'); ?>
    </div><!-- /col -->
  </div><!--/row-->

  <div class="clearfix f-space10"></div>

  <div class="row">
    <div class="col-md-12">
      <div class="page-title">
        <h3><?= Yii::t('main', 'Справочник веса товаров по категориям'); ?></h3>
      </div>
    </div><!--/col-->
  </div><!--/row-->

  <div class="clearfix f-space10"></div>

  <div class="row">
    <div class="col-md-12">

      <div class="cabinet-table">
          <? $this->widget(
            'booster.widgets.TbGridView',
            [
              'id'           => 'weights-grid',
              'type'         => 'striped',
              'dataProvider' => $weights->search(),
              'filter'       => $weights,
              'ajaxType'     => 'POST',
              'template'     => '{summarypager}{items}{pager}',
              'summaryText'  => Yii::t('main', 'Значения') . ' {start}-{end} ' . Yii::t(
                  'main',
                  'из'
                ) . ' {count}',
              'columns'      => [
                [
                  'name'  => 'ru',
                  'value' => function ($data) {
                      return Yii::t('main', $data['ru']);
                  },

                ],
                [
                  'name'   => 'en',
                  'filter' => false,
                ],
                [
                  'name'   => 'min_weight',
                  'filter' => false,
                ],
                [
                  'name'   => 'max_weight',
                  'filter' => false,
                ],
              ],
            ]
          );
          ?>
      </div>

    </div><!--/col-->
  </div><!--/row-->

</div><!--/Container-->