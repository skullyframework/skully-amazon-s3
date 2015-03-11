<?php /* Smarty version Smarty-3.1.18, created on 2015-03-10 15:44:11
         compiled from "D:\apache\skully-amazon-s3\vendor\skullyframework\skully-admin\public\views\admin\widgets\_userInfo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1260554feaedb26dad9-68397636%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b031b17e09e179d55423e0a39fa334d62617f1ed' => 
    array (
      0 => 'D:\\apache\\skully-amazon-s3\\vendor\\skullyframework\\skully-admin\\public\\views\\admin\\widgets\\_userInfo.tpl',
      1 => 1425148615,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1260554feaedb26dad9-68397636',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'adminUsername' => 1,
    'clientConfig' => 1,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54feaedb2aeaa8_75057074',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54feaedb2aeaa8_75057074')) {function content_54feaedb2aeaa8_75057074($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\apache\\skully-amazon-s3\\vendor\\skullyframework\\skully\\Skully\\App\\smarty\\plugins\\function.url.php';
if (!is_callable('smarty_modifier_date_format')) include 'D:\\apache\\skully-amazon-s3\\vendor\\skullyframework\\skully\\Skully\\Library\\Smarty\\libs\\plugins\\modifier.date_format.php';
?>
<div class="widget-fluid userInfo clearfix">
	<div class="name">Welcome, <?php echo $_smarty_tpl->tpl_vars['adminUsername']->value;?>
</div>
	<ul class="menuList">
		
		
		<li><a href="<?php echo smarty_function_url(array('path'=>'admin/admins/logout'),$_smarty_tpl);?>
"><span class="icon-share-alt"></span> Logoff</a></li>
	</ul>
	<div class="text"><b><?php echo smarty_modifier_date_format(time(),$_smarty_tpl->tpl_vars['clientConfig']->value['serverFormDateTimeFormat']);?>
</b>
	</div>
</div>
<?php }} ?>
