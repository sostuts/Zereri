<?php
/* Smarty version 3.1.30-dev/72, created on 2016-07-20 11:05:10
  from "F:\phpstudy\WWW\frame\App\Tpl\error.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/72',
  'unifunc' => 'content_578eea66604ae7_34500180',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e3f7a6f631290c683c5ed2590b54f1f2684076ce' => 
    array (
      0 => 'F:\\phpstudy\\WWW\\frame\\App\\Tpl\\error.html',
      1 => 1468906739,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_578eea66604ae7_34500180 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <meta charset="utf-8">
    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
        }
        body{
            background-color: #f0f1f3;
        }
        .container{
            position: absolute;
            left: 50%;
            top: 50%;
            width: 854px;
            height: 385px;
            margin-left: -427px;
            margin-top: -196px;
            background-color: #fff;
            border-top: 8px solid #93d9b0;
        }
        .title{
            width: 755px;
            height: 137px;
            margin: 0 auto;
            font-size: 40px;
            font-family: "华文隶书";
            line-height: 200px;
            border-bottom: 1px solid #a7a7a7;
        }
        .word{
            width: 755px;
            height: 216px;
            margin: 33px auto 0px auto;
            font-size: 17px;
            color: #989898;
            font-family: "Adobe 黑体 Std";
            line-height: 27px;
            letter-spacing: 2px;
            word-wrap : break-word;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="title">
        Something Wrong！
    </div>
    <div class="word">
        <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

    </div>
</div>
</body>
</html><?php }
}
