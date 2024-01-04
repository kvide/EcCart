<?php

# A
$lang['addedit_addtocart_template'] = 'Add/Edit AddToCart Template';
$lang['addedit_mycartform_template'] = 'Add/Edit MyCart Form Template';
$lang['addedit_viewcartform_template'] = 'Add/Edit Viewcart Form Template';
$lang['addtocart_destpage'] = 'Page to redirect to after add to cart';
$lang['addtocart_templates'] = 'AddToCart Templates';
$lang['add_to_cart'] = 'Add To My Cart';
$lang['amount'] = 'Amount';
$lang['available'] = 'Available';

# C
$lang['cart'] = 'Cart';

# D
$lang['default_addtocart_template'] = 'Prototype AddToCart Template';
$lang['default_mycartform_template'] = 'Prototype MyCart form Template';
$lang['default_viewcartform_template'] = 'Prototype Viewcart form Template';
$lang['default_templates'] = 'Prototype Templates';
$lang['delete'] = 'Delete';
$lang['description'] = 'Description';

# E
$lang['empty_cart'] = 'Remove All Items';
$lang['error_cartpolicy_additem'] = 'Cannot add this item to the cart. See the websites cart policy';
$lang['error_invalidparam'] = 'A supplied parameter has an incorrect value: %s';
$lang['error_missingparam'] = 'A required parameter is missing: %s';
$lang['error_nosuchproduct'] = 'Could not find information on the product: %s';
$lang['error_quantity_notavailable'] = 'We are sorry, but you requested to add %d items to your cart, where only %d are available.';
$lang['error_quantity_notavailable2'] = 'We are sorry, but you requested to add %d items to your cart. There are only %d are available, and there are some already in your cart.';

# F
$lang['free_product'] = 'Free Item';
$lang['friendlyname'] = 'Cart Extension';

# H
$lang['help_option_template'] = <<<EOT
<h3>Option Template:</h3>
<p>This template is used for generating the dropdown list in the add-to-cart form for items <em>(usually products)</em> That contain options.  It generates a simple one line display.</p>
<p>Available variables include:</p>
<table border="1" cellpadding="3" style="margin-top: 0.5em;">
  <thead>
    <tr>
      <th>Name:</th>
      <th>Description:</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>\$currency_symbol</td>
      <td>The currency symbol. <em>(i.e: \$)</em></td>
    </tr>
    <tr>
      <td>\$currency_code</td>
      <td>The currency code. <em>(i.e: USD)</em></td>
    </tr>
    <tr>
      <td>\$product</td>
      <td>An object representing product information. See the \EcommerceExt\productinfo class for the list of available methods.</td>
    </tr>
    <tr>
      <td>\$option</td>
      <td>An object representing the option information. See the \EcommerceExt\productinfo_option class for the list of available methods.</td>
    </tr>
    <tr>
      <td>\$discount</td>
      <td>The value of any discount applied to this option via promotion matching. <em>(May be null or empty.)</em></td>
    </tr>
    <tr>
      <td>\$percent</td>
      <td>The percentage discount applied to this option via promotion matching. <em>(May be null or empty.)</em></td>
    </tr>
  </tbody>
