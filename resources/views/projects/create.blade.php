@extends('layouts.app')

@section('content')
    <form action="/projects" method="POST">
        @csrf

        <h1>Créer un nouveau projet généalogique</h1>

        <label for="title">Titre</label>
        <input type="text" name="title" placeholder="Titre">

        <label for="description">Description</label>
        <textarea name="description" rows="7"></textarea>

        <button type="submit">Créer le Projet</button>
        <a href="/projects">Annuler</a>
    </form>
@endsection