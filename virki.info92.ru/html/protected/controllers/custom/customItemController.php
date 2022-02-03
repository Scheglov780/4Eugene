<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ItemController.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/*
 * Контроллер для работы с товаром.
 */

class customItemController extends CustomFrontController
{
    public $body_class = 'item';
    public $columns = 'two-col';
    public $defaultAction = 'index';
    /**
     * @var Item|boolean Собственно, Item
     */
    public $item = false;
    public $preLoading = false;

    private function export($exportType)
    {
        //TODO: Дичь, нет класса XML/Serializer.php
        header('Access-Control-Allow-Origin: *');
        if ($exportType == 'XML') {
//====================================
            $item2xml = $this->item->topItem;
            header('Content-Type: application/xml');
            //TODO: Дичь, не объявлена переменная $iid
            $filename = 'DSGItem-' . $iid . '.xml';
            header('Content-Disposition: attachment; charset=UTF-8; filename="' . $filename . '"');
            require_once 'XML/Serializer.php';
            $options = [
              XML_SERIALIZER_OPTION_INDENT               => '  ',
              XML_SERIALIZER_OPTION_LINEBREAKS           => "\n",
//        XML_SERIALIZER_OPTION_DEFAULT_TAG          => 'unnamedItem',
              XML_SERIALIZER_OPTION_SCALAR_AS_ATTRIBUTES => false,
              XML_SERIALIZER_OPTION_ATTRIBUTES_KEY       => '_attributes',
              XML_SERIALIZER_OPTION_CONTENT_KEY          => '_content',
              'addDecl'                                  => true,
              'encoding'                                 => 'utf-8',
              'rootName'                                 => 'DSGItem',
              'mode'                                     => 'simplexml',
            ];
            $serializer = new XML_Serializer($options);
            $result = $serializer->serialize($item2xml);
            if ($result === true) {
                $xml = $serializer->getSerializedData();
                echo $xml;
            } else {
                CVarDumper::dump($result, 1, true);
            }
            Yii::app()->end();
        } elseif ($exportType == 'CSV') {
//====================================
            $item2csv = $this->item->topItem;
            $result = [
              'num_iid'                    => [],
              'seller_id'                  => [],
              'shop_id'                    => [],
              'price'                      => [],
              'promotion_price'            => [],
              'delivery'                   => [],
              'num'                        => [],
              'title'                      => [],
              'desc'                       => [],
              'pic_url'                    => [],
              'item_imgs'                  => [], // список img
              'item_attributes'            => [], //список ul-li
              'skus->sku->sku_id'          => [],
              'skus->sku->quantity'        => [],
              'skus->sku->price'           => [],
              'skus->sku->promotion_price' => [],
              'skus->sku->properties'      => [],
            ];
            $result['num_iid'][] = $item2csv->num_iid;
            $result['seller_id'][] = $item2csv->seller_id;
            $result['shop_id'][] = $item2csv->shop_id;
            $result['price'][] = $item2csv->price;
            $result['promotion_price'][] = $item2csv->promotion_price;
            $result['delivery'][] = $item2csv->express_fee;
            $result['num'][] = $item2csv->num;
            $result['title'][] = Yii::app()->DVTranslator->translateLocal($item2csv->_title);
            $result['desc'][] = '';
            $result['pic_url'][] = $item2csv->pic_url;
            $item_imgs = '';
            if ((is_array($item2csv->_item_imgs->item_img) || $item2csv->_item_imgs->item_img instanceof ArrayAccess) &&
              (count($item2csv->_item_imgs->item_img) > 0)) {
                foreach ($item2csv->_item_imgs->item_img as $item_img) {
                    $item_imgs = $item_imgs . '<img src="' . $item_img->url . '"/>';
                }
            }
            $result['item_imgs'][] = $item_imgs;
            $item_attributes = '<dl>';
            if ((is_array($item2csv->_item_attributes) || $item2csv->_item_attributes instanceof ArrayAccess) &&
              (count($item2csv->_item_attributes) > 0)) {
                foreach ($item2csv->_item_attributes as $attr) {
                    $item_attributes = $item_attributes . '<dt>' . Yii::app()->DVTranslator->translateLocal(
                        $attr->prop
                      ) .
                      '</dt><dd>' . Yii::app()->DVTranslator->translateLocal($attr->val) . '</dd>';
                }
            }
            $result['item_attributes'][] = $item_attributes . '</dl>';

            if (isset($item2csv->_skus->sku[0])) {
                $result['skus->sku->sku_id'][] = $item2csv->_skus->sku[0]->sku_id;
                $result['skus->sku->quantity'][] = $item2csv->_skus->sku[0]->quantity;
                $result['skus->sku->price'][] = $item2csv->_skus->sku[0]->price;
                $result['skus->sku->promotion_price'][] = $item2csv->_skus->sku[0]->promotion_price;
//======================
                $properties = '<dl>';
                $propsArray = explode(';', $item2csv->_skus->sku[0]->properties);
                if (is_array($propsArray) && (count($propsArray) > 0)) {
                    foreach ($propsArray as $attr) {
                        unset($pv);
                        unset($prop);
                        unset ($val);
                        $pv = explode(':', $attr);
                        if (isset($pv[0]) && isset($pv[1])) {
                            if (isset($item2csv->_props[$pv[0]])) {
                                if (isset($item2csv->_props[$pv[0]]->childs)) {
                                    foreach ($item2csv->_props[$pv[0]]->childs as $child) {
                                        if ($child->vid == $pv[1]) {
                                            $prop = $item2csv->_props[$pv[0]]->name;
                                            $val = $child->name;
                                        }
                                    }
                                }

                            }
                            if (isset($prop) && isset($val)) {
                                $properties =
                                  $properties .
                                  '<dt id="' .
                                  $pv[0] .
                                  '">' .
                                  Yii::app()->DVTranslator->translateLocal($prop) .
                                  '</dt><dd id="' .
                                  $pv[1] .
                                  '">' .
                                  Yii::app()->DVTranslator->translateLocal(
                                    $val
                                  ) .
                                  '</dd>';
                            }
                        }
                    }
                }
                $result['skus->sku->properties'][] = $properties . '</dl>';
//======================
            } else {
                $result['skus->sku->sku_id'][] = '';
                $result['skus->sku->quantity'][] = '';
                $result['skus->sku->price'][] = '';
                $result['skus->sku->promotion_price'][] = '';
                $result['skus->sku->properties'][] = '';
            }
            foreach ($item2csv->_skus->sku as $i_sku => $sku) {
                if ($i_sku == 0) {
                    continue;
                }
                $result['num_iid'][] = $item2csv->num_iid;
                $result['seller_id'][] = '';
                $result['shop_id'][] = '';
                $result['price'][] = '';
                $result['promotion_price'][] = '';
                $result['delivery'][] = '';
                $result['num'][] = '';
                $result['title'][] = '';
                $result['desc'][] = '';
                $result['pic_url'][] = '';
                $result['item_imgs'][] = '';
                $result['item_attributes'][] = '';
                $result['skus->sku->sku_id'][] = $sku->sku_id;
                $result['skus->sku->quantity'][] = $sku->quantity;
                $result['skus->sku->price'][] = $sku->price;
                $result['skus->sku->promotion_price'][] = $sku->promotion_price;
//======================
                $properties = '<dl>';
                $propsArray = explode(';', $sku->properties);
                if (is_array($propsArray) && (count($propsArray) > 0)) {
                    foreach ($propsArray as $attr) {
                        unset($pv);
                        unset($prop);
                        unset ($val);
                        $pv = explode(':', $attr);
                        if (isset($pv[0]) && isset($pv[1])) {
                            if (isset($item2csv->_props[$pv[0]])) {
                                if (isset($item2csv->_props[$pv[0]]->childs)) {
                                    foreach ($item2csv->_props[$pv[0]]->childs as $child) {
                                        if ($child->vid == $pv[1]) {
                                            $prop = $item2csv->_props[$pv[0]]->name;
                                            $val = $child->name;
                                        }
                                    }
                                }

                            }
                            if (isset($prop) && isset($val)) {
                                $properties =
                                  $properties .
                                  '<dt id="' .
                                  $pv[0] .
                                  '">' .
                                  Yii::app()->DVTranslator->translateLocal($prop) .
                                  '</dt><dd id="' .
                                  $pv[1] .
                                  '">' .
                                  Yii::app()->DVTranslator->translateLocal(
                                    $val
                                  ) .
                                  '</dd>';
                            }
                        }
                    }
                }
                $result['skus->sku->properties'][] = $properties . '</dl>';
//======================
            }
            $csvarray = [];
            foreach ($result as $i_res => $res) {
                if (isset($csvarray[0])) {
                    $csvarray[0] = $csvarray[0] . '"' . $i_res . '";';
                } else {
                    $csvarray[0] = '"' . $i_res . '";';
                }
                foreach ($res as $i_str => $str) {
                    if (isset($csvarray[1 + $i_str])) {
                        $csvarray[1 + $i_str] = $csvarray[1 + $i_str] . '"' . $str . '";';
                    } else {
                        $csvarray[1 + $i_str] = '"' . $str . '";';
                    }
                }
            }
//=================
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            //TODO: Дичь, не объявлена переменная $iid
            $filename = 'DSGItem-' . $iid . '.csv';
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //charset=UTF-8;
            //$csv="\xEF\xBB\xBF";
            $csv = '';
            foreach ($csvarray as $csvstr) {
                $csv = $csv . $csvstr . "\r\n";
            }
            echo $csv; //chr(255).chr(254).
            //.mb_convert_encoding($csvstr, 'UTF-16LE', 'UTF-8')
            Yii::app()->end();
        }
//====================================
    }

