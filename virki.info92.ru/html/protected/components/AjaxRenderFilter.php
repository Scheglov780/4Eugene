<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="AjaxRenderFilter.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

class AjaxRenderFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        if (Yii::app()->request->getIsAjaxRequest() && isset($_GET["ajax"])) {
            $method = 'ajaxRender';
            $selectedWidgetId = $_GET["ajax"];
            $selectedWidgetView = '_ajax' . $selectedWidgetId;
            if (in_array(
                get_class($filterChain->controller),
                ['SellerController', 'CategoryController', 'BrandController']
              )
              && $filterChain->action->id == 'index'
            ) {
                $selectedWidgetView = '/search/' . $selectedWidgetView;
            }
            $file = $filterChain->controller->getViewFile($selectedWidgetView);
            if (!$file) {
                $file = '_ajax' . $selectedWidgetId;
            }
            if (file_exists($file) && method_exists($filterChain->controller, $method)) {
                $content = $filterChain->controller->$method($selectedWidgetView);
                echo PostprocessFilter::filterTranslation($content);
                Yii::app()->end();
            }
            //else{
            //  throw new CHttpException(400,"CGridView handler function {$method} not defined in controller ".get_class($filterChain->controller));
            //}
        }
        return parent::preFilter($filterChain);
    }
}
