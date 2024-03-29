<?php
/**
 * HConnectedNetworks shows the list with networks, that user connected to
 * @uses      CWidget
 * @version   1.2.5
 * @copyright Copyright &copy; 2013 Sviatoslav Danylenko
 * @author    Sviatoslav Danylenko <dev@udf.su>
 * @license   MIT ({@link http://opensource.org/licenses/MIT})
 * @link      https://github.com/SleepWalker/hoauth
 */

class HConnectedNetworks extends CWidget
{
    public $tag = 'ul';

    public function run()
    {
        require_once(dirname(__FILE__) . '/../models/UserOAuth.php');
        require_once(dirname(__FILE__) . '/../HOAuthAction.php');

        // provider delete action
        if (Yii::app()->request->isPostRequest && isset($_GET['hoauthDelSN'])) {
            ob_clean();
            ob_clean();
            $userNetwork = UserOAuth::model()->findUser(Yii::app()->user->id, $_GET['hoauthDelSN']);
            if ($userNetwork) {
                $userNetwork->delete();
            }
            Yii::app()->end();
        }

        $userNetworks = UserOAuth::model()->findUser(Yii::app()->user->id);
        $sns = [];

        foreach ($userNetworks as $network) {
            $deleteUrl = '?hoauthDelSN=' . $network->provider;
            try {
                array_push($sns,
                  [
                    'provider' => $network->provider,
                    'profileUrl' => $network->profileCache->profileURL,
                    'deleteUrl' => $deleteUrl,
                  ]
                );
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        $this->render('networksList', [
          'sns' => $sns,
        ]);
    }
}
