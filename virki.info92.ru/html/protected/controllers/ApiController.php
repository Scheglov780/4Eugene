<?php

class ApiController extends CustomController
{
    //Параметры подключения API 1C
    private $pass_1C = 'LgeH43jKQic'; // Пользователь 1С в настройках выгрузки на сайт
    private $path_unzip_1c = '/resources/1c/ic-line/'; // Пароль пользователя 1С в настройках выгрузки на сайт
    private $user_1C = '1c'; // путь сохранения файлов выгрузки из 1С

    public function actionEx1c() //Экшен API для 1С
    {
        session_start();

        $LoginSuccessful = false;

// Check username and password:
//print_r($_SERVER);
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {

            $Username = $_SERVER['PHP_AUTH_USER'];
            $Password = $_SERVER['PHP_AUTH_PW'];

            if ($Username == $this->user_1C && $Password == $this->pass_1C) {
                $LoginSuccessful = true;
            }
        }

// Login passed successful?
        if (!$LoginSuccessful) {
            header('WWW-Authenticate: Basic realm="Login"');
            header('HTTP/1.0 401 Unauthorized');
            print "Login failed!\n";
        } else {

            if (($_GET['type'] == 'catalog') && ($_GET['mode'] == 'checkauth')) { // сообщим 1С об авторизации
                echo("success\n");
                echo(session_name() . "\n");
                echo session_id();
                exit;
            } elseif (($_GET['type'] == 'catalog') && ($_GET['mode'] == 'init')) { // Установим параметры соединения
                //echo("zip=no\n");
                // или в ZIP (если есть соответствующий модуль)
                $zip = extension_loaded('zip') ? 'yes' : 'no';
                echo 'zip=' . $zip . "\n";
                echo("file_limit=0");
            } elseif (($_GET['type'] == 'catalog') && ($_GET['mode'] == 'file')) { // Получим файлы ?
                // вытаскиваем сырые данные
                $data = file_get_contents('php://input');
                //Сохраняем файл импорта в zip архиве
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . $this->path_unzip_1c . $_GET['filename'], $data);

                // распаковываем
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $this->path_unzip_1c . $_GET['filename'])) {
                    // работаем с zip
                    $zip = new ZipArchive;
                    //все в порядке с архивом?
                    if ($res =
                      $zip->open(
                        $_SERVER['DOCUMENT_ROOT'] . $this->path_unzip_1c . $_GET['filename'],
                        ZIPARCHIVE::CREATE
                      )) {
                        //Удалим старые данные
                        $DIRECT = $_SERVER['DOCUMENT_ROOT'] . $this->path_unzip_1c . 'current';
                        system("rm -rf " . $DIRECT);
                        // и запишем новые
                        // распаковываем два файла в формате xml
                        // в нашем случае в каталог //HTTP_ROOT/resources/1c/current [$path_unzip_1c = '/resources/1c/']
                        $zip->extractTo($_SERVER['DOCUMENT_ROOT'] . $this->path_unzip_1c . 'current');
                        $zip->close();
                        // удаляем временный файл и выходим
                        unlink($_GET['filename']);

                        //Всё получилось? сообщим
                        echo "success\n";

                        exit;

                        // Архив выгрузили и распаковали, и как давай его разбирать

                    }

                } else {
                    // если ничего не получилось
                    echo "failure\n";
                    exit;
                }
                //}

            } else {
                /*
                                Utils::debugLog(CVarDumper::dumpAsString($_GET));
                                Utils::debugLog(CVarDumper::dumpAsString($_POST));
                                Utils::debugLog(CVarDumper::dumpAsString($_SERVER));
                                Utils::debugLog(CVarDumper::dumpAsString($_SESSION));
                */
                // если ничего не получилось
                echo "failure\n";
                exit;

            }
        }

        //session_destroy();
    }

    public function actionIndex() // Это дефолтный экшен для API ( //SiteDomainName/api )
    {

        echo('OK' . "\n");
        echo('Controller: Api, Action: Index');

    }
}