<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Search.php">
 * </description>
 **********************************************************************************************************************/
class customSearchItemResult extends CComponent implements ArrayAccess
{
    function __construct($data = null, $isLocal = false)
    {
        $this->isLocal = $isLocal;
        if ($data) {
            if (is_array($data)) {
                if (isset($data['id'])) {
                    $this->id = $data['id'];
                }
                if (!$this->srcLanguage) {
                    if (isset($data['language'])) {
                        $this->srcLanguage = $data['language'];
                    } else {
                        $this->srcLanguage = 'ru';//DSConfig::getDsSourceParam($data['ds_source'], 'srcLang');
                    }
                }
                if (!$this->srcCurrency) {
                    if (isset($data['currency'])) {
                        $this->srcCurrency = $data['currency'];
                    } else {
                        $this->srcCurrency = 'rur'; //DSConfig::getDsSourceParam($data['ds_source'], 'srcCurrency');
                    }
                }
                $this->ds_source = $data['ds_source'];
                if (isset($data['ds_type'])) {
                    $this->ds_type = $data['ds_type'];
                }

                if ($this->ds_type == 'tmall') {
                    $this->tmall = true;
                }

                if (isset($data['num_iid'])) {
                    $this->num_iid = $data['num_iid'];
                } elseif (isset($data['item_id'])) {
                    $this->num_iid = $data['item_id'];
                }

                $price = (float) $data['price'];

                if (isset($data['price_promo'])) {
                    $price_original = (float) $data['price_promo'];
                } elseif (isset($data['promotion_price'])) {
                    $price_original = (float) $data['promotion_price'];
                } else {
                    $price_original = $price;
                }

                $this->price = max($price, $price_original);
                $this->promotion_price = min($price, $price_original);
                $this->name = new dvString(
                  (string) $data['title'],
                  'ru' //  DSConfig::getDsSourceParam($this->ds_source,'srcLang')
                );

                if (isset($data['pic_url'])) {
                    $pic_url = (string) $data['pic_url'];
                } elseif (isset($data['picture_url'])) {
                    $pic_url = (string) $data['picture_url'];
                } else {
                    $pic_url = '';
                }

                if ($pic_url) {
                    $this->pic_url = $pic_url;
                } else {
                    $imgUrl = Img::imglibSearchUrl(
                      '/' . $this->ds_source . '/',
                      $this->name->source
                    );
                    $this->pic_url = $imgUrl;
                }
                if (isset($data['seller_nick']) && $data['seller_nick']) {
                    $this->nick = (string) $data['seller_nick'];
                } elseif (isset($_GET['nick']) && $_GET['nick']) {
                    $this->nick = $_GET['nick'];
                }
                if (isset($data['seller_id'])) {
                    $this->user_id = (string) $data['seller_id'];
                }
                if (isset($data['seller_id_encripted'])) {
                    $this->encryptedUserId = (string) $data['seller_id_encripted'];
                }
                $this->seller_rate = (float) $data['seller_rate'];
                if (isset($data['price_delivery'])) {
                    $this->post_fee = (float) $data['price_delivery'];
                } elseif (isset($data['express_fee'])) {
                    $this->post_fee = (float) $data['express_fee'];
                }
                $this->express_fee = $this->post_fee;
                $this->ems_fee = $this->post_fee;
                $this->postage_id = '0';
                $this->cid = (string) $data['cid'];
                $this->tmall = false;
                if (isset($data['location'])) {
                    $this->location = (string) $data['location'];
                }
                if (isset($data['sold_items'])) {
                    $this->soldItems = (integer) $data['sold_items'];
                }
//=============================
                $this->extUrlSame = new customSearchItemResultRelated(null, $this);
                $this->extUrlSimilar = new customSearchItemResultRelated(null, $this);
                $this->extUrlUser = new customSearchItemResultRelated(null, $this);
                $this->uniqpid = '0';
                if (isset($data['pid'])) {
                    $similarPid = (string) $data['pid'];
                } else {
                    $similarPid = '';
                }
                if ($similarPid) {
                    /*            $num_iid = $this->num_iid;
                                $this->extUrlSame->originalUrl =
                                  "http://world.taobao.com/search/sameSim.htm?type=samestyle&nid={$num_iid}&uniqpid={$similarPid}";
                                $rawStr = "type=samestyle&nid={$num_iid}&uniqpid={$similarPid}";
                                $this->uniqpid = $similarPid;
                                $this->extUrlSame->count = 1;
                                $this->extUrlSame->url = '/search/index?similarPath=' . urlencode(
                                    $rawStr
                                  );
                                $this->extUrlSimilar->originalUrl =
                                  "http://world.taobao.com/search/sameSim.htm?type=similar&nid={$num_iid}&uniqpid={$similarPid}";
                                $rawStr = "type=similar&nid={$num_iid}&uniqpid={$similarPid}";
                                $this->uniqpid = $similarPid;
                                $this->extUrlSimilar->count = 1;
                                $this->extUrlSimilar->url = '/search/index?similarPath=' . urlencode(
                                    $rawStr
                                  );
                    */
//==============
                } else {
                    /*
                                $res = $this->jsonObjGetByRulePath('parse_item_values/sameItemInfoCount', $rawJsonItem);
                                if ($res !== false) {
                                    $this->extUrlSame->count = $res; //$data->nick;
                                } else {
                                    $this->extUrlSame->count = 0;
                                }
                                $this->extUrlSame->originalUrl = $this->jsonObjGetByRulePath(
                                  'parse_item_values/sameStyleUrl',
                                  $rawJsonItem
                                );
                                if ($this->extUrlSame->originalUrl) {
                                    $rawStr = preg_replace('/^.*?\?/', '', $this->extUrlSame->originalUrl);
                                    parse_str($rawStr, $rawStrParams);
                                    if (isset($rawStrParams['uniqpid'])) {
                                        $this->uniqpid = $rawStrParams['uniqpid'];
                                        $this->extUrlSame->count = 1;
                                        $this->extUrlSame->url = '/search/index?similarPath=' . urlencode(
                                            $rawStr
                                          );
                                    } else {
                                        $this->extUrlSame->url = '';
                                    }
                                } else {
                                    $this->extUrlSame->url = '';
                                }
                    //==============
                                $res = $this->jsonObjGetByRulePath('parse_item_values/similarCount', $rawJsonItem);
                                if ($res !== false) {
                                    $this->extUrlSimilar->count = $res; //$data->nick;
                                } else {
                                    $this->extUrlSimilar->count = 0;
                                }
                                $this->extUrlSimilar->originalUrl = $this->jsonObjGetByRulePath(
                                  'parse_item_values/similarUrl',
                                  $rawJsonItem
                                );
                                if ($this->extUrlSimilar->originalUrl) {
                                    $rawStr = preg_replace('/^.*?\?/', '', $this->extUrlSimilar->originalUrl);
                                    parse_str($rawStr, $rawStrParams);
                                    if (isset($rawStrParams['uniqpid'])) {
                                        $this->uniqpid = $rawStrParams['uniqpid'];
                                        $this->extUrlSimilar->count = 1;
                                        $this->extUrlSimilar->url = '/search/index?similarPath=' . urlencode(
                                            $rawStr
                                          );
                                    } else {
                                        $this->extUrlSimilar->url = '';
                                    }
                                } else {
                                    $this->extUrlSimilar->url = '';
                                }
                    */
                }
//==============
                /*        $this->extUrlUser->count = (end(
                          $this->DSGSearchRes->items
                        )->user_id ? 1 : 0); //$data->nick;
                        $shopUrl = $this->getDSGRule('parse_item_values/shopUrl');
                        $this->extUrlUser->originalUrl = $shopUrl . $this->user_id;
                        $this->extUrlUser->url =
                          '/seller/index/nick/' . $this->nick . '/seller_id/' . end(
                            $this->DSGSearchRes->items
                          )->user_id .
                          '/encryptedUserId/' . (isset($this->encryptedUserId) ? end(
                            $this->DSGSearchRes->items
                          )->encryptedUserId : '0');
                */
//===== SKUs =========
                $sku = [];
                /*        $res = $this->jsonObjGetByRulePath('parse_item_values/SKU', $rawJsonItem);
                        if ($res !== false) {
                            $rawSku = serialize($res);
                            $res = preg_match_all('/(\d+:\d+)/s', $rawSku, $matches);
                            if ($res) {
                                foreach ($matches[1] as $match) {
                                    $skuVal = explode(':', $match);
                                    if (is_array($skuVal) && isset($skuVal[0]) && isset($skuVal[1])) {
                                        $sku[$skuVal[0]][] = $skuVal[1];
                                    }
                                }

                            }
                        }
                */
                $this->sku = $sku;
                if (isset($data['dsg_item'])) {
                    $dsgItem = @unserialize($data['dsg_item']);
                    if ($dsgItem) {
                        if (isset($dsgItem->nick)) {
                            $this->nick = $dsgItem->nick;
                        }
                        if (isset($dsgItem->seller_id)) {
                            $this->user_id = $dsgItem->seller_id;
                        }
                    }
                }
            } elseif (is_object($data)) {
                if (isset($data->ds_source) && $data->ds_source) {
                    $this->ds_source = $data->ds_source;
                } else {
                    $this->ds_source = $this->dsSource->dsSourceGroup;
                }
                if ($data->tmall) {
                    $this->ds_type = 'tmall';
                }
                $this->num_iid = $data->num_iid;
                $this->price = $data->price;
                $this->promotion_price = $data->promotion_price;
                $this->pic_url = $data->pic_url;
                if (isset($data->nick) && $data->nick) {
                    $this->nick = $data->nick;
                } elseif (isset($_GET['nick']) && $_GET['nick']) {
                    $this->nick = $_GET['nick'];
                }
                if (isset($data->seller_rate)) {
                    $this->seller_rate = $data->seller_rate;
                } else {
                    $this->seller_rate = 0;
                }
                $this->post_fee = $data->post_fee;
                $this->express_fee = $data->express_fee;
                $this->ems_fee = $data->ems_fee;
                $this->postage_id = $data->postage_id;
                $this->cid = $data->cid;
                $this->tmall = $data->tmall;
                //--------------
                $this->sku = (isset($data->sku) ? $data->sku : []);
                $this->soldItems = (isset($data->soldItems) ? $data->soldItems : 0);
                $this->name = new dvString(
                  (isset($data->title) ? $data->title : ''),
                  'ru',//DSConfig::getDsSourceParam($this->ds_source,'srcLang')
                );
                $this->location = (isset($data->location) ? $data->location : '');
                $this->uniqpid = (isset($data->uniqpid) ? $data->uniqpid : 0);
                $this->extUrlSame = new customSearchItemResultRelated(
                  (isset($data->extUrlSame) ? $data->extUrlSame : null), $this
                );
                $this->extUrlSimilar = new customSearchItemResultRelated(
                  (isset($data->extUrlSimilar) ? $data->extUrlSimilar : null), $this
                );
                $this->extUrlUser = new customSearchItemResultRelated(
                  (isset($data->extUrlUser) ? $data->extUrlUser : null), $this
                );
            }
        }
    }

