<?php if ($model !== null) { ?>
  <table border="1">

    <tr>
      <th width="80px">
        news_id
      </th>
      <th width="80px">
        news_header
      </th>
      <th width="80px">
        news_body
      </th>
      <th width="80px">
        news_author
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
        news_type
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
        confirmation_needed
      </th>
    </tr>
      <?php foreach ($model as $row) { ?>
        <tr>
          <td>
              <?php echo $row->news_id; ?>
          </td>
          <td>
              <?php echo $row->news_header; ?>
          </td>
          <td>
              <?php echo $row->news_body; ?>
          </td>
          <td>
              <?php echo $row->news_author; ?>
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
              <?php echo $row->news_type; ?>
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
              <?php echo $row->confirmation_needed; ?>
          </td>
        </tr>
      <?php } ?>
  </table>
<?php } ?>
