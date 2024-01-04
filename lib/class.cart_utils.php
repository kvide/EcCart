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

use EcommerceExt\ProductMgr;
use EcommerceExt\Promotion;
use EcommerceExt\ecomm;

final class cart_utils
{

    private function __construct()
    {
        // Static class
    }

    public static function get_option_text(ProductMgr\productinfo $product, ProductMgr\productinfo_option $opt,
                                            $percent, $discount, $price)
    {
        $mod = \cms_utils::get_module(\MOD_ECCART);
        $smarty = \CmsApp::get_instance()->GetSmarty();
        $tpl = $mod->GetPreference('option_template');
        if ($tpl == '')
        {
            return;
        }

        $smarty->assign(preg_replace('/Ext$/', '', $mod->GetName()), $mod); // was: $mod->GetName()
                                                                            // $smarty->assign('mod', $mod);
        $smarty->assign('percent', $percent);
        $smarty->assign('discount', $discount);
        $smarty->assign('price', $price);
        $smarty->assign('product', $product);
        $smarty->assign('opt', $opt);
        $smarty->assign('currency_symbol', ecomm::get_currency_symbol());
        $smarty->assign('currency_code', ecomm::get_currency_code());
        $smarty->assign('weight_units', ecomm::get_weight_units());

        return $smarty->fetch('string:' . $tpl);
    }

    public static function adjust_offer($supplier_mod, Promotion\promotion_match $offer)
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
                $discount = (float) $offer->get_val();
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
                    if (strpos($tmp[0], '*') === FALSE && strpos($tmp[0], '[') === FALSE
                        && strpos($tmp[0], '?') == FALSE)
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
                            audit('', $this->GetName(), 'offer says sku ' . $offer->get_val()
                                    . ' is free, but we could not find it');
                        }
                    }
                }
                break;

            default:
            // ignore anything else
        }

        return $newoffer;
    }

    public static function get_template($params, $key, $typename)
    {
        if ($key)
        {
            $tpl = \xt_param::get_string($params, $key);
            if ($tpl)
            {
                return $tpl;
            }
        }

        $tpl = \CmsLayoutTemplate::load_dflt_by_type($typename);
        if ($tpl)
        {
            return $tpl->get_name();
        }

        audit('', 'EcCart', 'No default template of type ' . $typename . ' found');
        return;
    }

} // end of class

?>
