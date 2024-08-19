<x-guest-layout>
    <!-- حالة الجلسة -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="padding: 10px">
        @csrf

        <!-- عنوان البريد الإلكتروني -->
        <div>
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- كلمة المرور -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('كلمة المرور')" />

            <x-text-input id="password" class="block mt-1 w-full pr-10"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <!-- Eye icon to toggle password visibility -->
            <span toggle="#password" class="absolute right-3 top-10 cursor-pointer">
                <i id="togglePassword" class="fa fa-eye text-gray-500"></i>
            </span>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- تذكرني -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">

            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('هل نسيت كلمة المرور؟') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('تسجيل الدخول') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Toggle Password Visibility Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</x-guest-layout>
