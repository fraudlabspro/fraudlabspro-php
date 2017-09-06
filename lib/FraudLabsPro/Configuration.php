<?php
namespace FraudLabsPro;

/**
 *
 * Configuration registry
 *
 * @package	   FraudLabsPro
 * @subpackage Utility
 * @copyright  2017 FraudLabsPro.com
 */

class Configuration
{
	public static $global;

	private $_apiKey = null;
	private $_resllerKey = null;

	public function __construct($attribs = [])
	{
		foreach ($attribs as $kind => $value) {
			if ($kind == 'apiKey') {
				$this->_apiKey = $value;
			}

			if ($kind == 'resellerKey') {
				$this->_resellerKey = $value;
			}
		}
	}

	/**
	 * Resets configuration.
	 * @access public
	 */
	public static function reset()
	{
		self::$global = new Configuration();
	}

	/**
	 * Get or set API key.
	 * @access public
	 * @param string $value If provided, sets the API key.
     * @return string FraudLabs Pro API key.
	 */
	public static function apiKey($value = null)
	{
		if (empty($value)) {
			return self::$global->getApiKey();
		}
		self::$global->setApiKey($value);
	}

	/**
	 * Set API key.
	 * @access private
	 * @param string $value Sets the API key.
	 */
	private function setApiKey($value)
    {
		if (empty($value)) {
			throw new \RuntimeException('No API key is provided');
		}

		if (!is_string($value)) {
			throw new \RuntimeException('The API key must be a string');
		}

		if (!preg_match('/^[A-Z0-9]{32}$/', $value)) {
			throw new \RuntimeException('The API key is invalid');
		}

        $this->_apiKey = $value;
    }

	/**
	 * Get API key.
	 * @access public
	 * @return string FraudLabs Pro API key.
	 */
    public function getApiKey()
    {
        return $this->_apiKey;
    }

	/**
	 * Get or set reseller key.
	 * @access public
	 * @param string $value If provided, sets the reseller key.
     * @return string FraudLabs Pro reseller key.
	 */
	public static function resellerKey($value = null)
	{
		if (empty($value)) {
			return self::$global->getResellerKey();
		}
		self::$global->setResellerKey($value);
	}

	/**
	 * Set reseller key.
	 * @access private
	 * @param string $value Sets the reseller key.
	 */
	private function setResellerKey($value)
    {
		if (empty($value)) {
			throw new \RuntimeException('No reseller key is provided');
		}

		if (!is_string($value)) {
			throw new \RuntimeException('The reseller key must be a string');
		}

		if (!preg_match('/^[A-Z0-9]{12}$/', $value)) {
			throw new \RuntimeException('The reseller key is invalid');
		}

        $this->_resellerKey = $value;
    }

	/**
	 * Get reseller key.
	 * @access public
	 * @return string FraudLabs Pro reseller key.
	 */
    public function getResellerKey()
    {
        return $this->_resellerKey;
    }

}

Configuration::reset();
class_alias('FraudLabsPro\Configuration', 'FraudLabsPro_Configuration');
