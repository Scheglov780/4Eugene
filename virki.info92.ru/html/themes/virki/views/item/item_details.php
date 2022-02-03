<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="item_details.php">
 * </description>
 * Рендеринг описания товара
 **********************************************************************************************************************/
?>
<? if (DSConfig::getVal('item_description_show_as_html')) { ?>
    <?
    $src = preg_replace('/(^.*?\s*var\s+desc\s*=\s*\')|(\'\s*;\s*.*$)/isu', '', $src);
    $src = preg_replace('/^[^<]+>/isu', '', $src);
    $src = preg_replace("/\\\\$/sm", ' ', $src);
    if (extension_loaded('tidy')) {
        $config = [
          'clean'          => 'yes',
          'output-html'    => 'yes',
          'show-body-only' => true,
          'merge-divs'     => true,
          'merge-spans'    => true,
        ];
        $tidy = @tidy_parse_string($src, $config, 'utf8');
        if (isset($tidy) && $tidy) {
            $tidy->cleanRepair();
            if (isset($tidy->value) && $tidy->value) {
                $src = $tidy->value;
            }
        }
        unset($tidy);
    }
    $src = preg_replace("/href\s*=\s*[\"'].*?[\"']/is", 'href="javascript:void(0)"', $src);
    $src = preg_replace("/[\"']_blank[\"']/i", '"_self"', $src);
    echo $src;
    ?>
  <script>
      $(document).ready(function () {
          try {
              if (typeof deferredTranslateDescr != 'undefined') {
                  deferredTranslateDescr.resolve(true);
              }
          } catch (error) {
              console.log('No Bing translation deffered enabled');
          }
      });
  </script>
<? } else { ?>
    <? $res = preg_match_all(
      '/<\s*img\s+.*?\ssrc\s*=\s*"(http[s]*:\/\/[a-z0-9]+?\.(?:taobaocdn|alicdn).+?)"/isu',
      $src,
      $descImgs
    );
    if ($res) {
        ?>
      <ul style="width: 900px;">
          <? foreach ($descImgs[1] as $descImg) { ?>
            <li style="width: 450px; float:left;"><img style="width:450px; margin:-1px;"
                                                       src="<?= Img::getImagePath(
                                                         $descImg,
                                                         '_360x360.jpg',
                                                         false
                                                       ); ?>"
                                                       alt=""></li>
          <? } ?>
      </ul>
    <? } ?>
<? } ?>