    public function actionDetail($dsSource = 'taobao', $iid = false, $url = false, $rawHTML = 0)
    {
        header('Access-Control-Allow-Origin: *');
        if ($url) {
            //$url = urldecode($url);
            $src = (string) Item::getDescriptionFromUrl($url);
            if (DSConfig::getVal('item_description_show_as_html') != 1) {
                $src = preg_replace("/href\s*=\s*[\"'].*?[\"']/is", 'href="#"', $src);
                if ($rawHTML != 0) {
                    echo $src;
                    return;
                } else {
                    $result = $this->renderPartial('item_details', ['src' => $src], true, false);
                    echo $result;
                    return;
                }
            } else {
                $src = preg_replace('/(^.*?\s*var\s+desc\s*=\s*\')|(\'\s*;\s*.*$)/is', '', $src);
                $src = preg_replace('/^[^<]+>/is', '', $src);
                $src = preg_replace("/\\\\$/sm", ' ', $src);
                if (extension_loaded('tidy')) {
                    $config = [
                      'clean'          => 'yes',
                      'output-html'    => 'yes',
                      'show-body-only' => true,
                      'merge-divs'     => true,
                      'merge-spans'    => true,
                    ];
                    /** @noinspection PhpUsageOfSilenceOperatorInspection */
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
                //echo '<iframe src="http://translate.google.com/translate?hl=bg&ie=UTF-8&u='.$url.'&sl=zh&tl=ru" "0"/>';
                return;
            }
        } else {
            echo false;
            Yii::app()->end();
            return;
        }
        Yii::app()->end();
    }

    function actionGetInputProps($iid = false, $dsSource = 'taobao', $render = true)
    {
        header('Access-Control-Allow-Origin: *');
        if (!$iid) {
            //$this->renderPartial('item_not_found', array(),FALSE, TRUE);
            return false;
//      throw new CHttpException(400, Yii::t('main', 'Неверный запрос'));
        }
//        else
//            $iid = (int)$iid;

        $lang = Utils::transLang();
        if ($this->item == false) {
            //TODO: Закэшить потом в сессию, т.к. таких вызовов аяксом в этом контроллере - 3 штуки.
            $item = new Item($dsSource, $iid, false, false, false, true);
        } else {
            $item = $this->item;
        }
        if (!isset($item->topItem) || !$item->topItem) {
            $this->render('item_not_found', []);
            return false;
        }
        if ($render) {
            echo $this->renderPartial(
              'input_props',
              [
                'totalCount'  => $item->topItem->num,
                'input_props' => $item->topItem->input_props,
                'props'       => $item->topItem->props,
                'lang'        => $lang,
              ]
            );
            Yii::app()->end();
        }
        return true;
    }

    function actionGetSKU($iid, $params = false, $count = 1, $dsSource = 'taobao')
    {
        header('Access-Control-Allow-Origin: *');
        //$this->actionGetInputProps($iid,false);
        try {
            if (!$params || !$iid) {
                Yii::app()->end();
            }
            $params = substr($params, 0, -1);
            if ($dsSource == 'undefined') {
                $dsSource = 'taobao';
            }
            $return = Item::getSkuData($dsSource, $iid, $params, $count);
            echo CJSON::encode($return);
            Yii::app()->end();
        } catch (Exception $e) {
            CVarDumper::dump($e, 1, true);
        }
    }

    function actionGetUserPrice($iid, $dsSource = 'taobao', $price = false, $count = false, $delivery = false)
    {
        header('Access-Control-Allow-Origin: *');
        if (!$price || !$delivery) {
            //TODO: Закэшить потом в сессию, т.к. таких вызовов аяксом в этом контроллере - 3 штуки.
            $item = new Item($dsSource, $iid, false, false, false, true);
            if (!$price) {
                $price = $item->topItem->promotion_price;
            }
            if (!$delivery) {
                $delivery = $item->topItem->express_fee;
            }
        }
        if (!$delivery) {
            $delivery = 0;
        }

        if (!$count) {
            $count = 1;
        }
        if (DSConfig::getValDef('delivery_source_fee_in_price', 0) == 1) {
            $expressFeeInPrice = $delivery;
        } else {
            $expressFeeInPrice = -1;
        }
        //ini_set('precision', 20);
        //TODO: уже посчитано ранее? Проверить и удалить если что.
        $item->topItem->weight_calculated = Weights::getItemWeight(
          $item->topItem->ds_source,
          $item->topItem->cid,
          $item->topItem->num_iid
        );
        //TODO: Проверить, а не посчитано ли ранее?
        $resUserPriceForOneItem = Formulas::getUserPrice(
          [
            'dsSource'    => isset($item) ? $item->topItem->ds_source : 'taobao',
            'price'       => $price,
            'count'       => 1,
            'deliveryFee' => $expressFeeInPrice,
            'postageId'   => (isset($item)) ? $item->topItem->postage_id : 0,
            'sellerNick'  => (isset($item)) ? $item->topItem->nick : false,
            'weight'      => (isset($item)) ? $item->topItem->weight_calculated : 0,
            'isTmall'     => (isset($item)) ? $item->topItem->isTmall : false,
          ]
        );
        $resUserPrice = Formulas::getUserPrice(
          [
            'dsSource'    => isset($item) ? $item->topItem->ds_source : 'taobao',
            'price'       => $price,
            'count'       => $count,
            'deliveryFee' => $delivery,
            'postageId'   => (isset($item)) ? $item->topItem->postage_id : 0,
            'sellerNick'  => (isset($item)) ? $item->topItem->nick : false,
            'weight'      => (isset($item)) ? $item->topItem->weight_calculated : 0,
            'isTmall'     => (isset($item)) ? $item->topItem->isTmall : false,
          ]
        );
        $item->topItem->totalWeight = $resUserPrice->totalWeight;
        $item->topItem->totalDelivery = $resUserPrice->totalDelivery;
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.item.userPriceForSkuAndCount') . '.php'
        )) {
            echo $this->renderPartial(
              'webroot.themes.' . $this->frontTheme . '.views.item.userPriceForSkuAndCount',
              [
                'item'                   => $item,
                'resUserPriceForOneItem' => $resUserPriceForOneItem,
                'resUserPrice'           => $resUserPrice,
              ],
              true
            );
        } else {
            ?>x&nbsp;<span id="count-price"
                           title="<?= Yii::t(
                             'main',
                             ('Цена одного товара с предварительной доставкой')
                           ) ?>"><?
            echo Formulas::priceWrapper(($resUserPriceForOneItem->price), false, 2) ?></span><?
            if ($resUserPrice->discount > 0) {
                echo '&nbsp;&dash;&nbsp;<span title="' . Yii::t('main', 'Экономия от количества') . '">' .
                  Formulas::priceWrapper($resUserPrice->discount) . '</span>';
            } ?> = <span id="sum" title="<?
            echo Yii::t('main', 'Итоговая цена за указанное количество');
            ?>"><?= Formulas::priceWrapper($resUserPrice->price) ?></span><?
        }
        Yii::app()->end();
    }

    function actionGetUserPriceDetail($iid, $dsSource = 'taobao', $price = false, $count = false, $delivery = false)
    {
        header('Access-Control-Allow-Origin: *');
        if (!$price || !$delivery) {
            //TODO: Закэшить потом в сессию, т.к. таких вызовов аяксом в этом контроллере - 3 штуки.
            $item = new Item($dsSource, $iid, false, false, false, true);
            if (!$price) {
                $price = $item->topItem->price;
            }
            if (!$delivery) {
                $delivery = $item->topItem->express_fee;
            }
        }
        if (!$delivery) {
            $delivery = 0;
        }

        if (!$count) {
            $count = 1;
        }
        //ini_set('precision', 20);
        //TODO: Проверить, а не посчитано ли ранее?
        $item->topItem->weight_calculated = Weights::getItemWeight(
          $item->topItem->ds_source,
          $item->topItem->cid,
          $item->topItem->num_iid
        );
        //TODO: Проверить, а не посчитано ли ранее?
        $resUserPrice = Formulas::getUserPrice(
          [
            'dsSource'    => isset($item) ? $item->topItem->ds_source : 'taobao',
            'price'       => $price,
            'count'       => $count,
            'deliveryFee' => $delivery,
            'postageId'   => (isset($item)) ? $item->topItem->postage_id : 0,
            'sellerNick'  => (isset($item)) ? $item->topItem->nick : false,
            'weight'      => (isset($item)) ? $item->topItem->weight_calculated : 0,
            'isTmall'     => (isset($item)) ? $item->topItem->isTmall : false,
          ]
        );
        $item->topItem->totalWeight = $resUserPrice->totalWeight;
        $item->topItem->totalDelivery = $resUserPrice->totalDelivery;
        echo $this->renderPartial(
          'item_price_detail',
          [
            'item'         => $item,
            'resUserPrice' => $resUserPrice,
          ],
          true,
          false
        );
        Yii::app()->end();
    }

    function actionGetUserPriceJson($iid, $dsSource = 'taobao', $price = false, $count = false, $delivery = false)
    {
        header('Access-Control-Allow-Origin: *');
        if (!$price || !$delivery) {
            //TODO: Закэшить потом в сессию, т.к. таких вызовов аяксом в этом контроллере - 3 штуки.
            $item = new Item($dsSource, $iid, false, false, false, true);
            if (!$price) {
                $price = $item->topItem->price;
            }
            if (!$delivery) {
                $delivery = $item->topItem->express_fee;
            }
        }
        if (!$delivery) {
            $delivery = 0;
        }

        if (!$count) {
            $count = 1;
        }
        //TODO: Проверить, а не посчитано ли ранее?
        $resUserPrice = Formulas::getUserPrice(
          [
            'dsSource'    => isset($item) ? $item->topItem->ds_source : 'taobao',
            'price'       => $price,
            'count'       => $count,
            'deliveryFee' => $delivery,
            'postageId'   => (isset($item)) ? $item->topItem->postage_id : 0,
            'sellerNick'  => (isset($item)) ? $item->topItem->nick : false,
            'weight'      => (isset($item)) ? $item->topItem->weight_calculated : 0,
            'isTmall'     => (isset($item)) ? $item->topItem->isTmall : false,
          ]
        );
        $return = [
          'price' => Formulas::priceWrapper(($resUserPrice->price + $resUserPrice->discount) / $count, false, 2),
          'sum'   => Formulas::priceWrapper($resUserPrice->price),
        ];

        echo CJSON::encode($return);
    }

    public function actionIndex($iid = false, $dsSource = 'taobao', $exportType = false, $refresh = false)
    {
//----------------------------------
        $fullStartTime = microtime(true);
        header(
          'Access-Control-Allow-Origin: ' .
          (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] :
            (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '*'))
        );//http://mall92.ru
        header('Access-Control-Allow-Headers: X-Preloading-Time');
        //header('Access-Control-Allow-Headers: Accept, Accept-Encoding, Accept-Language, Cookie, Host, Origin, Referer, User-Agent, X-Preloading-Time');
        header('Access-Control-Allow-Credentials: true');
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            return null;
        }
        if (!$iid) {
            throw new CHttpException(404, Yii::t('main', 'Неверный запрос'));
        } elseif (!preg_match('/^[a-z0-9\-]+$/i', $iid)) {
            $this->render('item_not_found', []);
            return false;
        }
        if ($refresh == 'true') {
            $_refresh = true;
            $proxyEnabled = DSConfig::getVal('proxy_enabled');
            $proxyAccessable = DSGDownloader::checkProxy();
            if ($proxyEnabled && ($proxyAccessable != 'OK')) {
                $_refresh = false;
            }
        } else {
            $_refresh = false;
            if (!Yii::app()->user->isGuest) {
                if (!(Yii::app()->request->isAjaxRequest || Yii::app()->request->isPostRequest)) {
                    $_refresh = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
                }
            }
            if ((defined('YII_DEBUG') && YII_DEBUG == true) && DSConfig::getVal('search_cache_enabled') == 1) {
                $_refresh = false;
            }
        }
        //echo ($_refresh?'true':'false');
