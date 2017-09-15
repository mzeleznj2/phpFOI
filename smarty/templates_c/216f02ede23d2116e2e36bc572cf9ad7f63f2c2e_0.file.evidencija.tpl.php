<?php
/* Smarty version 3.1.30, created on 2017-06-19 11:06:06
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/evidencija.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_594793feb5ab85_12789229',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '216f02ede23d2116e2e36bc572cf9ad7f63f2c2e' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/evidencija.tpl',
      1 => 1497860876,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:include_head.tpl' => 1,
    'file:include_headerNavigation.tpl' => 1,
    'file:include_cookieFooter.tpl' => 1,
  ),
),false)) {
function content_594793feb5ab85_12789229 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
    <?php $_smarty_tpl->_subTemplateRender("file:include_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</head>
<body>

<?php $_smarty_tpl->_subTemplateRender("file:include_headerNavigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div id="sadrzaj">

    <?php if (isset($_smarty_tpl->tpl_vars['evidencija']->value) && count($_smarty_tpl->tpl_vars['evidencija']->value) > 0) {?>
        <table>
            <tr>
                <td>Program</td>
                <td>Opis</td>
            </tr>

            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['evidencija']->value, 'e');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['e']->value) {
?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['e']->value[1];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['e']->value[0];?>
</td>
                </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


        </table>
    <?php }?>

</div>

<?php $_smarty_tpl->_subTemplateRender("file:include_cookieFooter.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


</body>
</html><?php }
}
