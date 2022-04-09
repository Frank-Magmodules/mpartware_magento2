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

namespace Customweb\PayPalPlusCw\Model\Authorization\Method;

abstract class AbstractMethod
{
	/**
	 * @var \Psr\Log\LoggerInterface
	 */
	protected $_logger;

	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $_orderRepository;

	/**
	 * @var \Magento\Sales\Model\Order\Email\Sender\OrderSender
	 */
	protected $_orderSender;

	/**
	 * @var \Magento\Sales\Model\Order\Email\Sender\InvoiceSender
	 */
	protected $_invoiceSender;
	
	/**
	 * Core event manager proxy
	 *
	 * @var \Magento\Framework\Event\ManagerInterface
	 */
	protected $_eventManager;

	/**
	 * @var \Customweb\PayPalPlusCw\Model\DependencyContainer
	 */
	protected $_container;

	/**
	 * @var \Customweb\PayPalPlusCw\Model\Alias\Handler
	 */
	protected $_aliasHandler;

	/**
	 * @var \Customweb\PayPalPlusCw\Model\Authorization\TransactionContextFactory
	 */
	protected $_transactionContextFactory;

	/**
	 * @var \Customweb\PayPalPlusCw\Model\Authorization\TransactionFactory
	 */
	protected $_transactionFactory;

	/**
	 * @var \Customweb\PayPalPlusCw\Model\ResourceModel\Authorization\Transaction\CollectionFactory
	 */
	protected $_transactionCollectionFactory;

	/**
	 * @var \Customweb\PayPalPlusCw\Model\Authorization\Method\Context\Factory
	 */
	protected $_contextFactory;

	/**
	 * @var \Magento\Checkout\Model\Session
	 */
	protected $_checkoutSession;

	/**
	 * @var \Customweb_Payment_Authorization_IAdapter
	 */
	private $interfaceAdapter;

	/**
	 * @var \Customweb\PayPalPlusCw\Model\Authorization\Method\Context\IContext
	 */
	private $context;

	/**
	 * @param \Psr\Log\LoggerInterface $logger
	 * @param \Magento\Framework\Registry $coreRegistry
	 * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
	 * @param \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender
	 * @param \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender
	 * @param \Magento\Framework\Event\ManagerInterface $eventManager
	 * @param \Magento\Checkout\Model\Session $checkoutSession
	 * @param \Customweb\PayPalPlusCw\Model\DependencyContainer $container
	 * @param \Customweb\PayPalPlusCw\Model\Alias\Handler $aliasHandler
	 * @param \Customweb\PayPalPlusCw\Model\Authorization\TransactionContextFactory $transactionContextFactory
	 * @param \Customweb\PayPalPlusCw\Model\Authorization\TransactionFactory $transactionFactory
	 * @param \Customweb\PayPalPlusCw\Model\ResourceModel\Authorization\Transaction\CollectionFactory $transactionCollectionFactory
	 * @param \Customweb\PayPalPlusCw\Model\Authorization\Method\Context\Factory $contextFactory
	 * @param \Customweb\PayPalPlusCw\Model\Authorization\Method\Context\IContext $context
	 */
	public function __construct(
			\Psr\Log\LoggerInterface $logger,
			\Magento\Framework\Registry $coreRegistry,
			\Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
			\Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender,
			\Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender,
            \Magento\Framework\Event\ManagerInterface $eventManager,
			\Magento\Checkout\Model\Session $checkoutSession,
			\Customweb\PayPalPlusCw\Model\DependencyContainer $container,
			\Customweb\PayPalPlusCw\Model\Alias\Handler $aliasHandler,
			\Customweb\PayPalPlusCw\Model\Authorization\TransactionContextFactory $transactionContextFactory,
			\Customweb\PayPalPlusCw\Model\Authorization\TransactionFactory $transactionFactory,
			\Customweb\PayPalPlusCw\Model\ResourceModel\Authorization\Transaction\CollectionFactory $transactionCollectionFactory,
			\Customweb\PayPalPlusCw\Model\Authorization\Method\Context\Factory $contextFactory,
			\Customweb\PayPalPlusCw\Model\Authorization\Method\Context\IContext $context


	) {
		$this->_logger = $logger;
		$this->_coreRegistry = $coreRegistry;
		$this->_orderRepository = $orderRepository;
		$this->_orderSender = $orderSender;
		$this->_invoiceSender = $invoiceSender;
		$this->_eventManager = $eventManager;
		$this->_checkoutSession= $checkoutSession;
		$this->_container = $container;
		$this->_aliasHandler = $aliasHandler;
		$this->_transactionContextFactory = $transactionContextFactory;
		$this->_transactionFactory = $transactionFactory;
		$this->_transactionCollectionFactory = $transactionCollectionFactory;
		$this->_contextFactory = $contextFactory;
		$this->context = $context;

	}

