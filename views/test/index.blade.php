<!DOCTYPE html>
<html>
<head>
@include('lzscms::common.head')
</head>
<body>
<form method="post" action="{{ route('uploadImageSave') }}" enctype="multipart/form-data">
    {!! lzs_csrf() !!} 
	<input type="file" name="filedata">
	<input type="text" name="aid" value="">
	<button type="submit" value="提交">提交</button>
</form>
<style>


</style>
<!-- <img src="{{ lzs_image_resize(229, ['width'=>100, 'height'=>100, 'type'=>'force']) }}" style="width: 100px">


<img src="{{ route('imageView', ['aid'=>231]) }}" style="width: 100px">
<img src="{{ route('imageResize', ['aid'=>231, 'width'=>130, 'height'=>130, 'type'=>'resize']) }}" style="width: 100px"> -->
		
		<div class="hstui-upload J_upload"></div>
		<div class="hstui-upload J_uploads"></div>
<a href="" ></a>

<!-- 		<div class="hstui-button hstui-button-danger hstui-button-upload">
			<i class="hstui-icon hstui-icon-upload"></i>选择上传文件
			<input type="file" class="J_upload" id="filedata" data-idname="image" data-name="image" />
		</div> -->
		<span id="hstui-upload-queue-item-tips_image"></span>
		<span id="uploadpercents"></span>
		<div id="upload_list_image" class="upload_list">
<!-- 			<li class="hstui-upload-queue-item">
				<img src="http://pic.58.com/p1/big/n_v20b485ccd46c34831b6fc8617cd49135d_130_100.jpg">
				<div class="image_cover"></div>
				<div class="toolbar_wrap">	
					<div class="opacity"></div>	
					<div class="toolbar">		
						<a href="javascript:;" class="edit hstui-icon hstui-icon-compose" id=""></a>		
						<a href="javascript:;" class="delete hstui-icon hstui-icon-trash"></a>	
					</div>
				</div>
				<div class="hstui-upload-queue-item-tips">
					<span class="hstui-upload-queue-item-tips_content"></span>
					<span class="hstui-icon hstui-spinner"></span>
					<p>23%</p>
				</div>
			</li>
			<li class="hstui-upload-queue-item">
				<img src="http://pic.58.com/p1/big/n_v20b485ccd46c34831b6fc8617cd49135d_130_100.jpg">
				<div class="image_cover"></div>
				<div class="toolbar_wrap">	
					<div class="opacity"></div>	
					<div class="toolbar">		
						<a href="javascript:;" class="edit hstui-icon hstui-icon-compose" id=""></a>		
						<a href="javascript:;" class="delete hstui-icon hstui-icon-trash"></a>	
					</div>
				</div>
				<div class="hstui-upload-queue-item-tips hstui-upload-queue-item-tips_deng">
					<p class="hstui-upload-queue-item-tips_content">等待上传</p>
				</div>
			</li> -->
		</div>
		<div id="upload_list_image" class="upload_list">
			<li class="file_box">
				<!-- <img src="http://pic.58.com/p1/big/n_v20b485ccd46c34831b6fc8617cd49135d_130_100.jpg">
				<input type="text" class="hstui-input" name="">
				<span class="hstui-upload-queue-item-tips"></span> -->
			</li>
		</div>
		<input type="text" id="lzscms_image" name="">
