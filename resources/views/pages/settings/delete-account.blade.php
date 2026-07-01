@extends('layouts.app.layout')

@section('title', 'Delete Account')

@section('content')
    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <flux:button variant="danger" type="submit"
                onclick="return confirm('{{ __('Are you sure you want to delete your account?') }}')"
            >
                {{ __('Delete Account') }}
            </flux:button>
        </form>
    </x-pages::settings.layout>
@endsection
