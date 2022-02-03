<?

class AdditionalInformation
{
    public $key; // string
    public $value; // string
}

class Address
{
    public $addressLine1; // string
    public $addressLine2; // string
    public $city; // string
    public $country; // string
    public $county; // string
    public $zip; // string
}

/**
 * CNPMerchantWebServiceClient class
 * @author    CNP Processing KZ
 * @copyright {copyright}
 * @package   {package}
 */
class CNPMerchantWebServiceClient extends SoapClient
{
    public function __construct(
      $wsdl = 'https://payment.processinggmbh.ch/CNPMerchantWebServices/services/CNPMerchantWebService?wsdl',
      $options = [ /* https://test.processing.kz/CNPMerchantWebServices/services/CNPMerchantWebService?wsdl */
        'connection_timeout' => 60,
        'cache_wsdl'         => WSDL_CACHE_MEMORY,
        'trace'              => 1,
        'soap_version'       => 'SOAP 1.2',
        'encoding'           => 'UTF-8',
        'exceptions'         => true,
          /*'location' => 'https://test.processing.kz/CNPMerchantWebServices/services/CNPMerchantWebService'*/
        'location'           => 'https://payment.processinggmbh.ch/CNPMerchantWebServices/services/CNPMerchantWebService',
      ]
    ) {
        foreach (self::$classmap as $key => $value) {
            if (!isset ($options ['classmap'] [$key])) {
                $options ['classmap'] [$key] = $value;
            }
        }
        parent::__construct($wsdl, $options);
    }

    private static $classmap = [
      'StartTransactionResult'               => 'StartTransactionResult',
      'TransactionDetails'                   => 'TransactionDetails',
      'Address'                              => 'Address',
      'GoodsItem'                            => 'GoodsItem',
      'AdditionalInformation'                => 'AdditionalInformation',
      'StoredTransactionStatus'              => 'StoredTransactionStatus',
      'startTransaction'                     => 'startTransaction',
      'startTransactionResponse'             => 'startTransactionResponse',
      'refundTransaction'                    => 'refundTransaction',
      'refundTransactionResponse'            => 'refundTransactionResponse',
      'getVersionResponse'                   => 'getVersionResponse',
      'getTransactionStatus'                 => 'getTransactionStatus',
      'getTransactionStatusResponse'         => 'getTransactionStatusResponse',
      'getExtendedTransactionStatus'         => 'getExtendedTransactionStatus',
      'getExtendedTransactionStatusResponse' => 'getExtendedTransactionStatusResponse',
      'completeTransaction'                  => 'completeTransaction',
      'completeTransactionResponse'          => 'completeTransactionResponse',
    ];

    /**
     * @param completeTransaction $parameters
     * @return completeTransactionResponse
     */
    public function completeTransaction(completeTransaction $parameters)
    {
        return $this->__soapCall(
          'completeTransaction',
          [
            $parameters,
          ],
          [
            'uri'        => 'https://kz.processing.cnp.merchant_ws/',
            'soapaction' => '',
          ]
        );
    }

    /**
     * @param getExtendedTransactionStatus $parameters
     * @return getExtendedTransactionStatusResponse
     */
    public function getExtendedTransactionStatus(getExtendedTransactionStatus $parameters)
    {
        return $this->__soapCall(
          'getExtendedTransactionStatus',
          [
            $parameters,
          ],
          [
            'uri'        => 'http://kz.processing.cnp.merchant_ws/xsd',
            'soapaction' => '',
          ]
        );
    }

    /**
     * @param getTransactionStatus $parameters
     * @return getTransactionStatusResponse
     */
    public function getTransactionStatus(getTransactionStatus $parameters)
    {
        return $this->__soapCall(
          'getTransactionStatus',
          [
            $parameters,
          ],
          [
            'uri'        => 'https://kz.processing.cnp.merchant_ws/',
            'soapaction' => '',
          ]
        );
    }

