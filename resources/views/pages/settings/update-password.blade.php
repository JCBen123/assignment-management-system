@extends('layouts.app.layout')

@section('title', 'Update Password')

@section('content')
    <x-pages::settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <flux:input name="current_password" :label="__('Current password')" type="password" required
                autocomplete="current-password" viewable
            />
            <flux:input name="password" :label="__('New password')" type="password" required
                autocomplete="new-password" viewable
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
            />
            <flux:input name="password_confirmation" :label="__('Confirm password')" type="password" required
                autocomplete="new-password" viewable
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
            />

            <div class="flex items-center gap-6">
                <flux:button variant="primary" type="submit" class="cursor-pointer" data-test="update-password-button">
                    {{ __('Save') }}
                </flux:button>

                @if (session('status'))
                    <flux:text class="font-medium !text-green-600 !dark:text-green-400">
                        {{ session('status') }}
                    </flux:text>
                @endif
            </div>
        </form>
    </x-pages::settings.layout>
@endsection
