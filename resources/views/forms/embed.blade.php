@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">{{ $form->name }}</h1>
                    
                    <x-forms.form :form="$form" />
                </div>
            </div>
        </div>
    </div>
@endsection