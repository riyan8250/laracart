<?php

namespace LukePOLO\LaraCart;

/**
 * Class CartItemOption
 *
 * @package LukePOLO\LaraCart
 */
class CartSubItem
{
    public $locale;
    public $options;
    public $internationalFormat;
    private $itemHash;

    /**
     * @param $options
     */
    public function __construct($options)
    {
        $this->itemHash = \LaraCart::generateHash($options);
        if (isset($options['price']) === true) {
            $options['price'] = floatval($options['price']);
        }
        $this->options = $options;
    }

    /**
     * Gets the hash for the item
     *
     * @return mixed
     */
    public function getHash()
    {
        return $this->itemHash;
    }

    /**
     * Updates an option by its key
     *
     * @param $key
     * @param $value
     *
     * @return string
     */
    public function update($key, $value)
    {
        $this->$key = $value;

        return $this->id = md5(json_encode($this->options));
    }

    /**
     * Magic Method allows for user input as an object
     *
     * @param $option
     *
     * @return mixed | null
     */
    public function __get($option)
    {
        if ($option == 'price') {
            return \LaraCart::formatMoney(array_get($this->options, $option), $this->locale, $this->internationalFormat);
        } else {
            return array_get($this->options, $option);
        }
    }

    /**
     * Magic Method allows for user input to set a value inside a object
     *
     * @param $option
     * @param $value
     */
    public function __set($option, $value)
    {
        array_set($this->options, $option, $value);
    }

    /**
     * Magic Method allows for user to check if an option isset
     *
     * @param $option
     *
     * @return bool
     */
    public function __isset($option)
    {
        if (empty($this->options[$option]) === false) {
            return true;
        } else {
            return false;
        }
    }
}