<?php
/* Smarty version 3.1.30, created on 2017-06-19 07:21:52
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/kosarica.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59475f702b8a54_22081810',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e79ba9a95cbebd72b0b5602558a361a3de88c702' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/kosarica.tpl',
      1 => 1497849696,
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
function content_59475f702b8a54_22081810 (Smarty_Internal_Template $_smarty_tpl) {
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

    <?php if (!empty($_smarty_tpl->tpl_vars['rezultat']->value)) {?>

        <table>
        <tr>
            <td>Naziv</td>
            <td>Slika</td>
            <td>Aktivan od</td>
            <td>Aktivan do</td>
            <td>Bodovi</td>
            <td>Kupi</td>
        </tr>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rezultat']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value[2];?>
</td>
            <td><img src="slike/<?php echo $_smarty_tpl->tpl_vars['item']->value[3];?>
" style="max-width: 60px;"></td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value[4];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value[5];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value[6];?>
</td>
            <td>
                <form method="post" action="kosarica.php">
                    <input type="hidden" name="idKupon" value="<?php echo $_smarty_tpl->tpl_vars['item']->value[0];?>
">
                    <input type="hidden" name="idProgram" value="<?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
">
                    <input type="submit" value="Kupi">
                </form>
            </td>

        </tr>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            <tr>
                <td style="text-align: right;" colspan="6">
                    <form method="post" action="kosarica.php">
                        <input type="submit" name="isprazni" value="Isprazni košaricu">
                    </form>
                </td>
            </tr>
        </table>

    <?php }?>

</div>

<?php $_smarty_tpl->_subTemplateRender("file:include_cookieFooter.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


</body>
</html><?php }
}
