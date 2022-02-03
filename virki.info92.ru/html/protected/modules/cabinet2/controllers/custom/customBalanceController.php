<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BalanceController.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

class customBalanceController extends CustomFrontController
{
    /*
      1 Зачисление или возврат средств
      2 Снятие средств
      3 Ожидание зачисления средств
      4 Отмена ожидания зачисления средств
      5 Отправка внутреннего перевода средств
      6 Получение внутреннего перевода средств
      7 Зачисление бонуса или прибыли
      8 Вывод средств из системы
     */

    private $easyPayment = false;

    private function hmac($algo, $data, $passwd)
    {
        /* md5 and sha1 only */
        $algo = strtolower($algo);
        $p = ['md5' => 'H32', 'sha1' => 'H40'];
        if (strlen($passwd) > 64) {
            $passwd = pack($p[$algo], $algo($passwd));
        }
        if (strlen($passwd) < 64) {
            $passwd = str_pad($passwd, 64, chr(0));
        }

        $ipad = substr($passwd, 0, 64) ^ str_repeat(chr(0x36), 64);
        $opad = substr($passwd, 0, 64) ^ str_repeat(chr(0x5C), 64);

        return ($algo($opad . pack($p[$algo], $algo($ipad . $data))));
    }

    private function logActionCall($sender)
    {
        if ($sender) {
            $log = new PaySystemsLog();
            $log->date = date("Y-m-d H:i:s", time());
            $log->from_ip = Yii::app()->request->userHostAddress;
            $log->action = $this->action->id;
            $log->sender = $sender;
            $log->data = serialize($_POST);
            $log->save();
        }
    }

    /** Замена функции iconv()
     * @param        $txt
     * @param string $dir
     * @return mixed
     */
    private function win2utf($txt, $dir = "wu")
    {
        // cp1251
        $in_arr = [
          chr(208),
          chr(192),
          chr(193),
          chr(194),
          chr(195),
          chr(196),
          chr(197),
          chr(168),
          chr(198),
          chr(199),
          chr(200),
          chr(201),
          chr(202),
          chr(203),
          chr(204),
          chr(205),
          chr(206),
          chr(207),
          chr(209),
          chr(210),
          chr(211),
          chr(212),
          chr(213),
          chr(214),
          chr(215),
          chr(216),
          chr(217),
          chr(218),
          chr(219),
          chr(220),
          chr(221),
          chr(222),
          chr(223),
          chr(224),
          chr(225),
          chr(226),
          chr(227),
          chr(228),
          chr(229),
          chr(184),
          chr(230),
          chr(231),
          chr(232),
          chr(233),
          chr(234),
          chr(235),
          chr(236),
          chr(237),
          chr(238),
          chr(239),
          chr(240),
          chr(241),
          chr(242),
          chr(243),
          chr(244),
          chr(245),
          chr(246),
          chr(247),
          chr(248),
          chr(249),
          chr(250),
          chr(251),
          chr(252),
          chr(253),
          chr(254),
          chr(255),
        ];

        // utf-8
        $out_arr = [
          chr(208) . chr(160),
          chr(208) . chr(144),
          chr(208) . chr(145),
          chr(208) . chr(146),
          chr(208) . chr(147),
          chr(208) . chr(148),
          chr(208) . chr(149),
          chr(208) . chr(129),
          chr(208) . chr(150),
          chr(208) . chr(151),
          chr(208) . chr(152),
          chr(208) . chr(153),
          chr(208) . chr(154),
          chr(208) . chr(155),
          chr(208) . chr(156),
          chr(208) . chr(157),
          chr(208) . chr(158),
          chr(208) . chr(159),
          chr(208) . chr(161),
          chr(208) . chr(162),
          chr(208) . chr(163),
          chr(208) . chr(164),
          chr(208) . chr(165),
          chr(208) . chr(166),
          chr(208) . chr(167),
          chr(208) . chr(168),
          chr(208) . chr(169),
          chr(208) . chr(170),
          chr(208) . chr(171),
          chr(208) . chr(172),
          chr(208) . chr(173),
          chr(208) . chr(174),
          chr(208) . chr(175),
          chr(208) . chr(176),
          chr(208) . chr(177),
          chr(208) . chr(178),
          chr(208) . chr(179),
          chr(208) . chr(180),
          chr(208) . chr(181),
          chr(209) . chr(145),
          chr(208) . chr(182),
          chr(208) . chr(183),
          chr(208) . chr(184),
          chr(208) . chr(185),
          chr(208) . chr(186),
          chr(208) . chr(187),
          chr(208) . chr(188),
          chr(208) . chr(189),
          chr(208) . chr(190),
          chr(208) . chr(191),
          chr(209) . chr(128),
          chr(209) . chr(129),
          chr(209) . chr(130),
          chr(209) . chr(131),
          chr(209) . chr(132),
          chr(209) . chr(133),
          chr(209) . chr(134),
          chr(209) . chr(135),
          chr(209) . chr(136),
          chr(209) . chr(137),
          chr(209) . chr(138),
          chr(209) . chr(139),
          chr(209) . chr(140),
          chr(209) . chr(141),
          chr(209) . chr(142),
          chr(209) . chr(143),
        ];

        if ($dir == 'wu') {
            $txt = str_replace($in_arr, $out_arr, $txt);
        } else {
            $txt = str_replace($out_arr, $in_arr, $txt);
        }
        return $txt;
    }

    protected function payApiterminal($data, $type)
    { // API для терминалов
        try {

            header('Content-Type: text/xml', true);

            /** Данные настроек платежной системы из БД ( pay_systems ) * */
            $paySystem = PaySystems::getModelByType($type);
            $parameters = $paySystem['parameters'];
            $PRM = simplexml_load_string($parameters, null, LIBXML_NOCDATA);
            $XML = '<?xml version="1.0" encoding="UTF-8"?>' . '<xml>';

            /** Проверим наличие необходимых данных * */
            if (!isset($data['login_ps']) || !isset($data['password']) || !isset($data['status'])) {
                header('Access denied (no login, password or status)', true, 403);
                Yii::app()->end();
            }
            if (isset($data['account_id'])) {
                $data['account_id'] = ltrim(str_replace('-', '', $data['account_id']), '0');

                if ($data['account_id'] == '') {
                    $data['account_id'] = 0;
                }
            }

            /*             * * Проверяем логин и пароль ** */
            $params = false;
//  проверяем соответствие переданых параметров нашей конфигурации

            foreach ($PRM as $i) {

                $p['login'] = (string) $i->login;
                $p['password'] = (string) $i->password;
                $p['secret_word'] = (string) $i->secret_word;
                if ($p['login'] == $data['login_ps'] && $p['password'] == $data['password']) {
                    $params = $p;
                }
            }

            if ($params == false) {
                if (isset($data['transact_id'])) {
                    $XML .= '<transact_id>' . $data['transact_id'] . '</transact_id>';
                }
// сообщение о несоответствии логина и/или пароля или неверные данные вообще
                $XML .= '<status>' . '1' . '</status>';
                $XML .= '<comment>' . 'Invalid access params' . '</comment>';
                $XML .= '</xml>';

                echo $XML;

                header('Error: invalid params', true, 403);
                Yii::app()->end();
            }

            $def_currency = DSConfig::getSiteCurrency();
            if (isset($data['account_id'])) {
                $def_balans = Users::getBalance($data['account_id']);
            } else {
                $def_balans = 0;
            }

            if ($data['status'] == 0) { // Запрос данных аккаунта
// проверяем хэш
                $control_hash = trim($data['hash']);

                /*

                  $control = sha1($data['login_ps'].$params['password'].$data['status'].$params['secret_word']);
                  echo $control;

                 */

                if ($control_hash == sha1(
                    $data['login_ps'] . $params['password'] . $data['status'] . $params['secret_word']
                  )
                ) {

                    $USR = Yii::app()->db->createCommand(
                      "SELECT uu.email, uu.fullname FROM users uu WHERE uu.uid = :uid"
                    )
                      ->queryRow(true, [':uid' => $data['account_id']]);

                    if (!$USR) {

                        $XML .= '<status>' . '2' . '</status>';
                        if (isset($data['order_id'])) {
                            $XML .= '<order_id>' . $data['order_id'] . '</order_id>';
                        }
                        $XML .= '<comment> USER is notundefined </comment>';
                        $XML .= '</xml>';

                        echo $XML;
                        Yii::app()->end();
                    }

                    $balance = $def_balans;

                    /** получаем валюты курс которых можем посчитать * */
                    $curr = explode(',', DSConfig::getVal('site_currency_block')); // массив доступных валют
                    /*                     * проверим наличие валюты запроса на наличие в системе их курса * */
                    $curr_include = in_array(strtolower($data['currency']), $curr);

                    if ($curr_include == false) { // Нет данных о курсе валюты
                        if (isset($data['transact_id'])) {
                            $XML .= '<transact_id>' . $data['transact_id'] . '</transact_id>';
                        }
                        $XML .= '<status>' . '7' . '</status>';
                        if (isset($data['order_id'])) {
                            $XML .= '<order_id>' . $data['order_id'] . '</order_id>';
                        }
                        $XML .= '</xml>';

                        echo $XML;

                        header('Error: invalid or unsupported currency ' . $data['currency'], true, 403);
                        Yii::app()->end();
                    }

                    if ($def_currency !== strtolower($data['currency'])) {
                        $balance = Formulas::convertCurrency($def_balans, $def_currency, $data['currency']);
                    }

                    /** Запишем запрос в лог * */
                    $payment = new Payment; // Инициализация объекта для работы с оплатами

                    $payment->status = 3;
                    $payment->date = date("Y-m-d H:i:s", time());
                    $payment->description = Yii::t('main', 'Заявка на пополнение через терминал ' . $data['login_ps']);
                    $payment->uid = $data['account_id'];
                    $payment->manager_id = Yii::app()->user->id;
                    if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
                        $payment->oid = $_POST['CabinetForm']['order'];
                    }
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;

                    $order_id = $payment->id; // Олучем ID созданого запроса

                    /** Пердаем данные аккаунты для терминала * */
                    if (isset($data['transact_id'])) {
                        $XML .= '<transact_id>' . $data['transact_id'] . '</transact_id>';
                    }
                    $XML .= '<status>' . '5' . '</status>';
                    $XML .= '<email>' . $USR['email'] . '</email>';
                    $XML .= '<balance>' . $balance . '</balance>';
                    $XML .= '<currency>' . $data['currency'] . '</currency>';
                    $XML .= '<order_id>' . $order_id . '</order_id>';
                    $XML .= '<fullname>' . $USR['fullname'] . '</fullname>';
                    $XML .= '<datatime>' . time() . '</datatime>';
                    $XML .= '</xml>';

                    echo $XML;
                } else { // Не совпадает хэш
                    if (isset($data['transact_id'])) {
                        $XML .= '<transact_id>' . $data['transact_id'] . '</transact_id>';
                    }
                    if (isset($data['order_id'])) {
                        $XML .= '<order_id>' . $data['order_id'] . '</order_id>';
                    }
                    $XML .= '<status>' . '2' . '</status>';
                    $XML .= '</xml>';

                    echo $XML;
                }
            } elseif ($data['status'] == 6) { // Пополнение баланса
                $control_hash = trim($data['hash']);

                /*
                  $control = sha1($data['login_ps'] . $params['password'] .
                  $data['order_id'] . $data['status'] .
                  $data['sum'] . $data['currency'] . $params['secret_word']);
                  echo $control;
                 */
                if ($control_hash == sha1(
                    $data['login_ps'] . $params['password'] .
                    $data['order_id'] . $data['status'] .
                    $data['sum'] . $data['currency'] . $params['secret_word']
                  )
                ) {

                    /** Записываем операцию и пополняем баланс * */
                    $payment = Payment::model()->findByPk($data['order_id']);

                    $pay = $data['sum'];
                    if ($def_currency !== strtolower($data['currency'])) {
                        $pay = Formulas::convertCurrency($data['sum'], $data['currency'], $def_currency);
                    }

                    if ($payment && ($payment->status != 1)) {
                        $payment->status = 1;
                        $payment->description = Yii::t('main', 'Зачисление средств ' . $data['login_ps']);
                        $payment->date = date("Y-m-d H:i:s", time());
                        $payment->sum = $pay;
                        //Yii::app()->db->autoCommit = false;
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            if ($payment->save()) {
                                if ($payment->oid) {
                                    OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                                }
                            }
                        } catch (Exception $e) {
                            if (isset($transaction) && $transaction && $transaction->active) {
                                $transaction->rollback();
                            }
                            //Yii::app()->db->autoCommit = true;
                            Utils::debugLog(CVarDumper::dumpAsString($e));
                        }
                        if ($transaction->active) {
                            $transaction->commit();
                        }
                        //Yii::app()->db->autoCommit = true;
                        /** Отправим уведомление об успешном пополнении баланса * */
                        if (isset($data['transact_id'])) {
                            $XML .= '<transact_id>' . $data['transact_id'] . '</transact_id>';
                        }
                        $XML .= '<status>' . '11' . '</status>';
                        if (isset($data['order_id'])) {
                            $XML .= '<order_id>' . $data['order_id'] . '</order_id>';
                        }
                        $XML .= '<datatime>' . time() . '</datatime>';
                        $XML .= '</xml>';

                        echo $XML;
                    } else {
                        if (isset($data['transact_id'])) {
                            $XML .= '<transact_id>' . $data['transact_id'] . '</transact_id>';
                        }
                        $XML .= '<status>' . '8' . '</status>';
                        if (isset($data['order_id'])) {
                            $XML .= '<order_id>' . $data['order_id'] . '</order_id>';
                        }
                        $XML .= '</xml>';
                        echo $XML;
                    }
                } else { // Не совпадает хэш
                    if (isset($data['transact_id'])) {
                        $XML .= '<transact_id>' . $data['transact_id'] . '</transact_id>';
                    }
                    $XML .= '<status>' . '2' . '</status>';
                    $XML .= '<order_id>' . $data['order_id'] . '</order_id>';
                    $XML .= '</xml>';
                    echo $XML;
                }
            } elseif ($data['status'] == 9) { // Отказ оплаты клиентом
                $payment = Payment::model()->findByPk($data['order_id']);

                if ($payment != false) {

                    $payment->status = 4;
                    $payment->description = Yii::t(
                      'main',
                      'Отказ перевода средств через ' . $data['login_ps'] . ' клиентом'
                    );
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                }
                if (isset($data['transact_id'])) {
                    $XML .= '<transact_id>' . $data['transact_id'] . '</transact_id>';
                }
                if (isset($data['order_id'])) {
                    $XML .= '<order_id>' . $data['order_id'] . '</order_id>';
                }
                $XML .= '<status>' . '9' . '</status>';
                $XML .= '</xml>';

                echo $XML;
            } else { // Не верные параметры запроса
                //header('Parameters no response', true, 403);
                //Yii::app()->end();
                $XML .= '<status>' . '2' . '</status>';
                if (isset($data['order_id'])) {
                    $XML .= '<order_id>' . $data['order_id'] . '</order_id>';
                }
                $XML .= '<comment> Error Access Data </comment>';
                $XML .= '</xml>';

                echo $XML;
            }
            Yii::app()->end();
        } catch (Exception $e) {
            CVarDumper::dump($e, 1, true);
            Yii::app()->end();
        }
    }

    protected function payCash($data, $type)
    {
        $data['sum'] = number_format((float) $data['sum'], 2, '.', '');
        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = $data['sum'];
        $payment->check_summ = $data['sum']; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение наличными');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        $payment->save();

        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_offline',
          ['data' => $data, 'type' => $type]
        );
        return true;
    }

    protected function payEpay($data, $type = false)
    {
        $paySystem = PaySystems::getModelByType($type);
        $parameters = $paySystem['parameters'];
        $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);
        $intDefCurrency = (string) $params['intDefCurrency'];
        $siteCurrency = DSConfig::getVal('site_currency');
        $data['site_currency'] = $siteCurrency;
        $intSumm = number_format((float) $data['sum'], 2, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency($data['sum'], $siteCurrency, $intDefCurrency),
          2,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
              )
            );
            return false;
        }
        $data['sum'] = $OutSum;
        $data['intSumm'] = $intSumm;

        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = (float) str_replace(' ', '', $intSumm);
        $payment->check_summ = (float) str_replace(
          ' ',
          '',
          $OutSum
        ); //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
            $payment->description = Yii::t('main', 'Заявка на оплату заказа') . ' ' . $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

        // ID заказа
        $data['InvId'] = $payment->id;

        /*
        $ENCODED  = base64_encode($data);
        $CHECKSUM = hmac('sha1', $ENCODED, $secret); # XXX SHA-1 algorithm REQUIRED

        $min        = 'SET_THIS_CORRECT';
        $invoice    = sprintf("%.0f", rand(10) * 100000); # XXX Invoice
        $sum        = '22.80';                            # XXX Ammount
        $exp_date   = '01.08.2020';                       # XXX Expiration date
        $descr      = 'Test';                             # XXX Description

        $data = <<<DATA
        MIN={$min}
        INVOICE={$invoice}
        AMOUNT={$sum}
        EXP_TIME={$exp_date}
        DESCR={$descr}
        DATA;

        */
        //$data['Receiver'] = $params['Receiver']; // Идентификатор магазина

        /** Получаем максимальную дату оплаты (+14 дней) **/
        $datenow = date('d.m.Y');
        $date_e = strtotime($datenow);
        $nex = strtotime("+14 day", $date_e);
        $exp_data = date('d.m.Y', $nex);
        if (isset($_POST['CabinetForm']['order'])) {
            $data['description'] =
              Yii::t('main', 'Оплата заказа') . ' ' . Yii::app()->user->id . '-' . $_POST['CabinetForm']['order'];
        } else {
            $data['description'] = Yii::t('main', 'Пополнение счёта') . ' ' . Yii::app()->user->id;
        }

        /* Получаем хэш */
        $datastring = <<<DATA
            MIN={$params['Receiver']}
            INVOICE={$data['InvId']}
            AMOUNT={$data['sum']}
            EXP_TIME={$exp_data}
            DESCR={$data['description']}
DATA;
        //echo $datastring;
        //die;
        $data['encoded'] = base64_encode($datastring);
        $data['chsumm'] = $this->hmac('sha1', $data['encoded'], $params['SecretWord']);
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }
    }

