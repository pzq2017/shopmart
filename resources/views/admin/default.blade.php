<div class="login-tips">
    <p>您好，{{ admin_auth()->loginName }}，欢迎使用 QkMart。 您上次登录的时间是 {{ admin_auth()->lastTime->format('Y-m-d H:i:s') }} ，IP 是 {{ admin_auth()->lastIp }}</p>
</div>