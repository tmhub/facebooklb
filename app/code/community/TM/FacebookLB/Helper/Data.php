<?php

class TM_FacebookLB_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getCategoryLikeButton($product)
    {
        $result = '';
        if (Mage::getStoreConfig('facebooklb/category_products/enabled')) {
            $layout = Mage::getStoreConfig('facebooklb/category_products/layout');
            $width = Mage::getStoreConfig('facebooklb/category_products/width');
            $action = Mage::getStoreConfig('facebooklb/category_products/verb');
            $dataAttr = '';
            $dataAttr .= ' data-href="' . $product->getProductUrl() . '"';
            $dataAttr .= ' data-layout="' . $layout . '"';
            $dataAttr .= ' data-action="' . $action . '"';
            $dataAttr .= ' data-width="' . $width . '"';
            if (Mage::getStoreConfig('facebooklb/category_products/send')) {
                $dataAttr .= ' data-share="true"';
            }
            if (Mage::getStoreConfig('facebooklb/category_products/showfaces')) {
                $dataAttr .= ' data-show-faces="true"';
            }
            if (Mage::getStoreConfig('facebooklb/category_products/color') != 'light') {
                $dataAttr .= ' data-colorscheme="dark"';
            }
            $result = '<div class="fb-like"' . $dataAttr . '></div>';
        }
        return $result;
    }
}
