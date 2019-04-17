<?php


namespace Cobby\Extended\Observer;

use Magento\Framework\Event\ObserverInterface;

class CatalogProductImport implements ObserverInterface
{
    private $_customAttribute = 'dummy_attribute';

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $observer->getTransport()->getData();
        $result = array();
        foreach ($data['rows'] as $row) {
            $productId = key_exists('entity_id', $row) ? $row['entity_id'] : false;
            if($productId) {
                foreach ($row['attributes'] as $attribute) {
                    if (key_exists($this->_customAttribute, $attribute)) {
                        $value = $attribute[$this->_customAttribute];
                        //value can be saved in a different attribute or table
                    }
                }
            }

            $result[] = $row;
        }
        $observer->getTransport()->setData($result);

        return;
    }
}