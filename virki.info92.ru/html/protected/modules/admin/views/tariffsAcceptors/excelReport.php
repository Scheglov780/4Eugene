<?php if ($model !== null) { ?>
  <table border="1">

    <tr>
      <th width="80px">
        tariff_acceptors_id
      </th>
      <th width="80px">
        name
      </th>
      <th width="80px">
        address
      </th>
      <th width="80px">
        OGRN
      </th>
      <th width="80px">
        INN
      </th>
      <th width="80px">
        KPPacceptor
      </th>
      <th width="80px">
        schet
      </th>
      <th width="80px">
        valuta
      </th>
      <th width="80px">
        bank
      </th>
      <th width="80px">
        KPPbank
      </th>
      <th width="80px">
        BIK
      </th>
      <th width="80px">
        korrSchet
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
    </tr>
      <?php foreach ($model as $row) { ?>
        <tr>
          <td>
              <?php echo $row->tariff_acceptors_id; ?>
          </td>
          <td>
              <?php echo $row->name; ?>
          </td>
          <td>
              <?php echo $row->address; ?>
          </td>
          <td>
              <?php echo $row->OGRN; ?>
          </td>
          <td>
              <?php echo $row->INN; ?>
          </td>
          <td>
              <?php echo $row->KPPacceptor; ?>
          </td>
          <td>
              <?php echo $row->schet; ?>
          </td>
          <td>
              <?php echo $row->valuta; ?>
          </td>
          <td>
              <?php echo $row->bank; ?>
          </td>
          <td>
              <?php echo $row->KPPbank; ?>
          </td>
          <td>
              <?php echo $row->BIK; ?>
          </td>
          <td>
              <?php echo $row->korrSchet; ?>
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
        </tr>
      <?php } ?>
  </table>
<?php } ?>
