<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/* @var $this UtilitesController */

$this->breadcrumbs = [
  'Utilites',
];
?>

<h1><?= Yii::t('main', 'Сброс основных параметров системы на значения по умолчанию') ?></h1>
<div class="modal-body">
  <div class="form">
      <?php
      $formData = new InstallForm();
      $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        [
          'id'                     => 'form-install-script',
          'enableAjaxValidation'   => false,
          'enableClientValidation' => false,
          'method'                 => 'post',
          'action'                 => ['/' . Yii::app()->controller->module->id . '/orders/update'],
            //'type'=>'horizontal',

        ]
      ); ?>
      <?php echo $form->errorSummary($formData, 'Opps!!!', null, ['class' => 'alert alert-error span12']); ?>
    <div class="control-group-install-form">
      <!-- ========================================================================= -->
      <ul>
        <li> <?= $form->textFieldRow(
              $formData,
              'billing_use_operator_account'
            ); // 1  Отображать ли и использовать ли счёт оператора для начисления премий и бонусов      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'checkout_delivery_needed'
            ); // 1  Нужно ли при оформлении заказа считать и вводить службу доставки      ?></li>
        <li><? //=$form->textFieldRow($formData ,'checkout_delivery_sum_needed'); // 1  Нужно ли при оформлении заказа считать службу доставки ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'checkout_order_reconfirmation_needed'
            ); // 0  Подтверждение заказа покупателем после его расчёта менеджером      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'checkout_payment_needed'
            ); // 1  Нужно ли при оформлении заказа его оплачивать      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'checkout_reorder_needed'
            ); // 1  Использовать ли дозаказ?      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'checkout_weight_needed'
            ); // 1  Нужно ли покупателю при заказе вводить вес      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_0_10'
            ); // 1  Скидка на товары 0-9.99 юаней, например, 0.9 - это скидка в 10%      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_10000_1000000000'
            ); // 0.85  Скидка на товары дороже 10000 юаней      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_1000_2000'
            ); // 0.93  Скидка на товары 1000-1999.99 юаней      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_10_60'
            ); // 0.99  Скидка на товары 10-59.99 юаней      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_150_200'
            ); // 0.96  Скидка на товары 150-199.99 юаней      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_2000_5000'
            ); // 0.92  Скидка на товары 2000-4999.99 юаней      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_200_500'
            ); // 0.95  Скидка на товары 200 – 499.99 юаней      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_5000_10000'
            ); // 0.9  Скидка на товары 5000-9999.99 юаней      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_500_1000'
            ); // 0.94  Скидка на товары 500-999.99 юаней      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_60_90'
            ); // 0.98  Скидка на товары 60-89.99 юаней      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_90_150'
            ); // 0.97  Скидка на товары 90-149.99 юаней      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_main_k'
            ); // 1.7  Основной коэффициент в цене, например 1.5 это наценка в 30%      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'price_main_k_min_sum'
            ); // 10  Минимальная сумма наценки на весь лот, в валюте сайта      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'rate_byr'
            ); // 0.00364  Курс белорусского рубля к основной валюте      ?></li>
        <li><?= $form->textFieldRow($formData, 'rate_cny'); // 5.157672  Курс юаня к основной валюте      ?></li>
        <li><?= $form->textFieldRow($formData, 'rate_eur'); // 41.15  Курс евро к основной валюте      ?></li>
        <li><?= $form->textFieldRow($formData, 'rate_kzt'); // 0.22  Курс тенге к основной валюте      ?></li>
        <li><?= $form->textFieldRow($formData, 'rate_rur'); // 1  Курс рубля к основной валюте      ?></li>
        <li><?= $form->textFieldRow($formData, 'rate_uah'); // 3.85  Курс гривны к основной валюте      ?></li>
        <li><?= $form->textFieldRow($formData, 'rate_usd'); // 31.72  Курс доллара к основной валюте      ?></li>
        <li><?= $form->textAreaRow(
              $formData,
              'seo_sitemap_static'
            ); // <url><loc>http://777.danvit.ru</loc></url>  Статическая часть sitemap.xml      ?></li>
        <li><?= $form->textAreaRow(
              $formData,
              'site_currency'
            ); // usd  Главная валюта сайта, валюта админки и кабинета      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'site_currency_block'
            ); // usd,eur,rur,uah,byr,kzt,cny  Валюты, которые доступны пользователю на сайте (маленькими буквами, через запятую, без пробелов, в одну строку)      ?></li>
        <li><?= $form->textFieldRow($formData, 'site_domain'); // 777.danvit.ru  Домен сайта      ?></li>
        <li><?= $form->textFieldRow($formData, 'site_name'); // dropshop.pro  Название сайта      ?></li>
        <li><?= $form->textFieldRow($formData, 'skidka_0_10'); // 1  Скидка на количество 0-10      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'skidka_10000_1000000000'
            ); // 0.99  Скидка на количество более 10000      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'skidka_1000_2000'
            ); // 0.85  Скидка на количество 1000-2000      ?></li>
        <li><?= $form->textFieldRow($formData, 'skidka_10_60'); // 0.95  Скидка на количество 10-60      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'skidka_150_200'
            ); // 0.95  Скидка на количество 150-200      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'skidka_2000_5000'
            ); // 0.9  Скидка на количество 2000-5000      ?></li>
        <li><?= $form->textFieldRow($formData, 'skidka_200_500'); // 0.9  Скидка на количество 200-500      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'skidka_5000_10000'
            ); // 0.9  Скидка на количество 5000-10000      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'skidka_500_1000'
            ); // 0.9  Скидка на количество 500-1000      ?></li>
        <li><?= $form->textFieldRow($formData, 'skidka_60_90'); // 0.95  Скидка на количество 60-90      ?></li>
        <li><?= $form->textFieldRow($formData, 'skidka_90_150'); // 0.95  Скидка на количество 90-150      ?></li>
        <li><?= $form->textFieldRow(
              $formData,
              'source_EnabelDiscounts'
            ); // 1  Использовать ли скидки от таобао?      ?></li>

      </ul>
      <!-- ========================================================================= -->
    </div>
    <div class="clear"><br/></div>

  </div>
