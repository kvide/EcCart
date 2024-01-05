<?php
$lang['addedit_addtocart_template'] = 'Voeg toe/Wijzig AddToCart Formuliersjabloon';
$lang['addedit_mycartform_template'] = 'Voeg toe/Wijzig MyCart Formuliersjabloon';
$lang['addedit_viewcartform_template'] = 'Voeg toe/Wijzig Viewcart Formuliersjabloon';
$lang['addtocart_destpage'] = 'Te openen pagina na Cart toevoeging';
$lang['addtocart_templates'] = 'AddToCart Sjabloon';
$lang['add_to_cart'] = 'Voeg toe aan My Cart';
$lang['amount'] = 'Bedrag';
$lang['default_addtocart_template'] = 'Standaard AddToCart Sjabloon';
$lang['default_mycartform_template'] = 'Standaard MyCart form Sjabloon';
$lang['default_viewcartform_template'] = 'Standaard Viewcart form Sjabloon';
$lang['default_templates'] = 'Standaard Sjablonen';
$lang['delete'] = 'Verwijder';
$lang['description'] = 'Omschrijving';
$lang['empty_cart'] = 'Verwijder Alle Items';
$lang['error_cartpolicy_additem'] = 'Kan dit artikel niet toevoegen aan de winkelwagen. Bekijk de website voorwaarden';
$lang['error_invalidparam'] = 'Ingegeven parameter heeft een ongeldige waarde: %s';
$lang['error_missingparam'] = 'Een benodigde parameter mist: %s';
$lang['error_nosuchproduct'] = 'Geen informatie gevonden voor product: %s';
$lang['free_product'] = 'Gratis product';
$lang['friendlyname'] = 'Cart 2';
$lang['help_option_template'] = '<h3>Option Template:</h3>
<p>This template is used for generating the dropdown list in the add-to-cart form for items <em>(usually products)</em> That contain options.  It generates a simple one line display.</p>
<p>Available variables include:</p>
<table border=&quot;1&quot; cellpadding=&quot;3&quot; style=&quot;margin-top: 0.5em;&quot;>
  <thead>
    <tr>
      <th>Name:</th>
      <th>Description:</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>$currency_symbol</td>
      <td>The currency symbol. <em>(i.e: $)</em></td>
    </tr>
    <tr>
      <td>$currency_code</td>
      <td>The currency code. <em>(i.e: USD)</em></td>
    </tr>
    <tr>
      <td>$product</td>
      <td>An object representing product information. See the \EcommerceExt\productinfo class for the list of available methods.</td>
    </tr>
    <tr>
      <td>$option</td>
      <td>An object representing the option information. See the \EcommerceExt\productinfo_option class for the list of available methods.</td>
    </tr>
    <tr>
      <td>$discount</td>
      <td>The value of any discount applied to this option via promotion matching. <em>(May be null or empty.)</em></td>
    </tr>
    <tr>
      <td>$percent</td>
      <td>The percentage discount applied to this option via promotion matching. <em>(May be null or empty.)</em></td>
    </tr>
  </tbody>
</table>';
$lang['help_action'] = 'Specifies the behaviour of the module.  Possible values are &#039;default&#039;,&#039;mycart&#039;, and &#039;viewcart&#039;.<br/><ul><li>default: displays a form with an &#039;add to cart&#039; button to allow adding a specific product to the cart.  This mode requires the &#039;product&#039; parameter be supplied.</li><li>mycart: Displays a form that displays the number of items in the cart, and a &#039;checkout&#039; button.</li><li>viewcart: Displays a detailed form of the contents of the cart, including a current total, and allows deleting items from the cart.</li></ul>';
$lang['help_addtocarttemplate'] = 'Geeft een niet-standaard sjabloon voor gebruik bij de &#039;addtocart&#039; modus.';
$lang['help_destpage'] = 'Applicable only to the &#039;default&#039; (add to cart form) action, this parameter can be used to specify a page alias or id to jump to after the item has been added to the cart';
$lang['help_hideform'] = 'Applicable only to the &#039;viewcart&#039; action, this flag indicates wether the viewcart form should be displayed';
$lang['help_mycarttemplate'] = 'Specifies a non default template to use for the  &#039;mycart&#039; mode.';
$lang['help_product'] = 'Applicable only for the default action, this parameter specifies which product (by id) should be added to the cart.  Typically, in the product detail template of the products module, you would add {EcCart sku=$entry->sku} to allow adding items to the cart from product detail pages.';
$lang['help_supplier'] = 'Applicable only to the default action, this parameter specifies which supplier module to query information to.  By default this is &quot;Products&quot;';
$lang['help_viewcartpage'] = 'Specify a destination page for the &#039;viewcart&#039; mode.';
$lang['help_viewcarttemplate'] = 'Specifies a non default template to use for the &#039;viewcart&#039; mode.';
$lang['info_productsummarytemplate'] = 'This template is used to format the output used for each product summary in the view cart form.  It allows customizing the product label based on the attributes, product name, and price.';
$lang['infosubtotal'] = 'Dit is een subtotaal. Belastingen en verzendkosten worden berekend als u gaat afrekenen';
$lang['lbl_productsummarytemplate'] = 'Product Samenvatting Sjabloon';
$lang['moddescription'] = 'Een eenvoudige Cart Module';
$lang['mycartform_templates'] = 'MyCart Formuliersjablonen';
$lang['my_cart'] = 'Mijn Winkelwagen';
$lang['no'] = 'Nee';
$lang['none'] = 'Geen';
$lang['number'] = 'Aantal';
$lang['number_of_items'] = 'Aantal producten';
$lang['postinstall'] = 'De EcCart module is geinstalleerd';
$lang['postuninstall'] = 'De EcCart module is gede&iuml;nstalleerd';
$lang['preferences'] = 'Instellingen';
$lang['price'] = 'Prijs';
$lang['product_id'] = 'Product Id';
$lang['product_summary'] = 'Product Samenvatting Sjabloon';
$lang['prompt_option_template'] = 'Add to Cart Option Template';
$lang['quantity'] = 'Hoeveelheid';
$lang['really_uninstall'] = 'Weet u zeker dat u deze module wilt de&iuml;nstalleren?';
$lang['remove'] = 'Verwijder';
$lang['sku'] = 'SKU ';
$lang['submit'] = 'Versturen';
$lang['subtotal'] = 'Subtotaal';
$lang['summary'] = 'Samenvatting';
$lang['shipping'] = 'Verzending';
$lang['shipping_module'] = 'Verzending Module';
$lang['total'] = 'Totaal';
$lang['total_weight'] = 'Totaal Gewicht';
$lang['unit_price'] = 'Eenheidsprijs';
$lang['viewcartform_templates'] = 'Viewcart Formuliersjablonen';
$lang['warn_default_templates'] = 'This form controls what is displayed initially when you click &#039;Add New Template&#039; in the appropriate tab.  Adjusting the contents in this edit area will have no immedicate effect on your website.';
$lang['weight'] = 'Gewicht';
$lang['yes'] = 'Ja';
$lang['yousave'] = 'U bespaart';
$lang['utma'] = '156861353.678733034.1378369679.1378369679.1378369679.1';
$lang['utmz'] = '156861353.1378369679.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>