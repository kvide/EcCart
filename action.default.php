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
// TODO: NOTE: CAUTION AT THIS TIME THIS ACTION ASSUMES THE 'EcProductMgr' MODULE IS BEING USED.

use EcommerceExt\Cart;
use EcommerceExt\Promotion;
use EcommerceExt\ecomm;

//
// FUNCTIONS
//
// TODO: No reset_myoffer found anywhere(?)
if (! function_exists('__eccart_reset_myoffer'))
{

    function &__eccart_reset_myoffer()
    {
        $my_offer = new \stdClass();
        $my_offer->parent = - 1;
        $my_offer->discount = null;
        $my_offer->percent = null;
        $my_offer->promo_id = null;
        $my_offer->free_productid = null;
        $my_offer->free_productsku = null;

        return $my_offer;
    }

    function __eccart_adjust_offer($supplier_mod, Promotion\promotion_match $offer)
    {
        // this function should be in the match object.

        // ideally supplier mod should be in the offer.
        $newoffer = new \stdClass();
        $newoffer->discount = null;
        $newoffer->percent = null;
        $newoffer->free_productid = null;
        $newoffer->free_productsku = null;
        $newoffer->parent = $offer->get_cart_idx();
        $newoffer->promo_id = $offer->get_promo();

        switch ($offer->get_type())
        {
            case $offer::OFFER_DISCOUNT:
                // subtract the discount frome product value... maybe.
                $discount = (float) $offer->get_discount_amt();
                if ($discount > 0)
                {
                    $discount *= - 1;
                }
                $newoffer->discount = $discount;
                break;

            case $offer::OFFER_PERCENT:
                ;
                $percent = (float) $offer->get_val();
                if ($percent < 0)
                {
                    $percent *= - 1;
                }
                if ($percent > 1)
                {
                    $percent /= 100.0;
                }
                $newoffer->percent = $percent;
                break;

            case $offer::OFFER_PRODUCTID:
                $newoffer->free_productid = $offer->get_val();
                break;

            case $offer::OFFER_PRODUCTSKU:
                // test the value to see if it matches a single sku.
                $tmp = explode(',', $offer->get_val());
                if (count($tmp) == 1)
                {
                    // if sku does not contain wildchard chars.
                    $tmp[0] = trim($tmp[0]);
                    if (strpos($tmp[0], '*') === FALSE && strpos($tmp[0], '[') === FALSE && strpos($tmp[0], '?') == FALSE)
                    {
                        // if we can get this product by sku, then it's valid.
                        $tproduct = ecomm::get_product_by_sku($supplier_mod, $tmp[0]);
                        if (is_object($tproduct))
                        {
                            // $my_offer->free_productsku = $offer->get_val(); bad
                            $newoffer->free_productsku = $offer->get_val();
                        }
                        else
                        {
                            audit('', $this->GetName(), 'offer says sku ' . $offer->get_val() . ' is free, but we could not find it');
                        }
                    }
                }
                break;

            default:
            // ignore anything else
        }

        return $newoffer;
    } // function __eccart_adjust_offer
} // functions...

if (! isset($params['sku']))
{
    audit('', $this->GetName(), 'module called without a sku parameter on page ' . $returnid);
    return;
}
$sku = trim($params['sku']);
if ($sku == '')
{
    audit('', $this->GetName(), 'module called with an invalid sku parameter on page ' . $returnid);
    return;
}

$thetemplate = cart_utils::get_template($params, 'addtocarttemplate', 'EcCart::Add to Cart Form');
$tpl = $this->CreateSmartyTemplate($thetemplate);
$helper = $this->get_cart_manager();

// Now see if we can find the product
// Default to EcProductMgr
$supplier_mod = 'EcProductMgr';
if (isset($params['supplier']))
{
    $supplier_mod = trim($params['supplier']);
}
$product = ecomm::get_product_by_sku($supplier_mod, $sku);
if (! $product)
{
    audit('', $this->GetName(), "Could not get product with sku $sku from $supplier_mod, on page $returnid");
    return;
}

$session_obj = new \xt_session($this->GetName() . '_add');

//
// setup
//
$my_offer = __eccart_reset_myoffer();
$offer = null;

// adjust unit price for the case when the product has no options.
$unit_price = $product->get_price();
if (isset($params['price']))
{
    $tmp = (float) $params['price'];
    if ($tmp > 0.001)
    {
        $unit_price = $tmp;
    }
}

