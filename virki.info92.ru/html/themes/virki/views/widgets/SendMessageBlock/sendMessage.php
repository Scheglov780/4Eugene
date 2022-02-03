<? if ($this->asButton) { ?>
  <a href="javascript:void(0);"
     onclick="$('#btnRefreshCaptcha-<?= $this->id ?>').click();$('#sendMessageDialog-<?= $this->id ?>').modal('show');"><?= $this->label ?></a>
  <div class="modal fade" id="sendMessageDialog-<?= $this->id ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="commentForm">
            <?php $form = $this->beginWidget(
              'booster.widgets.TbActiveForm',
              [
                'id'                     => 'sendMessageForm-' . $this->id,
                'enableAjaxValidation'   => false,
                'enableClientValidation' => false,
                'action'                 => ['/site/sendMail'],
                'method'                 => 'POST',
                  //'htmlOptions' => array('class' => 'well'), // for inset effect
              ]
            ) ?>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <? /*                        <a class="close" data-dismiss="modal">x</a> */ ?>
            <h4><?= $this->label ?></h4>
          </div>
          <div class="modal-body">
              <?= $form->hiddenField($model, 'subj'); ?>
            <div class="row">
              <div class="col-lg-5 formmargin">
                  <?= $form->labelEx($model, 'name'); ?>
                  <?= $form->textField($model, 'name', ['class' => 'required']); ?>
                  <?= $form->error($model, 'name'); ?><br/>
                  <?= $form->labelEx($model, 'email'); ?>
                  <?= $form->emailField($model, 'email', ['class' => 'required']); ?>
                  <?= $form->error($model, 'email'); ?><br/>
              </div>
              <div class="col-lg-7">
                  <?= $form->labelEx($model, 'message'); ?>
                  <?= $form->textArea($model, 'message', ['class' => 'required']); ?>
                  <?= $form->error($model, 'message'); ?><br/>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <? if (CCaptcha::checkRequirements()) { ?>
                <div class="col-lg-4">
                  <div class="img-responsive pull-right"><? $this->widget(
                        'CCaptcha',
                        [
                          'buttonLabel'   => Yii::t('main', 'Обновить'),
                          'buttonOptions' => ['id' => 'btnRefreshCaptcha-' . $this->id],
                          'captchaAction' => Yii::app()->createUrl('/site/captcha'),
                        ]
                      /*
                      actionPrefix 	string 	the prefix to the IDs of the actions. 	CWidget
                      buttonLabel 	string 	the label for the refresh button. 	CCaptcha
                      buttonOptions 	array 	HTML attributes to be applied to the rendered refresh button element. 	CCaptcha
                      buttonType 	string 	the type of the refresh button. 	CCaptcha
                      captchaAction 	string 	the ID of the action that should provide CAPTCHA image. 	CCaptcha
                      clickableImage 	boolean 	whether to allow clicking on the CAPTCHA image to refresh the CAPTCHA letters. 	CCaptcha
                      controller 	CController 	Returns the controller that this widget belongs to. 	CWidget
                      id 	string 	Returns the ID of the widget or generates a new one if requested. 	CWidget
                      imageOptions 	array 	HTML attributes to be applied to the rendered image element. 	CCaptcha
                      owner 	CBaseController 	Returns the owner/creator of this widget. 	CWidget
                      showRefreshButton 	boolean 	whether to display a button next to the CAPTCHA image. 	CCaptcha
                      skin 	mixed 	the name of the skin to be used by this widget. 	CWidget
                      viewPath 	string 	Returns the directory containing the view files for this widget. 	CWidget
                      */
                      ); ?></div>
                </div>
                <div class="col-lg-5">
                    <? //= $form->labelEx($model, 'captcha'); ?>
                    <?= $form->textField($model, 'captcha', [
                      'class'       => 'required pull-left',
                      'placeholder' => $model->getAttributeLabel('captcha'),
                      'title'       => $model->getAttributeLabel('captcha'),
                    ]); ?>
                    <?= $form->error($model, 'captcha'); ?>
                </div>
              <? } ?>
            <div class="col-lg-3">
              <button type="submit" class="blogReadmore" id="con_submit-<?= $this->id ?>"><?= Yii::t(
                    'main',
                    'Отправить'
                  ) ?></button>
            </div>
          </div>
            <? $this->endWidget(
              'booster.widgets.TbActiveForm'
            ) ?>
        </div>
      </div>
    </div>
  </div>
<? } else { ?>
  <h2 class="commentTitle"><?= $this->label ?></h2>
  <div class="commentForm">
      <?php $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        [
          'id'                     => 'sendMessageForm-' . $this->id,
          'enableAjaxValidation'   => false,
          'enableClientValidation' => false,
          'action'                 => ['/site/sendMail'],
          'method'                 => 'POST',
            //'htmlOptions' => array('class' => 'well'), // for inset effect
        ]
      ) ?>
      <?= $form->hiddenField($model, 'subj') ?>
    <div class="row">
      <div class="col-lg-5 formmargin">
          <?= $form->labelEx($model, 'name'); ?>
          <?= $form->textField($model, 'name', ['class' => 'required']); ?>
          <?= $form->error($model, 'name'); ?><br/>

          <?= $form->labelEx($model, 'email'); ?>
          <?= $form->emailField($model, 'email', ['class' => 'required']); ?>
          <?= $form->error($model, 'email'); ?><br/>
      </div>
      <div class="col-lg-7">
          <?= $form->labelEx($model, 'message'); ?>
          <?= $form->textArea($model, 'message', ['class' => 'required']); ?>
          <?= $form->error($model, 'message'); ?><br/>
      </div>
    </div>
    <div class="row">
        <? if (CCaptcha::checkRequirements()) { ?>
          <div class="col-lg-5">
            <div class="img-responsive pull-right"><? $this->widget(
                  'CCaptcha',
                  [
                    'buttonLabel'   => Yii::t('main', 'Обновить'),
                    'buttonOptions' => ['id' => 'btnRefreshCaptcha-' . $this->id, 'class' => 'blogReadmore'],
                    'captchaAction' => Yii::app()->createUrl('/site/captcha'),
                  ]
                /*
                actionPrefix 	string 	the prefix to the IDs of the actions. 	CWidget
                buttonLabel 	string 	the label for the refresh button. 	CCaptcha
                buttonOptions 	array 	HTML attributes to be applied to the rendered refresh button element. 	CCaptcha
                buttonType 	string 	the type of the refresh button. 	CCaptcha
                captchaAction 	string 	the ID of the action that should provide CAPTCHA image. 	CCaptcha
                clickableImage 	boolean 	whether to allow clicking on the CAPTCHA image to refresh the CAPTCHA letters. 	CCaptcha
                controller 	CController 	Returns the controller that this widget belongs to. 	CWidget
                id 	string 	Returns the ID of the widget or generates a new one if requested. 	CWidget
                imageOptions 	array 	HTML attributes to be applied to the rendered image element. 	CCaptcha
                owner 	CBaseController 	Returns the owner/creator of this widget. 	CWidget
                showRefreshButton 	boolean 	whether to display a button next to the CAPTCHA image. 	CCaptcha
                skin 	mixed 	the name of the skin to be used by this widget. 	CWidget
                viewPath 	string 	Returns the directory containing the view files for this widget. 	CWidget
                */
                ); ?></div>
          </div>
          <div class="col-lg-4">
              <? //= $form->labelEx($model, 'captcha'); ?>
              <?= $form->textField($model, 'captcha', [
                'class'       => 'required pull-left',
                'placeholder' => $model->getAttributeLabel('captcha'),
                'title'       => $model->getAttributeLabel('captcha'),
              ]); ?>
              <?= $form->error($model, 'captcha'); ?>
          </div>
        <? } ?>
      <div class="col-lg-3">
        <button type="submit" class="blogReadmore pull-right" id="con_submit-<?= $this->id ?>"><?= Yii::t(
              'main',
              'Отправить'
            ) ?></button>
      </div>
    </div>
      <? $this->endWidget(
        'booster.widgets.TbActiveForm'
      ) ?>
  </div>
