<?php /* Smarty version Smarty-3.1.18, created on 2015-03-10 15:44:11
         compiled from "D:\apache\skully-amazon-s3\Tests\app\public\default\TestApp\views\admin\widgets\_mainMenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:475654feaedb22c998-42864195%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e841ac86e32424929d4e8c6881fbbf1a8ea957a4' => 
    array (
      0 => 'D:\\apache\\skully-amazon-s3\\Tests\\app\\public\\default\\TestApp\\views\\admin\\widgets\\_mainMenu.tpl',
      1 => 1407903835,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '475654feaedb22c998-42864195',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54feaedb239000_00461935',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54feaedb239000_00461935')) {function content_54feaedb239000_00461935($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\apache\\skully-amazon-s3\\vendor\\skullyframework\\skully\\Skully\\App\\smarty\\plugins\\function.url.php';
?><ul class="main">
    <li><a href="<?php echo smarty_function_url(array('path'=>'admin/home/index'),$_smarty_tpl);?>
"><span class="icom-screen"></span><span class="text">Main</span></a></li>
    <li><a href="<?php echo smarty_function_url(array('path'=>'admin/admins/index'),$_smarty_tpl);?>
"><span class="icom-user3"></span><span class="text">Admins</span></a></li>
    <li>
        <a href="<?php echo smarty_function_url(array('path'=>'admin/cRUDImages/index'),$_smarty_tpl);?>
"><span class="icom-images"></span><span class="text">Images</span></a>
        <ul class="main">
            <li><a href="<?php echo smarty_function_url(array('path'=>'admin/cRUDImages/index'),$_smarty_tpl);?>
"><span class="icom-images"></span><span class="text">Images (CRUD)</span></a></li>
            <li><a href="<?php echo smarty_function_url(array('path'=>'admin/settingImages/index'),$_smarty_tpl);?>
"><span class="icom-images"></span><span class="text">Images (Settings)</span></a></li>
        </ul>
    </li>
    <li><a href="<?php echo smarty_function_url(array('path'=>'admin/settings/index'),$_smarty_tpl);?>
"><span class="icom-cog"></span><span class="text">Settings</span></a></li>
</ul><?php }} ?>
