{* add to cart template *}
{if isset($cart_error)}
  {xterror}{$cart_error}{/xterror}
{/if}

{$formstart}{strip}
 <input type="text" name="{$quantityname}" value="1" size="2" maxlength="2"/>
 {if isset($single_option)}
   {* this is used if the sku passed to the EcCart module was the sku of an option of a product *}
   <input type="hidden" name="{$actionid}cart_options" value="{$single_option}"/>
   &nbsp;@ {$currency_symbol}{$unitprice|as_num:2}
 {elseif isset($options)}
   {* we have multiple options *}
   <select name="{$actionid}cart_options">
     {html_options options=$options}
   </select>
 {else}
   {* no options *}
   &nbsp;@ {$currency_symbol}{$unitprice|as_num:2}
 {/if}
 <input type="submit" name="{$submitname}" value="{$addtocarttext}"/>
{/strip}{$formend}
