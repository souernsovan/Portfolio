@php
    $barId = $id ?? 'category-bars';

    // Fixed categorical order — validated with scripts/validate_palette.js against both
    // the light (#fcfcfb) and dark (#0a0a0a) surfaces using this project's dataviz skill.
    // Same 600-shade passes both modes, so no separate dark: step is needed.
    $palette = [
        ['fill' => 'bg-emerald-600', 'track' => 'bg-emerald-600/15'],
        ['fill' => 'bg-blue-600', 'track' => 'bg-blue-600/15'],
        ['fill' => 'bg-amber-600', 'track' => 'bg-amber-600/15'],
        ['fill' => 'bg-violet-600', 'track' => 'bg-violet-600/15'],
        ['fill' => 'bg-rose-600', 'track' => 'bg-rose-600/15'],
        ['fill' => 'bg-cyan-600', 'track' => 'bg-cyan-600/15'],
        ['fill' => 'bg-lime-600', 'track' => 'bg-lime-600/15'],
        ['fill' => 'bg-fuchsia-600', 'track' => 'bg-fuchsia-600/15'],
    ];
@endphp

<div id="{{ $barId }}" class="space-y-5">
    @foreach($bars as $bar)
        @php $colors = $palette[($bar['colorIndex'] ?? 0) % count($palette)]; @endphp
        <div>
            <div class="mb-1.5 flex items-baseline justify-between text-sm">
                <span class="flex items-center gap-2">
                    <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $colors['fill'] }}"></span>
                    <span class="text-heading font-medium">{{ $bar['label'] }}</span>
                </span>
                <span class="text-muted">
                    <span class="text-heading font-semibold">{{ $bar['value'] }}%</span>
                    avg &middot; {{ $bar['count'] }} skill{{ $bar['count'] === 1 ? '' : 's' }}
                </span>
            </div>
            <div class="h-2.5 w-full overflow-hidden rounded-full {{ $colors['track'] }}">
                <div class="category-bar-fill h-full rounded-full {{ $colors['fill'] }}" data-value="{{ $bar['value'] }}" style="width: 0%"></div>
            </div>
        </div>
    @endforeach
</div>

<script>
    (function () {
        const container = document.getElementById(@json($barId));
        if (!container) return;
        requestAnimationFrame(() => {
            container.querySelectorAll('.category-bar-fill').forEach((fill) => {
                fill.style.transition = 'width 0.8s cubic-bezier(0.16, 1, 0.3, 1)';
                fill.style.width = fill.dataset.value + '%';
            });
        });
    })();
</script>
