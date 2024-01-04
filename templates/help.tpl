<link rel="stylesheet" href="{$mod->GetModuleURLPath()}/css/eccart.css" />
<script src="{$mod->GetModuleURLPath()}/js/js.cookie.js"></script>
<script>
jQuery(document).ready(function(){
  var active_tab = Cookies.get('eccart_active');

  if(typeof active_tab === "undefined")
  {
    _set_active_tab('general');
  }
  else
  {
    _set_active_tab(active_tab);
  }

  $('#page_tabs > div')
    .each(function()
    {
      $(this).click(function()
      {
        Cookies.set('eccart_active', this.id);
      });
    });
});


function _set_active_tab(tab_name)
{
  $('#page_tabs > div')
    .each(function()
    {
      $(this).removeClass('active');
    });

  $('#page_content > div')
    .each(function()
    {
      $(this).hide();
    });

  $('#' + tab_name).addClass('active');
  $('#' + tab_name + '_c').show();
  Cookies.set('eccart_active', tab_name);

}
</script>

<div class="clear"></div>

<div id="page_tabs">

  <div  id="general">
    General
  </div>
  <div id="using">
    How Do I Use It
  </div>
  <div id="parameters">
    Parameters
  </div>
<!--  <div id="smarty">
    Smarty Plugins
  </div>
  <div id="hooks">
    Hooks
  </div> -->
  <div id="about">
    About
  </div>

</div>

<div class="clearb"></div>
<div id="page_content">

  <div id="general_c">
    {include file='module_file_tpl:EcCart;help_general_tab.tpl'}
  </div>
  <div id="using_c">
    {include file='module_file_tpl:EcCart;help_using_tab.tpl'}
  </div>
  <div id="parameters_c">
    {include file='module_file_tpl:EcCart;help_parameters_tab.tpl'}
  </div>
  <div id="smarty_c">
    {* include file='module_file_tpl:EcCart;help_smarty_tab.tpl' *}
  </div>
  <div id="hooks_c">
    {* include file='module_file_tpl:EcCart;help_hooks_tab.tpl' *}
  </div>
  <div id="about_c">
    {include file='module_file_tpl:EcCart;help_about_tab.tpl'}
  </div>

  <div class="clearb"></div>
</div>
