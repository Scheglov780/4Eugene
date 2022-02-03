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
      <? /*
        * lands_id
        * land_group
        * land_number
        * land_number_cadastral
        * address
        * land_area
        * land_geo_latitude
        * land_geo_longitude
        * created
        * status
        * comments
        */ ?>
    <tr>
      <th width="80px">
        lands_id
      </th>
      <th width="80px">
        land_group
      </th>
      <th width="80px">
        land_number
      </th>
      <th width="80px">
        land_number_cadastral
      </th>
      <th width="160px">
        address
      </th>
      <th width="80px">
        land_area
      </th>
      <th width="80px">
        land_geo_latitude
      </th>
      <th width="80px">
        land_geo_longitude
      </th>
      <th width="80px">
        created
      </th>
      <th width="80px">
        status
      </th>
      <th width="180px">
        comments
      </th>
    </tr>
      <?php foreach ($model as $row): ?>
        <tr>
          <td>
              <?php echo $row->lands_id; ?>
          </td>
          <td>
              <?php echo $row->land_group; ?>
          </td>
          <td>
              <?php echo $row->land_number; ?>
          </td>
          <td>
              <?php echo $row->land_number_cadastral; ?>
          </td>
          <td>
              <?php echo $row->address; ?>
          </td>
          <td>
              <?php echo $row->land_area; ?>
          </td>
          <td>
              <?php echo $row->land_geo_latitude; ?>
          </td>
          <td>
              <?php echo $row->land_geo_longitude; ?>
          </td>
          <td>
              <?php echo $row->created; ?>
          </td>
          <td>
              <?php echo $row->status; ?>
          </td>
          <td>
              <?php echo $row->comments; ?>
          </td>
        </tr>
      <?php endforeach; ?>
  </table>
<?php endif; ?>
