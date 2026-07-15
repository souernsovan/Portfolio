@php
    $themeStorageKey = 'theme:' . ($scope ?? 'site');
@endphp
<script>
    (function () {
        var storageKey = @json($themeStorageKey);
        var stored = localStorage.getItem(storageKey);
        var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        var isDark = stored ? stored === 'dark' : prefersDark;
        document.documentElement.classList.toggle('dark', isDark);

        window.__toggleTheme = function () {
            var isNowDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem(storageKey, isNowDark ? 'dark' : 'light');
        };
    })();
</script>
