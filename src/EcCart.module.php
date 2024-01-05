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

//
// EXCEPTION
//
namespace EcCart
{
    class cart_Exception extends \xt_exception {}
    class eccart_QOHException extends cart_Exception{}
};

namespace
{

    // Global namespace
    if (! class_exists('\EcommerceExt\EcommModule'))
    {
        $mod = \cms_utils::get_module('EcommerceExt');
        $mod->autoload('EcommModule');
    }

    final class EcCart extends \EcommerceExt\EcommModule
    {

        private $_cart_helper;

        public function GetVersion()
        {
            return '0.98.0';
        }

        public function MinimumCMSVersion()
        {
            return "2.2.19";
        }

        public function GetFriendlyName()
        {
            return $this->Lang('friendlyname');
        }

        public function GetAuthor()
        {
            return 'Christian Kvikant';
        }

        public function GetAuthorEmail()
        {
            return 'kvide@kvikant.fi';
        }

        public function IsPluginModule()
        {
            return true;
        }

        public function HasAdmin()
        {
            return true;
        }

        public function GetAdminSection()
        {
            return 'ecommerce';
        }

        public function GetAdminDescription()
        {
            return $this->Lang('moddescription');
        }

        public function AllowAutoInstall()
        {
            return FALSE;
        }

        public function AllowAutoUpgrade()
        {
            return FALSE;
        }

        public function LazyLoadFrontend()
        {
            return TRUE;
        }

        public function LazyLoadAdmin()
        {
            return TRUE;
        }

        public function InstallPostMessage()
        {
            return $this->Lang('postinstall');
        }

        public function UninstallPostMessage()
        {
            return $this->Lang('postuninstall');
        }

        public function UninstallPreMessage()
        {
            return $this->Lang('really_uninstall');
        }

        public function GetDependencies()
        {
            return array(
                'CMSMSExt' => '1.4.5',
                'EcommerceExt' => '0.98.0'
            );
        }

        public function VisibleToAdminUser()
        {
            return $this->CheckPermission('Modify Site Preferences');
        }

        /*
         * function GetHelp()
         * {
         * return parent::GetHelp();
         * }
         */
        public function InitializeFrontend()
        {
            $this->RegisterModulePlugin();
            /*
             * $this->RestrictUnknownParams();
             * $this->SetParameterType('addtocarttemplate',CLEAN_STRING);
             * $this->SetParameterType('mycarttemplate',CLEAN_STRING);
             * $this->SetParameterType('supplier',CLEAN_STRING);
             * $this->SetParameterType('sku',CLEAN_STRING);
             * $this->SetParameterType('price',CLEAN_STRING);
             * $this->SetParameterType('product',CLEAN_STRING);
             * $this->SetParameterType('viewcarttemplate',CLEAN_STRING);
             * $this->SetParameterType('viewcartpage',CLEAN_STRING);
             * $this->SetParameterType('hideform',CLEAN_INT);
             * $this->SetParameterType('destpage',CLEAN_STRING);
             * $this->SetParameterType(CLEAN_REGEXP.'/cart_.*(part of comment - remove)/',CLEAN_STRING);
             */
        }

        public function Initializeadmin()
        {
            /*
             * $this->CreateParameter('addtocarttemplate','',$this->Lang('help_addtocarttemplate'));
             * $this->CreateParameter('mycarttemplate','',$this->Lang('help_mycarttemplate'));
             * $this->CreateParameter('supplier','Products',$this->Lang('help_supplier'));
             * $this->CreateParameter('sku','Products',$this->Lang('help_sku'));
             * $this->CreateParameter('price','',$this->Lang('help_price'));
             * $this->CreateParameter('product','Products',$this->Lang('help_product'));
             * $this->CreateParameter('viewcarttemplate','',$this->Lang('help_viewcarttemplate'));
             * $this->CreateParameter('viewcartpage','',$this->Lang('help_viewcartpage'));
             * $this->CreateParameter('hideform','0',$this->Lang('help_hideform'));
             * $this->CreateParameter('destpage','',$this->Lang('help_destpage'));
             * $this->CreateParameter('action','default',$this->Lang('help_action'));
             */
        }

        /**
         *
         * @ignore
         */
        public static function tpl_type_lang_cb($str)
        {
            $mod = \cms_utils::get_module(\MOD_ECCART);
            $str = str_replace(' ', '_', $str);
            if (is_object($mod))
            {
                return $mod->Lang('tpltype_' . $str);
            }
        }

        /**
         *
         * @ignore
         */
        public static function tpl_type_reset_cb(CmsLayoutTemplateType $type)
        {
            $mod = \cms_utils::get_module(\MOD_ECCART);
            if ($type->get_originator() != $mod->GetName())
            {
                throw new CmsLogicException('Cannot reset contents for this template type');
            }

            $fn = null;
            switch ($type->get_name())
            {
                case 'Add to Cart Form':
                    $fn = 'orig_addtocart_template.tpl';
                    break;
                case 'View Cart Form':
                    $fn = 'orig_viewcartform_template.tpl';
                    break;
                case 'My Cart Form':
                    $fn = 'orig_mycartform_template.tpl';
                    break;
            }

            if (! $fn)
            {
                return;
            }
            $fn = __DIR__ . '/templates/' . $fn;
            if (file_exists($fn))
            {
                return @file_get_contents($fn);
            }
        }

        /**
         *
         * @ignore
         */
        public function get_cart_manager()
        {
            $mod = \cms_utils::get_module(\MOD_ECOMMERCEEXT);
            if (! $this->_cart_helper)
            {
                $this->_cart_helper = new \EcCart\cart_helper($this);
            }

            return $this->_cart_helper;
        }

    }

    // class
} // global namespace

#
# EOF
#
?>
