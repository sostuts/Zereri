<?php
/* Smarty version 3.1.30-dev/72, created on 2016-09-08 21:10:29
  from "F:\phpstudy\WWW\wangyuan\App\Tpl\api.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/72',
  'unifunc' => 'content_57d163459f5f64_06316879',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a28cafaa18a0f2003ef0ff40021b978da895114f' => 
    array (
      0 => 'F:\\phpstudy\\WWW\\wangyuan\\App\\Tpl\\api.html',
      1 => 1473340210,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d163459f5f64_06316879 (Smarty_Internal_Template $_smarty_tpl) {
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
	<?php echo '<script'; ?>
 type="text/javascript">
		!function(t){if("object"==typeof exports&&"undefined"!=typeof module)module.exports=t();else if("function"==typeof define&&define.amd)define([],t);else{var e;e="undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self?self:this,e.Clipboard=t()}}(function(){var t,e,n;return function t(e,n,o){function i(a,c){if(!n[a]){if(!e[a]){var s="function"==typeof require&&require;if(!c&&s)return s(a,!0);if(r)return r(a,!0);var l=new Error("Cannot find module '"+a+"'");throw l.code="MODULE_NOT_FOUND",l}var u=n[a]={exports:{}};e[a][0].call(u.exports,function(t){var n=e[a][1][t];return i(n?n:t)},u,u.exports,t,e,n,o)}return n[a].exports}for(var r="function"==typeof require&&require,a=0;a<o.length;a++)i(o[a]);return i}({1:[function(t,e,n){var o=t("matches-selector");e.exports=function(t,e,n){for(var i=n?t:t.parentNode;i&&i!==document;){if(o(i,e))return i;i=i.parentNode}}},{"matches-selector":5}],2:[function(t,e,n){function o(t,e,n,o,r){var a=i.apply(this,arguments);return t.addEventListener(n,a,r),{destroy:function(){t.removeEventListener(n,a,r)}}}function i(t,e,n,o){return function(n){n.delegateTarget=r(n.target,e,!0),n.delegateTarget&&o.call(t,n)}}var r=t("closest");e.exports=o},{closest:1}],3:[function(t,e,n){n.node=function(t){return void 0!==t&&t instanceof HTMLElement&&1===t.nodeType},n.nodeList=function(t){var e=Object.prototype.toString.call(t);return void 0!==t&&("[object NodeList]"===e||"[object HTMLCollection]"===e)&&"length"in t&&(0===t.length||n.node(t[0]))},n.string=function(t){return"string"==typeof t||t instanceof String},n.fn=function(t){var e=Object.prototype.toString.call(t);return"[object Function]"===e}},{}],4:[function(t,e,n){function o(t,e,n){if(!t&&!e&&!n)throw new Error("Missing required arguments");if(!c.string(e))throw new TypeError("Second argument must be a String");if(!c.fn(n))throw new TypeError("Third argument must be a Function");if(c.node(t))return i(t,e,n);if(c.nodeList(t))return r(t,e,n);if(c.string(t))return a(t,e,n);throw new TypeError("First argument must be a String, HTMLElement, HTMLCollection, or NodeList")}function i(t,e,n){return t.addEventListener(e,n),{destroy:function(){t.removeEventListener(e,n)}}}function r(t,e,n){return Array.prototype.forEach.call(t,function(t){t.addEventListener(e,n)}),{destroy:function(){Array.prototype.forEach.call(t,function(t){t.removeEventListener(e,n)})}}}function a(t,e,n){return s(document.body,t,e,n)}var c=t("./is"),s=t("delegate");e.exports=o},{"./is":3,delegate:2}],5:[function(t,e,n){function o(t,e){if(r)return r.call(t,e);for(var n=t.parentNode.querySelectorAll(e),o=0;o<n.length;++o)if(n[o]==t)return!0;return!1}var i=Element.prototype,r=i.matchesSelector||i.webkitMatchesSelector||i.mozMatchesSelector||i.msMatchesSelector||i.oMatchesSelector;e.exports=o},{}],6:[function(t,e,n){function o(t){var e;if("INPUT"===t.nodeName||"TEXTAREA"===t.nodeName)t.focus(),t.setSelectionRange(0,t.value.length),e=t.value;else{t.hasAttribute("contenteditable")&&t.focus();var n=window.getSelection(),o=document.createRange();o.selectNodeContents(t),n.removeAllRanges(),n.addRange(o),e=n.toString()}return e}e.exports=o},{}],7:[function(t,e,n){function o(){}o.prototype={on:function(t,e,n){var o=this.e||(this.e={});return(o[t]||(o[t]=[])).push({fn:e,ctx:n}),this},once:function(t,e,n){function o(){i.off(t,o),e.apply(n,arguments)}var i=this;return o._=e,this.on(t,o,n)},emit:function(t){var e=[].slice.call(arguments,1),n=((this.e||(this.e={}))[t]||[]).slice(),o=0,i=n.length;for(o;i>o;o++)n[o].fn.apply(n[o].ctx,e);return this},off:function(t,e){var n=this.e||(this.e={}),o=n[t],i=[];if(o&&e)for(var r=0,a=o.length;a>r;r++)o[r].fn!==e&&o[r].fn._!==e&&i.push(o[r]);return i.length?n[t]=i:delete n[t],this}},e.exports=o},{}],8:[function(e,n,o){!function(i,r){if("function"==typeof t&&t.amd)t(["module","select"],r);else if("undefined"!=typeof o)r(n,e("select"));else{var a={exports:{}};r(a,i.select),i.clipboardAction=a.exports}}(this,function(t,e){"use strict";function n(t){return t&&t.__esModule?t:{"default":t}}function o(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}var i=n(e),r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol?"symbol":typeof t},a=function(){function t(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}return function(e,n,o){return n&&t(e.prototype,n),o&&t(e,o),e}}(),c=function(){function t(e){o(this,t),this.resolveOptions(e),this.initSelection()}return t.prototype.resolveOptions=function t(){var e=arguments.length<=0||void 0===arguments[0]?{}:arguments[0];this.action=e.action,this.emitter=e.emitter,this.target=e.target,this.text=e.text,this.trigger=e.trigger,this.selectedText=""},t.prototype.initSelection=function t(){this.text?this.selectFake():this.target&&this.selectTarget()},t.prototype.selectFake=function t(){var e=this,n="rtl"==document.documentElement.getAttribute("dir");this.removeFake(),this.fakeHandlerCallback=function(){return e.removeFake()},this.fakeHandler=document.body.addEventListener("click",this.fakeHandlerCallback)||!0,this.fakeElem=document.createElement("textarea"),this.fakeElem.style.fontSize="12pt",this.fakeElem.style.border="0",this.fakeElem.style.padding="0",this.fakeElem.style.margin="0",this.fakeElem.style.position="absolute",this.fakeElem.style[n?"right":"left"]="-9999px",this.fakeElem.style.top=(window.pageYOffset||document.documentElement.scrollTop)+"px",this.fakeElem.setAttribute("readonly",""),this.fakeElem.value=this.text,document.body.appendChild(this.fakeElem),this.selectedText=(0,i.default)(this.fakeElem),this.copyText()},t.prototype.removeFake=function t(){this.fakeHandler&&(document.body.removeEventListener("click",this.fakeHandlerCallback),this.fakeHandler=null,this.fakeHandlerCallback=null),this.fakeElem&&(document.body.removeChild(this.fakeElem),this.fakeElem=null)},t.prototype.selectTarget=function t(){this.selectedText=(0,i.default)(this.target),this.copyText()},t.prototype.copyText=function t(){var e=void 0;try{e=document.execCommand(this.action)}catch(n){e=!1}this.handleResult(e)},t.prototype.handleResult=function t(e){e?this.emitter.emit("success",{action:this.action,text:this.selectedText,trigger:this.trigger,clearSelection:this.clearSelection.bind(this)}):this.emitter.emit("error",{action:this.action,trigger:this.trigger,clearSelection:this.clearSelection.bind(this)})},t.prototype.clearSelection=function t(){this.target&&this.target.blur(),window.getSelection().removeAllRanges()},t.prototype.destroy=function t(){this.removeFake()},a(t,[{key:"action",set:function t(){var e=arguments.length<=0||void 0===arguments[0]?"copy":arguments[0];if(this._action=e,"copy"!==this._action&&"cut"!==this._action)throw new Error('Invalid "action" value, use either "copy" or "cut"')},get:function t(){return this._action}},{key:"target",set:function t(e){if(void 0!==e){if(!e||"object"!==("undefined"==typeof e?"undefined":r(e))||1!==e.nodeType)throw new Error('Invalid "target" value, use a valid Element');if("copy"===this.action&&e.hasAttribute("disabled"))throw new Error('Invalid "target" attribute. Please use "readonly" instead of "disabled" attribute');if("cut"===this.action&&(e.hasAttribute("readonly")||e.hasAttribute("disabled")))throw new Error('Invalid "target" attribute. You can\'t cut text from elements with "readonly" or "disabled" attributes');this._target=e}},get:function t(){return this._target}}]),t}();t.exports=c})},{select:6}],9:[function(e,n,o){!function(i,r){if("function"==typeof t&&t.amd)t(["module","./clipboard-action","tiny-emitter","good-listener"],r);else if("undefined"!=typeof o)r(n,e("./clipboard-action"),e("tiny-emitter"),e("good-listener"));else{var a={exports:{}};r(a,i.clipboardAction,i.tinyEmitter,i.goodListener),i.clipboard=a.exports}}(this,function(t,e,n,o){"use strict";function i(t){return t&&t.__esModule?t:{"default":t}}function r(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function a(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}function c(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}function s(t,e){var n="data-clipboard-"+t;if(e.hasAttribute(n))return e.getAttribute(n)}var l=i(e),u=i(n),f=i(o),d=function(t){function e(n,o){r(this,e);var i=a(this,t.call(this));return i.resolveOptions(o),i.listenClick(n),i}return c(e,t),e.prototype.resolveOptions=function t(){var e=arguments.length<=0||void 0===arguments[0]?{}:arguments[0];this.action="function"==typeof e.action?e.action:this.defaultAction,this.target="function"==typeof e.target?e.target:this.defaultTarget,this.text="function"==typeof e.text?e.text:this.defaultText},e.prototype.listenClick=function t(e){var n=this;this.listener=(0,f.default)(e,"click",function(t){return n.onClick(t)})},e.prototype.onClick=function t(e){var n=e.delegateTarget||e.currentTarget;this.clipboardAction&&(this.clipboardAction=null),this.clipboardAction=new l.default({action:this.action(n),target:this.target(n),text:this.text(n),trigger:n,emitter:this})},e.prototype.defaultAction=function t(e){return s("action",e)},e.prototype.defaultTarget=function t(e){var n=s("target",e);return n?document.querySelector(n):void 0},e.prototype.defaultText=function t(e){return s("text",e)},e.prototype.destroy=function t(){this.listener.destroy(),this.clipboardAction&&(this.clipboardAction.destroy(),this.clipboardAction=null)},e}(u.default);t.exports=d})},{"./clipboard-action":8,"good-listener":4,"tiny-emitter":7}]},{},[9])(9)});
	<?php echo '</script'; ?>
>
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
						<div class="complete-add copy_content" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['method']->value['url'];?>
" style="min-width: 396px">
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
								<li class="copy_content" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['param']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['param']->value['name'];?>
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


	<?php echo '<script'; ?>
 type="text/javascript">
		var clipboard = new Clipboard('.copy_content');
		clipboard.on('success', function(e) {
			alert("Successfully Copy!");
		});

		clipboard.on('error', function(e) {
			alert("请使用主流浏览器！");
		});
	<?php echo '</script'; ?>
>
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
