<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
<style>
  body{
    line-height: 1.0;
    overflow-y: hidden;
    overflow-x: hidden;
  }
  .hstui-topbar-inverse .hstui-topbar-nav>li.hstui-active>a:after,
  .hstui-topbar-inverse .hstui-topbar-nav>li.hstui-active>a:hover:after,
  .hstui-topbar-inverse .hstui-topbar-nav>li.hstui-active>a:focus:after {
    border-bottom-color: #0b6fa2;
  }
  .manage-main .manage-right,iframe{
    background: #fff;
  }
</style>
</head>
<body>
<div class="hstui-content" id="app" style="display: none;">
      <header class="hstui-topbar hstui-topbar-inverse manage-header">
        <div class="hstui-topbar-brand" style="width: 189px;">
          <a href="{!! route('manageIndex') !!}"><img src="{{ lzs_assets('manage/images/logo.png') }}" width="169" height="40"></a> 
        </div>
        <div class="hstui-topbar-collapse hstui-collapse" id="topbar-collapse">
          <ul class="hstui-nav hstui-nav-pills hstui-topbar-nav hstui-topbar-left" id="hstui-topbar-nav">
           
          </ul>

          <ul class="hstui-nav hstui-nav-pills hstui-topbar-nav hstui-topbar-right">
           <!--  <li>
              <a href="javascript:;"><span class="hstui-icon hstui-icon-email"></span> 收件箱 <span class="hstui-badge hstui-badge-warning">5</span></a>
            </li> -->
            <li class="hstui-dropdown" data-hstui-dropdown data-id="hstui-dropdown-content">
              <a class="hstui-dropdown-toggle" data-hstui-dropdown-toggle href="javascript:;">
                <span class="hstui-icon hstui-icon-guanliyuan"></span> {{ $userInfo['username'] }} <span class="hstui-icon-caret-down"></span>
              </a>
              <ul class="hstui-dropdown-content" id="hstui-dropdown-content">
                <li>
                  <a href="{!! route('manageUserInfoEdit', ['uid'=>$userInfo['uid']]) !!}" class="J_dialog" title="修改资料"><span class="hstui-icon hstui-icon-person"></span> {{ lzs_lang('lzscms::public.data') }}</a>
                </li>
                <li>
                  <a href="#"><span class="hstui-icon hstui-icon-gear"></span> {{ lzs_lang('lzscms::public.setting') }}</a>
                </li>
                <li>
                  <a href="{{ route('manageAuthLogout') }}"><span class="hstui-icon hstui-icon-export"></span> {{ lzs_lang('lzscms::public.logout')}}</a>
                </li>
              </ul>
            </li>
            <li class="hstui-hide-sm-only">
              <a href="{{ route('manageDoLocked') }}" class="J_confirm" data-msg="确认锁屏吗"><span class="hstui-icon hstui-icon-locked"></span> <span class="admin-fullText">{{ lzs_lang('lzscms::public.locked') }}</span></a>
            </li>
          </ul>
        </div>
      </header>
      <div class="manage-main">
        <div class="manage-left">
          <div class="hstui-scrollable-vertical">
            <ul class="hstui-lnav" id="B_menubar">
            </ul>
          </div>
         <!--  <div class="manage-left-setting">
            <i class="hstui-icon hstui-icon-arrowleft" data-icon1="hstui-icon-arrowleft" data-icon2="hstui-icon-arrowright"></i>
          </div> -->
        </div>
        <div class="manage-right" id="B_frame">
          <div id="B_tabA" class="tabA">
            <a href="" tabindex="-1" class="tabA_pre J_tooltips" id="J_prev" data-tooltips-content="上一页"><i class="hstui-icon hstui-icon-triangle-arrow-l"></i></a>
            <a href="" tabindex="-1" class="tabA_next J_tooltips" id="J_next" data-tooltips-content="下一页"><i class="hstui-icon hstui-icon-triangle-arrow-r"></i></a>
            <div style="margin:0 25px;min-height:1px;">
              <div style="position:relative;height:30px;width:100%;overflow:hidden;">
                <ul id="B_history" style="white-space:nowrap;position:absolute;left:0;top:0;">
                  <li tabindex="0" data-id="default" class="current"><span><a>{{ lzs_lang('lzscms::manage.manage.home') }}</a></span></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="options">
            <a href="" id="J_refresh" class="J_tooltips" data-tooltips-content="{{ lzs_lang('lzscms::public.refresh') }}"><i class="hstui-icon hstui-icon-refreshempty"></i></a>
            <a href="javascript:;" id="J_fullScreens" class="J_tooltips" data-tooltips-content="{{ lzs_lang('lzscms::manage.open.full.screen') }}" ><i class="hstui-icon hstui-icon-quanping"></i></a>
          </div>
          <iframe id="iframe_default" src="{{ route('manageHome') }}" style="height: 100%; width: 100%;display:none;" data-id="default" frameborder="0" scrolling="auto"></iframe>
        </div>
      </div>
