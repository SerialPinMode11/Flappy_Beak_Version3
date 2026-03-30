@extends('layouts.public-site')

@section('title', 'Frequently Asked Questions — JM Casabar Mini Farm')

@push('styles')
<style>
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    .faq-answer.active {
        max-height: 500px;
        transition: max-height 0.3s ease-in;
    }
</style>
@endpush

@section('content')
@include('partials.faq-content')
@endsection

@push('scripts')
@include('partials.faq-scripts')
@endpush
