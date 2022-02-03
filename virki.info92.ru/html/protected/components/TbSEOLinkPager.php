<?php

/**
 * CSEOLinkPager class file.
 */
class TbSEOLinkPager extends TbPager
{
    public $headerLink = '';
    public $htmlOptions = ['class' => 'pagination'];
    public $linkHtmlOptions = [];
    public $maxButtonCountMobile = 4;
    public $showEmptyPager = false;

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
            $class = trim($class . ' ' . ($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass));
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

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        $mobile = new Mobile_Detect();
        if ($mobile->isMobile()) {
            $this->maxButtonCount = $this->maxButtonCountMobile;
        }
        $this->registerClientScript();
        $buttons = $this->createPageButtons();
        if (empty($buttons) && !$this->showEmptyPager) {
            return;
        }
        if ($this->headerLink) {
            echo $this->headerLink;
        }
        echo CHtml::openTag($this->containerTag, $this->containerHtmlOptions);
        echo $this->header;
        echo CHtml::tag('ul', $this->htmlOptions, implode("\n", $buttons));
        echo '<div style="clear: both;"></div>';
        echo $this->footer;
        echo CHtml::closeTag($this->containerTag);
    }

}
