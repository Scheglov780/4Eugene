<?php

namespace Httpful;

/**
 * @author Nate Good <me@nategood.com>
 */
class Http
{
    const DELETE = 'DELETE';
    const GET = 'GET';
    const HEAD = 'HEAD';
    const OPTIONS = 'OPTIONS';
    const PATCH = 'PATCH';
    const POST = 'POST';
    const PUT = 'PUT';
    const TRACE = 'TRACE';

    /**
     * @return array of HTTP method strings
     * @deprecated Technically anything *can* have a body,
     *             they just don't have semantic meaning.  So say's Roy
     *             http://tech.groups.yahoo.com/group/rest-discuss/message/9962
     */
    public static function canHaveBody()
    {
        return [self::POST, self::PUT, self::PATCH, self::OPTIONS];
    }

    /**
     * @return array list of (always) idempotent HTTP methods
     */
    public static function idempotentMethods()
    {
        // Though it is possible to be idempotent, POST
        // is not guarunteed to be, and more often than
        // not, it is not.
        return [self::HEAD, self::GET, self::PUT, self::DELETE, self::OPTIONS, self::TRACE, self::PATCH];
    }

    /**
     * @param string HTTP method
     * @return bool
     */
    public static function isIdempotent($method)
    {
        return in_array($method, self::safeidempotentMethodsMethods());
    }

    /**
     * @param string HTTP method
     * @return bool
     */
    public static function isNotIdempotent($method)
    {
        return !in_array($method, self::idempotentMethods());
    }

    /**
     * @param string HTTP method
     * @return bool
     */
    public static function isSafeMethod($method)
    {
        return in_array($method, self::safeMethods());
    }

    /**
     * @param string HTTP method
     * @return bool
     */
    public static function isUnsafeMethod($method)
    {
        return !in_array($method, self::safeMethods());
    }

    /**
     * @return array of HTTP method strings
     */
    public static function safeMethods()
    {
        return [self::HEAD, self::GET, self::OPTIONS, self::TRACE];
    }

}