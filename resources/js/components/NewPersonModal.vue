<template>
    <modal name="new-person" classes="p-10 bg-white rounded-lg" height="auto">
        <h1 class="font-normal mb-10 text-center text-2xl">Créer une Nouvelle Personne</h1>

        <form @submit.prevent="submit">
<!--            <div class="flex items-center">-->
                <div class="flex items-center">
                    <div class="flex-1 mr-2 mb-4">
                        <label for="name" class="text-sm block mb-2">Nom</label>
                        <input type="text"
                               name="name"
                               class="border border-grey p-2 text-sm block w-full rounded text-grey"
                               v-model="form.name">
                    </div>

                    <div class="flex-1 ml-2 mb-4">
                        <label for="firstname" class="text-sm block mb-2">Prénom</label>
                        <input type="text"
                               name="firstname"
                               class="border border-grey p-2 text-sm block w-full rounded text-grey"
                               v-model="form.firstname">
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex-1 mr-2 mb-4">
                        <label for="gender" class="text-sm block mb-2">Genre</label>
<!--                        <select name="gender" id="gender"-->
<!--                                class="border border-grey p-2 text-sm block w-full rounded text-grey">-->
<!--                            <option value="M">Masculin</option>-->
<!--                            <option value="F">Féminin</option>-->
<!--                            <option value="I">Inconnu</option>-->
<!--                        </select>-->
                        <div class="flex item-center block p-2">
                            <input
                                class="border border-grey ml-2 text-sm"
                                type="radio" name="gender" value="M" id="M">
                            <label for="M" class="text-xs text-grey font-normal ml-2">Masculin</label>
                            <input
                                class="border border-grey ml-2 text-sm"
                                type="radio" name="gender" value="F" id="F">
                            <label for="F" class="text-xs text-grey font-normal ml-2">Féminin</label>
                            <input
                                class="border border-grey ml-2 text-sm"
                                type="radio" name="gender" value="I" id="I">
                            <label for="I" class="text-xs text-grey font-normal ml-2">Inconnu</label>
                        </div>
                    </div>

                    <div class="flex-1 ml-2 mb-4">
                        <label for="profession" class="text-sm block mb-2">Profession</label>
                        <input type="text"
                               name="profession"
                               class="border border-grey p-2 text-sm block w-full rounded text-grey"
                               v-model="form.profession">
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex-1 mr-2 mb-4">
                        <label for="birthdate" class="text-sm block mb-2">Date de Naissance</label>
                        <input type="date"
                               name="birthdate"
                               class="border border-grey p-2 text-sm block w-full rounded text-grey"
                               v-model="form.birthdate">
                    </div>

                    <div class="flex-1 ml-2 mb-4">
                        <label for="birthplace" class="text-sm block mb-2">Lieu de Naissance</label>
                        <input type="text"
                               name="birthplace"
                               class="border border-grey p-2 text-sm block w-full rounded text-grey"
                               v-model="form.birthplace">
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex-1 mr-2 mb-4">
                        <label for="death_date" class="text-sm block mb-2">Date de Décès</label>
                        <input type="date"
                               name="death_date"
                               class="border border-grey p-2 text-sm block w-full rounded text-grey"
                               v-model="form.death_date">
                    </div>

                    <div class="flex-1 ml-2 mb-4">
                        <label for="death_place" class="text-sm block mb-2">Lieu de Décès</label>
                        <input type="text"
                               name="death_place"
                               class="border border-grey p-2 text-sm block w-full rounded text-grey"
                               v-model="form.death_place">
                    </div>
                </div>
<!--                <div class="mb-4">-->
<!--                    <label for="title" class="text-sm block mb-2">Titre</label>-->
<!--                    <input type="text"-->
<!--                           name="title"-->
<!--                           class="border p-2 text-sm block w-full rounded"-->
<!--                           :class="errors.title ? 'border-red' : 'border-grey-light'"-->
<!--                           v-model="form.title">-->
<!--                    <span class="text-sm italic text-red" v-if="errors.title" v-text="errors.title[0]"></span>-->
<!--                </div>-->

<!--                <div class="mb-4">-->
<!--                    <label for="description" class="text-sm block mb-2">Description</label>-->
<!--                    <textarea name="description"-->
<!--                              class="border border-grey-light p-2 text-sm block w-full rounded"-->
<!--                              rows="7"-->
<!--                              v-model="form.description"-->
<!--                    ></textarea>-->
<!--                </div>-->
<!--            </div>-->

            <div class="mb-4 w-1/4">
                <label for="death_age" class="text-sm block mb-2">Âge du Décès</label>
                <input type="text"
                       name="death_age"
                       class="border border-grey p-2 text-sm block w-full rounded text-grey"
                       v-model="form.death_age">
            </div>

            <footer class="flex justify-end">
                <button class="button is-outlined mr-4" @click="$modal.hide('new-person')">Annuler</button>
                <button class="button">Créer la Personne</button>
            </footer>
        </form>
    </modal>
</template>

<script>
    export default {
        props: ['project'],

        data() {
            return {
                form: {
                    name: '',
                    firstname: '',
                    gender: '',
                    birthdate: '',
                    birthplace: '',
                    profession: '',
                    death_date: '',
                    death_place: '',
                    death_age: ''
                }
            }
        },

        methods: {
            async submit() {
                try {
                    // if (this.editable) {
                    //     await axios.patch('/projects/' + this.project.id, this.form);
                    // } else {
                        location = (await axios.post('/projects/' + this.project.id + '/persons', this.form)).data.message;
                    // }
                } catch (error) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
</script>