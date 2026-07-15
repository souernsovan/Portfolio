<x-admin-layout title="New Testimonial">
    <form method="POST" action="{{ route('admin.testimonials.store') }}">
        @include('admin.testimonials._form')
    </form>
</x-admin-layout>
