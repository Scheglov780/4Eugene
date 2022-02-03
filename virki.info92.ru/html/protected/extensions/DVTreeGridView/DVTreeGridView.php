<?php

/**
 *   Updated options can be found at:
 *   http://ludo.cubicphuse.nl/jquery-treetable/#configuration
 *   Those  were the option at 2014-09-02
 *   branchAttr          string  "ttBranch"              Optional data attribute that can be used to force the expander
 *   icon to be rendered on a node. This allows us to define a node as a branch node even though it does not have
 *   children yet. This translates to a data-tt-branch attribute in your HTML. clickableNodeNames  bool    false
 *              Set to true to expand branches not only when expander icon is clicked but also when node name is
 *              clicked. column              int     0                       The number of the column in the table that
 *              should be displayed as a tree. columnElType        string  "td"                    The types of cells
 *              that should be considered for the tree (td, th or both). expandable          bool    false
 *                   Should the tree be expandable? An expandable tree contains buttons to make each branch with
 *                   children collapsible/expandable. expanderTemplate    string  <a href="#">&nbsp;</a>  The HTML
 *                   fragment used for the expander. indent              int     19                      The number of
 *                   pixels that each branch should be indented with. indenterTemplate    string  <span
 *                   class="indenter"></span>  The HTML fragment used for the indenter. initialState        string
 *                   "collapsed"             Possible values: "expanded" or
 *                   "collapsed". nodeIdAttr          string  "ttId"                  Name of the data attribute used
 *                   to identify node. Translates to data-tt-id in your HTML. parentIdAttr        string  "ttParentId"
 *                             Name of the data attribute used to set parent node. Translates to data-tt-parent-id in
 *                             your HTML. stringCollapse      string  "Collapse" For internationalization. stringExpand
 *                                    string  "Expand"                For internationalization.
 */
//Yii::import('zii.widgets.grid.CGridView');
Yii::import('booster.widgets.TbGridView');

class DVTreeGridView extends TbGridView
{
    private $currentDepth = 0;
    private $dataIsArray = false;
    private $extensionBaseUrl;
    public $childClass = 'child-tree';
    public $childrenCountColumn = 'children';
    public $customCssFile;
    public $draggabeClass = 'tree-draggable';
    public $idColumn = 'id';
    public $initialDepth = 10; // Attribute that points to the parent
    public $isPartialRendering = false;
    public $lazyMode = false; // Class added do each <tr> that is a parent (only roots)
    public $lazyNodeUrl = ''; // Class added to each <tr> that is a child
    public $parentClass = 'parent-tree';
    public $parentColumn = 'parent_id';
    public $rootId = 1;
    public $setParentUrl = '';
    public $treeViewOptions = [];

    private function customCompare($nodeA, $nodeB)
    {
        return (
          $this->dataIsArray ? $nodeA[$this->idColumn] : $nodeA->{$this->idColumn}
          ) - ($this->dataIsArray ? $nodeB[$this->idColumn] : $nodeB->{$this->idColumn});
    }

