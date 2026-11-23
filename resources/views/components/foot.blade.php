{{--
  Contratto Filament 5.x — Configuring your layout:
  https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
<<<<<<< .merge_file_WBiOeZ

  Ordine obbligatorio a fine <body>:
  1. @livewire('notifications') — flash Filament (sempre, non solo per utenti autenticati)
  2. @filamentScripts — OBBLIGATORIO (JS Filament/Livewire per componenti FO)
  3. @vite JS del tema

  @livewireScripts non serve: config('livewire.inject_assets') = true.
<<<<<<< .merge_file_lrhbxV
--}}
@livewire('notifications')

@filamentScripts
=======
  Con :panel-assets="false" i punti 1 e 2 si saltano (siti pubblici senza componenti Filament).
=======
  @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
>>>>>>> .merge_file_8qvyli
--}}
@livewire('notifications')

<<<<<<< .merge_file_WBiOeZ
    @filamentScripts
@endif
>>>>>>> .merge_file_aKxV9J
=======
@filamentScripts
>>>>>>> .merge_file_8qvyli
@vite(['resources/js/app.js'], 'themes/'.$pubTheme)

@stack('scripts')
@yield('scripts')
