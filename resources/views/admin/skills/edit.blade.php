<x-admin-layout title="Edit Skill">
    <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
        @method('PUT')
        @include('admin.skills._form')
    </form>
</x-admin-layout>
