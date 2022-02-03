<?php // Issue #574: multiselect without form should send all selected elements
$this->widget(
  'bootstrap.widgets.TbSelect2',
  [
    'name'        => 'group_id_list',
    'data'        => [
      'RU' => 'Russian Federation',
      'CA' => 'Canada',
      'US' => 'United States of America',
      'GB' => 'Great Britain',
    ],
    'htmlOptions' => [
      'multiple' => 'multiple',
      'id'       => 'issue-574-checker-select',
    ],
  ]
);
echo CHtml::endForm();
$this->widget(
  'bootstrap.widgets.TbButton',
  [
    'label'       => 'Click on me with Developer Tools opened!',
    'htmlOptions' => [
      'onclick' => 'js:$.ajax({
                url: "/",
                type: "POST",
                data: (function () {
                    var select = $("#issue-574-checker-select");
                    var result = {};
                    result[select.attr("name")] = select.val();
                    return result;
                })() // have to use self-evaluating function here
            });',
    ],
  ]
);
