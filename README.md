# EcCart

Webshop cart module for the [EcommerceExt](../../../EcommerceExt) E-commerce extension for
[CMS Mase Simple](https://www.cmsmadesimple.org/).


## Installing

The module requires that the latest version (v1.4.5) of CMSMSExt module (a fork of CGExtensions) and EcommerceExt
modules are installed on the server.

Download and unzip the latest EcCart-x.x.x.xml.zip from [releases](../../releases). Use CMSMS's Module Manager
to upload the unzipped XML file to your server.

The module will only install on servers running CMSMS v2.2.19 on PHP 8.0 or newer. The software may run on older
versions of CMSMS or PHP, but the checks in MinimumCMSVersion() and method.install.php would need to be tweaked.

[!TIP]Update to latest version of CMSMS and PHP to keep your installation secure.


## Using the module

### Compatibility 

The module can co-exist and will not interfere with systems that use Cart2 as cart module in CGEcommerceBase.
