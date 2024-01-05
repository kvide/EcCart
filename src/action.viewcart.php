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

if (! isset($gCms))
{
    exit();
}

use EcommerceExt\Cart;
use EcommerceExt\ecomm;

$destpage = $returnid;
if (isset($params['viewcartpage']))
{
    $tmp = $this->resolve_alias_or_id($params['viewcartpage']);
    if ($tmp)
    {
        $destpage = $tmp;
    }
}

$thetemplate = cart_utils::get_template($params, 'viewcarttemplate', 'EcCart::View Cart Form');
$tpl = $this->CreateSmartyTemplate($thetemplate);

$helper = $this->get_cart_manager();
try
{
    // Expand the cart
    $items = $helper->GetItems();

    // handle emptying the cart
    if (isset($params['cart_empty_cart']))
    {
        $helper->EraseCart();
        $this->RedirectContent($returnid);
    }
    // handle adjusting the cart
    else if (isset($params['cart_adjust']))
    {
        // adjust the quantity
        $idx = 0;
        foreach ($params as $key => $value)
        {
            if (preg_match('/cart_quantity_/', $key))
            {
                $idx = (int) substr($key, 14);
                $items[$idx]->set_quantity($value);
            }
        }

        // remove any zero quantity items
        // or flagged for removal.
        $tmp = array();
        $removed = array();
        for ($i = 0; $i < count($items); $i ++)
        {
            $item = $items[$i];
            if ($item->get_quantity() == 0 || isset($params['cart_remove_' . $i]) || ($item->get_parent() !== null
                && in_array($item->get_parent(), $removed)))
            {
                $removed[] = $i;
                continue;
            }
            $tmp[] = $item;
        }
        $items = $tmp;

        // we have to clear all discounted cart items
        // and free cart items
        // to add new ones.
        $tmp = array();
        foreach ($items as $item)
        {
            if ($item->get_parent() > - 1)
            {
                continue;
            }
            if ($item->get_unit_discount() < 0)
            {
                $item->set_unit_discount(0);
            }
            $item->set_promo(null);
            $tmp[] = $item;
        }
        $items = $tmp;

        // re analyze promotions.
        $tester = ecomm::get_promotions_tester();
        if ($tester)
        {
            $tester->set_promo_type($tester::TYPE_INSTANT);
            $tester->set_cart($items);
            $offers = $tester->find_all_cart_matches();
            if ($offers)
            {
                foreach ($offers as $offer)
                {
                    if ($offer->get_cart_idx() > - 1)
                    {
                        if ($offer->get_cart_idx() >= count($items))
                        {
                            continue;
                        }
                        $item = $items[$offer->get_cart_idx()];
                        if ($item->get_unit_discount() != 0 || $item->get_parent() > - 1)
                        {
                            continue;
                        }
                        $adj = cart_utils::adjust_offer($item->get_source(), $offer);
                        if (is_object($adj))
                        {
                            $discount = null;
                            $free_product = null;
                            if ($adj->free_productid)
                            {
                                $free_product = ecomm::get_product_info($item->get_source(), $adj->free_productid);
                            }
                            else if ($adj->free_productsku)
                            {
                                $free_product = ecomm::get_product_by_sku($item->get_source(), $adj->free_productsku);
                            }
                            else if ($adj->percent)
                            {
                                $adj->discount = $item->get_unit_price() * $obj->percent * - 1;
                            }

                            if ($adj->discount)
                            {
                                // adjust the specified cart item
                                $item->set_unit_discount($adj->discount);
                                $item->set_promo($adj->promo_id);
                            }
                            else if ($free_product)
                            {
                                // add a new cart item.
                                $cart_item = new Cart\cartitem($adj->free_productsku, $free_product->get_product_id(),
                                                        $item->get_quantity(), $item->get_source());
                                $cart_item->set_parent($adj->parent);
                                $cart_item->set_unit_weight($free_product->get_weight());
                                $cart_item->set_promo($adj->promo_id);
                                $unit_price = $free_product->get_price();
                                $sku = $adj->free_productsku;
                                $text = $free_product->get_name();
                                if ($adj->free_productsku != $free_product->get_sku())
                                {
                                    for ($i = 0; $i < $free_product->count_options(); $i ++)
                                    {
                                        $opt = $free_product->get_option_by_idx($i);
                                        if ($opt->sku == $my_offer->free_productsku)
                                        {
                                            $text .= ': ' . $opt->text;
                                            $sku == $my_offer->free_productsku;
                                            $unit_price = $opt->parse_adjustment($free_product->get_price());
                                            break;
                                        }
                                    } // for
                                }
                                $dim = $free_product->get_dimensions();
                                if ($dim)
                                {
                                    $cart_item->set_dimensions($dim[0], $dim[1], $dim[2]);
                                }
                                $cart_item->set_sku($sku);
                                $cart_item->set_summary($text);
                                $cart_item->set_unit_price($unit_price);
                                $cart_item->set_unit_discount($unit_price * - 1);
                                $cart_item->set_allow_remove(FALSE);
                                $cart_item->set_allow_duplicate(FALSE);
                                $cart_item->set_allow_quantity_adjust(FALSE);
                                $items[] = $cart_item;
                            }
                        } // if have adjustment
                    }
                    else
                    {
                        // die, condition not handled...
                        // offer prercent, and offer discount...
                        //
                        die('todo: handle offer with no cart index');
                    }
                } // foreach offer
            } // if offers
        } // if tester

        $helper->SetItems($items);
        $this->RedirectContent($returnid);
    }
}
catch (\Exception $e)
{
    $tpl->assign('error', $e->GetMessage());
}