    /**
     * @param
     * @return getVersionResponse
     */
    public function getVersion()
    {
        return $this->__soapCall(
          'getVersion',
          [],
          [
            'uri'        => 'https://kz.processing.cnp.merchant_ws/',
            'soapaction' => '',
          ]
        );
    }

    /**
     * @param refundTransaction $parameters
     * @return refundTransactionResponse
     */
    public function refundTransaction(refundTransaction $parameters)
    {
        return $this->__soapCall(
          'refundTransaction',
          [
            $parameters,
          ],
          [
            'uri'        => 'https://kz.processing.cnp.merchant_ws/',
            'soapaction' => '',
          ]
        );
    }

    /**
     * @param startTransaction $parameters
     * @return startTransactionResponse
     */
    public function startTransaction(startTransaction $parameters)
    {
        return $this->__soapCall(
          'startTransaction',
          [
            $parameters,
          ],
          [
            'uri'        => 'https://kz.processing.cnp.merchant_ws/',
            'soapaction' => '',
          ]
        );
    }
}

class GoodsItem
{
    public $amount; // string
    public $currencyCode; // int
    public $merchantsGoodsID; // string
    public $nameOfGoods; // string
}

class StartTransactionResult
{
    public $customerReference; // string
    public $errorDescription; // string
    public $redirectURL; // string
    public $success; // boolean
}

class StoredTransactionStatus
{
    public $additionalInformation; // AdditionalInformation
    public $amountAuthorised; // string
    public $amountRefunded; // string
    public $amountRequested; // string
    public $amountSettled; // string
    public $authCode; // string
    public $goods; // GoodsItem
    public $transactionCurrencyCode; // string
    public $transactionStatus; // string
}

class StoredTransactionStatusExtended
{
    public $cardHashNumber; // string
    public $cardIssuerCountry; // string
    public $maskedCardNumber; // string
    public $purchaserIpAddress; // string
    public $verified3D; // string
}

class TransactionDetails
{
    public $billingAddress; // Address
    public $currencyCode; // int
    public $customerReference; // string
    public $description; // string
    public $goodsList; // GoodsItem
    public $languageCode; // string
    public $merchantAdditionalInformationList; // AdditionalInformation
    public $merchantId; // string
    public $merchantLocalDateTime; // string
    public $orderId; // string
    public $purchaserEmail; // string
    public $purchaserName; // string
    public $purchaserPhone; // string
    public $returnURL; // string
    public $terminalId; // string
    public $totalAmount; // string
}

class completeTransaction
{
    public $merchantId; // string
    public $overrideAmount; // string
    public $referenceNr; // boolean
    public $transactionSuccess; // string
}

class completeTransactionResponse
{
    public $return; // boolean
}

class getExtendedTransactionStatus
{
    public $merchantId; // string
    public $referenceNr; // string
}

class getExtendedTransactionStatusResponse
{
    public $return; // StoredTransactionStatusExtended
}

class getTransactionStatus
{
    public $merchantId; // string
    public $referenceNr; // string
}

class getTransactionStatusResponse
{
    public $return; // StoredTransactionStatus
}

class getVersionResponse
{
    public $return; // string
}

class refundTransaction
{
    public $additionalInformation; // string
    public $description; // string
    public $goodsToRefund; // string
    public $merchantId; // string
    public $password; // string
    public $referenceNr; // GoodsItem
    public $refundAmount; // AdditionalInformation
}

class refundTransactionResponse
{
    public $return; // boolean
}

class startTransaction
{
    public $transaction; // TransactionDetails
}

class startTransactionResponse
{
    public $return; // StartTransactionResult
}

function guid()
{
    if (function_exists('com_create_guid')) {
        return str_replace("}", "", str_replace("{", "", com_create_guid()));
    } else {
        mt_srand(( double ) microtime() * 10000); // optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr(
            $charid,
            12,
            4
          ) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
    }
    return $uuid;
}
