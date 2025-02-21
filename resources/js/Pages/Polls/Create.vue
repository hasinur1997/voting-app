<script setup>
import { defineProps } from 'vue';
import { router, Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


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

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <!-- Create Poll Button -->
                        <Link :href="route('polls.index')" class="bg-blue-500 text-white px-4 py-2 rounded inline-block mb-4">
                            Back To List
                        </Link>

                        Create form list
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
