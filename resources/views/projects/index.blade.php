@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-grey text-sm font-normal">Mes Généalogies</h2>

            <a href="/projects/create"
               @click.prevent="$modal.show('new-project')"
               class="button">Nouvelle Généalogie</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div>Aucun projet généalogique encore créé.</div>
        @endforelse
    </main>

    <new-project-modal></new-project-modal>
@endsection