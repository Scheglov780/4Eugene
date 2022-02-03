<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CustomControllerVars.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

class CustomControllerVars implements ArrayAccess, Countable, Iterator, Serializable
{

    public function __construct(array $array = null)
    {
        if (!is_null($array)) {
            $this->_container = $array;
        }
    }

    private $_container = [];
    private $_position = 0;
    public $asText = '';
    public $errors = [];
    public $report = '';

    public function __invoke(array $data = null)
    {
        if (is_null($data)) {
            return $this->_container;
        } else {
            $this->_container = $data;
        }
    }

    public function count()
    {
        return count($this->_container);
    }

    public function current()
    {
        return $this->_container[$this->_position];
    }

    public function key()
    {
        return $this->_position;
    }

    public function next()
    {
        ++$this->_position;
    }

    public function offsetExists($offset)
    {
        return isset($this->_container[$offset]);
    }

    public function offsetGet($offset)
    {
        if (is_array($offset)) {
            $_offset = $offset[0];
            $_type = $offset[1];
        } else {
            $_offset = $offset;
            $_type = false;
        }
        if ($this->offsetExists($_offset)) {
            $result = $this->_container[$_offset];
        } else {
            $result = new CustomControllerVar(null, 'Parameter ' . $_offset . ' not found!');
            $this->errors[$_offset] = $result->description;
        }
        if ($_type) {
            switch ($_type) {
                case $_type == 'array':
                    if (!is_array($result->val)) {
                        $result->val = [];
                        $this->errors[$_offset] = 'Type inconsistence: array needed!';
                    };
                    break;
                case ($_type == 'numeric'):
                    if (!is_numeric($result->val)) {
                        $result->val = 0;
                        $this->errors[$_offset] = 'Type inconsistence: numeric needed!';
                    };
                    break;
                default:
                    if (!is_a($result->val, $_type)) {
                        $result->val = null;
                        $this->errors[$_offset] = 'Type inconsistence: ' . $_type . ' needed!';
                    };
                    break;
            }
        }
        return $result;
    }

    public function offsetSet($offset, $value)
    {
        if (is_array($offset)) {
            $_offset = $offset[0];
            $_description = $offset[1];
        } else {
            $_offset = $offset;
            $_description = '';
        }
        if (is_null($_offset)) {
            $this->_container[] = new CustomControllerVar($value, $_description);
        } else {
            $this->_container[$_offset] = new CustomControllerVar($value, $_description);
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->_container[$offset]);
    }

    public function prepareReport()
    {
        $this->report = 'none';
        if (is_array($this->_container)) {
            $this->report = '';
            foreach ($this->_container as $name => $var) {
                $varType = gettype($var->val);
                if ($varType == 'object') {
                    $varType = get_class($var->val);
                }
                $this->report = $this->report . $name . ' (' . $varType . ')' . "\r\n";
                $varStruct = $var->val;
                if (is_array($varStruct)) {
                    $varStruct = array_slice($varStruct, 0, 1);
                }
                try {
                    $dump = CVarDumper::dumpAsString($varStruct, 3);
                    $this->asText = $this->asText . 'var $' . $name . " = \r\n" . $dump . "\r\n";
                } catch (Exception $e) {
                    return;
                }
            }
        }
    }

    public function rewind()
    {
        $this->_position = 0;
    }

    public function serialize()
    {
        try {
            $result = null;
            if (isset($this->_container)) {
                $result = serialize($this->_container);
            }
            if (isset($result) && $result && is_string($result)) {
                return $result;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function unserialize($data)
    {
        $this->_container = unserialize($data);
    }

    public function valid()
    {
        return isset($this->_container[$this->_position]);
    }
}