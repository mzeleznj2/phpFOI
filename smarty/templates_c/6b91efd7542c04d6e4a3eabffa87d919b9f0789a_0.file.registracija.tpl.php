<?php
/* Smarty version 3.1.30, created on 2017-06-17 07:10:30
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/registracija.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5944b9c674f844_84609722',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6b91efd7542c04d6e4a3eabffa87d919b9f0789a' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/registracija.tpl',
      1 => 1497676226,
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
function content_5944b9c674f844_84609722 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
    <?php $_smarty_tpl->_subTemplateRender("file:include_head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <?php echo '<script'; ?>
 src="https://www.google.com/recaptcha/api.js" async defer><?php echo '</script'; ?>
>
</head>
<body>

    <?php $_smarty_tpl->_subTemplateRender("file:include_headerNavigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


    <div id="jsGreske"></div>

    <div id="sadrzaj">

        <form id="registracija" action="registracija.php" method="POST">
            <label>Način prijave: </label>
            <label><input type="radio" name="nacinPrijave" value="1" checked> Jedan korak</label>
            <label><input type="radio" name="nacinPrijave" value="2"> Dva koraka</label>
            <br><br><br>
            <label for ="ime"> Ime: </label>
            <input type="text" id="ime" name="ime" placeholder="Ime" ><br>
            <label for="prezime">Prezime: </label>
            <input type="text" id="prezime" name="prezime" placeholder="Prezime"  ><br>
            <label for="korime">Korisničko ime: </label>
            <input type="text" id="korime" name="korime" placeholder="Korisničko ime"  ><br>
            <label for="email">Email adresa: </label>
            <input  id="email" name="email" placeholder="Email"  ><br>
            <label for="lozinka1">Lozinka: </label>
            <input type="password" id="lozinka1" name="lozinka1" placeholder="Lozinka" ><br>
            <label for="lozinka2">Ponovi pozinku: </label>
            <input type="password" id="lozinka2" name="lozinka2" placeholder="Ponovi lozinku">
            <br><br>
            <div class="g-recaptcha" data-sitekey="6Leb7h4TAAAAALvUW1yxckRyPN6d9_4-4LJudwyc"></div>
            <br>
            <input id="registracijaSubmit" type="submit" value="Registriraj se">
        </form>

    </div>

    <?php $_smarty_tpl->_subTemplateRender("file:include_cookieFooter.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


</body>
</html><?php }
}
