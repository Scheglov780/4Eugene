<?php

// base class for exceptions raised by this library
class Telerivet_APIException extends Telerivet_Exception
{
    function __construct($message, $error_code)
    {
        parent::__construct($message);
        $this->error_code = $error_code;
    }

    public $error_code;
}

// exception corresponding to error returned in API response

class Telerivet_Exception extends Exception
{
}

class Telerivet_IOException extends Telerivet_Exception
{
}

class Telerivet_InvalidParameterException extends Telerivet_APIException
{
    function __construct($message, $error_code, $param)
    {
        parent::__construct($message, $error_code);
        $this->param = $param;
    }

    public $param;
}

// exception raised when client could not connect to server

class Telerivet_NotFoundException extends Telerivet_APIException
{
    function __construct($message, $error_code)
    {
        parent::__construct($message, $error_code);
    }
}