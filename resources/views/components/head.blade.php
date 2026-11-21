{{--
  Contratto Filament 5.x — Configuring your layout:
  https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
  @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
--}}
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @head
    <style>[x-cloak] { display: none !important; }</style>
    <script>
        if (typeof Storage !== 'undefined' && localStorage.getItem('dark_mode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
    @filamentStyles
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
</head>
