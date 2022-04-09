<?php
/**
 * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 *
 * @category	Customweb
 * @package		Customweb_PayPalPlusCw
 * 
 */

namespace Customweb\PayPalPlusCw\Model\System\Message;

class LicenseFailed implements \Magento\Framework\Notification\MessageInterface
{
	/**
	 * Retrieve unique message identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return md5('paypalpluscw-license');
    }

    /**
     * Check whether
     *
     * @return bool
     */
        public function isDisplayed()
    {
		
		$arguments = null;
		return \Customweb_Licensing_PayPalPlusCw_License::run('v9v0e9lfavcrls5o', $this, $arguments);
	}

	final public function call_9140ab24v6lnun8h() {
		$arguments = func_get_args();
		$method = $arguments[0];
		$call = $arguments[1];
		$parameters = array_slice($arguments, 2);
		if ($call == 's') {
			return call_user_func_array(array(get_class($this), $method), $parameters);
		}
		else {
			return call_user_func_array(array($this, $method), $parameters);
		}
		
		
	}

    /**
     * Retrieve message text
     *
     * @return string
     */
        public function getText()
    {
		
		$arguments = null;
		return \Customweb_Licensing_PayPalPlusCw_License::run('f235i4cbght3ek9v', $this, $arguments);
	}

	final public function call_9l59bp273s7lesp3() {
		$arguments = func_get_args();
		$method = $arguments[0];
		$call = $arguments[1];
		$parameters = array_slice($arguments, 2);
		if ($call == 's') {
			return call_user_func_array(array(get_class($this), $method), $parameters);
		}
		else {
			return call_user_func_array(array($this, $method), $parameters);
		}
		
		
	}

    /**
     * Retrieve message severity
     *
     * @return int
     */
    public function getSeverity()
    {
        return \Magento\Framework\Notification\MessageInterface::SEVERITY_CRITICAL;
    }
}
####licenseEncrypt####