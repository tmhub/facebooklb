<?php

class TM_FacebookLB_Adminhtml_Model_System_Config_Source_Layout
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'button_count', 'label'=>'Button with count'),
            array('value'=>'button', 'label'=>'Button'),
            array('value'=>'standard', 'label'=>'Standard'),
            array('value'=>'box_count', 'label'=>'Box with count'),
            array('value'=>'custom', 'label'=>'Custom Button'),
        );
    }
}
