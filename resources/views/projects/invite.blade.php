<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-4 mb-3 -ml-5 border-l-4 border-blue-light pl-4">
        Inviter un Utilisateur
    </h3>

    <form method="POST" action="{{ $project->path() . '/invitations' }}">
        @csrf

        <div class="mb-3">
            <input
                    type="email"
                    name="email"
                    class="border border-grey rounded w-full py-2 px-3"
                    placeholder="Email">
        </div>

        <button type="submit" class="button">Inviter</button>
    </form>

    @include('errors')
</div>
