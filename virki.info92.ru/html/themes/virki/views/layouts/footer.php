<!--Footer Start-->
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-sm-6">
        <div class="widget fotinfo">
            <?= cms::customContent('kd:footerAbout') ?>
        </div>
      </div>
      <div class="clearfix hidden-lg hidden-xs"></div>
      <div class="col-lg-4 col-sm-6">
        <div class="widget">
          <h3 class="fotterTitle"><?= Yii::t('main', 'НАВИГАЦИЯ') ?></h3>
          <ul class="navigation">
              <?
              $sql = "
                        SELECT id,parent,order_in_level,page_id,url, enabled, \"SEO\",
                        (SELECT cc.title FROM cms_pages_content cc WHERE cc.page_id = pp.page_id
                        ORDER BY cc.lang=:lang DESC, cc.lang='*' DESC LIMIT 1) AS title,
                        (SELECT cc.description FROM cms_pages_content cc WHERE cc.page_id = pp.page_id
                        ORDER BY cc.lang=:lang DESC, cc.lang='*' DESC LIMIT 1) AS description
                        FROM cms_pages pp
                        WHERE (pp.parent NOT IN (SELECT pf.id FROM cms_pages pf WHERE pf.page_id LIKE '@%'))
                        AND id != parent
                        AND pp.order_in_level>=0
                        ORDER BY pp.parent=1 DESC, pp.parent, abs(pp.order_in_level), pp.id
                        ";
              $articles = Yii::app()->db->cache(YII_DEBUG ? 0 : 600)->createCommand($sql)->queryAll(
                true,
                [':lang' => Utils::appLang()]
              );
              ?>
              <? foreach ($articles as $article) {
                  if (!$article['enabled'] || !$article['title']) {
                      continue;
                  }
                  //print_r($article);
                  ?>
                <li>
                  <a class="footerNavigationLink"
                     href="<?= Yii::app()->createUrl('/article/' . $article['url']) ?>"
                    <? /* data-toggle="tooltip" data-placement="bottom"
                                   title="<?= Yii::t('main', $article['description']) ?>"*/ ?>
                  ><?= Yii::t(
                        'main',
                        $article['title']
                      ) ?></a>
                </li>
              <? } ?>
            <li>
              <a class="footerNavigationLink" href="<?= Yii::app()->createUrl('/news/') ?>"
                <? /* data-toggle="tooltip" data-placement="bottom"
                                   title="<?= Yii::t('main', $article['description']) ?>"*/ ?>
              ><?= Yii::t(
                    'main',
                    'Новости'
                  ) ?></a>
            </li>
            <li>
              <a class="footerNavigationLink" href="<?= Yii::app()->createUrl('/adverts/') ?>"
                <? /* data-toggle="tooltip" data-placement="bottom"
                                   title="<?= Yii::t('main', $article['description']) ?>"*/ ?>
              ><?= Yii::t(
                    'main',
                    'Объявления'
                  ) ?></a>
            </li>
            <li>
              <a class="footerNavigationLink" href="<?= Yii::app()->createUrl('/votings/') ?>"
                <? /* data-toggle="tooltip" data-placement="bottom"
                                   title="<?= Yii::t('main', $article['description']) ?>"*/ ?>
              ><?= Yii::t(
                    'main',
                    'Голосования'
                  ) ?></a>
            </li>
            <li>
              <a class="footerNavigationLink" href="<?= Yii::app()->createUrl('/polls/') ?>"
                <? /* data-toggle="tooltip" data-placement="bottom"
                                   title="<?= Yii::t('main', $article['description']) ?>"*/ ?>
              ><?= Yii::t(
                    'main',
                    'Опросы'
                  ) ?></a>
            </li>
            <li>
              <a class="footerNavigationLink" href="<?= Yii::app()->createUrl('/blanks/') ?>"
                <? /* data-toggle="tooltip" data-placement="bottom"
                                   title="<?= Yii::t('main', $article['description']) ?>"*/ ?>
              ><?= Yii::t(
                    'main',
                    'Полезные файлы'
                  ) ?></a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6">
        <div class="widget">
          <h3 class="fotterTitle"><?= Yii::t('main', 'КОНТАКТЫ') ?></h3>
            <?= cms::customContent('kd:footerContacts') ?>
          <div class="footerSocial">
              <?= cms::customContent('kd:footerSocial') ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<!--Footer End-->
<!--Copy Right start-->
<section class="copyright">
  <div class="container">
    <div class="row">
      <div class="col-sm-6 col-xs-12">
        <p><?= Yii::t('main', 'Разработка и сопровождение') ?>: <a href="https://info92.ru">Info92 team</a></p>
      </div>
      <div class="col-sm-6 col-xs-12">
          <? if (date('Y') == '2020') {
              $copyrightYers = '2020';
          } else {
              $copyrightYers = '2020-' . date('Y');
          } ?>
        <p>&copy; <?= $copyrightYers ?>, <a
              href="//<?= DSConfig::getVal('site_domain') ?>"><?= DSConfig::getVal(
                  'site_name'
                ) ?></a>, <?= Yii::t('main', 'все права защищены') ?></p>
      </div>
    </div>
  </div>
</section>
<!--Copy Right End-->
