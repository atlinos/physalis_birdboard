<template>
    <modal name="delete-person" @before-open="beforeOpen" classes="p-10 bg-white rounded-lg" height="auto">
        <h1 class="font-normal mb-8 text-center text-2xl">
            Supprimer une Personne
        </h1>

        <div class="text-center mb-16">
            Voulez-vous vraiment supprimer :
            <strong>{{ this.person.firstname }} {{ this.person.name}}</strong> ?
        </div>

        <form @submit.prevent="submit">
            <footer class="flex justify-center">
                <button class="button is-outlined-danger mr-4" @click.prevent="$modal.hide('delete-person')">Annuler</button>
                <button class="button danger">Supprimer la Personne</button>
            </footer>
        </form>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                person: ''
            }
        },

        methods: {
            beforeOpen(event) {
                this.person = event.params.person;
            },

            async submit() {
                axios.delete(location.pathname)
                    .then(response => location = response.data.message)
            }
        }
    }
</script>