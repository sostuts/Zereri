<?php
/* Smarty version 3.1.30-dev/72, created on 2016-07-19 01:29:08
  from "F:\phpstudy\WWW\frame\App\Tpl\api.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/72',
  'unifunc' => 'content_578d11e4c824a9_02690935',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c9a587149353afc1a1f9dcec1a9ccae4e321ea5c' => 
    array (
      0 => 'F:\\phpstudy\\WWW\\frame\\App\\Tpl\\api.html',
      1 => 1468862942,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_578d11e4c824a9_02690935 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style type="text/css">
		*{
			margin: 0px;
			padding: 0px;
		}
		a{
			text-decoration: none;
		}
		body{
			background-color: #f0f1f3;
		}
		.container{
			width: 895px;
			margin: 37px auto 49px auto;
			background-color: #fff;
			overflow: hidden;
		}
		body:last-child{
			margin-bottom: 100px!important;
		}
		.title{
			width: 862px;
			height: 48px;
			margin: 29px auto 0px auto;
			text-align: center;
			font-size: 36px;
			font-family: "华文新魏";
		}
		.up-tri{
			width: 0;
			height: 0;
			margin: 0 auto;
			border-bottom: 10px solid #93d9b0;
			border-right: 8px solid transparent;
			border-left: 8px solid transparent;
		}
		.border{
			width: 862px;
			height: 3px;
			margin: 0 auto 29px auto;
			background-color: #93d9b0;
		}
		.add-way{
			width: auto;
			height: 92px;
			margin-left: 75px;
			position: relative;
		}
		.down-tri{
			width: 0;
			height: 0;
			margin-right: 12px;
			border-top: 24px solid #93d9b0;
			border-right: 12px solid transparent;
			border-left: 12px solid transparent;
			float: left;
		}
		.add{
			font-size: 25px;
			font-family: "华文新魏";
			float: left;
			position: relative;
			max-width: 400px;
		}
		.short-add{
			color: #b7b7b7;
			max-width: 258px;
			word-wrap : break-word;
		}
		.small-title{
			margin-bottom: 25px;
			text-align: center;
			font-family: "华文新魏";
			font-size: 26px;
		}
		.list-container{
			width: 736px;
			margin: 0 auto 40px auto;
			font-size: 14px;
		}
		ul li{
			width: 100%;
			height: auto;
			list-style: none;
			line-height: 33px;
			padding-left: 4px;
		}
		ul li ul li{
			float: left;
			width: 139px;
			font-family: "微软雅黑";
		}
		ul li ul li:first-child{
			width: 177px;
		}
		ul li ul li:last-child{
			width: 265px;
		}
		ul li:first-child ul{
			width: 100%;
			min-height: 33px;
			background-color: #def0e0!important;
			font-size: 17px!important;
			font-family: "微软雅黑";
			font-weight: bold;
		}
		ul li:nth-child(odd) ul{
			width: 100%;
			background-color: #e9f3ea;
		}
		ul li ul{
			min-height: 33px;
			word-wrap : break-word;
			height: auto;
		}
		.format{
			font-size: 20px;
			font-family: "华文新魏";
			margin-bottom: 13px;
		}
		.explain li ul li:first-child{
			width: 315px;
		}
		.explain li ul li:last-child{
			width: 413px;
		}
		.complete-add{
			width: 322px;
			max-width: 322px;
			background-color: #fff;
			font-size: 25px;
			font-family: "华文新魏";
			color: #b7b7b7;
			position: absolute;
			top: 0px;
			word-wrap : break-word;
			display: none;
			cursor: pointer;
		}
		.catalog{
			width: 736px;
			height: 60px;
			line-height: 77px;
			margin-left: 63px;
			font-size: 36px;
			font-family: "华文新魏";
			border-bottom: 1px solid #93d9b0;
		}
		.cat-list{
			list-style: none;
			margin: 31px 0px 0px 63px;
			width: 736px;
			height: 18px;
			font-size: 20px;
			font-family: "华文新魏";
			color: #606060;
			position: relative;
		}
		.cat-ADD{
			font-size: 20px;
			color: #b7b7b7;
			float: right;
			cursor: pointer;
		}
		.cat-list:last-child{
			padding-bottom: 35px;
		}
		.cat-circle{
			width: 13px;
			height: 13px;
			margin: 2px 18px 0px 9px;
			border-radius: 50%;
			background-color: #93d9b0;
			float: left;
		}
		.cat-comAdd{
			max-width: 557px;
			background-color: #fff;
			font-size: 20px;
			font-family: "华文新魏";
			color: #b7b7b7;
			position: absolute;
			z-index: 2;
			top: 0px;
			right: 0px;
			word-wrap : break-word;
			cursor: pointer;
			display: none;
		}
		.cat-comAdd a{
			color: #b7b7b7;
		}
	</style>
	<title>API || Document</title>
</head>
<body>
	<div class="container" style="overflow:visible">
		<div class="catalog">目录</div>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'controller');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['controller']->value) {
?>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['controller']->value, 'method');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['method']->value) {
?>
				<div class="cat-list">
					<div class="cat-circle"></div>
						<?php echo $_smarty_tpl->tpl_vars['method']->value['title'];?>

					<span class="cat-ADD"><?php echo $_smarty_tpl->tpl_vars['method']->value['url_short'];?>
</span>
					<div class="cat-comAdd"><a href="#<?php echo $_smarty_tpl->tpl_vars['method']->value['url_short'];?>
"><?php echo $_smarty_tpl->tpl_vars['method']->value['url'];?>
</a></div>
				</div>		
			
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	</div>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'controller');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['controller']->value) {
?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['controller']->value, 'method');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['method']->value) {
?>
			<a id="<?php echo $_smarty_tpl->tpl_vars['method']->value['url_short'];?>
"></a>
			<div class="container">
				<p class="title"><?php echo $_smarty_tpl->tpl_vars['method']->value['title'];?>
</p>
				<div class="up-tri"></div>
				<div class="border"></div>
				<div class="add-way">
					<div class="down-tri"></div>
					<div class="add" style="width:456px">
						接口地址：
						<a href="###">
						<span class="short-add"><?php echo $_smarty_tpl->tpl_vars['method']->value['url_short'];?>
</span>
						</a>
						<div class="complete-add" style="min-width: 396px">
							<?php echo $_smarty_tpl->tpl_vars['method']->value['url'];?>

						</div>
					</div>
					<div class="down-tri"></div>
					<div class="add">
						请求方式：
						<a href="###">
						<span class="short-add"><?php echo $_smarty_tpl->tpl_vars['method']->value['api_method'];?>
</span>
						</a>	
						<div class="complete-add">
							<?php echo $_smarty_tpl->tpl_vars['method']->value['api_method'];?>

						</div>
					</div>
				</div>
				<?php if ($_smarty_tpl->tpl_vars['method']->value['params'] != null) {?>
				<p class="small-title">接口参数</p>
				<div class="list-container">
					<ul>
						<li>
							<ul>
								<li>名称</li>
								<li>类型</li>
								<li>必须</li>
								<li>说明</li>
							</ul>
						</li>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['method']->value['params'], 'param');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['param']->value) {
?>
						<li>
							<ul>
								<li><?php echo $_smarty_tpl->tpl_vars['param']->value['name'];?>
</li>
								<li><?php echo $_smarty_tpl->tpl_vars['param']->value['type'];?>
</li>
								<li><?php echo $_smarty_tpl->tpl_vars['param']->value['need'];?>
</li>
								<li><?php echo $_smarty_tpl->tpl_vars['param']->value['desc'];?>
</li>
								<div style="clear:both"></div>
							</ul>
						</li>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					</ul>
				</div>
				<?php }?>
				<p class="small-title">返回说明</p>
				<div class="list-container">
					<p class="format">格式：   <?php echo $_smarty_tpl->tpl_vars['method']->value['return']['format'];?>
</p>
					<ul class="explain">
						<li>
							<ul>
								<li>名称</li>
								<li>说明</li>
							</ul>
						</li>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['method']->value['return']['content'], 'return');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['return']->value) {
?>
						<li>
							<ul>
								<li><?php echo $_smarty_tpl->tpl_vars['return']->value['name'];?>
</li>
								<li><?php echo $_smarty_tpl->tpl_vars['return']->value['desc'];?>
</li>
								<div style="clear:both"></div>
							</ul>
						</li>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					</ul>
				</div>
			</div>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</body>
<?php echo '<script'; ?>
 type="text/javascript">
	var shortADD = document.getElementsByClassName('short-add');
	var completeADD = document.getElementsByClassName('complete-add');
	for(var i=0;i<shortADD.length;i++){
		shortADD[i].index=i;
		shortADD[i].onmouseover=function(){
			completeADD[this.index].style.display='block';
		};
	};
	for(var i=0;i<completeADD.length;i++){
		completeADD[i].index=i;
		completeADD[i].onmouseover=function(){
			completeADD[this.index].style.display='block';
		};
		completeADD[i].onmouseleave=function(){
			completeADD[this.index].style.display='none';
		}
	};
	var catAdd = document.getElementsByClassName(
		'cat-ADD');
	var catComAdd = document.getElementsByClassName('cat-comAdd')
	for(var i=0;i<catAdd.length;i++){
		catAdd[i].index=i;
		catAdd[i].onmouseover=function(){
			catComAdd[this.index].style.display='block';
		}
	};
	for(var i=0;i<catComAdd.length;i++){
		catComAdd[i].index=i;
		catComAdd[i].onmouseover=function(){
			catComAdd[this.index].style.display='block';
		};
		catComAdd[i].onmouseleave=function(){
			catComAdd[this.index].style.display='none';
		}
	}
<?php echo '</script'; ?>
>
</html><?php }
}
