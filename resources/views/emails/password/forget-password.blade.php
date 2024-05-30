<form method="POST" action="{{ route('forget-password') }}">
    @csrf

    <label for="email">{{ __('Email') }}</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">

    <button type="submit">{{ __('Send Password Reset Link') }}</button>
</form>
