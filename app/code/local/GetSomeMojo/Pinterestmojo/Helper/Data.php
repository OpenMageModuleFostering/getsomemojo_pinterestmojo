<?php
/**
 * Mojo Creative & Technical Solutions LLC
 *
 * @category   GetSomeMojo
 * @package    GetSomeMojo_Pinterestmojo
 * @copyright  Copyright (c) 2011-2013 Mojo Creative & Technical Solutions LLC (http://GetSome.MojoMage.com)
 * @license    http://getsome.mojomage.com/license/
 * @author     Mojo Creative & Technical Solutions LLC <info@MojoMage.com>
 */
 
class GetSomeMojo_Pinterestmojo_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * System Config Node Value Path Names
     */
    const XML_MOJO                  = 'pinterestmojo';
    const XML_MOJO_GENERAL          = 'general';
    const XML_MOJO_GENERAL_ACTIVATE = 'activate';
    const XML_MOJO_GENERAL_TYPE     = 'type';
    const XML_MOJO_GENERAL_COUNT    = 'count';
    const XML_MOJO_GENERAL_PRICE    = 'price';
    const XML_MOJO_GENERAL_ALIGN    = 'align';
    const XML_MOJO_GENERAL_STYLE    = 'style';
    const XML_MOJO_GENERAL_WIDTH    = 'width';

    /**
     * Get System Config Values
     *
     * @param string $type
     * @param string $value
     * @param mixed $store
     * @return mixed
     */
    public function getSystemConfigValue($type, $value, $store = null)
    {
        return Mage::getStoreConfig(self::XML_MOJO . '/' . $type . '/' . $value, $store);
    }

}