// Test the product against promotions (does not handle options).
$tester = ecomm::get_promotions_tester();
if ($tester)
{
    // this will test for matches against the product itself before adding to cart (not necessarily options)
    $tester->set_promo_type($tester::TYPE_INSTANT);
    $tester->set_product($product);
    $tester->set_sku($sku);
    $tester->set_cart($helper->GetItems());

    $offer = $tester->find_match();
    if ($offer)
    {
        $my_offer = __eccart_adjust_offer($supplier_mod, $offer); // we have options, and something matches.
    }
}

if (isset($params['cart_submit']))
{
    try
    {
        $quantity = \xt_utils::get_param($params, 'cart_quantity', 1);
        $avail_quantity = (int) $product->get_qoh();

        if ($quantity > 0)
        {
            // handle adding the base cart item (even if its an option)..
            // also handles instant discounts on the item itself.
            $cart_item = null;

            if (isset($params['cart_options']))
            {
                // there are options for this item.

                list ($chk, $sig) = explode('::', $params['cart_options'], 2);
                if (md5(__FILE__ . session_id() . $sig) != $chk)
                {
                    debug_display($params);
                    die('checksum error');
                }
                $tmp = base64_decode($sig);
                list ($optsku, $qoh, $base_price, $my_offer->discount,
                            $my_offer->parent, $my_offer->promo_id) = explode('::', $tmp);
                $base_price = (float) $base_price;

                // make sure that the option sku is an attribute of the loaded product.
                $opt = $product->get_option_by_sku($optsku);
                if (! $opt)
                {
                    // oops, option specified with a price, but couldn't find the option.
                    throw new \CmsInvalidDataException('Could not find item with an option that has the sku ' . $optsku);
                }
                $avail_quantity = (int) $opt->qoh;

                // check if this sku matches an offer...
                if (! $offer && ! $my_offer->discount && is_object($tester))
                {
                    $tester->set_sku($optsku);
                    $newoffer = $tester->find_match();
                    if ($newoffer)
                    {
                        $my_offer = __eccart_adjust_offer($supplier_mod, $newoffer);
                    }
                }

                if ($my_offer->percent != null && $my_offer->discount == null)
                {
                    $my_offer->discount = round($product->get_price() * $my_offer->percent * - 1, 2);
                }

                $cart_item = new Cart\cartitem($optsku, $product->get_product_id(), $quantity, $supplier_mod);
                $cart_item->set_summary($product->get_name() . ': ' . $opt->text);
                $cart_item->set_unit_weight($product->get_weight());
                if ($product->get_type() == $product::TYPE_SERVICE)
                {
                    $cart_item->set_type($cart_item::TYPE_SERVICE);
                }
                $cart_item->set_digital($product->get_digital());
                $dim = $product->get_dimensions();
                if ($dim)
                {
                    $cart_item->set_dimensions($dim[0], $dim[1], $dim[2]);
                }
                $cart_item->set_unit_price($base_price);
                $cart_item->set_unit_discount($my_offer->discount);
                if ($my_offer->parent > - 1)
                {
                    // item is being added as a child
                    $cart_item->set_quantity(1);
                    $cart_item->set_parent($my_offer->parent);
                    $cart_item->set_allow_remove(FALSE);
                    $cart_item->set_allow_quantity_adjust(FALSE);
                    $cart_item->set_promo($my_offer->promo_id);
                }
            }
            else
            {
                // there are no options for this item.
                $cart_item = new Cart\cartitem($sku, $product->get_product_id(), $quantity, $supplier_mod);
                $cart_item->set_summary($product->get_name());
                $cart_item->set_unit_weight($product->get_weight());
                $cart_item->set_digital($product->get_digital());
                if ($product->get_type() == $product::TYPE_SERVICE)
                {
                    $cart_item->set_type($cart_item::TYPE_SERVICE);
                }
                $dim = $product->get_dimensions();
                if ($dim)
                {
                    $cart_item->set_dimensions($dim[0], $dim[1], $dim[2]);
                }
                $cart_item->set_unit_price($unit_price);

                // check if this sku matches an offer...
                if (! $offer && ! $my_offer->discount && is_object($tester))
                {
                    $tester->set_quantity($quantity);
                    $newoffer = $tester->find_match();
                    if ($newoffer)
                    {
                        $my_offer = __eccart_adjust_offer($supplier_mod, $newoffer);
                    }
                }

                if ($my_offer->parent > - 1)
                {
                    // item is being added as a child, due to some promotion
                    $cart_item->set_quantity(1);
                    $cart_item->set_parent($my_offer->parent);
                    $cart_item->set_allow_remove(FALSE);
                    $cart_item->set_allow_quantity_adjust(FALSE);
                }

                if ($my_offer->promo_id > 0)
                {
                    $cart_item->set_promo($my_offer->promo_id);
                }

                if ($my_offer->percent != null)
                {
                    $my_offer->discount = round($unit_price * $my_offer->percent * - 1, 2);
                }
                $cart_item->set_unit_discount($my_offer->discount);
            }

            if ($this->GetPreference('watch_qoh') && $quantity > $avail_quantity)
            {
                throw new eccart_QOHException($this->Lang('error_quantity_notavailable', $quantity, $avail_quantity));
            }

            // adds this item to the cart.
            $my_offer->parent = $helper->AddCartItem($cart_item);

            // handle adding free items to the cart. due to some promotion
            $free_product = null;
            if ($my_offer->free_productsku)
            {
                $free_product = ecomm::get_product_by_sku($supplier_mod, $my_offer->free_productsku);
                if (! $free_product)
                {
                    audit('', $this->GetName(), "Could not find product with sku {$my_offer->free_productsku} to add (free) to the cart");
                }
            }
            else if ($my_offer->free_productid)
            {
                $free_product = ecomm::get_product_info($supplier_mod, $my_offer->free_productid);
                if (! $free_product)
                {
                    audit('', $this->GetName(), "Could not find product with id {$my_offer->free_productid} to add (free) to the cart");
                }
            }
            if ($free_product)
            {
                // build the slave cart item. ... add only one of these items.
                $free_cart_item = new Cart\cartitem($my_offer->free_productsku, $free_product->get_product_id(), $quantity, $supplier_mod);
                $free_cart_item->set_parent($my_offer->parent);
                $free_cart_item->set_unit_weight($free_product->get_weight());
                $dim = $free_product->get_dimensions();
                if ($dim)
                {
                    $free_cart_item->set_dimensions($dim[0], $dim[1], $dim[2]);
                }
                $free_cart_item->set_promo($my_offer->promo_id);

                // check if freeproductsku is an option's sku
                $text = $free_product->get_name();
                $unit_price = $free_product->get_price();
                $sku = $my_offer->free_productsku;

                $text = $free_product->get_name();
                if ($my_offer->free_productid == $free_product->get_product_id()
                    || $my_offer->free_productsku == $free_product->get_sku())
                {
                    // we're getting a product... either the product itself, or an option
                    $unit_price = $free_product->get_price();
                    $sku = $free_product->get_sku();

                    if ($my_offer->free_productsku)
                    {
                        // getting a free product by sku.
                        $nopt = $free_product->get_option_by_sku($my_offer->free_productsku);
                        $text .= ': ' . $nopt->text;
                    }
                }
                else
                {
                    for ($i = 0; $i < $free_product->count_options(); $i ++)
                    {
                        $opt = $free_product->get_option_by_idx($i);
                        if ($opt->sku == $my_offer->free_productsku)
                        {
                            $text .= ': ' . $opt->text;
                            // FIXME:
                            $sku == $my_offer->free_productsku;
                            $unit_price = $opt->parse_adjustment($free_product->get_price());
                            break;
                        }
                    }
                }

                $free_cart_item->set_sku($sku);
                $free_cart_item->set_summary($text);
                $free_cart_item->set_unit_price($unit_price);
                $free_cart_item->set_unit_discount($unit_price * - 1);
                $free_cart_item->set_allow_remove(FALSE);
                $free_cart_item->set_allow_quantity_adjust(FALSE);

                $helper->AddCartItem($free_cart_item);
            }

            $destid = $this->GetPreference('addtocart_destpage', - 1);
            if ($destid == - 1)
            {
                $destid = $returnid;
            }
            if (isset($params['destpage']))
            {
                $tmp = $this->resolve_alias_or_id($params['destpage']);
                if ($tmp)
                {
                    $destid = $tmp;
                }
            }
            $this->RedirectContent($destid);
        }
    }
    catch (eccart_QOHException $e)
    {
        $session_obj->put($id . 'error', 'qoh');
        $session_obj->put($id . 'errmsg', $e->GetMessage());
        audit('', $this->GetName(), 'Problem adding item to cart: ' . $e->GetMessage());
        if (isset($params['cart_returnto']))
        {
            redirect(html_entity_decode($params['cart_returnto']));
        }
    }
    catch (\Exception $e)
    {
        $session_obj->put($id . 'error', 'addtocart');
        audit('', $this->GetName(), 'Problem adding item to cart: ' . $e->GetMessage());
        if (isset($params['cart_returnto']))
        {
            redirect(html_entity_decode($params['cart_returnto']));
        }
    }
} // cart submit.

