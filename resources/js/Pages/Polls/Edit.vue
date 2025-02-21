<script setup>
import { defineProps } from 'vue';
import { router, Link, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

import { onMounted, ref } from "vue";

const { flash } = usePage();
const successMessage = ref(flash?.success || '');

const props = defineProps({
    poll: Object, // Poll data from backend
});

console.log(props.poll);

// Prefill form with existing data
const form = useForm({
    question: props.poll.question,
    options: props.poll.options.map(option => option.option_text), // Extract option text
});

const errors = ref({});

// Add New Option
const addOption = () => {
    form.options.push("");
};

// Remove Option
const removeOption = (index) => {
    if (form.options.length > 1) {
        form.options.splice(index, 1);
    }
};

// Handle Form Submission
const submitPoll = () => {
    errors.value = {}; // Clear previous errors

    // Frontend Validation
    if (!form.question.trim()) {
        errors.value.question = "Poll question is required.";
    }
    if (form.options.length < 2 || form.options.some(opt => !opt.trim())) {
        errors.value.options = "At least two valid options are required.";
    }

    // If no errors, submit via Inertia
    if (Object.keys(errors.value).length === 0) {
        form.patch(route("polls.update", { poll: props.poll.id }), {
            onError: (errorMessages) => {
                errors.value = errorMessages;
            }
        });
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
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <!-- Success Message -->
                        <div v-if="successMessage" class="mt-4 bg-green-500 text-white p-2 rounded">
                            {{ successMessage }}
                        </div>
                        <h1 class="text-2xl font-bold mb-4">Edit Poll</h1>

                        <!-- Poll Question Input -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-1">Poll Question</label>
                            <input v-model="form.question" type="text"
                                class="w-full p-2 border rounded focus:ring focus:ring-blue-300" />
                            <p v-if="form.errors.question" class="text-red-500 text-sm mt-1">{{ form.errors.question }}</p>
                        </div>

                        <!-- Poll Options Repeater -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold mb-1">Poll Options</label>
                            <div v-for="(option, index) in form.options" :key="index" class="flex items-center gap-2 mb-2">
                                <input v-model="form.options[index]" type="text"
                                    class="w-full p-2 border rounded focus:ring focus:ring-blue-300" />
                                <button @click="removeOption(index)" v-if="form.options.length > 1"
                                    class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200">
                                    ✖
                                </button>
                            </div>
                            <button @click="addOption" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                + Add Option
                            </button>
                            <p v-if="form.errors.options" class="text-red-500 text-sm mt-1">{{ form.errors.options }}</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-between items-center">
                            <Link :href="route('polls.index')" class="text-blue-600 hover:underline">← Back to Polls</Link>
                            <button @click="submitPoll" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                                :disabled="form.processing">
                                Update Poll
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
