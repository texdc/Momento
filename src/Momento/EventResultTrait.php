<?php
/**
 * EventResultTrait.php
 *
 * @copyright 2014 George D. Cooksey, III
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace Momento;

/**
 * Basic implementation of the {@link EventResult} interface as an immutable value
 * object.  Encapsulted properties are externally available, but they cannot be
 * externally modified.
 *
 * @package Momento
 */
trait EventResultTrait
{
    /**
     * @var bool
     */
    private $final = false;

    /**
     * @var string[]
     */
    private $errors = [];


    /**
     * Was the processing successful?
     *
     * @return bool
     */
    public function isSuccess()
    {
        return empty($this->errors);
    }

    /**
     * Should event proccessing be halted?
     *
     * @return bool
     */
    public function isFinal()
    {
        return (bool) $this->final;
    }

    /**
     * Determine the final state
     *
     * @param  bool $final the final state
     * @return void
     */
    private function setFinal($final = true)
    {
        $this->final = (bool) $final;
    }

    /**
     * Get the processing errors
     *
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set, or clear, the errors
     *
     * @param  string[] $errors the errors to set
     * @return void
     */
    private function setErrors(array $errors = [])
    {
        $this->errors = $errors;
    }

    /**
     * Provide 'magic' public access to properties
     *
     * @param  string $aProperty the property name
     * @return mixed
     * @throws Exception\InvalidPropertyException
     */
    public function __get($aProperty)
    {
        $getter = 'get' . $aProperty;
        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        } elseif (property_exists($this, $aProperty)) {
            return $this->{$aProperty};
        }
        throw new Exception\InvalidPropertyException(
            "$aProperty is not a valid property"
        );
    }

    /**
     * Prevent public mutation
     *
     * @param  string $aProperty the property name
     * @param  mixed  $asValue   the property value
     * @throws Exception\ImmutableException
     */
    final public function __set($aProperty, $asValue)
    {
        throw new Exception\ImmutableException(__CLASS__ . ' is immutable');
    }
}