$tpl->assign('carttotal', $helper->GetTotal());
$tpl->assign('cartweight', $helper->GetTotalWeight());
$cartobjs = array();
$idx = 0;
$items = $helper->GetItems();
foreach ($items as $oneitem)
{
    // convert the cart item to a stdclass object using some trickery.
    $tmp = array(
        'source',
        'product_id',
        'sku',
        'quantity',
        'base_price',
        'type',
        'estimated',
        'pending',
        'unit_weight',
        'unit_price',
        'summary',
        'item_total',
        'subscription',
        'allow_quantity_adjust',
        'allow_remove',
        'unit_discount',
        'parent',
        'net_unit_price'
    );
    $obj = new \stdClass();
    foreach ($tmp as $t2)
    {
        $t3 = 'get_' . $t2;
        if ($t2 == 'estimated')
        {
            $t3 = 'is_' . $t2;
        }
        if ($t2 == 'allow_quantity_adjust')
        {
            $t3 = $t2;
        }
        if ($t2 == 'allow_remove')
        {
            $t3 = $t2;
        }
        $obj->$t2 = $oneitem->$t3();
    }

    if ($oneitem->allow_quantity_adjust())
    {
        // this item allows adjusting the quantity.
        $obj->quantity_box = $this->CreateInputText($id, 'cart_quantity_' . $idx, $obj->quantity, 3, 3);
    }

    if ($oneitem->allow_remove() && $oneitem->get_type() != Cart\cartitem::TYPE_DISCOUNT)
    {
        $obj->remove_box = $this->CreateInputCheckbox($id, 'cart_remove_' . $idx, 1);
    }

    $cartobjs[] = $obj;
    $idx ++;
}

$tpl->assign('cart_data', $items);
$tpl->assign('cartitems', $cartobjs);
$tpl->assign('subtotal_text', $this->Lang('subtotal'));
$tpl->assign('pricetext', $this->Lang('price'));
$tpl->assign('quantitytext', $this->Lang('quantity'));
$tpl->assign('total_text', $this->Lang('total'));
$tpl->assign('total_weight_text', $this->Lang('total_weight'));
$tpl->assign('currencysymbol', ecomm::get_currency_symbol());
$tpl->assign('weightunits', ecomm::get_weight_units());
if (! isset($params['hideform']))
{
    $tpl->assign('formstart', $this->XTCreateFormStart($id, 'viewcart', $destpage));
    $tpl->assign('formend', $this->CreateFormEnd());
    $tpl->assign('submit_name', $id . 'cart_adjust');
    $tpl->assign('submit_text', $this->Lang('submit'));
}

$tpl->display();

// EOF
?>
