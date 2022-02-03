<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="СrowdsrcController.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

class customCrowdsrcController extends CustomFrontController
{
    public function actionIndex()
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Краудсорсинг');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $client = new SoapClient('https://dsproxy2.danvit.ru/dsapi/wsdl');
        $result = $client->getSegmentWords(Utils::appLang());
        $render =
          '<h3 class="box-heading"><span>' .
          Yii::t('main', 'Сделайте переводы лучше - внесите свой вклад!') .
          '</span></h3>';
        $render = $render . '<table class="table table-striped tbl-crowdsrc">';
        if ($result && is_array($result)) {
            $i = 0;
            foreach ($result as $res) {
                $translation = Yii::app()->DVTranslator->translateText(
                  $res,
                  'zh',
                  Utils::appLang(),
                  'top10000',
                  true,
                  false,
                  true
                );
                $render =
                  $render .
                  "\r\n<tr><td>" .
                  $res .
                  '</td><td><input id="radio' .
                  $i .
                  '" type="radio" name="group1" value="' .
                  $i .
                  '"><label for="radio' .
                  $i .
                  '">' .
                  $translation .
                  '</label></td></tr>';
                $i++;
            }
        }
        $render = $render . '</table>';
        ?>

        <?
        $this->render('webroot.themes.' . $this->frontTheme . '.views.cabinet.crowdsrc', ['render' => $render]);
    }

    public function filters()
    {
        return array_merge(
          [
            'Rights', // perform access control for CRUD operations
          ],
          parent::filters()
        );
    }
}