</div>
<div class="modal-footer">
    <?php
    $this->widget(
      'booster.widgets.TbButton',
      [
        'buttonType'  => 'button',
        'type'        => 'default',
          //'size'        => 'mini',
        'icon'        => 'fa fa-check',
        'label'       => Yii::t('main', 'Сохранить'),
        'url'         => '/' . Yii::app()->controller->module->id . '/utilites/setparams',
        'ajaxOptions' => [
          'complete' => 'js:function(){alert("' . Yii::t('main', 'Параметры сохранены') . '");}',
        ],
      ]
    );
    ?>
    <?php
    $this->widget(
      'booster.widgets.TbButton',
      [
        'buttonType'  => 'ajaxSubmit',
        'type'        => 'danger',
        'icon'        => 'remove white',
        'label'       => Yii::t('main', 'Удалить демо-данные'),
        'url'         => '/' . Yii::app()->controller->module->id . '/utilites/cleardatabase/table/all',
        'ajaxOptions' => [
          'complete' => 'js:function(){alert("' . Yii::t('main', 'Демонстрационные данные удалены') . '");}',
        ],
      ]
    );
    ?>
</div>
<?php $this->endWidget(); ?>
<!-- ================================================ -->
<div style="display: none;">
    <span class="badge badge-important" style="margin: 1.2em; font-size: 1.2em;"><?= Yii::t(
          'main',
          'Преобразование старого формата cледует выполнить один раз при переходе на новый формат.'
        ) ?></span>
  <div class="form">
    <form id="convertOrders">
            <span class="badge badge-info"><?= Yii::t(
                  'main',
                  'Преобразование старого формата хранения заказов в новый.'
                ) ?></span>
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'ajaxSubmit',
            'type'        => 'success',
            'icon'        => 'fa fa-spinner fa-spin white',
            'label'       => Yii::t('main', 'Преобразовать'),
//    'loadingText'=>Yii::t('main','Выполняется...'),
//    'completeText'=>Yii::t('main','Выполнено'),
            'url'         => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/utilites/command',
              ['cmd' => 'convertOrders']
            ),
            'htmlOptions' => [],
            'ajaxOptions' => ['update' => '#convertOrdersResult'],
          ]
        );
        ?>
      <div id="convertOrdersResult"></div>
    </form>
  </div>
  <!-- ================================================ -->
  <div class="form">
    <form id="convertOrdersItems">
            <span class="badge badge-info"><?= Yii::t(
                  'main',
                  'Преобразование старого формата хранения товаров в новый.'
                ) ?></span>
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'ajaxSubmit',
            'type'        => 'success',
            'icon'        => 'fa fa-spinner fa-spin white',
            'label'       => Yii::t('main', 'Преобразовать'),
