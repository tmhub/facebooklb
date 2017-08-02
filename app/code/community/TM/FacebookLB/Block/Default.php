<?php

class TM_FacebookLB_Block_Default extends Mage_Core_Block_Template
{
    protected $_mapping = array(
        'send'      => 'data-share',
        'layout'    => 'data-layout',
        'showfaces' => 'data-show-faces',
        'width'     => 'data-width',
        'verb'      => 'data-action',
        'color'     => 'data-colorscheme'
    );

    protected function _toHtml()
    {
        if (!$this->getTemplate()) {
            $this->setTemplate('tm/facebooklb/button/custom.phtml');
        }
        $config = $this->getConfig();
        if (($config['enabled'] == 'false') || !$config['enabled']) {
            $this->setTemplate('');
        }
        return parent::_toHtml();
    }

    public function getConfig()
    {
        return $this->helper('facebooklb')->getConfig($this->getConfigKey());
    }

    public function getMapping()
    {
        return $this->_mapping;
    }

}
