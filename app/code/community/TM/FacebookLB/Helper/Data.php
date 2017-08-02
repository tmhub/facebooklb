<?php

class TM_FacebookLB_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected $_config = array();

    protected $_mapping = array(
            'send'      => 'data-share',
            'layout'    => 'data-layout',
            'showfaces' => 'data-show-faces',
            'width'     => 'data-width',
            'verb'      => 'data-action',
            'color'     => 'data-colorscheme'
        );

    public function getCategoryLikeButton($product)
    {
        if (!Mage::getStoreConfig('facebooklb/category_products/enabled')) {
            return;
        }
        $oldUrl = $product->getData('url');
        $oldRequestPath = $product->getData('request_path');
        $product->setData('url', '');
        $product->setData('request_path', '');

        $params = array('_ignore_category' => true);
        $url = $product->getUrlModel()->getUrl($product, $params);

        $product->setData('url', $oldUrl);
        $product->setData('request_path', $oldRequestPath);

        return $this->renderLikeButton($url, 'category_products');
    }

    public function renderLikeButton($url, $configKey)
    {
        if (!Mage::getStoreConfig('facebooklb/general/enabled')) {
            return '';
        }
        $config = $this->getConfig($configKey);
        $button = $this->getLayout()
            ->createBlock('facebooklb/default')
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
}
