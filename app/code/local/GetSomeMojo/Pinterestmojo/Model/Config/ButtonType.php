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

class GetSomeMojo_Pinterestmojo_Model_Config_ButtonType extends Mage_Core_Model_Config_Data
{

    const OPTION1_VALUE = 'one';
    const OPTION2_VALUE = 'any';
    const OPTION3_VALUE = 'hover';

    /**
     * Fills the select field with values
     * 
     * @return array
     */
    public function toOptionArray()
    {

        return array(
            self::OPTION1_VALUE => Mage::helper('pinterestmojo')->__('One Image'),
            self::OPTION2_VALUE => Mage::helper('pinterestmojo')->__('Any Image'),
            self::OPTION3_VALUE => Mage::helper('pinterestmojo')->__('Image Hover'),
        );

    }

}