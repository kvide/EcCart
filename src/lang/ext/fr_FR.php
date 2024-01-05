<?php
$lang['addedit_addtocart_template'] = 'Ajouter / Éditer le gabarit Ajouter au panier (AddToCart)';
$lang['addedit_mycartform_template'] = 'Ajouter / Éditer le gabarit Mon panier (MyCart)';
$lang['addedit_viewcartform_template'] = 'Ajouter / Éditer le gabarit Voir le panier (ViewCart)';
$lang['addtocart_destpage'] = 'Page où rediriger l\'utilisateur après l\'ajout au panier';
$lang['addtocart_templates'] = 'Gabarits Ajouter au panier (AddToCart)';
$lang['add_to_cart'] = 'Ajouter à mon panier';
$lang['amount'] = 'Montant';
$lang['available'] = 'Disponible';
$lang['cart'] = 'Panier';
$lang['default_addtocart_template'] = 'Gabarit Ajouter au panier par défaut';
$lang['default_mycartform_template'] = 'Gabarit Mon panier par défaut';
$lang['default_viewcartform_template'] = 'Gabarit Voir le panier par défaut';
$lang['default_templates'] = 'Gabarits par défaut';
$lang['delete'] = 'Supprimer';
$lang['description'] = 'Description&nbsp;';
$lang['empty_cart'] = 'Supprimer tous les articles';
$lang['error_cartpolicy_additem'] = 'Impossible d\'ajouter cet article dans le panier. Veuillez consulter les règles du site concernant la gestion du panier';
$lang['error_invalidparam'] = 'Un paramètre fourni a une valeur non correcte&nbsp;: %s';
$lang['error_missingparam'] = 'Un paramètre requis est manquant&nbps;: %s';
$lang['error_nosuchproduct'] = 'Aucune information trouvée sur le produit&nbsp;: %s';
$lang['error_quantity_notavailable'] = 'Nous sommes désolés, mais vous avez demandé d\'ajouter %d articles à votre panier, mais seuls %d sont disponibles.';
$lang['error_quantity_notavailable2'] = 'Nous sommes désolés, mais vous avez demandé d\'ajouter %d articles à votre panier. Seuls %d sont disponibles, et il y en a déjà dans votre panier.';
$lang['free_product'] = 'Article gratuit';
$lang['friendlyname'] = 'Panier2';
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
$lang['help_action'] = 'Spécifie le comportement du module. Les valeurs possibles sont \'default\', \'mycart\' et \'viewcart\'.<br/><ul><li>default : affiche un formulaire avec un bouton d\'ajout au panier permettant d\'ajouter un produit spécifique au panier. Ce mode requiert que le paramètre \'product\' soit présent.</li><li>mycart : affiche un formulaire qui indique le nombre d\'articles dans le panier, et un bouton \'Mon panier\'.</li><li>viewcart : affiche un formulaire détaillé du contenu du panier, incluant le total en cours, et permettant de supprimer des articles du panier.</li></ul>';
$lang['help_addtocarttemplate'] = 'Spécifie un gabarit différent de celui par défaut pour le mode "Ajouter au panier (addtocart)".';
$lang['help_destpage'] = 'Applicable uniquement à l\'action par défaut (formulaire Ajout au panier), ce paramètre peut être utilisé pour spécifier un alias ou ID de page vers laquelle rediriger après l\'ajout d\'un article au panier.';
$lang['help_hideform'] = 'Applicable uniquement à l\'action "viewcart" (voir le panier), cette option indique si le formulaire de viewcart doit être affiché.';
$lang['help_mycarttemplate'] = 'Spécifie un gabarit différent de celui par défaut pour le mode "Mon panier (mycart)".';
$lang['help_price'] = 'Applicable uniquement à l\'action par défaut, ce paramètre permet d\'outrepasser le prix de base d\'un produit.';
$lang['help_product'] = 'Applicable uniquement à l\'action par défaut, ce paramètre spécifie quel produit (par id) doit être ajouté au panier. Typiquement, dans le gabarit de détail du produit du module Produits, il faudra ajouter {EcCart sku=$entry->sku} pour permettre d\'ajouter des articles au panier depuis les pages de détail de produit.';
$lang['help_sku'] = 'Applicable uniquement à l\'action par défaut, ce paramètre spécifie quel produit (par SKU) doit être ajouté au panier. Il ne doit pas être utilisé avec le paramètre product.';
$lang['help_supplier'] = 'Applicable uniquement à l\'action par défaut, ce paramètre spécifie de quel module récupérer les informations. Par défaut il s\'agit du module "Products"';
$lang['help_viewcartpage'] = 'Spécifie une page de destination pour le mode "viewcart".';
$lang['help_viewcarttemplate'] = 'Spécifie un gabarit différent de celui par défaut à utiliser pour le mode "viewcart".';
$lang['help_watch_qoh'] = '<p>Si cette option est activée, les utilisateurs ne pourront pas ajouter plus d\'articles qu\'il n\'y en a en stock.</p>
<p><strong>Note :</strong> Ce système n\'est pas infaillible.</p>
<ul>
  <li>La quantité disponible n\'est pas ajustée tant qu\'une commande n\'est pas terminée. Il est cependant possible qu\'il y ait des quantités négatives (situations de commande en suspens) pour des articles populaires quand de nombreux acheteurs commandent le même article durant la même période.</li>
  <li>La quantité en stock n\'est PAS augmentée toutes les fois qu\'une commande est passée depuis le module Commande (orders).</li>
