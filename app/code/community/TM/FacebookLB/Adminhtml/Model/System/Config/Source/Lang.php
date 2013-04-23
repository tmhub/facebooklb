<?php

class TM_FacebookLB_Adminhtml_Model_System_Config_Source_Lang
{
    public function toOptionArray()
    {
        $path = 'http://facebook.com/translations/FacebookLocales.xml';
        $xml = new Varien_Simplexml_Element($path, 0, true);
        $xmlData = $xml->children();

        $locales = $xmlData;
        $result = array();
        foreach ($xmlData as $locale) {
            $data = $locale->asArray();
            $codes = $data['codes'];
            $code = trim($codes['code']['standard']['representation']);
            $label = $data['englishName'] . ' - ' . $code;

            $result[] = array('value' => $code, 'label' => $label);
        }

        return $result;
    }
}