//=============================================================

    protected function payKzCard($data, $type)
    {
        /** Получаем данные из формы **/

        //$sum_pay = (int) $_GET['sum'] * 100;
        $sum_pay = (int) $data['sum'] * 100;

        /** Получаем параметры аутентификации **/
        $paySystem = PaySystems::getModelByType($type);
        $parameters = $paySystem['parameters'];
        $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

        $siteCurrency = DSConfig::getVal('site_currency');

        //$wsdl_url = (string) $params['UrlWsdl'];
        $MID = $params['MerchantId'];

        $returnURL = $params['returnURL'];

        /* Запишем заявку на пополнение */

        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = $data['sum'];
        $payment->check_summ = $sum_pay;
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение PROCESSING.kz');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

        // ID заказа
        $ord_num = $payment->id;
        $data['InvId'] = $ord_num;
        $data['site_currency'] = $siteCurrency;
        // ID пользователя
        $data['User_id'] = Yii::app()->user->id;
        /*
                    $this->render(
                      'webroot.themes.' . DSConfig::getVal('site_front_theme') . '.views.cabinet.payment_online',
                      array('data' => $data, 'type' => $type)
                    );
        */
//===============================================================================================
        include_once(Yii::getPathOfAlias('application.components.WebServiceClient') . '.php');
        $client = new CNPMerchantWebServiceClient(
          $params['UrlWsdl'],
          [
            'connection_timeout' => 60,
            'cache_wsdl'         => WSDL_CACHE_MEMORY,
            'trace'              => 1,
            'soap_version'       => 'SOAP 1.2',
            'encoding'           => 'UTF-8',
            'exceptions'         => true,
            'location'           => $params['url'],
          ]
        );
        $transactionDetails = new TransactionDetails ();
        $transactionDetails->merchantId = $MID;
        //$transactionDetails->terminalId = "TEST TID";
        //$transactionDetails->totalAmount = 100;
        $transactionDetails->totalAmount = $sum_pay;
        $transactionDetails->currencyCode = '398';
        $descript = 'Пополнение счета # ' . $data['User_id'] . ' интернет-магазин ' . DSConfig::getVal('site_name');
        $transactionDetails->description = $descript;
        /*
         * в конце url-а передаем '&customerReference=', для того чтоб использовать автоматическую генерацию RRN,
         * автоматически сгенерированный customerReference будет дополняться в конце URL адреса в вашем returnURL.
         *
         */
        $transactionDetails->returnURL = $returnURL;
        $transactionDetails->goodsList = [];
        $goodItem = new GoodsItem();
        $goodItem->amount = $sum_pay;
        $goodItem->currencyCode = '398';
        $goodItem->merchantsGoodsID = 0;
        $goodItem->nameOfGoods = $descript;
        $transactionDetails->goodsList[] = $goodItem;
        $transactionDetails->languageCode = "ru";
        $transactionDetails->merchantLocalDateTime = date("d.m.Y H:i:s");
        //$transactionDetails->orderId = rand ( 1, 10000 );
        $transactionDetails->orderId = $ord_num;
        //$transactionDetails->purchaserName = "IVANOV IVAN";
        //$transactionDetails->purchaserEmail = "purchaser@processing.kz";
        $transactionDetails->purchaserEmail = Yii::app()->user->email;

        $st = new startTransaction ();
        $st->transaction = $transactionDetails;
        //CVarDumper::dump($transactionDetails);die;
        $startTransactionResult = $client->startTransaction($st);

        if ($startTransactionResult->return->success == true) {
            // на всякой случай сохраняем данные customerReference в сессию
            $_SESSION ["customerReference"] = $startTransactionResult->return->customerReference;
            //header("Location: " . $startTransactionResult->return->redirectURL);

            $data['reqURL'] = $startTransactionResult->return->redirectURL;
            if (file_exists(
              Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
            )) {
                $this->renderPartial(
                  'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
                  ['data' => $data, 'type' => $type]
                );
                Yii::app()->end();
            } else {
                $this->render(
                  'webroot.themes.' . DSConfig::getVal('site_front_theme') . '.views.cabinet.payment_online',
                  ['data' => $data, 'type' => $type]
                );
            }
            return false;

        } else {
            $errors = 'Error: ' . $startTransactionResult->return->errorDescription;
            Utils::debugLog($errors);
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка' . ': ' . $startTransactionResult->return->errorDescription
              )
            );
            return false;
        }
//===============================================================================================
        /*
                $this->render(
                  'webroot.themes.' . DSConfig::getVal('site_front_theme') . '.views.cabinet.payment_online',
                  array('data' => $data, 'type' => $type)
                );
        */

        Yii::app()->end();
    }

    /*     * **************************************************************************************
     *                                                                   PAY FORMS FUNCTIONS *
     * ************************************************************************************* */

    protected function payLiqpay($data, $type)
    {
        $paySystem = PaySystems::getModelByType($type);
        $parameters = $paySystem['parameters'];
        $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);
        $intDefCurrency = (string) $params['intDefCurrency'];
        $siteCurrency = DSConfig::getVal('site_currency');
        $data['siteCurrency'] = $siteCurrency;
        $intSumm = number_format((float) $data['sum'], 2, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency($data['sum'], $siteCurrency, $intDefCurrency),
          2,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
              )
            );
            return false;
        }
        $data['sum'] = $OutSum;
        $data['intSumm'] = $intSumm;

        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = (float) str_replace(' ', '', $intSumm);
        $payment->check_summ = (float) str_replace(
          ' ',
          '',
          $OutSum
        ); //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение LiqPay');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

// ID заказа
        $data['InvId'] = $payment->id;
// ID товара, в нашем случае ID пользователя
        $data['Shp_item'] = Yii::app()->user->id;
        $data['site_currency'] = $siteCurrency;
        $operation_xml = PaySystems::preRenderForm($data, $type, (string) $params['operation_xml']);
        $data['operation_xml'] = base64_encode($operation_xml);

        $data['merchant_sig'] = (string) $params['merchant_sig'];
        $data['signature'] = base64_encode(sha1($data['merchant_sig'] . $operation_xml . $data['merchant_sig'], 1));

// формирование подписи
// generate signature
//    $data['SignatureValue'] = md5($MrchLogin . ':' . $OutSum . ':' . $data['InvId'] . ':' . $password1 . ':' . 'Shp_item=' . $data['Shp_item']);
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }
        return true;
    }

    protected function payOnPay($data, $type)
    {
        /*
         * <form action="{#url}" method="GET" target="_blank">
          <input name="pay_mode" value="fix" type="hidden">
          <input name="f" value="7" type="hidden">
          <input name="price" value="{sum}" type="hidden">
          <input name="pay_for" value="{InvId}" type="hidden">
          <input name="note" value="Пополнение счёта пользователя #{Shp_item}" type="hidden">
          <input name="ticker" value="{IncCurrLabel}" type="hidden">
          <input name="user_phone" value="{ClientPhone}" type="hidden">
          <input name="price_final" value="false" type="hidden">
          <input name="md5" value="{Check}" type="hidden">
          <input name="url_success" value="{#SuccessUrl}" type="hidden">
          <input name="url_fail" value="{#FailUrl}" type="hidden">
          <br>
          <input value="Перейти к оплате" onclick="window.history.back();" type="submit">
          </form>
         */

        $paySystem = PaySystems::getModelByType($type);
        $parameters = $paySystem['parameters'];
        $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

        $intDefCurrency = 'rur';
        $siteCurrency = DSConfig::getVal('site_currency');
        $data['sum'] = $data['sum'] * 1.08;                 // 8% налогов за счет плательщика
        $intSumm = number_format((float) $data['sum'], 1, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency(
            $data['sum'],
            $siteCurrency,
            $intDefCurrency,
            1
          ),
          1,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
              )
            );
            return false;
        }

        $data['sum'] = $OutSum;
        $data['intSumm'] = $intSumm;
        $data['ClientPhone'] = $data['phone'];

        $payment = new Payment;
        $payment->sum = $intSumm;
        $payment->check_summ = $OutSum; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение OnePay');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

        // ID заказа
        $data['InvId'] = $payment->id;
        $data['ticker'] = $data['IncCurrLabel'] = mb_strtoupper($siteCurrency);
        // ID пользователя
        $data['Shp_item'] = Yii::app()->user->id;

        $data['SuccessUrl'] = 'http://' . DSConfig::getVal(
            'site_domain'
          ) . '/ru/cabinet/balance/paysuccess/sender/onpay/id/' . $payment->id;
        $data['FailUrl'] = 'http://' . DSConfig::getVal(
            'site_domain'
          ) . '/ru/cabinet/balance/payfail/sender/onpay/id/' . $payment->id;

        /* pay_mode;price;ticker;pay_for;convert;secret_key */
        $prekey = $params['PayMode'] . ';' .
          $data['sum'] . ';' .
          $data['ticker'] . ';' .
          $data['InvId'] . ';yes;' .
          $params['SecretKey'];
        $data['Check'] = md5($prekey);
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }
        return false;
    }

    protected function payOrder($data, $type)
    {
        $data['sum'] = number_format((float) $data['sum'], 2, '.', '');
        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = $data['sum'];
        $payment->check_summ = $data['sum']; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение банковским переводом');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        $payment->save();
        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_offline',
          ['data' => $data, 'type' => $type]
        );
        return true;
    }

    protected function payPayMaster($data, $type)
    {
        /* Передаваемые параметры:
          <form action="{#url}" method="POST" target="_blank">
          <input name="LMI_MERCHANT_ID" value="{#MrchLogin}" type="hidden">
          <input name="LMI_PAYMENT_AMOUNT" value="{sum}" type="hidden">
          <input name="LMI_PAYMENT_NO" value="{InvId}" type="hidden">
          <input name="LMI_PAYMENT_DESC" value="Пополнение счёта пользователя #{Shp_item}" type="hidden">
          <input name="LMI_CURRENCY" value="{IncCurrLabel}" type="hidden">
          <input name="LMI_PAYER_PHONE_NUMBER" value="{ClientPhone}" type="hidden">
          <input name="LMI_SIM_MODE" value="0" type="hidden">
          <br>
          <input value="Перейти к оплате" onclick="window.history.back();" type="submit">
          </form>
         */

        $intDefCurrency = 'rur';
        $siteCurrency = DSConfig::getVal('site_currency');
        $intSumm = number_format((float) $data['sum'], 2, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency(
            $data['sum'],
            $siteCurrency,
            $intDefCurrency,
            2
          ),
          2,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
              )
            );
            return false;
        }

        $data['sum'] = $OutSum;
        $data['intSumm'] = $intSumm;
        $data['ClientPhone'] = $data['phone'];
        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = $intSumm;
        $payment->check_summ = $OutSum; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение Pay Master');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

        // ID заказа
        $data['InvId'] = $payment->id;
        $data['site_currency'] = $data['IncCurrLabel'] = mb_strtoupper($siteCurrency);
        // ID пользователя
        $data['Shp_item'] = Yii::app()->user->id;
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }
        return false;
    }

    protected function payPaycard($data, $type)
    {
        /**
         *  Параметры для взаимодействия
         * 'PAYMENT_MERCHANT_ID'       => 'merchantId',
         * 'PAYMENT_ORDER_NR'          => 'order_nr',
         * 'PAYMENT_AMOUNT'            => 'amount',
         * 'PAYMENT_CURRENCY'          => 'currency',
         * 'PAYMENT_SYSTEM'            => 'paymentSystems',
         * 'PAYMENT_DESC'              => 'desc',
         * 'PAYMENT_RESULT_URL'        => 'site_result_url',
         * 'PAYMENT_RESULT_METHOD'     => 'site_result_method',
         * 'PAYMENT_SUCCESS_URL'       => 'site_success_url',
         * 'PAYMENT_SUCCESS_METHOD'    => 'site_success_method',
         * 'PAYMENT_CANCEL_URL'        => 'site_cancel_url',
         * 'PAYMENT_CANCEL_METHOD'     => 'site_cancel_method',
         * 'PAYMENT_HASH'              => 'created_hash',
         * 'PAYMENT_RESPONS_KEY'       => 'key',
         * 'PAYMENT_TRANSPARENT'       => 'transparent',
         * 'PAYMENT_CUSTOMER_EMAIL'    => 'customer_email',
         * 'PAYMENT_CUSTOMER_PHONE'    => 'customer_phone',
         * 'PAYMENT_CUSTOMER_NAME'     => 'customer_name',
         * 'PAYMENT_CUSTOMER_FNAME'    => 'customer_fname',
         * 'PAYMENT_CUSTOMER_LNAME'    => 'customer_lname',
         * 'PAYMENT_CUSTOMER_CITY'     => 'customer_city',
         * 'PAYMENT_CUSTOMER_COUNTRY'  => 'customer_country',
         * 'PAYMENT_AUTO_REG'          => 'auto_reg',
         * 'PAYMENT_BILL'              => 'bill',
         */
        $paySystem = PaySystems::getModelByType($type);
        $parameters = $paySystem['parameters'];
        $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

        $data['merchantUrl'] = 'https://pay-card.eu/process/payment';
        $data['merchantId'] = $params['merchant_id'];
        $data['merchantSign'] = $params['merchant_sign'];
        $data['paymentSystems'] = 'BPS';
        $data['currency'] = $params['currency'];
        $data['site_language'] = $params['site_language'];

        $data['site_result_url'] = 'https://' . DSConfig::getVal(
            'site_domain'
          ) . '/cabinet/balance/payresult/sender/paycard';
        $data['site_result_method'] = 'POST';
        $data['site_success_url'] = 'http://' . DSConfig::getVal(
            'site_domain'
          ) . '/cabinet/balance/paysuccess/sender/paycard';
        $data['site_success_method'] = 'POST';
        $data['site_cancel_url'] = 'http://' . DSConfig::getVal(
            'site_domain'
          ) . '/cabinet/balance/payfail/sender/paycard';
        $data['site_cancel_method'] = 'POST';

        $data['site_sys_error_url'] = null;
        $data['site_sys_error_method'] = 'POST';

        $data['pc_method'] = 'POST';
        $data['transparent'] = 1;
        $data['bill'] = 0;
        $data['auto_reg'] = 0;

        // получим необходимые данные о пользователе
        $data['uid'] = Yii::app()->user->id;
        $user = Users::model()->findByPkEx($data['uid']);

        if (!isset($user->city) or !empty($user->city)) {
            $user_city = $user->city;
        } else {
            $user_city = Yii::t('main', 'нет данных');
        }
        if (!isset($user->country) or !empty($user->country)) {
            $user_country = $user->country;
        } else {
            $user_country = Yii::t('main', 'нет данных');
        }

        // сумма для оплаты с учетом коммисии (+3.9%) +0.4 USD (оплата за транзакцию)
        $sum_include_commision = $data['sum'] * 1.039;
        $data['fullsum'] = round($sum_include_commision + 0.4, 2);

        $data['uemail'] = $user->email;
        $data['uphone'] = $data['phone'];
        $data['ufname'] = $user->fullname;

        // запишем операцию заявки в базу
        $payment = new Payment;
        $payment->status = 3;
        $payment->check_summ = $data['sum'];
        //$payment->check_summ = $OutSum; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение PAY-CARD');
        $payment->uid = $data['uid'];
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

        // ID заказа
        $order_id = $payment->id;
        // Сосотавляем уникальный ID заказа
        $time = time();
        $data['coef'] = $order_id;

        $data['order_nr'] = $time;

        //$data['order_nr'] = $payment->id;
// составим хэш для платежной системы PAY-CARD (добавить в форму отправки поле - HASH)
        $data['hash'] = md5(
          $data['merchantId'] .
          '|' .
          $data['order_nr'] .
          '|' .
          $data['fullsum'] .
          '|' .
          $data['currency'] .
          '|' .
          $data['paymentSystems'] .
          '|' .
          $data['merchantSign']
        );
// получаем KEY

        set_time_limit(0);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $data['merchantUrl']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
          $ch,
          CURLOPT_POSTFIELDS,
          [
            'get_key_shop' => $data['merchantId'],
            'order_nr'     => $data['order_nr'],
            'amount'       => $data['fullsum'],
            'created_hash' => $data['hash'],
          ]
        );

        $data['key'] = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($code == 200) { // Рендерим форму для передачи данных
            if (file_exists(
              Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
            )) {
                $this->renderPartial(
                  'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
                  ['data' => $data, 'type' => $type]
                );
                Yii::app()->end();
            } else {
                $this->render(
                  'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
                  ['data' => $data, 'type' => $type]
                );
            }
            return false;
        }
    }

    protected function payPaypal($data, $type)
    {
        return false;
    }

    protected function payQiwi($data, $type)
    {
        /*         * ***************
         *  Идентификатор пользователя: 17989754
         * Пароль: YYJnYwVFboTgxrscJI02
         */

        // Оплата заданной суммы на сайте Visa Qiwi Wallet
        // Payment of the set sum on  Visa Qiwi Wallet  site
        //==========================
        $paySystem = PaySystems::getModelByType($type);
        $parameters = $paySystem['parameters'];
        $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

        $intDefCurrency = 'rur';
        $siteCurrency = DSConfig::getVal('site_currency');
        $intSumm = number_format((float) $data['sum'], 2, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency($data['sum'], $siteCurrency, $intDefCurrency),
          2,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
              )
            );
            return false;
        }

        $data['sum'] = $OutSum;
        $data['intSumm'] = $intSumm;
        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = $intSumm;
        $payment->check_summ = $OutSum; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение Qiwi');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

// ID заказа
        $data['InvId'] = $payment->id;
        $data['site_currency'] = $siteCurrency;
