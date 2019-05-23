<template>
    <modal name="new-person" classes="p-10 bg-white rounded-lg" height="auto">
        <h1 class="font-normal mb-10 text-center text-2xl" v-if="editable">
            Modifier {{ form.firstname }} {{ form.name }}
        </h1>

        <h1 class="font-normal mb-10 text-center text-2xl" v-else>
            Créer une Nouvelle Personne
        </h1>

        <form @submit.prevent="submit">
<!--            <div class="flex items-center">-->
                <div class="flex items-center">
                    <div class="flex-1 mr-2 mb-4">
                        <label for="name" class="text-sm block mb-2">Nom</label>
                        <input type="text"
                               name="name"
                               class="border border-grey p-2 text-sm block w-full rounded text-grey"
                               :class="errors.name ? 'border-red' : 'border-grey'"
                               v-model="form.name">
                        <span class="text-sm italic text-red" v-if="errors.name" v-text="errors.name[0]"></span>
                    </div>

                    <div class="flex-1 ml-2 mb-4">
                        <label for="firstname" class="text-sm block mb-2">Prénom</label>
                        <input type="text"
                               name="firstname"
                               class="border border-grey p-2 text-sm block w-full rounded text-grey"
                               :class="errors.firstname ? 'border-red' : 'border-grey'"
                               v-model="form.firstname">
                        <span class="text-sm italic text-red" v-if="errors.firstname" v-text="errors.firstname[0]"></span>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex-1 mr-2 mb-4">
                        <label for="gender" class="text-sm block mb-2">Genre</label>
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

            <div class="mb-4 w-1/4">
                <label for="death_age" class="text-sm block mb-2">Âge du Décès</label>
                <input type="text"
                       name="death_age"
                       class="border border-grey p-2 text-sm block w-full rounded text-grey"
                       v-model="form.death_age">
            </div>

            <footer class="flex justify-end">
                <button class="button is-outlined mr-4" @click="$modal.hide('new-person')">Annuler</button>
                <button class="button"
                        v-text="editable ? 'Valider les Modifications' : 'Créer la Personne'"></button>
            </footer>
        </form>
    </modal>
</template>

<script>
    export default {
        props: ['person'],

        data() {
            return {
                editable: this.person,
                form: {
                    name: this.person ? this.person.name : '',
                    firstname: this.person ? this.person.firstname : '',
                    gender: this.person ? this.person.gender : '',
                    birthdate: this.person ? this.person.birthdate : '',
                    birthplace: this.person ? this.person.birthplace : '',
                    profession: this.person ? this.person.profession : '',
                    death_date: this.person ? this.person.death_date : '',
                    death_place: this.person ? this.person.death_place : '',
                    death_age: this.person ? this.person.death_age : ''
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
                        location = (await axios.post(location.pathname + '/persons', this.form)).data.message;
                    }
                } catch (error) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
</script>