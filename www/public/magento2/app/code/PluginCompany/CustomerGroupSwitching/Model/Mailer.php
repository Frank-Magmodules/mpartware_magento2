<?php
/**
 *
 * Created by:  Milan Simek
 * Company:     Plugin Company
 *
 * LICENSE: http://plugin.company/docs/magento-extensions/magento-extension-license-agreement
 *
 * YOU WILL ALSO FIND A PDF COPY OF THE LICENSE IN THE DOWNLOADED ZIP FILE
 *
 * FOR QUESTIONS AND SUPPORT
 * PLEASE DON'T HESITATE TO CONTACT US AT:
 *
 * SUPPORT@PLUGIN.COMPANY
 *
 */
namespace PluginCompany\CustomerGroupSwitching\Model;

use Magento\Customer\Model\Customer;
use Magento\Email\Model\Template\Filter;
use Magento\Email\Model\Template\FilterFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\DataObject;

class Mailer
{

    private $mailData;

    /**
     * @var Filter
     */
    private $templateFilter;
    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    private $templateVars = [];

    /**
     * @var FilterFactory
     */
    private $filterFactory;

    public function __construct(
        TransportBuilder $transportBuilder,
        FilterFactory $filterFactory
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->filterFactory = $filterFactory;
        $this->templateFilter = $this->filterFactory->create();
    }

    public function setReplyTo($value, $name = null)
    {
        $this->getMailData()
            ->setReplyTo($value);
        return $this;
    }

    public function setFromEmail($value)
    {
        $this->getMailData()
            ->setFromEmail($value);
        return $this;
    }

    public function setFromName($value)
    {
        $this->getMailData()
            ->setFromName($value);
        return $this;
    }

    public function setSubject($value)
    {
        $this->getMailData()
            ->setSubject($value);
        return $this;
    }

    public function setBcc($value)
    {
        $this->getMailData()
            ->setBcc($value);
        return $this;
    }

    public function setToName($value)
    {
        $this->getMailData()
            ->setToName($value);
        return $this;
    }

    public function setToEmail($value)
    {
        $this->getMailData()
            ->setToEmail($value);
        return $this;
    }

    public function setBody($value)
    {
        $this->getMailData()
            ->setBody($value)
        ;
        return $this;
    }

    public function setTemplateVars($vars)
    {
        if(isset($vars['customer'])) {
            $customer = $vars['customer'];
            $vars['customer'] = $customer->getData();
            $vars['customer']['name'] = $customer->getName();
            $vars['customer'] = new DataObject($vars['customer']);
        }
        if(isset($vars['store'])) {
            $vars['store'] = new DataObject($vars['store']->getData());
        }
        $this->templateVars = array_merge($this->templateVars, $vars);
        $this->transportBuilder
            ->setTemplateVars($this->templateVars)
        ;
        return $this;
    }

    /**
     * @return DataObject
     */
    public function getMailData()
    {
        if(!$this->mailData){
            $this->initMailData();
        }
        return $this->mailData;
    }

    private function initMailData()
    {
        $this->mailData = new DataObject();
        return $this;
    }

    public function resetMailData()
    {
        return $this->initMailData();
    }

    public function sendMail()
    {
        $this->filterMailData();
        $mailData = $this->mailData;
        $transportBuilder = $this->transportBuilder
            ->setTemplateIdentifier('customer_group_switch_notification')
            ->setTemplateOptions(
                [
                    'area' => 'frontend',
                    'store' => $this->templateVars['store']->getStoreId()
                ]
            )
            ->setTemplateVars([
                'email_subject' => $mailData->getSubject(),
                'content' => $mailData->getBody()
            ])
            ->setFrom(
                [
                    'email' => $mailData->getFromEmail(),
                    'name' => $mailData->getFromName()
                ]
            )
            ->addTo($this->getToEmail(), $mailData->getToName())
        ;
        if($mailData->getReplyTo()) {
            $transportBuilder->setReplyTo($mailData->getReplyTo());
        }
        if($this->getBcc()){
            $transportBuilder->addBcc($this->getBcc());
        }

        $transport = $transportBuilder->getTransport();

        $transport->sendMessage();
        return $this;
    }

    public function getToEmail()
    {
        return $this->explodeIfCommaDelimited(
            $this->mailData->getData('to_email')
        );
    }

    public function getBcc()
    {
        return $this->explodeIfCommaDelimited(
            $this->mailData->getData('bcc')
        );
    }

    private function explodeIfCommaDelimited($mail)
    {
        if(!is_array($mail) && stristr($mail,',')){
            $mail = explode(',', $mail);
        }
        if(is_array($mail)) {
            $mail = array_map('trim', $mail);
        }
        return $mail;
    }

    private function filterMailData()
    {
        foreach($this->getMailData()->getData() as $k => $v)
        {
            $this->getMailData()
                ->setData($k, $this->getFilteredVar($v));
        }
        return $this;
    }

    private function getFilteredVar($v)
    {
        return $this->getTemplateFilter()->filter($v);
    }

    private function getTemplateFilter()
    {
        return $this->templateFilter
            ->setStoreId($this->getStoreId())
            ->setVariables($this->templateVars)
            ;
    }

    private function getStoreId()
    {
        return $this->templateVars['store']->getStoreId();
    }

}