//--- preparing fast opening --------------------------------------------------------------
        $exists = Item::exists($dsSource, $iid);

        if ($_refresh && $exists == 'partial') {
            $_refresh = false;
        }
        if (((Yii::app()->request->isPostRequest || Yii::app()->request->isAjaxRequest) && $exists == 'partial') ||
          (DSConfig::getVal(
              'item_ajax_loading'
            ) == 0) ||
          preg_match('/^local_/', $dsSource) ||
          $_refresh
          ||
          (DSConfig::getVal(
              'local_shop_mode'
            ) == 'only'
            || Item::isItemInLocal($dsSource, $iid))
        ) {
            $exists = false;
        }
        // Раскомментить, если нужно поотлаживать загрузку аяксом
        //$exists = 'partial';
        if ($exists == 'partial') {
            $session = Yii::app()->session;
            $session->open();
            if (Yii::app()->session->contains('itemAjaxLoading' . $iid)) {
                $exists = false;
                Yii::app()->session->remove('itemAjaxLoading' . $iid);
            }
            $session->close();
        }
        $startTime = microtime(true);
        $this->item = new Item($dsSource, $iid, (bool) $_refresh, false, $exists == 'partial');
        $endTime = microtime(true) - $startTime;
        $startTime = microtime(true);
        $isSubDomainRequest = preg_match('/\.$/is', Yii::app()->request->hostInfo);
        if (Yii::app()->request->isPostRequest || $isSubDomainRequest || Yii::app()->request->isAjaxRequest) {
            //echo "<script>top.location.href = top.location.href;</script>";
            echo 'true';
            return null;
            //Yii::app()->end();
//                }
        } else {
            if ($exists == 'partial' && isset($this->item->topItem) && $this->item->topItem) {
                $this->preLoading = true;
                $session = Yii::app()->session;
                $session->open();
                Yii::app()->session->add('itemAjaxLoading' . $iid, $iid);
                $session->close();
//==============================================================
                $itemSubdomains = explode(',', DSConfig::getVal('item_ajax_loading_subdomains'));
                $clearHash = md5(Yii::app()->name . $dsSource . $iid);
                if (is_array($itemSubdomains) && (count(
                      $itemSubdomains
                    ) > 0) && isset($itemSubdomains[0]) && $itemSubdomains[0]
                ) {
                    $d = 0;
                    for ($i = 0; $i <= 31; $i++) {
                        $d = $d ^ hexdec($clearHash{$i});
                    }
                    $n = (int) ((count($itemSubdomains) / 16) * $d);
                    $s = $itemSubdomains[$n];

                    $subdomain = $s . '.';
                } else {
                    $subdomain = '';
                }
                $hostinfo = Yii::app()->request->hostInfo;
                $hostinfo = preg_replace('/(?<=^|\/)www\./i', '', $hostinfo);
//==============================================================
                $url =
                  preg_replace('/http[s]*:\/\//is', "//{$subdomain}", $hostinfo) . '/item/' . $dsSource . '/' . $iid;
                $originalUrl = Yii::app()->request->requestUri;
                $refererUrl = Yii::app()->request->urlReferrer;
                $progressText = Yii::t('main', 'Дождитесь загрузки страницы товара...');
                $progressTitle = Yii::t('main', 'Загрузка');
                $errorText = Yii::t('main', 'Сайт сейчас перегружен запросами, обновите страницу');
                $errorTitle = Yii::t('main', 'Ошибка');
                $ajaxMethod = 'POST';//($isSubDomainRequest?'GET':'POST');
                $ajaxTimeout = (int) DSConfig::getVal('curl_timeout_default') * 1000;
                $_SERVER['HTTP_X_PRELOADING_TIME'] = 0;
                if (true) {
                    Yii::app()->clientScript->registerScript(
                      'item-fast-opening',
                      "
         dsProgress('{$progressText}','{$progressTitle}') ;
         var ajaxStartRequestTime = new Date().getTime();
        $.ajax({
			type: '{$ajaxMethod}',
			cache: false,
			url: '{$url}',
			//crossDomain: true,
			headers: { 
			     'X-Preloading-Time': '0' 
			     },
            xhrFields: {
                withCredentials: true
            },			
			timeout: {$ajaxTimeout},
			success: function(data, textStatus, request){
		//	console.log('{$exists} -> {$url} -> {$originalUrl}');
		//alert(request.getResponseHeader('X-Preloading-Time'));
		     var ajaxRequestTime = new Date().getTime()-ajaxStartRequestTime;
		     $.cookie('ItemAjaxPreloadedTime', ajaxRequestTime, { path: '/', expires: 1 });
		     $.cookie('ItemAjaxPreloadedReferer', '{$refererUrl}', { path: '/', expires: 1 });
		     window.location.replace('{$originalUrl}');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
              dsAlert('{$errorText}','{$errorTitle}',true);
			}
		});
       ",
                      CClientScript::POS_BEGIN
                    );
                }
            }
        }
        //CVarDumper::dump($this->item); die;
