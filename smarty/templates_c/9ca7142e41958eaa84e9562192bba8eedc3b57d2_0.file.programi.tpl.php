<?php
/* Smarty version 3.1.30, created on 2017-06-19 11:06:00
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/programi.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_594793f87110e5_31917891',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9ca7142e41958eaa84e9562192bba8eedc3b57d2' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/programi.tpl',
      1 => 1497863157,
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
function content_594793f87110e5_31917891 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
    <?php $_smarty_tpl->_subTemplateRender("file:include_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" type="text/css">
    <?php echo '<script'; ?>
 type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
>
        $(document).ready(function(){
            $('#programiTable').DataTable({
                "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
            });
        });
    <?php echo '</script'; ?>
>
</head>
<body>

<?php $_smarty_tpl->_subTemplateRender("file:include_headerNavigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div id="sadrzaj">

    Odaberite vrstu programa:
    <form method="post" action="programi.php">
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
    <br>

    <?php if (isset($_smarty_tpl->tpl_vars['programi']->value) && count($_smarty_tpl->tpl_vars['programi']->value) > 0) {?>
    <table id="programiTable">
        <thead>
            <tr>
                <td>Naziv</td>
                <td>Vrijeme</td>
                <td>Zamjenski termin</td>
                <td>Trajanje</td>
                <td>Max.broj polaznika</td>
                <td>Broj prijavljenih polaznika</td>
                <td>Prijava</td>
            </tr>
        </thead>

        <tbody>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['programi']->value, 'program');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['program']->value) {
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['program']->value[7];?>
</td>
                <td><?php echo date("d.m.Y H:i",$_smarty_tpl->tpl_vars['program']->value[1]);?>
</td>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['program']->value[2] > 0) {?>
                        <?php echo date("d.m.Y H:i",$_smarty_tpl->tpl_vars['program']->value[2]);?>

                    <?php }?>
                </td>
                <td><?php echo $_smarty_tpl->tpl_vars['program']->value[6];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['program']->value[3];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['program']->value[8];?>
</td>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['program']->value[9] == 1) {?>
                        Prijavljen
                    <?php } elseif ($_smarty_tpl->tpl_vars['program']->value[8] < $_smarty_tpl->tpl_vars['program']->value[3]) {?>
                        <form method="post" action="programi_prijava.php">
                            <input type="hidden" name="idProgram" value="<?php echo $_smarty_tpl->tpl_vars['program']->value[0];?>
">
                            <input type="submit" value="Prijavi me">
                        </form>
                    <?php } else { ?>
                        Popunjeno
                    <?php }?>
                </td>
            </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </tbody>
    </table>
    <?php }?>

</div>

<?php $_smarty_tpl->_subTemplateRender("file:include_cookieFooter.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


</body>
</html><?php }
}