// ID пользователя
        $data['User_id'] = Yii::app()->user->id;
        $data['Success_Url'] = $params['SuccessUrl'] . '/payid/' . $payment->id;
        $data['Fail_Url'] = $params['FailUrl'] . '/payid/' . $payment->id;
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }

        return false;
    }

    /*    Передаваемые параметры:
      <?xml version="1.0" encoding='UTF-8' ?>
      <paySystem>
      <name><![CDATA[liqpay]]></name>
      <url><![CDATA[https://www.liqpay.com/?do=clickNbuy]]></url>
      <operation_xml><![CDATA[<request>
      <version>1.2</version>
      <merchant_id>777danvitnet</merchant_id>
      <result_url>http://777.danvit.ru/ru/cabinet/balance/paysuccess/sender/liqpay</result_url>
      <server_url>http://777.danvit.ru/ru/cabinet/balance/payresult/sender/liqpay</server_url>
      <order_id>{InvId}</order_id>
      <amount>{sum}</amount>
      <currency>UAH</currency>
      <description>Payment from user #{Shp_item}</description>
      <default_phone>{userPhone}</default_phone>
      <pay_way>card,liqpay</pay_way>
      <goods_id>{Shp_item}</goods_id>
      </request>]]></operation_xml>

      <merchant_sig>123123123</merchant_sig>
      <intDefCurrency>uah</intDefCurrency>
      </paySystem>

      <form action="#url" method="POST" />
      <input type="hidden" name="operation_xml" value="{#operation_xml}" />
      <input type="hidden" name="signature" value="{signature}" />
      <input type="submit" value="Перейти к оплате">
      </form>


     */

    protected function payQiwiKz($data, $type = false) // Пополнение баланса через терминалы QIWI (KZ)
    {
        //$account = $_GET['account']; // Идентификатор клиента
        //$txn = (int) $_GET['txn_id']; // ID транзакции
        //$sum = (float) $_GET['sum']; // Сумма в тенге
        //$command = $_GET['command']; // Идентификатор операции

        //Utils::debugLog(($data), true);
        Utils::debugLog(CVarDumper::dumpAsString($data));

        if (isset($data['command'])) {
            $comment = '';
            $txn = $data['txn_id'];

            $xml = '<?xml version="1.0" encoding="UTF-8"?>' .
              '<response>' .
              '<osmp_txn_id>' . $txn . '</osmp_txn_id>';

            if ($data['command'] == 'check') { // Проверка наличия аккаунта

                $account = $data['account'];
                $sum = $data['sum'];
                $account_id = ltrim(str_replace('-', '', $account), '0');

                $user = Users::model()->findByPk($account_id);

                if ($user) {
                    //$fild['balans'] = Users::getBalance($account_id); // Получение баланся

                    /* Запишем заявку на пополнение */
                    $payment = new Payment;
                    $payment->status = 3;
                    $payment->date = date("Y-m-d H:i:s", time());
                    $payment->check_summ = $sum;
                    $payment->description = Yii::t('main', 'Заявка на пополнение QIWI(KZ)');
                    $payment->comment = $data['txn_id'];
                    $payment->uid = $data['account'];
                    $payment->manager_id = Yii::app()->user->id;
                    if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
                        $payment->oid = $_POST['CabinetForm']['order'];
                    }
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;

                    //$order_id = $payment->id; // ID заказа

                    $balans2text = 'Остаток на счете ' . Users::getBalance($account_id) . ' тенге';

                    $fild = [
                      'email'  => $user->email,
                      'balans' => $balans2text,
                    ];
                    //$data['InvId'] = $ord_num;
                    //$data['site_currency'] = $siteCurrency;
                    // ID пользователя
                    //$data['User_id'] = Yii::app()->user->id;

                    $result = 0;
                    $comment = 'Ожидание зачисления средств';

                    $xml .= '<result>' . $result . '</result>' .
                      '<fields>' .
                      '<field1 name="email">' . $fild['email'] . '</field1>' .
                      '<field2 name="balans">' . $fild['balans'] . '</field2>' .
                      '</fields>';

                } else {
                    $xml .= '<result>5</result>';
                    $comment = 'Запрошеный аккаунт не существует';
                }

            }

            if ($_GET['command'] == 'pay') { // Зачисление средств

                $account = $data['account'];
                $account_id = ltrim(str_replace('-', '', $account), '0');
                $sum = $data['sum'];
                //$data_pay = $data['txn_date'];
                $payment = Payment::model()->findBySql(
                  "SELECT * FROM payments WHERE uid = :uid ORDER BY id DESC LIMIT 1",
                  [
                    ':uid' => $account_id,
                  ]
                );

                if ($payment && ($payment->status != 1)) {

                    //$id = $row;

                    Utils::debugLog(CVarDumper::dumpAsString($payment));

                    /** Записываем операцию и пополняем баланс * */
                    //$payment = Payment::model()->findByPk($id);
                    $payment->status = 1;
                    $payment->sum = round($sum, 2);
                    $payment->description = Yii::t('main', 'Зачисление средств QIWI(KZ)');
                    //$payment->check_sum = $payment['AMOUNT'];
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($payment->save()) {
                            if ($payment->oid) {
                                OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                            }
                        }
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                    //header('OK', true, 200);

                    $result = 0;
                    $comment = 'Баланс успешно пополнен';

                    $xml .= '<prv_txn>' . $payment->id . '</prv_txn>' .
                      '<sum>' . $sum . '</sum>' .
                      '<result>' . $result . '</result>';

                } else {
                    $xml .= '<result>5</result>';
                    $comment = 'Ошибка транзакции ID не найден';
                }
            }

            $xml .= '<comment>' . $comment . '</comment>' .
              '</response>';

            echo $xml;

            Yii::app()->end();
        }
    }

    protected function payRobokassa($data, $type)
    {
        /*    Передаваемые параметры:
          <html>
          <form action="{#url}" method="POST">
          <input type="hidden" name="MrchLogin" value="{#MrchLogin}">
          <input type="hidden" name="OutSum" value="{sum}">
          <input type="hidden" name="InvId" value="{InvId}">
          <input type="hidden" name="Desc" value="{Desc}">
          <input type="hidden" name="SignatureValue" value="{SignatureValue}">
          <input type="hidden" name="Shp_item" value="{Shp_item}">
          <input type="hidden" name="IncCurrLabel" value="{IncCurrLabel}">
          <input type="hidden" name="Culture" value="{Culture}">
          <input type="submit" value="{#SubmitValue}">
          </form>
          </html>
         */
// Оплата заданной суммы с выбором валюты на сайте ROBOKASSA
// Payment of the set sum with a choice of currency on site ROBOKASSA
// регистрационная информация (логин, пароль #1)
// registration info (login, password #1)
//==========================
        $paySystem = PaySystems::getModelByType($type);
        $parameters = $paySystem['parameters'];
        $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);
        $intDefCurrency = (string) $params['intDefCurrency'];
        $siteCurrency = DSConfig::getVal('site_currency');
        $intSumm = number_format((float) $data['sum'], 2, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency($data['sum'], $siteCurrency, $intDefCurrency),
          2,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
              )
            );
            return false;
        }
        $data['sum'] = $OutSum;
        $data['intSumm'] = $intSumm;
        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = $intSumm;
        $payment->check_summ = $OutSum; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение RoboKassa');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;
// ID заказа
        $data['InvId'] = $payment->id;
// ID товара, в нашем случае ID пользователя
        $data['Shp_item'] = Yii::app()->user->id;
        $MrchLogin = (string) $params['MrchLogin'];
        $password1 = (string) $params['Password1'];
// предлагаемая валюта платежа
// default payment e-currency
        $data['IncCurrLabel'] = '';
// язык
// language
        $data['Culture'] = Utils::transLang();

        $data['site_currency'] = $siteCurrency;

// формирование подписи
// generate signature
        $data['SignatureValue'] = md5(
          $MrchLogin . ':' . $OutSum . ':' . $data['InvId'] . ':' . $password1 . ':' . 'Shp_item=' . $data['Shp_item']
        );
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }
        return true;
    } // End <payWayforpay>

    protected function payWalletone($data, $type)
    {
        /* Передаваемые параметры:
          <form method="POST" action="{#url}" target="_blank" accept-charset="UTF-8">
          <input name="WMI_MERCHANT_ID" value="{MerchantId}" type="hidden">
          <input name="WMI_PAYMENT_AMOUNT" value="{sum}" type="hidden">
          <input name="WMI_CURRENCY_ID" value="643" type="hidden">
          <input name="WMI_DESCRIPTION" value="{Description}" type="hidden">
          <input name="WMI_PAYMENT_NO" value="{InvId}" type="hidden">
          <input name="WMI_SUCCESS_URL" value="{SuccessUrl}" type="hidden">
          <input name="WMI_FAIL_URL" value="{FailUrl}" type="hidden">
          <input name="WMI_SIGNATURE" value="{Signature}" type="hidden">
          <br>
          <input value="Перейти к оплате" onclick="window.history.back();" type="submit">
          </form>
         */
        // Оплата заданной суммы на сайте Единая касса
        // Payment of the set sum on  Wallet One  site
        // регистрационная информация (WMI_MERCHANT_ID)
        // registration info (WMI_MERCHANT_ID)
        //==========================
        $paySystem = PaySystems::getModelByType($type);
        $parameters = $paySystem['parameters'];
        $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

        $intDefCurrency = 'rur';
        $siteCurrency = DSConfig::getVal('site_currency');
        $intSumm = number_format((float) $data['sum'], 2, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency($data['sum'], $siteCurrency, $intDefCurrency),
          2,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
              )
            );
            return false;
        }

        $data['sum'] = $OutSum;
        $data['intSumm'] = $intSumm;
        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = $intSumm;
        $payment->check_summ = $OutSum; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение Единая касса');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

// ID заказа
        $data['InvId'] = $payment->id;
        $data['site_currency'] = $siteCurrency;
// ID пользователя
        $data['User_id'] = Yii::app()->user->id;
        /* действуем согласно мануалу    http://www.walletone.com/ru/merchant/documentation/ */
        $fields = [];

        $fields["WMI_MERCHANT_ID"] = $params['Merchant_id'];
        $fields["WMI_PAYMENT_AMOUNT"] = $data['sum'];
        $fields["WMI_CURRENCY_ID"] = "643";
        $fields["WMI_DESCRIPTION"] = "BASE64:" . base64_encode('Пополнение счёта пользователя #' . $data['User_id']);
        $fields["WMI_PAYMENT_NO"] = $data['InvId'];
        $fields["WMI_SUCCESS_URL"] = $params['Success_url'];
        $fields["WMI_FAIL_URL"] = $params['Fail_url'];

        //Сортировка значений внутри полей
        foreach ($fields as $name => $val) {
            if (is_array($val)) {
                usort($val, "strcasecmp");
                $fields[$name] = $val;
            }
        }

        uksort($fields, "strcasecmp");
        $fieldValues = "";

        foreach ($fields as $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    //$v = $this->win2utf( $v, "uw" );
                    $v = iconv("utf-8", "windows-1251", $v);
                    $fieldValues .= $v;
                }
            } else {
                //$value = $this->win2utf( $value, "uw" );
                $value = iconv("utf-8", "windows-1251", $value);
                $fieldValues .= $value;
            }
        }

        $signature = base64_encode(pack("H*", md5($fieldValues . $params['SecretKey'])));

        //Добавление параметра WMI_SIGNATURE в словарь параметров формы
        //$fields[ "WMI_SIGNATURE" ] = $signature;
        /*         * ************************************************* End of doc.code */
        $data['MerchantId'] = $params['Merchant_id'];
        $data['Description'] = $fields["WMI_DESCRIPTION"];
        $data['Signature'] = $signature;
        $data['Success_url'] = $fields["WMI_SUCCESS_URL"];
        $data['Fail_url'] = $fields["WMI_FAIL_URL"];
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }

        return false;
    }

    protected function payWayforpay($data, $type)
    {
        $paySystem = PaySystems::getModelByType($type);
        $parameters = $paySystem['parameters'];
        $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

        $intDefCurrency = 'rur';
        $siteCurrency = DSConfig::getVal('site_currency');
        // Тут конвертим валюты
        $intSumm = number_format((float) $data['sum'], 2, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency($data['sum'], $siteCurrency, $intDefCurrency),
          2,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t('main', 'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!')
            );
            return false;
        }

        $data['sum'] = $OutSum * 1.03;
        $data['intSumm'] = $intSumm;
        $data['timeOrd'] = time();
        $data['SiteName'] = DSConfig::getVal('site_name');
        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = $intSumm;
        $payment->check_summ = $data['sum']; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = $data['timeOrd'];
        $payment->description = Yii::t('main', 'Заявка на пополнение WayForPay');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        $payment->comment = date('d-m-Y h:i:s');
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
            $data['orderId'] = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

        // ID заказа
        $data['InvId'] = $payment->id;
        $data['site_currency'] = $siteCurrency;
        // ID пользователя
        $data['User_id'] = Yii::app()->user->id;;
        // Создадим ХЭШ для отправки
        $string = $params['Receiver']
          . ';' . $data['SiteName']
          . ';' . $data['InvId']
          . ';' . $data['timeOrd']
          . ';' . $data['sum']
          . ';' . $params['intDefCurrency']
          . ';' . 'Пополнение счета клиента trend-tao.com.ua'
          . ';1'
          . ';' . $data['sum'];
        $stringHASH = hash_hmac("md5", $string, $params['SecretWord']);
        $data['merchantSignature'] = $stringHASH;

        //Utils::debugLog(CVarDumper::dumpAsString($stringHASH));
        //Utils::debugLog(CVarDumper::dumpAsString($type));
        //Utils::debugLog(CVarDumper::dumpAsString($data));

        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }

        //return false;
    }

    protected function payWebmoney($data, $type)
    {
        return false;
    }

    protected function payYandexkassa($data, $type)
    {
        /* Передаваемые параметры:

          <form action="{#urldemo}" method="post">
          <!-- Обязательные поля -->
          <input name="paymentType" value="" type="hidden" />
          <input name="shopId" value="{#shopid}" type="hidden" />
          <input name="scid" value="{#scid}" type="hidden" />
          <input name="sum" value="{sum}" type="hidden" />
          <input name="customerNumber" value="{User_id}" type="hidden" />
          <!--
          <input name="cps_phone" value="79110000000"/>
          <input name="cps_email" value="testuser@dropshop.com"/>
          -->
          <br>
          <input value="Перейти к оплате" onclick="setTimeout(function(){window.location.href='/cabinet';}, 1000);" type="submit"/>
          </form>
         */
        // Оплата заданной суммы на сайте Яндекс.Деньги
        // Payment of the set sum on  Яндекс.Деньги  site
        // регистрационная информация (receiver)
        // registration info (receiver)
        //==========================
        $intDefCurrency = 'rur';
        $siteCurrency = DSConfig::getVal('site_currency');
        $intSumm = number_format((float) $data['sum'], 2, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency($data['sum'], $siteCurrency, $intDefCurrency),
          2,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
              )
            );
            return false;
        }

        $data['sum'] = $OutSum;
        $data['intSumm'] = $intSumm;
        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = $intSumm;
        $payment->check_summ = $OutSum; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение Яндекс.Касса');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

// ID заказа
        $data['InvId'] = $payment->id;
        $data['site_currency'] = $siteCurrency;
// ID пользователя
        $data['User_id'] = Yii::app()->user->id;
        // E-mail пользователя
        $data['User_email'] = Yii::app()->user->email;
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . DSConfig::getVal('site_front_theme') . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }
        return false;
    }

    protected function payYandexmoney($data, $type = false)
    {
        /* Передаваемые параметры:

          <form method=" POST " action="{#url}" target="_blank">
          <input name="receiver" value="{#Receiver}" type="hidden">
          <input name="formcomment" value="Пополнение счёта пользователя #{Shp_item}" type="hidden">
          <input name="short-dest" value="Пополнение счёта пользователя #{Shp_item}" type="hidden">
          <input name="label" value="{InvId}" type="hidden">
          <input name="quickpay-form" value="shop" type="hidden">
          <input name="targets" value="Пополнение счёта пользователя #{Shp_item}" type="hidden">
          <input name="sum" value="{sum}" data-type="number" type="hidden">
          <input name="paymentType" value="PC" type="hidden">
          <br>
          <input value="Перейти к оплате" onclick="window.history.back();" type="submit">
          </form>
         */
        // Оплата заданной суммы на сайте Яндекс.Деньги
        // Payment of the set sum on  Яндекс.Деньги  site
        // регистрационная информация (receiver)
        // registration info (receiver)
        //==========================
        $intDefCurrency = 'rur';
        $siteCurrency = DSConfig::getVal('site_currency');
        $intSumm = number_format((float) $data['sum'], 2, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency($data['sum'], $siteCurrency, $intDefCurrency),
          2,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
              )
            );
            return false;
        }

        $data['sum'] = $OutSum;
        $data['intSumm'] = $intSumm;
        $payment = new Payment();
        $payment->status = 3;
        $payment->sum = $intSumm;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        $payment->check_summ = $OutSum; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение Яндекс.Деньги');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

        // ID заказа
        $data['InvId'] = $payment->id;
        $data['site_currency'] = $siteCurrency;
        // ID пользователя
        $data['User_id'] = Yii::app()->user->id;
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }
        return false;
    }

// базовый экшен для платежей PAY-CARD

    protected function payZpayment($data, $type)
    {
        /* Передаваемые параметры:
          <form action="{#url}" method="POST" target="_blank" name="pay">
          <input name="LMI_PAYEE_PURSE" value="{#ZPShopId}" type="hidden">
          <input name="LMI_PAYMENT_AMOUNT" value="{sum}" type="hidden">
          <input name="LMI_PAYMENT_DESC" value="Пополнение счёта пользователя #{Shp_item}" type="hidden">
          <input name="LMI_PAYMENT_NO" value="{InvId}" type="hidden">
          <br>
          <input value="Перейти к оплате" onclick="window.history.back();" type="submit">
          </form>
         */
        // Оплата заданной суммы на сайте Z-Payment
        // Payment of the set sum on  Z-Payment  site
        // регистрационная информация (receiver)
        // registration info (receiver)
        //==========================
        $intDefCurrency = 'rur';
        $siteCurrency = DSConfig::getVal('site_currency');
        $intSumm = number_format((float) $data['sum'], 2, '.', '');
        $OutSum = number_format(
          (float) Formulas::convertCurrency($data['sum'], $siteCurrency, $intDefCurrency),
          2,
          '.',
          ''
        );
        if ($OutSum <= 0) {
            Yii::app()->user->setFlash(
              'payment',
              Yii::t(
                'main',
                'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
              )
            );
            return false;
        }

        $data['sum'] = $OutSum;
        $data['intSumm'] = $intSumm;
        $payment = new Payment;
        $payment->status = 3;
        $payment->sum = $intSumm;
        $payment->check_summ = $OutSum; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
        $payment->date = date("Y-m-d H:i:s", time());
        $payment->description = Yii::t('main', 'Заявка на пополнение Z-Payment');
        $payment->uid = Yii::app()->user->id;
        $payment->manager_id = Yii::app()->user->id;
        if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
            $payment->oid = $_POST['CabinetForm']['order'];
        }
        //Yii::app()->db->autoCommit = false;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $payment->save();
        } catch (Exception $e) {
            if (isset($transaction) && $transaction && $transaction->active) {
                $transaction->rollback();
            }
            //Yii::app()->db->autoCommit = true;
            Utils::debugLog(CVarDumper::dumpAsString($e));
        }
        if ($transaction->active) {
            $transaction->commit();
        }
        //Yii::app()->db->autoCommit = true;

// ID заказа
        $data['InvId'] = $payment->id;
        $data['site_currency'] = $siteCurrency;
