<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="error.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div class="page-title">

    <?= Yii::t('main', 'Ошибка') ?><?php echo $error->code; ?>

</div>

<div class="error">
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
    //print_r($error);
    echo 'Error: ' . $error['type'] . ': ' . CHtml::encode($error['message']);
    echo '<br/>';
    echo $error['source'];
    echo '<br/>';
    echo $error['file'] . ': ' . $error['line'];
    echo '<br/>';
    echo $error['trace'];
    ?>
</div>