</ul>';
$lang['info_productsummarytemplate'] = 'Ce gabarit est utilisé pour formater l\'affichage pour chaque résumé de produit dans le formulaire Voir le panier (viewcart). Il permet la personnalisation de la définition du produit basé sur ces attributs, nom de produit et prix.';
$lang['infosubtotal'] = 'Ceci est un sous-total. Les taxes et les frais de transports sont calculés au moment de la finalisation de la commande.';
$lang['lbl_productsummarytemplate'] = 'Gabarit de sommaire de produit';
$lang['moddescription'] = 'Un module de panier simple';
$lang['mycartform_templates'] = 'Gabarits du formulaire Mon panier';
$lang['my_cart'] = 'Mon panier';
$lang['no'] = 'Non';
$lang['none'] = 'Aucun';
$lang['number'] = 'Nombre';
$lang['number_of_items'] = 'Nombre d\'articles';
$lang['postinstall'] = 'Le module Panier a bien été installé';
$lang['postuninstall'] = 'Le module Panier a été désinstallé';
$lang['preferences'] = 'Préférences';
$lang['price'] = 'Prix';
$lang['product_id'] = 'Id produit';
$lang['product_summary'] = 'Gabarit de sommaire de produit';
$lang['prompt_option_template'] = 'Gabarit d\'option d\'ajout au panier';
$lang['prompt_watch_qoh'] = 'Surveiller la quantité en stock';
$lang['quantity'] = 'Quantité';
$lang['really_uninstall'] = 'Êtes-vous sûr de vouloir désinstaller ce module ?';
$lang['remove'] = 'Supprimer';
$lang['sku'] = 'UGS';
$lang['submit'] = 'Envoyer';
$lang['subtotal'] = 'Sous-total';
$lang['summary'] = 'Sommaire';
$lang['shipping'] = 'Livraison';
$lang['shipping_module'] = 'Module de livraison';
$lang['total'] = 'Total&nbsp;';
$lang['total_weight'] = 'Poids total';
$lang['tpltype_EcCart'] = 'EcCart panier';
$lang['tpltype_Add_to_Cart_Form'] = 'Formulaire Ajouter au panier';
$lang['tpltype_My_Cart_Form'] = 'Formulaire Mon panier';
$lang['tpltype_View_Cart_Form'] = 'Formulaire Voir le panier';
$lang['unit_discount'] = 'Remise unitaire';
$lang['unit_price'] = 'Prix unitaire';
$lang['viewcartform_templates'] = 'Gabarits du formulaire ViewCart';
$lang['warn_default_templates'] = 'Ce formulaire contrôle ce qui est affiché au départ quand vous cliquez sur "Ajouter un nouveau gabarit" dans l\'onglet correspondant. La modification du contenu dans cette zone d\'édition n\'aura pas d\'effet immédiat sur votre site.';
$lang['weight'] = 'Poids';
$lang['yes'] = 'Oui';
$lang['yousave'] = 'Vous sauvegardez';
?>