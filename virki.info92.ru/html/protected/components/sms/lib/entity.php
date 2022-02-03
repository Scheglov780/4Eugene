<?php
/*
    Base class for all entities returned by the Telerivet API, including projects,
    contacts, messages, groups, labels, scheduled messages, data tables, and data rows.       
 */

class Telerivet_CustomVars implements Iterator
{
    function __construct($vars)
    {
        $this->_vars = $vars;
    }

    private $_dirty = [];
    private $_vars;

    function __get($name)
    {
        return $this->get($name);
    }

    function __set($name, $value)
    {
        $this->set($name, $value);
    }

    function __isset($name)
    {
        return isset($this->_vars[$name]);
    }

    function __unset($name)
    {
        unset($this->_vars[$name]);
    }

    function all()
    {
        return $this->_vars;
    }

    function clearDirtyVariables()
    {
        $this->_dirty = [];
    }

    function current()
    {
        return current($this->_vars);
    }

    function get($name)
    {
        return isset($this->_vars[$name]) ? $this->_vars[$name] : null;
    }

    function getDirtyVariables()
    {
        return $this->_dirty;
    }

    function key()
    {
        return key($this->_vars);
    }

    function next()
    {
        return next($this->_vars);
    }

    function rewind()
    {
        return reset($this->_vars);
    }

    function set($name, $value)
    {
        $this->_vars[$name] = $value;
        $this->_dirty[$name] = $value;
    }

    function valid()
    {
        return key($this->_vars) !== null;
    }
}

abstract class Telerivet_Entity
{
    function __construct($api, $data, $is_loaded = true)
    {
        $this->_api = $api;
        $this->_setData($data);
        $this->_is_loaded = $is_loaded;
    }

    protected $_api;
    protected $_data;
    protected $_dirty = [];
    protected $_is_loaded;
    protected $_vars;

    abstract function getBaseApiPath();

    protected function _setData($data)
    {
        $this->_data = $data;
        $this->_vars = new Telerivet_CustomVars(isset($data['vars']) ? $data['vars'] : []);
    }

    function __get($name)
    {
        if ($name == 'vars') {
            $this->load();
            return $this->_vars;
        }

        $data = $this->_data;
        if (isset($data[$name])) {
            return $data[$name];
        } else {
            if ($this->_is_loaded || array_key_exists($name, $data)) {
                return null;
            }
        }

        $this->load();
        $data = $this->_data;

        return isset($data[$name]) ? $data[$name] : null;
    }

    function __set($name, $value)
    {
        $this->_data[$name] = $value;
        $this->_dirty[$name] = $value;
    }

    function __toString()
    {
        $res = get_class($this);
        if (!$this->_is_loaded) {
            $res .= " (not loaded)";
        }
        $res .= " JSON: " . json_encode($this->_data);

        return $res;
    }

    function load()
    {
        if (!$this->_is_loaded) {
            $this->_is_loaded = true;
            $old_dirty_vars = $this->_vars->getDirtyVariables();

            $this->_setData($this->_api->doRequest('GET', $this->getBaseApiPath()));

            foreach ($old_dirty_vars as $name => $value) {
                $this->_vars->set($name, $value);
            }

            foreach ($this->_dirty as $name => $value) {
                $this->_data[$name] = $value;
            }
        }
        return $this;
    }

    /**
     * Saves any updated properties to Telerivet.
     */
    function save()
    {
        $dirty_props = $this->_dirty;

        if ($this->_vars) {
            $dirty_vars = $this->_vars->getDirtyVariables();
            if ($dirty_vars) {
                $dirty_props['vars'] = $dirty_vars;
            }
        }

        $this->_api->doRequest('POST', $this->getBaseApiPath(), $dirty_props);
        $this->_dirty = [];

        if ($this->_vars) {
            $this->_vars->clearDirtyVariables();
        }
    }
}
