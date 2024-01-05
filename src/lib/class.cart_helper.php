<?php

# BEGIN_LICENSE
# -------------------------------------------------------------------------
# Module: EcCart (c) 2023 by CMS Made Simple Foundation
#
# A module to allow maintaining a shopping cart of products
#
# -------------------------------------------------------------------------
# A fork of:
#
# Module: Cart2 (c) 2013-2017 by Robert Campbell
# (calguy1000@cmsmadesimple.org)
#
# -------------------------------------------------------------------------
#
# CMSMS - CMS Made Simple is (c) 2006 - 2023 by CMS Made Simple Foundation
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
#
# -------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple. You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
# -------------------------------------------------------------------------
# END_LICENSE

namespace EcCart;

use EcommerceExt\Cart;
use EcommerceExt\ecomm;

class cart_helper implements \EcommerceExt\Cart\shopping_cart_mgr
{

    private $_mod;
    private $_items;
    private $_calculated;
    private $_subtotal;
    private $_total;
    private $_weight;
    private $_numitems;
    private $_key;

    public function __construct(\EcCart $mod)
    {
        $this->_mod = $mod;
        $this->_key = md5(__FILE__);
        $this->_items = array();
        $this->_calculated = 0;
        $this->_subtotal = 0;
        $this->_total = 0;
        $this->_weight = 0;
        $this->_numitems = 0;
    }

    public function GetName()
    {
        return $this->_mod->GetName();
    }

    public function IsConfigured()
    {
        return TRUE;
    }

    public function SupportsShippingInfo()
    {
        return FALSE;
    }

    /**
     * Erase the entire contents of the cart.
     *
     * @internal
     * @ignore
     */
    public function EraseCart($adddata = '')
    {
        if (isset($_SESSION[$this->_key]))
        {
            Cart\cart::on_cart_adjusted('before', $adddata);
            unset($_SESSION[$this->_key]);
            $this->_items = array();
            $this->_calculated = 0;
            Cart\cart::on_cart_adjusted('after', $adddata);
        }
    }

    /**
     * Calculate and store (temporarily) any cart metadata
     *
     * @internal
     * @ignore
     */
    protected function _calculate_cart_metadata($force = 0)
    {
        $gCms = cmsms();
        $smarty = $gCms->GetSmarty();
        class_exists('\EcommerceExt\ProductMgr\productinfo'); // force the product info stuff to be loaded.

        if ($this->_calculated == 1)
        {
            return;
        }
        if (count($this->_items) == 0 || $force == 1)
        {
            $this->_expand_cart();
        }

        $smarty->assign('currencysymbol', ecomm::get_currency_symbol());
        $smarty->assign('weightunits', ecomm::get_weight_units());

        $this->_weight = 0;
        $this->_subtotal = 0;
        $this->_total = 0;
        $this->_numitems = 0;
        for ($i = 0; $i < count($this->_items); $i ++)
        {
            $obj = &$this->_items[$i];

            // adjust metadata.
            $this->_subtotal += $obj->get_unit_price() * $obj->get_quantity();
            $this->_total += $obj->get_item_total();
            $this->_weight += $obj->get_unit_weight() * $obj->get_quantity();
            $this->_numitems += $obj->get_quantity();
        }

        $this->_calculated = 1;
    }

    /**
     * Return the contents of the named basket.
     * This module does not support more than one basket.
     *
     * @param
     *            string The basket name
     * @param
     *            integer The feu uid
     * @return array of Cart\cartitem objects.
     */
    public function GetBasketItems($name, $feu_uid = - 1)
    {
        return $this->GetItems();
    }

    /**
     * Return shipping information and meta data about a basket
     * This module only supports one basket
     *
     * @param
     *            string The basket name
     * @param
     *            integer The FEU userid
     * @return mixed Hash containing address information, subtotal, total, weight values
     */
    public function GetBasketDetails($name, $feu_uid = - 1)
    {
        $this->_calculate_cart_metadata();
        $result = array();
        $result['cart_name'] = $this->_mod->Lang('cart');
        $result['dest_first_name'] = '-- not entered --'; // what's this for?
        $result['subtotal'] = $this->_subtotal;
        $result['total'] = $this->_total;
        $result['weight'] = $this->_weight;

        return $result;
    }

    /**
     * Return an array of basket names.
     * This module only supports one basket.
     *
     * @param
     *            integer the FEU User id.
     * @return array of strings
     */
    public function GetBasketNames($feu_uid = '')
    {
        // this module does not support naming baskets.
        return [$this->_mod->Lang('my_items')];
    }

    /**
     * Get the number of baskets currently created
     * This module only supports one basket.
     *
     * @return integer
     */
    public function GetNumBaskets()
    {
        return 1;
    }

    /**
     * Return the number of entries in the cart (not including quantities)
     *
     * @return integer
     */
    public function GetNumItems()
    {
        $this->_calculate_cart_metadata();

        return count($this->_items);
    }

    /**
     * Get the subtotal of the cost of all of the items in the cart
     * taking into account quantities, and any price adjustments
     * but not including any taxes or shipping costs.
     *
     * @return float
     */
    public function GetTotal()
    {
        $this->_calculate_cart_metadata();

        return $this->_total;
    }

    /**
     * Get the total weight of the order.
     * Unit of weight is determined by the products module
     *
     * @return float
     */
    public function GetTotalWeight()
    {
        $this->_calculate_cart_metadata();

        return $this->_weight;
    }

