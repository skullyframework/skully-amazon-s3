<?php /* Smarty version Smarty-3.1.18, created on 2014-08-06 14:20:41
         compiled from "/media/jay/Data/apache/skully-admin/public/views/admin/widgets/crud/add/_addAjax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:179667471453e1d749877f80-39482352%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29e2576e913dade7db5b94c175e7aa1831d61c34' => 
    array (
      0 => '/media/jay/Data/apache/skully-admin/public/views/admin/widgets/crud/add/_addAjax.tpl',
      1 => 1402120786,
      2 => 'file',
    ),
    '7dbb3b46ee1e0bda11c3965bf6f66ec5a750b4e9' => 
    array (
      0 => '/media/jay/Data/apache/skully-admin/public/views/admin/wrappers/_formDialog.tpl',
      1 => 1402120786,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '179667471453e1d749877f80-39482352',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_53e1d7498c8054_99067490',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53e1d7498c8054_99067490')) {function content_53e1d7498c8054_99067490($_smarty_tpl) {?>
<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>

<h3>Create new <?php echo $_smarty_tpl->tpl_vars['instanceName']->value;?>
</h3>

</div>
<div class="modal-body">
	<div class="row-fluid">
	<?php echo $_smarty_tpl->getSubTemplate ("admin/widgets/_ajaxAlerts.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	
    
        <?php echo $_smarty_tpl->tpl_vars['form']->value;?>

    

	</div>
</div>
<div class="modal-footer">
	
		<a class="btn btn-primary" onclick="return bootstrapModalSubmit();">Save Changes</a>
		<a class="btn" data-dismiss="modal">Close</a>
	
</div><?php }} ?>
