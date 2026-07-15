<x-admin-layout title="New Skill">
    <form method="POST" action="{{ route('admin.skills.store') }}">
        @include('admin.skills._form')
    </form>
</x-admin-layout>
