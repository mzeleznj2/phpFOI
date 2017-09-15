<?php
/* Smarty version 3.1.30, created on 2017-06-19 11:09:18
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/bodovi.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_594794be84df67_32513339',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c96ce2de5a53622c7383d9cb59611a422abc7eb5' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/bodovi.tpl',
      1 => 1497863355,
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
function content_594794be84df67_32513339 (Smarty_Internal_Template $_smarty_tpl) {
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
            $('#bodoviTable').DataTable({
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

    <?php if (isset($_smarty_tpl->tpl_vars['bodovi']->value) && count($_smarty_tpl->tpl_vars['bodovi']->value) > 0) {?>
        <table id="bodoviTable">
            <thead>
                <tr>
                    <td>Akcija</td>
                    <td>Vrijeme</td>
                    <td>Bodovi</td>
                </tr>
            </thead>

            <tbody>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['bodovi']->value, 'bod');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['bod']->value) {
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['bod']->value[2];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['bod']->value[0];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['bod']->value[1];?>
</td>
                    </tr>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </tbody>
            
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">
                        <div>Ukupno: <?php echo $_smarty_tpl->tpl_vars['ukupno']->value['bodovi'];?>
 bodova</div>
                        <div>Potrošeno: <?php echo $_smarty_tpl->tpl_vars['ukupno']->value['potroseno'];?>
 bodova</div>
                        <div>Preostalo: <?php echo $_smarty_tpl->tpl_vars['ukupno']->value['bodovi']-$_smarty_tpl->tpl_vars['ukupno']->value['potroseno'];?>
 bodova</div>
                    </td>
                </tr>
            </tfoot>

        </table>
    <?php }?>

</div>

<?php $_smarty_tpl->_subTemplateRender("file:include_cookieFooter.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


</body>
</html><?php }
}
