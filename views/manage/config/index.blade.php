<!doctype html>
<html>
<head>
@include('lzscms::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('mymanageConfigSave') }}" method="post">
    {!! lzs_csrf() !!} 
    <div class="hstui-frame">
      	<div class="hstui-frame-content">
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.site.name') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="name" id="lzscms_name" value="@if($errors->has('name')){!! old('name') !!}@else{!! @$config['name'] !!}@endif" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_name"></div>
	          </div>
	        </div>
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('icp')) hstui-form-error @endif" id="J_form_error_icp">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.site.icp') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="icp" id="lzscms_icp" value="@if($errors->has('icp')){!! old('icp') !!}@else{!! @$config['icp'] !!}@endif" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_icp" data-tips="{{ lzs_lang('lzscms::manage.site.icp.tips') }}">{{ lzs_lang('lzscms::manage.site.icp.tips') }}</div>
	          </div>
	        </div>
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('headerhtml')) hstui-form-error @endif" id="J_form_error_headerhtml">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.site.headerhtml') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
					<textarea name="headerhtml" id="lzscms_headerhtml" class="hstui-input hstui-length-5" style="height: 120px;">@if(old('headerhtml')){!! old('headerhtml') !!}@else{!! @$config['headerhtml'] !!}@endif</textarea>
	            <div class="hstui-form-input-tips" id="J_form_tips_headerhtml" data-tips="{{ lzs_lang('lzscms::manage.site.headerhtml.tips') }}">{{ lzs_lang('lzscms::manage.site.headerhtml.tips') }}</div>
	          </div>
	        </div>
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('footerhtml')) hstui-form-error @endif" id="J_form_error_footerhtml">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.site.footerhtml') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
					<textarea name="footerhtml" id="lzscms_footerhtml" class="hstui-input hstui-length-5" style="height: 120px;">@if(old('footerhtml')){!! old('footerhtml') !!}@else{!! @$config['footerhtml'] !!}@endif</textarea>
	            <div class="hstui-form-input-tips" id="J_form_tips_footerhtml" data-tips="{{ lzs_lang('lzscms::manage.site.footerhtml.tips') }}">{{ lzs_lang('lzscms::manage.site.footerhtml.tips') }}</div>
	          </div>
	        </div>
		    <div class="hstui-form-group hstui-form-group-sm @if($errors->has('visitState')) hstui-form-error @endif" id="J_form_error_visitState">
		        <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.site.visit.state') }}</label>
		        <div class="hstui-u-sm-10 hstui-form-input" id="J_state_type">
		            	<label class="blue mr10">
							<input name="state" value="1" type="radio" class="ace" data-title="s1" data-type="J_state_s1" @if(old('state')){!! lzs_ifCheck(old('state') == 1) !!}@else{!! lzs_ifCheck(@$config['vstate'] == 1) !!}@endif />
							<span class="lbl">{{ lzs_lang('lzscms::public.opens') }}</span>
						</label>
						<label class="blue">
							<input name="state" value="0" type="radio" class="ace" data-title="s0" data-type="J_state_s0" @if(old('state')){!! lzs_ifCheck(!old('state')) !!}@else{!! lzs_ifCheck(!@$config['vstate']) !!}@endif/>
							<span class="lbl">{{ lzs_lang('lzscms::public.closes') }}</span>
						</label>
		          	<div class="hstui-form-input-tips" id="J_form_tips_visitState"></div>
					<span class="input-tips" id="J_state_tip"></span>
		        </div>
		    </div>
			<div class="J_status_tbody" id="J_state_s1"></div>
			<div class="hstui-form-group J_status_tbody" id="J_state_s0">
		        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('visitMessage')) hstui-form-error @endif" id="J_form_error_visitMessage">
		          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.site.visit.state0') }}</label>
		          <div class="hstui-u-sm-10 hstui-form-input">
						<textarea name="visitMessage" id="lzscms_visitMessage" class="hstui-input hstui-textarea hstui-length-5" style="height: 120px;">@if(old('visitMessage')){!! old('visitMessage') !!}@else{!! @$config['vmessage'] !!}@endif</textarea>
		            <div class="hstui-form-input-tips" id="J_form_tips_visitMessage"></div>
		          </div>
		        </div>
		        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('visitMessageTemplate')) hstui-form-error @endif" id="J_form_error_visitMessageTemplate">
		          <label class="hstui-u-sm-2 hstui-form-label">{{ lzs_lang('lzscms::manage.site.visit.message.template') }}</label>
		          <div class="hstui-u-sm-10 hstui-form-input">
	              		<input type="text" name="visitMessageTemplate" id="lzscms_visitMessageTemplate" value="@if($errors->has('visitMessageTemplate')){!! old('visitMessageTemplate') !!}@else{!! @$config['vmtemplate'] !!}@endif" class="hstui-input hstui-length-5">
		            <div class="hstui-form-input-tips" id="J_form_tips_headerhtml" data-tips="{{ lzs_lang('lzscms::manage.site.visit.message.template.tips') }}">{{ lzs_lang('lzscms::manage.site.visit.message.template.tips') }}</div>
		          </div>
		        </div>
			</div>
      	</div>
    </div>    
    <div class="hstui-form-button">
       <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ lzs_lang('lzscms::public.submit') }}</button>
    </div>
  </form>
</div>
<script>
//站点状态
var status_title = {
	s1 : '允许任何人访问站点',
	s2 : '除创始人，其他用户不允许访问站点，一般用于站点关闭、系统维护等情况'
};
Hstui.use('jquery','common',function() {
	var checked = $('#J_state_type input:checked');
	statusAreaShow(checked.data('type'));
	statusTitle(checked.data('title'));

	$('#J_state_type input:radio').on('change', function() 
	{
			statusAreaShow($(this).data('type'));
			statusTitle($(this).data('title'));
	});
	//切换显示版块
	function statusAreaShow(type) 
	{
		var status_arr= new Array();
		status_arr = type.split(",");
		$('div.J_status_tbody').hide();
		$.each(status_arr, function(i, o)
		{
			$('#'+ o).show();
		});
	}
	//切换提示文案
	function statusTitle(title)
	{
		$('#J_state_tip').text(status_title[title]);
	}
});
</script>
</body>
</html>