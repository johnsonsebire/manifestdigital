<x-layouts.frontend transparentHeader="false" preloader="none">
    <x-slot:title>Our Projects | Manifest Digital Portfolio</x-slot:title>
@push('styles')
    @vite(['resources/css/projects.css'])
@endpush
    <x-projects.hero />
    <x-projects.filters-section />
    <x-projects.grid-section />
    <x-projects.stats-section /> 
</x-layouts.frontend>