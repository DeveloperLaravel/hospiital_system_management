<x-guest-layout>
        <!-- Logo -->
        <div class="mb-6">
            <a href="/">
                <x-application-logo class="w-24 h-24 fill-current text-indigo-600 shadow-lg rounded-full p-2 bg-white" />
            </a>
        </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6 rtl">
                @csrf

                <!-- Email Address -->
                <div class="relative">
                    <x-input-label for="email" :value="__('البريد الإلكتروني')" class="font-semibold text-gray-700 text-right" />
                    <div class="mt-1 relative">
                        <x-text-input id="email" class="block w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-right"
                                      type="email"
                                      name="email"
                                      :value="old('email')"
                                      required
                                      autofocus
                                      autocomplete="username"
                                      placeholder="example@domain.com"/>
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0H4m4 0v8m0-8V4"/>
                            </svg>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 text-right" />
                </div>

                <!-- Password -->
                <div class="relative">
                    <x-input-label for="password" :value="__('كلمة المرور')" class="font-semibold text-gray-700 text-right" />
                    <div class="mt-1 relative">
                        <x-text-input id="password" class="block w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-right"
                                      type="password"
                                      name="password"
                                      required
                                      autocomplete="current-password"
                                      placeholder="••••••••"/>
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 cursor-pointer" onclick="togglePassword()">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 text-right" />

                    <!-- Password strength -->
                    <div id="password-strength" class="mt-2 h-2 w-full rounded bg-gray-200 overflow-hidden">
                        <div class="h-full w-0 bg-green-500 transition-all"></div>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center space-x-2 rtl:space-x-reverse text-right">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="text-sm text-gray-600">{{ __('تذكرني') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-800 underline" href="{{ route('password.request') }}">
                            {{ __('نسيت كلمة المرور؟') }}
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <div>
                    <x-primary-button class="w-full py-2 text-lg font-semibold">
                        {{ __('تسجيل الدخول') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Welcome Message -->
            <p class="mt-6 text-gray-500 text-sm text-right">
                مرحبًا بك في نظام مستشفى الشروق
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.add('text-indigo-600');
            } else {
                password.type = 'password';
                eyeIcon.classList.remove('text-indigo-600');
            }
        }

        const passwordInput = document.getElementById('password');
        const strengthBar = document.querySelector('#password-strength div');
        passwordInput.addEventListener('input', () => {
            const val = passwordInput.value;
            let strength = 0;
            if (val.length >= 6) strength += 1;
            if (/[A-Z]/.test(val)) strength += 1;
            if (/[0-9]/.test(val)) strength += 1;
            if (/[\W]/.test(val)) strength += 1;

            const width = (strength / 4) * 100;
            strengthBar.style.width = width + '%';
            strengthBar.className = `h-full transition-all ${width < 50 ? 'bg-red-500' : width < 75 ? 'bg-yellow-400' : 'bg-green-500'}`;
        });
    </script>
</x-guest-layout>
