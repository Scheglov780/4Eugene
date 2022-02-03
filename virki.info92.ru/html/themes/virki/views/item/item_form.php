<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="item_form.php">
 * </description>
 * Форма работы с картой товара
 **********************************************************************************************************************/
?>
<? if (!$this->preLoading) { ?>
  <div class="item-block-form-props">
    <div class="row clearfix f-space10"></div><!--отступ для блока-->
      <? if (isset($item->top_item->isAuction) && $item->top_item->isAuction) { ?>
        <div class="row clearfix f-space10"></div><!--отступ для блока-->
        <div class="item-space-box-xyz">
          <h3>
              <?= Yii::t(
                'main',
                'К сожалению, вы не можете заказать этот товар, так как он продаётся только с аукциона!'
              ) ?>
          </h3>
        </div>
        <div class="row clearfix f-space10"></div><!--отступ для блока-->
      <? } else { ?>
        <form action="<?= Yii::app()->createUrl('/cart/add') ?>" method="POST">

          <div class="form-item">
            <input type="hidden" name="dsSource" value="<?= $item->top_item->ds_source ?>" id="dsSource"/>
            <input type="hidden" name="cid" value="<?= $item->top_item->cid ?>" id="cid"/>
            <input type="hidden" name="iid" value="<?= $item->top_item->num_iid ?>" id="iid"/>
            <input type="hidden" name="inputprops-processed" id="inputprops-processed" value="0"/>
              <? if (!$ajax['input']) {
                  echo Yii::app()->controller->renderPartial(
                    'input_props',
                    [
                      'item'        => $item,
                      'totalCount'  => $item->top_item->num,
                      'input_props' => $input_props,
                    ],
                    true,
                    false
                  );
              } else { ?>
                <div id="item-input-props">
                  <script>
                      loadInputProps();
                  </script>
                </div>
              <? } ?>

          </div>

            <? /* /================= VK comments =========================== ?>
        <div>
            <?//<p>Вы можете оставить отзыв о данном товаре, его увидят другие пользователи.</p>?>
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>
            <script type="text/javascript">
                VK.init({apiId: 4897684, onlyWidgets: true});
            </script>

            <!-- Put this div tag to the place, where the Comments block will be -->
            <div id="vk_comments"></div>
            <script type="text/javascript">
                VK.Widgets.Comments("vk_comments", {limit: 10, width: "960", attach: "*"});
            </script>
        </div>
<? //========================================================  */ ?>
          <div class="row clearfix f-space10"></div><!--отступ для блока-->
          <div class="item-space-box-xyz">
            <div class="form-item">
              <label><?= Yii::t('main', 'В наличии') ?>:</label>
              <div class="item-info-param">
                <span id="item_num"><?= $item->top_item->num ?></span>&nbsp;
              </div>
              <input type="hidden" name="item_totalcount" id="item_totalcount"
                     value="<?= $item->top_item->num ?>">
                <? if (Yii::app()->user->checkAccess('@showSourceLinkInUserCard')) { ?>
                  <div class="item-info-param pull-right" id="item_onsource">
                    <a href="http://item.source.com/item.htm?id=<?= $item->top_item->num_iid ?>"
                       target="_blank">
                      &nbsp;<?= Yii::t('main', 'Этот товар на source.com') ?>
                    </a>
                  </div>
                <? } ?>
            </div>
          </div>

          <div class="row clearfix f-space10"></div><!--отступ для блока-->
          <div class="item-space-box-xyz">
            <div class="form-item">

              <div class="item-info-param">

                <label for="num">
                    <?= Yii::t('main', 'Количество') . ' :' ?>
                </label>

                <div class="number">
                  <nobr>

                    <input type="text" onchange="getUserPrice()" name="num" id="num" class="item-count"
                           value="1"/>
                    <p class="plus"><i class="fa fa-plus"></i></p>
                    <p class="minus"><i class="fa fa-minus"></i></p>

                    <input type="hidden" name="num-processed" id="num-processed" value="1"/>
                  </nobr>

                    <? /*
                        <div class="number">
                            <nobr>
                                <p class="minus"><i class="fa fa-caret-square-o-down"></i></p>
                                <p class="plus"><i class="fa fa-caret-square-o-up"></i></p>
                                <input type="text" onchange="getUserPrice()" name="num" id="num" class="item-count col-lg-10 col-md-10 col-sm-10 col-xs-10" value="1"/>
                                <input type="hidden" name="num-processed" id="num-processed" value="1"/>
                            </nobr>
                        </div>
*/ ?>
                  <div id="item-count-price">
                      <? $this->renderPartial(
                        'webroot.themes.' . $this->frontTheme . '.views.item.userPriceForSkuAndCount',
                        [
                          'item'                   => $item,
                          'resUserPriceForOneItem' => false,
                          'resUserPrice'           => false,
                        ]
                      ); ?>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row clearfix f-space10"></div><!--отступ для блока-->
          <div class="item-space-box-xyz">
              <?
              Yii::app()->controller->renderPartial(
                'item_price_detail',
                [
                  'item'         => $item,
                  'resUserPrice' => false,
                ],
                false,
                false
              );
              ?>
          </div>
          <div class="row clearfix f-space10"></div><!--отступ для блока-->
          <!-- Кнопки формы -->
          <div class="product-big-btns pull-right">

              <? /*
        <button type="submit" class="btn btn-danger btn-addtocart"
                title="" data-toggle="tooltip" data-placement="left"
                data-original-title="<?=((count($item->top_item->input_props)) ? Yii::t('main', 'Не выбраны характеристики товара'):'') ?>"
                name="doGo" value="<?= Yii::t('main', 'Добавить в корзину') ?>"
          <?= ((count($item->top_item->input_props))?'disabled':'disabled' ) ?> >
            <i class="fa fa-shopping-cart fa-fw"></i> в корзину
        </button>
*/ ?>
              <? if (Yii::app()->user->notInRole(['guest'])) { ?>
                <button class="btn btn-info btn-compare"
                        data-toggle="tooltip" data-placement="bottom"
                        title=""
                        type="button"
                        name="btnRefresh"
                        data-original-title="<?= Yii::t('main', 'Обновить цены и остатки') ?>"
                        formaction="javascript:void(0);"
                        onclick="window.location.replace(addParameterToUrl(window.location.href, 'refresh', 'true', true));">
                  <i class="fa fa-refresh fa-fw"></i>
                </button>
              <? } ?>

              <? if (isset($item->extUrlSame->count) && ($item->extUrlSame->count > 0)) { ?>
                <button class="btn btn-info btn-compare"
                        data-toggle="tooltip" data-placement="bottom"
                        title=""
                        type="button"
                        name="btnRefresh"
                        data-original-title="<?= Yii::t('main', 'Найти такие же товары у других продавцов') ?>"
                        formaction="javascript:void(0);"
                        onclick="window.location.replace(addParameterToUrl(window.location.href, 'refresh', 'true', true));">
                  <i class="fa fa-refresh fa-fw"></i>
                </button>
              <? } ?>

              <? /*
                     <? if (isset($item->extUrlSame->count) && ($item->extUrlSame->count > 0)) { ?>
                        <a style="display:inline-block; cursor: pointer;"
                           title="<?= Yii::t('main', 'Найти такие же товары у других продавцов') ?>"
                           rel="nofollow" href="<?= Yii::app()->createUrl($item->extUrlSame->url) ?>" target="_blank"><i
                                    class="fa fa-magic fa-2x"></i></a>
                    <? } ?>
                    <? if (isset($item->extUrlSimilar->count) && ($item->extUrlSimilar->count > 0)) { ?>
                        <a style="display:inline-block; cursor: pointer;"
                           title="<?= Yii::t('main', 'Найти похожие товары') ?>"
                           rel="nofollow" href="<?= Yii::app()->createUrl($item->extUrlSimilar->url) ?>" target="_blank"><i
                                    class="fa fa-search fa-2x"></i></a>
                    <? } ?>
                    <? if (isset($item->extUrlUser->count) && ($item->extUrlUser->count > 0)) { ?>
                        <a style="display:inline-block; cursor: pointer;"
                           title="<?= Yii::t('main', 'Показать все товары продавца') ?>"
                           rel="nofollow" href="<?= Yii::app()->createUrl($item->extUrlUser->url) ?>" target="_blank"><i
                                    class="fa fa-user-circle fa-2x"></i></a>
                    <? } elseif (isset($seller->user_id) && $seller->user_id) { ?>
                        <a style="display:inline-block; cursor: pointer;"
                           title="<?= Yii::t('main', 'Показать все товары продавца') ?>"
                           rel="nofollow" href="<?= Yii::app()->createUrl(
                          '/seller/index',
                          array(
                            'nick'            => $seller->seller_nick,
                            'seller_id'       => $seller->user_id,
                            'encryptedUserId' => (isset($seller->encryptedUserId) ? $seller->encryptedUserId : '')
                          )
                        ) ?>" target="_blank"><i class="fa fa-user-circle fa-2x"></i></a>
                    <? } ?>
*/ ?>


              <? if (Yii::app()->user->notInRole(['guest'])) { ?>
                <button data-original-title="<?= Yii::t('main', 'Добавить в избранное') ?>"
                        class="btn btn-warning btn-sendtofriend"
                        data-toggle="tooltip" data-placement="bottom"
                        name="dofav"
                        formaction="<?= Yii::app()->createUrl(
                          '/cabinet/favorite/add',
                          [
                            'dsSource' => $item->top_item->ds_source,
                            'iid'      => $item->top_item->num_iid,
                            'download' => true,
                          ]
                        ) ?>"
                        onclick="addFavorite(this,'<?= $item->top_item->num_iid ?>'); return false;"
                        title=""
                        value="<?= Yii::t('main', 'Добавить в избранное') ?>">
                  <i class="fa fa-star"></i>
                </button>
              <? } ?>
              <? if ((Yii::app()->user->notInRole(['guest', 'user']))) { ?>
                <button class="btn btn-success btn-wishlist"
                        data-toggle="tooltip" data-placement="bottom"
                        title=""
                        type="button"
                        name="addReq"
                        data-original-title="<?= Yii::t('main', 'Добавить в рекомендованное') ?>"
                        formaction="<?= Yii::app()->createUrl(
                          '/' . Yii::app()->controller->module->id . '/featured/add/',
                          ['dsSource' => $item->top_item->ds_source, 'id' => $item->top_item->num_iid]
                        ) ?>"
                        onclick="addFeatured(this,'<?= $item->top_item->num_iid ?>');return false;">
                  <i class="fa fa-heart fa-fw"></i>
                </button>
                  <? /*
                        <a style="display:inline-block; cursor: pointer;"
                   title="<?= Yii::t('main', 'Изменить вес') ?>"
                   rel="nofollow" href="javascript:void(0)"
                   onclick="editWeight(<?= $item->top_item->cid ?>,<?= $item->top_item->num_iid ?>,<?= (isset($item->top_item->weight_calculated) ? $item->top_item->weight_calculated : 0) ?>); return false;"><i
                            class="fa fa-download fa-2x"></i></a>
*/ ?>
              <? } ?>
            <button data-original-title="<?= Yii::t('main', 'Продолжить покупки') ?>"
                    class="btn btn-info btn-compare"
                    name="toCart"
                    data-toggle="tooltip" data-placement="bottom"
                    title=""
                    formaction="javascript:void(0);"
                    onclick="window.history.back();">
              <i class="fa fa-sign-in"></i>
            </button>
              <? //TODO: Кнопки, которых не хватает -> уже хватает НО не работают  ?>

              <? if (isset($item->extUrlSame->count) && ($item->extUrlSame->count > 0)) { ?>
                  <? /*
                    <a class="ui-icon ui-icon-extlink" style="display:inline-block; cursor: pointer;"
                       title="<?= Yii::t('main', 'У других продавцов') ?>"
                       rel="nofollow" href="<?= Yii::app()->createUrl($item->extUrlSame->url) ?>" target="_blank">

                    </a>
                    */ ?>
                <button data-original-title="<?= Yii::t('main', 'У других продавцов') ?>"
                        class="btn btn-warning btn-compare1"
                        name="atherSellers"
                        data-toggle="tooltip" data-placement="bottom"
                        title=""
                        formaction="<?= Yii::app()->createUrl($item->extUrlSame->url) ?>"
                        onclick="window.history.back();">
                  <i class="fa fa-users"></i>
                </button>
              <? } ?>
              <? if (isset($item->extUrlSimilar->count) && ($item->extUrlSimilar->count > 0)) { ?>
                  <? /*
                    <a class="ui-icon ui-icon-newwin" style="display:inline-block; cursor: pointer;"
                       title="<?= Yii::t('main', 'Похожие товары') ?>"
                       rel="nofollow" href="<?= Yii::app()->createUrl($item->extUrlSimilar->url) ?>"
                       target="_blank">
                    </a>
                    */ ?>
                <button data-original-title="<?= Yii::t('main', 'Похожие товары') ?>"
                        class="btn btn-success btn-compare2"
                        name="atherSellers"
                        data-toggle="tooltip" data-placement="bottom"
                        title=""
                        formaction="<?= Yii::app()->createUrl($item->extUrlSimilar->url) ?>"
                        onclick="window.history.back();">
                  <i class="fa fa-clone"></i>
                </button>
              <? } ?>
              <? if (isset($item->extUrlUser->count) && ($item->extUrlUser->count > 0)) { ?>
                  <? /*
                    <a class="ui-icon ui-icon-person" style="display:inline-block; cursor: pointer;"
                       title="<?= Yii::t('main', 'Все товары продавца') ?>"
                       rel="nofollow" href="<?= Yii::app()->createUrl($item->extUrlUser->url) ?>" target="_blank">
                    </a>
                    */ ?>
                <button data-original-title="<?= Yii::t('main', 'Все товары продавца') ?>"
                        class="btn btn-info btn-compare3"
                        name="allGoodsSeller"
                        data-toggle="tooltip" data-placement="bottom"
                        title=""
                        formaction="<?= Yii::app()->createUrl($item->extUrlUser->url) ?>"
                        onclick="window.history.back();">
                  <i class="fa fa-user"></i>
                </button>
              <? } ?>
              <? /*
                    <a class="ui-icon ui-icon-arrowstop-1-s" style="display:inline-block; cursor: pointer;"
                       title="<?= Yii::t('main', 'Изменить вес') ?>"
                       rel="nofollow" href="javascript:void(0)"
                       onclick="editWeight(<?= $item->top_item->cid ?>,<?= $item->top_item->num_iid ?>,<?= (isset($item->top_item->weight_calculated) ? $item->top_item->weight_calculated : 0) ?>); return false;">
                    </a>
                    /*?>

                <button data-original-title="<?= Yii::t('main', 'Изменить вес') ?>"
                        class="btn btn-success btn-compare4"
                        name="editWeght"
                        data-toggle="tooltip" data-placement="bottom"
                        title=""
                        formaction="editWeight(<?= $item->top_item->cid ?>,<?= $item->top_item->num_iid ?>,<?= (isset($item->top_item->weight_calculated) ? $item->top_item->weight_calculated : 0) ?>); return false;"
                        onclick="window.history.back();">
                    <i class="fa fa-balance-scale"></i>
                </button>

<? //================================ ?>
            </div>

    </div><!--End:Блок с кнопками--->
    <? /* if ((Yii::app()->user->notInRole(array('guest', 'user')))) { ?>
            <a class="ui-icon ui-icon-star" style="display:inline-block; cursor: pointer;"
               title="<?= Yii::t('main', '"Экспорт в XML') ?>"
               href="<?= '/item/index/iid/' . $item->top_item->num_iid . '/exportType/CSV' ?>"></a>
        <? } */ ?>

            <!------------------------------------------------------->
              <? //========= Разруливаем, когда можно заказать сразу и добавить в корзину
              $neededSum = DSConfig::getVal('checkout_min_order_sum');
              $neededSumInCurr = Formulas::convertCurrency(
                $neededSum,
                DSConfig::getVal('site_currency'),
                DSConfig::getCurrency()
              );
              $allowCart = false;
              $allowBuy = false;
              $notAllowCartMessage = Yii::t('main', 'Сначала выберите характеристики товара!');
              $notAllowBuyMessage = Yii::t('main', 'Сначала выберите характеристики товара!');
              if (!count($item->top_item->input_props)) {
                  $allowCart = true;
                  $notAllowCartMessage = '';
              }
              if ($allowCart) {
                  if ($item->top_item->userPriceFinal >= $neededSumInCurr) {
                      $allowBuy = true;
                      $notAllowBuyMessage = '';
                  } else {
                      $notAllowBuyMessage = Yii::t(
                          'main',
                          'Минимальная стоимость заказа'
                        ) . ": $neededSumInCurr " . DSConfig::getCurrency();
                  }
              }
              ?>
            <input type="submit" data-toggle="tooltip" data-placement="bottom"
                   data-original-title="<?= $notAllowBuyMessage ?>"
              <?= (!$allowBuy ? 'disabled="disabled"' : '') ?> name="doBuy"
                   value="<?= Yii::t('main', 'Купить') ?>"
                   id="buy-btn-buy"
                   class="buy-btn bigger btn btn-danger" style="height: 41px;"/>
            <input type="submit" data-toggle="tooltip" data-placement="bottom"
                   data-original-title="<?= $notAllowCartMessage ?>"
              <?= (!$allowCart ? 'disabled="disabled"' : '') ?> name="doGo"
                   value="<?= Yii::t('main', 'В корзину') ?>"
                   id="buy-btn-cart"
                   class="buy-btn bigger btn btn-danger" style="height: 41px;"/>

        </form>
      <? } ?>
  </div>
<? } ?>