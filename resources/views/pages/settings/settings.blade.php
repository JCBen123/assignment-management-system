@extends('layouts.app.layout')

@section('title', 'Settings')

@section('content')
    <x-pages::settings.layout
        :heading="__('Settings')"
        :subheading="__('Check your settings by clicking the options')">

        <div>
            <flux:heading size="md">Appearance</flux:heading>
            <flux:text class="mt-2 mb-4">Choose your preferred theme</flux:text>

            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun">Light</flux:radio>
                <flux:radio value="dark" icon="moon">Dark</flux:radio>
                <flux:radio value="system" icon="computer-desktop">System</flux:radio>
            </flux:radio.group>
        </div>
    </x-pages::settings.layout>
@endsection