// ID пользователя
        $data['Shp_item'] = Yii::app()->user->id;
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type]
            );
        }
        return false;
    }

    function actionIndex($payment_email = null)
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Выписка по счету');
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];
        $uid = Yii::app()->user->id;
        $sqlUnion = " from
      ((select concat('PAY-',pp.id) as id, pp.\"sum\", pp.description, pp.status, pp.\"date\", pp.uid, pp.check_summ, pp.comment
       from payments pp
       where
       (pp.uid=:uid) and pp.status IN (1,2,5,6,7,8)
        and (pp.\"date\">=:date_from or :date_from is null) and (pp.\"date\"<=:date_to or :date_to is null)
       )

      UNION ALL
(select concat('ODR-PAY-',op.oid) as id,
round(op.summ,2) as \"sum\",
descr as description,
100 as status,
extract(epoch from \"date\") as \"date\",
uid, 0 as check_summ, null as comment
from orders_payments op
where op.oid IN (SELECT oo.id
                              FROM orders oo
                             WHERE     oo.uid = :uid
                                   AND oo.status NOT IN ('CANCELED_BY_CUSTOMER','CANCELED_BY_SERVICE')))

       UNION ALL
         (select concat('ODR-DEL-',oo.id) as id,
(select round(coalesce(sum(op.summ),0),2) from orders_payments op where op.oid=oo.id) as \"sum\",
 concat('" . Yii::t('main', 'Отмена заказа') . " №',oo.id) as description,
-100 as status,
extract(epoch from (select el.\"date\" from events_log el where el.subject_id = oo.id and el.event_name = 'Order.beforeUpdate.status'
order by el.\"date\" desc limit 1)) as \"date\",
oo.uid, 0 as check_summ, null as comment
         from orders oo
         where oo.uid=:uid
         and oo.status in ('CANCELED_BY_CUSTOMER','CANCELED_BY_SERVICE')
         and (oo.date>=:date_from or :date_from is null) and (oo.date<=:date_to or :date_to is null)
         )
       ) pu ";

        $sqlSelect = "select pu.id, pu.\"sum\", pu.description, pu.status, pu.\"date\", pu.uid, pu.check_summ, pu.comment, pu.text_date,
     case when pu.status=1 then '" . Yii::t('main', 'Зачисление или возврат средств') . "'
      when pu.status=2 then '" . Yii::t('main', 'Снятие средств') . "'
      when pu.status=3 then '" . Yii::t('main', 'Ожидание зачисления средств') . "'
      when pu.status=4 then '" . Yii::t('main', 'Отмена ожидания зачисления средств') . "'
      when pu.status=5 then '" . Yii::t('main', 'Отправка внутреннего перевода средств') . "'
      when pu.status=6 then '" . Yii::t('main', 'Получение внутреннего перевода средств') . "'
      when pu.status=7 then '" . Yii::t('main', 'Зачисление бонуса или прибыли') . "'
      when pu.status=8 then '" . Yii::t('main', 'Вывод средств из системы') . "'
      when pu.status=100 then '" . Yii::t('main', 'Платеж по заказу') . "'
      when pu.status=-100 then '" . Yii::t('main', 'Возврат средств по заказу') . "'
      else '" . Yii::t('main', 'Не определено (ошибка?)') . "' end as status_name" .
          $sqlUnion . " order by pu.date desc";

        $sqlCount = "select count(0) " . $sqlUnion;

        if (isset($_POST['yt0'])) {
            $date_from = new DateTime($_POST['date_from']);
            $date_to = new DateTime($_POST['date_to']);
            $date_to->modify('+ 1 day');
            $date_from_u = $date_from->getTimestamp();
            $date_to_u = $date_to->getTimestamp();
            Yii::app()->session->add('payments_dates', ['date_from_u' => $date_from_u, 'date_to_u' => $date_to_u,]);
        } else {
            //вычисляем дату начала, это сегодняшняя дата минус месяц
            $date_from = new DateTime(date('Y-m-d'));
            $date_from->modify('-1 month');
            //вычисляем дату конца
            $date_to = new DateTime(date('Y-m-d'));
            $date_to->modify('+ 1 day');
            $date_from_u = $date_from->getTimestamp();
            $date_to_u = $date_to->getTimestamp();
            if (Yii::app()->session->contains('payments_dates')) {
                if (Yii::app()->session->contains('payments_dates'['date_from_u'])) {
                    $date_from_u = Yii::app()->session->get('payments_dates'['date_from_u']);
                }
                if (Yii::app()->session->contains('payments_dates'['date_to_u'])) {
                    $date_to_u = Yii::app()->session->get('payments_dates'['date_to_u']);
                }
            }
        }

        $count = Yii::app()->db->createCommand($sqlCount)->queryScalar(
          [
            ':uid'       => $uid,
            ':date_from' => $date_from_u,
            ':date_to'   => $date_to_u,
          ]
        );

        $payments = new CSqlDataProvider(
          $sqlSelect, [
            'params'         => [
              ':uid'       => $uid,
              ':date_from' => $date_from_u,
              ':date_to'   => $date_to_u,
            ],
            'id'             => 'U_payments_dataProvider',
            'keyField'       => 'id',
            'totalItemCount' => $count,
            'pagination'     => [
              'pageSize' => 50,
            ],
          ]
        );
        $render = [
          'payments'  => $payments,
          'date_from' => date('Y-m-d', $date_from_u),
          'date_to'   => date('Y-m-d', $date_to_u),
        ];
        $this->render('webroot.themes.' . $this->frontTheme . '.views.cabinet.balance', $render);
    }

    public function actionOrder($oid, $paysystem = false)
    {
        $order = Order::model()->findByPk($oid);
        if (!$order) {
            Yii::app()->user->setFlash('user', Yii::t('main', 'Такого заказа не существует!'));
            $this->redirect('/cabinet');
        }
        $checkPaySystem = PaySystems::getModelByType($paysystem);
        if ($paysystem && !$checkPaySystem) {
            Yii::app()->user->setFlash('user', Yii::t('main', 'Была выбрана недопустимая платёжная система!'));
            $this->redirect('/cabinet/orders/view/id/' . $oid);
        }
        $balance = Users::getBalance(Yii::app()->user->id);
        $orderSum = ($order->manual_sum) ? $order->manual_sum : $order->sum;
        $orderDelivery = ($order->manual_delivery) ? $order->manual_delivery : $order->delivery;
        $orderPayed = OrdersPayments::getPaymentsSumForOrder($order->id);
        $paymentSum = Formulas::cRound($orderDelivery + $orderSum - $orderPayed, DSConfig::getSiteCurrency());
        if (($orderPayed <= 0)) {
            $paymentDescription = Yii::t('main', 'Оплата заказа') . ' №' . $oid;
        } else {
            $paymentDescription = Yii::t('main', 'Доплата по заказу') . ' № ' . $oid;
        }

        if ($paymentSum > $balance && !$paysystem) {
            Yii::app()->user->setFlash('user', Yii::t('main', 'На вашем счету недостаточно средств!'));
        } else {
            if (OrdersPayments::payForOrder($oid, $paymentSum, $paymentDescription, Yii::app()->user->id, $paysystem)) {
                $notices = UserNotice::model()->findAll('uid=:uid', [':uid' => Yii::app()->user->id]);
                foreach ($notices as $note) {
                    $note->delete();
                }
                Yii::app()->user->setFlash('user', Yii::t('main', 'Заказ оплачен!'));
            }
        }

        if (isset($GLOBALS['_SERVER']['HTTP_REFERER'])) {
            $this->redirect($GLOBALS['_SERVER']['HTTP_REFERER']);
        } else {
            $this->redirect('/cabinet');
        }
    }

    public function actionPayFail($sender = false, $payid = false)
    {
        //$this->logActionCall($sender);

        // Utils::debugLog(CVarDumper::dumpAsString($_POST));
        // $this->logActionCall($sender);

        try {
            /*             * ***************************************************************************** robokassa
             * *********************************************************************** PayFail ********** */
            if ($sender == 'robokassa') {
                if (!(isset($_POST['OutSum']) && isset($_POST['InvId']) && isset($_POST['Shp_item']))) {
                    $this->redirect('/');
                    //throw new CHttpException(404,Yii::t('main','Not Found'));
                }
// чтение параметров
// read parameters
                $sum = $_POST['OutSum'];
                $InvId = $_POST['InvId'];
                $Shp_item = $_POST['Shp_item'];
// проверка корректности подписи
// check signature
                $payment = Payment::model()->findByPk($InvId);
                if ($payment != false) {
                    $payment->status = 4;
                    $payment->description = Yii::t('main', 'Отмена пополнения счёта RoboKassa');
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                    Yii::app()->user->setFlash('payment', Yii::t('main', 'Пополнние счёта отменено'));
                }
                $this->redirect('/cabinet/balance/payment');
            }

            /*             * ***************************************************************************** walletone
             * *********************************************************************** PayFail ********** */
            if ($sender == 'walletone') {

                Yii::app()->user->setFlash(
                  'payment',
                  Yii::t('main', 'Пополнние счёта отменено')
                );
                $this->redirect('/cabinet/balance/index');
            }  // End if walletone
            /*             * ***************************************************************************** PAY-CARD
             * *********************************************************************** PayFail ********** */
            if ($sender == 'paycard') {

                Yii::app()->user->setFlash(
                  'payment',
                  Yii::t('main', 'Пополнние счёта отменено')
                );
                $this->redirect('/cabinet/balance/index');
            }  // End if PAY-CARD
            /*             * ***************************************************************************** ePay
             * *********************************************************************** PayFail ********** */
            if ($sender == 'epay') {
                Yii::app()->user->setFlash(
                  'payment',
                  Yii::t('main', 'Пополнние счёта отменено')
                );
                $this->redirect('/cabinet/balance/index');
            }
            /*             * ***************************************************************************** Z-Payment
             * *********************************************************************** PayFail ********** */
            if ($sender == 'zpayment') {
                /* response
                  Array
                  (
                  [LMI_PAYMENT_NO] => 60
                  [LMI_SYS_INVS_NO] => 7901080
                  [LMI_SYS_TRANS_NO] => 3271930
                  [LMI_SYS_TRANS_DATE] => 20141028 12:38:36
                  [Submit] => Вернуться в магазин
                  )
                 */
                if (isset($_POST['LMI_PAYMENT_NO'])) {
                    $InvId = $_POST['LMI_PAYMENT_NO'];
                    $payment = Payment::model()->findByPk($InvId);

                    if ($payment != false) {
                        Yii::app()->user->setFlash(
                          'payment',
                          Yii::t('main', 'Пополнение счёта отменено')
                        );
                    }
                }

                $this->redirect('/cabinet/balance/index');
            } // zpayment

            /*             * ***************************************************************************** Qiwi
             * *********************************************************************** PayFail ********** */
            if ($sender == 'qiwi') {
                $InvId = $payid;
                $payment = Payment::model()->findByPk($InvId);
                if ($payment != false) {
                    $payment->status = 4;
                    $payment->description = Yii::t('main', 'Отмена пополнения счёта Qiwi');
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;

                    Yii::app()->user->setFlash(
                      'payment',
                      Yii::t('main', 'Пополнение счёта отменено')
                    );
                }
                $this->redirect('/cabinet/balance/index');
            } // Qiwi

            /*             * ***************************************************************************** Pay Master
             * *********************************************************************** PayFail ********** */
            if ($sender == 'paymaster') {

                Utils::debugLog(CVarDumper::dumpAsString($_POST));

                $InvId = $_POST['LMI_PAYMENT_NO'];
                $payment = Payment::model()->findByPk($InvId);
                if ($payment != false) {
                    $payment->status = 4;
                    $payment->description = Yii::t('main', 'Отмена пополнения счёта Pay Master');
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;

                    Yii::app()->user->setFlash(
                      'payment',
                      Yii::t('main', 'Пополнение счёта отменено')
                    );
                }
                $this->redirect('/cabinet/balance/index');
            }
            /*             * ***************************************************************************** OnPay
             * ******************************************************************* PayFail ********** */
            if ($sender == 'onpay') {

                $InvId = $_GET['id'];
                $payment = Payment::model()->findByPk($InvId);
                if ($payment != false) {
                    $payment->status = 4;
                    $payment->description = Yii::t('main', 'Отмена пополнения счёта OnPay');
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;

                    Yii::app()->user->setFlash(
                      'payment',
                      Yii::t('main', 'Пополнение счёта отменено')
                    );
                }
                $this->redirect('/cabinet/balance/index');
            }
            if ($sender == 'yandexkassa') {

                $this->redirect('/cabinet/balance/index');
            }
        } catch (Exception $e) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
    }

    public function actionPayResult($sender = false)
    {
        //Utils::debugLog(CVarDumper::dumpAsString($_SERVER));
        //Utils::debugLog(CVarDumper::dumpAsString($_POST));
        //Utils::debugLog(CVarDumper::dumpAsString($_GET));
        //$this->logActionCall($sender);
        //Utils::debugLog(print_r($_SERVER, true));
        /*         * ***************************************************************************** robokassa
         * ******************************************************************** PayResult ********** */
        if ($sender == 'robokassa') {
            $paySystem = PaySystems::getModelByType($sender);
            $parameters = $paySystem['parameters'];
            $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

            $password2 = (string) $params['Password2'];

// чтение параметров
// read parameters
            $sum = $_POST['OutSum'];
            $InvId = $_POST['InvId'];
            $Shp_item = $_POST['Shp_item'];
            $SignatureValue = strtoupper($_POST["SignatureValue"]);
            $mySignatureValue = strtoupper(md5($sum . ':' . $InvId . ':' . $password2 . ':' . 'Shp_item=' . $Shp_item));

// проверка корректности подписи
// check signature
            if ($SignatureValue != $mySignatureValue) {
                echo "bad sign\n"; //.$SignatureValue.' <> '.$mySignatureValue;
                //   echo "<br/>".$sum . ':' . $InvId . ':' . $password2 . ':' . 'Shp_item=' . $Shp_item ;
                Yii::app()->end();
                exit();
            }
//== OK ===================================================
            $payment = Payment::model()->findByPk($InvId);
            if ($payment && ($payment->status != 1)) {
                $payment->status = 1;
                $payment->description = Yii::t('main', 'Зачисление средств robokassa');
                $payment->date = date("Y-m-d H:i:s", time());
                //Yii::app()->db->autoCommit = false;
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($payment->save()) {
                        if ($payment->oid) {
                            OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                        }
                    }
                } catch (Exception $e) {
                    if (isset($transaction) && $transaction && $transaction->active) {
                        $transaction->rollback();
                    }
                    //Yii::app()->db->autoCommit = true;
                    Utils::debugLog(CVarDumper::dumpAsString($e));
                }
                if ($transaction->active) {
                    $transaction->commit();
                }
                //Yii::app()->db->autoCommit = true;
            }
// признак успешно проведенной операции
// success
            echo 'OK' . $InvId . "\n";
            Yii::app()->end();
        }

        /*         * ***************************************************************************** epay
         * ******************************************************************** PayResult ********** */
        if ($sender == 'epay') {

            //Utils::debugLog(CVarDumper::dumpAsString($_POST));

            $this->logActionCall($sender);
            $ENCODED = $_POST['encoded'];
            $CHECKSUM = $_POST['checksum'];
            $data_str = base64_decode($ENCODED);
            $lines_arr = preg_split("/[\r\n]+/s", $data_str);
            $paySystem = PaySystems::getModelByType($sender);
            $parameters = $paySystem['parameters'];
            $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);
            $secret = $params['SecretWord'];
            $hmac = $this->hmac('sha1', $ENCODED, $secret);
            if ($hmac == $CHECKSUM) {
                $info_data = '';
                foreach ($lines_arr as $line) {
                    if (preg_match(
                      "/^INVOICE=(\d+):STATUS=(PAID|DENIED|EXPIRED)(:PAY_TIME=(\d+):STAN=(\d+):BCODE=([0-9a-zA-Z]+))?$/",
                      $line,
                      $regs
                    )) {
                        $invoice = $regs[1];
                        $status = $regs[2];
                        $pay_date = $regs[4];
                        $stan = $regs[5];
                        $bcode = $regs[6];
                        /******************/
                        // Откроем запрс на пополнение
                        $payment = Payment::model()->findByPk($invoice);
                        if (!$payment) {
                            $info_data .= "INVOICE=$invoice:STATUS=NO\n";
                        } else {
                            if ($payment->status == 3) { //Запишем успешное пополнение
                                $payment->date = date("Y-m-d H:i:s", time());
                                if ($status == 'PAID') {
                                    $payment->status = 1;
                                    // RESPONSE FOR ePay
                                    $info_data .= "INVOICE=$invoice:STATUS=OK\n";
                                } else { // или не успешное
                                    $payment->status = 4;
                                    $info_data .= "INVOICE=$invoice:STATUS=OK\n";
                                }
                                $payment->description = Yii::t('main', 'Зачисление средств ePay');
                                $payment->comment = $status; // . ' ' . $bcode . ' ' . $stan;
                                //Yii::app()->db->autoCommit = false;
                                $transaction = Yii::app()->db->beginTransaction();
                                try {
                                    if ($payment->save()) {
                                        if (($payment->status == 1) && $payment->oid) {
                                            OrdersPayments::payForOrder(
                                              $payment->oid,
                                              $payment->sum,
                                              $payment->description
                                            );
                                            if (Yii::app()->language == 'bg') {
                                                $payMessage = cms::customContent(
                                                  'BGOrderCompleteMessage',
                                                  false,
                                                  false,
                                                  false,
                                                  false
                                                );
                                            } else {
                                                $payMessage = Yii::t(
                                                    'main',
                                                    'Вы оплатили заказ на сумму'
                                                  ) . $payment->sum . ' ' . DSConfig::getVal('site_currency');
                                            }
                                            $order = Order::model()->findByPk($payment->oid);
                                            if ($order && isset($order->uid)) {
                                                UserNotice::setFlash($order->uid, $payMessage);
                                            }
                                        }
                                    }
                                } catch (Exception $e) {
                                    if (isset($transaction) && $transaction && $transaction->active) {
                                        $transaction->rollback();
                                    }
                                    //Yii::app()->db->autoCommit = true;
                                    Utils::debugLog(CVarDumper::dumpAsString($e));
                                }
                                if ($transaction->active) {
                                    $transaction->commit();
                                }
                                //Yii::app()->db->autoCommit = true;
                            } else {
                                // RESPONSE FOR ePay
                                $info_data .= "INVOICE=$invoice:STATUS=OK\n";
                            }
                        }
                    } // End:If
                } // End:Foreach
                echo $info_data, "\n";
            } // Enf:If($hmac == $CHECKSUM)
            else {
                echo "ERR=Not valid CHECKSUM\n"; //# XXX The description of error is REQUIRED
            }
        }
        /*         * ***************************************************************************** liqpay
         * ******************************************************************** PayResult ********** */
        if ($sender == 'liqpay') {
            if (!isset($_POST['operation_xml']) || !isset($_POST['signature'])) {
                echo "bad sign\n"; // check needed response
                Yii::app()->end();
            }
            $operation_xml = $_POST['operation_xml'];
            $signature = $_POST['signature'];

            $xml_decoded = base64_decode($operation_xml);
            /*
              <response>
              <version>1.2</version>
              <merchant_id></merchant_id>
              <order_id> ORDER_123456</order_id>
              <amount>1.01</amount>
              <currency>UAH</currency>
              <description>Comment</description>
              <status>success</status>
              <code></code>
              <transaction_id>31</transaction_id>
              <pay_way>card</pay_way>
              <sender_phone>+3801234567890</sender_phone>
              <goods_id>1234</goods_id>
              <pays_count>5</pays_count>
              </response>
              Примечание, по тегам
              merchant_id - id мерчанта
              order_id - id заказа
              amount - стоимость
              currency - Валюта
              description - Описание
              status - статус транзакции
              code - код ошибки (если есть ошибка)
              transaction_id - id транзакции в системе LiqPay
              pay_way - способ которым оплатит покупатель(если не указывать то он сам выбирает, с карты или с телефона(liqpay, card))
              sender_phone - телефон оплативший заказ
              goods_id - id товара в счетчике покупок (если был передан) NEW!
              pays_count - число завершенных покупок данного товара (если был передан goods_id) NEW!

             * Примеры статусов
              status="success" - покупка совершена
              status="failure" - покупка отклонена
              status="wait_secure" - платеж находится на проверке

             */
            $paySystem = PaySystems::getModelByType($sender);
            $parameters = $paySystem['parameters'];
            $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);
            $merchant_sig = (string) $params['merchant_sig'];
            $resp_signature = base64_encode(sha1($merchant_sig . $xml_decoded . $merchant_sig, 1));
            if ($signature != $resp_signature) {
                echo "bad sign\n";
                Yii::app()->end();
                exit();
            }

            $response = (array) simplexml_load_string($xml_decoded, null, LIBXML_NOCDATA);

// чтение параметров
// read parameters
            $InvId = $response['order_id'];
            $payment = Payment::model()->findByPk($InvId);
            if ($payment && ($payment->status != 1)) {
                if ($response['status'] == 'success') {
//== OK ===================================================
                    $payment->status = 1;
                    $payment->description = Yii::t('main', 'Зачисление средств liqpay');
                    $payment->date = date("Y-m-d H:i:s", time());
                    $payment->comment = $xml_decoded;
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($payment->save()) {
                            if ($payment->oid) {
                                OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                            }
                        }
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                    if (Yii::app()->language == 'bg') {
                        $payMessage = cms::customContent('BGOrderCompleteMessage', false, false, false, false);
                    } else {
                        $payMessage = Yii::t(
                            'main',
                            'Вы оплатили заказ на сумму'
                          ) . $payment->sum . ' ' . DSConfig::getVal('site_currency');
                    }
                    Yii::app()->user->setFlash(
                      'payment',
                      $payMessage
                    );
                } else {
                    $payment->status = 4;
                    $payment->description = Yii::t('main', 'Отмена пополнения счёта liqpay');
                    $payment->date = date("Y-m-d H:i:s", time());
                    $payment->comment = $xml_decoded;
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                    Yii::app()->user->setFlash('payment', Yii::t('main', 'Ошибка пополнения счёта') . ' (liqpay)');
                    $this->redirect('/cabinet/balance/payment');
                }
            }
// признак успешно проведенной операции
// success
            echo 'OK' . $InvId . "\n";
            Yii::app()->end();
        }
        // Обработка ответов платежной системы WayForPay (UA)
        /*         * ***************************************************************************** wayforpay
                 * ******************************************************************** PayResult ********** */
        /*
         * 'merchantAccount' => 'trend_tao_com_ua'
            'orderReference' => '57'
            'merchantSignature' => '884636555e57f890c37727a3bd3ca871'
            'amount' => 1.03
            'currency' => 'UAH'
            'authCode' => ''
            'email' => 'simlock@list.ru'
            'phone' => '380631138754'
            'createdDate' => 1494571855
            'processingDate' => 1494571937
            'cardPan' => ''
            'cardType' => null
            'issuerBankCountry' => 'Unknown bank country.'
            'issuerBankName' => 'Unknown bank name.'
            'recToken' => ''
            'transactionStatus' => 'Approved'
            'reason' => 'Ok'
            'reasonCode' => 1100
            'fee' => 0.03
            'paymentSystem' => 'privat24'
            'clientName' => '???? ??????'
         */
        if ($sender == 'wayforpay') {
            //Utils::debugLog(CVarDumper::dumpAsString($_POST));
            $JSON = json_decode(file_get_contents('php://input'), true);
            Utils::debugLog('JSON: ' . CVarDumper::dumpAsString($JSON));
            //Utils::debugLog('POST: ' . CVarDumper::dumpAsString($_POST));

            $paySystem = PaySystems::getModelByType($sender);
            $parameters = $paySystem['parameters'];
            $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

            // проверим корректность подписи
            $controlSign = $JSON['merchantSignature'];
            $calcSign = $JSON['merchantAccount']
              . ';' . $JSON['orderReference']
              . ';' . $JSON['amount']
              . ';' . $JSON['currency']
              . ';' . $JSON['authCode']
              . ';' . $JSON['cardPan']
              . ';' . $JSON['transactionStatus']
              . ';' . $JSON['reasonCode'];

            /*
            .(isset($JSON['merchantDomainName'])?';'.$JSON['merchantDomainName']:'')
            .';'.$JSON['orderReference']
            .(isset($JSON['orderDate'])?';'.$JSON['orderDate']:'')
            .';'.$JSON['amount']
            .';'.$JSON['currency']
            .(isset($JSON['productNamee'])?';'.$JSON['productName']:'');
            */

            $calcSignHash = hash_hmac("md5", $calcSign, $params['SecretWord']);

            //Utils::debugLog($controlSign);
            //Utils::debugLog($calcSignHash);

            $InvId = (int) $JSON['orderReference'];
            //Utils::debugLog($InvId);
            try {
                $payment = Payment::model()->findByPk($InvId);
            } catch (Exception $e) {
                Utils::debugLog($e);
            }
            //$payment = Payment::model()->findByPk($InvId);
            //Utils::debugLog(CVarDumper::dumpAsString($payment));

            if ($payment && ($payment->status != 1)) {

                //Utils::debugLog($controlSign);
                //Utils::debugLog($calcSignHash);

                if (($controlSign == $calcSignHash) && ($JSON['reason'] == 'Ok')) { // Если хэши одинаковые

                    $payment->status = 1;
                    $payment->description = Yii::t('main', 'Зачисление средств WayForPay');
                    $payment->date = date("Y-m-d H:i:s", time());
                    //$payment->oid = $InvId;
                    $payment->comment = date('d-m-Y h:i:s');
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($payment->save()) {
                            if ($payment->oid) {
                                OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                            }
                        }
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                    if (Yii::app()->language == 'bg') {
                        $payMessage = cms::customContent('BGOrderCompleteMessage', false, false, false, false);
                    } else {
                        $payMessage = Yii::t(
                            'main',
                            'Вы оплатили заказ на сумму'
                          ) . $payment->sum . ' ' . DSConfig::getVal('site_currency');
                    }
                    Yii::app()->user->setFlash(
                      'payment',
                      $payMessage
                    );

                    // Ответим что платеж прошел
                    /*
                        {
                        "orderReference":"DH783023",
                        "status":"accept",
                        "time":1415379863,
                        "signature":""
                        }
                    */
                    $re = [];
                    $re['orderReference'] = $InvId;
                    $re['status'] = 'accept';
                    $re['time'] = time();
                    $calcSignRe = $re['orderReference'] . ';' . $re['status'] . ';' . $re['time'];
                    $re['signature'] = hash_hmac("md5", $calcSignRe, $params['SecretWord']);

                    print_r($re);

                } else { // Если хэши не одинаковые
                    // Ответим что платеж не прошел
                    $re = [];
                    $re['orderReference'] = $InvId;
                    $re['status'] = 'falureSign';
                    $re['time'] = time();
                    $calcSignRe = $re['orderReference'] . ';' . $re['status'] . ';' . $re['time'];
                    $re['signature'] = hash_hmac("md5", $calcSignRe, $params['SecretWord']);

                    print_r($re);
                }

            }
            // Если нет заявки на оплату

            $re = [];
            $re['orderReference'] = $InvId;
            $re['status'] = 'UnknownOrder';
            $re['time'] = time();
            $calcSignRe = $re['orderReference'] . ';' . $re['status'] . ';' . $re['time'];
            $re['signature'] = hash_hmac("md5", $calcSignRe, $params['SecretWord']);

            print_r($re);

        }
        /*         ****************************************************************************** Kz Card
         *         ******************************************************************** PayResult ******/
        // Обработка ответов платежной системы PAY-CARD (KZ)
        if ($sender == 'kzcard') {

            //Utils::debugLog(CVarDumper::dumpAsString($_SERVER));
            //Utils::debugLog(CVarDumper::dumpAsString($_POST));
            //$this->logActionCall($sender);
            //Utils::debugLog(CVarDumper::dumpAsString($_REQUEST));
            //Utils::debugLog(print_r($_REQUEST, true));
            //Utils::debugLog(print_r($_SESSION, true));
            //Utils::debugLog(print_r($_GET, true));
            //Utils::debugLog(print_r($_SERVER, true));
            Utils::debugLog(print_r($_REQUEST, true));
            //Utils::debugLog('OK', true);
//===========================================================
            //session_start ();
            include_once(Yii::getPathOfAlias('application.components.WebServiceClient') . '.php');
            //$client = new CNPMerchantWebServiceClient();
            //===============================================
            //require_once ("CNPMerchantWebServiceClient.php");

            if (isset($_REQUEST ["customerReference"]) && $_REQUEST ["customerReference"]) {
                /*
                        * если мы в конце returnURL передали '&customerReference=' (смотрите checkout.php c 37-40 строки, подробнее в тех спец.), то этот параметр customerReference будет дополняться в конце URL адреса в вашем returnURL, по этому берем данные customerReference с url
                        */
                $customerReference = $_REQUEST ["customerReference"];
            } elseif (isset($_SESSION ['customerReference']) && $_SESSION ['customerReference']) {
                /*
                * если все таки, customerReference не передался в конце url, берем данные по нему с сессии
                */
                $customerReference = $_SESSION ['customerReference'];
            } else {
                $customerReference = 0;
            }

            $errors = "";

            $paySystem = PaySystems::getModelByType('kzcard');
            $parameters = $paySystem['parameters'];
            $paySystemParams = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

            $client = new CNPMerchantWebServiceClient (
              $paySystemParams['UrlWsdl'],
              [
                'connection_timeout' => 60,
                'cache_wsdl'         => WSDL_CACHE_MEMORY,
                'trace'              => 1,
                'soap_version'       => 'SOAP 1.2',
                'encoding'           => 'UTF-8',
                'exceptions'         => true,
                'location'           => $paySystemParams['url'],
              ]
            );

            $param = new completeTransaction ();
            $param->merchantId = $paySystemParams['MerchantId'];//"SB0000025900058";
            $param->referenceNr = $customerReference;
            $param->overrideAmount = null;

            if (isset ($_REQUEST ["btn_RequestPayment"]) && is_null($_REQUEST ["btn_RequestPayment"]) === false) {
                $param->transactionSuccess = true;
                if ($client->completeTransaction($param) == false) {
                    $errors = "Settlement request failed.";
                    Utils::debugLog($errors);
                }
            } elseif (isset($_REQUEST["btn_RequestReversal"]) && is_null($_REQUEST["btn_RequestReversal"]) === false) {
                $param->transactionSuccess = false;
                if ($client->completeTransaction($param) == false) {
                    $errors = "Reversal request failed.";
                    Utils::debugLog($errors);
                }
            } else {
                $param->transactionSuccess = true;
                if ($client->completeTransaction($param) == false) {
                    $errors = "Reversal request failed.";
                    Utils::debugLog($errors);
                }
            }

            $params = new getTransactionStatus ();
            $params->merchantId = $paySystemParams['MerchantId'];//"SB0000025900058";
            $params->referenceNr = $customerReference;
            $tranResult = $client->getTransactionStatus($params);

            //Utils::debugLog(print_r($tranResult, true));
            $StoredTransaction = $tranResult->return;

            Utils::debugLog(print_r($StoredTransaction, true));

            //=============================================
            $order_id = $StoredTransaction->orderId;
            //$summ = $tranResult->amountAuthorised;

            $payment = Payment::model()->findByPk($order_id);
            if ($payment && ($payment->status != 1)) {
                if ($StoredTransaction->transactionStatus == 'AUTHORISED') {
                    $payment->status = 3;
                    //$payment->sum = round($summ, 2);
                    $payment->comment = Yii::t('main', 'PROCESSING.kz перевод авторизован банком');
                    //$payment->check_sum = $payment['AMOUNT'];
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                } elseif ($StoredTransaction->transactionStatus == 'REVERSED') {
                    $payment->status = 4;
                    $payment->description = Yii::t(
                      'main',
                      'Платеж PROCESSING.kz был отменен Авторизация была отменена'
                    );
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                } elseif ($StoredTransaction->transactionStatus == 'NO_SUCH_TRANSACTION') {
                    $payment->status = 4;
                    $payment->description = Yii::t(
                      'main',
                      'PROCESSING.kz Транзакция с указанным ID не найдена'
                    );
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                } elseif ($StoredTransaction->transactionStatus == 'PENDING_CUSTOMER_INPUT') {
                    $payment->status = 3;
                    $payment->description = Yii::t(
                      'main',
                      'PROCESSING.kz Ожидание ввода данных карты покупателем на платёжной странице. Т.е. данные еще не введены и не отправлены в банк для авторизации.'
                    );
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                } elseif ($StoredTransaction->transactionStatus == 'DECLINED') {
                    $payment->status = 4;
                    $payment->comment = Yii::t(
                        'main',
                        'PROCESSING.kz Банк отклонил запрос транзакции'
                      ) . ' (' . $payment->status . ')';
                    $payment->description = Yii::t(
                      'main',
                      'PROCESSING.kz Банк отклонил запрос'
                    );
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                        Yii::app()->db->createCommand("UPDATE payments SET status=4 WHERE id=:id")->execute(
                          [':id' => $payment->id]
                        );
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                } elseif ($StoredTransaction->transactionStatus == 'PAID') {
                    $payment->status = 1;
                    $payment->description = Yii::t('main', 'PROCESSING.kz Успешное зачисление');
                    $payment->comment = Yii::t('main', 'PROCESSING.kz Транзакция отправлена для расчета');
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($payment->save()) {
                            if ($payment->oid) {
                                OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                            }
                        }
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                } elseif ($StoredTransaction->transactionStatus == 'REFUNDED') {
                    $payment->status = 4;
                    $payment->description = Yii::t(
                      'main',
                      'PROCESSING.kz Сумма транзакции была частично или полностью возвращена магазином'
                    );
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                } elseif ($StoredTransaction->transactionStatus == 'INVALID_MID') {
                    $payment->status = 3;
                    $payment->description = Yii::t(
                      'main',
                      'PROCESSING.kz Указанный идентификатор ТСП неверный, пожалуйста, свяжитесь со службой поддержки'
                    );
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                } elseif ($StoredTransaction->transactionStatus == 'MID_DISABLED') {
                    $payment->status = 3;
                    $payment->description = Yii::t(
                      'main',
                      'PROCESSING.kz Указанный идентификатор ТСП более не действителен (блокирован), пожалуйста, свяжитесь со службой поддержки'
                    );
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                }
            }
            /*
  1 Зачисление или возврат средств
  2 Снятие средств
  3 Ожидание зачисления средств
  4 Отмена ожидания зачисления средств
  5 Отправка внутреннего перевода средств
  6 Получение внутреннего перевода средств
  7 Зачисление бонуса или прибыли
  8 Вывод средств из системы
*/

            //=============================================

            $params = new getExtendedTransactionStatus ();
            $params->merchantId = $paySystemParams['MerchantId'];//"SB0000025900058";
            $params->referenceNr = $customerReference;
            $extendedTranResult = $client->getExtendedTransactionStatus($params);

            Utils::debugLog(print_r($extendedTranResult, true));

//===========================================================
            if ($errors !== '') {
                Utils::debugLog($errors);
            }
            //echo $errors;
            $this->redirect('/cabinet/balance/index');
            Yii::app()->end();
        }
        /*         * ***************************************************************************** PAY-CARD
         * ******************************************************************** PayResult ********** */
        // Обработка ответов платежной системы PAY-CARD
        if ($sender == 'paycard') {
            $params = $_POST;
            $site_curr = DSConfig::getVal('site_currency');
            if (isset($params['INCOME_CURRENCY'])) {
                $int_curr = strtolower($params['INCOME_CURRENCY']);
            } else {
                $int_curr = $site_curr;
            }
            if (isset($params['ORDER_NR'])) {
                $order_nr = $params['ORDER_NR'];
            }
            /* если валюта платежа не совпадает с валютой сайта пересчитаем сумму пополнения по текущему курсу */
            if ($site_curr !== $int_curr) {
                $SUM = (float) Formulas::convertCurrency($params['AMOUNT'], $int_curr, $site_curr);
            } else {
                $SUM = $params['AMOUNT'];
            }

            // отнимаем коммисию платежной системы
            $SUM = $SUM - 0.4;
            $summ = $SUM / 1.039;

            if (isset($params['STATUS_HASH']) && isset($params['HASH']) && isset($order_nr) &&
              isset($params['STATUS']) && isset($params['STATUS_STRING']) && isset($params['SYSTEM'])
            ) {
                $key = md5(
                  $params['HASH'] . '|' . $params['STATUS'] . '|' . $params['STATUS_STRING'] . '|' . $params['SYSTEM']
                );
                if ($params['STATUS_HASH'] == $key) { // проверяем STATUS_HASH
                    $my_hash = md5(
                      $params['MERCHANT_ID'] . '|' . $params['ORDER_NR'] . '|' . $params['AMOUNT'] .
                      '|' . $params['CURRENCY'] . '|' . $params['SYSTEM'] . '|' . $order_nr
                    );
                    if ($my_hash != $params['HASH']) {
                        $status_hash = md5(
                          "{$params['HASH']}|{$params['STATUS']}|{$params['STATUS_STRING']}|{$params['SYSTEM']}"
                        );
                        if ($params['STATUS_HASH'] == $status_hash) {

                            $ORDER = $params['COEF'];
                            $order_id = $ORDER;

                            $payment = Payment::model()->findByPk($order_id);
                            if ($payment && ($payment->status != 1)) {
                                if ($params['STATUS'] == '1') { //1 – успешно проведён
                                    $payment->status = 1;
                                    $payment->sum = round($summ, 2);
                                    $payment->description = Yii::t('main', 'Зачисление средств PAY-CARD');
                                    //$payment->check_sum = $payment['AMOUNT'];
                                    $payment->date = date("Y-m-d H:i:s", time());
                                    //Yii::app()->db->autoCommit = false;
                                    $transaction = Yii::app()->db->beginTransaction();
                                    try {
                                        if ($payment->save()) {
                                            if ($payment->oid) {
                                                OrdersPayments::payForOrder(
                                                  $payment->oid,
                                                  $payment->sum,
                                                  $payment->description
                                                );
                                            }
                                        }
                                    } catch (Exception $e) {
                                        if (isset($transaction) && $transaction && $transaction->active) {
                                            $transaction->rollback();
                                        }
                                        //Yii::app()->db->autoCommit = true;
                                        Utils::debugLog(CVarDumper::dumpAsString($e));
                                    }
                                    if ($transaction->active) {
                                        $transaction->commit();
                                    }
                                    //Yii::app()->db->autoCommit = true;
                                    //header('OK', true, 200);
                                } elseif ($params['STATUS'] == '2') { //2 – платёж был отменён, по каким либо причинам
                                    $payment->status = 4;
                                    $payment->description = Yii::t(
                                      'main',
                                      'Платеж PAY-CARD был отменен пользователем или платежной системой'
                                    );
                                    $payment->date = date("Y-m-d H:i:s", time());;
                                    //Yii::app()->db->autoCommit = false;
                                    $transaction = Yii::app()->db->beginTransaction();
                                    try {
                                        $payment->save();
                                    } catch (Exception $e) {
                                        if (isset($transaction) && $transaction && $transaction->active) {
                                            $transaction->rollback();
                                        }
                                        //Yii::app()->db->autoCommit = true;
                                        Utils::debugLog(CVarDumper::dumpAsString($e));
                                    }
                                    if ($transaction->active) {
                                        $transaction->commit();
                                    }
                                    //Yii::app()->db->autoCommit = true;
                                    //header('OK', true, 200);
                                } elseif ($params['STATUS'] == '3') { //3 – возникла ошибка при платеже
                                    $payment->status = 4;
                                    $payment->description = Yii::t('main', 'Возникла ошибка при платеже PAY-CARD');
                                    $payment->date = date("Y-m-d H:i:s", time());
                                    //Yii::app()->db->autoCommit = false;
                                    $transaction = Yii::app()->db->beginTransaction();
                                    try {
                                        $payment->save();
                                    } catch (Exception $e) {
                                        if (isset($transaction) && $transaction && $transaction->active) {
                                            $transaction->rollback();
                                        }
                                        //Yii::app()->db->autoCommit = true;
                                        Utils::debugLog(CVarDumper::dumpAsString($e));
                                    }
                                    if ($transaction->active) {
                                        $transaction->commit();
                                    }
                                    //Yii::app()->db->autoCommit = true;
                                    //header('OK', true, 200);
                                }
                            }
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        /*         * ***************************************************************************** yandexmoney
         * ******************************************************************** PayResult ********** */
        if (in_array($sender, ['yandexmoney', 'yandexmoney-card'])) {
            /*  response
              "test_notification":"true",
              "sender":"41001000040",
              "amount":"413.45",
              "operation_id":"test-notification",
              "sha1_hash":"9d46d116251022a8d9aee32684c6bcb57a73a0fa",
              "notification_type":"p2p-incoming",
              "codepro":"false",
              "label":"",
              "datetime":"2014-09-25T12:06:57Z",
              "currency":"643"
              -----------------

              test_notification         - bool - тестовое уведомление
              sender                    - номер счета/кошелька
              amount                    - Сумма операции
              operation_id              - Идентификатор операции в истории счета получателя
              sha1_hash                 - SHA-1 hash параметров уведомления
              notification_type         - "p2p-incoming" -операция с кошельком
              codepro                   - bool - перевод защищен кодом протекции
              label                     - Метка платежа
              datetime                  - дата время перевода
              currency                  - валюта, всегда 643
             */
// Запишем лог ответа
//Utils::debugLog(CVarDumper::dumpAsString($_POST));

            $paySystem = PaySystems::getModelByType($sender);
            $parameters = $paySystem['parameters'];
            $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

            $word = $_POST['notification_type'] . '&' .
              $_POST['operation_id'] . '&' .
              $_POST['amount'] . '&' .
              $_POST['currency'] . '&' .
              $_POST['datetime'] . '&' .
              $_POST['sender'] . '&' .
              $_POST['codepro'] . '&' .
              $params['SecretWord'] . '&' .
              $_POST['label'];

// чтение параметров
// read parameters
            $InvId = $_POST['label'];
            $payment = Payment::model()->findByPk($InvId);
            if ($payment && ($payment->status != 1)) {
                // проверяем хеш
                if ($_POST['sha1_hash'] == sha1($word)) {
//== OK ===================================================
                    $payment->status = 1;
                    $payment->description = Yii::t('main', 'Зачисление средств yandexmoney');
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($payment->save()) {
                            if ($payment->oid) {
                                OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                            }
                        }
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                    Yii::app()->user->setFlash(
                      'payment',
                      Yii::t('main', 'Ваш счёт пополнен на ') . $payment->sum . ' ' .
                      DSConfig::getVal('site_currency')
                    );
                }
            }
            Yii::app()->end();
        }  // End if yandexmoney

        /*         * **************************************************Проверка данных для платежа yandexkassa
         * ******************************************************************** PayResult ********** */

        if ($sender == 'yandexkassa') {
            /*
              <*> request
              -----------------
              requestDatetime - Момент формирования запроса в сервисе Яндекс.Денег.
             *   action - Тип запроса. Значение: checkOrder.
             *   md5 - MD5-хэш параметров платежной формы.
             *   shopId - Идентификатор магазина.
              shopArticleId - Идентификатор товара, выдается в сервисе Яндекс.Денег.
             *   invoiceId - Уникальный номер транзакции в Яндекс.Деньгах.
             *   customerNumber - Идентификатор плательщика на стороне магазина.
              orderCreatedDatetime - Момент регистрации заказа в сервисе Яндекс.Денег.
             *   orderSumAmount - Стоимость заказа.
             *   orderSumCurrencyPaycash - Код валюты для суммы заказа.
             *   orderSumBankPaycash - Код процессингового центра в Яндекс.Деньгах для суммы заказа.
              shopSumAmount - Сумма к выплате на р/с магазина (стоимость заказа минус комиссия Яндекс.Денег).
              shopSumCurrencyPaycash - Код валюты для shopSumAmount.
              shopSumBankPaycash - Код процессингового центра Яндекс.Денег для shopSumAmount.
              paymentPayerCode - Номер счета в Яндекс.Деньгах, с которого производится оплата.
              paymentType - Способ оплаты заказа.
              PC - Оплата из кошелька в Яндекс.Деньгах
              AC - Оплата с произвольной банковской карты
              MC - Платеж со счета мобильного телефона
              GP - Оплата наличными через кассы и терминалы
              WM - Оплата из кошелька в системе WebMoney
              SB - Оплата через Сбербанк: по смс или Сбербанк Онлайн
              MP - Оплата через мобильный терминал (mPOS)
              AB - Оплата через Альфа-Клик
              MA - Оплата через MasterPass
              PB - Оплата через интернет-банк Промсвязьбанка
              QW - Оплата через QIWI Wallet
              KV - Оплата через КупиВкредит (Тинькофф Банк)
              QP - Оплата через Доверительный платеж («Куппи.ру»)
              ------------------
              <*> response
              ------------------
              performedDatetime - Момент обработки запроса по часам в сервисе Яндекс.Денег.
              code - Код результата обработки.
              0 - (Успешно) Магазин дал согласие и готов принять перевод.
              1 - (Ошибка авторизации) Несовпадение значения параметра md5 с результатом расчета хэш-функции.
              100 - (Отказ в приеме перевода) Отказ в приеме перевода с заданными параметрами.
              200 - (Ошибка разбора запроса)Магазин не в состоянии разобрать запрос.
              shopId - Идентификатор магазина. Соответствует значению параметра shopId в запросе.
              invoiceId - Идентификатор транзакции в сервисе Яндекс.Денег.
              Соответствует значению параметра invoiceId в запросе.
              orderSumAmount - Стоимость заказа в валюте, определенной параметром запроса orderSumCurrencyPaycash.
              message - Текстовое пояснение в случае отказа принять платеж.
              techMessage - Дополнительное текстовое пояснение ответа магазина. Как правило, используется как
              дополнительная информация об ошибках. Необязательное поле.
             */
            /* ---------------------
             * формирование хэша md5
             * ---------------------
              action;
              orderSumAmount;
              orderSumCurrencyPaycash;
              orderSumBankPaycash;
              shopId;
              invoiceId;
              customerNumber;
              shopPassword;
             */
            $paySystem = PaySystems::getModelByType($sender);
            $parameters = $paySystem['parameters'];
            $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

            $req = (array) $_POST; // Получаем данные для проверки платежа от Яндекс.Кассы
            // Формируем строку для проверки хэша
            $hash_string = $req['action'] . ';' .
              $req['orderSumAmount'] . ';' .
              $req['orderSumCurrencyPaycash'] . ';' .
              $req['orderSumBankPaycash'] . ';' .
              $params['shopid'] . ';' .
              $req['invoiceId'] . ';' .
              $req['customerNumber'] . ';' .
              $params['shopPassword'];

            $hash_str = md5($hash_string); // Получаем хэш
            $hash = strtoupper($hash_str); // Переводим в верхний регистр

            $payment = Payment::model()->findByPk($req['orderNumber']);

            if ($hash == $req['md5'] && $payment) { // Если хэш совпал с данными
                echo '<checkOrderResponse performedDatetime="' . $req['requestDatetime'] .
                  '" code="0" invoiceId="' . $req['invoiceId'] .
                  '" shopId="' . $params['shopid'] . '"/>';
            } else { // Иначе выдаем ошибку
                $payment = new Payment;
                $payment->status = 4;
                $payment->sum = $req['orderSumAmount'];
                $payment->check_summ = $req['orderSumAmount'];
                $payment->date = date("Y-m-d H:i:s", time());
                $payment->description = Yii::t('main', 'Сбой пополнения счета через Яндекс.Касса');
                $payment->uid = $req['costumerNumber'];
                $payment->manager_id = Yii::app()->user->id;
                if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
                    $payment->oid = $_POST['CabinetForm']['order'];
                }
                //Yii::app()->db->autoCommit = false;
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $payment->save();
                } catch (Exception $e) {
                    if (isset($transaction) && $transaction && $transaction->active) {
                        $transaction->rollback();
                    }
                    //Yii::app()->db->autoCommit = true;
                    Utils::debugLog(CVarDumper::dumpAsString($e));
                }
                if ($transaction->active) {
                    $transaction->commit();
                }
                //Yii::app()->db->autoCommit = true;

                echo '<checkOrderResponse performedDatetime="' . $req['requestDatetime'] .
                  '" code="1" invoiceId="' . $req['invoiceId'] .
                  '" shopId="' . $params['shopid'] .
                  '" message="Переданы неверные данные"' .
                  ' techMessage="Ошибка авторизации"/>';
            }
        }  // End if yandexkassa

        /*         * ***************************************************************************** walletone
         * ******************************************************************** PayResult ********** */
        if ($sender == 'walletone') {
            /*
              $file=fopen("log.txt","a");
              $tmp = date("d.m.Y H:i:s");
              fwrite($file,$tmp."\n");
              $tmp = "REQUEST: ";
              fwrite($file,$tmp.print_r($_REQUEST, 1)."\n");
              $tmp = "==================\n\n";
              fwrite($file,$tmp);
              fclose($file);
             */

            if (isset($_POST['WMI_PAYMENT_NO'])) {
                $paySystem = PaySystems::getModelByType($sender);
                $parameters = $paySystem['parameters'];
                $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

                $InvId = $_POST['WMI_PAYMENT_NO'];
                $payment = Payment::model()->findByPk($InvId);
                if ($payment && ($payment->status != 1)) {
                    if (isset($_POST['WMI_ORDER_STATE'])) {
                        if (isset($_POST['WMI_SIGNATURE'])) {
                            foreach ($_POST as $w1_name => $w1_val) {
                                if ($w1_name !== "WMI_SIGNATURE") {
                                    $w1_par[$w1_name] = $w1_val;
                                }
                            }

                            uksort($w1_par, "strcasecmp");
                            $w1_values = "";
                            foreach ($w1_par as $w1_name1 => $w1_val1) {
//								    $w1_val1 = iconv( "utf-8", "windows-1251", $w1_val1 );
                                $w1_val1 = $this->win2utf($w1_val1, "uw");
                                $w1_values .= $w1_val1;
                            }
                            $signature = base64_encode(pack("H*", md5($w1_values . $params['SecretKey'])));
                            if ($signature == $_POST["WMI_SIGNATURE"]) {

                                if (strtoupper($_POST["WMI_ORDER_STATE"]) == "ACCEPTED") {
                                    $payment->status = 1;
                                    $payment->description = Yii::t('main', 'Зачисление средств Единая касса');
                                    $payment->date = date("Y-m-d H:i:s", time());
                                    //Yii::app()->db->autoCommit = false;
                                    $transaction = Yii::app()->db->beginTransaction();
                                    try {
                                        if ($payment->save()) {
                                            if ($payment->oid) {
                                                OrdersPayments::payForOrder(
                                                  $payment->oid,
                                                  $payment->sum,
                                                  $payment->description
                                                );
                                            }
                                        }
                                    } catch (Exception $e) {
                                        if (isset($transaction) && $transaction && $transaction->active) {
                                            $transaction->rollback();
                                        }
                                        //Yii::app()->db->autoCommit = true;
                                        Utils::debugLog(CVarDumper::dumpAsString($e));
                                    }
                                    if ($transaction->active) {
                                        $transaction->commit();
                                    }
                                    //Yii::app()->db->autoCommit = true;
//									    $this->saveLogTxt( 'ID: ' . $InvId . ', Зачислено' );
                                } else {
                                    $payment->status = 4;
                                    $payment->description = Yii::t('main', 'Отмена пополнения счёта Единая касса');
                                    $payment->date = date("Y-m-d H:i:s", time());
                                    //Yii::app()->db->autoCommit = false;
                                    $transaction = Yii::app()->db->beginTransaction();
                                    try {
                                        $payment->save();
                                    } catch (Exception $e) {
                                        if (isset($transaction) && $transaction && $transaction->active) {
                                            $transaction->rollback();
                                        }
                                        //Yii::app()->db->autoCommit = true;
                                        Utils::debugLog(CVarDumper::dumpAsString($e));
                                    }
                                    if ($transaction->active) {
                                        $transaction->commit();
                                    }
                                    //Yii::app()->db->autoCommit = true;
//									    $this->saveLogTxt( 'ID: ' . $InvId . ', Отменено' );
                                }
                                echo "WMI_RESULT=OK";
                                die();
                            } else {
//								    $this->saveLogTxt( 'ID: ' . $InvId . ', Не верная подпись' );
                                die('MI_RESULT=RETRY&WMI_DESCRIPTION=' . urlencode('Не верная подпись WMI_SIGNATURE'));
                            }
                        } else {
//							    $this->saveLogTxt( 'ID: ' . $InvId . ', Отсутствует параметр WMI_SIGNATURE' );
                            die('WMI_RESULT=RETRY&WMI_DESCRIPTION=' . urlencode('Отсутствует параметр WMI_SIGNATURE'));
                        }
                    } else {
//						    $this->saveLogTxt( 'ID: ' . $InvId . ', Отсутствует параметр WMI_ORDER_STATE' );
                        die('WMI_RESULT=RETRY&WMI_DESCRIPTION=' . urlencode('Отсутствует параметр WMI_ORDER_STATE'));
                    }
                } else {
//					    $this->saveLogTxt( 'ID: ' . $InvId . ', WMI_PAYMENT_NO отсутствует в базе' );
                    die('WMI_RESULT=RETRY&WMI_DESCRIPTION=' . urlencode('WMI_PAYMENT_NO отсутствует в базе'));
                }
            } else {
//				    $this->saveLogTxt( 'ID: нет, Отсутствует параметр WMI_PAYMENT_NO' );
                die('WMI_RESULT=RETRY&WMI_DESCRIPTION=' . urlencode('Отсутствует параметр WMI_PAYMENT_NO'));
            }
        } // End if walletone

        /*         * ***************************************************************************** Z-Payment
         * ******************************************************************** PayResult ********** */
        if ($sender == 'zpayment') {
            /*  response
              Array
              (
              [LMI_PAYEE_PURSE] => 15669
              [LMI_PAYMENT_AMOUNT] => 2.00
              [LMI_PAYMENT_NO] => 60
              [LMI_PAYER_WM] => ZP82586516
              [LMI_SYS_TRANS_NO] => 3271930
              [LMI_MODE] => 0
              [LMI_SYS_INVS_NO] => 7901080
              [LMI_PAYER_PURSE] => ZP82586516
              [LMI_SYS_TRANS_DATE] => 20141028 12:38:36
              [LMI_HASH] => 40150C7372E8945E8A2CBB6C4C870A16
              [ZP_SUMMA_SELLER] => 2.00
              [ZP_CURRENCY_INVOICE] => RUR
              [ZP_TYPE_PAY] => ZP_ZP
              )
             */

            $paySystem = PaySystems::getModelByType('zpayment');
            $parameters = $paySystem['parameters'];
            $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

            $error = false;
            //Проверяем номер магазина
            if ($_POST['LMI_PAYEE_PURSE'] != $params['ZPShopId']) {
                $error = true;
                $err_text = "Id магазина не соответсвует настройкам сайта!";
            }

            if (!$error) {
                // чтение параметров
                // read parameters
                $InvId = $_POST['LMI_PAYMENT_NO'];
                $payment = Payment::model()->findByPk($InvId);
                if ($payment != false) {
                    if ($payment->sum == $_POST['LMI_PAYMENT_AMOUNT']) {
                        //Расчет контрольного хеша из полученных переменных и Ключа мерчанта
                        $CalcHash = md5(
                          $_POST['LMI_PAYEE_PURSE'] .
                          $_POST['LMI_PAYMENT_AMOUNT'] .
                          $_POST['LMI_PAYMENT_NO'] .
                          $_POST['LMI_MODE'] .
                          $_POST['LMI_SYS_INVS_NO'] .
                          $_POST['LMI_SYS_TRANS_NO'] .
                          $_POST['LMI_SYS_TRANS_DATE'] .
                          $params['SecretKey'] .
                          $_POST['LMI_PAYER_PURSE'] .
                          $_POST['LMI_PAYER_WM']
                        );

                        //Сравниваем значение расчетного хеша с полученным
                        if ($_POST['LMI_HASH'] == strtoupper($CalcHash)) {
                            //== OK ===================================================
                            $payment->status = 1;
                            $payment->description = Yii::t('main', 'Зачисление средств zpayment');
                            $payment->date = date("Y-m-d H:i:s", time());
                            //Yii::app()->db->autoCommit = false;
                            $transaction = Yii::app()->db->beginTransaction();
                            try {
                                if ($payment->save()) {
                                    if ($payment->oid) {
                                        OrdersPayments::payForOrder(
                                          $payment->oid,
                                          $payment->sum,
                                          $payment->description
                                        );
                                    }
                                }
                            } catch (Exception $e) {
                                if (isset($transaction) && $transaction && $transaction->active) {
                                    $transaction->rollback();
                                }
                                //Yii::app()->db->autoCommit = true;
                                Utils::debugLog(CVarDumper::dumpAsString($e));
                            }
                            if ($transaction->active) {
                                $transaction->commit();
                            }
                            //Yii::app()->db->autoCommit = true;
                            Yii::app()->user->setFlash(
                              'payment',
                              Yii::t('main', 'Ваш счёт пополнен на ') . $payment->sum . ' ' . DSConfig::getVal(
                                'site_currency'
                              )
                            );
                            $err_text = 'Ваш счёт пополнен на ' . $payment->sum;
                            echo 'YES';
                        } else {
                            $payment->status = 4;
                            $payment->description = Yii::t('main', 'Отмена пополнения счёта zpayment');
                            $payment->date = date("Y-m-d H:i:s", time());
                            //Yii::app()->db->autoCommit = false;
                            $transaction = Yii::app()->db->beginTransaction();
                            try {
                                $payment->save();
                            } catch (Exception $e) {
                                if (isset($transaction) && $transaction && $transaction->active) {
                                    $transaction->rollback();
                                }
                                //Yii::app()->db->autoCommit = true;
                                Utils::debugLog(CVarDumper::dumpAsString($e));
                            }
                            if ($transaction->active) {
                                $transaction->commit();
                            }
                            //Yii::app()->db->autoCommit = true;
                            Yii::app()->user->setFlash(
                              'payment',
                              Yii::t('main', 'Ошибка пополнения счёта') . ' (liqpay)'
                            );
                            $err_text = 'Ошибка пополнения счёта';
                            echo 'YES';
                        }
                    } else {
                        $error = true;
                        $err_text = 'Сумма оплаты не соответсвует сумме заказа!';
                    }
                } else {
                    $error = true;
                    $err_text = 'Номер счета не соответсвует заказу!';
                }
            }
            Yii::app()->end();
        } // zpayment

        /*         * ***************************************************************************** OnPay
         * ******************************************************************** PayResult ********** */
        if ($sender == 'onpay') {
//        $this->saveLogTxt($_GET, 'GET PayResult');
//        $this->saveLogTxt($_POST, 'POST PayResult');
            $InvId = $_POST['pay_for'];
            $payment = Payment::model()->findByPk($InvId);

            if ($payment && ($payment->status != 1)) {

                $paySystem = PaySystems::getModelByType($sender);
                $parameters = $paySystem['parameters'];
                $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

                if ($_POST['type'] == 'check') {
                    /* check;pay_for;order_amount;order_currency;code;secret_key_api_in */
                    $prekey = 'check;' .
                      $InvId . ';' .
                      $_POST['order_amount'] . ';' .
                      $_POST['order_currency'] . ';0;' .
                      $params['SecretKey'];

                    echo 'code=0
pay_for=' . $InvId . '
comment=OK
md5=' . strtoupper(md5($prekey));
                    die();
                } else {
                    if ($_POST['type'] == 'pay') {

                        $payment->status = 1;
                        $payment->description = Yii::t('main', 'Зачисление средств OnPay');
                        $payment->date = date("Y-m-d H:i:s", time());
                        //Yii::app()->db->autoCommit = false;
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            if ($payment->save()) {
                                if ($payment->oid) {
                                    OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                                }
                            }
                        } catch (Exception $e) {
                            if (isset($transaction) && $transaction && $transaction->active) {
                                $transaction->rollback();
                            }
                            //Yii::app()->db->autoCommit = true;
                            Utils::debugLog(CVarDumper::dumpAsString($e));
                        }
                        if ($transaction->active) {
                            $transaction->commit();
                        }
                        //Yii::app()->db->autoCommit = true;

                        /* pay;pay_for;onpay_id;order_id;order_amount;order_currency;code;secret_key */
                        $prekey = 'pay;' .
                          $InvId . ';' .
                          $_POST['onpay_id'] . ';' .
                          $InvId . ';' .
                          $_POST['order_amount'] . ';' .
                          $_POST['order_currency'] . ';0;' .
                          $params['SecretKey'];

                        echo 'code=0
comment=OK
onpay_id=' . $_POST['onpay_id'] . '
pay_for=' . $_POST['pay_for'] . '
order_id=' . $InvId . '
md5=' . strtoupper(md5($prekey));
                        die();
                    } else {
                        echo 'code=1';
                        die();
                    }
                }
            } else {
                echo 'code=1';
                die();
            }
        }
    }

    public function actionPaySuccess($sender = false, $payid = false)
    {
        //$this->logActionCall($sender);

        // Utils::debugLog(CVarDumper::dumpAsString($_POST));
        // $this->logActionCall($sender);
        // Utils::debugLog( print_r( $_SERVER, true ) );

        // robokassa
        try {

            /*             * ***************************************************************************** robokassa
             * ******************************************************************* PaySuccess ********** */
            if ($sender == 'robokassa') {
                if (!(isset($_POST['OutSum']) && isset($_POST['InvId']) && isset($_POST['Shp_item']) &&
                  isset($_POST['SignatureValue']))
                ) {
                    $this->redirect('/');
                    //throw new CHttpException(404,Yii::t('main','Not Found'));
                }
                $paySystem = PaySystems::getModelByType($sender);
                $parameters = $paySystem['parameters'];
                $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

                $password1 = (string) $params['Password1'];

// чтение параметров
// read parameters
                $sum = $_POST['OutSum'];
                $InvId = $_POST['InvId'];
                $Shp_item = $_POST['Shp_item'];
                $SignatureValue = strtoupper($_POST['SignatureValue']);
                $mySignatureValue = strtoupper(
                  md5($sum . ':' . $InvId . ':' . $password1 . ':' . 'Shp_item=' . $Shp_item)
                );

// проверка корректности подписи
// check signature
                if ($SignatureValue == $mySignatureValue) {
                    $payment = Payment::model()->findByPk($InvId);
                    if ($payment != false) {
                        Yii::app()->user->setFlash(
                          'payment',
                          Yii::t('main', 'Ваш счёт пополнен на ') . $payment->sum . ' ' . DSConfig::getVal(
                            'site_currency'
                          )
                        );
                        $this->redirect('/cabinet/balance');
                    }
                } else {
                    Yii::app()->user->setFlash('payment', Yii::t('main', 'Ошибка пополнения счёта'));
                    $this->redirect('/cabinet/balance/payment');
                }
            }

            /*             * ***************************************************************************** liqpay
             * ******************************************************************* PaySuccess ********** */
            if ($sender == 'liqpay') {
                $this->redirect('/cabinet/balance/index');
            }
            /*             * ***************************************************************************** ePay
                         * *********************************************************************** PayFail ********** */
            if ($sender == 'epay') {
                Yii::app()->user->setFlash('payment', Yii::t('main', 'Ошибка пополнения счёта'));
                $this->redirect('/cabinet/balance/payment');
            }

            /*             * ***************************************************************************** walletone
             * ******************************************************************* PaySuccess ********** */
            if ($sender == 'walletone') {

                Yii::app()->user->setFlash(
                  'payment',
                  Yii::t('main', 'Ваш счёт пополнен ')
                );
                $this->redirect('/cabinet/balance/index');
            }  // End if walletone
            /*             * ***************************************************************************** PAY-CARD
             * ******************************************************************* PaySuccess ********** */
            if ($sender == 'paycard') {

                Yii::app()->user->setFlash(
                  'payment',
                  Yii::t('main', 'Ваш счёт пополнен ')
                );
                $this->redirect('/cabinet/balance/index');
            }  // End if PAY-CARD
            /*             * ***************************************************************************** Z-Payment
             * ******************************************************************* PaySuccess ********** */
            // Z-Payment
            if ($sender == 'zpayment') {
                /* response
                  Array
                  (
                  [LMI_PAYMENT_NO] => 60
                  [LMI_SYS_INVS_NO] => 7901080
                  [LMI_SYS_TRANS_NO] => 3271930
                  [LMI_SYS_TRANS_DATE] => 20141028 12:38:36
                  [Submit] => Вернуться в магазин
                  )
                 */
                if (isset($_POST['LMI_PAYMENT_NO'])) {
                    $InvId = $_POST['LMI_PAYMENT_NO'];
                    $payment = Payment::model()->findByPk($InvId);

                    if ($payment != false) {
                        Yii::app()->user->setFlash(
                          'payment',
                          Yii::t('main', 'Ваш счёт пополнен на ') . $payment->sum . ' ' .
                          DSConfig::getVal('site_currency')
                        );
                    }
                }

                $this->redirect('/cabinet/balance/index');
            } // zpayment

            /*             * ***************************************************************************** Qiwi
             * ******************************************************************* PaySuccess ********** */
            if ($sender == 'qiwi') {
                $InvId = $payid;
                $payment = Payment::model()->findByPk($InvId);
                if ($payment && ($payment->status != 1)) {
                    $payment->status = 1;
                    $payment->description = Yii::t('main', 'Зачисление средств Qiwi');
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($payment->save()) {
                            if ($payment->oid) {
                                OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                            }
                        }
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;

                    Yii::app()->user->setFlash(
                      'payment',
                      Yii::t('main', 'Ваш счёт пополнен на ') . $payment->sum . ' ' .
                      DSConfig::getVal('site_currency')
                    );
                }
                $this->redirect('/cabinet/balance/index');
            } // Qiwi

            /*             * ***************************************************************************** Pay Master
             * ******************************************************************* PaySuccess ********** */
            if ($sender == 'paymaster') {
                /*
                 * Array (
                 * [LMI_MERCHANT_ID] => 5fe6 ... 6f1a
                 * [LMI_CURRENCY] => RUB
                 * [LMI_PAYMENT_AMOUNT] => 1.20
                 * [LMI_PAYMENT_NO] => 18
                 * [LMI_SYS_PAYMENT_DATE] => 2015-05-19T17:00:56
                 * [LMI_SYS_PAYMENT_ID] => 30976471
                 * )
                 */

                //$LOG = (string) print_r($_POST, true);
                //Utils::debugLog($LOG);
//var_dump($_POST);
                Utils::debugLog(CVarDumper::dumpAsString($_POST));

                /** ФИКС ДЛЯ ИГОРЯ (ВИДЖЕТ) **/
                if (isset($_POST['CLIENT_ID'])) {
                    $payment = new Payment;
                    $payment->status = 1;
                    $payment->sum = $_POST['LMI_PAYMENT_AMOUNT'];
                    $payment->check_summ =
                      $_POST['LMI_PAYMENT_AMOUNT']; //round($OutSum * DSConfig::model()->findByPk('rate_usd')->value, 2);
                    $payment->date = date("Y-m-d H:i:s", time());
                    $payment->description = Yii::t('main', 'Пополнение через Pay Master');;
                    $payment->uid = $_POST['CLIENT_ID'];
                    $payment->manager_id = Yii::app()->user->id;
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $payment->save();
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;

                }
                /** //ФИКС ДЛЯ ИГОРЯ (ВИДЖЕТ) **/
                //Utils::debugLog( print_r( $_SERVER, true));

                $InvId = $_POST['LMI_PAYMENT_NO'];
                $payment = Payment::model()->findByPk($InvId);

                if ($payment && ($payment->status != 1)) {
                    $payment->status = 1;
                    $payment->description = Yii::t('main', 'Зачисление средств Pay Master');
                    $payment->date = date("Y-m-d H:i:s", time());
                    //Yii::app()->db->autoCommit = false;
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($payment->save()) {
                            if ($payment->oid) {
                                OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                            }
                        }
                    } catch (Exception $e) {
                        if (isset($transaction) && $transaction && $transaction->active) {
                            $transaction->rollback();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Utils::debugLog(CVarDumper::dumpAsString($e));
                    }
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;

                    Yii::app()->user->setFlash(
                      'payment',
                      Yii::t('main', 'Ваш счёт пополнен на ') . $payment->sum . ' ' .
                      DSConfig::getVal('site_currency')
                    );
                }
                $this->redirect('/cabinet/balance/index');
            }

            /*             * ***************************************************************************** OnPay
             * ******************************************************************* PaySuccess ********** */
            if ($sender == 'onpay') {
                $InvId = $_GET['id'];
                $payment = Payment::model()->findByPk($InvId);

                Yii::app()->user->setFlash(
                  'onpay',
                  Yii::t('main', 'Ваш счёт пополнен на ') . $payment->sum . ' ' .
                  DSConfig::getVal('site_currency')
                );
                $this->redirect('/cabinet/balance/index');
            }
            /*             * ***************************************************************************** YandexKassa
             * ******************************************************************* PaySuccess ********** */
            if ($sender == 'yandexkassa') {
                /**
                 * * request
                 * -------------
                 * requestDatetime - Момент формирования запроса в Яндекс.Деньгах.
                 * paymentDatetime - Момент регистрации оплаты заказа в Яндекс.Деньгах.
                 * action - Тип запроса. Значение: paymentAviso
                 * md5 - MD5-хэш параметров платежной формы (правила формирования)
                 * shopId - Идентификатор магазина, выдается Яндекс.Деньгами.
                 * shopArticleId - Идентификатор товара, выдается Яндекс.Деньгами.
                 * invoiceId - Уникальный номер транзакции в сервисе Яндекс.Денег.
                 * orderNumber - Номер заказа в системе магазина. Передается, только если был указан в платежной форме.
                 * customerNumber - Идентификатор плательщика (присланный в платежной форме) на стороне магазина.
                 * orderCreatedDatetime - Момент регистрации заказа в сервисе Яндекс.Денег.
                 * orderSumAmount (CurrencyAmount) - Стоимость заказа.
                 * orderSumCurrencyPaycash
                 * CurrencyCode
                 * orderSumBankPaycash
                 * CurrencyBank
                 * shopSumAmount
                 * CurrencyAmount - Сумма к выплате на счет магазина (стоимость заказа минус комиссия Яндекс.Денег).
                 * shopSumCurrencyPaycash
                 * CurrencyCode - Код валюты для shopSumAmount.
                 * shopSumBankPaycash
                 * CurrencyBank - Код процессингового центра Яндекс.Денег для shopSumAmount.
                 * paymentPayerCode
                 * YMAccount - Номер счета в Яндекс.Деньгах, с которого производится оплата.
                 * paymentType
                 * normalizedString - Способ оплаты заказа. Коды способов оплаты
                 * cps_user_country_code (string, 2 символа) - Двухбуквенный код страны плательщика ISO 3166-1 alpha-2.
                 */
                //Utils::debugLog(CVarDumper::dumpAsString($_POST));

                $ppp = Yii::app()->request->isPostRequest && isset($_POST) && count($_POST);

                $data = $_POST;

                if ($ppp) { // Если переданы данные о платеже
                    $ord_num = $data['orderNumber'];

                    $payment = Payment::model()->findByPk($ord_num); // Получаем запись о заявке из БД
                    // Обновляем данные платежа
                    if ($payment && ($payment->status != 1)) {
                        $payment->status = 1;
                        $payment->date = date("Y-m-d H:i:s", time());
                        $payment->description = Yii::t('main', 'Успешное пополнение через Яндекс.Касса');
                        //Yii::app()->db->autoCommit = false;
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            if ($payment->save()) {
                                if ($payment->oid) {
                                    OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                                }
                            }
                        } catch (Exception $e) {
                            if (isset($transaction) && $transaction && $transaction->active) {
                                $transaction->rollback();
                            }
                            //Yii::app()->db->autoCommit = true;
                            Utils::debugLog(CVarDumper::dumpAsString($e));
                        }
                        if ($transaction->active) {
                            $transaction->commit();
                        }
                        //Yii::app()->db->autoCommit = true;
                    }
                    // Отвечаем о принятии платежа
                    echo '<paymentAvisoResponse performedDatetime="' . $data['paymentDatetime'] .
                      '" code="0" invoiceId="' . $data['invoiceId'] .
                      '" shopId="' . $data['shopId'] . '"/>';
                } else { // Если не можем найти данные о завке на предворительный платеж - откланяем платеж
                    echo '<paymentAvisoResponse performedDatetime="' . $data['paymentDatetime'] .
                      '" code="200" message="Магазин не нашел запроса на платеж"/>';
                }
            } else {
                $this->redirect('/cabinet/balance/index');
            }
        } catch (Exception $e) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
    }

    /*     * **************************************************************************************
     *                                                                  PAY RESULT FUNCTIONS *
     * ************************************************************************************* */

    public function actionPaySuitePay($data = [], $type = 'suitepay')
    {
        $sessflag = false;
        if (Yii::app()->session->contains('sp_data')) {
            $data = Yii::app()->session->get('sp_data');
            $sessflag = true;
        }

        //==========================
        $payment = new Payment;

        if (!$sessflag) {
            $paySystem = PaySystems::getModelByType($type);
            $parameters = $paySystem['parameters'];
            $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);

            $intDefCurrency = 'usd';
            $siteCurrency = DSConfig::getVal('site_currency');
            $intSumm = number_format((float) $data['sum'], 2, '.', '');
            $OutSum = number_format(
              (float) Formulas::convertCurrency($data['sum'], $siteCurrency, $intDefCurrency),
              2,
              '.',
              ''
            );
            if ($OutSum <= 0) {
                Yii::app()->user->setFlash(
                  'payment',
                  Yii::t(
                    'main',
                    'Ошибка: Вы ввели слишком маленькую сумму для пополнения счёта!'
                  )
                );
                return false;
            }

            $data['sum'] = $OutSum;
            $data['intSumm'] = $intSumm;
// ID заказа
            $data['InvId'] = $payment->id;
            $data['site_currency'] = $siteCurrency;
// ID пользователя
            $data['Shp_item'] = Yii::app()->user->id;
            $data['url'] = $params['toUrl'];
            $data['mid'] = $params['MerchantID'];
            $data['devid'] = $params['DevID'];
            $data['pkey'] = $params['PKey'];
            $data['ulogin'] = $params['uLogin'];
        }
        if (isset($_POST['mid'])) {
            $err = [];
            if (!mb_strlen($_POST['cardfullname'], 'UTF-8')) {
                $err['cardfullname'] = Yii::t('main', 'Необходимо заполнить поле "Имя владельца карты"');
            }

            if (!mb_strlen($_POST['creditcard'], 'UTF-8')) {
                $err['creditcard'] = Yii::t('main', 'Необходимо заполнить поле "Номер карты"');
            } else {
                if (!preg_match('%[0-9]+%', $_POST['creditcard'])) {
                    $err['creditcard'] = Yii::t('main', 'В поле "Номер карты" допустимы только цифры');
                }
            }

            if (!mb_strlen($_POST['month'], 'UTF-8')) {
                $err['month'] = Yii::t('main', 'Необходимо заполнить поле "Месяц"');
            } else {
                if (!preg_match('%[0-9]+%', $_POST['month'])) {
                    $err['month'] = Yii::t('main', 'В поле "Месяц" допустимы только цифры');
                }
            }

            if (!mb_strlen($_POST['year'], 'UTF-8')) {
                $err['year'] = Yii::t('main', 'Необходимо заполнить поле "Год"');
            } else {
                if (!preg_match('%[0-9]+%', $_POST['year'])) {
                    $err['year'] = Yii::t('main', 'В поле "Год" допустимы только цифры');
                }
            }

            if (!mb_strlen($_POST['cvv'], 'UTF-8')) {
                $err['cvv'] = Yii::t('main', 'Необходимо заполнить поле "CVV"');
            } else {
                if (!preg_match('%[0-9]+%', $_POST['cvv'])) {
                    $err['cvv'] = Yii::t('main', 'В поле "CVV" допустимы только цифры');
                }
            }

            if (!mb_strlen($_POST['amount'], 'UTF-8')) {
                $err['amount'] = Yii::t('main', 'Необходимо заполнить поле "Сумма"');
            } else {
                if (!preg_match('%[0-9]+%', $_POST['amount'])) {
                    $err['amount'] = Yii::t('main', 'В поле "Сумма" допустимы только цифры');
                }
            }

            if (count($err)) {
                $data['form_err'] = json_encode($err);
            } else {
                unset($data['form_err']);
                $data['sum'] = $_POST['amount'];

                $payment->status = 3;
                $payment->sum = $data['intSumm'];
                $payment->check_summ = $data['sum'];
                $payment->date = date("Y-m-d H:i:s", time());
                $payment->description = Yii::t('main', 'Заявка на пополнение SuitePay');
                $payment->uid = Yii::app()->user->id;
                $payment->manager_id = Yii::app()->user->id;
                if (isset($_POST['CabinetForm']['order']) && $_POST['CabinetForm']['order']) {
                    $payment->oid = $_POST['CabinetForm']['order'];
                }
                //Yii::app()->db->autoCommit = false;
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $payment->save();
                } catch (Exception $e) {
                    if (isset($transaction) && $transaction && $transaction->active) {
                        $transaction->rollback();
                    }
                    //Yii::app()->db->autoCommit = true;
                    Utils::debugLog(CVarDumper::dumpAsString($e));
                }
                if ($transaction->active) {
                    $transaction->commit();
                }
                //Yii::app()->db->autoCommit = true;

                $data['InvId'] = $payment->id;

                $tosend = json_encode(
                  [
                    'user_login'       => $data['ulogin'],
                    'public_key'       => $data['pkey'],
                    'developerid'      => $data['devid'],
                    'transaction_data' => [
                      'mid'          => $data['mid'],
                      'creditcard'   => $_POST['creditcard'],
                      'cardfullname' => $_POST['cardfullname'],
                      'cvv'          => $_POST['cvv'],
                      'currency'     => 'USD',
                      'month'        => $_POST['month'],
                      'year'         => $_POST['year'],
                        /// must be a unique number each time a sale is done
                      'orderid'      => $data['InvId'],
                      'amount'       => $data['sum'],
                    ],
                  ]
                );

                // qa.suitepay.com for testing and api.suitepay.com for the live
//        $curlURL = "https://qa.suitepay.com/api/v2/card/sale2/";
                $curlURL = "https://api.suitepay.com/api/v2/card/sale2/";

                $ch = curl_init($curlURL);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $tosend);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSLVERSION, 1);
                curl_setopt($ch, CURLOPT_SSLVERSION, 1);

