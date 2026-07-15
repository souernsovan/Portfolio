<x-admin-layout title="Profile">
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="text-muted mb-1.5 block text-sm">Profile photo</label>
            <div class="flex items-center gap-5">
                <span id="avatar-preview-wrap" class="surface-2 flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full text-2xl font-semibold text-emerald-600 dark:text-emerald-300">
                    @if($profile->avatar_url)
                        <img id="avatar-preview" src="{{ $profile->avatar_url }}" alt="{{ $profile->name }}" class="h-full w-full object-cover">
                    @else
                        <img id="avatar-preview" src="" alt="" class="hidden h-full w-full object-cover">
                        <span id="avatar-preview-fallback">{{ $profile->name ? mb_strtoupper(mb_substr($profile->name, 0, 1)) : '?' }}</span>
                    @endif
                </span>
                <div>
                    <label for="avatar" class="btn-outline inline-block cursor-pointer rounded-lg px-4 py-2 text-sm font-medium">
                        Choose image
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                    </label>
                    @if($profile->avatar_url)
                        <label class="text-muted mt-2 flex items-center gap-2 text-sm">
                            <input type="checkbox" name="remove_avatar" value="1" class="border-app rounded bg-transparent text-red-600 focus:ring-red-500/50 dark:text-red-400">
                            Remove current photo
                        </label>
                    @endif
                    @error('avatar')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    <p class="text-faint mt-1 text-xs">JPG, PNG or WEBP. Max 4MB.</p>
                </div>
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="name" class="text-muted mb-1.5 block text-sm">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $profile->name) }}" required
                    class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
                @error('name')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="role" class="text-muted mb-1.5 block text-sm">Role / title</label>
                <input type="text" name="role" id="role" value="{{ old('role', $profile->role) }}" required
                    class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
                @error('role')<p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="tagline" class="text-muted mb-1.5 block text-sm">Hero tagline</label>
            <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $profile->tagline) }}"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        </div>

        <div>
            <label for="about" class="text-muted mb-1.5 block text-sm">About</label>
            <textarea name="about" id="about" rows="6"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">{{ old('about', $profile->about) }}</textarea>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="email" class="text-muted mb-1.5 block text-sm">Public email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $profile->email) }}"
                    class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            </div>
            <div>
                <label for="location" class="text-muted mb-1.5 block text-sm">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location', $profile->location) }}"
                    class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            </div>
        </div>

        <div>
            <label for="resume_url" class="text-muted mb-1.5 block text-sm">Résumé URL</label>
            <input type="text" name="resume_url" id="resume_url" value="{{ old('resume_url', $profile->resume_url) }}"
                class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
        </div>

        <div class="grid gap-5 sm:grid-cols-3">
            <div>
                <label for="github_url" class="text-muted mb-1.5 block text-sm">GitHub URL</label>
                <input type="text" name="github_url" id="github_url" value="{{ old('github_url', $profile->github_url) }}"
                    class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            </div>
            <div>
                <label for="linkedin_url" class="text-muted mb-1.5 block text-sm">LinkedIn URL</label>
                <input type="text" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}"
                    class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            </div>
            <div>
                <label for="twitter_url" class="text-muted mb-1.5 block text-sm">Twitter URL</label>
                <input type="text" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $profile->twitter_url) }}"
                    class="field-input w-full rounded-lg px-4 py-2.5 text-sm">
            </div>
        </div>

        <button type="submit" class="btn-primary rounded-lg px-6 py-3 text-sm font-semibold">
            Save profile
        </button>
    </form>

    <script>
        document.getElementById('avatar')?.addEventListener('change', (event) => {
            const file = event.target.files?.[0];
            if (!file) return;

            const preview = document.getElementById('avatar-preview');
            const fallback = document.getElementById('avatar-preview-fallback');
            const reader = new FileReader();
            reader.onload = () => {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                fallback?.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>
</x-admin-layout>
