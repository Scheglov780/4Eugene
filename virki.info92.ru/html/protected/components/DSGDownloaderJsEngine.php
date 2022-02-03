<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DSGCurl.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

/**
 * Класс, реализующий работу с библиотекой curl с некоторыми специфическими особенностями.
 */
class DSGDownloaderJsEngine
{
    /**
     * Internal constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->path = Yii::getPathOfAlias('application.vendors.phantomJs.bin.phantomjs');
        /*
Usage:
   phantomjs [switchs] [options] [script] [argument [argument [...]]]

Options:
  --cookies-file=<val>                 Sets the file name to store the persistent cookies
  --config=<val>                       Specifies JSON-formatted configuration file
  --debug=<val>                        Prints additional warning and debug message: 'true' or 'false' (default)
  --disk-cache=<val>                   Enables disk cache: 'true' or 'false' (default)
  --disk-cache-path=<val>              Specifies the location for the disk cache
  --ignore-ssl-errors=<val>            Ignores SSL errors (expired/self-signed certificate errors): 'true' or 'false' (default)
  --load-images=<val>                  Loads all inlined images: 'true' (default) or 'false'
  --local-url-access=<val>             Allows use of 'file:///' URLs: 'true' (default) or 'false'
  --local-storage-path=<val>           Specifies the location for local storage
  --local-storage-quota=<val>          Sets the maximum size of the local storage (in KB)
  --offline-storage-path=<val>         Specifies the location for offline storage
  --offline-storage-quota=<val>        Sets the maximum size of the offline storage (in KB)
  --local-to-remote-url-access=<val>   Allows local content to access remote URL: 'true' or 'false' (default)
  --max-disk-cache-size=<val>          Limits the size of the disk cache (in KB)
  --output-encoding=<val>              Sets the encoding for the terminal output, default is 'utf8'
  --remote-debugger-port=<val>         Starts the script in a debug harness and listens on the specified port
  --remote-debugger-autorun=<val>      Runs the script in the debugger immediately: 'true' or 'false' (default)
  --proxy=<val>                        Sets the proxy server, e.g. '--proxy=http://proxy.company.com:8080'
  --proxy-auth=<val>                   Provides authentication information for the proxy, e.g. ''-proxy-auth=username:password'
  --proxy-type=<val>                   Specifies the proxy type, 'http' (default), 'none' (disable completely), or 'socks5'
  --script-encoding=<val>              Sets the encoding used for the starting script, default is 'utf8'
  --script-language=<val>              Sets the script language instead of detecting it: 'javascript'
  --web-security=<val>                 Enables web security, 'true' (default) or 'false'
  --ssl-protocol=<val>                 Selects a specific SSL protocol version to offer. Values (case insensitive): TLSv1.2, TLSv1.1, TLSv1.0, TLSv1 (same as v1.0), SSLv3, or ANY. Default is to offer all that Qt thinks are secure (SSLv3 and up). Not all values may be supported, depending on the system OpenSSL library.
  --ssl-ciphers=<val>                  Sets supported TLS/SSL ciphers. Argument is a colon-separated list of OpenSSL cipher names (macros like ALL, kRSA, etc. may not be used). Default matches modern browsers.
  --ssl-certificates-path=<val>        Sets the location for custom CA certificates (if none set, uses environment variable SSL_CERT_DIR. If none set too, uses system default)
  --ssl-client-certificate-file=<val>  Sets the location of a client certificate
  --ssl-client-key-file=<val>          Sets the location of a clients' private key
  --ssl-client-key-passphrase=<val>    Sets the passphrase for the clients' private key
  --webdriver=<val>                    Starts in 'Remote WebDriver mode' (embedded GhostDriver): '[[<IP>:]<PORT>]' (default '127.0.0.1:8910')
  --webdriver-logfile=<val>            File where to write the WebDriver's Log (default 'none') (NOTE: needs '--webdriver')
  --webdriver-loglevel=<val>           WebDriver Logging Level: (supported: 'ERROR', 'WARN', 'INFO', 'DEBUG') (default 'INFO') (NOTE: needs '--webdriver')
  --webdriver-selenium-grid-hub=<val>  URL to the Selenium Grid HUB: 'URL_TO_HUB' (default 'none') (NOTE: needs '--webdriver')
  -w,--wd                              Equivalent to '--webdriver' option above
  -h,--help                            Shows this message and quits
  -v,--version                         Prints out PhantomJS version

Any of the options that accept boolean values ('true'/'false') can also accept 'yes'/'no'.

         */
        $this->options = [
          '--cookies-file=cookies.txt',
          '--disk-cache=true',
            //'--disk-cache-path=<val>'
            //'--max-disk-cache-size=<val>',//          Limits the size of the disk cache (in KB)
          '--ignore-ssl-errors=true',
          '--load-images=false',
            //'--local-storage-path=<val>',
            //'--local-storage-quota=<val>',
            //'--offline-storage-path=<val>',
            //'--offline-storage-quota=<val>',
            //'--local-to-remote-url-access=true',
          '--output-encoding=utf8',
            //--proxy=<val>                        Sets the proxy server, e.g. '--proxy=http://proxy.company.com:8080'
            //--proxy-auth=<val>                   Provides authentication information for the proxy, e.g. ''-proxy-auth=username:password'
            //--proxy-type=<val>                   Specifies the proxy type, 'http' (default), 'none' (disable completely), or 'socks5'
          '--script-encoding=utf8',
            //--script-language=<val>              Sets the script language instead of detecting it: 'javascript'
            //--web-security=<val>                 Enables web security, 'true' (default) or 'false'
            //--ssl-protocol=<val>                 Selects a specific SSL protocol version to offer. Values (case insensitive): TLSv1.2, TLSv1.1, TLSv1.0, TLSv1 (same as v1.0), SSLv3, or ANY. Default is to offer all that Qt thinks are secure (SSLv3 and up). Not all values may be supported, depending on the system OpenSSL library.
            //--ssl-ciphers=<val>                  Sets supported TLS/SSL ciphers. Argument is a colon-separated list of OpenSSL cipher names (macros like ALL, kRSA, etc. may not be used). Default matches modern browsers.
            //--ssl-certificates-path=<val>        Sets the location for custom CA certificates (if none set, uses environment variable SSL_CERT_DIR. If none set too, uses system default)
            //--ssl-client-certificate-file=<val>  Sets the location of a client certificate
            //--ssl-client-key-file=<val>          Sets the location of a clients' private key
            //--ssl-client-key-passphrase=<val>    Sets the passphrase for the clients' private key
        ];

