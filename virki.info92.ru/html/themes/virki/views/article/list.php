<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 * Представление для отображения статических страниц (cms)
 * Нaпример, по ссылке http://<domain.ru>/ru/article/oplata
 * var $article = stdClass#1
 * (
 * [title] => 'Способы оплаты'
 * [description] => 'Способы оплаты'
 * [keywords] => 'Способы оплаты'
 * [content] => HTML-контент страницы
 * )
 **********************************************************************************************************************/
?>
<div class="row clearfix f-space10"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
        <? foreach ($articles as $article) {
            if (!$article['enabled'] || !$article['title']) {
                continue;
            }
            //print_r($article);
            ?>
          <a class="<?= (($article['parent'] == 1) ? 'level1' : 'level2') ?><?= (($article['children']) ?
            ' have-children' : '') ?>"
             href="<?= Yii::app()->createUrl('/article/' . $article['url']) ?>" data-toggle="tooltip"
             data-placement="bottom"
             title="<?= Yii::t('main', $article['description']) ?>"><?= Yii::t('main', $article['title']) ?></a>
          <br>
        <? } ?>
    </div>
  </div>
</div>
<div class="row clearfix f-space30"></div>