//-----------------------------------------------------------------------------------------
        if (!isset($this->item->topItem) ||
          !isset($this->item->topItem->num_iid) ||
          ($this->item->topItem->num_iid == '0')) {
            $this->render('item_not_found', []);
            return false;
        }
        if (isset($this->item->topItem->notOnSale) && $this->item->topItem->notOnSale) {
            $this->render('item_not_found', []);
            return false;
        }
        $lang = Utils::transLang();
        $ajax = [
          'input' => !$this->item->inputPropsReady(),
//      'itemRelated'=>FALSE,
        ];
//----------------------------------
        $seller = $this->item->topItem->seller;
        //Получаем данные о похожих товарах
        $itemRelated = [];
        if (!$this->preLoading) {
            if (isset($this->item->topItem->fromDSG)) {
                $itemRelated = $this->item->getItemRelated();
            }
        }
        $meta = Item::getSEOTags($this->item->topItem);
        $this->pageTitle = $meta->title;
        $this->meta_desc = $meta->description;
        $this->meta_keyword = $meta->keywords;
        if (!$this->preLoading) {
            SiteLog::doItemLog($this->item);
        }
        $endTime = microtime(true) - $startTime;
        //echo "<pre>Pre-rendering: $endTime</pre>";
        $startTime = microtime(true);
        if (!$exportType) {
            $this->render(
              'index',
              [
                'item'        => $this->item,
                'input_props' => $this->item->topItem->input_props,
                'props'       => $this->item->topItem->props,
                'seller'      => $seller,
                  //'sellerRelated' => $sellerRelated,
                'itemRelated' => $itemRelated,
                'ajax'        => $ajax,
                'lang'        => $lang,
//        'comments' => $comments,
              ]
            );
        } else {
            $this->export($exportType);
        }
        $endTime = microtime(true) - $startTime;
        $fullEndTime = microtime(true) - $fullStartTime;
        //echo "<pre>Rendering / Full time: $endTime / $fullEndTime</pre>";
        return null;
    }

    public function actionItemComments($dsSource, $num_iid, $seller_id, $type)
    {
        header('Access-Control-Allow-Origin: *');
        if ((!$num_iid && !$seller_id) || !$type) { ?>
            <?= Yii::t('main', 'Комментарии отсутствуют'); ?>
          <script>
              $(document).ready(function () {
                  try {
                      if (typeof deferredTranslateComments != 'undefined') {
                          deferredTranslateComments.resolve(true);
                      }
                  } catch (e) {
                      console.log('No Bing translation deffered enabled');
                  }
              });
          </script>
            <?
            return;
        }
        $search_PIM_grabbers_debug = DSConfig::getVal('search_PIM_grabbers_debug') == 1;
        $itemComments = new DSGItemComments($search_PIM_grabbers_debug);
        $itemComments->isTmall = ($type == 'tmall');
        $itemComments->num_iid = $num_iid;
        $itemComments->ds_source = $dsSource;
        $itemComments->seller_id = $seller_id;
        if (isset($_REQUEST['itemComments_dataProvider_page'])) {
            $itemComments->page = $_REQUEST['itemComments_dataProvider_page'];
        }
        $itemComments->cacheKey = $type . '-' . $dsSource . '-' . (string) $num_iid . '-' . (string) $seller_id;
        Profiler::start('itemComments->get', true);
        try {
            $itemComments->execute();
            Profiler::stop('itemComments->get', true);
        } catch (Exception $e) {
            Profiler::stop('itemComments->get', true);
        }
        //'webroot.themes.' . Yii::app()->theme->name . '.views.item.item_comments'
        $this->renderPartial(
          'webroot.themes.' . Yii::app()->theme->name . '.views.item.item_comments',
          ['itemComments' => $itemComments],
          false,
          true,
          true
        );
//        Yii::app()->end();
    }

    function actionSellerRelatedBlock($nick, $userid, $dsSource, $iid)
    {
        header(
          'Access-Control-Allow-Origin: ' .
          (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] :
            (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '*'))
        );
        header('Access-Control-Allow-Credentials: true');
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            return;
        }
        if (empty($nick) || (strlen($nick) <= 0) || empty($userid)) {
            Yii::app()->end();
        }

//=====================================
        // $searchRes = ItemRelated::getSellerRelated($nick, $userid, $iid, $dsSource);
        // public static function getSellerRelated($seller_nick, $seller_id, $iid, $ds_source = 'staobao')
        Profiler::start('item->getSellerRelated');
        $searchRes = new customSearchResult();
        $searchRes->query = $nick;
        $searchRes->cid = '0';
        if (isset($nick) && $nick && isset($userid) && isset($iid)) {
            $search = new Search('relatedBySeller');
            //TODO: тут возможно фейковый ds_source
            $search->params = ['ds_source' => $dsSource, 'nick' => $nick, 'user_id' => $userid];
            $searchRes = $search->execute();
        }
        Profiler::stop('item->getSellerRelated');
//=====================================
        $this->renderPartial('sellerRelatedBlock', ['sellerRelated' => $searchRes]);
    }

    public function filters()
    {
        if (AccessRights::GuestIsDisabled()) {
            return array_merge(
              [
                'Rights', // perform access control for CRUD operations
              ],
              parent::filters()
            );
        } else {
            return parent::filters();
        }
    }
}