<?php


namespace Cobby\Extended\Observer;

use Magento\Framework\Event\ObserverInterface;

class CatalogProductExport implements ObserverInterface
{
    private $_customAttribute = 'dummy_attribute';

    public function execute(\Magento\Framework\Event\Observer $observer){
        $data = $observer->getTransport()->getData();
        $result = array();

        foreach ($data as $row) {
            $sku = $row['_sku'];
            $productId = $row['_entity_id'];
            foreach ($row['_attributes'] as $storeId => $storeValues) {
                if (key_exists($this->_customAttribute, $row['_attributes'][$storeId])) {

                    $row['_attributes'][$storeId][$this->_customAttribute] = 'changed during export'; // value changed during export
                }
            }
            $result[] = $row;
        }
        $observer->getTransport()->setData($result);

        return;
    }
}