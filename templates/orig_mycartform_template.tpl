{* mycart form template *}
{$numitemstext}:&nbsp;{$cart_itemcount}<br/>
{$EcCart->Lang('subtotal')}:&nbsp;{$currency_symbol}{$cart_totalprice|as_num:2}&nbsp;<br/>
*{$EcCart->Lang('infosubtotal')}
{if isset($submitname)}
  {$formstart}
  <input type="submit" name="{$submitname}" value="{$checkouttext}"/>
  {$formend}
{/if}
