<?php
/**
 * Created by PhpStorm.
 * User: Qoma
 * Date: 19/02/14
 * Time: 18:34
 */

namespace ZFS\DomainModel\Object;

/**
 * Class Object
 * @package ZFS\DomainModel\Object
 */
class Object implements ObjectInterface
{
    /** @var bool  */
    protected $isNew = true;

    /** @var  array */
    protected $data;

    /** @var array */
    protected $fieldToColumnMap = array();

    /** @var array */
    protected $primaryColumns = array();

    /**
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->fromArray($data);
    }

    /**
     * @param bool|null $new
     *
     * @return bool
     */
    public function isNew($new = null)
    {
        if (is_bool($new)) {
            $this->isNew = $new;
        }

        return $this->isNew;
    }

    /**
     * @return array
     */
    public function toArrayPrimary()
    {
        $result = array();
        foreach ($this->primaryColumns as $column) {
            $result[$column] = $this->get($column);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param array $array
     */
    public function fromArray(array $array)
    {
        foreach ($array as $key => &$value) {
            $this->set($key, $value);
        }
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    protected function get($name)
    {
        if (isset($this->fieldToColumnMap[$name]) && isset($this->data[$this->fieldToColumnMap[$name]])) {
            return $this->data[$this->fieldToColumnMap[$name]];
        } elseif (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            return null;
        }
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    protected function set($name, $value)
    {
        if (isset($this->fieldToColumnMap[$name])) {
            $this->data[$this->fieldToColumnMap[$name]] = $value;
        } else {
            $this->data[$name] = $value;
        }

        return $this;
    }

    public function __sleep()
    {
        return array('data');
    }
}
