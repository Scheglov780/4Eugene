<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchQueryBlock.php">
 * </description>
 * Виджет, реализующий поисковую строку
 * var $cats = - список категорий для фильтра
 * array
 * (
 * 0 => array
 * (
 * 'pkid' => '2'
 * 'cid' => '0'
 * 'parent' => '1'
 * 'status' => '1'
 * 'url' => 'mainmenu-odezhda'
 * 'query' => '女装男装'
 * 'level' => '2'
 * 'order_in_level' => '200'
 * 'view_text' => 'Одежда'
 * 'children' => array
 * (
 * 3 => array(...)
 * 18 => array(...)
 * 31 => array(...)
 * 41 => array(...)
 * 49 => array(...)
 * 60 => array(...)
 * 70 => array(...)
 * 81 => array(...)
 * )
 * )
 * )
 * var $query = '' - поисковый запрос
 * var $cid = '' - cid категории
 **********************************************************************************************************************/
?>
<? /* <div <?//AlexySearch?>> */ ?>
<?
Yii::app()->clientScript->registerScript(
  'lazySearch',
  "
  $('#main-search-block').off('submit').on('submit',function(event) {
  dsProgress('" . Yii::t('main', 'Дождитесь завершения поиска...') . "','" . Yii::t('main', 'Поиск') . "');
  });
",
  CClientScript::POS_END
);
?>

  <!--<div class="searchbar">-->
<?= CHtml::beginForm(['/search/index'], 'get', ['id' => 'main-search-block', 'class' => 'searchForm']) ?>
  <input name="query" autocomplete="off" id="query" data-toggle="tooltip"
         data-placement="bottom"
         title="<?= Yii::t(
           'main',
           'Введите запрос для поиска данных'
         ); ?>"
         placeholder="<?= Yii::t('main', 'Поиск документов') ?>..." value="<?= $query ?>"
         type="search">
  <button class="pull-right btn-search" type="button" onclick="submitSearchForm();"><i
        class="fa fa-search"></i></button>
<?= CHtml::endForm() ?>
  <script>
      //=== Yandex spellchecker and corrector ====
      function submitSearchForm() {
          console.log('Yandex speller: Try to check...');
          <? if (in_array(Utils::appLang(), ['ru', 'en'])) { ?>
          var query = $('#query').val().trim().replace(/\r\n|\n\r|\n|\r/g, '\n');
          if (!query.match(/http[s]*|select|delete|[\/\\<>#@&*\.\$!]/i)) {
              var lines = query.split('\n');
              lines.forEach(function (line) {
                  if (line.length) {
                      try {
                          $.ajax({
                              url: '//speller.yandex.net/services/spellservice.json/checkText?text=' + line + '&options=2583',
                              dataType: 'json',
                              success: function (data) {
                                  fixQuerySyntaxErrorsCallback(data);
                              },
                              error: function (jqXHR, textStatus, errorThrown) {
                                  console.log('Yandex speller: Can\'t access (error)');
                                  $('#main-search-block').submit();
                              },
                              fail: function (jqXHR, textStatus, errorThrown) {
                                  console.log('Yandex speller: Can\'t access (fail)');
                                  $('#main-search-block').submit();
                              }
                          });
                      } catch (e) {
                          console.log('Yandex speller: Can\'t access (catch)');
                          $('#main-search-block').submit();
                      }
                  }
              });
          } else {
              $('#main-search-block').submit();
          }
          <? } else { ?>
          $('#main-search-block').submit();
          <? } ?>
      }

      $('#query').keypress(function (event) {
          if (event.which == 13) {
              submitSearchForm();
              return false;
          }
      });

      fixQuerySyntaxErrorsCallback = function (data) {
          try {
              var originalVal = $('#query').val().trim();
              var correctedVal = originalVal;
              data.forEach(function (elem) {
                  correctedVal = correctedVal.replace(
                      elem['word'],
                      elem['s'][0] || elem['word']
                  );
              });
              if (originalVal != correctedVal) {
                  if (dsConfirm('<?=Yii::t(
                    'main',
                    'Возможно, в запросе допущены ошибки'
                  )?>:\n\n' + correctedVal + '\n\n<?=Yii::t('main', 'Исправить?')?>',
                      '<?=Yii::t('main', 'Проверка запроса')?>', false
                  )) {
                      $('#query').val(correctedVal);
                  }
              }
              $('#main-search-block').submit();
          } catch (e) {
              $('#main-search-block').submit();
          }
      };
  </script>
<? /* </div> */ ?>