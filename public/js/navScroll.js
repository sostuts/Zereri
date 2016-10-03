/**
 * 点击导航链接 跳转到指定容器的位置，类似于锚点的功能，增加了动画效果
 * 扩展 当窗口宽度小于容器宽度，内容居中显示。
 * 动画算法参考 http://www.cnblogs.com/cloudgamer/archive/2009/01/06/Tween.html
 * @param        {Object}                     resizeWrap        用于容器宽度的方法，不使用此功能可以删除。
 * @param        {Object}                     nav               用于导航锚点跳转功能，不使用此功能可以删除。
 *
 * @example      resizeWrap : {
 *                   wrap : 'wrap',           {String}          外容器的ID名
 *                   maxWidth : 600           {Number}          窗口小于多少宽度开始裁剪
 *               }
 * 
 * @example      nav : {
 *                   id : 'nav',              {String}          导航的ID名
 *                   current : 'current',     {String}          选中的class名，默认为 current
 *                   speed : 25,              {Number}          动画速度，越小越快
 *                   fixPx : 40               {Number}          在导航使用绝对定位且在窗口上方，容器与导航的差，可以不填写，默认为0;
 *               }
 * 
 * @author        M.J
 * @URL           http://webjyh.com
 * @Demo          http://demo.webjyh.com/navScroll/
 * @Time          2014/03/07
 * @Update        2014/03/28
 * @Ver           1.2.0
*/
(function(){
	var navScroll = function( params ){
		if ( !params ) return false;
		var _this = this;
		
		if ( params.resizeWrap ) {
			_this.resizeWrap( params.resizeWrap.wrap, params.resizeWrap.maxWidth );
			_this.bind( params.resizeWrap.wrap, params.resizeWrap.maxWidth );
		}
		if ( params.nav ){
			_this.current = params.nav.current ? params.nav.current : 'current';
			_this.fixPx = params.nav.fixPx ? params.nav.fixPx : 0;
			_this.init( params.nav.id, params.nav.speed );
		}
	};
	navScroll.prototype = {
		addEventCheck : function( obj, evt, fn ){
			if ( obj.addEventListener ){
				obj.addEventListener( evt, fn, false );
			} else if ( obj.attachEvent ){
				obj.attachEvent( 'on'+evt, fn );
			}
		},
		resizeWrap : function( obj, maxWidth ){
			var _this = this,
			    screen = document.body.clientWidth,
			    m = ( screen < maxWidth ) ? parseInt( ( screen - maxWidth ) / 2 ) + 'px' : 'auto';
			document.getElementById( obj ).style.marginLeft = m;
		},
		init : function( obj, speed ){
			var _this = this,
			    li = document.getElementById( obj ).getElementsByTagName('li'),
			    re = new RegExp( '#+(.*)', 'i' ),
			    offsetTop = [];
			for ( var i=0; i<li.length; i++ ){
				li[i].index = i;
				var reg = re.exec( li[i].getElementsByTagName('a')[0].href );
				li[i].idName = reg ? reg[1] : null;
				var box = [
					li[i].index,
					li[i].idName ? ( document.getElementById( li[i].idName ).offsetTop - _this.fixPx ) : null,
					li[i].idName ? (document.getElementById( li[i].idName ).offsetTop - _this.fixPx) + document.getElementById( li[i].idName ).clientHeight : null
				];
				offsetTop.push( box );
				li[i].onclick = function(){
					if ( li[this.index].idName ){
						var top = document.getElementById( li[this.index].idName ).offsetTop - _this.fixPx ,
							b = _this.getScrollPos(),
							c = ( top - _this.getScrollPos() ),
							d= speed ,
							t=0;
						_this.animate( t, b, c, d );
						return false;
					}
				}
			}
			_this.addEventCheck( window, 'scroll', function(){ _this.scroll( li, offsetTop ); } );
		},
		scroll : function( obj, arr ){
			var _this = this,
			    scroll = _this.getScrollPos();
			for ( var i=0; i<arr.length; i++ ){
				if ( arr[i][1] && arr[i][2] ){
					if ( scroll >= arr[i][1] && scroll <= arr[i][2] ){
						_this.classReset( obj );
						obj[arr[i][0]].getElementsByTagName('a')[0].className = _this.current;
					}
				}
			}
		},
		getScrollPos : function(){
			return window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
		},
		classReset : function( obj ){
			for ( var i=0; i<obj.length; i++ ){
				obj[i].getElementsByTagName('a')[0].className='';
			}
		},
		animate : function( t, b, c, d ){
			var _this = this;
			var a = Math.ceil( _this.easeOut( t, b, c, d ) );
			window.scrollTo( 0, a );
			if ( t<d ){ t++; setTimeout( function(){ _this.animate( t, b, c, d ); }, 20 ); }
		},
		bind : function( obj, maxWidth ){
			var _this = this;
			_this.addEventCheck( window, 'resize', function(){ _this.resizeWrap( obj, maxWidth ); } )
		},
		easeOut : function( t, b, c, d ){
			return c*((t=t/d-1)*t*t + 1) + b;
		}
	};
	window.navScroll = navScroll;
}());