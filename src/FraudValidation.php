<?php

namespace FraudLabsPro;

/**
 * @deprecated Use \FraudLabsPro\Order instead.
 * This class is maintained for backward compatibility.
 */
class FraudValidation extends Order
{
	// Leave this class empty. 
	// It inherits all constants, properties, and methods from the Order class.
}

// Preserve the existing alias for users relying on the non-namespaced version
class_alias('FraudLabsPro\FraudValidation', 'FraudLabsPro_FraudValidation');