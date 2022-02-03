<?php

//  httpful bootstrap execution
//require(dirname(__FILE__)."/protected/components/httpful/bootstrap.php");

abstract class APIActions
{
    const DIC_MODEL_BASE_STATIONS = 'Get a list of base stations models';
    const DIC_MODEL_BRANDS = 'Get a list of brands';
    const DIC_MODEL_CLASSES = 'Get a list of device model classes';
    const DIC_MODEL_DEVICE_GROUPS = 'Get a list of metring device groups';
    const DIC_MODEL_DEVICE_TYPES = 'Get metering device types by group id';
    const DIC_MODEL_GATEWAYS = 'Get a list of gateway models';
    const DIC_MODEL_GATEWAY_TYPED = 'Get the list of types of gateways';
    const DIC_MODEL_INTERFACES = 'Get a list of device interfaces models';
    const DIC_MODEL_METERING_DEVICES = 'Get a list of metering devices models';
    const DIC_MODEL_POLL_FIELDS = 'Get available model polling fields';
    const GET_DEVICES_LIST = 'Get list';
    const GET_DEVICE_DATA = 'Get data';
    const GET_DEVICE_DATA_MESSAGE_GROUPS = 'Get data groups';
    const GET_DEVICE_DATA_MESSAGE_TYPES = 'Get data types';
    const LOGIN = 'Login';
    const LOGOUT = 'Logout';
}

class NektaCommunicator
{
    private const API_ACTION_PATHS = [
      APIActions::LOGIN                          => 'auth/login/',
      APIActions::LOGOUT                         => 'auth/logout/',
      APIActions::GET_DEVICES_LIST               => 'device/metering_devices/',
      APIActions::GET_DEVICE_DATA                => 'device/messages/',
      APIActions::GET_DEVICE_DATA_MESSAGE_TYPES  => 'device/messages/types',
      APIActions::GET_DEVICE_DATA_MESSAGE_GROUPS => 'device/messages/groups',
//=========== dictionaries ==========
      APIActions::DIC_MODEL_INTERFACES           => 'device/model/interfaces',
        // POST Get a list of device interfaces models
      APIActions::DIC_MODEL_BASE_STATIONS        => 'device/model/base_stations',
        // POST Get a list of base stations models
      APIActions::DIC_MODEL_METERING_DEVICES     => 'device/model/metering_devices',
        // POST Get a list of metering devices models
      APIActions::DIC_MODEL_GATEWAYS             => 'device/model/gateways',
        // POST Get a list of gateway models
      APIActions::DIC_MODEL_BRANDS               => 'device/model/brands',
        // POST Get a list of brands
      APIActions::DIC_MODEL_DEVICE_GROUPS        => 'device/model/metering_device/groups',
        // POST Get a list of metring device groups
      APIActions::DIC_MODEL_DEVICE_TYPES         => 'device/model/metering_device/types',
        // POST Get metering device types by group id
      APIActions::DIC_MODEL_GATEWAY_TYPED        => 'device/model/gateway/types',
        // POST Get the list of types of gateways
      APIActions::DIC_MODEL_CLASSES              => 'device/model/classes',
        // GET Get a list of device model classes
      APIActions::DIC_MODEL_POLL_FIELDS          => 'device/model/poll/fields',
        //POST Get available model polling fields
    ];
    private const API_URI_PATH = 'api/';
    const debug = false;

    public function __construct(
      $user,
      $password,
      $URIScheme = 'https',
      $URIBase = 'core.nekta.cloud'
    ) {
        require(dirname(__FILE__) . '/../extensions/httpful/bootstrap.php');
        $this->userName = $user;
        $this->userPassword = $password;
        $this->URIScheme = $URIScheme;
        $this->URIBase = $URIBase;
    }

    private $URIBase = '';
    private $URIScheme = '';
    private $accessToken = null;
    private $lastError = '';
    private $userName = '';
    private $userPassword = '';

    private function getCredentials()
    {
        return [
          'email'    => $this->userName,
          'password' => $this->userPassword,
        ];
    }

    // ------------ INTERFACE FUNCTIONS ------------

    private function getFullURI($additionalPath = '')
    {
        return $this->URIScheme . "://" .
          $this->URIBase . "/" .
          self::API_URI_PATH .
          $additionalPath;
    }

