<template>
    <div>
        <div class="flex items-center mb-3">
            <input
                    @input="submit"
                    type="text"
                    name="q"
                    v-model="q"
                    placeholder="Recherche via Nom Prénom"
                    class="card-sm w-full">
        </div>

        <div v-if="results">
            <div class="flex flex-wrap items-center justify-between">
                <h2 class="text-grey font-normal text-lg mb-3"
                    :class="results.length > 0 ? 'w-full' : ''"
                    v-text="'Résultats pour : ' + q + ' (' + results.length + ')'">
                </h2>

                <div v-if="results.length > 0" class="w-full">
                    <div v-for="(result, index) in results" class="mb-3">
                        <person-card :person="result" v-show="visible(index, step)"></person-card>
                    </div>

                    <div
                        class="flex items-center space-between bg-white rounded-lg p-1"
                        v-show="results.length > perPage">

                        <span
                            class="text-center text-grey-darker font-normal cursor-pointer w-full"
                            @click="manageStep"
                            v-text="step * perPage < results.length ? 'Voir plus de résultats' : 'Réduire les Résultats'"
                        ></span>

                        <span v-show="step > 1" class="mx-3 cursor-pointer" @click="step = 1">
                            <svg width="10" height="10" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 64 64">
                              <g>
                                <path fill="#1D1D1B" d="M28.941,31.786L0.613,60.114c-0.787,0.787-0.787,2.062,0,2.849c0.393,0.394,0.909,0.59,1.424,0.59   c0.516,0,1.031-0.196,1.424-0.59l28.541-28.541l28.541,28.541c0.394,0.394,0.909,0.59,1.424,0.59c0.515,0,1.031-0.196,1.424-0.59   c0.787-0.787,0.787-2.062,0-2.849L35.064,31.786L63.41,3.438c0.787-0.787,0.787-2.062,0-2.849c-0.787-0.786-2.062-0.786-2.848,0   L32.003,29.15L3.441,0.59c-0.787-0.786-2.061-0.786-2.848,0c-0.787,0.787-0.787,2.062,0,2.849L28.941,31.786z"/>
                              </g>
                            </svg>
                        </span>
                    </div>
                </div>

                <div v-else>
                    <button @click.prevent="$modal.show('new-person', { input: q })"
                            class="button ml-auto">Créer la Personne</button>
                </div>
            </div>

            <div class="flex-1" v-if="results.length == 0">
                <div class="card-sm my-3">
                    <span class="font-normal no-underline text-black">
                        Aucun résultat
                    </span>
                </div>
            </div>
        </div>

        <div v-else>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-grey font-normal text-lg">Récemment Ajouté</h2>

                <button @click.prevent="$modal.show('new-person', { input: '' })"
                        class="button ml-3">Créer une Personne</button>
            </div>

            <div v-if="lastPeople">
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
                perPage: 15
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
                axios.get(`${location.pathname}/persons`).then(this.refresh);
            },

            refresh({ data }) {
                this.lastPeople = data;
                this.step = 1;
            },

            visible(index, step) {
                return index < step * this.perPage;
            },

            manageStep() {
                if (this.step * this.perPage < this.results.length) {
                    return this.step++;
                }

                return this.step = 1;
            }
        }
    }
</script>