    /**
     * Does this module support multiple baskets ?
     *
     * @return bool
     */
    public function SupportsMultipleBaskets()
    {
        return FALSE;
    }

    /**
     * Expand the cart
     *
     * @internal
     * @ignore
     */
    protected function _expand_cart()
    {
        $this->_items = array();
        if (! isset($_SESSION[$this->_key]))
        {
            return;
        }

        $this->_items = unserialize(base64_decode($_SESSION[$this->_key]));
        $this->_calculated = 0;
        $this->_subtotal = 0;
        $this->_total = 0;
        $this->_weight = 0;
        $this->_numitems = 0;
    }

    /**
     * Collapse the cart
     *
     * @internal
     * @ignore
     */
    protected function _collapse_cart($items = array())
    {
        if (count($items) == 0)
        {
            $items = &$this->_items;
        }

        $data = base64_encode(serialize($items));
        $_SESSION[$this->_key] = $data;
    }

    /**
     * Add an item to the named cart
     *
     * Note: This module ignores the basket_name parameter as there is only one basket.
     *
     * @param
     *            Cart\cartitem The cart item to add
     * @param
     *            string Optional basket name (if the basket does not exist it will be created)
     * @return boolean
     */
    public function AddCartItem(Cart\cartitem &$obj, $basket_name = '')
    {
        $this->_expand_cart();

        $msg = '';
        $res = Cart\cart::check_cartitem_valid($this->_items, $obj);
        if (! $res)
        {
            throw new \CmsException('Attempt to add invalid cart item to the cart');
        }

        // set the summary for the item. if it doesn't have one.
        $product = null;
        if ($obj->get_type() == $obj::TYPE_PRODUCT && $obj->get_summary() == '')
        {
            $product = ecomm::get_product_info($obj->get_source(), $obj->get_product_id());
            $obj->set_summary(Cart\cart::calculate_cartitem_summary($product, $obj->get_attributes(), $obj));
        }

        // here we check the policy on adding quantities or adding a new item.
        $added = false;
        $idx = null;
        for ($i = 0; $i < count($this->_items); $i ++)
        {
            $one = &$this->_items[$i];

            if ($one->compare($obj))
            {
                // they are the same item.
                // increase the quantity and play with the unit discount if any.

                // check if we have this many available.
                $quantity = $one->get_quantity() + $obj->get_quantity();
                if ($product && $this->GetPreference('watch_qoh'))
                {
                    $avail_quantity = $product->get_qoh_by_sku($obj->get_sku());
                    if ($quantity > $avail_quantity)
                    {
                        throw new eccart_QOHException($this->_mod->Lang('error_quantity_notavailable2', $obj->get_quantity(), $avail_quantity));
                    }
                }

                $one->set_quantity($one->get_quantity() + $obj->get_quantity());
                $discount = min($one->get_unit_discount(), $obj->get_unit_discount());
                $one->set_unit_discount($discount);
                $idx = $i;
                $added = true;
                break;
            }
        }

        if (! $added)
        {
            Cart\cart::before_add_cartitem($obj);
            $idx = count($this->_items);
            $this->_items[] = $obj;
        }

        $this->_calculated = 0;
        $this->_collapse_cart();

        // note this could be done by having a cart base class
        // or by letting the \EcommerceExt\ecomm stuff handle all the cart stuff
        Cart\cart::on_cart_item_added($obj);

        return $idx;
    }

    /**
     * Get all of the items in the cart
     *
     * @return mixed array of cart items, or null
     */
    public function &GetItems()
    {
        $this->_calculate_cart_metadata();

        return $this->_items;
    }

    /**
     * Set all items into the cart
     *
     * @param
     *            array of Cart\cartitem objects
     */
    public function SetItems($items)
    {
        if (is_array($items))
        {
            Cart\cart::on_cart_adjusted('before');
            $this->_items = $items;
            $this->_calculated = 0;
            $this->_collapse_cart();
            Cart\cart::on_cart_adjusted('after');
        }
    }

    /**
     * Return the HTML form for adding an item to the cart
     *
     * @param
     *            hash of form parameters
     * @return string
     */
    public function get_addtocart_form($params)
    {
        @ob_start();
        $this->DoActionBase('default', 'test', $params);
        $tmp = @ob_get_contents();
        @ob_end_clean();

        return $tmp;
    }

    /**
     * Check if an item with the same source and product id exists in the cart
     *
     * @param
     *            string The supplier module name
     * @param
     *            integer The product id
     * @param
     *            null ignored
     * @return boolean
     */
    public function check_itemid_exists($source, $product, $extra = null)
    {
        if (! $source)
        {
            return FALSE;
        }
        if ($product <= 0)
        {
            return FALSE;
        }

        $this->_expand_cart();
        for ($i = 0; $i < count($this->_items); $i ++)
        {
            $item = &$this->_items[$i];
            if ($item->get_source() == $source && $item->get_product_id() == $product)
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Check if an item with the specified SKU exists in the cart.
     *
     * @param
     *            string The supplier module name
     * @param
     *            string The SKU
     * @param
     *            null ignored
     * @return boolean
     */
    public function check_sku_exists($source, $sku, $extra = null)
    {
        if (! $source)
        {
            return FALSE;
        }
        if (! $sku)
        {
            return FALSE;
        }

        $this->_expand_cart();
        for ($i = 0; $i < count($this->_items); $i ++)
        {
            $item = &$this->_items[$i];
            if ($item->get_source() == $source && $item->get_sku() == $sku)
            {
                return TRUE;
            }
        }

        return FALSE;
    }

} // end of class.

?>
