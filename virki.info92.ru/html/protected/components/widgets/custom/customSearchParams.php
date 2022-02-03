<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchParams.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

class customSearchParams extends CustomWidget
{

    public $bids = [];
    public $cid = '0';
    public $cids = [];
    public $filters = [];
    public $groups = [];
    public $items = false;
    public $multiFilters = [];
    public $params = [];
    public $priceRange = [];
    public $suggestions = [];
    public $type = 'search';
    public $userRateUrl = false;

    public function run()
    {
        return null;
        if ((bool) $this->params === true) {
            $cur_props = [];
            if (is_array($this->filters) && count($this->filters) && isset($this->params['props'])) {
                $ps = explode(';', preg_replace('/%3b|%2c/i', ';', $this->params['props']));
                foreach ($ps as $p) {
                    if ($p !== '') {
                        $pp = str_replace('%3A', ':', $p);
                        [$k, $v] = explode(':', $pp);
                        $cur_props[$k] = $v;
                    }
                }
            }
            [$minPrice, $maxPrice, $stepPrice] = CategoriesPrices::getPricesRangeForArray(
              $this->priceRange,
              $this->items
            );
            if (isset($this->params['user_id'])) {
                $seller = new stdClass();
                $seller->ds_source = (isset($this->params['ds_source']) ? $this->params['ds_source'] : '');
                $seller->user_id = (isset($this->params['user_id']) ? $this->params['user_id'] : '');
                $seller->seller_nick = (isset($this->params['nick']) ? $this->params['nick'] : '');
                // //rate.taobao.com/user-rate-b83a1c08c0c6b11a22a3b0056aedde63.htm
                if (preg_match('/user\-rate\-(.+?)\.htm/i', $this->userRateUrl, $matches)) {
                    $encryptedUserId = $matches[1];
                } else {
                    $encryptedUserId = '';
                }
                $seller->encryptedUserId = $encryptedUserId;
                $seller->city = '';
            } else {
                $seller = false;
            }
            $this->render(
              'themeBlocks.SearchParams.SearchParams',
              [
                'type'         => $this->type,
                'seller'       => $seller,
                'cids'         => $this->cids,
                'groups'       => $this->groups,
                'filters'      => $this->filters,
                'multiFilters' => $this->multiFilters,
                'suggestions'  => $this->suggestions,
                'priceRange'   => $this->priceRange,
                'params'       => $this->params,
                'cur_props'    => $cur_props,
                'minPrice'     => $minPrice,
                'maxPrice'     => $maxPrice,
                'stepPrice'    => $stepPrice,
              ]
            );
        }
    }
}
