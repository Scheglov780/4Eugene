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

<div class="container">
  <div class="row clearfix f-space10"></div>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="page-title">
        <h2><?= $this->pageTitle ?></h2>
      </div>
    </div>
  </div><!--End:Row-->
  <div class="row clearfix f-space10"></div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 box-block page-sidebar">
    <div class="box-heading"><span><?= Yii::t('main', 'Меню') ?></span></div>
      <? // Виджет меню кабинета
      $this->widget('application.components.widgets.cabinetMenuBlock'); ?>
  </div><!-- End:Col-->
  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="alert alert-danger">
        <?= Yii::t('main', 'Символом * отмечены поля, обязательные для заполнения') ?>
    </div>
    <div class="form-group profile">
      <form method="post" action="/ru/cabinet/profile/index">
        <div class="row">
          <div class="col-md-4">
            <label><?= $model->getAttributeLabel('fullname') ?> <span class="sss">*</span> </label>
          </div>
          <div class="col-md-8">
            <input class="input3 form-control" value="<?= $model->fullname; ?>" name="CabinetForm[fullname]"
                   type="text"/>
          </div>
        </div>
        <div class="row clearfix f-space10"></div>

          <? /*   Заменить ДАТАПИКЕРОМ ! ! ! !
                <div class="row">
                    <div class="col-md-4">
                        <label><?= $model->getAttributeLabel('d_birth') ?></label>
                    </div>
                    <div class="col-md-8">
                        <input class="input3" value="<?= $model->d_birth; ?>" type="dropdownlist" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label><?= $model->getAttributeLabel('m_birth') ?></label>
                    </div>
                    <div class="col-md-8">
                        <input class="input3" value="<?= $model->m_birth; ?>" type="dropdownlist" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label><?= $model->getAttributeLabel('y_birth') ?></label>
                    </div>
                    <div class="col-md-8">
                        <input class="input3" value="<?= $model->y_birth; ?>" type="dropdownlist" />
                    </div>
                </div>
               */ ?>
        <div class="row clearfix f-space10"></div>
        <div class="row">
          <div class="col-md-4">
            <label><?= $model->getAttributeLabel('phone') ?></label>
          </div>
          <div class="col-md-8">
            <input class="input3 form-control" value="<?= $model->phone; ?>" name="CabinetForm[phone]"
                   type="tel"/>
          </div>
        </div>
        <div class="row clearfix f-space10"></div>
        <div class="row">
          <div class="col-md-4">
            <label><?= $model->getAttributeLabel('promo_code') ?></label>
          </div>
          <div class="col-md-8">
            <input class="input3 form-control" value="<?= $model->promo_code; ?>"
                   name="CabinetForm[promo_code]"
                   type="text"/>
          </div>
        </div>
        <div class="row clearfix f-space10"></div>
        <div class="row">
          <div class="col-md-4">
            <label><?= $model->getAttributeLabel('password') ?></label>
          </div>
          <div class="col-md-8">
            <input class="input3 form-control" value="<?= $model->password; ?>" name="CabinetForm[password]"
                   type="password"/>
          </div>
        </div>
        <div class="row clearfix f-space10"></div>
        <div class="row">

        </div>
        <div class="row clearfix f-space10"></div>

        <div class="row">
          <button class="btn color2 pull-right" type="submit" name="submit"
                  style="position: relative; right: 15px; top: 15px; padding: 10px;"><?= Yii::t(
                'main',
                'Сохранить'
              ) ?></button>
        </div>
      </form>
    </div><!--End:Form-group & Prolile-->
  </div><!--End:Col-->

</div>
<br/><br/>
