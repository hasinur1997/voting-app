<script setup>
import { defineProps, ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import CopyModal from '@/Components/Polls/CopyModal.vue';

const props = defineProps({ poll: Object });
const showCopyModal = ref(false);
const copyLink = ref("");

const openCopyModal = () => {
    copyLink.value = `${window.location.origin}/vote/${props.poll.slug}`;
    showCopyModal.value = true;
};

const deletePoll = () => {
    if (confirm("Are you sure you want to delete this poll?")) {
        router.delete(`/polls/${props.poll.id}`);
    }
};
</script>

<template>
    <div class="flex justify-center space-x-2">
        <!-- View Button -->
        <Link :href="route('polls.show', { poll: poll.id })"
            class="p-2 bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12m0 0a3 3 0 11-6 0 3 3 0 016 0zm7 0s-3.6 7-10 7S2 12 2 12s3.6-7 10-7 10 7 10 7z">
                </path>
            </svg>
        </Link>

        <!-- Edit Button -->
        <Link :href="route('polls.edit', { poll: poll.id })"
            class="p-2 bg-yellow-100 text-yellow-600 rounded hover:bg-yellow-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 3.487a2.25 2.25 0 113.182 3.182l-9.9 9.9a4.5 4.5 0 01-1.592 1.062l-4.486 1.795a.75.75 0 01-.972-.972l1.795-4.486a4.5 4.5 0 011.062-1.592l9.9-9.9z">
                </path>
            </svg>
        </Link>

        <!-- Delete Button -->
        <button @click="deletePoll"
            class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Share Poll -->
        <button @click="openCopyModal" class="p-2 bg-gray-100 text-gray-600 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 5l6 6m0 0l-6 6m6-6H9a6 6 0 00-6 6v1" />
            </svg>
        </button>

        <CopyModal :show="showCopyModal" :copyLink="copyLink" @close="showCopyModal = false" />
    </div>
</template>