//         curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

                $payErr = false;
                $paymsg = '';
                try {
                    $response = curl_exec($ch);
                    $arresult = json_decode($response, true);
                    $ce = curl_errno($ch);
                    if ($ce) { //error
                        $payErr = true;
                        $paymsg = Yii::t('main',
                          'В процессе выполнения платежа SuitePay возникла ошибка {cerr}',
                          [
                            '{cerr}' => $ce,
                          ]
                        );
                    } else {
                        if ($arresult['status'] == 'approved') {
                            $payErr = false;
                            $paymsg = Yii::t('main',
                              'Ваш счет пополнен на ${csum}. SuitePay код транзакции {ctrans}',
                              [
                                '{csum}'   => $data['sum'],
                                '{ctrans}' => $arresult['transaction_id'],
                              ]
                            );
                        } else {
                            if ($arresult['status'] == 'declined') {
                                $payErr = true;
                                $paymsg = Yii::t('main',
                                  'SuitePay выполнение платежа отколнено по причине: {cerr}',
                                  [
                                    '{cerr}' => $arresult['code'],
                                  ]
                                );
                            } else {
                                $payErr = true;
                                $paymsg = Yii::t('main',
                                  'SuitePay в процессе выполнения платежа возникла ошибка {cerr}',
                                  [
                                    '{cerr}' => $arresult['code'],
                                  ]
                                );
                            }
                        }
                    }

                    curl_close($ch);
                } catch (Exception $e) {
                    $payErr = true;
                    $paymsg = Yii::t('main', 'SuitePay в процессе выполнения платежа возникла неизвестная ошибка');
                }

                if ($payErr) {
                    $payment = Payment::model()->findByPk($data['InvId']);
                    if ($payment != false) {
                        $payment->status = 4;
                        $payment->description = $paymsg;
                        $payment->date = date("Y-m-d H:i:s", time());
                        //Yii::app()->db->autoCommit = false;
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            $payment->save();
                        } catch (Exception $e) {
                            if (isset($transaction) && $transaction && $transaction->active) {
                                $transaction->rollback();
                            }
                            //Yii::app()->db->autoCommit = true;
                            Utils::debugLog(CVarDumper::dumpAsString($e));
                        }
                        if ($transaction->active) {
                            $transaction->commit();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Yii::app()->user->setFlash('payment', $paymsg);
                    }
                    $this->redirect('/cabinet/balance/payment');
                } else {
                    $payment = Payment::model()->findByPk($data['InvId']);
                    if ($payment && ($payment->status != 1)) {
                        $payment->status = 1;
                        $payment->description = $paymsg;
                        $payment->date = date("Y-m-d H:i:s", time());
                        //Yii::app()->db->autoCommit = false;
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            if ($payment->save()) {
                                if ($payment->oid) {
                                    OrdersPayments::payForOrder($payment->oid, $payment->sum, $payment->description);
                                }
                            }
                        } catch (Exception $e) {
                            if (isset($transaction) && $transaction && $transaction->active) {
                                $transaction->rollback();
                            }
                            //Yii::app()->db->autoCommit = true;
                            Utils::debugLog(CVarDumper::dumpAsString($e));
                        }
                        if ($transaction->active) {
                            $transaction->commit();
                        }
                        //Yii::app()->db->autoCommit = true;
                        Yii::app()->user->setFlash('payment', $paymsg);
                    }
                    $this->redirect('/cabinet/balance/index');
                }
            }
        }
        Yii::app()->session->add('sp_data', $data);

        $this->pageTitle = 'Пополнить счет';
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy') . '.php'
        )) {
            $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online_easy',
              ['data' => $data, 'type' => $type]
            );
            Yii::app()->end();
        } else {
            $this->render(
              'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment_online',
              ['data' => $data, 'type' => $type, 'pst' => json_encode($_POST)]
            );
        }
        return true;
    }

    function actionPayment($sum = false, $order = false, $user = false, $paysystem = false, $sig = false)
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Пополнить счет');
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];

        $model = new CabinetForm('payment');
        if (!$user) {
            $user = Yii::app()->user->id;
        }
        if ($user) {
            $userModel = Users::model()->findByPk($user);
            $model->attributes = $userModel->attributes;
            $model->publicAccount = Yii::app()->user->getPersonalAccount();
        }
