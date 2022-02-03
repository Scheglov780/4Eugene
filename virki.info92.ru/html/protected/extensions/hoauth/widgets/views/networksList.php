<?php
/**
 * @var $sns array of array('provider' => $network->provider, 'profileUrl' => $network->profile->profileURL,
 *      'deleteUrl' => $deleteUrl)
 */
?>
<ul class="hoauthSNList">
    <?php
    foreach ($sns as $sn) {
        [$provider, $profileUrl, $deleteUrl] = array_values($sn);
        echo '<li>' .
          CHtml::link($provider, $profileUrl, ['target' => '_blank']) .
          ' ' .
          CHtml::ajaxLink('(' . HOAuthAction::t('Remove') . ')', $deleteUrl, [
            'type'       => 'post',
            'context'    => 'js:this',
            'beforeSend' => "js:function() {return confirm('" .
              HOAuthAction::t(
                'If you remove this social network account, you will you will not be able to login with it.\\n\\nDo you realy want to remove this account?'
              ) .
              "');}",
            'success'    => 'js:function() {$(this).parent().remove();}',
          ], ['class' => "hoauthSNUnbind"]) .
          '</li>';
    }
    ?>
</ul>
