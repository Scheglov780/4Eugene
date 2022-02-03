<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Search.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/*
 * Модель для общего поиска товаров. Уникальна и используется для поиска, категорий, продавцов
 */

/**
 * @property string             $searchType
 * @property array              $params
 * @property array              $dsSources
 * @property dsSourceSearchData $dsSource
 */
abstract class customSearchBaseProps extends CComponent
{
    /**
     * customSearchBaseProps constructor.
     * @param string|null                $searchType
     * @param customSearchBaseProps|null $ancessor
     */
    public function __construct($searchType = null, $ancessor = null)
    {
        if ($ancessor) {
            $vars = get_object_vars($ancessor);
            foreach ($vars as $name => $value) {
                if (property_exists('customSearchBaseProps', $name)) {
                    $this->$name = $value;
                }
            }
        }
        if ($searchType) {
            $this->searchType = $searchType;
        }
        if (!isset($this->_params['page'])) {
            $this->_params['page'] = 1;
        }
        ksort($this->_params);
        $this->initDsSources();
        //parent::__construct();
    }

    private $noDsSourcesNeededForSearchTypes = ['favorite'];
    /**
     * @var array Базовые параметры поиска
     */
    protected $_params = [];
    /**
     * @var array Данные о ds_source
     */
    public $dsSources = [];
    /**
     * @var string Тип поиска
     */
    public $searchType;

    private function initDsSources()
    {
        return null;
        $found = null;
        if (count($this->dsSources)) {
            $this->dsSources = [];
        }
        $grabbersXml = DSConfig::getDSGParserXMLByName('search_DropShop_grabbers');
        if (DSConfig::getApiKey('openCartTaobaoApi/search') || DSConfig::getApiKey('openCartTaobaoApi/item')) {
            //throw new Exception('needed tp API support implement!');
            $apiParserNameXPath = 'name = "openCartTaobaoApi/search" or name = "openCartTaobaoApi/item"';
        } else {
            $apiParserNameXPath = 'name != "openCartTaobaoApi/search" and name != "openCartTaobaoApi/item"';
        }
        $apiParserNameXPath = '(' . $apiParserNameXPath . ')';
        if (isset($this->_params['ds_source']) && $this->_params['ds_source'] && $this->searchType) {
            $dsSource = $this->_params['ds_source'];
            $xpath =
              "//parser_section[enabled = 1 and default = 1 and subtypes[subtype = '{$this->searchType}'] and ds_sources[ds_source = '{$dsSource}']]";
            $found = $grabbersXml->xpath($xpath);
        }
        if ((!$found || !count($found)) && $this->searchType) {
            if (is_a($this, 'searchRemote')) { // DSConfig::getVal('local_shop_mode') == 'off'
                $xpath =
                  "//parser_section[{$apiParserNameXPath} and enabled = 1 and default = 1 and subtypes[subtype = '{$this->searchType}'] and  type != 'local']";
            } elseif (is_a($this, 'searchLocal')) { //DSConfig::getVal('local_shop_mode') == 'only'
                $xpath =
                  "//parser_section[enabled = 1 and default = 1 and subtypes[subtype = '{$this->searchType}'] and  type = 'local']";
            } else {
                if (DSConfig::getVal('local_shop_mode') == 'off') {
                    $xpath =
                      "//parser_section[{$apiParserNameXPath} and enabled = 1 and default = 1 and subtypes[subtype = '{$this->searchType}'] and  type != 'local']";
                } elseif (DSConfig::getVal('local_shop_mode') == 'only') {
                    $xpath =
                      "//parser_section[enabled = 1 and default = 1 and subtypes[subtype = '{$this->searchType}'] and  type = 'local']";
                } else {
                    $xpath =
                      "//parser_section[{$apiParserNameXPath} and enabled = 1 and default = 1 and subtypes[subtype = '{$this->searchType}']]";
                }
            }
            $found = $grabbersXml->xpath($xpath);
        }
        if ((!$found || !count($found)) && $this->searchType) {
            if (is_a($this, 'searchRemote')) { //DSConfig::getVal('local_shop_mode') == 'off'
                $xpath =
                  "//parser_section[{$apiParserNameXPath} and enabled = 1 and subtypes[subtype = '{$this->searchType}'] and  type != 'local']";
            } elseif (is_a($this, 'searchLocal')) { //DSConfig::getVal('local_shop_mode') == 'only'
                $xpath =
                  "//parser_section[enabled = 1 and subtypes[subtype = '{$this->searchType}'] and  type = 'local']";
            } else {
                if (DSConfig::getVal('local_shop_mode') == 'off') {
                    $xpath =
                      "//parser_section[{$apiParserNameXPath} and enabled = 1 and subtypes[subtype = '{$this->searchType}'] and  type != 'local']";
                } elseif (DSConfig::getVal('local_shop_mode') == 'only') {
                    $xpath =
                      "//parser_section[enabled = 1 and subtypes[subtype = '{$this->searchType}'] and  type = 'local']";
                } else {
                    $xpath =
                      "//parser_section[{$apiParserNameXPath} and enabled = 1 and subtypes[subtype = '{$this->searchType}']]";
                }
            }
            $found = $grabbersXml->xpath($xpath);
        }
        if ($found && count($found)) {
            //if (!function_exists('cmpDsSources')) {
            $callback = function ($a, $b) use (&$obj) {
                if (DSConfig::getVal('local_shop_mode') != 'off') {
                    if ((string) $a->type == 'local') {
                        if (is_a($obj, 'searchRemote')) {
                            return 1;
                        } elseif (is_a($obj, 'searchLocal')) {
                            return -1;
                        } else {
                            return 1;
                        }
                    } else {
                        if (is_a($obj, 'searchRemote')) {
                            return -1;
                        } elseif (is_a($obj, 'searchLocal')) {
                            return 1;
                        } else {
                            return -1;
                        }

                    }
                } else {
                    if ((int) $a->default == (int) $b->default) {
                        return 0;
                    }
                    return ((int) $a->default < (int) $b->default) ? 1 : -1;
                }
            };
//            }
            $obj = $this;
            @usort($found, $callback);//'cmpDsSources'
            foreach ($found as $foundRec) {
                $this->dsSources[] = new dsSourceSearchData($foundRec);
            }
        }
        if ((!isset($this->dsSources[0]) || !$this->dsSources[0]) && !in_array(
            $this->searchType,
            $this->noDsSourcesNeededForSearchTypes
          )) {
            throw new Exception(
              'dsSource not exists or not selected! Check dsg search rules. If type is mixed and local rules must exists! SubType: ' .
              $this->searchType
            );
        }
        $this->initPriceRanges(isset($this->dsSources[0]) ? $this->dsSources[0] : false);
        /* else {
            $this->dsSources[0] = null;
        } */
    }

