<?php
$lang['addedit_addtocart_template'] = '„Zum Warenkorb hinzufügen“-Vorlage hinzufügen/bearbeiten';
$lang['addedit_mycartform_template'] = '„Mein Warenkorb“-Vorlage hinzufügen/bearbeiten';
$lang['addedit_viewcartform_template'] = '„Warenkorb anzeigen“-Vorlage hinzufügen/bearbeiten';
$lang['addtocart_destpage'] = 'Nach dem Hinzufügen zum Warenkorb weiterleiten auf';
$lang['addtocart_templates'] = '„Zum Warenkorb hinzufügen“-Vorlagen';
$lang['add_to_cart'] = 'In den Warenkorb';
$lang['amount'] = 'Betrag';
$lang['default_addtocart_template'] = 'Standardvorlage für „Zum Warenkorb hinzufügen“';
$lang['default_mycartform_template'] = 'Standardvorlage für „Mein Warenkorb“';
$lang['default_viewcartform_template'] = 'Standardvorlage für „Warenkorb anzeigen“';
$lang['default_templates'] = 'Standardvorlagen';
$lang['delete'] = 'Löschen';
$lang['description'] = 'Beschreibung';
$lang['empty_cart'] = 'Alle Artikel entfernen';
$lang['error_cartpolicy_additem'] = 'Dieser Artikel kann nicht hinzugefügt werden. Bitte konsultieren sie die Warenkorbrichtlinien dieser Website.';
$lang['error_invalidparam'] = 'Ein angegebener Parameter hat einen ungültigen Wert: %s';
$lang['error_missingparam'] = 'Ein benötigter Parameter fehlt: %s';
$lang['error_nosuchproduct'] = 'Konnte keine Information zum Produkt %s finden';
$lang['free_product'] = 'Kostenloser Artikel';
$lang['friendlyname'] = 'Warenkorb (EcCart-Modul)';
$lang['help_option_template'] = '<h3>Option Template:</h3>
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
$lang['help_action'] = 'Specifies the behaviour of the module.  Possible values are \'default\',\'mycart\', and \'viewcart\'.<br/><ul><li>default: displays a form with an \'add to cart\' button to allow adding a specific product to the cart.  This mode requires the \'product\' parameter be supplied.</li><li>mycart: Displays a form that displays the number of items in the cart, and a \'checkout\' button.</li><li>viewcart: Displays a detailed form of the contents of the cart, including a current total, and allows deleting items from the cart.</li></ul>';
$lang['help_addtocarttemplate'] = 'Specifies a non default template to use for the \'addtocart\' mode.';
$lang['help_destpage'] = 'Applicable only to the \'default\' (add to cart form) action, this parameter can be used to specify a page alias or id to jump to after the item has been added to the cart';
$lang['help_hideform'] = 'Applicable only to the \'viewcart\' action, this flag indicates wether the viewcart form should be displayed';
$lang['help_mycarttemplate'] = 'Specifies a non default template to use for the  \'mycart\' mode.';
$lang['help_product'] = 'Applicable only for the default action, this parameter specifies which product (by id) should be added to the cart.  Typically, in the product detail template of the products module, you would add {EcCart sku=$entry->sku} to allow adding items to the cart from product detail pages.';
$lang['help_supplier'] = 'Applicable only to the default action, this parameter specifies which supplier module to query information to.  By default this is "Products"';
$lang['help_viewcartpage'] = 'Specify a destination page for the \'viewcart\' mode.';
$lang['help_viewcarttemplate'] = 'Specifies a non default template to use for the \'viewcart\' mode.';
$lang['info_productsummarytemplate'] = 'This template is used to format the output used for each product summary in the view cart form.  It allows customizing the product label based on the attributes, product name, and price.';
$lang['infosubtotal'] = 'Dies ist eine Zwischensumme. Steuern und Versandkosten werden bei der endgültigen Bestellung berechnet.';
$lang['lbl_productsummarytemplate'] = 'Produkt-Zusammenfassungsvorlage';
$lang['moddescription'] = 'Ein einfaches Warenkorb-Modul';
$lang['mycartform_templates'] = 'Warenkorb-Vorlagen';
$lang['my_cart'] = 'Mein Warenkorb';
$lang['no'] = 'Nein';
$lang['none'] = 'Keine Vorgabe';
$lang['number'] = 'Anzahl';
$lang['number_of_items'] = 'Artikel im Warenkorb';
$lang['postinstall'] = 'Das Warenkorb-Modul wurde installiert';
$lang['postuninstall'] = 'Das Warenkorb-Modul wurde entfernt';
$lang['preferences'] = 'Einstellungen';
$lang['price'] = 'Preis';
$lang['product_id'] = 'Produkt-ID';
$lang['product_summary'] = 'Produktbeschreibungsvorlage';
$lang['prompt_option_template'] = 'Produktoptionenvorlage';
$lang['quantity'] = 'Menge';
$lang['really_uninstall'] = 'Wollen Sie wirklich dieses Modul entfernen?';
$lang['remove'] = 'Entfernen';
$lang['sku'] = 'Artikelnummer';
$lang['submit'] = 'Aktualisieren';
$lang['subtotal'] = 'Zwischensumme';
$lang['summary'] = 'Kurzbeschreibung';
$lang['shipping'] = 'Versand';
$lang['shipping_module'] = 'Versand-Modul';
$lang['total'] = 'Gesamt';
$lang['total_weight'] = 'Gesamtgewicht';
$lang['unit_price'] = 'Stückpreis';
$lang['viewcartform_templates'] = 'Warenkorb-Detailvorlagen';
$lang['warn_default_templates'] = 'This form controls what is displayed initially when you click \'Add New Template\' in the appropriate tab.  Adjusting the contents in this edit area will have no immedicate effect on your website.';
$lang['weight'] = 'Gewicht';
$lang['yes'] = 'Ja';
$lang['yousave'] = 'Sie sparen';
?>