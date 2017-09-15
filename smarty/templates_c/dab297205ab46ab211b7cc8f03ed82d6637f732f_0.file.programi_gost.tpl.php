<?php
/* Smarty version 3.1.30, created on 2017-06-17 21:37:40
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/programi_gost.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_594585049a5413_71967335',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dab297205ab46ab211b7cc8f03ed82d6637f732f' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/programi_gost.tpl',
      1 => 1497728245,
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
function content_594585049a5413_71967335 (Smarty_Internal_Template $_smarty_tpl) {
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

    Odaberite vrstu programa:
    <form method="post" action="programi_gost.php">
        <select name="idVrsta">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['vrstaPrograma']->value, 'vrstaP');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vrstaP']->value) {
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['vrstaP']->value[0];?>
" <?php if (isset($_POST['idVrsta']) && $_smarty_tpl->tpl_vars['vrstaP']->value[0] == $_POST['idVrsta']) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['vrstaP']->value[1];?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </select>
        <input type="submit" value="Prikaži">
    </form>

    <?php if (isset($_smarty_tpl->tpl_vars['programi']->value) && count($_smarty_tpl->tpl_vars['programi']->value) > 0) {?>
    <table>
        <tr>
            <td>Naziv</td>
            <td>Vrijeme</td>
            <td>Trajanje</td>
            <td>Broj polaznika</td>
        </tr>

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['programi']->value, 'program');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['program']->value) {
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['program']->value[0];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['program']->value[1];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['program']->value[2];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['program']->value[3];?>
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
