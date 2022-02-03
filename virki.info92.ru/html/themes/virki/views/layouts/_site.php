<? // Блок слайдера баннеров на главной ?>
<? $this->widget('application.components.widgets.sliderBlock') ?>

<div class="left-col">
    <? // Вертикальный список категорий на главной и в поисковых страницах ?>
  <h4 class="page-title"><?= Yii::t('main', 'Категории товаров') ?></h4>

  <div id="main-cats-menu-ajax">
        <span style="text-align: center;">
            <img src="<?= $this->frontThemePath ?>/images/Hourglass.png">
        </span>
  </div>

    <? if (Yii::app()->user->notInRole('guest')) { ?>
      <h4 class="page-title"><?= Yii::t('main', 'Избранное') ?></h4>
      <div id="favorites-menu">
          <? // Блок категорий избранного, который выводится ниже меню категорий?>
          <?
          $this->widget(
            'application.components.widgets.FavoritesMenuBlock',
            [
              'adminMode' => false,
            ]
          );
          ?>
      </div>
    <? } ?>
</div>

<div class="main-col" id="content">
    <? //Здесь выводится контент представления контроллера ?>
    <?= $content ?>
</div>
<div class="clear" style="height: 15px;"></div>
<div>
    <? //Рендеринг блока брендов?>
    <? $this->widget('application.components.widgets.BrandsBlock'); ?>
</div>
<div class="clear"></div>
<?= cms::customContent('main') ?>