    /**
     * @var dvString Alt для изображения товара
     */
    public $alt = null;
    /**
     * @var string ID категории товара
     */
    public $cid = '0';
    /**
     * @var string ID источника данных
     */
    public $ds_source = 'taobao';
    /**
     * @var string Подтип источника данных
     */
    public $ds_type = 'taobao';
    /**
     * @var float Стоимость доставки в валюте источника
     */
    public $ems_fee = 0.0;
    /**
     * @var string кодированный ID продавца
     */
    public $encryptedUserId = '';
    /**
     * @var float Стоимость доставки в валюте источника
     */
    public $express_fee = 0.0;
    /**
     * @var customSearchItemResultRelated Данные для поиска таких же товаров
     */
    public $extUrlSame;
    /**
     * @var customSearchItemResultRelated Данные для поиска похожих товаров
     */
    public $extUrlSimilar;
    /**
     * @var customSearchItemResultRelated Данные для поиска товаров продавца
     */
    public $extUrlUser;
    /**
     * @var string ID источника данных
     */
    public $id = null;
    /**
     * @var bool Является ли источник данных локальным?
     */
    public $isLocal = false;
    /**
     * @var string Место нахождения товара
     */
    public $location = '';
    /**
     * @var dvString Название товара
     */
    public $name = null;
    /**
     * @var string Ник продавца
     */
    public $nick = '';
    /**
     * @var bool Исключен из продажи
     */
    public $notOnSale = false;
    /**
     * @var string ID товара
     */
    public $num_iid = '0';
    /**
     * @var string Ссылка URL на изображение товара
     */
    public $pic_url = '';
    /**
     * @var float Стоимость доставки в валюте источника
     */
    public $post_fee = 0.0;
    /**
     * @var string ID доставки
     */
    public $postage_id = '0';
    /**
     * @var float Оригинальная цена без скидки в валюте источника
     */
    public $price = 0.0;
    /**
     * @var float Процент скидки
     */
    public $promotion_percent = 0.0;
    /**
     * @var float Оригинальная цена со скидкой в валюте источника
     */
    public $promotion_price = 0.0;
    /**
     * @var float Рейтинг продавца
     */
    public $seller_rate = 0.0;
    /**
     * @var array Набор SKU - переделать в итератор
     */
    public $sku = [];
    /**
     * @var int Количество проданных товаров
     */
    public $soldItems = 0;
    /**
     * @var string Валюта источника
     */
    public $srcCurrency = null;
    /**
     * @var string Язык источника
     */
    public $srcLanguage = null;
    /**
     * @var dvString Title для товара
     */
    public $title = null;
    /**
     * @var bool Является ли tmall - переделать в string и назвать sub_source
     */
    public $tmall = false;
    /**
     * @var float Какая-то стоимость доставки
     */
    public $totalDelivery = 0.0;
    /**
     * @var float Вес товара какой-то снова
     */
    public $totalWeight = 0.0;
    /**
     * @var integer UID
     */
    public $uid = 0;
    /**
     * @var string ID - маркер для поиска похожих товаров
     */
    public $uniqpid = '0';
    /**
     * @var float Цена с наценкой без скидки в валюте интерфейса
     */
    public $userPrice = 0.0;
    /**
     * @var float Цена с наценкой со скидкой в валюте интерфейса
     */
    public $userPromotionPrice = 0.0;
    /**
     * @var string ID продавца
     */
    public $user_id = '';
    /**
     * @var float Вес товара
     */
    public $weight = 0.0;
    /**
     * @var array кэш языка источника товара
     */
    private static $_getDsSrcLangArray = [];

