@if ($user->hasUnverifiedEmail != true)
    <div>
        <flux:text class="mt-4">
            {{ __('Your email address is unverified.') }}

            <form method="POST" action="{{ route('profile.verification.resend') }}" class="inline">
                @csrf

                <flux:button type="submit" variant="ghost" class="text-sm cursor-pointer">
                    {{ __('Click here to re-send the verification email.') }}
                </flux:button>
            </form>
        </flux:text>

        @if (session('status') === 'verification-link-sent')
            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                {{ __('A new verification link has been sent to your email address.') }}
            </flux:text>
        @endif
    </div>
@endif
