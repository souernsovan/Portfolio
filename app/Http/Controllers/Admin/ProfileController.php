<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $profile = Profile::firstOrNew();

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:500'],
            'about' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:4096'],
            'remove_avatar' => ['nullable', 'boolean'],
            'resume_url' => ['nullable', 'string', 'max:2048'],
            'github_url' => ['nullable', 'string', 'max:2048'],
            'linkedin_url' => ['nullable', 'string', 'max:2048'],
            'twitter_url' => ['nullable', 'string', 'max:2048'],
        ]);

        $profile = Profile::firstOrNew();

        if ($request->hasFile('avatar')) {
            $this->deleteStoredAvatar($profile);
            $data['avatar_url'] = Storage::url($request->file('avatar')->store('avatars', 'public'));
        } elseif ($request->boolean('remove_avatar')) {
            $this->deleteStoredAvatar($profile);
            $data['avatar_url'] = null;
        }

        unset($data['avatar'], $data['remove_avatar']);

        $profile->fill($data)->save();

        return redirect()->route('admin.profile.edit')->with('status', 'Profile updated.');
    }

    private function deleteStoredAvatar(Profile $profile): void
    {
        if ($profile->avatar_url && str_starts_with($profile->avatar_url, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $profile->avatar_url));
        }
    }
}