    private function performActionWithRetry($action, $actionData, $maxRetryCount = 10)
    {
        $retryCount = 0;
        do {
            try {
                if (++$retryCount > $maxRetryCount) {
                    throw new Exception(
                      'Action "' . $action . '" performing retries number exceeded (' . $maxRetryCount . ')'
                    );
                }
                self::log('Performing action "' . $action . '" [attempt: ' . $retryCount . ']...', CLogger::LEVEL_INFO);
                switch ($action) {
                    case APIActions::LOGIN:
                        $response = $this->performJsonPost(
                          APIActions::LOGIN,
                          $this->getFullURI(self::API_ACTION_PATHS[APIActions::LOGIN]),
                          json_encode($actionData['request_body']),
                          $actionData['request_headers']
                        );
                        return $response;
                        break;

                    case APIActions::GET_DEVICES_LIST:
                    case APIActions::GET_DEVICE_DATA:
                    case APIActions::DIC_MODEL_METERING_DEVICES:
                    case APIActions::DIC_MODEL_DEVICE_GROUPS:
                    case APIActions::DIC_MODEL_DEVICE_TYPES:
                        if (is_null($this->accessToken)) {
                            throw new ErrorException('Access token needed to perform "' . $action . '" action');
                        }
                        $actionData['request_headers']['Authorization'] = 'Bearer ' . $this->accessToken;
                        $response = $this->performJsonPost(
                          $action,
                          $this->getFullURI(self::API_ACTION_PATHS[$action]),
                          json_encode($actionData['request_body']),
                          $actionData['request_headers']
                        );
                        return $response;
                        break;
                    case APIActions::LOGOUT:
                    default:
                        throw new Exception('Unexpected or unimplemented action requested: "' . $action . '"');
                }

            }

                // TODO: add here more retry conditions

                // if unauthorized exception thrown - try to relogin
            catch (ErrorException $e) {
                if ($action ==
                  APIActions::LOGIN) {   // if action is login and failed with unauthorized code - throw exception
                    self::log(
                      'Unauthorized exception caught while performing action "' . $action . '"',
                      CLogger::LEVEL_ERROR
                    );
                    throw $e;
                }

                self::log(
                  'Unathorized exception caught while performing action "' . $action . '": ' . $e->getMessage(),
                  CLogger::LEVEL_WARNING
                );

                if ($this->login()) {   // if relogin is ok - try current action once more with new token
                    $actionData['request_headers']['Authorization'] = 'Bearer ' . $this->accessToken;
                    continue;
                } else {   // if relogin failed - throw exception
                    self::log(
                      'Unathorized on relogin try while performing action " ' . $action . '"',
                      CLogger::LEVEL_ERROR
                    );
                    throw $e; // TODO: do error handling here or separate retry and throw conditions
                }
            } catch (Exception $e) {
                self::log('Exception occured on action " ' . $action . '" ' . $e->getMessage(), CLogger::LEVEL_ERROR);
                throw $e; // TODO: do error handling here or separate retry and throw conitions
            }
        } while ($retryCount <= $maxRetryCount);

        return null;
    }

    private function performGetRequest($action, $URI, $headers = [])
    {
        self::log('Performing request for action " ' . $action . '" (' . $URI . ')', CLogger::LEVEL_INFO);
        try {
            $request = \Httpful\Request::get($URI)
              ->expectsJson();
            $request->addHeader('Authorization', 'Bearer ' . $this->accessToken);
            if (!empty($headers)) {
                foreach ($headers as $headerKey => $headerVal) {
                    $request->addHeader($headerKey, $headerVal);
                }
            }
            self::log('Request body: ' . $request->payload, CLogger::LEVEL_INFO);
            self::log('Request headers: ' . json_encode($request->headers), CLogger::LEVEL_INFO);
            $response = $request->send();
        } catch (Httpful\Exception\ConnectionErrorException $e) {
            throw new Exception($action . ' failed due to network error: "' . $e->getMessage() . '"');
        } catch (Exception $e) {
            throw new Exception($action . ' failed due to some error: "' . $e->getMessage() . '"');
        }

        if (!is_a($response, '\Httpful\Response')) {
            throw new Exception($action . ' failed due to invalid response object type');
        }

        if ($response->hasErrors()) {
            if ($response->code == 401) {
                throw new ErrorException($action . ' failed due to HTTP error: ' . $response->code);
            }
            throw new Exception($action . ' failed due to HTTP error: ' . $response->code);
        }

        if (!$response->hasBody()) {
            throw new Exception($action . ' failed due to empty response body');
        }

        self::log('Successfully performed request for action " ' . $action . '" (' . $URI . ')', CLogger::LEVEL_INFO);

        return $response;
    }

