@php
    $chartWidth = 600;
    $chartHeight = 220;
    $padLeft = 34;
    $padRight = 12;
    $padTop = 16;
    $padBottom = 28;
    $plotWidth = $chartWidth - $padLeft - $padRight;
    $plotHeight = $chartHeight - $padTop - $padBottom;

    $count = count($points);
    $rawMax = max(array_column($points, 'value'));
    $niceMax = max(4, (int) ceil(max(1, $rawMax) / 4) * 4);
    $stepX = $count > 1 ? $plotWidth / ($count - 1) : 0;

    $coords = collect($points)->map(function ($point, $i) use ($padLeft, $padTop, $plotHeight, $niceMax, $stepX) {
        return [
            'x' => round($padLeft + $i * $stepX, 2),
            'y' => round($padTop + $plotHeight - ($point['value'] / $niceMax) * $plotHeight, 2),
            'label' => $point['label'],
            'value' => $point['value'],
        ];
    });

    $linePath = $coords->map(fn ($c, $i) => ($i === 0 ? 'M' : 'L') . " {$c['x']} {$c['y']}")->implode(' ');
    $baseline = $padTop + $plotHeight;
    $areaPath = $linePath . " L {$coords->last()['x']} {$baseline} L {$coords->first()['x']} {$baseline} Z";

    $gridLines = [0, 0.5, 1];
    $labelEvery = max(1, (int) ceil($count / 5));
@endphp

<div class="relative">
    <svg id="{{ $id }}" viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" class="w-full" role="img" aria-label="{{ $ariaLabel ?? 'Line chart' }}" data-padl="{{ $padLeft }}" data-padr="{{ $padRight }}" data-points='@json($coords->values())'>
        {{-- Gridlines --}}
        @foreach($gridLines as $g)
            @php $gy = round($padTop + $plotHeight - $g * $plotHeight, 2); @endphp
            <line x1="{{ $padLeft }}" y1="{{ $gy }}" x2="{{ $chartWidth - $padRight }}" y2="{{ $gy }}" class="stroke-neutral-200 dark:stroke-white/10" stroke-width="1" />
            <text x="{{ $padLeft - 8 }}" y="{{ $gy + 3 }}" text-anchor="end" class="fill-neutral-400 dark:fill-neutral-500" font-size="10">{{ (int) round($g * $niceMax) }}</text>
        @endforeach

        {{-- Area + line --}}
        <path d="{{ $areaPath }}" class="fill-emerald-500/10 dark:fill-emerald-400/10" />
        <path d="{{ $linePath }}" fill="none" class="stroke-emerald-500 dark:stroke-emerald-400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />

        {{-- X-axis labels --}}
        @foreach($coords as $i => $c)
            @if($i % $labelEvery === 0 || $i === $count - 1)
                <text x="{{ $c['x'] }}" y="{{ $chartHeight - 8 }}" text-anchor="middle" class="fill-neutral-400 dark:fill-neutral-500" font-size="10">{{ $c['label'] }}</text>
            @endif
        @endforeach

        {{-- End marker with surface ring --}}
        <circle cx="{{ $coords->last()['x'] }}" cy="{{ $coords->last()['y'] }}" r="5" class="fill-white dark:fill-neutral-900" />
        <circle cx="{{ $coords->last()['x'] }}" cy="{{ $coords->last()['y'] }}" r="3.5" class="fill-emerald-500 dark:fill-emerald-400" />

        {{-- Hover layer --}}
        <line class="chart-crosshair stroke-neutral-300 dark:stroke-white/20" stroke-width="1" x1="0" x2="0" y1="{{ $padTop }}" y2="{{ $baseline }}" style="opacity:0" />
        <circle class="chart-hover-dot fill-emerald-500 dark:fill-emerald-400" r="4" style="opacity:0" />
        <rect class="chart-overlay" x="{{ $padLeft }}" y="{{ $padTop }}" width="{{ $plotWidth }}" height="{{ $plotHeight }}" fill="transparent" />
    </svg>

    <div id="{{ $id }}-tooltip" class="border-app pointer-events-none absolute z-10 -translate-x-1/2 -translate-y-[calc(100%+10px)] rounded-lg border bg-white px-3 py-1.5 text-xs whitespace-nowrap shadow-lg dark:bg-neutral-900" style="opacity:0">
        <p class="tt-label text-faint"></p>
        <p class="text-heading font-semibold"><span class="tt-value"></span> message(s)</p>
    </div>
</div>

<script>
    (function () {
        const svg = document.getElementById(@json($id));
        const tooltip = document.getElementById(@json($id . '-tooltip'));
        if (!svg || !tooltip) return;

        const points = JSON.parse(svg.dataset.points);
        const padl = parseFloat(svg.dataset.padl);
        const overlay = svg.querySelector('.chart-overlay');
        const crosshair = svg.querySelector('.chart-crosshair');
        const dot = svg.querySelector('.chart-hover-dot');
        const viewBox = svg.viewBox.baseVal;
        const stepX = points.length > 1 ? (points[points.length - 1].x - points[0].x) / (points.length - 1) : 0;

        function nearestIndex(svgX) {
            if (stepX === 0) return 0;
            const idx = Math.round((svgX - padl) / stepX);
            return Math.max(0, Math.min(points.length - 1, idx));
        }

        function handleMove(evt) {
            const rect = svg.getBoundingClientRect();
            const clientX = evt.touches ? evt.touches[0].clientX : evt.clientX;
            const scaleX = viewBox.width / rect.width;
            const scaleY = viewBox.height / rect.height;
            const svgX = (clientX - rect.left) * scaleX;
            const point = points[nearestIndex(svgX)];

            crosshair.setAttribute('x1', point.x);
            crosshair.setAttribute('x2', point.x);
            crosshair.style.opacity = 1;
            dot.setAttribute('cx', point.x);
            dot.setAttribute('cy', point.y);
            dot.style.opacity = 1;

            tooltip.style.opacity = 1;
            tooltip.style.left = (point.x / scaleX) + 'px';
            tooltip.style.top = (point.y / scaleY) + 'px';
            tooltip.querySelector('.tt-label').textContent = point.label;
            tooltip.querySelector('.tt-value').textContent = point.value;
        }

        function handleLeave() {
            crosshair.style.opacity = 0;
            dot.style.opacity = 0;
            tooltip.style.opacity = 0;
        }

        overlay.addEventListener('pointermove', handleMove);
        overlay.addEventListener('pointerleave', handleLeave);
    })();
</script>
