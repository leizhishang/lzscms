<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body style="">
<div style="text-align:center;background-color: #ffc65a;padding: 30px;font-family: '微软雅黑'">
    <table width="650" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;"><tbody><tr><td>
                <div style="width:650px;text-align:left;font:12px/15px simsun;color:#000;">
                    <div style="min-height: 462px;padding: 43px;background:#fff;" >
                        <div style="font-size: 14px;color: #515151;">
                            <p>Hello，<span style="color: #ed8b31;">{{ $data['username'] }}</span></p>
                            <p>您本次操作的验证码为：<span style="color: #ed8b31;">{{ $data['code'] }}</span></p>
                            <p>本验证码5分钟内有效。</p>
                            <div style="margin: 45px 0;">
                                <p>如果您有任何问题，请联系我们，我们会尽快回复</p>
                            </div>
                            <p>Email:@if(lzs_config('site', 'email')){!! lzs_config('site', 'email') !!}
                                @else info@leizhishang.com @endif</p>
                        </div>
                    </div>
                </div>
            </td></tr>
        </tbody>
    </table>
</div>
</body>
</html>