//==== EasyPayment =====================================================================================================
        if ($sum && $order && $user && $paysystem && $sig) {
            $signature = md5($sum . $user . $order . $paysystem . Yii::app()->id);
            if ($sig === $signature) {
                $this->easyPayment = true;
                $orderModel = Order::model()->findByPk($order);
                $orderAddressModel = Addresses::model()->findByPk($orderModel->addresses_id);
                if ($userModel->phone) {
                    $phone = $userModel->phone;
                } elseif ($orderAddressModel && $orderAddressModel->phone) {
                    $phone = $orderAddressModel->phone;
                } else {
                    $phone = 'undefined';
                }
                $_POST['preference'] = $paysystem;
                $_POST['CabinetForm'] = [
                  'sum'   => $sum,
                  'phone' => $phone,
                  'order' => $order,
                ];
            }
        }
//======================================================================================================================
// Разбор paySystem на предмет содержания id в формате paySystem[id]
        if (isset($_POST['preference']) && preg_match('/^(.+?)\[(\d+)\]/s', $_POST['preference'], $matches)) {
            $_paySystemForSearch = $_POST['preference'];
            $_POST['preference'] = $matches[1];
            $_paySystem = $matches[1];
            $_paySystemId = $matches[2];
        } elseif (isset($_POST['preference'])) {
            $_paySystemForSearch = $_POST['preference'];
            $_paySystem = $_POST['preference'];
            $_paySystemId = null;
        }
