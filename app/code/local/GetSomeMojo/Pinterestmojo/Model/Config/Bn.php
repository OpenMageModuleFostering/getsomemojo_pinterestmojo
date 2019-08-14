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

class GetSomeMojo_Pinterestmojo_Model_Config_Bn extends Mage_Paypal_Model_Config
{
    /**
    * BN code
    *
    * @param string $countryCode ISO 3166-1
    */
    public function getBuildNotationCode($countryCode = null)
    {
        /*
         * determine Magento Edition by License file name
         */
        if (file_exists('LICENSE_EE.txt')) {
            $newBnCode = 'MojoCreative_SI_MagentoEE';
        } elseif (file_exists('LICENSE_PRO.html')) {
            $newBnCode = 'MojoCreative_SI_MagentoPE';
        } else {
            $newBnCode = 'MojoCreative_SI_MagentoCE';
        }
        return $newBnCode;
    }
}