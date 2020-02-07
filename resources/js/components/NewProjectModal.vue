<template>
    <modal name="new-project" classes="p-10 bg-white rounded-lg" height="auto">
        <h1
            class="font-normal mb-10 text-center text-2xl"
            v-text="editable ? 'Éditer la Généalogie' : 'Nouvelle Généalogie'"></h1>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <label for="title" class="text-sm block mb-2">Titre</label>
                <input type="text"
                       v-focus="focused" @focus="focused = true" @blur="focused = false"
                       name="title"
                       class="border p-2 text-sm block w-full rounded"
                       :class="errors.title ? 'border-red' : 'border-grey-light'"
                       v-model="form.title">
                <span class="text-sm italic text-red" v-if="errors.title" v-text="errors.title[0]"></span>
            </div>

            <div class="mb-4">
                <label for="description" class="text-sm block mb-2">Description</label>
                <textarea name="description"
                          class="border border-grey-light p-2 text-sm block w-full rounded"
                          rows="7"
                          v-model="form.description"
                ></textarea>
            </div>

            <footer class="flex justify-end">
                <button class="button is-outlined mr-4" @click.prevent="$modal.hide('new-project')">Annuler</button>
                <button
                    class="button"
                    v-text="editable ? 'Éditer la Généalogie' : 'Créer la Généalogie'"></button>
            </footer>
        </form>
    </modal>
</template>

<script>
    import { focus } from 'vue-focus';

    export default {
        directives: { focus: focus },
        props: ['project'],

        data() {
            return {
                focused: true,
                editable: this.project,
                form: {
                    title: this.project ? this.project.title : '',
                    description: this.project ? this.project.description : ''
                },
                errors: {}
            }
        },

        methods: {
            async submit() {
                try {
                    if (this.editable) {
                        axios.patch(location.pathname, this.form)
                            .then(response => location = response.data.message)
                            .catch((error) => this.errors = error.response.data.errors);
                    } else {
                        location = (await axios.post('/projects', this.form)).data.message;
                    }
                } catch (error) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
</script>
