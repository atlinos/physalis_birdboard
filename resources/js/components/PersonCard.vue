<template>
    <div class="card-sm mb-3">
        <a :href="path(person)"
           class="font-normal no-underline text-black">
            {{ person.name + ' ' + person.firstname }}
        </a>
    </div>
</template>

<script>
    export default {
        props: ['person'],

        methods: {
            path(val) {
                return '/projects/' + val.project_id + '/persons/' + val.id;
            }
        }
    }
</script>