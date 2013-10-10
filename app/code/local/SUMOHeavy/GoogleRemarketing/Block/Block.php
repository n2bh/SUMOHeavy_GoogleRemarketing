<?php
/**
 * SUMOHeavy_GoogleRemarketing
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@sumoheavy.com so we can send you a copy immediately.
 *
 * @category   SUMOHeavy
 * @package    SUMOHeavy_GoogleRemarketing
 * @copyright  Copyright 2013 SUMO Heavy Industries, LLC
 * @license    http://opensource.org/licenses/osl-3.0.php
 * @author     Sean Kennedy <support@sumoheavy.com>
 */
class SUMOHeavy_GoogleRemarketing_Block_Block extends Mage_Core_Block_Abstract
{

    public function __construct()
    {
        parent::__construct();
        $this->setGoogleConversionId(Mage::getStoreConfig('sumoheavy_googleremarketing/googleremarketing/google_conversion_id'));
        $this->setGoogleConversionLabel(Mage::getStoreConfig('sumoheavy_googleremarketing/googleremarketing/google_conversion_label'));
    }

    protected function _toHtml()
    {
        $_helper = Mage::helper('sumoheavy_googleremarketing');
        $html = '';

        if (Mage::helper('sumoheavy_googleremarketing')->isTrackingAllowed()):
            $_pagetype = $_helper->getPageType();
            $_product = Mage::registry('current_product');
            $_productId = '';
            $_productPrice = '';
            if ($_product) {
                $_productId = $_product->getData('sku');
                $_productPrice = number_format($_product->getFinalPrice(), 2, '.', '');
            }
            $_conversionId = $this->getGoogleConversionId();
            $_conversionLabel = $this->getGoogleConversionLabel();
            $html .= <<<HTML
<script type="text/javascript">
var google_tag_params = {
    ecomm_prodid: '$_productId',
    ecomm_pagetype: '$_pagetype',
    ecomm_totalvalue: '$_productPrice'
};

/* <![CDATA[ */
var google_conversion_id = $_conversionId;
var google_conversion_label = $_conversionLabel;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>

<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/$_conversionId/?value=0&label=$_conversionLabel&guid=ON&script=0"/>
    </div>
</noscript>
HTML;
        endif;

        return $html;
    }
}
