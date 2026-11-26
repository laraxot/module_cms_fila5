{{--
  Contratto Filament 5.x — Configuring your layout:
  https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
<<<<<<< .merge_file_18iQ14
=======

  Ordine obbligatorio a fine <body>:
  1. @livewire('notifications') — flash Filament (sempre, non solo per utenti autenticati)
  2. @filamentScripts — OBBLIGATORIO (JS Filament/Livewire per componenti FO)
  3. @vite JS del tema
>>>>>>> .merge_file_NGRgPB

  @livewireScripts non serve: config('livewire.inject_assets') = true.
  @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
--}}
@livewire('notifications')

@filamentScripts
@vite(['resources/js/app.js'], 'themes/'.$pubTheme)

@stack('scripts')
@yield('scripts')
