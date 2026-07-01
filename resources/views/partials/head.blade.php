<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title : '' }}
</title>

<link rel="icon" href="{{ asset('storage/logo/ams-light.png') }}" media="(prefers-color-scheme: light)">
<link rel="icon" href="{{ asset('storage/logo/ams-dark.png') }}" media="(prefers-color-scheme: dark)">
<link rel="apple-touch-icon" href="{{ asset('storage/logo/ams-light.png') }}">

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
