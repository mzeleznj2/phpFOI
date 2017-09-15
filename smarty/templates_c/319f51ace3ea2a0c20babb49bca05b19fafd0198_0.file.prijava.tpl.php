<?php
/* Smarty version 3.1.30, created on 2017-06-19 10:29:44
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/prijava.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59478b782cacb3_45208499',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '319f51ace3ea2a0c20babb49bca05b19fafd0198' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/prijava.tpl',
      1 => 1497860883,
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
function content_59478b782cacb3_45208499 (Smarty_Internal_Template $_smarty_tpl) {
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

        <form id="prijava" method="post" action="prijava.php">
            <label for="korime">Korisničko ime: </label>
            <input type="text" id="korime" name="korime" placeholder="Korisničko ime" value="<?php if (isset($_smarty_tpl->tpl_vars['korime']->value)) {
echo $_smarty_tpl->tpl_vars['korime']->value;
}?>"><br>
            <label for="lozinka">Lozinka: </label>
            <input type="password" id="lozinka" name="lozinka" placeholder="Lozinka" ><br>
            Zapamti me:
            <label>
                <input id="zapamti" type="radio" name="zapamtiMe" value="1" <?php if (isset($_smarty_tpl->tpl_vars['korime']->value)) {?> checked="checked" <?php }?>>DA
            </label>
            <label>
                <input type="radio" name="zapamtiMe" value="0" <?php if (!isset($_smarty_tpl->tpl_vars['korime']->value)) {?> checked="checked" <?php }?>>NE
            </label>
            <br>
            <input id="submit" type="submit" name="login" value=" Prijavi se "><br>
            <a href="registracija.php"> Registracija </a> <br> <br>
            <a href="promjena_lozinke.php"> Zaboravili ste lozinku? </a> <br> <br>
        </form>

        

    </div>

    <?php $_smarty_tpl->_subTemplateRender("file:include_cookieFooter.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


</body>
</html><?php }
}
