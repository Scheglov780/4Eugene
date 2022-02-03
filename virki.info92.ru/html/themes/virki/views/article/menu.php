<?
//==== Неспешно получаем дерево меню. Будет надо - ускорим ============================
$sql = "SELECT \"id\",\"parent\",\"order_in_level\",
        (SELECT count(0) FROM cms_pages pp2 WHERE pp.id = pp2.parent) AS childrenCount,
        \"page_id\",\"url\", \"enabled\", \"SEO\"
          FROM \"cms_pages\" pp
        WHERE pp.enabled = 1 AND pp.parent = 1  AND pp.id!=1
        ORDER BY pp.order_in_level
        ";
$rows = Yii::app()->db->cache(YII_DEBUG ? 0 : 600)->createCommand($sql)->queryAll();
$menu = [];
if ($rows) {
    foreach ($rows as $row) {
        $menu[$row['id']] = new stdClass();
        $menu[$row['id']]->id = $row['id'];
        $menu[$row['id']]->parent = $row['parent'];
        $menu[$row['id']]->order_in_level = $row['order_in_level'];
        $menu[$row['id']]->childrenCount = $row['childrenCount'];
        $menu[$row['id']]->page_id = $row['page_id'];
        $menu[$row['id']]->url = $row['url'];
        $menu[$row['id']]->enabled = $row['enabled'];
        $menu[$row['id']]->SEO = $row['SEO'];
        $menu[$row['id']]->children = [];
        if ($menu[$row['id']]->childrenCount) {
            $sql = "SELECT \"id\",\"parent\",\"order_in_level\",
        (SELECT count(0) FROM cms_pages pp2 WHERE pp.id = pp2.parent) AS childrenCount,
        \"page_id\",\"url\", \"enabled\", \"SEO\"
          FROM \"cms_pages\" pp
        WHERE pp.enabled = 1 AND pp.parent = :id
        ORDER BY pp.order_in_level
        ";
            $rows =
              Yii::app()->db->cache(YII_DEBUG ? 0 : 600)->createCommand($sql)->queryAll(
                true,
                [':id' => $menu[$row['id']]->id]
              );
            if ($rows) {
                foreach ($rows as $row2) {
                    $menu[$row['id']]->children[$row2['id']] = new stdClass();
                    $menu[$row['id']]->children[$row2['id']]->id = $row2['id'];
                    $menu[$row['id']]->children[$row2['id']]->parent = $row2['parent'];
                    $menu[$row['id']]->children[$row2['id']]->order_in_level = $row2['order_in_level'];
                    $menu[$row['id']]->children[$row2['id']]->childrenCount = $row2['childrenCount'];
                    $menu[$row['id']]->children[$row2['id']]->page_id = $row2['page_id'];
                    $menu[$row['id']]->children[$row2['id']]->url = $row2['url'];
                    $menu[$row['id']]->children[$row2['id']]->enabled = $row2['enabled'];
                    $menu[$row['id']]->children[$row2['id']]->SEO = $row2['SEO'];
                }
            }
        }

    }
}
?>

<script>
    $(function () {
        $('#help-accordion').dcAccordion({
            classParent: 'dcjq-parent',
            classActive: 'active',
            classArrow: 'ui-icon ui-icon-grip-diagonal-se',
            classCount: 'dcjq-count',
            classExpand: 'dcjq-current-parent',
            classDisable: '',
            eventType: 'hover',
            hoverDelay: 300,
            menuClose: false,
            autoClose: true,
            autoExpand: false,
            speed: 'fast',
            saveState: true,
            disableLink: false,
            showCount: false,
            cookie: 'help-vertical-menu'
        });
    });
</script>
<div class="block" id="help-block">
  <div class="heading">
    <div class="page-title site_main_color"><?= Yii::t('main', 'Помощь') ?></div>
  </div>
  <hr class="dashed"/>
  <div class="block-content">
      <? if ($menu && count($menu)) { ?>
        <ul class="accordion" id="help-accordion">
            <? foreach ($menu as $item) { ?>
              <li><?= cms::pageLink($item->page_id) ?>
                  <? if (count($item->children)) { ?>
                    <ul>
                        <? foreach ($item->children as $item2) {
                            ?>
                          <li><?= cms::pageLink($item2->page_id) ?></li>
                        <? } ?>
                    </ul>
                  <? } ?>
              </li>
            <? } ?>
        </ul>
      <? } ?>
  </div>
</div>