<?php if ($model !== null) { ?>
  <table border="1">

    <tr>
      <th width="80px">
        votings_id
      </th>
      <th width="80px">
        votings_type
      </th>
      <th width="80px">
        votings_header
      </th>
      <th width="80px">
        votings_query
      </th>
      <th width="80px">
        votings_variants
      </th>
      <th width="80px">
        votings_summary
      </th>
      <th width="80px">
        votings_author
      </th>
      <th width="80px">
        date_actual_start
      </th>
      <th width="80px">
        date_actual_end
      </th>
      <th width="80px">
        recipients
      </th>
      <th width="80px">
        created
      </th>
      <th width="80px">
        enabled
      </th>
      <th width="80px">
        comments
      </th>
    </tr>
      <?php foreach ($model as $row) { ?>
        <tr>
          <td>
              <?php echo $row->votings_id; ?>
          </td>
          <td>
              <?php echo $row->votings_type; ?>
          </td>
          <td>
              <?php echo $row->votings_header; ?>
          </td>
          <td>
              <?php echo $row->votings_query; ?>
          </td>
          <td>
              <?php echo $row->votings_variants; ?>
          </td>
          <td>
              <?php echo $row->votings_summary; ?>
          </td>
          <td>
              <?php echo $row->votings_author; ?>
          </td>
          <td>
              <?php echo $row->date_actual_start; ?>
          </td>
          <td>
              <?php echo $row->date_actual_end; ?>
          </td>
          <td>
              <?php echo $row->recipients; ?>
          </td>
          <td>
              <?php echo $row->created; ?>
          </td>
          <td>
              <?php echo $row->enabled; ?>
          </td>
          <td>
              <?php echo $row->comments; ?>
          </td>
        </tr>
      <?php } ?>
  </table>
<?php } ?>