	/**
	 * @return \Customweb\PayPalPlusCw\Model\Authorization\Method\Context\IContext
	 */
	public function getContext()
	{
		if (!($this->context instanceof \Customweb\PayPalPlusCw\Model\Authorization\Method\Context\IContext)) {
			throw new \Exception("No context has been set.");
		}
		return $this->context;
	}

	/**
	 * @param \Customweb\PayPalPlusCw\Model\Authorization\Method\Context\IContext $context
	 */
	public function setContext(\Customweb\PayPalPlusCw\Model\Authorization\Method\Context\IContext $context)
	{
		$this->context = $context;
	}

	/**
	 * @return \Customweb_Payment_Authorization_IAdapter
	 */
	public function getAdapter()
	{
		if (!($this->interfaceAdapter instanceof \Customweb_Payment_Authorization_IAdapter)) {
			$this->interfaceAdapter = $this->_container->getBean($this->getAdapterInterfaceName());
		}
		return $this->interfaceAdapter;
	}

	public function initializeTransaction(\Customweb\PayPalPlusCw\Model\Authorization\Transaction $transaction)
	{
		
		$arguments = array(
			'transaction' => $transaction,
 		);
		return \Customweb_Licensing_PayPalPlusCw_License::run('51tfsr8j67bmrn9e', $this, $arguments);
	}

	final public function call_k8daf1dr783hd77j() {
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
	 * @return \Customweb\PayPalPlusCw\Model\Service\AuthorizationData
	 */
	public function startAuthorization()
	{
		$data = new \Customweb\PayPalPlusCw\Model\Service\AuthorizationData();
		$data->setFormActionUrl($this->getFormActionUrl());
		$data->setHiddenFormFields($this->getHiddenFormFields());
		return $data;
	}

	/**
	 * @param \Customweb\PayPalPlusCw\Model\Authorization\Transaction $transaction
	 */
	public function finishAuthorization()
	{
		
		$arguments = null;
		return \Customweb_Licensing_PayPalPlusCw_License::run('ef849ci76kaf6t24', $this, $arguments);
	}

	final public function call_f0m6deq7mabp7jk8() {
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
	 * @return string
	 */
	public function getFormActionUrl()
	{
		if (method_exists($this->getAdapter(), 'getFormActionUrl')) {
			$result = $this->getAdapter()->getFormActionUrl($this->getContext()->getTransaction()->getTransactionObject());
			$this->getContext()->getTransaction()->save();
			return $result;
		} else {
			return '';
		}
	}

	/**
	 * @return \Customweb_Form_IElement[]
	 */
	public function getVisibleFormFields()
	{
		$formFields = [];
		if ($this->getContext()->getOrderContext()->isValid()) {
			$aliasFormField = $this->getAliasFormField();
			if ($aliasFormField instanceof \Customweb_Form_IElement) {
				$formFields[] = $aliasFormField;
			}
			if (method_exists($this->getAdapter(), 'getVisibleFormFields')) {
				$formFields = array_merge($formFields, $this->getAdapter()->getVisibleFormFields(
						$this->getContext()->getOrderContext(),
						$this->getAliasTransaction() == null ? null : $this->getAliasTransaction()->getTransactionObject(),
						null,
						$this->getContext()->getCustomerContext()
				));
				$this->getContext()->getCustomerContext()->save();
			}
		}
		return $formFields;
	}

	/**
	 * @return array
	 */
	public function getHiddenFormFields()
	{
		if (method_exists($this->getAdapter(), 'getHiddenFormFields')) {
			$result = $this->getAdapter()->getHiddenFormFields($this->getContext()->getTransaction()->getTransactionObject());
			$this->getContext()->getTransaction()->save();
			return $result;
		} else {
			return '';
		}
	}

	/**
	 * @throws \Exception
	 * @return void
	 */
	public function preValidate()
	{
		if ($this->getContext()->getOrderContext()->isValid()) {
			try {
				$this->getAdapter()->preValidate($this->getContext()->getOrderContext(), $this->getContext()->getCustomerContext());
			} catch (\Exception $e) {
				$this->getContext()->getCustomerContext()->save();
				throw $e;
			}
		}
		$this->getContext()->getCustomerContext()->save();
	}

	/**
	 * @throws \Exception
	 * @return void
	 */
	public function validate()
	{
		try {
			$this->getAdapter()->validate($this->getContext()->getOrderContext(), $this->getContext()->getCustomerContext(), $this->getContext()->getParameters());
		} catch (\Exception $e) {
			$this->getContext()->getCustomerContext()->save();
			throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()), $e);
		}
		$this->getContext()->getCustomerContext()->save();
	}

