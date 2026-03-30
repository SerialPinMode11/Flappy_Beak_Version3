@extends('layouts.public-site')

@section('title', 'Privacy Policy — JM Casabar Mini Farm')

@push('styles')
<style>.scroll-smooth { scroll-behavior: smooth; }</style>
@endpush

@section('content')
@include('partials.privacy-content', ['privacyCtaHomeUrl' => url('/')])
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
</script>
@endpush
