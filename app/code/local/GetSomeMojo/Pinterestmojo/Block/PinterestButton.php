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

class GetSomeMojo_Pinterestmojo_Block_PinterestButton extends Mage_Core_Block_Template
{

    const PIN_BUTTON_ANCHOR_URL = '//pinterest.com/pin/create/button/';
    const PIN_BUTTON_IMAGE_URL  = '//assets.pinterest.com/images/pidgets/pin_it_button.png';
    const PIN_BUTTON_IMAGE_URL_SMALL_GRAY  = '//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png';
    const PIN_BUTTON_IMAGE_URL_LARGE_GRAY  = '//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_28.png';
    const PIN_BUTTON_IMAGE_URL_SMALL_RED   = '//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png';
    const PIN_BUTTON_IMAGE_URL_LARGE_RED   = '//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_28.png';
    const PIN_BUTTON_IMAGE_URL_SMALL_WHITE = '//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_white_20.png';
    const PIN_BUTTON_IMAGE_URL_LARGE_WHITE = '//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_white_28.png';

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
            $this->setTemplate('getsomemojo/pinterestmojo/pinit.phtml');
        }

    }

    public function _beforeToHtml()
    {

        parent::_beforeToHtml();

        if ($this->getYeaH4yeaH() && $this->getCurrentProduct()) {

            $this->setButtonType($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_TYPE, $this->getCurrentStore()))
                ->setButtonSize($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_SIZE, $this->getCurrentStore()))
                ->setButtonShape($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_SHAPE, $this->getCurrentStore()))
                ->setButtonColor($this->getMojoHelper()->getSystemConfigValue(GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL, GetSomeMojo_Pinterestmojo_Helper_Data::XML_MOJO_GENERAL_COLOR, $this->getCurrentStore()))
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
        if ($this->_getPinButtonShape() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonShape::OPTION1_VALUE) {
            if ($this->getButtonColor() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonColor::OPTION1_VALUE &&
                $this->getButtonSize() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonSize::OPTION1_VALUE) {
                return self::PIN_BUTTON_IMAGE_URL_LARGE_RED;
            } elseif ($this->getButtonColor() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonColor::OPTION1_VALUE &&
                $this->getButtonSize() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonSize::OPTION2_VALUE) {
                return self::PIN_BUTTON_IMAGE_URL_SMALL_RED;
            }

            if ($this->getButtonColor() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonColor::OPTION2_VALUE &&
                $this->getButtonSize() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonSize::OPTION1_VALUE) {
                return self::PIN_BUTTON_IMAGE_URL_LARGE_GRAY;
            } elseif ($this->getButtonColor() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonColor::OPTION2_VALUE &&
                $this->getButtonSize() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonSize::OPTION2_VALUE) {
                return self::PIN_BUTTON_IMAGE_URL_SMALL_GRAY;
            }

            if ($this->getButtonColor() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonColor::OPTION3_VALUE &&
                $this->getButtonSize() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonSize::OPTION1_VALUE) {
                return self::PIN_BUTTON_IMAGE_URL_LARGE_WHITE;
            } elseif ($this->getButtonColor() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonColor::OPTION3_VALUE &&
                $this->getButtonSize() == GetSomeMojo_Pinterestmojo_Model_Config_ButtonSize::OPTION2_VALUE) {
                return self::PIN_BUTTON_IMAGE_URL_SMALL_WHITE;
            }
        }

        return self::PIN_BUTTON_IMAGE_URL;
    }

    public function _getPinButtonShape()
    {
        if ($this->getButtonShape() != '') {
            return $this->getButtonShape();
        } else {
            return GetSomeMojo_Pinterestmojo_Model_Config_ButtonShape::OPTION1_VALUE;
        }
    }

    public function _getPinButtonSize()
    {
        if ($this->getButtonSize() != '') {
            return $this->getButtonSize();
        } else {
            return GetSomeMojo_Pinterestmojo_Model_Config_ButtonSize::OPTION1_VALUE;
        }
    }

}
