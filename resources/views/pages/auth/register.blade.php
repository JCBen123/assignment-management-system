<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <flux:input name="name" :label="__('Name')" :value="old('name')" type="text" required
                autofocus autocomplete="name" :placeholder="__('Full name')"
            />

            <flux:input name="email" :label="__('Email address')" :value="old('email')" type="email" required
                autocomplete="email" placeholder="email@example.com"
            />

            <flux:input name="password" :label="__('Password')" type="password" required
                autocomplete="new-password" :placeholder="__('Password')" viewable
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
            />

            <flux:input name="password_confirmation" :label="__('Confirm password')" type="password"
                required autocomplete="new-password" :placeholder="__('Confirm password')" viewable
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <u><a href="/login" wire:navigate>{{ __('Log in') }}</a></u>
        </div>

        <a href="/" class="text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400" wire:navigate>
            {{ __('Return to dashboard') }}
        </a>
    </div>
</x-layouts::auth>
