<?php if ($model !== null) { ?>
  <table border="1">

    <tr>
      <th width="80px">
        devices_id
      </th>
      <th width="80px">
        source
      </th>
      <th width="80px">
        name
      </th>
      <th width="80px">
        device_serial_number
      </th>
      <th width="80px">
        active
      </th>
      <th width="80px">
        properties
      </th>
      <th width="80px">
        model_id
      </th>
      <th width="80px">
        device_type_id
      </th>
      <th width="80px">
        device_group_id
      </th>
      <th width="80px">
        report_period_update
      </th>
      <th width="80px">
        desc
      </th>
      <th width="80px">
        created_at
      </th>
      <th width="80px">
        updated_at
      </th>
      <th width="80px">
        deleted_at
      </th>
      <th width="80px">
        starting_value1
      </th>
      <th width="80px">
        starting_value2
      </th>
      <th width="80px">
        starting_value3
      </th>
      <th width="80px">
        starting_balance
      </th>
      <th width="80px">
        starting_date
      </th>
      <th width="80px">
        device_usage_id
      </th>
      <th width="80px">
        device_status_id
      </th>
    </tr>
      <?php foreach ($model as $row) {
          if (empty($row)) {
              continue;
          }
          ?>
        <tr>
          <td>
              <?php echo $row->devices_id ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->source ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->name ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->device_serial_number ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->active ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->properties ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->model_id ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->device_type_id ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->device_group_id ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->report_period_update ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->desc ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->created_at ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->updated_at ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->deleted_at ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->starting_value1 ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->starting_value2 ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->starting_value3 ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->starting_balance ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->starting_date ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->device_usage_id ?? '-'; ?>
          </td>
          <td>
              <?php echo $row->device_status_id ?? '-'; ?>
          </td>
        </tr>
      <?php } ?>
  </table>
<?php } ?>
