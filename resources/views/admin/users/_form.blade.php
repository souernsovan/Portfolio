@csrf

<div class="space-y-5">
    <div>
        <label for="name" class="text-muted mb-1.5 block text-sm">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        @error('name')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="email" class="text-muted mb-1.5 block text-sm">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required
            class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        @error('email')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="password" class="text-muted mb-1.5 block text-sm">
                Password @if(isset($user)) <span class="text-faint">(leave blank to keep current)</span> @endif
            </label>
            <input type="password" name="password" id="password" {{ isset($user) ? '' : 'required' }} autocomplete="new-password"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            @error('password')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="password_confirmation" class="text-muted mb-1.5 block text-sm">Confirm password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" {{ isset($user) ? '' : 'required' }} autocomplete="new-password"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        </div>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary rounded-lg px-6 py-3 text-sm font-semibold">
            Save
        </button>
        <a href="{{ route('admin.users.index') }}" class="border-app text-body rounded-lg border px-6 py-3 text-sm font-semibold hover:border-neutral-400 dark:hover:border-white/30">
            Cancel
        </a>
    </div>
</div>
