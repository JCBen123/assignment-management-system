@extends('layouts.app.layout')

@section('title', 'Personal Info')

@section('content')
    <x-pages::settings.layout :heading="__('Personal Info')" :subheading="__('Update your name and email address')">
        <form method="POST" action="{{ route('personal-info.update') }}" class="my-6 w-full space-y-6">
            @csrf
            @method('PUT')

            <flux:input name="name" :label="__('Name')" type="text" autofocus autocomplete="name"
                value="{{ old('name', $user->name) }}" required />

            <flux:input name="email" :label="__('Email')" type="email" autocomplete="email"
                value="{{ old('email', $user->email) }}" disabled />

            <div class="flex items-center gap-6">
                <flux:button variant="primary" type="submit" class="cursor-pointer" data-test="update-profile-button">
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
