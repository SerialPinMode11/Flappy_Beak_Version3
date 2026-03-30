@extends('layouts.public-site')

@section('title', 'Privacy Policy — ' . ($publicContent['store_name'] ?? 'JM Casabar Mini Farm'))

@push('styles')
<style>
    .scroll-smooth { scroll-behavior: smooth; }
</style>
@endpush

@section('content')
@include('partials.privacy-content', ['privacyCtaHomeUrl' => route('home')])
@endsection

@push('scripts')
<script>
document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        var target = document.querySelector(this.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
window.addEventListener('scroll', function () {
    var sections = document.querySelectorAll('section[id]');
    var navLinks = document.querySelectorAll('a[href^="#"]');
    var current = '';
    sections.forEach(function (section) {
        if (scrollY >= (section.offsetTop - 200)) current = section.getAttribute('id');
    });
    navLinks.forEach(function (link) {
        link.classList.remove('text-forest', 'font-semibold');
        link.classList.add('text-stone-500');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.remove('text-stone-500');
            link.classList.add('text-forest', 'font-semibold');
        }
    });
});
</script>
@endpush
