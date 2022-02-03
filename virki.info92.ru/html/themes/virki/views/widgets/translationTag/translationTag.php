<? // Рендеринг перевода
try {
    $path = Yii::getPathOfAlias('application.extensions.simple_html_dom.simple_html_dom') . '.php';
    if (file_exists($path)) {
        include_once($path);
        if (!function_exists('prepareTranslateTag')) {
            function prepareTranslateTag(&$tag)
            {
                $tag->outertext = '';
            }
        }
        if (!function_exists('prepareTranslationTag')) {
            function prepareTranslationTag(&$tag, $idPostfix)
            {
                if (($tag->getAttribute('editable') == 0)) {
                    if (Yii::app()->user->checkAccess('site/translate')) {
                        $tag->setAttribute('editable', '1');
                        $tag->setAttribute('url', DSConfig::getVal('translator_block_mode_url'));
                    }
                } elseif (($tag->getAttribute('editable') == 1)) {
                    if (!Yii::app()->user->checkAccess('site/translate')) {
                        $tag->setAttribute('editable', '0');
                        $tag->removeAttribute('url');
                    }
                }

                if ($tag->getAttribute('editable') == 1 && $tag->getAttribute('translated') == 1) {
                    $tag->setAttribute('title', Yii::t('main', 'Перевод - правый клик'));
                    $editable = true;
                } else {
                    //$tag->removeAttribute('title');
                    $tag->removeAttribute('url');
                    $editable = false;
                }
                $tag->setAttribute('id', $tag->getAttribute('id') . '-' . $idPostfix);
                $tag->setAttribute('data-toggle', 'tooltip');
                //$tag->setAttribute('data-placement','bottom');
                return $editable;
            }
        }
        $editable = false;
        $dom = str_get_html($srcTranslation);
        if ($dom) {
            $translateTags = $dom->find('translate');
            if (is_array($translateTags)) {
                foreach ($translateTags as $translateTag) {
                    prepareTranslateTag($translateTag);
                }
            } else {
                prepareTranslateTag($translateTags);
            }
            unset($translateTags);
            $translationTags = $dom->find('translation');
            if (is_array($translationTags)) {
                foreach ($translationTags as $subIndex => $translationTag) {
                    $idPostfix = $index . '-' . $subIndex;
                    if (prepareTranslationTag($translationTag, $idPostfix)) {
                        $editable = true;
                    }
                }
            } else {
                $idPostfix = $index;
                if (prepareTranslationTag($translationTags, $idPostfix)) {
                    $editable = true;
                }
            }
            $result = $dom->save();
            $dom->clear();
            unset($dom);
            echo $result;
        } else {
            echo $srcTranslation;
        }
//=====================================
        /*        if ($editable && $last) { ?>
                    <script>
                        $(document).ready(function() {
            var editableTranslations = $('translation[editable=1]');
            if (editableTranslations.length > 0) {
                console.log('Online translation editing enabled');
                $(editableTranslations).each(function () {
                    //$(this).oncontextmenu = function() {return false;};
                    $(this).on('contextmenu', function (e) {
                        e.preventDefault();
                        return false;
                    });
                    $(this.parentNode).on('contextmenu', function (e) {
                        e.preventDefault();
                        return false;
                    });
                    $(this).mousedown(function (e) {
                        if (e.which == 3) { //e.button = 2
                            var type = $(this).attr('type');
                            var idAndMode = $(this).attr('id');
                            console.log('Online translation: ' + idAndMode);
                            idAndMode = idAndMode.replace(type, '');
                            var id = idAndMode.replace(/([\d\-]+).+/i, '$1');
                            var mode = idAndMode.replace(/[\d\-]+(.+)/i, '$1');
                            editTranslation(e, this, type, id, mode);
                            stopPropagation(e);
                            return false;
                        }
                        return true;
                    });
                });
            }
                        });
                    </script>
                 <? } */
//=====================================
    } else {
        echo $srcTranslation;
    }
} catch (Exception $e) {
    echo $srcTranslation;
}