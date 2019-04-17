<?php


namespace Cobby\Extended\Observer;

use Magento\Framework\Event\ObserverInterface;

class AttributeOption implements ObserverInterface
{
    private $_customAttribute = 'dummy_attribute';

    private $storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ){
        $this->storeManager = $storeManager;
    }

    public function execute(\Magento\Framework\Event\Observer $observer){
        $data = $observer->getAttribute()->getData();

        if($data['attribute_code'] == $this->_customAttribute) {
            //custom data for attribute options, can be loaded from other tables or models
            $items = array(
                array('id'=> 1, 'title'=> 'title 1'),
                array('id'=> 2, 'title'=> 'title 2')
            );

            $stores = $this->storeManager->getStores(true);
            foreach($stores as $storeId => $store) {
                foreach ($items as $item) {
                    $data[] = array(
                        'store_id' => $storeId,
                        'value' => $item['id'],
                        'label' => $item['title'],
                        'use_default' => $storeId > 0
                    );
                }
            }

            $observer->getAttribute()->setData($data);
        }

        return;
    }
}