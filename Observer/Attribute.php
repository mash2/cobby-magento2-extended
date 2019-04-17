<?php


namespace Cobby\Extended\Observer;

use Magento\Framework\Event\ObserverInterface;


class Attribute implements ObserverInterface
{
    private $_customAttribute = 'dummy_attribute'; //dummy attribute

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $observer->getTransport()->getData();

        if ($data['attribute_code'] == $this->_customAttribute) {
            $data['is_user_defined'] = 0; //simulate system attribute

            $observer->getTransport()->setData($data);
        }

        return;
    }
}