//      'loadingText'=>Yii::t('main','Выполняется...'),
//      'completeText'=>Yii::t('main','Выполнено'),
            'url'         => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/utilites/command',
              ['cmd' => 'convertOrdersItems']
            ),
            'htmlOptions' => [],
            'ajaxOptions' => ['update' => '#convertOrdersItemsResult'],
          ]
        );
        ?>
      <div id="convertOrdersItemsResult"></div>
    </form>
  </div>
  <!-- ================================================ -->
  <div class="form">
    <form id="convertCart">
            <span class="badge badge-info"><?= Yii::t(
                  'main',
                  'Преобразование старого формата корзины в новый.'
                ) ?></span>
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'ajaxSubmit',
            'type'        => 'success',
            'icon'        => 'fa fa-spinner fa-spin white',
            'label'       => Yii::t('main', 'Преобразовать'),
//      'loadingText'=>Yii::t('main','Выполняется...'),
//      'completeText'=>Yii::t('main','Выполнено'),
            'url'         => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/utilites/command',
              ['cmd' => 'convertCart']
            ),
            'htmlOptions' => [],
            'ajaxOptions' => ['update' => '#convertCartResult'],
          ]
        );
        ?>
      <div id="convertCartResult"></div>
    </form>
  </div>
  <!-- ================================================ -->
  <div class="form">
    <form id="convertDeliveries">
            <span class="badge badge-info"><?= Yii::t(
                  'main',
                  'Преобразование старого формата служб доставок в новый.'
                ) ?></span>
      <!--<p><input placeholder="Ваше имя" name="user"></p> -->
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'ajaxSubmit',
            'type'        => 'success',
            'icon'        => 'fa fa-spinner fa-spin white',
            'label'       => Yii::t('main', 'Преобразовать'),
//      'loadingText'=>Yii::t('main','Выполняется...'),
//      'completeText'=>Yii::t('main','Выполнено'),
            'url'         => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/utilites/command',
              ['cmd' => 'convertDeliveries']
            ),
            'htmlOptions' => [],
            'ajaxOptions' => ['update' => '#convertDeliveriesResult'],
          ]
        );
        ?>
      <div id="convertDeliveriesResult"></div>
    </form>
  </div>
  <!-- ================================================ -->
  <div class="form">
    <form id="convertArticles">
            <span class="badge badge-info"><?= Yii::t(
                  'main',
                  'Преобразование старого формата статей в новый.'
                ) ?></span>
      <!--<p><input placeholder="Ваше имя" name="user"></p> -->
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'ajaxSubmit',
            'type'        => 'success',
            'icon'        => 'fa fa-spinner fa-spin white',
            'label'       => Yii::t('main', 'Преобразовать'),
//      'loadingText'=>Yii::t('main','Выполняется...'),
//      'completeText'=>Yii::t('main','Выполнено'),
            'url'         => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/utilites/command',
              ['cmd' => 'convertArticles']
            ),
            'htmlOptions' => [],
            'ajaxOptions' => ['update' => '#convertArticlesResult'],
          ]
        );
        ?>
      <div id="convertArticlesResult"></div>
    </form>
  </div>
  <!-- ================================================ -->
  <div class="form">
    <form id="loadDic">
      <span class="badge badge-info"><?= Yii::t('main', 'Загрузка переводов.') ?></span>
      <!--<p><input placeholder="Ваше имя" name="user"></p> -->
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'ajaxSubmit',
            'type'        => 'success',
            'icon'        => 'fa fa-spinner fa-spin white',
            'label'       => Yii::t('main', 'Загрузка'),
//      'loadingText'=>Yii::t('main','Выполняется...'),
//      'completeText'=>Yii::t('main','Выполнено'),
            'url'         => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/utilites/command',
              ['cmd' => 'loadDic']
            ),
            'htmlOptions' => [],
            'ajaxOptions' => ['update' => '#loadDicResult'],
          ]
        );
        ?>
      <div id="loadDicResult"></div>
    </form>
  </div>
  <div class="form">
      <?
      $model = new OrdersItemsCommentsAttaches();
      $this->widget(
        'ext.xphoto.XPhoto',
        [
          'model'     => $model,
          'attribute' => 'uploadedFile',
        ]
      );
      ?>
  </div>
</div>