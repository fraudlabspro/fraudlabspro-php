<?php
/**
 * FraudLabsPro PHP Library
 * Implements fraud checking solution using FraudLabs Pro service.
 * API key is required, and if you do not have an API key, you may sign up free
 * at at http://www.fraudlabspro.com
 *
 * @copyright 2017 FraudLabs Pro
 * http://www.fraudlabspro.com
 */

 require_once('autoload.php');

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    throw new \RuntimeException('PHP version >= 5.4.0 required');
}

function requireDependencies() {
    $requiredExtensions = ['curl'];
    foreach ($requiredExtensions as $ext) {
        if (!extension_loaded($ext)) {
            throw new \RuntimeException('The FraudLabsPro library requires the ' . $ext . ' extension.');
        }
    }
}

requireDependencies();