    private function initPriceRanges($ds_source = false)
    {
        if (isset($this->_params['price_min']) && (bool) ($this->_params['price_min'])) {
            $this->_params['price_min'] = (float) Formulas::getOriginalSourcePrice(
              ['price' => $this->_params['price_min']]
            );
        }
        if (isset($this->_params['price_max']) && (bool) ($this->_params['price_max'])) {
            $this->_params['price_max'] = (float) Formulas::getOriginalSourcePrice(
              ['price' => $this->_params['price_max']]
            );
        }
    }

    /**
     * @return dsSourceSearchData|null
     */
    public function getDsSource()
    {
        if (isset($this->dsSources[0])) {
            return $this->dsSources[0];
        } else {
            return null;
        }
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->_params = $params;
        ksort($this->_params);
        $this->initDsSources();
    }
}

class dsSourceSearchData
{
    /**
     * @param SimpleXMLElement $dsSourceXml
     */
    public function __construct($dsSourceXml)
    {
        $this->dsSourceName = (string) $dsSourceXml->name;
        $this->isLocal = (bool) preg_match('/^local_/i', $this->dsSourceName);
        $this->canUseDSProxy = (bool) ((integer) $dsSourceXml->can_use_dsproxy) && !$this->isLocal;
        $this->dsSourceGroup = (string) $dsSourceXml->ds_source_group;
        $this->dsSourceCurrency = (string) $dsSourceXml->srcCurrency;
        $this->dsSourceLang = (string) $dsSourceXml->srcLang;
        $this->dsSourcePageSize = 25; //(integer) $dsSourceXml->pageSize;
        foreach ($dsSourceXml->ds_sources->ds_source as $ds_source) {
            $this->allowedDsSources[] = (string) $ds_source;
        }
//================
        $sortOrders = $dsSourceXml->xpath('url_query_params/param[name="sort_order"]/values/value');
        $this->searchSortParameters = [];
        if (is_array($sortOrders)) {
            foreach ($sortOrders as $sortOrder) {
                $this->searchSortParameters[(string) $sortOrder->name] = Yii::t(
                  'main',
                  (string) $sortOrder->description
                );
            }
        }
//================
    }

    public $allowedDsSources = [];
    public $canUseDSProxy = false;
    public $dsSourceCurrency = '';
    public $dsSourceGroup = '';
    public $dsSourceLang = '';
    public $dsSourceName = '';
    public $dsSourcePageSize = 0;
    public $isLocal = false;
    public $searchSortParameters = [];

}