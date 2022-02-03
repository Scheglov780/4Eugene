<?php
$langArray = explode(',', DSConfig::getVal('site_language_block'));
$languages = [];
$languages[] = '*';
if (is_array($langArray)) {
    foreach ($langArray as $lang) {
        $languages[] = $lang;
    }
}
$updateScript = '';
foreach ($languages as $language) {
//select record from data
    $record = false;
    if (isset($data->records[$language])) {
        $updateScript =
          $updateScript . ' PagesContent_update_textVar_' . ($language == '*' ? 'asterisk' : $language) . '.save();';
    }
}
?>
<div class="box-header with-border">
  <h3 class="box-title"><?= Yii::t('main', 'Редактирование контента страницы') ?></h3>
</div>
<?php
/** @var TbActiveForm $form */
$form = $this->beginWidget(
  'booster.widgets.TbActiveForm',
  [
    'id'                     => 'pagesContent-ex-update-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => false,
    'type'                   => 'horizontal',
    'method'                 => 'post',
    'action'                 => ['/' . Yii::app()->controller->module->id . '/cmsPagesContent/updateEx'],
      //'type'=>'horizontal',
    'htmlOptions'            => [
      'onsubmit' => "return false;",
        /* Disable normal form submit */
        //'onkeypress'=>" if(event.keyCode == 13){ update_cmsPagesContent (); } " /* Do ajax call when user presses enter key */
    ],
  ]
); ?>
<input type="hidden" name="page_id" value="<?= $data->page_id ?>"/>
<div class="box-body">
  <div class="nav-tabs-custom" id="PagesContent-update-lang-tabs">
    <ul class="nav nav-tabs" role="tablist">
        <?
        foreach ($languages as $language) {
            $languageName = $language;
            $language = ($language == '*' ? 'asterisk' : $language);
            ?>
          <li role="presentation" <?= $language == 'asterisk' ? ' class="active"' : '' ?>><a
                href="#PagesContent-update-lang-tabs-<?= $language ?>"
                aria-controls="PagesContent-update-lang-tabs-<?= $language ?>"
                role="tab"
                data-toggle="tab"><?= $languageName ?></a></li>
            <? /* <script>
                $('#myTabs a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
                })
                </script>
                */ ?>
        <? } ?>
    </ul>
    <div class="tab-content">
        <? foreach ($languages as $language) {
            //select record from data
            $record = false;
            if (isset($data->records[$language])) {
                $record = $data->records[$language];
            }
            $languageName = $language;
            $language = ($language == '*' ? 'asterisk' : $language);
            ?>
          <div role="tabpanel" class="<?= $language == 'asterisk' ? 'active ' : '' ?>tab-pane"
               id="PagesContent-update-lang-tabs-<?= $language ?>">
            <input type="hidden" name="PagesContent[<?= $languageName ?>][id]"
                   value="<?= ($record ? $record->id : 0) ?>"/>
            <div class="form-group">
              <label for="PagesContent_update_title_<?= $language ?>"><?= Yii::t(
                    'main',
                    'meta title'
                  ) ?> <?= $languageName ?></label>
              <textarea class="form-control" id="PagesContent_update_title_<?= $language ?>"
                        name="PagesContent[<?= $languageName ?>][title]"><?= ($record ? $record->title :
                    '') ?></textarea>
            </div>
            <div class="form-group">
              <label for="PagesContent_update_description_<?= $language ?>"><?= Yii::t(
                    'main',
                    'meta description'
                  ) ?></label>
              <textarea class="form-control" id="PagesContent_update_description_<?= $language ?>"
                        name="PagesContent[<?= $languageName ?>][description]"><?= ($record ? $record->description :
                    '') ?></textarea>
            </div>
            <div class="form-group">
              <label for="PagesContent_update_keywords_<?= $language ?>"><?= Yii::t(
                    'main',
                    'meta keywords'
                  ) ?></label>
              <textarea class="form-control" id="PagesContent_update_keywords_<?= $language ?>"
                        name="PagesContent[<?= $languageName ?>][keywords]"><?= ($record ? $record->keywords :
                    '') ?></textarea>
            </div>
            <div class="form-group">
              <label for="PagesContent_update_text_<?= $language ?>"><?= Yii::t(
                    'main',
                    'Контент страницы'
                  ) ?></label>
              <textarea class="form-control" id="PagesContent_update_text_<?= $language ?>"
                        name="PagesContent[<?= $languageName ?>][text]"><?= ($record ? $record->content_data :
                    '') ?></textarea>
            </div>
            <script>
                if (PagesContent_update_textVar_<?=$language ?> != undefined) {
                    PagesContent_update_textVar_<?=$language ?>.toTextArea();
                }
                var PagesContent_update_textVar_<?=$language ?> = CodeMirror.fromTextArea(
                    document.getElementById('PagesContent_update_text_<?= $language ?>')
                    , {
                        //lineNumbers: true,
                        mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                        matchBrackets: true,
                    });
                PagesContent_update_textVar_<?=$language ?>.setSize(null, 500);
                PagesContent_update_textVar_<?=$language ?>.refresh();
            </script>
          </div>
        <? } ?>
    </div>
  </div>
</div>
<div class="box-footer">
    <?php
    $this->widget(
      'booster.widgets.TbButton',
      [
        'buttonType'  => 'button',
        'type'        => 'info',
        'icon'        => 'ok white',
        'label'       => Yii::t('main', 'Сохранить'),
        'htmlOptions' => ['onclick' => "{$updateScript} updateExSave();"],
      ]
    );
    ?>
</div>
<?php $this->endWidget(); ?>

