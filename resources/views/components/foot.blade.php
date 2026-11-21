{{--
  Contratto Filament 5.x — Configuring your layout:
  https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
  Ordine obbligatorio: notifications, @filamentScripts, poi il bundle del tema.
  @livewireScripts non serve: config('livewire.inject_assets') = true.
  @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
--}}
@livewire('notifications')

@filamentScripts
@vite(['resources/js/app.js'], 'themes/'.$pubTheme)

@stack('scripts')
@yield('scripts')
