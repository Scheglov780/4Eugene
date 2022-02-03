<?php

/**
 * CSEOLinkPager class file.
 */
class COrderItemsPager extends CLinkPager
{
    public $orderItems = false;
    /**
     * Creates the page buttons.
     * @return array a list of page buttons (in HTML code).
     */

    /**
     * Creates a page button.
     * You may override this method to customize the page buttons.
     * @param string  $label    the text label for the button
     * @param integer $page     the page number
     * @param string  $class    the CSS class for the page button.
     * @param boolean $hidden   whether this page button is visible
     * @param boolean $selected whether this page button is selected
     * @return string the generated button
     */
    protected function createPageButton($label, $page, $class, $hidden, $selected)
    {
        if ($hidden || $selected) {
            $class .= ' ' . ($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
        }

        if ($class == 'page' || $class == 'page selected') {
            //$link=CHtml::link($label,$this->createPageUrl($page));
            //$s=$page+1;
            $images = '';
            if (isset($this->orderItems) && is_array($this->orderItems)) {
                foreach ($this->orderItems as $i => $item) {
                    if (($i < ($page) * $this->pages->pageSize) || ($i >= ($page + 1) * $this->pages->pageSize)) {
                        continue;
                    }
                    $images = $images . '<ul class="orderNavigatorItem">';
                    $images = $images . '<li>';
                    $images = $images . '<div class="product-image">';
                    if (!$selected) {
                        $images = $images . '<a href="' . (!$selected ? $this->createPageUrl(
                            $page
                          ) : '') . '#headerblock-item-' . $item->id . '" ' . ($selected ? ' onclick=""' : '') . '>';
                    } else {
                        $images =
                          $images .
                          '<div onclick="location.hash =\'#headerblock-item-' .
                          $item->id .
                          '\';">'; //href="#headerblock-item-'.$item->id.'"
                    }
                    $images = $images . '<img src="' . Img::getImagePath(
                        $item->pic_url,
                        '_60x60.jpg'
                      ) . '" alt="" title=""/>';
                    if (!$selected) {
                        $images = $images . '</a>';
                    } else {
                        $images = $images . '</div>';
                    }
                    $images = $images . '</div>';
                    $images = $images . '&nbsp;' . (($item->tid) ? '<i class="fa fa-credit-card" title="' . Yii::t(
                          'admin',
                          'Закуплено'
                        ) . '"></i>' : '&nbsp;') . '&nbsp;';
                    $images = $images . '<span title="' . Yii::t(
                        'admin',
                        'Статус обработки лота'
                      ) . '">' . $item->status_text . '</span>';
                    if ($item->track_code) {
                        $images = $images . '<br><i class="fa fa-barcode"></i>&nbsp;<span title="' . Yii::t(
                            'admin',
                            'Трек-код посылки при отправке с таобао. Может быть несколько, через запятую.'
                          ) . '">' . $item->track_code . '</span>';
                    }
                    $images = $images . '</li>';
                    $images = $images . '</ul>';
                }
            }
            //$images = $images . '<br/>';

            return '<li class="' . $class . '">' . $images . '</li>';
        } else {
            return '';
        }
    }

    protected function createPageButtons()
    {
        if (($pageCount = $this->getPageCount()) < 1) { //<=1
            return [];
        }

        [$beginPage, $endPage] = $this->getPageRange();
        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons = [];

        // first page
        $buttons[] = $this->createPageButton(
          $this->firstPageLabel,
          0,
          $this->firstPageCssClass,
          $currentPage <= 0,
          false
        );

        // prev page
        if (($page = $currentPage - 1) < 0) {
            $page = 0;
        }
        $buttons[] = $this->createPageButton(
          $this->prevPageLabel,
          $page,
          $this->previousPageCssClass,
          $currentPage <= 0,
          false
        );

        // internal pages
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->createPageButton($i + 1, $i, $this->internalPageCssClass, false, $i == $currentPage);
        }

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1) {
            $page = $pageCount - 1;
        }
        $buttons[] = $this->createPageButton(
          $this->nextPageLabel,
          $page,
          $this->nextPageCssClass,
          $currentPage >= $pageCount - 1,
          false
        );

        // last page
        $buttons[] = $this->createPageButton(
          $this->lastPageLabel,
          $pageCount - 1,
          $this->lastPageCssClass,
          $currentPage >= $pageCount - 1,
          false
        );

        return $buttons;
    }

    /**
     * @return array the begin and end pages that need to be displayed.
     */
    protected function getPageRange()
    {
        $currentPage = $this->getCurrentPage();
        $pageCount = $this->getPageCount();

        $beginPage = max(0, $currentPage - (int) ($this->maxButtonCount / 2));
        if (($endPage = $beginPage + $this->maxButtonCount - 1) >= $pageCount) {
            $endPage = $pageCount - 1;
            $beginPage = max(0, $endPage - $this->maxButtonCount + 1);
        }
        return [$beginPage, $endPage];
    }

    /**
     * Registers the needed client scripts (mainly CSS file).
     */
    public function registerClientScript()
    {
        if ($this->cssFile !== false) {
            self::registerCssFile($this->cssFile);
        }
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        $this->registerClientScript();
        $buttons = $this->createPageButtons();
        if (empty($buttons)) {
            return;
        }
        echo $this->header;
        if (count($buttons) == 5) {
            echo '<div class="' . $this->owner->pagerCssClass . '">';
        }
        echo CHtml::tag('ul', $this->htmlOptions, implode("\n", $buttons));
        if (count($buttons) == 5) {
            echo '</div>';
        }
        echo $this->footer;
    }

    /**
     * Registers the needed CSS file.
     * @param string $url the CSS URL. If null, a default CSS URL will be used.
     */
    public static function registerCssFile($url = null)
    {
        if ($url === null) {
            $url = CHtml::asset(Yii::getPathOfAlias('system.web.widgets.pagers.pager') . '.css');
        }
        Yii::app()->getClientScript()->registerCssFile($url);
    }
}