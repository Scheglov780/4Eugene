<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="excelReport.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php if ($model !== null): ?>
  <table border="1">

    <tr>
      <th width="80px">
        uid
      </th>
      <th width="160px">
        fullname
      </th>
      <th width="80px">
        email
      </th>
      <th width="80px">
        status
      </th>
      <th width="80px">
        created
      </th>
      <th width="80px">
        role
      </th>
      <th width="80px">
        phone
      </th>
    </tr>
      <?php foreach ($model as $row): ?>
        <tr>
          <td>
              <?php echo $row->uid; ?>
          </td>
          <td>
              <?php echo $row->fullname; ?>
          </td>
          <td>
              <?php echo $row->email; ?>
          </td>
          <td>
              <?php echo $row->status; ?>
          </td>
          <td>
              <?php echo $row->created; ?>
          </td>
          <td>
              <?php echo $row->role; ?>
          </td>
          <td>
              <?php echo $row->phone; ?>
          </td>
        </tr>
      <?php endforeach; ?>
  </table>
<?php endif; ?>