//======================================================================================================================
// Блок оформления платежей
//======================================================================================================================
        // Проверяем запрос к АПИ терминалов КИВИ (казахстан)
        if (isset($_GET['txn_id'])
          && in_array(
            $_SERVER['REMOTE_ADDR'],
            [
              '31.40.142.6',
              '31.40.142.206',
              '31.40.142.209',
              '89.218.54.34',
              '89.218.54.36',
              '212.154.215.82',
              '79.142.55.227',
              '79.142.55.231',
            ]
          )
        ) {
            // Проверка на доставероность IP
            $this->payQiwiKz($_GET, 'qiwikz');
            return;
        }
        // Проверяем, АПИ это вобще, или нет
        if (isset($_POST['login_ps'])) {
            $this->payApiterminal($_POST, 'apiterminal');
            return;
        }
        if (isset($_POST['CabinetForm'])) {
            $model->attributes = $_POST['CabinetForm'];
            $model->sum = (float) strtr($model->sum, [',' => '.']);
            if (isset($_POST['preference']) && isset($_paySystem) && isset($_paySystemForSearch) && $model->validate()
            ) {
                $model_array = [];
                foreach ($model as $i => $v) {
                    $model_array[$i] = $v;
                }
                switch ($_paySystem) {
                    case in_array($_paySystem, ['cash', 'sber-offline']):
                        if ($this->payCash($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'robokassa':
                        if ($this->payRobokassa($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'liqpay':
                        if ($this->payLiqpay($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'wayforpay':
                        if ($this->payWayforpay($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'order':
                        if ($this->payOrder($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'order_alt':
                        if ($this->payOrder($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'webmoney':
                        if ($this->payWebmoney($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'qiwi':
                        if ($this->payQiwi($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'qiwikz':
                        if ($this->payQiwiKz($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'kzcard':
                        if ($this->payKzCard($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'paypal':
                        if ($this->payPaypal($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'yandexmoney':
                        if ($this->payYandexmoney($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'yandexmoney-card':
                        if ($this->payYandexmoney($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'yandexkassa':
                        if ($this->payYandexkassa($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'payсard':
                        if ($this->payPaycard($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'walletone':
                        if ($this->payWalletone($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'zpayment':
                        if ($this->payZpayment($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'paymaster':
                        if ($this->payPayMaster($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'onpay':
                        if ($this->payOnPay($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'epay':
                        if ($this->payEpay($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    case 'suitepay':
                        if (Yii::app()->session->contains('sp_data')) {
                            Yii::app()->session->remove('sp_data');
                        }

                        if ($this->actionPaySuitePay($model_array, $_paySystemForSearch)) {
                            return;
                        }
                        break;
                    default:
                        Yii::app()->user->setFlash(
                          'payment',
                          Yii::t('main', 'Ошибка: Выбранная Вами платёжная система не обслуживается!')
                        );
                }
            } else {
                //print_r($model); die;
                if (!isset($_POST['preference']) || !isset($_paySystem) || !isset($_paySystemForSearch)) {
                    $message = 'Ошибка: Не выбрана платежная система';
                } elseif (!$model->validate()) {
                    $message = 'Ошибка: Не верно указаны параметры платежа или вход в систему не произведен.
                    ' . CVarDumper::dumpAsString($model->errors);
                } else {
                    $message = 'Ошибка: Не верно указана сумма платежа';
                }
                Yii::app()->user->setFlash(
                  'payment',
                  Yii::t(
                    'main',
                    $message
                  )
                );
            }
        }
//======================================================================================================================
// Блок оформления платежей - конец
//======================================================================================================================
// default rendering
        if ($sum) {
            $model->sum = $sum;
        } else {
            $model->sum = 100;
        }
        // рендерим представление
        $paySystems = PaySystems::model()->findAll(
          "enabled=1 order by SUBSTRING(parameters, '<sortorder>(.*?)<\/sortorder>'),id"
        );
        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.payment',
          ['model' => $model, 'check' => false, 'paySystems' => $paySystems]
        );
    }

    public function actionReadSer($id = 0)
    {
        $res = PaySystemsLog::model()->findByPk($id);
        $data = unserialize($res['data']);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }

    function actionStatement()
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Информация о счете');
        $this->render('webroot.themes.' . $this->frontTheme . '.views.cabinet.statement', []);
    }

    function actionTransfer()
    {

        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Перевод денег на другой счет');
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];

        $model = new AccountForm('transfer');
        $form = new CForm(
          [
            'elements' => [
              'id_account' => [
                'type'      => 'text',
                'maxlength' => 128,
                'class'     => 'form-control input3',
              ],
              'summ'       => [
                'type'      => 'text',
                'maxlength' => 128,
                'class'     => 'form-control input3',
              ],
              'password'   => [
                'type'      => 'password',
                'maxlength' => 128,
                'class'     => 'form-control input3',
              ],
            ],
            'buttons'  => [
              'submit' => [
                'type'  => 'submit',
                'class' => 'btn btn-success button-transfer pull-right',
                'style' => '',
                'label' => Yii::t('main', 'Перевести деньги'),
              ],
            ],
          ], $model
        );

        if (isset($_POST['AccountForm'])) {
            $model->attributes = $_POST['AccountForm'];
            $post_summ = 0;
            $destUid = Yii::app()->user->id;
            if ($model->validate()) {
                $flag_error = false;
                $identity = new UserIdentity(Yii::app()->user->email, $_POST['AccountForm']['password']);
                if (!$identity->authenticate()) {
                    $flag_error = Yii::t('main', 'Вы ошиблись при вводе пароля - повторите');
                } else {
                    $destUid = Yii::app()->user->getIdByPersonalAccount($_POST['AccountForm']['id_account']);
                    $destUser = Users::model()->findByPk($destUid);

                    if (is_null($destUid) || is_null($destUser)) {
                        $flag_error = Yii::t('main', 'Не существует пользователя с таким персональным счетом');
                    }
                    if ($destUid == Yii::app()->user->id) {
                        $flag_error = Yii::t('main', 'Нельзя делать перевод на свой собственный счет');
                    }
                    if (!$flag_error) {
                        $available_funds = Users::getBalance(Yii::app()->user->id);
                        $post_summ = str_replace(',', '.', $_POST['AccountForm']['summ']);
                        if ($available_funds < (float) $_POST['AccountForm']['summ']) {
                            $flag_error = Yii::t(
                              'main',
                              'Ваш баланс не должен быть меньше суммы, которую Вы хотите перевести'
                            );
                        }
                    }
                }
                if ($flag_error) {
                    Yii::app()->user->setFlash(
                      'transfer',
                      Yii::t('main', 'Ошибка') . ': ' . $flag_error
                    );
                } else {
                    $payment_from = new Payment;
                    $payment_from->sum = floatval(-1 * $post_summ);
                    $payment_from->check_summ =
                      $payment_from->sum; // = -1 * Formulas::convertCurrency($post_summ, DSConfig::getVal('site_currency'), 'rur');
                    $payment_from->date = date("Y-m-d H:i:s", time());
                    $payment_from->description = Yii::t(
                        'main',
                        'Перевод денег на счет'
                      ) . ' №' . $_POST['AccountForm']['id_account'];
                    $payment_from->uid = Yii::app()->user->id;
                    $payment_from->status = 5;
                    $payment_from->save();

                    $payment_to = new Payment;
                    $payment_to->sum = floatval($post_summ);
                    $payment_to->check_summ =
                      $payment_to->sum; //Formulas::convertCurrency($post_summ, DSConfig::getVal('site_currency'), 'rur');
                    $payment_to->date = date("Y-m-d H:i:s", time());
                    $payment_to->description =
                      Yii::t('main', 'Получение денег со счета') . ' №' . Yii::app()->user->getPersonalAccount();
                    $payment_to->uid = $destUid;
                    $payment_to->manager_id = Yii::app()->user->id;
                    $payment_to->status = 6;
                    $payment_to->save();

                    Yii::app()->user->setFlash(
                      'transfer',
                      Yii::t('main', 'Перевод успешно осуществлен')
                    );

                    $this->redirect('/cabinet/balance/transfer');
                }
            }
        }

        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.transfer',
          ['model' => $model, 'form' => $form]
        );
    }

    /*
     * Подсчет контрольной суммы для ePay.bg
     */

    public function filters()
    {
        return array_merge(
          [
            'Rights', // perform access control for CRUD operations
          ],
          parent::filters()
        );
    }

    public function saveLogTxt($data, $func = '')
    {
        $file = fopen("log.txt", "a");
        if ($func) {
            $tmp = "** $func **: " . date("d.m.Y H:i:s");
        } else {
            $tmp = date("d.m.Y H:i:s");
        }
        fwrite($file, $tmp . "\n");
        $tmp = "data: ";
        fwrite($file, print_r($data, true) . "\n");
        $tmp = "==================\n\n";
        fwrite($file, $tmp);
        fclose($file);
    }

//==================================================================

}