</div>
<div class="loading hstui-loading" id="loading"><img src="{{ url('assets/manage/images/loading.gif') }}"></div>
{!! lzscms_hook('s_manage_index') !!}
<script>
      var  SUBMENU_CONFIG = {!! $menus !!};/*主菜单区*/
      Hstui.use('jquery', 'common', function() {
        Hstui.js('{{ lzs_public('assets/manage/js/common.js') }}', function() {
          var topbar = [];
          $.each(SUBMENU_CONFIG,function(i,o) {
            var lihtml = '<li class="hstui-hide-sm-only">';
            if(!o.url) {
              lihtml += '<a data-name="'+o.name+'" data-id="'+o.id+'" href="javascript:;">'+o.name+'</a>';
            }
            lihtml +='</li>';
            topbar.push(lihtml);
          });
          $('#hstui-topbar-nav').html(topbar.join(''));
          $('#hstui-topbar-nav li').eq(0).addClass('hstui-active');
          function setLeftMenu(topbarId) {
            var html = [];
            $.each(SUBMENU_CONFIG[topbarId].items,function(i,o) {
              var lihtml = '<li class="J_lid_'+o.id+'">';
              if(o.url) {
                lihtml +='<a data-name="'+o.name+'" data-id="'+o.id+'" data-tid="'+o.id+'" data-href="'+o.url+'" href="javascript:;" ><i class="hstui-icon hstui-icon-triangle-arrow-r"></i> '+o.name+'</a>';
              } else {
                lihtml +='<a href="javascript:;" class="dropdown-toggle"><i class="hstui-icon '+o.icon+'"></i>'+o.name+'<i class="hstui-icon hstui-icon-arrowright"></i></a>';
                if(o.items) {
                  lihtml +='<ul class="submenu">';
                  $.each(o.items,function(x,v) {
                    lihtml +='<li>';
                    if(v.url) {
                      lihtml +='<a data-name="'+v.name+'" data-tid="'+o.id+'" data-id="'+v.id+'" data-href="'+v.url+'" href="javascript:;"><i class="hstui-icon hstui-icon-triangle-arrow-r"></i>'+v.name+'</a>';
                    } else {
                      lihtml +='<a href="javascript:;" class="dropdown-toggle">'+v.name+'<i class="hstui-icon hstui-icon-arrowright"></i></a>';
                      lihtml +='<ul class="submenu">';
                      $.each(v.items,function(c,t) {
                        lihtml +='<li>';
                        lihtml +='<a data-name="'+t.name+'" data-tid="'+o.id+'" data-id="'+t.id+'" data-href="'+t.url+'" href="javascript:;"><i class="hstui-icon hstui-icon-triangle-arrow-r"></i>'+t.name+'</a>';
                        lihtml +='</li>';
                      });
                        lihtml +='</ul>';
                    }
                    lihtml +='</li>';
                  });
                  lihtml +='</ul>';
                }
              }
              lihtml +='</li>';
              html.push(lihtml);
            });
            $('#B_menubar').html(html.join(''));
            Hstui.Util.treenav($(".hstui-lnav"), function(o) {
              var href = o.data('href'),
                id = o.data('id'),
                name = o.text();
                if(href != null) {
                  iframeJudge({
                    elem: o,
                    href: href,
                    id: id,
                    name: name
                  });
                }
            });
          }
          $('#hstui-topbar-nav li a').on('click', function(e){
            e.preventDefault();
            var _this = $(this),
              id = _this.data('id');
              $('#hstui-topbar-nav li').removeClass('hstui-active');
              setLeftMenu(id);
              _this.parent().addClass('hstui-active');
          });
          setLeftMenu($('#hstui-topbar-nav li a').eq(0).data('id'));
          function initHw() {
            var bh = $('body').height();
            var bw = $('body').width();
            $(".hstui-scrollable-vertical").height(bh - $('header').height() - 30);
            $(".manage-right").height(bh - $('header').height());
            $('iframe').height(bh - $('header').height() - $('.tabA').height());
          }
          window.onresize = function(){
            initHw();
          }
          initHw();
          var isfullScreens = false;
          $("#J_fullScreens").on('click', function(e) {
            e.preventDefault();
            $("#J_fullScreens i").toggleClass('hstui-icon-quanping');
            $("#J_fullScreens i").toggleClass('hstui-icon-tuichuquanping');
            if(!isfullScreens) {
              isfullScreens = true;
              requestFullScreen(document.documentElement);
              $("#J_fullScreens").tooltips({
                content:'{{ lzs_lang('lzscms::manage.close.full.screen') }}'
              });
            } else {
              exitFull();
              isfullScreens = false;
              $("#J_fullScreens").tooltips({
                content:'{{ lzs_lang('lzscms::manage.open.full.screen') }}'
              });
            }
          })
          var iframe_default = document.getElementById('iframe_default');
          $(iframe_default.contentWindow.document).ready(function() {
            $('#loading').hide();
            $("#app").show();
            $(iframe_default).show();
          });

          //判断显示或创建iframe
          window.iframeJudge = function (options) {
            var elem = options.elem,
              href = options.href,
              id = options.id,
              name = options.name,
              li = $('#B_history li[data-id=' + id + ']');
            if(li.length > 0) {
              //如果是已经存在的iframe，则显示并让选项卡高亮,并不显示loading
              var iframe = $('#iframe_' + id);
              li.addClass('current');
              if(iframe[0].contentWindow && iframe[0].contentWindow.location.href !== href) {
                iframe[0].contentWindow.location.href = href;
              }
              $('#B_frame iframe').hide();
              $('#iframe_' + id).show();
              showTab(li); //计算此tab的位置，如果不在屏幕内，则移动导航位置
            } else {
              //创建一个并加以标识
              $("#loading img").css({'width':'30px'});
              $("#loading").css({"margin-left":"95px"}).show();
              var iframeAttr = {
                src: href,
                id: 'iframe_' + id,
                frameborder: '0',
                scrolling: 'auto',
                height: '100%',
                width: '100%'
              };
              var iframe = $('<iframe/>').prop(iframeAttr).appendTo('#B_frame').hide();
              $(iframe[0].contentWindow.document).ready(function() {
                $('#B_frame iframe').hide();
                  var li = $('<li tabindex="0"><span><a>' + name + '</a><a class="del hstui-icon" title="{{ lzs_lang('lzscms::manage.close.this.page')}}"></a></span></li>').attr('data-id', id).addClass('current');
                  li.siblings().removeClass('current');
                  li.appendTo('#B_history');
                  showTab(li); //计算此tab的位置，如果不在屏幕内，则移动导航位置
              });
              if (iframe[0].attachEvent){ 
                iframe.attachEvent("onload", function(){ 
                  alert("Local iframe is now loaded1."); 
                }); 
              } else { 
                iframe[0].onload = function(){ 
                  $("#loading").hide();
                  iframe.show()
                }; 
              } 
            }
            initHw();
          }
          //顶部点击一个tab页
          $('#B_history').on('click focus', 'li', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var data_id = $(this).data('id');
            $(this).addClass('current').siblings('li').removeClass('current');
            $('#iframe_' + data_id).show().siblings('iframe').hide(); //隐藏其它iframe
          });

          //顶部关闭一个tab页
          $('#B_history').on('click', 'a.del', function(e) {
            e.stopPropagation();
            e.preventDefault();
            var li = $(this).parent().parent(),
              prev_li = li.prev('li'),
              data_id = li.attr('data-id');
            li.hide(60, function() {
              $(this).remove(); //移除选项卡
              $('#iframe_' + data_id).remove(); //移除iframe页面
              var current_li = $('#B_history li.current');
              //找到关闭后当前应该显示的选项卡
              current_li = current_li.length ? current_li : prev_li;
              current_li.addClass('current');
              cur_data_id = current_li.attr('data-id');
              $('#iframe_' + cur_data_id).show();
            });
          });

          //下一个选项卡
          $('#J_next').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            var ul = $('#B_history'),
              current = ul.find('.current'),
              li = current.next('li');
            showTab(li);
          });
          //上一个选项卡
          $('#J_prev').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            var ul = $('#B_history'),
              current = ul.find('.current'),
              li = current.prev('li');
            showTab(li);
          });
          //显示顶部导航时作位置判断，点击左边菜单、上一tab、下一tab时公用
          function showTab(li) {
            if(li.length) {
              var ul = $('#B_history'),
                li_offset = li.offset(),
                li_width = li.outerWidth(true),
                next_left = $('#J_next').offset().left - 9, //右边按钮的界限位置
                prev_right = $('#J_prev').offset().left + $('#J_prev').outerWidth(true); //左边按钮的界限位置
              if(li_offset.left + li_width > next_left) { //如果将要移动的元素在不可见的右边，则需要移动
                var distance = li_offset.left + li_width - next_left; //计算当前父元素的右边距离，算出右移多少像素
                ul.animate({
                  left: '-=' + distance
                }, 200, 'swing');
              } else if(li_offset.left < prev_right) { //如果将要移动的元素在不可见的左边，则需要移动
                var distance = prev_right - li_offset.left; //计算当前父元素的左边距离，算出左移多少像素
                ul.animate({
                  left: '+=' + distance
                }, 200, 'swing');
              }
              li.trigger('click');
            }
          }
          //刷新
          $('#J_refresh').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            var id = $('#B_history .current').attr('data-id'),
              iframe = $('#iframe_' + id);
            if(iframe[0].contentWindow) {
              Hstui.Util.reloadPage(iframe[0].contentWindow);
            }
          });
        });
      });
      function requestFullScreen(element) {  // 判断各种浏览器，找到正确的方法
        var requestMethod = element.requestFullScreen || //W3C
           element.webkitRequestFullScreen || //Chrome等
           element.mozRequestFullScreen || //FireFox
           element.msRequestFullScreen; //IE11
        if(requestMethod) {  
          requestMethod.call(element); 
        } else if(typeof window.ActiveXObject !== "undefined") { //for Internet Explorer
          var wscript = new ActiveXObject("WScript.Shell");  
          if(wscript !== null) {   
            wscript.SendKeys("{F11}");  
          } 
        }
      }
      function exitFull() {
        var exitMethod = document.exitFullscreen || //W3C
          document.mozCancelFullScreen || //Chrome等
          document.webkitExitFullscreen || //FireFox
          document.webkitExitFullscreen; //IE11
        if(exitMethod) {
          exitMethod.call(document);
        } else if(typeof window.ActiveXObject !== "undefined") { //for Internet Explorer
          var wscript = new ActiveXObject("WScript.Shell");
          if(wscript !== null) {
            wscript.SendKeys("{F11}");
          }
        }
      }     
</script>
</body>
</html>