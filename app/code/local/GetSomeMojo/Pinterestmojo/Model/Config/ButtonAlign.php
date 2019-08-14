<?php
/**
 * Mojo Creative & Technical Solutions LLC
 *
 * @category   GetSomeMojo
 * @package    GetSomeMojo_Pinterestmojo
 * @copyright  Copyright (c) 2011-2015 Mojo Creative & Technical Solutions LLC (http://GetSome.MojoMage.com)
 * @license    http://getsome.mojomage.com/license/
 * @author     Mojo Creative & Technical Solutions LLC <info@MojoMage.com>
 */

class GetSomeMojo_Pinterestmojo_Model_Config_ButtonAlign extends Mage_Core_Model_Config_Data
{

    const OPTION1_VALUE = 'left';
    const OPTION2_VALUE = 'right';

    /**
     * Fills the select field with values
     *
     * @return array
     */
    public function toOptionArray()
    {

        return array(
            self::OPTION1_VALUE => Mage::helper('pinterestmojo')->__('Left'),
            self::OPTION2_VALUE => Mage::helper('pinterestmojo')->__('Right')
        );

    }

}
