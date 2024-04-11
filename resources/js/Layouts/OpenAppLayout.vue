<script setup>
import { ref } from 'vue';
const showingNavigationDropdown = ref(false);


</script>

<template>

    <notifications position="top right"/>

    <main>
        <slot />
    </main>


</template>

<script>
import {mapGetters} from "vuex";

export default {

    computed: {
        ...mapGetters(['getErrors', 'cartTotalCount', 'cartProducts']),

    },

    methods:{

    }
}
</script>
<style lang="scss">

</style>