    // ------------ GETTERS and SETTERS ------------

    private function performJsonPost($action, $URI, $jsonBody, $headers = [])
    {
        self::log('Performing request for action " ' . $action . '" (' . $URI . ')', CLogger::LEVEL_INFO);
        try {
            $request = \Httpful\Request::post($URI)
              ->sendsJson()
              ->expectsJson()
              ->body($jsonBody);

            if (!empty($headers)) {
                foreach ($headers as $headerKey => $headerVal) {
                    $request->addHeader($headerKey, $headerVal);
                }
            }
            self::log('Request body: ' . $request->payload, CLogger::LEVEL_INFO);
            self::log('Request headers: ' . json_encode($request->headers), CLogger::LEVEL_INFO);
            $response = $request->send();
        } catch (Httpful\Exception\ConnectionErrorException $e) {
            throw new Exception($action . ' failed due to network error: "' . $e->getMessage() . '"');
        } catch (Exception $e) {
            throw new Exception($action . ' failed due to some error: "' . $e->getMessage() . '"');
        }

        if (!is_a($response, '\Httpful\Response')) {
            throw new Exception($action . ' failed due to invalid response object type');
        }

        if ($response->hasErrors()) {
            if ($response->code == 401) {
                throw new ErrorException($action . ' failed due to HTTP error: ' . $response->code);
            }
            throw new Exception($action . ' failed due to HTTP error: ' . $response->code);
        }

        if (!$response->hasBody()) {
            throw new Exception($action . ' failed due to empty response body');
        }

        self::log('Successfully performed request for action " ' . $action . '" (' . $URI . ')', CLogger::LEVEL_INFO);

        return $response;
    }

    /**
     * Perform getting data for particular device
     * @param int $devId     - device identificator
     * @param int $startDate - unixtime timestamp for data filtering
     * @param int $endDate   - unixtime timestamp for data filtering
     * @return array data on success
     * @return NULL on failure
     */
    public function getDeviceData($devId, $startDate, $endDate, $type)
    {
        /*
        {
        device_id*	integer
        ID or [ID1, ID2 ...] of the metering device or gateway in the application
        msgType*	integer
        Device messages type ID
        msgGroup*	integer
        Device messages group ID
        startDate*	integer
        Period start date for device messages request(unix timestamp)
        stopDate*	integer
        Period end date for device messages request(unix timestamp)
        paginate	boolean
        (optional)This parameter specifies whether messages will be paginated(Default = true)
        per_page	integer
        (optional)Number of messages per page/ messages received in the request. Used only with pagination! (Default = 10. Max value = 10000)
        profile_type	integer
        (optional|Only for messages of type 'Power profiles' (msgType=5))Profile type. (Possible value = 30 or 60)
        with_transformation_ratio	boolean
        (optional)Consider transformation ratio from accounting point(Default = true)
        }
        */

        $requestBody = [
          'device_id' => $devId,
          'msgType'   => $type,
            /*
             1 - Показания
             5 - Профиль мощности
             6 - Мгновенные показания

             */
          'msgGroup'  => 0,
          'startDate' => $startDate,
          'stopDate'  => $endDate,
          'paginate'  => false,
          'per_page'  => 0,
            // 'tab'       => 'tariffs'
            //"profile_type": 0,
            //"with_transformation_ratio": true
        ];

        $requestData = [
          'request_body'    => $requestBody,
          'request_headers' => [],
        ];

        try {
            $response = $this->performActionWithRetry(APIActions::GET_DEVICE_DATA, $requestData);
            if (is_null($response)) {
                $this->lastError = 'Unexpected error occured on "' . APIActions::GET_DEVICE_DATA . '"';
                return null;
            }
        } catch (Exception $e) {
            $this->lastError =
              'Exception occured on "' . APIActions::GET_DEVICE_DATA . '". Exception msg: "' . $e->getMessage() . '"';
            return null;
        }

        $this->lastError = '';
        return $response->raw_body;
    }
    // ------------ ------------------- ------------