    private function orderData($remainingNodes, $orderedData = [])
    {
        if (count($orderedData) == 0) {
            $this->currentDepth = 1;
            // add the roots
            foreach ($remainingNodes as $node) {
                if (($this->dataIsArray ? $node[$this->parentColumn] : $node->{$this->parentColumn}) == $this->rootId) {
                    $orderedData[] = $node;
                } else {
                    // Потому как у нас всё отсортировано в SQL по rootId и потом по parent_id
                    break;
                }
            }
            if (count($orderedData) == 0) {
                return $orderedData;
            }
        } else {
            $oldOrderedData = $orderedData;
            $this->currentDepth++;
            foreach ($remainingNodes as $node) {
                // look for the parent
                foreach ($orderedData as $i => $insertedNode) {
                    if (
                      ($this->dataIsArray ? $insertedNode[$this->idColumn] : $insertedNode->{$this->idColumn})
                      == ($this->dataIsArray ? $node[$this->parentColumn] : $node->{$this->parentColumn})
                      && in_array($insertedNode, $oldOrderedData)
                    ) {
                        // parent is in position $i
                        $positionToInsert = null;
                        $j = $i + 1;
                        while ($j < count($orderedData) && $positionToInsert == null) {
                            $orderedNode = $orderedData[$j];
                            // if the parent is the same, proceed
                            if (($this->dataIsArray ? $orderedNode[$this->parentColumn] :
                                $orderedNode->{$this->parentColumn})
                              == ($this->dataIsArray ? $node[$this->parentColumn] : $node->{$this->parentColumn})
                            ) {
                                $j++;
                            } else {
                                $positionToInsert = $j;
                            }
                        }

                        if ($positionToInsert != null) {
                            array_splice($orderedData, $positionToInsert, 0, [$node]);
                            break;
                        } else {
                            $orderedData[] = $node;
                            break;
                        }
                    }
                }
            }
        }
        $remainingNodes = array_udiff(
          $remainingNodes,
          $orderedData,
          [$this, 'customCompare']
        );

        if ($remainingNodes != null && $this->currentDepth < $this->initialDepth) {
            return $this->orderData($remainingNodes, $orderedData);
        } else {
            return $orderedData;
        }
    }

    public function init()
    {
        parent::init();
        $this->lazyMode = ($this->lazyMode ? 'true' : 'false');
        // parent must be followed by their children, so, order the dataProvider
        $start = microtime(true);
        $data = $this->dataProvider->getData();
        $time = microtime(true) - $start;
        if ($data && is_array($data)) { // && isset($data[0])
            $this->dataIsArray = is_array($data);
        }
        $start = microtime(true);
        $newData = $this->orderData($data);
        $time = microtime(true) - $start;
        $this->dataProvider->setData($newData);
    }