</table>
EOT;
$lang['help_action'] = 'Specifies the behaviour of the module.  Possible values are \'default\',\'mycart\', and \'viewcart\'.<br/><ul><li>default: displays a form with an \'add to cart\' button to allow adding a specific product to the cart.  This mode requires the \'product\' parameter be supplied.</li><li>mycart: Displays a form that displays the number of items in the cart, and a \'checkout\' button.</li><li>viewcart: Displays a detailed form of the contents of the cart, including a current total, and allows deleting items from the cart.</li></ul>';
$lang['help_addtocarttemplate'] = 'Specifies a non default template to use for the \'addtocart\' mode.';
$lang['help_destpage'] = 'Applicable only to the \'default\' (add to cart form) action, this parameter can be used to specify a page alias or id to jump to after the item has been added to the cart';
$lang['help_hideform'] = 'Applicable only to the \'viewcart\' action, this flag indicates wether the viewcart form should be displayed';
$lang['help_mycarttemplate'] = 'Specifies a non default template to use for the  \'mycart\' mode.';
$lang['help_price'] = 'Applicable only to the default action, this parameter allows overriding the base price of a product.';
$lang['help_product'] = 'Applicable only for the default action, this parameter specifies which product (by id) should be added to the cart.  Typically, in the product detail template of the products module, you would add {EcCart sku=$entry->sku} to allow adding items to the cart from product detail pages.';
$lang['help_sku'] = 'Applicable only to the default action, this parameter specifies which product (by SKU) should be added to the cart. This should not be used with the product parameter.';
$lang['help_supplier'] = 'Applicable only to the default action, this parameter specifies which supplier module to query information to.  By default this is &quot;Products&quot;';
$lang['help_viewcartpage'] = 'Specify a destination page for the \'viewcart\' mode.';
$lang['help_viewcarttemplate'] = 'Specifies a non default template to use for the \'viewcart\' mode.';
$lang['help_watch_qoh'] = <<<EOT
<p>If this option is enabled, users will not be allowed to add more items to the cart than is currently avaialble on hand.</p>
<p><strong>Note:</strong> This system is not foolproof.</p>
<ul>
  <li>Available quantity is not adjusted until an order is completed.  Therefore it is possible for negative quantities (backorder situations) to occur for popular items when multiple customers order the same item within the same period.</li>
  <li>Quantity on hand is NOT increased at all times when an order is updated from within the orders module.</li>
</ul>
EOT;
# I
$lang['info_productsummarytemplate'] = 'This template is used to format the output used for each product summary in the view cart form.  It allows customizing the product label based on the attributes, product name, and price.';
$lang['infosubtotal'] = 'This is a subtotal.  Taxes and shipping costs are calculated at time of checkout';

# L
$lang['lbl_productsummarytemplate'] = 'Product Summary Template';

# M
$lang['moddescription'] = 'A Simple Cart Module';
$lang['msg_setascart'] = 'This is now your preferred cart module';
$lang['mycartform_templates'] = 'MyCart Form Templates';
$lang['my_cart'] = 'My Cart';
$lang['my_items'] = 'My Items';

# N
$lang['no'] = 'No';
$lang['none'] = 'None';
$lang['number'] = 'Number';
$lang['number_of_items'] = 'Number of items';

# P
$lang['postinstall'] = 'The Cart module has successfully been installed';
$lang['postuninstall'] = 'The Cart module has been removed';
$lang['preferences'] = 'Preferences';
$lang['price'] = 'Price';
$lang['product_id'] = 'Product ID';
$lang['product_summary'] = 'Product Summary Template';
$lang['prompt_option_template'] = 'Add to Cart Option Template';
$lang['prompt_watch_qoh'] = 'Watch Quantity On Hand';

# Q
$lang['quantity'] = 'Quantity';

# R
$lang['really_uninstall'] = 'Are you sure you want to remove this module?';
$lang['remove'] = 'Remove';

# S
$lang['setascart'] = 'Set as cart Module';
$lang['sku'] = 'SKU';
$lang['submit'] = 'Submit';
$lang['subtotal'] = 'Subtotal';
$lang['summary'] = 'Summary';
$lang['shipping'] = 'Shipping';
$lang['shipping_module'] = 'Shipping Module';

# T
$lang['total'] = 'Total';
$lang['total_weight'] = 'Total Weight';
$lang['tpltype_EcCart'] = 'EcCart';
$lang['tpltype_Add_to_Cart_Form'] = 'Add to Cart Form';
$lang['tpltype_My_Cart_Form'] = 'My Cart Form';
$lang['tpltype_View_Cart_Form'] = 'View Cart Form';

# U
$lang['unit_discount'] = 'Unit discount';
$lang['unit_price'] = 'Unit price';

# V
$lang['viewcartform_templates'] = 'Viewcart form templates';

# W
$lang['warn_default_templates'] = 'This form controls what is displayed initially when you click \'Add New Template\' in the appropriate tab.  Adjusting the contents in this edit area will have no immedicate effect on your website.';
$lang['weight'] = 'Weight';

# X

# Y
$lang['yes'] = 'Yes';
$lang['yousave'] = 'You Save';

# Z
?>
