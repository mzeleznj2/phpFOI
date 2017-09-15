<?php
/* Smarty version 3.1.30, created on 2017-06-19 10:28:35
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/include_headerNavigation.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59478b33e49c19_62693517',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e18f2b8f5b53e5ca01d528ac29181f9abb792dc3' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/include_headerNavigation.tpl',
      1 => 1497860881,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59478b33e49c19_62693517 (Smarty_Internal_Template $_smarty_tpl) {
?>
<header class="no-print">
    <figure>
        <figcaption id="naslov"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</figcaption>
        <img id="naslovna" src="slike/logo.png" width="300" height="100" usemap="#mapa1" alt="logo">
    </figure>
</header>

        <nav id="meni" class="no-print">
    <ul>
        <?php echo $_smarty_tpl->tpl_vars['meni']->value;?>

    </ul>
</nav>

<?php if (!empty($_smarty_tpl->tpl_vars['greske']->value)) {?>
    <div id="greske">
        <ul>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['greske']->value, 'greska');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['greska']->value) {
?>
                <li><?php echo $_smarty_tpl->tpl_vars['greska']->value;?>
</li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </ul>
    </div>
<?php }?>

<?php if (!empty($_smarty_tpl->tpl_vars['uspjehi']->value)) {?>
    <div id="uspjehi">
        <ul>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['uspjehi']->value, 'uspjeh');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['uspjeh']->value) {
?>
                <li><?php echo $_smarty_tpl->tpl_vars['uspjeh']->value;?>
</li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </ul>
    </div>
<?php }
}
}