//
// build the form
//
if ($session_obj->exists($id . 'error'))
{
    $err = $session_obj->get($id . 'error');
    $msg = $session_obj->get($id . 'errmsg');
    $session_obj->clear($id . 'error');
    $session_obj->clear($id . 'errmsg');
    if (! $msg)
    {
        $msg = $this->Lang('error_cartpolicy_additem');
    }
    if ($err == 'addtocart' || $err == 'qoh')
    {
        $tpl->assign('cart_error', $msg);
    }
}

$parms = array(
    'sku' => $params['sku'],
    'cart_returnto' => \xt_url::current_url()
);
$parms['supplier'] = $supplier_mod;
if (isset($params['destpage']))
{
    $parms['destpage'] = $params['destpage'];
}
if (isset($params['price']))
{
    $parms['price'] = $params['price'];
}
$tpl->assign('formstart', $this->XTCreateFormStart($id, 'default', $returnid, $parms));
$tpl->assign('formend', $this->CreateFormEnd());
$tpl->assign('quantityname', $id . 'cart_quantity');
$tpl->assign('submitname', $id . 'cart_submit');
$tpl->assign('addtocarttext', $this->Lang('add_to_cart'));
$tpl->assign('unitprice', $unit_price);
if ($my_offer->percent != null)
{
    $my_offer->discount = $unit_price * $my_offer->percent * - 1;
}
if ($my_offer->free_productid == $product->get_product_id())
{
    // woot, this product is free.
    $tpl->assign('unitprice', 0);
}
else if ($my_offer->discount < 0)
{
    $tpl->assign('unitprice', $unit_price + $my_offer->discount);
}

