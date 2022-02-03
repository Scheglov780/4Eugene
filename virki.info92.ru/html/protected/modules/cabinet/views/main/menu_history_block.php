<?php $this->widget(
  'booster.widgets.TbGridView',
  [
    'id'           => 'admin-tabs-history-grid',
    'dataProvider' => ModuleTabsHistory::getHistory(),
    'type'         => 'condensed', //striped bordered condensed
    'template'     => '{items}',//'{summary}{pager}{items}{pager}',
    'hideHeader'   => true,
    'htmlOptions'  => ['class' => 'grid-view-history'],
    'columns'      => [
      [
        'name'  => 'name',
        'type'  => 'raw',
        'value' => function ($data) {
            //$result = CHtml::link($data->name, array($data->href), array("title"=>$data->title,"onclick"=>"getContent(this,\"$data->name\",false);return false;"));
            if (preg_match('/\/(?:update|view)(?:\/|$)/iu', $data->href)) {
                $color = 'red';
            } elseif (preg_match('/\/(?:index)(?:\/|$)/iu', $data->href)) {
                $color = 'yellow';
            } else {
                $color = 'aqua';
            }
            if (preg_match('/<.+>/iu', $data->name)) {
                $iClass = '';
            } else {
                $iClass = "<i class=\"fa fa-circle-o text-{$color}\"></i> ";
            }

            $result = "<li><a href=\"{$data->href}\" title=\"{$data->title}\"
                       onclick='getContent(this,\"" . addslashes(
                $data->name
              ) . "\",false,true,false);return false;'>{$iClass}{$data->name}</a></li>";
            return $result;
            ?>
            <?
        },
      ],
    ],
  ]
);
?>