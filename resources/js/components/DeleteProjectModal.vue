<template>
    <modal name="delete-project" @before-open="beforeOpen" classes="p-10 bg-white rounded-lg" height="auto">
        <h1 class="font-normal mb-8 text-center text-2xl">
            Supprimer une Généalogie
        </h1>

        <div class="text-center mb-16">
            Voulez-vous vraiment supprimer votre généalogie : <strong>{{ this.project.title }}</strong> ?
        </div>

        <form @submit.prevent="submit">
            <footer class="flex justify-center">
                <button class="button is-outlined-danger mr-4" @click.prevent="$modal.hide('delete-project')">Annuler</button>
                <button class="button danger">Supprimer la Généalogie</button>
            </footer>
        </form>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                project: ''
            }
        },

        methods: {
            beforeOpen(event) {
                this.project = event.params.project;
            },

            async submit() {
                axios.delete('/projects/' + this.project.id)
                    .then(response => location = response.data.message)
            }
        }
    }
</script>