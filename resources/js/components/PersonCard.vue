<template>
    <div class="card-sm flex items-center mb-3">
        <a :href="path(person)"
           class="font-normal no-underline text-black">
            {{ person.name + ' ' + person.firstname }}
        </a>

        <div v-if="person.birthdate || person.birthplace" class="text-sm text-grey ml-3">
            <span v-text="person.gender == 'M' ? 'Né' : (person.gender == 'F' ? 'Née' : 'Né(e)')"></span>

            <span v-if="person.birthdate" v-text="' le ' + datify(person.birthdate)"></span>
            <span v-if="person.birthplace" v-text="' à ' + person.birthplace"></span>
        </div>

        <span
            v-if="(person.birthdate || person.birthplace) && (person.death_date || person.death_place)"
            class="text-sm text-grey ml-3">/</span>

        <div v-if="person.death_date || person.death_place || person.death_age" class="text-sm text-grey ml-3">
            <span v-text="person.gender == 'M' ? 'Décédé' : (person.gender == 'F' ? 'Décédée' : 'Décédé(e)')"></span>

            <span v-if="person.death_date" v-text="' le ' + datify(person.death_date)"></span>
            <span v-if="person.death_place" v-text="' à ' + person.death_place"></span>
            <span
                v-if="person.death_age"
                v-text="' à l\'âge de ' + person.death_age + ' ' + (person.death_age != 1 ? 'ans' : 'an')"
            ></span>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        props: ['person'],

        methods: {
            path(val) {
                return '/projects/' + val.project_id + '/persons/' + val.id;
            },

            datify(val) {
                return moment(String(val)).format('DD/MM/YYYY');
            }
        }
    }
</script>