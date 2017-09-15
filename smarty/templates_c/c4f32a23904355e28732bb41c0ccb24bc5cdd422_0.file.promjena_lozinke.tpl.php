<?php
/* Smarty version 3.1.30, created on 2017-06-17 06:49:44
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/promjena_lozinke.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5944b4e8ca45e1_69173251',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c4f32a23904355e28732bb41c0ccb24bc5cdd422' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/promjena_lozinke.tpl',
      1 => 1497674635,
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
function content_5944b4e8ca45e1_69173251 (Smarty_Internal_Template $_smarty_tpl) {
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

        <h4 style="margin-left: 400px;"> Unesite email sa kojim ste registrirani na koji ćemo vam poslati novu lozinku: </h4> <br>

        <form id="promjena_pass" method="post" action="promjena_lozinke.php">
            <label for="email">Email: </label>
            <input id="email" type="text" name="email" placeholder="Email"><br><br>
            <input type="submit" value="Pošalji">
        </form>

    </div>

    <?php $_smarty_tpl->_subTemplateRender("file:include_cookieFooter.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


</body>
</html>


<?php }
}