// Get the list of options for this product
if ($product->count_options())
{
    // there are options so create a pulldown that can be displayed in the template

    $opt_array = array();
    $options = array();
    $one_option = null;
    for ($opt_idx = 0; $opt_idx < $product->count_options(); $opt_idx ++)
    {
        $opt = $product->get_option_by_idx($opt_idx);
        if ($this->GetPreference('watch_qoh') && $opt->qoh < 1)
        {
            continue;
        }
        $base_price = $opt->parse_adjustment($unit_price);

        if (is_object($tester))
        {
            if (! isset($offer))
            {
                // test all promotions against the sku of this option.
                $tester->set_sku($opt->sku);
                $tester->set_price($base_price);
                $offer = $tester->find_match();
            }

            if (! isset($offer))
            {
                // still no matching offer?
                // test if this 'sku' is the offer part of a promotion
                // and that the cart contents already match.
                $tester->set_sku($opt->sku);
                $offer = $tester->find_offer_match();
            }
        }

        $my_offer = __eccart_reset_myoffer();
        if ($offer)
        {
            $my_offer = __eccart_adjust_offer($supplier_mod, $offer);
            switch ($offer->get_type())
            {
                case $offer::OFFER_PRODUCTSKU:
                    // we are offering this sku free ... when we add it to the cart
                    // so adjust the offer to a type 'discount' with the price being the base price of the option.
                    if (fnmatch($offer->get_val(), $opt->sku))
                    {
                        $offer->set_type($offer::OFFER_DISCOUNT);
                        $offer->set_val($base_price * - 1);
                        $my_offer = __eccart_adjust_offer($supplier_mod, $offer);
                    }
                    break;
                case $offer::OFFER_PRODUCTID:
                    // do nothing.
                    break;
                default:
                    $my_offer = __eccart_adjust_offer($supplier_mod, $offer);
                    break;
            }

            // calculate the discount... if any.
            if ($my_offer->percent != null)
            {
                $my_offer->discount = round($base_price * $my_offer->percent * - 1, 2);
            }
            unset($offer);
        }

        // calculate the final price for this item, and build the list of options to display.
        $price = (float) sprintf('%.2f', $base_price + $my_offer->discount);
        $sig = base64_encode(implode('::', array(
            $opt->sku,
            $opt->qoh,
            $base_price,
            $my_offer->discount,
            $my_offer->parent,
            $my_offer->promo_id
        )));
        $sig = md5(__FILE__ . session_id() . $sig) . '::' . $sig;

        if ($opt->sku == $sku)
        {
            // we're specifying an option sku.
            $one_option = $sig;
            $tpl->assign('unitprice', $price);
        }
        $options[$sig] = cart_utils::get_option_text($product, $opt, $my_offer->percent, $my_offer->discount, $price);
    }

    if ($one_option != null)
    {
        $tpl->assign('single_option', $one_option);
    }
    else if (count($options) > 0)
    {
        $tpl->assign('options', $options);
    }
}

$tpl->display();

// EOF
?>
