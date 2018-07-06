<?php

namespace FraudLabsPro;

/**
 * Configuration registry.
 *
 * @copyright  2017 FraudLabsPro.com
 */
class Configuration
{
	public static $global;

	private $_apiKey = null;

	public function __construct($attribs = [])
	{
		foreach ($attribs as $kind => $value) {
			if ($kind == 'apiKey') {
				$this->_apiKey = $value;
			}
		}
	}

	/**
	 * Resets configuration.
	 */
	public static function reset()
	{
		self::$global = new self();
	}

	/**
	 * Get or set API key.
	 *
	 * @param string $value if provided, sets the API key
	 *
	 * @return string fraudLabs Pro API key
	 */
	public static function apiKey($value = null)
	{
		if (empty($value)) {
			return self::$global->getApiKey();
		}
		self::$global->setApiKey($value);
	}

	/**
	 * Get API key.
	 *
	 * @return string fraudLabs Pro API key
	 */
	public function getApiKey()
	{
		return $this->_apiKey;
	}

	/**
	 * Set API key.
	 *
	 * @param string $value sets the API key
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
}

Configuration::reset();
class_alias('FraudLabsPro\Configuration', 'FraudLabsPro_Configuration');
