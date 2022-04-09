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

namespace Customweb\PayPalPlusCw\Model\Config\Source\Paypalplus;

class Currency implements \Magento\Framework\Option\ArrayInterface
{
	/**
	 * @return array
	 */
	public function toOptionArray()
	{
		return [
			['value' => 'USD', 'label' => __('United States dollar (USD)')],
			['value' => 'CHF', 'label' => __('Swiss franc (CHF)')],
			['value' => 'EUR', 'label' => __('Euro (EUR)')],
			['value' => 'AUD', 'label' => __('Australian dollar (AUD)')],
			['value' => 'BRL', 'label' => __('Brazilian real (BRL)')],
			['value' => 'CAD', 'label' => __('Canadian dollar (CAD)')],
			['value' => 'CZK', 'label' => __('Czech koruna (CZK)')],
			['value' => 'DKK', 'label' => __('Danish krone (DKK)')],
			['value' => 'HKD', 'label' => __('Hong Kong dollar (HKD)')],
			['value' => 'HUF', 'label' => __('Hungarian forint (HUF)')],
			['value' => 'ILS', 'label' => __('Israeli new shekel (ILS)')],
			['value' => 'JPY', 'label' => __('Japanese yen (JPY)')],
			['value' => 'MYR', 'label' => __('Malaysian ringgit (MYR)')],
			['value' => 'MXN', 'label' => __('Mexican peso (MXN)')],
			['value' => 'NOK', 'label' => __('Norwegian krone (NOK)')],
			['value' => 'INR', 'label' => __('Indian rupee (INR)')],
			['value' => 'NZD', 'label' => __('New Zealand dollar (NZD)')],
			['value' => 'PHP', 'label' => __('Philippine peso (PHP)')],
			['value' => 'PLN', 'label' => __('Polish złoty (PLN)')],
			['value' => 'GBP', 'label' => __('Pound sterling (GBP)')],
			['value' => 'SGD', 'label' => __('Singapore dollar (SGD)')],
			['value' => 'SEK', 'label' => __('Swedish krona (SEK)')],
			['value' => 'TWD', 'label' => __('New Taiwan dollar (TWD)')],
			['value' => 'THB', 'label' => __('Thai baht (THB)')],
			['value' => 'TRY', 'label' => __('Turkish lira (TRY)')],
		];
	}
}
