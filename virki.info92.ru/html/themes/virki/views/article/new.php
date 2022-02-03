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
<div class="page-title">
    <?= isset($this->pageTitle) ? $this->pageTitle : '' ?>
</div>
<div class="content">
    <?= Yii::t('main', 'Создать?') ?><br>
    <?= isset($article->content) ? $article->content : $article ?>
</div>