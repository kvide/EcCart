<h3>How do I use it:</h3>

  <p>This module works in conjunction with the EcProductMgr module, or any other supplier module as listed and selected
   in EcommerceExt module settings, and can read product information from that module.</p>

  <p>There are multiple cart modules, therefore you must select which (of the installed and available) cart modules you
   would like to use in the 'Cart&nbsp;Settings' tab of EcommerceExt.  Then you will also use the
    &#123;EcCart&nbsp;sku='some_sku'} plugin to add an 'add to cart' form where you want it.</p>

  <p>Secondly, a tag like &#123;EcCart&nbsp;action='mycart'} could be be placed on a page or page template to allow
   users to see a brief summary of items in the cart. This is typically used in the header of an e-commerce site.</p>

  <p>Thirdly, a tag like &#123;EcCart&nbsp;action='viewcart'} would be placed on a page or page template to allow users
   to edit and preview the items in their cart.</p>

<h3>Tip / FAQ:</h3>
<ul>
  <li>How do I add a &quot;checkout&quot; button to my cart?
     <p>Since the checkout process is handled by the EcOrderMgr module, and the EcOrderMgr module is usually called
      on a separate page, you just need to create a link to that page within your &quot;View&nbsp;Cart&quot; template.
       i.e.: assuming the alias to your checkout page is &quot;checkout&quot; this should work:</p>

     <pre><code>&lt;a href="{cms_selflink href=checkout}"&gt;Checkout&lt;/a&gt;</code></pre>

  </li>
</ul>