<? } ?>
<? /*
    <section class="blogSection">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h2 class="commentTitle"><?= $this->label ?></h2>
                    <div class="commentForm">
                        <?php $form = $this->beginWidget(
                          'booster.widgets.TbActiveForm',
                          array(
                            'id' => 'sendMessageForm',
                            'enableAjaxValidation' => false,
                            'action' => array('#'),
                              //'htmlOptions' => array('class' => 'well'), // for inset effect
                          )
                        ) ?>
                        <div class="row">
                            <div class="col-lg-5 formmargin">
                                <?= $form->labelEx($model, 'name'); ?>
                                <?= $form->textField($model, 'name', array('class' => 'required')); ?>
                                <?= $form->error($model, 'name'); ?><br/>

                                <?= $form->labelEx($model, 'email'); ?>
                                <?= $form->emailField($model, 'email', array('class' => 'required')); ?>
                                <?= $form->error($model, 'email'); ?><br/>
                            </div>
                            <div class="col-lg-7">
                                <?= $form->labelEx($model, 'message'); ?>
                                <?= $form->textArea($model, 'message', array('class' => 'required')); ?>
                                <?= $form->error($model, 'message'); ?><br/>
                            </div>
                            <div class="row">
                                <? if (CCaptcha::checkRequirements()) { ?>
                                    <div class="col-lg-6">
                                        <div class="img-responsive" style="width:50%;"><? $this->widget(
                                              'CCaptcha'
                                            ); ?></div>

                                        <?= $form->labelEx($model, 'captcha'); ?>
                                        <?= $form->textField($model, 'captcha', array('class' => 'required')); ?>
                                        <?= $form->error($model, 'captcha'); ?>
                                    </div>
                                <? } ?>
                                <div class="col-lg-6">
                                    <button type="submit" class="blogReadmore" id="con_submit"><?= Yii::t('main',
                                          'Отправить'
                                        ) ?></button>
                                </div>
                            </div>
                        </div>
                        <? $this->endWidget(
                          'booster.widgets.TbActiveForm'
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
*/ ?>