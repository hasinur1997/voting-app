<script setup>
import { defineProps } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

    const props = defineProps({
        poll: Object
    });

    const deletePoll = async (pollId) => {
        if (confirm('Are you sure you want to delete this poll?')) {
            try {
            await axios.delete(route('admin.polls.destroy', pollId));
            // Redirect to the list page or show success
            window.location.href = route('admin.polls.index');
            } catch (error) {
            console.error(error);
            }
        }
    };
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Poll
            </h2>
        </template>

        <div class="flex items-start justify-center min-h-screen bg-gray-100">
            <div class="max-w-2xl w-full p-6 bg-white shadow-lg rounded-xl border border-gray-200 mt-16">
            <Link :href="route('polls.index')" class="text-blue-600 hover:underline">← Back to Polls</Link>
            <!-- Poll Title -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">{{ poll.question }}</h2>

            <!-- Poll Options -->
            <div class="space-y-3">
                <div
                v-for="option in poll.options"
                :key="option.id"
                class="flex items-center justify-between p-4 border rounded-lg shadow-sm bg-gray-50 hover:bg-gray-100 transition"
                >
                <span class="text-gray-700 font-medium">{{ option.option_text }}</span>

                <!-- Vote Count Badge -->
                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                    {{ option.votes }} Votes
                </span>
                </div>
            </div>
    </div>
  </div>
    </AuthenticatedLayout>
</template>

<style scoped>
    .poll-show {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    }

    .poll-option {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    }

    button {
    width: 100%;
    }
</style>
