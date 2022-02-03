<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8"/>
  <meta name="title" content="Форма ПД-4"/>
  <meta name="description" content="Печать формы ПД-4"/>
  <title>Форма ПД-4</title>
  <!--    <link rel="stylesheet" href="PD4.css" media="screen"> -->
  <link rel="stylesheet" href="<?= $this->frontThemePath ?>/views/blanks/billPrint.css" media="screen,print">
</head>
<body>
<section class="blank-section">
    <? /** @var Bills $bill */ ?>
  <table class="blank">
    <tbody>
    <tr>
      <td class="pole1">
        <table>
          <tbody>
          <tr>
            <td class="pole11">
              Извещение
            </td>
          </tr>
          <tr>
            <td class="pole12">
              Кассир
            </td>
          </tr>
          </tbody>
        </table>
      </td>
      <td class="pole2">
        <table>
          <tbody>
          <tr>
            <td colspan="2" width="120" height="26">
              <!-- <object style="width: 120px; height: 26px;" data="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAA/BAMAAACoZujHAAAAElBMVEUAAAAzMzNmZmaZmZnMzMz///+pQRfJAAAFdklEQVRo3u2ZQY+cRhBGH9B1x06443W4Y2+4I9nce4Dv//+VHKq7YWbWUSLNKqNokXaHgR76UfVVVVOgp9z4wPqfYG1D+X4ZngcrkmE27Jmwsi+hexqssXD1hD48C1aLtTSSeixSPwnWLhAERRDPIS6k2ZwH+AzdGJ4DK2IRfgIDhPgU5kJSxKCOhJFqhudw4gXB0BI0ww6KgySt7W+LD/mp5T/AipB8CNOIuRd7AHPFgdLOcWD1zy6lvfQT00g97BC0Vq9+rgKP7h9faDxnt7RI0jfAtFajaasw9T5TnbDUwwZMPeaxGHkTKzguhDVzOlaQNINpptIOjaKLYQVaCNJcxvfQMkkjtKANzP85EZWEZkAjIWKRINI5mpHGLbAhRehE45YBdmikgtX4x+KJGUyxynXDBH73LtwZJEwXMMU0XG7qkL9pBFBL2Fe3m1/DpLlcaEp1oHG8Nie4zXxm6lzCClbfHVgRNNKl2ubusHRJytFBc+ZTAmGDCpbZfTbClIUnSZPzLbMiDMkCJuk1YXlAMyRTYNtRZS3l6UXqyTQK6QpxyUMmzdmbQi0A9Qp0lyQln8eLpS8uZphmF910wtoliTZjFSFWXGOFmIYERcJxpqwPWpBGzBVarIWt2EbBSsqIAL/rEGyEIeYY8MBaG4eP1/FhZ20pY6ExndlgyUOGFZg0OsIZi0GZCpELdo5I3zmFqDKCFEMsxD59D+UKULXFdeeqe7WaapO2wmgJa84wf3DCagrWb0CnCMtcJ6xOEoSLJ4bYbBlLJyzynOlkfY9VrIUJOo3Q6BaLM9bhRG1QpwhzrCU7Z4ZFLs4rrJYmD1Pacdts5zXKGWuRO5FOrWPFO6pa5V6zjHxnLxm9RFh2Z32TIK7GFazLCWs7OTFIMOUs/wssu8GKsGQllNDkyDGVu+yM1elNLK8oTcY6RaJgUU9Qttb6NtZwhTUkLIuHc8zvc0OXOyzTmDR/YE1+Nh6qK1jKWOa5TaXcnbZJs4tZyw3Wxa4vCkGxkVqYbrDywDR5jooqUUg6BauUtGXFWvdYLuxJil2ERXMpZ/21tTYwpSRr91jL2SbQeL5MRy7JgOpc+wUraesuFKtcTzamCLZ7zcQ0+oEyzQgmfollZ6wRtCe7MGT1LIqdoNPmQXiU6jvN21FIvI7jC4tTEVdJvbpgcnHldOrrrYsPXDPWCk3Kc6QKMQM901buwtc0CevWi4tyseF2vYVyyYn5Fuac+z0r9mAZMsXeuY4de5YnLqb2BLCnZeCtF09XabT2fH75ukjfPn39/kKn9VOb4ufHy+c/Je3fJkk/vnzV9vIq7fvrpP3lp/T6msaVJfePl7SztynQt+9fPkn7d0laTn9KSe7Gh8/Rg+jvfPgcjaRnM5ZyS+SUtJ6oG9gfGf6pmpTzU1EdvdOtp/7jo6X7gfXg1sg7b9XN90/gnYlfbd5Iep+t/Ru66p7pfOhDW/8brLb6N7/YFkl/vj9W/48L9FyrdFQkjfaOWCtNz/m92P7LwS0SNqMLvXIv8N3yVhexHSwiTKlDaoLGIfK63DuKFvMjaH4YMfU+yCLqH4Q1Mu3UI4SINw+YgGbLjxjXWH3qiRxYLzZX1IoBi6h+ENZMd5rdeiKGUe8WDyxLbZeERWQpWMmCs7CN3+1hTrQTVoCVABCB5cR7Qkgtu/YKq3EFDA/DChcC6fHacGt5pZwILpsuY21YZEkNwSvUIEwjD0sQ4K0PZsBmYGrTs6rRjPirCJM0IlEnt56xqp7Intrsj3pxh795CJEXbMffEoQdGDwSL+k5rUXed/DpC9YFhkhLo1g/LstvOWcvb+Ws2+fG/e0HyXHSjqI9Dutx2/wgxT8Y61HS+ljY/KvtL/JnRYhTUXPeAAAAAElFTkSuQmCC" width="120" height="26">СБЕРБАНК РОССИИ</object> -->
            </td>
            <td class="italic">
              Форма № ПД-4
            </td>
          </tr>
          <tr>
            <td class="btext">
                <? // Название получателя
                $acceptor = json_decode($bill->j_acceptor);
                echo $acceptor->name ?>
            </td>
            <td>КПП&nbsp;
            </td>
            <td>
              <table class="btext2">
                <colgroup>
                  <col class="cell" span="9">
                </colgroup>
                <tbody>
                <tr>
                    <? // КПП получателя
                    echo preg_replace('/(\d)/', '<td>\1</td>', $acceptor->KPPacceptor);
                    ?>
                </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td class="subtext">
              (наименование получателя платежа)
            </td>
            <td colspan="2">
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td>
              <table class="btext2">
                <colgroup>
                  <col class="cell" span="10">
                </colgroup>
                <tbody>
                <tr>
                    <? // ИНН получателя
                    echo preg_replace('/(\d)/', '<td>\1</td>', $acceptor->INN);
                    ?>
                </tr>

                </tbody>
              </table>
            </td>
            <td rowspan="2" class="text-small">
            </td>
            <td>
              <table class="btext2">
                <colgroup>
                  <col class="cell" span="20">
                </colgroup>
                <tbody>
                <tr>
                    <? // Счёт получателя
                    echo preg_replace('/(\d)/', '<td>\1</td>', $acceptor->schet);
                    ?>
                </tr>

                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td class="subtext">
              (ИНН получателя платежа)
            </td>
            <td class="subtext">
              (номер счета получателя платежа)
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td>
              в&nbsp;
            </td>
            <td class="btext">
                <? // Название банка получателя
                echo $acceptor->bank;
                ?>
            </td>
            <td>
              &nbsp;БИК&nbsp;
            </td>
            <td>
              <table class="btext2">
                <colgroup>
                  <col class="cell" span="9">
                </colgroup>
                <tbody>
                <tr>
                    <? // БИК банка
                    echo preg_replace('/(\d)/', '<td>\1</td>', $acceptor->BIK);
                    ?>
                </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td>
            </td>
            <td class="subtext">
              (наименование банка получателя платежа)
            </td>
            <td colspan="2">
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td class="text-small text-left">
              Номер кор./сч. банка получателя платежа&nbsp;
            </td>
            <td>
              <table class="btext2">
                <colgroup>
                  <col class="cell" span="20">
                </colgroup>
                <tbody>
                <tr>
                    <? // Коррсчет банка
                    echo preg_replace('/(\d)/', '<td>\1</td>', $acceptor->korrSchet);
                    ?>
                </tr>

                </tbody>
              </table>
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td class="line1">
                <? // Название получателя
                $land = json_decode($bill->j_land); ?>
              <span class="payment-name">№ уч. <span class="nomer"><?= $land->land_number ?></span>
                                <? $tariff = json_decode($bill->j_tariff); ?>
                  <?= $tariff->tariff_name ?></span>
            </td>
          </tr>
          <tr>
            <td class="subtext">
              (наименование платежа)
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td>
              Ф.И.О.&nbsp;плательщика&nbsp;
            </td>
            <td class="btext">
                <? $user = json_decode($bill->j_user); ?>
              <span class="fio"><?= $user->fullname ?></span>
            </td>
          </tr>
          <tr>
            <td>
              Адрес&nbsp;плательщика&nbsp;
            </td>
            <td class="btext">
              <span class="fio"><?= $user->post_address ?></span>
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td>Сумма&nbsp;платежа&nbsp;
            </td>
            <td class="line3">
              <span class="rubas"><?= Formulas::cRound($bill->manual_summ ? $bill->manual_summ : $bill->summ) ?></span>
            </td>
            <td>&nbsp;руб.&nbsp;
            </td>
            <td class="line3 rubas">
              &nbsp;&nbsp;00
            </td>
            <td>&nbsp;коп.&nbsp;
            </td>
            <td>&nbsp;&nbsp;&nbsp;
            </td>
            <td>Сумма&nbsp;платы&nbsp;за&nbsp;услуги&nbsp;
            </td>
            <td class="line3">
            </td>
            <td>&nbsp;руб.&nbsp;
            </td>
            <td class="line3">
            </td>
            <td>&nbsp;коп.&nbsp;
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td>Итого&nbsp;
            </td>
            <td class="line3">
            </td>
            <td>&nbsp;руб.&nbsp;
            </td>
            <td class="line3">
            </td>
            <td>&nbsp;коп.&nbsp;
            </td>
            <td class="space2">
            </td>
            <td>«&nbsp;
            </td>
            <td class="line4">
            </td>
            <td>&nbsp;»&nbsp;
            </td>
            <td class="line5">
            </td>
            <td>&nbsp;20&nbsp;
            </td>
            <td class="line6">
            </td>
            <td>&nbsp;г.
            </td>
          </tr>
          </tbody>
        </table>
        <p class="text-small text-left">
          С условиями приема указанной в платежном документе суммы, в&nbsp; т.ч.&nbsp; с&nbsp; суммой
          взымаемой
          платы за услуги<br>банка, ознакомлен и согласен.<br>
        </p>
        <table class="text-right">
          <tbody>
          <tr>
            <td>
            </td>
            <td class="text-small text-right">
              Подпись&nbsp;плательщика&nbsp;
            </td>
            <td class="line7">
            </td>
          </tr>
          </tbody>
        </table>
        <div class="space1">
        </div>
      </td>
    </tr>
    <tr>
      <td class="pole3 pole3t">
        Квитанция
      </td>
      <td rowspan="2" class="pole4">
        <br><br>

        <table>

          <tbody>
          <tr>
            <td class="btext">
                <?= $acceptor->name ?>
            </td>
            <td>КПП&nbsp;
            </td>
            <td>
              <table class="btext2">
                <colgroup>
                  <col class="cell" span="9">
                </colgroup>
                <tbody>
                <tr>
                    <? // КПП получателя
                    echo preg_replace('/(\d)/', '<td>\1</td>', $acceptor->KPPacceptor);
                    ?>
                </tr>

                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td class="subtext">
              (наименование получателя платежа)
            </td>
            <td colspan="2">
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td>
              <table class="btext2">
                <colgroup>
                  <col class="cell" span="10">
                </colgroup>
                <tbody>
                <tr>
                    <? // ИНН получателя
                    echo preg_replace('/(\d)/', '<td>\1</td>', $acceptor->INN);
                    ?>
                </tr>

                </tbody>
              </table>
            </td>
            <td rowspan="2" class="text-small">
            </td>
            <td>
              <table class="btext2">
                <colgroup>
                  <col class="cell" span="20">
                </colgroup>
                <tbody>
                <tr>
                    <? // Счёт получателя
                    echo preg_replace('/(\d)/', '<td>\1</td>', $acceptor->schet);
                    ?>
                </tr>

                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td class="subtext">
              (ИНН получателя платежа)
            </td>
            <td class="subtext">
              (номер счета получателя платежа)
            </td>
          </tr>
          </tbody>
        </table>
        <br>
        <table>
          <tbody>
          <tr>
            <td>
              в&nbsp;
            </td>
            <td class="btext">
                <? // Название банка получателя
                echo $acceptor->bank;
                ?>
            </td>
            <td>
              &nbsp;БИК&nbsp;
            </td>
            <td>
              <table class="btext2">
                <colgroup>
                  <col class="cell" span="9">
                </colgroup>
                <tbody>
                <tr>
                    <? // БИК банка
                    echo preg_replace('/(\d)/', '<td>\1</td>', $acceptor->BIK);
                    ?>
                </tr>

                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td>
            </td>
            <td class="subtext">
              (наименование банка получателя платежа)
            </td>
            <td colspan="2">
            </td>
          </tr>
          </tbody>
        </table>
        <br>
        <table>
          <tbody>
          <tr>
            <td class="text-small text-left">
              Номер кор./сч. банка получателя платежа&nbsp;
            </td>
            <td>
              <table class="btext2">
                <colgroup>
                  <col class="cell" span="20">
                </colgroup>
                <tbody>
                <tr>
                    <? // Коррсчёт банка
                    echo preg_replace('/(\d)/', '<td>\1</td>', $acceptor->korrSchet);
                    ?>
                </tr>

                </tbody>
              </table>
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td class="line1">
                            <span class="payment-name">№ уч.
                            <span class="nomer"><?= $land->land_number ?></span>
                                <?= $tariff->tariff_name ?></span>
            </td>
          </tr>
          <tr>
            <td class="subtext">
              (наименование платежа)
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td>
              Ф.И.О.&nbsp;плательщика&nbsp;
            </td>
            <td class="btext">
              <span class="fio"><?= $user->fullname ?></span>
            </td>
          </tr>
          <tr>
            <td>
              Адрес&nbsp;плательщика&nbsp;
            </td>
            <td class="btext">
              <span class="fio"><?= $user->post_address ?></span>
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td>Сумма&nbsp;платежа&nbsp;
            </td>
            <td class="line3">
              <span class="rubas"><?= Formulas::cRound($bill->manual_summ ? $bill->manual_summ : $bill->summ) ?></span>
            </td>
            <td>&nbsp;руб.&nbsp;
            </td>
            <td class="line3 rubas">
              &nbsp;&nbsp;00
            </td>
            <td>&nbsp;коп.&nbsp;
            </td>
            <td>&nbsp;&nbsp;&nbsp;
            </td>
            <td>Сумма&nbsp;платы&nbsp;за&nbsp;услуги&nbsp;
            </td>
            <td class="line3">
            </td>
            <td>&nbsp;руб.&nbsp;
            </td>
            <td class="line3">
            </td>
            <td>&nbsp;коп.&nbsp;
            </td>
          </tr>
          </tbody>
        </table>
        <table>
          <tbody>
          <tr>
            <td>Итого&nbsp;
            </td>
            <td class="line3">
            </td>
            <td>&nbsp;руб.&nbsp;
            </td>
            <td class="line3">
            </td>
            <td>&nbsp;коп.&nbsp;
            </td>
            <td class="space2">
            </td>
            <td>«&nbsp;
            </td>
            <td class="line4">
            </td>
            <td>&nbsp;»&nbsp;
            </td>
            <td class="line5">
            </td>
            <td>&nbsp;20&nbsp;
            </td>
            <td class="line6">
            </td>
            <td>&nbsp;г.
            </td>
          </tr>
          </tbody>
        </table>
        <p class="text-small text-left">
          <br>С условиями приема указанной в платежном документе суммы, в&nbsp; т.ч.&nbsp; с&nbsp; суммой
          взымаемой платы за услуги<br>банка, ознакомлен и согласен.
        </p>
        <table class="text-right">
          <tbody>
          <tr>
            <td class="text-small">
            </td>
            <td class="text-small text-right">
              Подпись&nbsp;плательщика&nbsp;
            </td>
            <td class="line7">
            </td>
          </tr>
          </tbody>
        </table>
        <div class="space1">
          <div class="barcode">
            <img src="/img/barcode?code=<?= $bill->code ?>">
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td class="pole3">
        Кассир
      </td>
    </tr>
    </tbody>
  </table>
</section>
</body>
</html>


