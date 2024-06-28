<script setup>
import CalcForm from "@/Components/Calc/CalcForm.vue";
import CalcTableForm from "@/Components/Calc/CalcTableForm.vue";
</script>
<template>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item ">
            <a class="nav-link rounded-0"
               @click="tab=0"
               v-bind:class="{'active':tab===0}"
               aria-current="page" href="javascript:void(0)">Версия 1</a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-0"
               @click="tab=1"
               v-bind:class="{'active':tab===1}"
               href="javascript:void(0)">Версия 2</a>
        </li>
    </ul>

    <CalcForm v-if="tab===0"/>
    <CalcTableForm v-if="tab===1"/>
</template>
<script>
export default {
    data(){
        return {
            tab:0
        }
    }
}
</script>
