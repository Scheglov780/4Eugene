<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="error.php">
 * </description>
 * Рендеринг сообщения об ошибке
 **********************************************************************************************************************/
?>
<? Yii::app()->clientScript->registerMetaTag('noindex', 'robots'); ?>
<section class="errorPage">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 col-xs-12 text-center noPadding">
        <div class="errorIn">
          <h1><?
              if (is_array($error)) {
                  if (isset($error['code']) && $error['code']) {
                      echo $error['code'];
                  } elseif (isset($error['statusCode']) && $error['statusCode']) {
                      echo $error['statusCode'];
                  } else {
                      echo 'unknown';
                  }
              } else {
                  if (isset($error->code) && $error->code) {
                      echo $error->code;
                  } elseif (isset($error->statusCode) && $error->statusCode) {
                      echo $error->statusCode;
                  } else {
                      echo 'unknown';
                  }
              }
              ?></h1>
          <h2><?= Yii::t('main', 'ОШИБКА') ?></h2>
          <p>
              <?
              /*
              code - the HTTP status code (e.g. 403, 500)
              type - the error type (e.g. 'CHttpException', 'PHP Error')
              message - the error message
              file - the name of the PHP script file where the error occurs
              line - the line number of the code where the error occurs
              trace - the call stack of the error
              source - the context source code where the error occurs
              */
              $mess = 'unknown';
              if (is_array($error) && isset($error['message'])) {
                  $mess = $error['message'];
              } else {
                  $mess = @$error->getMessage();
              }
              if (is_object($error)) {
                  echo '<br /><div class="alert alert-danger"> Error: ' . CHtml::encode(
                      $mess
                    ) . ' (' . get_class($error) . ')</div>';
              } else {
                  echo '<br /><div class="alert alert-danger">Error: ' . CHtml::encode($mess) . '</div>';
              }
              ?>
          </p>
        </div>
      </div>
    </div>
      <? if (Yii::app()->user->id && YII_DEBUG && isset($error['traces'])) { ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="errorIn">
                    <pre>
                    <?
                    $errorLog = CVarDumper::dumpAsString($error['traces'], 10, true);
                    echo $errorLog;
                    ?>
                    </pre>
            </div>
          </div>
        </div>
      <? } ?>
  </div>
</section>