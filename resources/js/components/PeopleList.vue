<template>
    <div>
        <div class="flex items-center mb-3">
            <input
                    @input="submit"
                    autofocus
                    type="text"
                    name="q"
                    v-model="q"
                    placeholder="Recherche par Nom Prénom"
                    class="card-sm w-full">
        </div>

        <div v-if="results">
            <div class="flex flex-wrap items-center justify-between mb-3">
                <h2 class="text-grey font-normal text-lg"
                    v-text="'Résultats pour : ' + q + ' (' + results.length + ')'">
                </h2>

                <button @click.prevent="$modal.show('new-person', { input: q })"
                        class="button ml-auto">Créer la personne</button>
            </div>

            <div v-if="results.length > 0" class="w-full flex-1">
                <div v-for="(result, index) in results" class="mb-3">
                    <person-card :person="result" v-show="visible(index, step)"></person-card>
                </div>

                <div
                    class="flex items-center w-full justify-around"
                    v-show="results.length > perPage">

                    <button
                        class="text-center text-grey-darker text-sm focus:outline-none bg-white rounded-lg px-5 py-2"
                        :class="step > 1 ? 'cursor-pointer' : 'opacity-50 cursor-default'"
                        @click="decreaseStep"
                        v-text="'Précédent'"></button>

                    <button
                        class="text-center text-grey-darker text-sm focus:outline-none bg-white rounded-lg px-5 py-2"
                        :class="step * perPage < results.length ? 'cursor-pointer' : 'opacity-50 cursor-default'"
                        @click="increaseStep"
                        v-text="'Suivant'"></button>
                </div>
            </div>

            <div class="w-full flex-1" v-else>
                <div class="card-sm my-3">
                    <span class="font-normal no-underline text-black">
                        Aucun résultat
                    </span>
                </div>
            </div>
        </div>

        <div v-else>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-grey font-normal text-lg">Récemment ajouté</h2>

                <div>
                    <button @click="$modal.show('search-person', { input: '' })"
                            class="button ml-3"
                            :class="lastPeople.length ? '' : 'opacity-50 cursor-not-allowed'"
                            :disabled="! lastPeople.length">Rechercher</button>

                    <button @click.prevent="$modal.show('new-person', { input: '' })"
                            class="button ml-3">Créer une personne</button>
                </div>
            </div>

            <div v-if="lastPeople.length">
                <div v-for="person in lastPeople">
                    <person-card :person="person"></person-card>
                </div>
            </div>
            <div v-else>
                <div class="card-sm mb-3">Ajouter une nouvelle personne</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                q: '',
                results: '',
                lastPeople: [],
                step: 1,
                perPage: 5
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            submit() {
                axios.get(location.pathname + '/search?q=' + this.q)
                    .then(response => {
                        this.results = response.data;
                        this.step = 1;
                    });
            },

            fetch() {
                axios.get(`${location.pathname}/people`).then(this.refresh);
            },

            refresh({ data }) {
                this.lastPeople = data;
                this.step = 1;
            },

            visible(index, step) {
                return index < step * this.perPage && index >= (step - 1) * this.perPage;
            },

            decreaseStep() {
                if (this.step > 1){
                    return this.step--;
                }

                return step;
            },

            increaseStep() {
                if (this.step * this.perPage < this.results.length) {
                    return this.step++;
                }

                return step;
            }
        }
    }
</script>
