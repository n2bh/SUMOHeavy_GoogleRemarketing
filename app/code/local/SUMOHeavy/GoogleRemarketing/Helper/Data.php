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
class SUMOHeavy_GoogleRemarketing_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isTrackingAllowed()
    {
        return Mage::getStoreConfigFlag('sumoheavy_googleremarketing/googleremarketing/enabled');
    }

    public function isHomepage() {
        return (Mage::getSingleton('cms/page')->getIdentifier() == 'home' ? true : false);
    }

    public function getPageType()
    {
        $_pagetype = 'siteview';
        $_controllerName = Mage::app()->getRequest()->getControllerName();
        $_actionName = Mage::app()->getRequest()->getActionName();
        switch ($_controllerName) {
            case 'index':
                if ($this->isHomepage())
                    $_pagetype = 'home';
                break;
            case 'category':
                $_pagetype = 'category';
                break;
            case 'product':
                $_pagetype = 'product';
                break;
            case 'cart':
                $_pagetype = 'cart';
                break;
            case 'onepage':
                if ($_actionName == 'success') {
                $_pagetype = 'purchase';
                }
                break;
            default:
                // siteview
                break;

        }
        return $_pagetype;
    }
}
