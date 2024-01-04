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

use EcommerceExt\ecomm;

if (! isset($gCms))
{
    exit();
}

$viewcartpage = '';
if (isset($params['viewcartpage']))
{
    $manager = &$gCms->GetHierarchyManager();
    $node = &$manager->sureGetNodeByAlias($params['viewcartpage']);
    if (isset($node))
    {
        $content = $node->GetContent();
        if (isset($content))
        {
            $viewcartpage = $content->Id();
        }
    }
    else
    {
        $node = $manager->sureGetNodeById($params['viewcartpage']);
        if (isset($node))
        {
            $viewcartpage = $params['viewcartpage'];
        }
    }
}
if ($viewcartpage != '')
{
    $returnid = $viewcartpage;
}

$thetemplate = cart_utils::get_template($params, 'mycarttemplate', 'EcCart::My Cart Form');
$tpl = $this->CreateSmartyTemplate($thetemplate);

// Expand the cart
$itemcount = 0;
$carttotal = 0;
$helper = $this->get_cart_manager();
$items = $helper->GetItems();
for ($i = 0; $i < count($items); $i ++)
{
    $obj = &$items[$i];
    $itemcount += $obj->get_quantity();
}

$carttotal = $this->GetTotal();
$totalweight = $this->GetTotalWeight();
if (isset($params['cart_submit']) && $itemcount > 0)
{
    $this->Redirect($id, 'viewcart', $returnid, $params);
}

$tpl->assign('pricetext', $this->Lang('price'));
$tpl->assign('cart_itemcount', $itemcount);
$tpl->assign('cart_totalweight', $totalweight);
$tpl->assign('cart_totalprice', $carttotal);
$tpl->assign('carttotal', $carttotal);
$tpl->assign('numitemstext', $this->Lang('number_of_items'));
$tpl->assign('currency_symbol', ecomm::get_currency_symbol());
$tpl->assign('weight_units', ecomm::get_weight_units());
if ($itemcount > 0)
{
    $tpl->assign('formstart', $this->XTCreateFormStart($id, 'mycart', $returnid, $params));
    $tpl->assign('formend', $this->CreateFormEnd());
    $tpl->assign('submitname', $id . 'cart_submit');
    $tpl->assign('checkouttext', $this->Lang('my_cart'));
}

$tpl->display();

// EOF
?>
