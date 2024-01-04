<h3>Parameters</h3>
<ul>

  <li><b><em>(optional)</em> action</b>="default" - Specifies the behaviour of the module.  Possible values are 'default',
      'mycart', and 'viewcart'.</li>
    <p>Actions:</p>
    <ul>
    <li><b>default</b>: displays a form with an 'add to cart' button to allow adding a
      specific product to the cart.  This mode requires the 'product' parameter be supplied.</li>
    <li><b>mycart</b>: Displays a form that displays the number of items in the cart, and a 'checkout' button.</li>
    <li><b>viewcart</b>: Displays a detailed form of the contents of the cart, including a current total, and allows deleting
      items from the cart.</li>
    </ul>
  </li>

<li><b><em>(optional)</em> addtocarttemplate</b>="" - Specifies a non default template to use for the 'addtocart' mode.</li>
<li><b><em>(optional)</em> mycarttemplate</b>="" - Specifies a non default template to use for the  'mycart' mode.</li>
<li><b><em>(optional)</em> supplier</b>="" - Applicable only to the default action, this parameter specifies which
    supplier module to query information to.  By default this is &quot;EcProductMgr&quot;</li>
<li><b><em>(optional)</em> sku</b>="" - Applicable only to the default action, this parameter specifies which product
    (by SKU) should be added to the cart. This should not be used with the product parameter.</li>
<li><b><em>(optional)</em> price</b>="" - Applicable only to the default action, this parameter allows overriding the base
    price of a product.</li>
<li><b><em>(optional)</em> product</b>="" - Applicable only for the default action, this parameter specifies which
    product (by id) should be added to the cart.  Typically, in the product detail template of the products module,
    you would add &#123;EcCart&nbsp;sku=$entry->sku} to allow adding items to the cart from product detail pages.</li>
<li><b><em>(optional)</em> viewcarttemplate</b>="" - Specifies a non default template to use for the 'viewcart' mode.</li>
<li><b><em>(optional)</em> viewcartpage</b>="" - Specify a destination page for the 'viewcart' mode.</li>
<li><b><em>(optional)</em> hideform</b>="0" - Applicable only to the 'viewcart' action, this flag indicates wether the
    viewcart form should be displayed</li>
<li><b><em>(optional)</em> destpage</b>="" - Applicable only to the 'default' (add to cart form) action, this parameter can
    be used to specify a page alias or id to jump to after the item has been added to the cart</li>


</ul>