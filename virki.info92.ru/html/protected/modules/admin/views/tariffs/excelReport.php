<?php if ($model !== null) { ?>
  <table border="1">

    <tr>
      <th width="80px">
        tariffs_id
      </th>
      <th width="80px">
        tariff_name
      </th>
      <th width="80px">
        tariff_short_name
      </th>
      <th width="80px">
        tariff_description
      </th>
      <th width="80px">
        tariff_rules
      </th>
      <th width="80px">
        created
      </th>
      <th width="80px">
        comments
      </th>
      <th width="80px">
        enabled
      </th>
      <th width="80px">
        acceptor_id
      </th>
    </tr>
      <?php foreach ($model as $row) { ?>
        <tr>
          <td>
              <?php echo $row->tariffs_id; ?>
          </td>
          <td>
              <?php echo $row->tariff_name; ?>
          </td>
          <td>
              <?php echo $row->tariff_short_name; ?>
          </td>
          <td>
              <?php echo $row->tariff_description; ?>
          </td>
          <td>
              <?php echo $row->tariff_rules; ?>
          </td>
          <td>
              <?php echo $row->created; ?>
          </td>
          <td>
              <?php echo $row->comments; ?>
          </td>
          <td>
              <?php echo $row->enabled; ?>
          </td>
          <td>
              <?php echo $row->acceptor_id; ?>
          </td>
        </tr>
      <?php } ?>
  </table>
<?php } ?>
