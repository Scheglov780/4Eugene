<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Search.php">
 * </description>
 **********************************************************************************************************************/
class customSearchResult extends CComponent
{
    /**
     * @var array
     */
    public $bids = [];
    /**
     * @var array Массив, содержащий элементы крошек со ссылками на оригинальный источник товаров
     */
    public $breadcrumbs = [];
    /**
     * @var string ID категории
     */
    public $cid = '0';
    /**
     * @var array Массив похожих категорий
     */
    public $cids = [];
    /**
     * @var string Поиковый запрос на языке источника товаров
     */
    public $dsSrcLangQuery = '';
    /**
     * @var array Массив источников, которые использовались при поиске
     */
    public $ds_sources = [];
    /**
     * @var null|string Сообщение об ошибках поиска
     */
    public $error = null;
    /**
     * @var array Массив фильтров
     */
    public $filters = [];
    /**
     * @var array
     */
    public $groups = [];
    /**
     * @var array Массив товаров
     */
    public $items = [];
    /**
     * @var array Массив мультифильтров
     */
    public $multiFilters = [];
    /**
     * @var int Размер страницы
     */
    public $pageSize = 0;
    /**
     * @var array Массив диапазонов цен
     */
    public $priceRange = [];
    /**
     * @var string Поиковый запрос на языке сейта
     */
    public $query = '';
    /**
     * @var array Массив диапазонов цен
     */
    public $searchSortParameters = [];
    /**
     * @var string Тип поиска
     */
    public $search_type = 'searchDSG';
    /**
     * @var array Массив похожих поисков
     */
    public $suggestions = [];
    /**
     * @var int Количество найденных результатов
     */
    public $total_results = 0;
    /**
     * @var string Ссылка URL на информацию о продавце
     */
    public $userRateUrl = '';
    /**
     * @var string Ссылка URL на оригинальный источник поиска товаров
     */
    public $viewUrl = '';
}