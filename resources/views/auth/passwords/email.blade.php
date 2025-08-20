<!-- resources/views/auth/passwords/email.blade.php -->

<h1>Quên mật khẩu</h1>

@if (session('status'))
    <p style="color: green">{{ session('status') }}</p>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Gửi link đặt lại mật khẩu</button>
</form>