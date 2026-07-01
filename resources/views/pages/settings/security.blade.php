@extends('layouts.app.layout')

@section('title', 'Security')

@section('content')
    <x-pages::settings.layout :heading="__('Security Settings')" :subheading="__('')">
        <div class="flex items-start max-md:flex-col">
            <div class="me-10 w-full pb-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('security.update-password') }}" class="flex items-center px-3 py-2 rounded relative
                        hover:bg-gray-200 dark:hover:bg-gray-600" wire:navigate>
                            <div class="flex items-center gap-x-3">
                                <flux:icon name="lock-closed" />
                                <span class="sidebar-text">Change Password</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('security.verify-email') }}" class="flex items-center px-3 py-2 rounded relative
                        hover:bg-gray-200 dark:hover:bg-gray-600" wire:navigate>
                            <div class="flex items-center gap-x-3">
                                <flux:icon name="envelope" />
                                <span class="sidebar-text">Verify Email</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('security.enable-2fa') }}" class="flex items-center px-3 py-2 rounded relative
                        hover:bg-gray-200 dark:hover:bg-gray-600" wire:navigate>
                            <div class="flex items-center gap-x-3">
                                <flux:icon name="device-phone-mobile" />
                                <span class="sidebar-text">Enable Two-Factor Authentication</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </x-pages::settings.layout>
@endsection
