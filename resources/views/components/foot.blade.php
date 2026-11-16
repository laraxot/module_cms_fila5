@auth
    @livewire('notifications')
@endauth

@vite(['resources/js/app.js'], 'themes/'.$pubTheme)

@stack('scripts')
@yield('scripts')