	/**
	 * @return \Customweb_Form_IElement
	 */
	protected function getAliasFormField()
	{
		
	}

	/**
	 * @return \Customweb\PayPalPlusCw\Model\Authorization\Transaction|null
	 */
	protected function getAliasTransaction()
	{
		if ($this->getContext()->getAliasTransaction() != null && $this->getContext()->getAliasTransaction() != 'new') {
			$aliasTransaction = $this->_transactionFactory->create()->load($this->getContext()->getAliasTransaction());
			if ($aliasTransaction->getId()) {
				return $aliasTransaction;
			}
		}
		return null;
	}

	/**
	 * @return \Magento\Sales\Model\Order\Invoice
	 */
	private function createInvoice()
	{
		if ($this->getContext()->getPaymentMethod() instanceof \Customweb\PayPalPlusCw\Model\Payment\Method\AbstractMethod) {
			$payment = $this->getContext()->getTransaction()->getOrderPayment();
			if ($this->getContext()->getPaymentMethod()->getPaymentMethodConfigurationValue('settlement') == 'direct') {
				$order = $this->getContext()->getOrder();
				if (!$order->hasInvoices()) {
					$invoice = $order->prepareInvoice();
					$invoice->register();
					$invoice->setTransactionId($payment->getTransactionId());
					$order->addRelatedObject($invoice);
					return $invoice;
				}
			}
		}
	}

	/**
	 * @param \Magento\Sales\Api\Data\OrderInterface $order
	 * @param string $transactionId
	 * @return \Magento\Sales\Model\Order\Invoice
	 */
	private function getInvoiceByTransactionId(\Magento\Sales\Api\Data\OrderInterface $order, $transactionId) {
		foreach ($order->getInvoiceCollection() as $invoice) {
			if ($invoice->getTransactionId() == $transactionId) {
				$invoice->load($invoice->getId());
				// to make sure all data will properly load (maybe not required)
				return $invoice;
			}
		}
		foreach ($order->getInvoiceCollection() as $invoice) {
			if ($invoice->getState() == \Magento\Sales\Model\Order\Invoice::STATE_OPEN
				&& $invoice->load($invoice->getId())) {
				$invoice->setTransactionId($transactionId);
				return $invoice;
			}
		}
	}

	private function sendInvoiceEmail(\Magento\Sales\Model\Order\Invoice $invoice)
	{
		if ($this->getContext()->getPaymentMethod() instanceof \Customweb\PayPalPlusCw\Model\Payment\Method\AbstractMethod) {
			if ($this->getContext()->getPaymentMethod()->getPaymentMethodConfigurationValue('invoice_email')) {
				$this->_invoiceSender->send($invoice);
			}
		}
	}

	/**
	 * Retrieve the interface name of the adapter.
	 *
	 * @return string
	 */
	abstract protected function getAdapterInterfaceName();

	private function getTransactionContextFactory() {
		return $this->_transactionContextFactory;
	}

	private function getCheckoutSession() {
		return $this->_checkoutSession;
	}

	private function getContextFactory() {
		return $this->_contextFactory;
	}

	private function getCoreRegistry() {
		return $this->_coreRegistry;
	}
	
	private function getEventManager() {
	    return $this->_eventManager;
	}

	private function getOrderSender() {
		return $this->_orderSender;
	}

	private function getLogger() {
		return $this->_logger;
	}

	public function getOrderRepository(){
		return $this->_orderRepository;
	}
}