    // ------------ INTERNAL FUNCTIONS ------------

    public function getDeviceDataMsgGroups()
    {
        try {
            $response = $this->performGetRequest(
              APIActions::GET_DEVICE_DATA_MESSAGE_GROUPS,
              $this->getFullURI(self::API_ACTION_PATHS[APIActions::GET_DEVICE_DATA_MESSAGE_GROUPS])
            );
            if (is_null($response)) {
                $this->lastError = 'Unexpected error occured on "' . APIActions::GET_DEVICE_DATA_MESSAGE_GROUPS . '"';
                return null;
            }
        } catch (Exception $e) {
            $this->lastError =
              'Exception occured on "' .
              APIActions::GET_DEVICE_DATA_MESSAGE_GROUPS .
              '". Exception msg: "' .
              $e->getMessage() .
              '"';
            return null;
        }
        $this->lastError = '';
        return $response->raw_body;
    }

    public function getDeviceDataMsgTypes()
    {
        try {
            $response = $this->performGetRequest(
              APIActions::GET_DEVICE_DATA_MESSAGE_TYPES,
              $this->getFullURI(self::API_ACTION_PATHS[APIActions::GET_DEVICE_DATA_MESSAGE_TYPES])
            );
            if (is_null($response)) {
                $this->lastError = 'Unexpected error occured on "' . APIActions::GET_DEVICE_DATA_MESSAGE_TYPES . '"';
                return null;
            }
        } catch (Exception $e) {
            $this->lastError =
              'Exception occured on "' .
              APIActions::GET_DEVICE_DATA_MESSAGE_TYPES .
              '". Exception msg: "' .
              $e->getMessage() .
              '"';
            return null;
        }

        $this->lastError = '';
        return $response->raw_body;
    }

    /**
     * Perform getting devices list procedure
     * @return array data on success
     * @return NULL on failure
     */
    public function getDevicesList()
    {
        /*
        {
device_brand_id	integer

(optional)Unique numeric brand ID
device_group_id	integer

(optional)Unique numeric metering device group ID
device_type_id	integer

(optional)Unique numeric metering device type ID
gateway_interface_id	integer

(optional)ID of the interface through which the metering device can work with the gateway
server_interface_id	integer

(optional)ID of the interface through which the metering device can work with the base station/server
control_relay	boolean

(optional)Control relay support
name	string

(optional)Full or partial name of the metering device model
company_id	integer

(optional)Request device models that are tied to the current company
device_ids	[

(Optional)List of devices by models which will be filtered(example = [1,2,3])
integer]
model_ids	[

(Optional)List of id models to get(example = [1,2,3])
integer]
append_attributes	[

(Optional)list of additional attributes to add to the model! It works if only one model is requested by id! (example = [device_fields_titles])
string]
}
        */

        $requestBody = [
          'paginate'      => false,
          'device_state'  => 'all',
          'append_fields' => ['active_polling', 'attributes'],
        ];

        $requestData = [
          'request_body'    => $requestBody,
          'request_headers' => [],
        ];

        try {
            $response = $this->performActionWithRetry(APIActions::GET_DEVICES_LIST, $requestData);
            if (is_null($response)) {
                $this->lastError = 'Unexpected error occured on "' . APIActions::GET_DEVICES_LIST . '"';
                return null;
            }
        } catch (Exception $e) {
            $this->lastError =
              'Exception occured on "' . APIActions::GET_DEVICES_LIST . '". Exception msg: "' . $e->getMessage() . '"';
            return null;
        }

        $this->lastError = '';
        return $response->raw_body;
    }

    public function getDicDevicesGroups()
    {
        /*
         {
        }
         */
        $requestBody = [
            //  'control_relay'      => true,
        ];

        $requestData = [
          'request_body'    => $requestBody,
          'request_headers' => [],
        ];

        try {
            $response = $this->performActionWithRetry(APIActions::DIC_MODEL_DEVICE_GROUPS, $requestData);
            if (is_null($response)) {
                $this->lastError = 'Unexpected error occured on "' . APIActions::DIC_MODEL_DEVICE_GROUPS . '"';
                return null;
            }
        } catch (Exception $e) {
            $this->lastError =
              'Exception occured on "' .
              APIActions::DIC_MODEL_DEVICE_GROUPS .
              '". Exception msg: "' .
              $e->getMessage() .
              '"';
            return null;
        }

        $this->lastError = '';
        return $response->raw_body;
    }

