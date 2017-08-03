<?php

class TM_FacebookLB_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected $_config = array();

    public function getCategoryLikeButton($product)
    {
        $html = '';

        if ($this->isCategoryButtonAvailable()) {
            $oldUrl = $product->getData('url');
            $oldRequestPath = $product->getData('request_path');
            $product->setData('url', '');
            $product->setData('request_path', '');

            $params = array('_ignore_category' => true);
            $url = $product->getUrlModel()->getUrl($product, $params);

            $product->setData('url', $oldUrl);
            $product->setData('request_path', $oldRequestPath);

            $html = $this->renderLikeButton($url, 'category_products');
        }

        return $html;
    }

    public function renderLikeButton($url, $configKey)
    {
        if (!Mage::getStoreConfig('facebooklb/general/enabled')) {
            return '';
        }
        $button = Mage::app()->getLayout()
            ->createBlock('facebooklb/button')
            ->setLikeUrl($url)
            ->setConfigKey($configKey);
        return $button->toHtml();
    }

    public function getConfig($parentConfigKey)
    {
        if (!isset($this->_config[$parentConfigKey])) {
            $config = Mage::getStoreConfig('facebooklb/' . $parentConfigKey);
            if ($config['layout'] != 'standard') {
                unset($config['showfaces'], $config['width']);
            }
            // transporm config to facebook values
            foreach ($config as $key => $value) {
                switch ($value) {
                    case '1':
                        $config[$key] = 'true';
                        break;

                    case '0':
                        $config[$key] = 'false';
                        break;
                }
            }
            $this->_config[$parentConfigKey] = $config;
        }
        return $this->_config[$parentConfigKey];
    }

    public function getHandles()
    {
        return Mage::app()->getLayout()->getUpdate()->getHandles();
    }

    public function isCategoryButtonAvailable()
    {
        if (Mage::getStoreConfig('facebooklb/general/enabled')) {
            $allowed = array(
                'catalog_category_default',
                'catalog_category_layered',
                'catalogsearch_result_index'
            );
            return !empty(array_intersect($allowed, $this->getHandles()));
        }
        return false;
    }
}
