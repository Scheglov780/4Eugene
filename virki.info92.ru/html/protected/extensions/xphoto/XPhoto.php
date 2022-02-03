<?php
/**
 * XPhoto - Extension to upload photo and capture from webcam or camera using HTML5
 * Licenced under WTFPL - http://wtfpl.net
 * ---------------------------------------
 * Project page:
 * - http://www.yiiframework.com/extension/xphoto/
 * - https://github.com/khayatzen/xphoto
 * --------------------------------------------------------------------------------
 * @author Muhammad Khayat - khayat@infest.or.id
 * Blog: http://yat.my.id
 */

/**
 * Requirements:
 * - Twitter Bootstrap
 * - Yii 1.1 above
 */

/**
 * How to use it:
 * -----------------------------------------
 * $this->widget('ext.xphoto.XPhoto',array(
 *    'model'=>$model,
 *    'attribute'=>'user_photo',
 * ));
 * -----------------------------------------
 */
class XPhoto extends CWidget
{

    /**
     * attribut of model
     */
    public $attribute;
    /**
     * ID of canvas element
     */
    public $canvasID = 'xphoto-canvas';
    /**
     * Using capture
     * if true, XPhoto capture from your webcam or camera which attached on your computer
     */
    public $capture = true;

    //public $allowedExtensions = array('jpg','jpeg','png');
    public $cssFile;
    /**
     * height of photo canvas : in pixel
     */
    public $height = 350;
    public $htmlOptions = [];
    public $id;
    /**
     * model name for active field
     */
    public $model;
    /**
     * ID of photo element
     */
    public $photoID = 'xphoto-photo';
    public $photoUrl;
    /**
     * Using upload file
     * if true, XPhoto will enable file upload from computer harddrive
     */
    public $upload = false;
    /**
     * ID of video element
     */
    public $videoID = 'xphoto-video';
    /**
     * width of photo canvas : in pixel
     */
    public $width = 300;
    /**
     * Modal dialog for capture photo
     * if modal is true, when capturing photo the modal will shown as capture media container
     */
    public $withModal = true;

    public function registerScript()
    {
        if (defined('YII_DEBUG') && YII_DEBUG == true) {
            $baseScriptUrl =
              Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.xphoto.assets'), false, 1, YII_DEBUG);
        } else {
            $baseScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.xphoto.assets'));
        }

        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseScriptUrl . '/css/xphoto.css');
        $cs->registerScriptFile($baseScriptUrl . '/js/xphoto.js', CClientScript::POS_HEAD);
        $options = [
          'upload'      => $this->upload,
          'capture'     => $this->capture,
          'videoID'     => $this->videoID,
          'canvasID'    => $this->canvasID,
          'photoWidth'  => $this->width,
          'photoHeight' => $this->height,
          'withModal'   => $this->withModal,
          'inputID'     => CHtml::activeID($this->model, $this->attribute),
          'photoUrl'    => $this->photoUrl,
            //'autostart'=> true,
        ];
        $cs->registerScript(
          $this->id . '_xphoto',
          "			
			var xphoto = new XPhoto(" . CJavaScript::encode($options) . ");			
		"
        );
    }

    public function run()
    {
        if (isset($this->htmlOptions['id'])) {
            $id = $this->htmlOptions['id'];
        } else {
            $id = $this->htmlOptions['id'] = $this->getId();
        }

        if (isset($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] .= ' xphoto';
        } else {
            $this->htmlOptions['class'] = 'xphoto';
        }

        echo CHtml::openTag('div', $this->htmlOptions);
        echo '<div id="xphoto-modal-container" style="position:absolute;"></div>';

        $videoOptions = [
          'id'     => $this->videoID,
          'width'  => $this->width,
          'height' => $this->height,
        ];
        $canvasOptions = [
          'id'     => $this->canvasID,
          'width'  => $this->width,
          'height' => $this->height,
        ];
        $videoContainerOptions = [
          'class' => 'xphoto-video-container',
          'style' => 'width:' . $this->width . 'px;height:' . $this->height . 'px;',
        ];
        if (isset($this->photoUrl)) {
            $videoContainerOptions['style'] .= 'background-image:url("' . $this->photoUrl . '");';
        }
        echo CHtml::openTag('div', $videoContainerOptions);
        if ($this->capture) {
            echo CHtml::openTag('video', $videoOptions);
            echo CHtml::closeTag('video');
        }
        echo CHtml::closeTag('div');

        echo CHtml::openTag('canvas', $canvasOptions);
        echo CHtml::closeTag('canvas');

        if ($this->upload) {
            $photoOptions = [
              'id'     => $this->photoID,
              'width'  => $this->width,
              'height' => $this->height,
            ];
            echo CHtml::openTag('div', $photoOptions);
            echo CHtml::closeTag('div');
            echo '<input type="file" id="xphoto-input-file" name="xphoto-input-file" style="display:none;">';
        }
        echo '<div class="xphoto-buttons"></div>';
        echo CHtml::activeHiddenField($this->model, $this->attribute);
        echo CHtml::closeTag('div');

        $this->registerScript();
    }
}