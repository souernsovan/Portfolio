<x-admin-layout title="New Project">
    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @include('admin.projects._form')
    </form>
</x-admin-layout>
