<x-admin-layout title="Edit Experience">
    <form method="POST" action="{{ route('admin.experiences.update', $experience) }}">
        @method('PUT')
        @include('admin.experiences._form')
    </form>
</x-admin-layout>