    public function getDicDevicesModels()
    {
        /*
         {
          "device_brand_id": 0,
          "device_group_id": 0,
          "device_type_id": 0,
          "gateway_interface_id": 0,
          "server_interface_id": 0,
          "control_relay": true,
          "name": "string",
          "company_id": 0,
          "device_ids": [
            0
          ],
          "model_ids": [
            0
          ],
          "append_attributes": [
            "string"
          ]
        }
         */
        $requestBody = [
          'control_relay' => true,
        ];

        $requestData = [
          'request_body'    => $requestBody,
          'request_headers' => [],
        ];

        try {
            $response = $this->performActionWithRetry(APIActions::DIC_MODEL_METERING_DEVICES, $requestData);
            if (is_null($response)) {
                $this->lastError = 'Unexpected error occured on "' . APIActions::DIC_MODEL_METERING_DEVICES . '"';
                return null;
            }
        } catch (Exception $e) {
            $this->lastError =
              'Exception occured on "' .
              APIActions::DIC_MODEL_METERING_DEVICES .
              '". Exception msg: "' .
              $e->getMessage() .
              '"';
            return null;
        }

        $this->lastError = '';
        return $response->raw_body;
    }

    public function getDicDevicesTypes()
    {
        /*
         {
        }
         */
        $requestBody = [
            //  'device_group_id': 0
        ];

        $requestData = [
          'request_body'    => $requestBody,
          'request_headers' => [],
        ];

        try {
            $response = $this->performActionWithRetry(APIActions::DIC_MODEL_DEVICE_TYPES, $requestData);
            if (is_null($response)) {
                $this->lastError = 'Unexpected error occured on "' . APIActions::DIC_MODEL_DEVICE_TYPES . '"';
                return null;
            }
        } catch (Exception $e) {
            $this->lastError =
              'Exception occured on "' .
              APIActions::DIC_MODEL_DEVICE_TYPES .
              '". Exception msg: "' .
              $e->getMessage() .
              '"';
            return null;
        }

        $this->lastError = '';
        return $response->raw_body;
    }

    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * Perform login procedure. On success access token will be stored internally
     * @return true on success
     * @return false on failure
     */
    public function login()
    {
        $requestData = [
          'request_body'    => $this->getCredentials(),
          'request_headers' => [],
        ];

        try {
            $response = $this->performActionWithRetry(APIActions::LOGIN, $requestData, 1);
            if (is_null($response)) {
                $this->lastError = 'Unexpected error occured on "' . APIActions::LOGIN . '"';
                return false;
            }
        } catch (Exception $e) {
            $this->lastError =
              'Exception occured on "' . APIActions::LOGIN . '". Exception msg: "' . $e->getMessage() . '"';
            return false;
        }

        $dataArr = recursiveCastToArray($response->body);
        try {
            $this->accessToken = $dataArr['data']['access_token'];
            $accessTokenExpire = $dataArr['data']['expires_at'];
        } catch (Exception $e) {
            $this->lastError =
              'Exception occured on "' . APIActions::LOGIN . '". Exception msg: "' . $e->getMessage() . '"';
            unset($this->accessToken);
            $accessTokenExpire = 0;
            return false;
        }

        if (is_null($this->accessToken) || $accessTokenExpire == 0) {
            $this->lastError = 'Error occured on "' . APIActions::LOGIN . '". Error msg: "' . $dataArr['msg'] . '"';
            return false;
        }

        $this->lastError = '';

        return true;
    }

    public static function log($message, $logLevel = 'info')
    {
        if (($logLevel != CLogger::LEVEL_INFO) || self::debug) {
            Yii::app()->db->createCommand('insert into log_iot (datetime, message) values (Now(), :message)')
              ->execute(
                [
                  ':message' => 'Nekta: ' . $message,
                ]
              );
        }
    }
}

function recursiveCastToArray($input)
{
    if (is_scalar($input)) {
        return $input;
    }
    return array_map(__FUNCTION__, (array) $input);
}