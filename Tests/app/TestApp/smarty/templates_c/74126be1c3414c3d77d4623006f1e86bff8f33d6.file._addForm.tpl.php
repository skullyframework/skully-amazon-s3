<?php /* Smarty version Smarty-3.1.18, created on 2015-03-10 15:47:29
         compiled from "D:\apache\skully-amazon-s3\Tests\app\public\default\TestApp\views\admin\cRUDImages\_addForm.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1407554feafa14e9db8-25418544%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '74126be1c3414c3d77d4623006f1e86bff8f33d6' => 
    array (
      0 => 'D:\\apache\\skully-amazon-s3\\Tests\\app\\public\\default\\TestApp\\views\\admin\\cRUDImages\\_addForm.tpl',
      1 => 1405162173,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1407554feafa14e9db8-25418544',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'action' => 1,
    'instanceName' => 1,
    '($_smarty_tpl->tpl_vars[\'instanceName\']->value)' => 1,
    'isAjax' => 1,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54feafa159cd42_34423387',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54feafa159cd42_34423387')) {function content_54feafa159cd42_34423387($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'D:\\apache\\skully-amazon-s3\\vendor\\skullyframework\\skully\\Skully\\App\\smarty\\plugins\\function.url.php';
if (!is_callable('smarty_block_form')) include 'D:\\apache\\skully-amazon-s3\\vendor\\skullyframework\\skully\\Skully\\App\\smarty\\plugins\\block.form.php';
if (!is_callable('smarty_function_lang')) include 'D:\\apache\\skully-amazon-s3\\vendor\\skullyframework\\skully\\Skully\\App\\smarty\\plugins\\function.lang.php';
?>
    <?php if (empty($_smarty_tpl->tpl_vars['action']->value)) {?>
        <?php $_smarty_tpl->tpl_vars['action'] = new Smarty_variable('create', true, 0);?>
    <?php }?>
    <?php ob_start();?><?php echo smarty_function_url(array('path'=>("admin/cRUDImages/").($_smarty_tpl->tpl_vars['action']->value)),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->smarty->_tag_stack[] = array('form', array('class'=>"validate",'method'=>"POST",'action'=>$_tmp1)); $_block_repeat=true; echo smarty_block_form(array('class'=>"validate",'method'=>"POST",'action'=>$_tmp1), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

        <div class="block-fluid">
            <div class="row-form">
                <div class="span12 largerText">
                    <?php if ($_smarty_tpl->tpl_vars['action']->value=='create') {?>
                        <?php echo smarty_function_lang(array('value'=>("Create ").($_smarty_tpl->tpl_vars['instanceName']->value)),$_smarty_tpl);?>

                    <?php } else { ?>
                        <input name="<?php echo $_smarty_tpl->tpl_vars['instanceName']->value;?>
[id]" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars[($_smarty_tpl->tpl_vars['instanceName']->value)]->value['id'];?>
">
                        <?php echo smarty_function_lang(array('value'=>("Edit ").($_smarty_tpl->tpl_vars['instanceName']->value)),$_smarty_tpl);?>

                    <?php }?>
                </div>
            </div>

            <div class="row-form">
                <div class="span12">
                    <p>Instance needs to be created first before image(s) can be added into it.</p>
                    <p>Click on "Save Changes" button below.</p>
                </div>
            </div>

            <?php if (!$_smarty_tpl->tpl_vars['isAjax']->value) {?>
                <div class="toolbar bottom TAR">
                    <div class="btn-group">
                        <button class="btn btn-primary" id="submitForm" type="submit">Save Changes</button>
                    </div>
                </div>
            <?php }?>

        </div>
    <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_form(array('class'=>"validate",'method'=>"POST",'action'=>$_tmp1), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>
