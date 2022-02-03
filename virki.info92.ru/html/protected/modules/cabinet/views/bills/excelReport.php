<?php if ($model !== null) { ?>
  <table border="1">

    <tr>
      <th width="80px">
        Номер счёта
      </th>
      <th width="80px">
        ID счёта
      </th>
      <th width="80px">
        Дата
      </th>
      <th width="80px">
        Участок
      </th>
      <th width="80px">
        Плательщик
      </th>
      <th width="80px">
        Назначение платежа
      </th>
      <th width="80px">
        Сумма
      </th>
      <th width="80px">
        Оплачено
      </th>
      <th width="80px">
        Статус
      </th>
      <th width="80px">
        Заблокирован
      </th>
    </tr>
      <?php foreach ($model as $row) { ?>
        <tr>
          <td>
              <?php echo $row->id; ?>
          </td>
          <td>
              <?php echo $row->code; ?>
          </td>
          <td>
              <?php echo Utils::pgDateToStr($row->date, 'Y-m-d'); ?>
          </td>
          <td>
              <?php echo $row->land_name; ?>
          </td>
          <td>
              <?php echo $row->user_name; ?>
          </td>
          <td>
              <?php echo $row->tariff_name; ?>
          </td>
          <td>
              <?php if (is_null($row->manual_summ)) {
                  echo $row->summ;
              } else {
                  echo $row->manual_summ;
              } ?>
          </td>
          <td>
              <?php echo $row->paid_summ; ?>
          </td>
          <td>
              <?php if ($row->ext_status_name) {
                  $extstatus = " (" . $row->ext_status_name . ")";
              } else {
                  $extstatus = "";
              }
              echo Yii::t('main', $row->status_name) . Yii::t('main', $extstatus); ?>
          </td>
          <td>
              <?php echo($row->frozen ? 'Да' : ''); ?>
          </td>
        </tr>
      <?php } ?>
  </table>
<?php } ?>
