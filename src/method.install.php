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

if (! isset($gCms))
{
    exit();
}
if (version_compare(phpversion(), '8.0') < 0)
{
    return "Minimum PHP version of 8.0 required";
}

// This is the 'Add to Cart Option Template' TODO: move somewhere else
$tpl = <<<EOT
{strip}{\$opt->text}:&nbsp;{\$currency_symbol}{\$price|as_num:2}
{if \$discount ne ''}
  &nbsp;({\$mod->Lang('yousave')} {\$currency_symbol}{\$discount|as_num:2})
{/if}
{if \$opt->qoh > 0}
 -- {\$opt->qoh} {\$mod->Lang('available')}
{/if}{/strip}
EOT;

$this->SetPreference('option_template', $tpl);

{
    $create_template_type = function ($type_name, $mod)
    {
        try
        {
            $tpl_type = new \CmsLayoutTemplateType();
            $tpl_type->set_originator($this->GetName());
            $tpl_type->set_dflt_flag();
            $tpl_type->set_name($type_name);
            $tpl_type->set_lang_callback($this->GetName() . '::tpl_type_lang_cb');
            $tpl_type->set_content_callback($this->GetName() . '::tpl_type_reset_cb');
            $tpl_type->reset_content_to_factory();
            $tpl_type->save();
        }
        catch (\CmsException $e)
        {
            \xt_utils::log_exception($e);
            audit('', $this->GetName(), 'Install error: ' . $e->GetMessage());
        }

        $tpl_type = \CmsLayoutTemplateType::load($this->GetName() . '::' . $type_name);

        return $tpl_type;
    };

    $create_template_of_type = function ($type_ob, $dflt = true)
    {
        $name = 'EcCart sample ' . $type_ob->get_name();
        $ob = new \CmsLayoutTemplate();
        $ob->set_type($type_ob);
        $ob->set_content($type_ob->get_dflt_contents());
        $ob->set_owner(get_userid());
        $ob->set_type_dflt($dflt);
        $new_name = $ob->generate_unique_name($name);
        $ob->set_name($new_name);
        $ob->save();
    }; // function

    $addtocart_type = $create_template_type('Add to Cart Form', $this);
    $create_template_of_type($addtocart_type);
    $viewcart_type = $create_template_type('View Cart Form', $this);
    $create_template_of_type($viewcart_type);
    $mycart_type = $create_template_type('My Cart Form', $this);
    $create_template_of_type($mycart_type);
    $this->DeleteTemplate();
}

$this->RegisterModulePlugin(TRUE);

// EOF
?>
