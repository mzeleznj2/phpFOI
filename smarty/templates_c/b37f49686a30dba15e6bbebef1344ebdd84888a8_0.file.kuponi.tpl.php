<?php
/* Smarty version 3.1.30, created on 2017-06-18 17:27:35
  from "/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/kuponi.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59469be7825603_41391338',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b37f49686a30dba15e6bbebef1344ebdd84888a8' => 
    array (
      0 => '/var/www/webdip.barka.foi.hr/2016_projekti/WebDiP2016x130/smarty/templates/kuponi.tpl',
      1 => 1497799653,
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
function content_59469be7825603_41391338 (Smarty_Internal_Template $_smarty_tpl) {
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
    <form method="post" action="kuponi.php">
        <label>Program:
        <select name="program">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['programi']->value, 'program');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['program']->value) {
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['program']->value[0];?>
" <?php if (isset($_POST['program']) && $_smarty_tpl->tpl_vars['program']->value[0] == $_POST['program']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['program']->value[1];?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </select>
            <input type="submit" value="Prikaži">
        </label>
    </form>

    <br>
    <?php if (isset($_smarty_tpl->tpl_vars['kuponi']->value) && count($_smarty_tpl->tpl_vars['kuponi']->value) > 0) {?>

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['kuponi']->value, 'kupon');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['kupon']->value) {
?>
            <div style="display: inline-block; margin-right: 10px; text-align: center">
                <?php echo $_smarty_tpl->tpl_vars['kupon']->value[1];?>
 <br>
                <a href="kosarica.php?idKupon=<?php echo $_smarty_tpl->tpl_vars['kupon']->value[0];
if (isset($_POST['program'])) {?>&program=<?php echo $_POST['program'];
}?>">
                    <img title="Ddoaj u košaricu" src="slike/<?php echo $_smarty_tpl->tpl_vars['kupon']->value[2];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['kupon']->value[1];?>
" style="width: 125px;"> <br>
                </a>
                <?php echo $_smarty_tpl->tpl_vars['kupon']->value[3];?>
 bodova
            </div>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


    <?php }?>

</div>

<?php $_smarty_tpl->_subTemplateRender("file:include_cookieFooter.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


</body>
</html><?php }
}
