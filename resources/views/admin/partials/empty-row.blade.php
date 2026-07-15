<tr>
    <td colspan="{{ $colspan }}" class="px-4 py-12 text-center">
        <p class="text-muted text-sm">{{ $message }}</p>
        @isset($ctaRoute)
            <a href="{{ $ctaRoute }}" class="link-accent mt-2 inline-block text-sm font-medium">{{ $ctaLabel ?? 'Add the first one' }} &rarr;</a>
        @endisset
    </td>
</tr>
