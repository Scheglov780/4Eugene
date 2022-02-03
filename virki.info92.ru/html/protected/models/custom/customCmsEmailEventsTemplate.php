<? //Письмо клиентам о нефинансовых изменениях в свойствах заказа ?>
<mail>
  <from><?= 'support@' . DSConfig::getVal('site_domain'); ?></from>
  <fromName><?= 'Cлужба поддержки ' . DSConfig::getVal('site_name'); ?></fromName>
  <subj><?= 'Изменение Вашего заказа ' . str_pad($new->uid, 4, '0', STR_PAD_LEFT) . '-' . str_pad(
        $new->id,
        4,
        '0',
        STR_PAD_LEFT
      ) . ' на ' . DSConfig::getVal('site_name'); ?></subj>
</mail>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="viewport" content="width=device-width"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <style>
    * {
      margin: 0;
      padding: 0;
      font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
      font-size: 100%;
      line-height: 1.6
    }

    img {
      max-width: 100%
    }

    body {
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: none;
      width: 100% !important;
      height: 100%
    }

    a {
      color: #348eda
    }

    .btn-primary {
      text-decoration: none;
      color: #FFF;
      background-color: #348eda;
      border: solid #348eda;
      border-width: 10px 20px;
      line-height: 2;
      font-weight: bold;
      margin-right: 10px;
      text-align: center;
      cursor: pointer;
      display: inline-block;
      border-radius: 25px
    }

    .btn-secondary {
      text-decoration: none;
      color: #FFF;
      background-color: #aaa;
      border: solid #aaa;
      border-width: 10px 20px;
      line-height: 2;
      font-weight: bold;
      margin-right: 10px;
      text-align: center;
      cursor: pointer;
      display: inline-block;
      border-radius: 25px
    }

    .last {
      margin-bottom: 0
    }

    .first {
      margin-top: 0
    }

    .padding {
      padding: 10px 0
    }

    table.body-wrap {
      width: 100%;
      padding: 20px
    }

    table.body-wrap .container {
      border: 1px solid #f0f0f0
    }

    table.footer-wrap {
      width: 100%;
      clear: both !important
    }

    .footer-wrap .container p {
      font-size: 12px;
      color: #666
    }

    table.footer-wrap a {
      color: #999
    }

    h1, h2, h3 {
      font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
      line-height: 1.1;
      margin-bottom: 15px;
      color: #000;
      margin: 40px 0 10px;
      line-height: 1.2;
      font-weight: 200
    }

    h1 {
      font-size: 36px
    }

    h2 {
      font-size: 28px
    }

    h3 {
      font-size: 22px
    }

    p, ul, ol {
      margin-bottom: 10px;
      font-weight: normal;
      font-size: 14px
    }

    ul li, ol li {
      margin-left: 5px;
      list-style-position: inside
    }

    .container {
      display: block !important;
      max-width: 600px !important;
      margin: 0 auto !important;
      clear: both !important
    }

    .body-wrap .container {
      padding: 20px
    }

    .content {
      max-width: 600px;
      margin: 0 auto;
      display: block
    }

    .content table {
      width: 100%
    }
  </style>
</head>
<body bgcolor="#f6f6f6">
<!-- body -->
<table class="body-wrap">
  <tr>
    <td></td>
    <td class="container" bgcolor="#FFFFFF">
      <!-- content -->
      <div class="content">
        <table>
          <tr>
            <td bgcolor="#348eda" style="color: #ffffff !important;">
              &nbsp;<a style="color: #ffffff !important;"
                       href="http://<?= DSConfig::getVal('site_domain') ?>"><b><?= DSConfig::getVal(
                          'site_name'
                        ) ?></b>:</a> <?= cms::customContent('default-meta-title', false, true) ?>
            <td>
          <tr>
          <tr>
            <td>
              <!-- ========================================================================================== -->
              <h3>Уважаемый(ая) <?= $recipient->fullname ?>!</h3>
              <p>Сообщаем, что Ваш <a target="_blank" href="<?= Order::getUserLink($new->id) ?>">заказ
                  №<?= str_pad($new->uid, 4, '0', STR_PAD_LEFT) . '-' . str_pad(
                        $new->id,
                        4,
                        '0',
                        STR_PAD_LEFT
                      ) ?></a> от <?= date("d-m-Y H:i", $new->date); ?> изменён:</p>
              <p>
                  <? if ($comparedFields) { ?>
              <table>
                <tr>
                  <th>Параметр</th>
                  <th>Было</th>
                  <th>Стало</th>
                </tr>
                  <? foreach ($comparedFields as $fieldName => $field) { ?>
                    <tr>
                      <td><?= $field->label ?></td>
                      <td>
                        <s><?= ($fieldName == 'status') ? OrdersStatuses::getStatusName(
                              $field->old
                            ) : $field->old ?></s>
                      </td>
                      <td>
                          <?= ($fieldName == 'status') ? OrdersStatuses::getStatusName(
                            $field->new
                          ) : $field->new ?>
                      </td>
                    </tr>
                  <? } ?>
              </table>
                <? } ?>
              </p>
              <p>- все суммы отображаются в <?= strtoupper(DSConfig::getVal('site_currency')) ?></p>
              <h3>Лоты заказа:</h3>
              <table>
                <tr>
                  <td>
                      <?
                      echo Order::getOrderItemsPreview($new->id, '_60x60.jpg', 1000, false);
                      ?>
                  </td>
                </tr>
              </table>
              <p>Благодарим Вас за выбор нашего магазина!</p>
              <!-- =================================================================================================================== -->
            </td>
          </tr>
        </table>
      </div>
      <!-- /content -->
    </td>
    <td></td>
  </tr>
</table>
<!-- /body -->
<!-- footer -->
<table class="footer-wrap">
  <tr>
    <td></td>
    <td class="container">
      <!-- content -->
      <div class="content">
        <table>
          <tr>
            <td align="center">
              <p>Возникли трудности или вопросы? <a
                    href="mailto:<?= 'support@' . DSConfig::getVal('site_domain'); ?>">
                  <unsubscribe>Служба поддержки <?= 'support@' . DSConfig::getVal(
                        'site_name'
                      ); ?></unsubscribe>
                </a>.
              </p>
            </td>
          </tr>
        </table>
      </div>
      <!-- /content -->

    </td>
    <td></td>
  </tr>
</table>
<!-- /footer -->
</body>
</html>