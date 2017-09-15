<?php
/* Smarty version 3.1.30, created on 2017-06-19 11:00:34
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/korisnici.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_594792b2dbdb67_01199777',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5d9186fddfdf3af8f6886a46f54b3612c185658a' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/korisnici.tpl',
      1 => 1497862832,
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
function content_594792b2dbdb67_01199777 (Smarty_Internal_Template $_smarty_tpl) {
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
            $('#korisniciTable').DataTable({
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

    <?php if (count($_smarty_tpl->tpl_vars['korisnici']->value) > 0) {?>

        <table id="korisniciTable">
            <thead>
                <tr>
                    <td>Korisničko ime</td>
                    <td>Ime</td>
                    <td>Prezime</td>
                    <td>Email</td>
                    <td>Tip</td>
                    <td>Aktivan</td>
                </tr>
            </thead>
            <tbody>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['korisnici']->value, 'korisnik');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['korisnik']->value) {
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['korisnik']->value[1];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['korisnik']->value[2];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['korisnik']->value[3];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['korisnik']->value[4];?>
</td>
                <td>
                    <form method="post" action="korisnici.php">
                        <input type="hidden" name="idKorisnik" value="<?php echo $_smarty_tpl->tpl_vars['korisnik']->value[0];?>
">
                        <select name="tip">
                            <option value="1" <?php if ($_smarty_tpl->tpl_vars['korisnik']->value[5] == 1) {?>selected<?php }?>>Administrator</option>
                            <option value="2" <?php if ($_smarty_tpl->tpl_vars['korisnik']->value[5] == 2) {?>selected<?php }?>>Moderator</option>
                            <option value="3" <?php if ($_smarty_tpl->tpl_vars['korisnik']->value[5] == 3) {?>selected<?php }?>>Registrirani</option>
                        </select>
                        <input type="submit" value="Izmjeni">
                    </form>

                </td>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['korisnik']->value[6] == 1) {?>
                        DA
                        <form style="float: right;" method="post" action="korisnici.php">
                            <input type="hidden" name="zakljucaj" value="<?php echo $_smarty_tpl->tpl_vars['korisnik']->value[0];?>
">
                            <input type="submit" value="Zaključaj">
                        </form>
                    <?php } else { ?>
                        NE
                        <form style="float: right;" method="post" action="korisnici.php">
                            <input type="hidden" name="otkljucaj" value="<?php echo $_smarty_tpl->tpl_vars['korisnik']->value[0];?>
">
                            <input type="submit" value="Otključaj">
                        </form>
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
