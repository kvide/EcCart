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

use EcommerceExt;

if (! isset($gCms))
{
    exit();
}
if (! $this->VisibleToAdminUser())
{
    exit();
}

// Get RTE in proper state
$mod = \cms_utils::get_module(\MOD_ECOMMERCEEXT);

if (\xt_param::exists($params, 'setascart'))
{
    try
    {
        EcommerceExt\setup_manager::set_shopping_cart_mgr($this->GetName());
        echo $this->ShowMessage($this->Lang('msg_setascart'));
    }
    catch (\Exception $e)
    {
        echo $this->ShowErrors($e->GetMessage());
    }
}
else if (\xt_param::exists($params, 'submit'))
{
    $this->SetPreference('addtocart_destpage', $params['addtocart_destpage']);
    $this->SetPreference('option_template', $params['option_template']);
    $this->SetPreference('watch_qoh', (int) \xt_utils::get_param($params, 'watch_qoh'));
}

$contentops = $gCms->GetContentOperations();
$smarty->assign('option_template', $this->GetPreference('option_template'));
$smarty->assign('prompt_addtocart_destpage', $this->Lang('addtocart_destpage'));
$smarty->assign('input_addtocart_destpage', $contentops->CreateHierarchyDropdown('',
                                                            $this->GetPreference('addtocart_destpage'), $id
                                                                                    . 'addtocart_destpage'));
$smarty->assign('watch_qoh', $this->GetPreference('watch_qoh', 0));

echo $this->ProcessTemplate('admin_preferences_tab.tpl');

// EOF
?>
