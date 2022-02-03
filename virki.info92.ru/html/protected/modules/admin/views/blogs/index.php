<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Блоги') ?>
    <small><?= Yii::t('main', 'Управление блогами, категориями блогов, сообщениями, комментариями') ?></small>
  </h1>
    <? /*
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">UI</a></li>
            <li class="active">Buttons</li>
        </ol>
        */ ?>
</section>
<section class="content">
    <? $this->widget(
      'application.components.widgets.BlogCategoriesBlock',
      [
        'adminMode' => true,
      ]
    );
    $this->widget(
      'application.components.widgets.BlogPostsBlock',
      [
        'adminMode' => true,
      ]
    );
    ?>
</section>
