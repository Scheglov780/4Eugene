<?php
$cnt = count($levs['lev']);
foreach ($levs['lev'] as $ls) :
    $lvl = $ls['level'];
    ?>

  <div class="any_level">
      <?php echo CHtml::dropDownList(
        'level_' . $lvl,
        $ls['sel'],
        $ls['opt'],
        [
          'class' => 'span10 catalog',
        ]
      ); ?>

    <div class="ajax cat_<?php echo $lvl; ?>"></div>
    <div class="arrows arup" <?php
    if (($cnt > $lvl) || ($lvl == 1)) {
        echo ' style="display: none;" ';
    }
    ?>><a href="#" class="totop"></a>
    </div>
    <div class="arrows ardn" <?php
      if ($cnt > $lvl) {
          echo ' style="display: none;" ';
      }
      ?>"><a href="#" class="tobot"></a>
  </div>
  <div class="clear"></div>
  </div>
<?php endforeach; ?>

