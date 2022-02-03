<!--Breadcrumb Start-->
<section class="breadcrumbSec">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 text-center">
          <?
          reset($this->breadcrumbs);
          end($this->breadcrumbs);
          $breadCrumbTitle = key($this->breadcrumbs);
          if (is_numeric($breadCrumbTitle)) {
              $breadCrumbTitle = end($this->breadcrumbs);
          }
          ?>
        <h1 class="breadTitle"><?= $breadCrumbTitle ?></h1>
          <?php $this->widget(
            'booster.widgets.TbBreadcrumbs',
            [
              'separator' => '<i class="fa fa-angle-right"></i>',
              'htmlOptions' => ['class' => 'breadCumpNav',],
              'links' => $this->breadcrumbs,
              'homeLink' => CHtml::link('<i class="fa fa-home"></i>' . Yii::t('main', 'Главная'), '/'),
            ]
          ); ?>
          <? //</div>?>
      </div>
    </div>
  </div>
</section>
<!--Breadcrumb End-->