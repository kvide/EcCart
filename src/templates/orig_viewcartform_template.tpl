{* viewcartform template *}
<style>
.viewcartform th {
  text-align: left;
}
</style>

<div class="viewcartform">
{* if the smarty variable orders_simpleviewcart is not set, then don't provide a form for adjusting quantities *}
{if !isset($cartitems) || count($cartitems) == 0 }
  <div class="alert alert-warning">Your cart is empty</div>
{else}

  {if isset($formstart) && !isset($orders_simpleviewcart)}{$formstart}{/if}
  <table class="table" width="100%">
    <thead>
      <tr>
        <th>{$EcCart->Lang('sku')}</th>
        <th>{$EcCart->Lang('summary')}</th>
        <th>{$EcCart->Lang('quantity')}</th>
        <th>{$EcCart->Lang('unit_price')}</th>
        <th>{$EcCart->Lang('unit_discount')}</th>
        <th>{$EcCart->Lang('total')}</th>
        <th width="1%">{$EcCart->Lang('remove')}</th>
      </tr>
    </thead>
    <tbody>
    {foreach from=$cartitems item='oneitem'}
      <tr>
        <td>{$oneitem->sku}</td>
        <td>{$oneitem->summary}</td>
        <td>
           {if $oneitem->type != 1 || !isset($oneitem->quantity_box)}
             {$oneitem->quantity}
           {else}
             {$oneitem->quantity_box}
           {/if}
        </td>
        <td>{$currencysymbol}{$oneitem->unit_price|as_num:2}</td>
        <td>{$currencysymbol}{$oneitem->unit_discount|as_num:2}</td>
        <td>{$currencysymbol}{$oneitem->item_total|as_num:2}</td>
        <td>{if isset($oneitem->remove_box)}{$oneitem->remove_box}{/if}</td>
      </tr>
    {/foreach}
    </tbody>
    <tfoot>
      <tr>
        <td colspan="5" align="right">{$EcCart->Lang('total_weight')}:</td>
        <td>{$cartweight|as_num:2}{$weightunits}</td>
        <td></td>
      </tr>
      <tr>
        <td colspan="5" align="right">{$EcCart->Lang('subtotal')}:<br>
            <em>({$EcCart->Lang('infosubtotal')})</em>
        </td>
        <td>{$currencysymbol}{$carttotal|as_num:2}</td>
        <td></td>
      </tr>
      {if isset($formstart) && !isset($orders_simpleviewcart)}
      <tr>
        <td colspan="7">
          <input type="submit" name="{$submit_name}" value="{$submit_text}"/>
          <input type="submit" name="{$actionid}cart_empty_cart" value="{$EcCart->Lang('empty_cart')}"/>
        </td>
      </tr>
      {/if}
    </tfoot>
  </table>
    
  {if isset($formstart) && !isset($orders_simpleviewcart)}
    {$formend}
  {/if}

{/if}
</div>
