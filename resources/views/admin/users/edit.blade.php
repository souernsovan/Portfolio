<x-admin-layout title="Edit User">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @method('PUT')
        @include('admin.users._form')
    </form>
</x-admin-layout>
