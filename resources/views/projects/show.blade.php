@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal no-underline">
                    Mes Généalogies
                </a> / {{ $project->title }}
            </p>

            <a href="/projects/create"
               @click.prevent="$modal.show('new-project')"
               class="button">Éditer la Généalogie</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-grey font-normal text-lg mb-3">Dernières Personnes Ajoutées</h2>

                    @forelse($project->persons as $person)
                        <div class="card mb-3">
                            {{ $person->firstname . ' ' . $person->name }}
                        </div>
                    @empty
                        <div class="card mb-3">Ajouter une nouvelle personne</div>
                    @endforelse
                </div>

                <div>
                    <h2 class="text-grey font-normal text-lg mb-3">Notes</h2>

                    <div class="card w-full" style="min-height: 200px">Lorem ipsum.</div>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>

    <new-project-modal :project="{{ $project }}"></new-project-modal>
@endsection