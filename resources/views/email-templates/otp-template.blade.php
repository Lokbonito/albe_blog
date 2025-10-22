<div style="font-family: Arial, sans-serif; color: #333;">
    <h2>Xin chào {{ $user->name }},</h2>
    <p>Mã xác thực OTP của bạn là:</p>
    <h3 style="color: #007bff;">{{ $otp }}</h3>
    <p>Mã này sẽ hết hạn sau <strong>1 phút</strong>. Vui lòng không chia sẻ mã này với bất kỳ ai.</p>
    <br>
    <p>Trân trọng,<br>Đội ngũ hỗ trợ {{ config('app.name') }}</p>
</div>
