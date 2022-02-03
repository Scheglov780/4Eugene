<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillsListBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
$this->widget(
  'booster.widgets.TbButton',
  [
    'id'          => 'user-payment-submit-' . $this->id,
    'buttonType'  => 'button', // 'buttonType'  => 'ajaxSubmit',
    'type'        => $this->buttonType, //default
      //'size'=>'mini',
    'icon'        => $this->buttonIcon,//'fa fa-cc-visa',
    'label'       => $this->buttonLabel, //'Новый платёж',
    'htmlOptions' => array_merge(
      ['onclick' => 'renderCreateForm_user_payment_' . $this->id . '()',],
      $this->buttonHtmlOptions
    ),
  ],
);
?>
<div class="modal fade" id="user-payment-create-modal-<?= $this->id ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Внесение или списание средств') ?><?= Utils::getHelp(
              'create',
              true
            ) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'user-payment-create-form-' . ($this->id),
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ['/' . Yii::app()->controller->module->id . '/users/balance'],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'enctype'  => 'multipart/form-data',
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_lands (); } " /* Do ajax call when land presses enter key
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => 'js:function(form, data, hasError) {
            if (!hasError)
            {
            //create_bills();
            }
            }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?
          $htmlOptions = ['id' => 'user-payment-uid-' . $this->id];
          echo $form->hiddenField($this->model, 'uid', $htmlOptions);
          $htmlOptions['id'] = 'user-payment-fullname-' . $this->id;
          echo $form->uneditableRow($this->model, 'fullname', $htmlOptions);
          $htmlOptions['id'] = 'user-payment-userBalance-' . $this->id;
          echo $form->uneditableRow($this->model, 'userBalance', $htmlOptions);
          if (Yii::app()->user->inRole(['superAdmin', 'topManager']) && Yii::app()->user->checkAccess(
              Yii::app()->controller->module->id . '/users/balance/'
            )
          ) { ?>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="<?= 'user-payment-sum-' . $this->id ?>"><?= Yii::t(
                    'main',
                    'Сумма'
                  ) ?></label>
              <div class="col-sm-9">
                <input class="form-control" type="number" name="sum"
                       id="<?= 'user-payment-sum-' . $this->id ?>"
                       value="0.00"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"
                     for="<?= 'user-payment-operation-' . $this->id ?>"><?= Yii::t(
                    'main',
                    'Операция'
                  ) ?></label>
              <div class="col-sm-9">
                <select class="form-control" name="operation"
                        id="<?= 'user-payment-operation-' . $this->id ?>">
                  <option value="1"><?= Yii::t('main', 'Пополнение счёта') ?></option>
                  <option value="2"><?= Yii::t('main', 'Снятие средств') ?></option>
                </select>
              </div>
            </div>
            <div class="form-group ">
              <label class="col-sm-3 control-label" for="<?= 'user-payment-desc-' . $this->id ?>"><?= Yii::t(
                    'main',
                    'Описание'
                  ) ?></label>
              <div class="col-sm-9">
                        <textarea class="form-control" style="resize:none;"
                                  rows="2" name="desc" id="<?= 'user-payment-desc-' . $this->id ?>"><?= Yii::t(
                              'main',
                              'Операция со счётом вручную'
                            ) ?></textarea>
              </div>
            </div>
          <? } ?>
      </div>
      <div class="modal-footer">
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'id'          => 'user-payment-submit-' . $this->id,
              'buttonType'  => 'button', // 'buttonType'  => 'ajaxSubmit',
              'type'        => 'default',
                //'size'=>'mini',
              'icon'        => 'fa fa-check',
              'label'       => Yii::t('main', 'Сохранить'),
              'htmlOptions' => [
                'onclick' => 'create_user_payment_' . $this->id . '()',
              ],
            ],
          );
          ?>
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
              'icon'        => 'fa fa-close',
              'label'       => Yii::t('main', 'Отмена'),
              'htmlOptions' => ['data-dismiss' => 'modal'],
            ]
          );
          ?>

          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'reset',
              'type'        => 'default',
                //'size'       => 'mini',
              'icon'        => 'fa fa-rotate-left',
              'label'       => Yii::t('main', 'Сброс'),
              'htmlOptions' => ['class' => 'pull-left'],
            ]
          ); ?>
      </div>
        <?php
        $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    function create_user_payment_<?=$this->id?>() {
        var data = $("#user-payment-create-form-<?=$this->id?>").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/users/balance'); ?>',
            data: data,
            success: function (data) {
                var objId = 'enmpty';
                try {
                    if (data !== 'false') {
                        $('#user-payment-create-modal-<?=$this->id?>').modal('hide');
                        $('body').find('<?=$this->yiiGridViewIdToUpdate?>').each(function () {
                            objId = $(this).attr('id');
                            if (objId.length > 0) {
                                //console.log('Try to update grid ' + objId);
                                $.fn.yiiGridView.update(objId, {});
                            }
                        });
                        $('body').find('<?=$this->yiiListViewIdToUpdate?>').each(function () {
                            objId = $(this).attr('id');
                            if (objId.length > 0) {
                                //console.log('Try to update grid ' + objId);
                                $.fn.yiiListView.update(objId, {});
                            }
                        });
                        dsAlert('Сохранено', 'Подтверждение', true);
                    }
                } catch (e) {
                    console.log('ERROR to update ' + objId + '\r\n' + e);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function renderCreateForm_user_payment_<?=$this->id?>() {
        $('#user-payment-create-form-<?=$this->id?>').each(function () {
            this.reset();
        });
        $('#user-payment-create-modal-<?=$this->id?>').modal('show');
    }

</script>