<script>
			Hstui.use('jquery', 'common', 'upload', function() {
					// $(".J_upload").hstuiUpload({
					// 	uploadNum: 5,
					// 	uploadUrl: 'http://www.Leizhishang.com/test/post',
					// 	uploadData: {
					// 		_token: $("input[name='_token']").val()
					// 	},
					// 	uploadProgress:function(e,p,t,r) {

					// 	}
					// });
					$(".J_pw").on('click', function(e){
						e.preventDefault();
						var _this = $(this),pwstr = _this.data('pw'),isview = _this.data('isview');
						if(isview) {
							return false;
						}
						html = '<div class="hstui-form hstui-form-horizontal"><div class="hstui-frame"><div class="hstui-frame-content"><div class="hstui-form-group hstui-form-group-sm " id="J_form_error_viewpw"><input type="password" name="viewpw" id="lzscms_viewpw" value="" class="hstui-input hstui-length-6" placeholder="请输入查看密码"><div class="hstui-form-input-tips" id="J_form_tips_viewpw" data-tips=""></div></div></div><div class="hstui-form-button"><button type="submit" class="hstui-button hstui-button-primary J_pw_submit_btn" data-dialog="1">{{ lzs_lang('lzscms::public.submit')}}</button></div></div></div>';
						Hstui.use('dialog', function() {
							Hstui.dialog.html(html,{
								id:'J_pw',
								title:'{{ lzs_lang('lzscms::public.view')}}',
								className: 'hstui-pop-showmsg-wrap',
								isMask: false,
								zIndex: 99,
								callback:function() {
									$(".J_pw_submit_btn").on('click',function(e){
										e.preventDefault();
										var viewpw = $("#lzscms_viewpw").val();
										if(!viewpw) {
											$("#J_form_error_viewpw").removeClass('hstui-form-error').addClass('hstui-form-error');
											$("#J_form_tips_viewpw").html('').html('请输入查看密码');
											setTimeout(function() {
												$("#J_form_error_viewpw").removeClass('hstui-form-error');
												$("#J_form_tips_viewpw").html('');
											}, 1500);
											return false;
										}
										Hstui.Util.ajaxMaskShow();
										$.ajax({
											url: _this.data('href'),
											type: 'post',
											dataType: 'json',
											data:{
												viewpw:pwstr,
												password:viewpw,
												_token: $('meta[name="csrf-token"]').attr('content')
											},
											success: function(data) {
												Hstui.Util.ajaxMaskRemove();
												if(data.state === 'success') {
													_this.html(data.viewpw);
													_this.data("isview", 1);
													$('.J_close').click();
												} else if(data.state === 'fail') {
													$("#J_form_error_viewpw").removeClass('hstui-form-error').addClass('hstui-form-error');
													$("#J_form_tips_viewpw").html('').html(data.message);
													setTimeout(function() {
														$("#J_form_error_viewpw").removeClass('hstui-form-error');
														$("#J_form_tips_viewpw").html('');
													}, 1500);
												}
											},
											error: function() {
												Hstui.Util.ajaxMaskRemove();
												$("#J_form_error_viewpw").removeClass('hstui-form-error').addClass('hstui-form-error');
												$("#J_form_tips_viewpw").html('').html('请求出错');
												setTimeout(function() {
													$("#J_form_error_viewpw").removeClass('hstui-form-error');
													$("#J_form_tips_viewpw").html('');
												}, 1500);
											}
										});
									})
								}
							});
						});
					});
					$(".J_upload").hstuiUpload({
						// uploadNum: 5,
						fileName: 'filedata',
						fName: 'tu',
						isedit: true,
						url: 'http://www.Leizhishang.com/test/post',
						dataList: [{"aid":215,"name":"1225px(1).png","type":"png","size":21102,"path":"2018\/05\/28\/8b444a9dfba5c6fdfe58f63d87717171.png","ifthumb":0,"created_userid":0,"created_time":1527498262,"app":"form_ceshi","app_id":12,"descrip":"","disk":"public","url":"http:\/\/www.Leizhishang.com\/storage\/2018\/05\/28\/8b444a9dfba5c6fdfe58f63d87717171.png"},{"aid":216,"name":"down.png","type":"png","size":149,"path":"2018\/05\/28\/9e38550bbf5c68fb947f785ad67b9c4a.png","ifthumb":0,"created_userid":0,"created_time":1527498264,"app":"form_ceshi","app_id":12,"descrip":"","disk":"public","url":"http:\/\/www.Leizhishang.com\/storage\/2018\/05\/28\/9e38550bbf5c68fb947f785ad67b9c4a.png"}],
						formParam: {
							_token: $("input[name='_token']").val()
						},
						// uploadProgress:function(e,p,t,r) {

						// }
					});
					$(".J_uploads").hstuiUpload({
						autoUpload: true,
						multi: false,
						fileName: 'filedata',
						fName: 'image',
						// dataList: [{"aid":215,"name":"1225px(1).png","type":"png","size":21102,"path":"2018\/05\/28\/8b444a9dfba5c6fdfe58f63d87717171.png","ifthumb":0,"created_userid":0,"created_time":1527498262,"app":"form_ceshi","app_id":12,"descrip":"","disk":"public","url":"http:\/\/www.Leizhishang.com\/storage\/2018\/05\/28\/8b444a9dfba5c6fdfe58f63d87717171.png"},{"aid":216,"name":"down.png","type":"png","size":149,"path":"2018\/05\/28\/9e38550bbf5c68fb947f785ad67b9c4a.png","ifthumb":0,"created_userid":0,"created_time":1527498264,"app":"form_ceshi","app_id":12,"descrip":"","disk":"public","url":"http:\/\/www.Leizhishang.com\/storage\/2018\/05\/28\/9e38550bbf5c68fb947f785ad67b9c4a.png"}],
						queue: {
							width: 300,
							itemWidth:'300',
							itemHeight:'200',
						},
						showNote: '请上传8m以内文件',
						url: 'http://www.Leizhishang.com/test/post',
						formParam: {
						},
						// uploadProgress:function(e,p,t,r) {

						// }
				})
			})
		</script>
</body>
</html>