<x-admin-layout title="New Experience">
    <form method="POST" action="{{ route('admin.experiences.store') }}">
        @include('admin.experiences._form')
    </form>
</x-admin-layout>
