<?php if ($model !== null): ?>
  <table border="1">

    <tr>
      <th width="80px">
        val_id
      </th>
      <th width="80px">
        val_group
      </th>
      <th width="80px">
        val_name
      </th>
      <th width="80px">
        val_description
      </th>
    </tr>
      <?php foreach ($model as $row): ?>
        <tr>
          <td>
              <?php echo $row->val_id; ?>
          </td>
          <td>
              <?php echo $row->val_group; ?>
          </td>
          <td>
              <?php echo $row->val_name; ?>
          </td>
          <td>
              <?php echo $row->val_description; ?>
          </td>
        </tr>
      <?php endforeach; ?>
  </table>
<?php endif; ?>
