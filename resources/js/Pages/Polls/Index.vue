<script setup>
import { defineProps, ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PollTable from '@/Components/Polls/PollTable.vue';

defineProps({ polls: Array });

const deletePoll = (id) => {
    if (confirm("Are you sure you want to delete this poll?")) {
        router.delete(`/polls/${id}`);
    }
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Poll</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Create Poll Button -->
                        <Link :href="route('polls.create')" class="bg-blue-500 text-white px-4 py-2 rounded inline-block mb-4">
                            Create Poll
                        </Link>

                        <!-- Poll Table -->
                        <PollTable :polls="polls" @delete="deletePoll" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