    public function registerClientScript()
    {
        parent::registerClientScript();

        if ($this->extensionBaseUrl == null) {
            $this->extensionBaseUrl = Yii::app()->getAssetManager()->publish(
              Yii::getPathOfAlias('ext.DVTreeGridView')
            );
        }

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile(
          $this->extensionBaseUrl . '/js/jquery.treeTable' . (YII_DEBUG ? '' : '.min') . '.js',
          CClientScript::POS_END
        );

        if ($this->customCssFile == null) {
            $cs->registerCssFile(
              $this->extensionBaseUrl . '/css/jquery.treetable' . (YII_DEBUG ? '' : '.min') . '.css'
            );
            $cs->registerCssFile(
              $this->extensionBaseUrl . '/css/jquery.treetable.theme.default' . (YII_DEBUG ? '' : '.min') . '.css'
            );
        } else {
            $cs->registerCssFile($this->customCssFile);
        }

        $options = CJavaScript::encode($this->treeViewOptions);
        $dndConfirmMessage = Yii::t('admin', 'Перенести запись?');
        $cs->registerScript(
          'treeTable',
          /** @lang JavaScript */
          "$(document).ready(function()
  {
    var table = $('#{$this->getId()} .items'); 
    var options = {$options};
    var settings = options;
   /* 
    function droppableSetup() {
    try {
      $(this).droppable({
        accept: '.{$this->draggabeClass}',
        drop: function(e, ui) {
        if(!confirm('{$dndConfirmMessage}'))
          return;
          var droppedEl, node;
          droppedEl = ui.draggable.parents('tr');
          node = $('#{$this->getId()} .items').treetable('node', droppedEl.data('ttId'));
          var newParentId = $(this).data('ttId');
          // Update server-side tree
          var data='parent='+newParentId;//node.parentId;
        jQuery.ajax({
            type: 'POST',
            async: false,
            url: '{$this->setParentUrl}/id/' + node.id,
            data:data,
            success:function(data){
               $('#{$this->getId()} .items').treetable('move', node.id, newParentId);
            },
            error: function(data) { // if error occured
              alert('Error occured, please try again');
            },
           dataType:'json'
        });
        },
        hoverClass: 'accept',
        over: function(e, ui) {
          var droppedEl = ui.draggable.parents('tr');
          if(this != droppedEl[0] && !$(this).is('.expanded')) {
            $('#{$this->getId()} .items').treetable('expandNode', $(this).data('ttId'));
          }
        }
      });
      } catch (err) {

      }
    }

    var lazyMode = {$this->lazyMode};
    if (lazyMode) {
    var settings = $.extend({
  onNodeCollapse: function() {
        var node = this;
        if (!node.parentId) {
        table.treetable('unloadBranch', node);
        }
      },

onNodeExpand: function() {
        var node = this;
        if (!node.parentId) {
        // Render loader/spinner while loading
        $.ajax({
          async: false, // Must be false, otherwise loadBranch happens after showChildren?
          url: '{$this->lazyNodeUrl}'+'/id/' + node.id
        }).done(function(html) {
          var rows = $(html).filter('tr');

          rows.find('.{$this->draggabeClass}').parents('tr').each(function() {
            droppableSetup.apply(this);
          })

          table.treetable('loadBranch', node, rows);
        });
        }
      }
},options);
}
*/
    table.treetable(settings);

    // Highlight selected row
    /*
    $(document).on('mousedown', '#{$this->getId()} .items tbody tr', function() {
      $('tr.selected').removeClass('selected');
      $(this).addClass('selected');
    });
    */ 
    // Drag & Drop Example Code
    /*
    $(document).on('mouseenter', '#{$this->getId()} .items .{$this->draggabeClass}', function() {
      var el = $(this);

      if(!el.data('dndInit')) {
        el.data('dndInit', true);
        el.draggable({
          helper: 'clone',
          opacity: .75,
          refreshPositions: true, // Performance?
          revert: 'invalid',
          revertDuration: 300,
          scroll: true
        });
      }
    });

    $('#{$this->getId()} .items .{$this->draggabeClass}').parents('tr').each(function() {
      droppableSetup.apply(this);
    });
     */
 });"
        );
    }

    public function renderTableRow($rowIndex)
    {
        $model = $this->dataProvider->data[$rowIndex];
        // data-tt-id must be unique
        $row = '<tr data-tt-id="' . ($this->dataIsArray ? $model[$this->idColumn] : $model->{$this->idColumn}) . '"';
        if ($this->lazyMode) {
            $row .= ' data-tt-branch="' .
              (($this->dataIsArray ? $model[$this->childrenCountColumn] : $model->{$this->childrenCountColumn}) ?
                'true' : 'false') .
              '"';
        }
        /*
                if ((($this->dataIsArray ? $model[$this->parentColumn] : $model->{$this->parentColumn}) != $this->rootId) && $this->isPartialRendering) {
                    $row .= ' style="display:none"';
                }
        */
        if ((($this->dataIsArray ? $model[$this->parentColumn] : $model->{$this->parentColumn}) != $this->rootId) ||
          $this->isPartialRendering) {
            // data-tt-parent-id indicates the parent
            $row .= ' data-tt-parent-id="' .
              ($this->dataIsArray ? $model[$this->parentColumn] : $model->{$this->parentColumn}) .
              '"';

            // add child class and class attribute remains open
            $row .= ' class="' . $this->childClass;
        } else {
            // add parent class and class attribute remains open
            $row .= ' class="' . $this->parentClass;
        }

        // check if there are more classes to be add
        if ($this->rowCssClassExpression !== null) {
            $row .= ' ' . $this->evaluateExpression(
                $this->rowCssClassExpression,
                ['rowIndex' => $rowIndex, 'data' => $model]
              );
        } else {
            if (is_array($this->rowCssClass) && ($n = count($this->rowCssClass)) > 0) {
                $row .= ' ' . $this->parentClass . $this->rowCssClass[$rowIndex % $n];
            }
        }

        // closes class attribute and the tr tag
        $row .= '">';

        echo $row;

        // render columns
        foreach ($this->columns as $column) {
            $column->renderDataCell($rowIndex);
        }

        echo "</tr> \n";
    }
}