    /**
     * @return string
     */
    public function getDsSrcLang()
    {
        return 'ru';
        $result = 'zh';
        if ($this->ds_source) {
            if (isset(self::$_getDsSrcLangArray[$this->ds_source])) {
                $result = self::$_getDsSrcLangArray[$this->ds_source];
            } else {
                $grabbersXml = DSConfig::getDSGParserXMLByName('search_DropShop_grabbers');
                $xpath =
                  "//parser_section[enabled = 1 and default = 1 and subtype = 'search' and ds_sources[ds_source = '{$this->ds_source}']]";
                $found = $grabbersXml->xpath($xpath);
                if ($found && count($found)) {
                    $result = (string) $found[0]->srcLang;
                }
            }
            self::$_getDsSrcLangArray[$this->ds_source] = $result;
        }
        return $result;
    }

    public function offsetExists($offset)
    {
        return property_exists('customSearchItemResult', $offset);
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    public function offsetUnset($offset)
    {
        $this->$offset = null;
    }
}

/**
 * Class customSearchItemResultRelated
 */
class customSearchItemResultRelated
{
    public function __construct($data = null, $searchResultItem = null)
    {
        if (!is_null($data)) {
            if (is_array($data)) {

            } elseif (is_object($data)) {
                if (isset($data->count)) {
                    $this->count = $data->count;
                }
                if (isset($data->originalUrl)) {
                    $this->originalUrl = $data->originalUrl;
                }
                if (isset($data->url)) {
                    $this->url = $data->url;
                }
            }
            if ($this->url && isset($searchResultItem) && $searchResultItem && isset($searchResultItem->ds_source)
              && $searchResultItem->ds_source
            ) {
                $this->url = preg_replace(
                  '/\/seller\/index\/nick\//',
                  '/seller/index/dsSource/' . $searchResultItem->ds_source . '/nick/',
                  $this->url
                );
            }
            if (preg_match('/\/nick\/\//', $this->url)) {
                $this->count = 0;
                $this->url = '';
            }
            if (preg_match('/\/nick\//', $this->url) && isset($_GET['nick'])) {
                $this->count = 0;
                $this->url = '';
            }
        }
    }

    /**
     * @var int Количество связанных товаров
     */
    public $count = 0;
    /**
     * @var bool
     */
    public $originalUrl = false;
    /**
     * @var string Ссылка на связанные товары
     */
    public $url = '';
}