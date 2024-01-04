{form_start}
<div class="pageoverflow">
  <p class="pagetext">{$prompt_addtocart_destpage}</p>
  <p class="pagetext">{$input_addtocart_destpage}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_option_template')}&nbsp;{xt_helptag key='option_template'}
  <p class="pagetext">
    <textarea rows="5" cols="80" name="{$actionid}option_template">{$option_template}</textarea>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_watch_qoh')}&nbsp;{xt_helptag key='watch_qoh'}
  <p class="pagetext">
    {xt_yesno_options prefix=$actionid name=watch_qoh selected=$watch_qoh}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}setascart" value="{$mod->Lang('setascart')}"/>
  </p>
</div>
{form_end}

{xt_helphandler}
<div style="display: none;">
  {xt_helpcontent key='option_template' text=$mod->Lang('help_option_template')}
  {xt_helpcontent key='watch_qoh' text=$mod->Lang('help_watch_qoh')}
</div>