<script setup>
import { defineProps, defineEmits } from 'vue';
import PollActions from '@/Components/Polls/PollActions.vue';

defineProps({ polls: Array });
const emit = defineEmits(['delete']);
</script>

<template>
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 text-left">Poll Questions</th>
                <th class="border px-4 py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="poll in polls" :key="poll.id">
                <td class="border px-4 py-2">{{ poll.question }}</td>
                <td class="border px-4 py-2 text-center">
                    <PollActions :poll="poll" @delete="emit('delete', poll.id)" />
                </td>
            </tr>
        </tbody>
    </table>
</template>
