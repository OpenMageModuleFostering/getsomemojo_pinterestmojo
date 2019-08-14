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
  
class GetSomeMojo_Pinterestmojo_Block_PinterestButton extends Mage_Core_Block_Template
{

    const PIN_BUTTON_ANCHOR_URL = '//pinterest.com/pin/create/button/';
    const PIN_BUTTON_IMAGE_URL  = '//assets.pinterest.com/images/pidgets/pin_it_button.png';

    /**
     * Constructor. Set template.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentStore(Mage::app()->getStore())
            ->setMojoHelper($this->helper('pinterestmojo'))
            ->setYeaH4yeaH($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_ACTIVATE, $this->getCurrentStore()));

        if ($this->getYeaH4yeaH() && $currentProduct = Mage::registry('current_product')) {
            $this->setCurrentProduct($currentProduct);
            $this->setTemplate('getsomemojo/pinterestmojo/pinterest_button.phtml');
        }

    }

    public function _beforeToHtml()
    {

        parent::_beforeToHtml();

        if ($this->getYeaH4yeaH() && $this->getCurrentProduct()) {

            $this->setButtonType($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_TYPE, $this->getCurrentStore()))
                ->setButtonAlign($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_ALIGN, $this->getCurrentStore()))
                ->setPinStyle($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_STYLE, $this->getCurrentStore()));

            if ($this->getButtonType() == 'one') {

                $this->setPinCount($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_COUNT, $this->getCurrentStore()))
                    ->setPinPrice($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_PRICE, $this->getCurrentStore()))
                    ->setPinWidth($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_WIDTH, $this->getCurrentStore()));

                $_pinDesc = Mage::helper('catalog/output')->productAttribute($this->getCurrentProduct(), nl2br($this->getCurrentProduct()->getShortDescription()), 'short_description');

                if ($this->getPinPrice()) {
                    $this->setProductPrice(Mage::helper('core')->currency($this->getCurrentProduct()->getPrice(), true, false));
                    $_pinDesc .= " [" . $this->getProductPrice() . "]";
                }

                $this->setPinDesc($_pinDesc);

                $_pinImage = urlencode(
                                $this->helper('catalog/image')
                                ->init($this->getCurrentProduct(), 'image')
                                ->resize($this->getPinWidth(), null)
                                ->constrainOnly(TRUE)
                                ->keepAspectRatio(TRUE)
                                ->keepFrame(FALSE)
                            );

                $this->setPinImage($_pinImage);

                /* @MOJO - Addresses/Fixes certain web server settings for URL rewrites */
                $_pinUrl = $this->_getPinButtonAnchorUrl() . "?url=" . Mage::helper('core/url')->getCurrentUrl() . "&media=" . $this->getPinImage() . "&description=" . $this->getPinDesc();
                $this->setPinUrl(str_replace('.html?', '.html&', $_pinUrl));

            }

        }

    }

    public function _getPinButtonAnchorUrl()
    {
        return self::PIN_BUTTON_ANCHOR_URL;
    }

    public function _getPinButtonImageUrl()
    {
        return self::PIN_BUTTON_IMAGE_URL;
    }

}