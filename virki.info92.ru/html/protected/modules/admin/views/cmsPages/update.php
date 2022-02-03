<? /** @var customCmsPages $model */ ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Страница') ?> #<?= $model->page_id; ?>
  </h1>
</section>
<!-- Main content -->
<section class="content">
    <?php $this->renderPartial('_form', ['model' => $model]); ?>
</section>
