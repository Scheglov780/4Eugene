<?php

class tmessage extends ArrayObject
{
    public function __toString()
    {
        if (isset($this[Yii::app()->sourceLanguage])) {
            return $this[Yii::app()->sourceLanguage];
        } else {
            return 'Сообщение отсутствует';
        }
    }
}