        $this->debug = false;
    }

    /**
     * Debug flag.
     * @var boolean
     * @access protected
     */
    protected $debug;
    /**
     * Log info
     * @var string
     * @access protected
     */
    protected $log;
    /**
     * PhantomJs run options.
     * @var array
     * @access protected
     */
    protected $options;
    /**
     * Executable path.
     * @var string
     * @access protected
     */
    protected $path;

    /**
     * Validate execuable file.
     * @access private
     * @param string $file
     * @return boolean
     * @throws \JonnyW\PhantomJs\Exception\InvalidExecutableException
     */
    private function validateExecutable($file)
    {
        if (!file_exists($file) || !is_executable($file)) {
            throw new Exception(sprintf('File does not exist or is not executable: %s', $file));
        }

        return true;
    }

    /**
     * Add single PhantomJs run option.
     * @access public
     * @param string $option
     * @return DSGDownloaderJsEngine
     */
    public function addOption($option)
    {
        if (!in_array($option, $this->options)) {
            $this->options[] = $option;
        }

        return $this;
    }

    /**
     * Clear log info.
     * @access public
     * @return DSGDownloaderJsEngine
     */
    public function clearLog()
    {
        $this->log = '';

        return $this;
    }

    /**
     * Debug.
     * @access public
     * @param boolean $doDebug
     * @return DSGDownloaderJsEngine
     */
    public function debug($doDebug)
    {
        $this->debug = $doDebug;

        return $this;
    }

    /**
     * Get PhantomJs run command with
     * loader run options.
     * @access public
     * @return string
     */
    public function getCommand()
    {
        $path = $this->getPath();
        $options = $this->getOptions();

        $this->validateExecutable($path);

        if ($this->debug) {
            array_push($options, '--debug=true');
        }

        return sprintf('%s %s', $path, implode(' ', $options));
    }

    /**
     * Get log info.
     * @access public
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Get PhantomJs run options.
     * @access public
     * @return array
     */
    public function getOptions()
    {
        return (array) $this->options;
    }

    /**
     * Set PhantomJs run options.
     * @access public
     * @param array $options
     * @return DSGDownloaderJsEngine
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get path.
     * @access public
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path.
     * @access public
     * @param string $path
     * @return DSGDownloaderJsEngine
     */
    public function setPath($path)
    {
        $this->validateExecutable($path);

        $this->path = $path;

        return $this;
    }

    /**
     * Log info.
     * @access public
     * @param string $info
     * @return DSGDownloaderJsEngine
     */
    public function log($info)
    {
        $this->log = $info;

        return $this;
    }

    public function run()
    {
        try {

            $executable = preg_replace('/phantomjs$/is', 'download.js', $this->path);
            $descriptorspec = [
              ['pipe', 'r'],
              ['pipe', 'w'],
              ['pipe', 'w'],
            ];

            $process =
              proc_open(
                escapeshellcmd(sprintf('%s %s', $this->getCommand(), $executable)),
                $descriptorspec,
                $pipes,
                null,
                null
              );

            if (!is_resource($process)) {
                throw new Exception('proc_open() did not return a resource');
            }

            $result = stream_get_contents($pipes[1]);
            $log = stream_get_contents($pipes[2]);

            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            proc_close($process);

            $result = CJSON::decode($result);
            $this->log($log);
            foreach ($result['resources'] as $resource) {
                echo '<pre>' . $resource['timeLoad'] . ' ' . $resource['url'] . '</pre><br>';
            }
            echo '<hr/><pre>' . $result['timeLoad'] . '</pre><br>';
            //echo $result['content'];
            die;

        } catch (Exception $e) {
            throw new Exception(sprintf('Error when executing PhantomJs procedure - %s', $e->getMessage()));
        }
    }

}