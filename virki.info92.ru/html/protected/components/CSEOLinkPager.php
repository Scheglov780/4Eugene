<?php

/**
 * CSEOLinkPager class file.
 */
class CSEOLinkPager extends CLinkPager
{
    public $linkHtmlOptions = [];
    public $maxButtonCountMobile = 4;

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
        // Не нужно, пожалуйста, ставить здесь больше 10. Иначе поисковики мгновенно выберут все лимиты по получению данных с таобао - а эти лимиты существуют.
        if ($page >= 10 && Yii::app()->user->isGuest) {
            if (get_class($this->owner) != 'TbListView') {
                $result = '<li class="' . $class . '">' . CHtml::link(
                    $label,
                    Yii::app()->createUrl('/user/login'),
                    $this->linkHtmlOptions
                  ) . '</li>';
            } else {
                $result = '';
            }
        } else {
            $result = '<li class="' . $class . '">' . CHtml::link(
                $label,
                $this->createPageUrl($page),
                $this->linkHtmlOptions
              ) . '</li>';
        }
        return $result;

    }

    public function run()
    {
        $mobile = new Mobile_Detect();
        if ($mobile->isMobile()) {
            $this->maxButtonCount = $this->maxButtonCountMobile;
        }
        parent::run();
    }
}
