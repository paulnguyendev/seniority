@php
    $urlActive = route('auth_agent/active',['token' => $data['token']]);
@endphp
<div
    style="background: #edf2f7;padding:30px;width:100%;height:100%;display:flex;align-items: center;justify-content: center;overflow: hidden;">
    <div style="background:#fff;padding:30px;border-radius:8px;width: 570px;margin:auto">
        <div style="text-align: center">
            <img style="width:200px;margin:auto;" src="{{get_logo()}}"
                alt="">
        </div>
        <p><strong>Hello</strong> {{$data['email']}}</p>
        <p>Congratulations, you have successfully activated an account</p>
        <p>Verification Code: {{$data['verify_code'] ?? "-"}} </p>
        <p style="text-align:center">
            <a href="{{$urlActive}}"
                style="padding:15px;background:{{config('obn.brand.color_main')}};border-radius:8px;color:#fff;text-decoration: none; display:inline-block;margin:auto">Active account</a></p>
        <div style="text-align: center">
            <p>Or at the following link: </p>
            <p><a href="{{$urlActive}}">{{$urlActive}}</a></p>
        </div>
    </div>
</div>
