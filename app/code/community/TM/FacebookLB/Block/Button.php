<?php

class TM_FacebookLB_Block_Button extends Mage_Core_Block_Template
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
        $config = $this->getConfig();
        if (($config['enabled'] == 'false') || !$config['enabled']) {
            $this->setTemplate('');
        } elseif (!$this->getTemplate()) {
            if ($config['layout'] == 'custom') {
                $this->setTemplate('tm/facebooklb/button/custom.phtml');
            } else {
                $this->setTemplate('tm/facebooklb/button/default.phtml');
            }
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
