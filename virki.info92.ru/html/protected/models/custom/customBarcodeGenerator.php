<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BarcodeGenerator.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/*---------------------------------------------------------------------------------
  Name :
	Standard / Traditional Barcode Generator
  Description :
	This is an extension to generate a standard / traditional barcode (as images). 
  Author :
	144key
-----------------------------------------------------------------------------------*/

class customBarcodeGenerator
{
    public $bcHeight, $bcThinWidth, $bcThickWidth, $bcFontSize, $mode, $fontSize, $outMode, $codeMap;

    public function build($text = '', $showText = false, $fileName = null)
    {
        if (trim($text) <= ' ') {
            throw new exception('barcodeGenerator::build - must be passed text to operate');
        }
        if (!$fileType = $this->outMode[$this->mode]) {
            throw new exception("barcodeGenerator::build - unrecognized output format ({$this->mode})");
        }
        if (!function_exists("image{$this->mode}")) {
            throw new exception("barcodeGenerator::build - unsupported output format ({$this->mode} - check phpinfo)");
        }

        $text = strtoupper($text);
        $dispText = '*   ' . preg_replace('/(.{1})/', '\1 ', $text) . '   *';
        //$dispText = '*' . $text . '*';
        $text = "*$text*";
        $textLen = strlen($text);
        $barcodeWidth = $textLen * (7 * $this->bcThinWidth + 3 * $this->bcThickWidth) - $this->bcThinWidth;
        $im = imagecreate($barcodeWidth, $this->bcHeight + 27);
        $black = imagecolorallocate($im, 0, 0, 0);
        $white = imagecolorallocate($im, 255, 255, 255);
        imagefill($im, 0, 0, $white);

        $xpos = 0;
        for ($idx = 0; $idx < $textLen; $idx++) {
            if (!$char = $text[$idx]) {
                $char = '-';
            }
            for ($ptr = 0; $ptr <= 8; $ptr++) {
                $elementWidth = ($this->codeMap[$char][$ptr]) ? $this->bcThickWidth : $this->bcThinWidth;
                if (($ptr + 1) % 2) {
                    imagefilledrectangle($im, $xpos, 0, $xpos + $elementWidth - 1, $this->bcHeight, $black);
                }
                $xpos += $elementWidth;
            }
            $xpos += $this->bcThinWidth;
        }

        if ($showText) {
            $fontWidth = imagefontwidth($this->fontSize);
            $pxWid = $fontWidth * mb_strlen($dispText) + 10;
            $pxHt = imagefontheight($this->fontSize) - 15;
            $bigCenter = $barcodeWidth / 2;
            $textCenter = $pxWid / 2;
            imagefilledrectangle(
              $im,
              $bigCenter - $textCenter,
              $this->bcHeight - $pxHt,
              $bigCenter + $textCenter,
              $this->bcHeight,
              $white
            );
            imagestring(
              $im,
              $this->fontSize,
              ($bigCenter - $textCenter) + 5,
              ($this->bcHeight - $pxHt) + 1,
              $dispText,
              $black
            );
        }

        if (!$fileName) {
            header("Content-type:  image/{$fileType}");
        }
        switch ($this->mode) {
            case 'gif':
                imagegif($im, $fileName);
                break;
            case 'png':
                imagepng($im, $fileName, 0, PNG_NO_FILTER);
                break;
            case 'jpeg':
                imagejpeg($im, $fileName, 100);
                break;
            case 'wbmp':
                imagewbmp($im, $fileName);
                break;
            default:
                imagejpeg($im, $fileName);
                break;
        }

        imagedestroy($im);
    }

    public function init($mode = 'png', $height = 50, $thin = 2, $thick = 3, $fSize = 2)
    {
        $this->bcHeight = $height;
        $this->bcThinWidth = $thin;
        $this->bcThickWidth = $this->bcThinWidth * $thick;
        $this->fontSize = $fSize;
        $this->mode = $mode;
        $this->outMode = ['gif' => 'gif', 'png' => 'png', 'jpeg' => 'jpeg', 'wbmp' => 'vnd.wap.wbmp'];
        $this->codeMap = [
          '-' => '000110100',
          '1' => '100100001',
          '2' => '001100001',
          '3' => '101100000',
          '4' => '000110001',
          '5' => '100110000',
          '6' => '001110000',
          '7' => '000100101',
          '8' => '100100100',
          '9' => '001100100',
          'A' => '100001001',
          'B' => '001001001',
          'C' => '101001000',
          'D' => '000011001',
          'E' => '100011000',
          'F' => '001011000',
          'G' => '000001101',
          'H' => '100001100',
          'I' => '001001100',
          'J' => '000011100',
          'K' => '100000011',
          'L' => '001000011',
          'M' => '101000010',
          'N' => '000010011',
          'O' => '100010010',
          'P' => '001010010',
          'Q' => '000000111',
          'R' => '100000110',
          'S' => '001000110',
          'T' => '000010110',
          'U' => '110000001',
          'V' => '011000001',
          'W' => '111000000',
          'X' => '010010001',
          'Y' => '110010000',
          'Z' => '011010000',
          ' ' => '011000100',
          '$' => '010101000',
          '%' => '000101010',
          '*' => '010010100',
          '+' => '010001010',
          '0' => '010000101',
          '.' => '110000100',
          '/' => '010100010',
        ];
        return $this;
    }
}
