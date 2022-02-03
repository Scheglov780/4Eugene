<div class="left-col">
    <?
    // Блок меню кабинета
    $this->widget('application.components.widgets.cabinetMenuBlock'); ?>
</div>
<div class="main-col" id="cabinet">
    <? $this->widget('application.components.widgets.UserNoticeBlock'); ?>
    <? //Здесь выводится контент представления контроллера ?>
    <?= $content ?>
</div>
