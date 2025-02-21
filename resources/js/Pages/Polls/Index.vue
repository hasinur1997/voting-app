<script setup>
import { defineProps } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import { useClipboard } from "@vueuse/core";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";



import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({ polls: Array });

const deletePoll = (id) => {
    if (confirm("Are you sure you want to delete this poll?")) {
        router.delete(`/polls/${id}`);
    }
};

const showCopyModal = ref(false);
const copyLink = ref("");
const copySuccess = ref(false);
const copyInput = ref(null);

const { copy } = useClipboard();

const openCopyModal = (slug) => {
  copyLink.value = `${window.location.origin}/vote/${slug}`;
  showCopyModal.value = true;
    copySuccess.value = false;
};

// Copy to clipboard
const copyToClipboard = async () => {
    console.log(copyInput)

    copyInput.select();
    // copyInput.setSelectionRange(0, 99999); // For mobile devices

   // Copy the text inside the text field
    navigator.clipboard.writeText(copyLink);

};

// Close modal
const closeModal = () => {
  showCopyModal.value = false;
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
                        <!-- Create Poll Button -->
                        <Link :href="route('polls.create')" class="bg-blue-500 text-white px-4 py-2 rounded inline-block mb-4">
                            Create Poll
                        </Link>


                        <table class="w-full border">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-4 py-2 text-left">Question</th>
                                    <th class="border px-4 py-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="poll in polls" :key="poll.id">
                                    <td class="border px-4 py-2">{{ poll.question }}</td>
                                    <td class="border px-4 py-2 text-center">
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
                                            <button @click="deletePoll(poll.id)"
                                                class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            <!-- Shareable Link -->
                                            <button @click="openCopyModal(poll.slug)"
                                                class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            <Modal :show="showCopyModal" maxWidth="md" @close="closeModal">
                                            <div class="p-5">
                                                <h3 class="text-lg font-bold mb-3">Share Poll Link</h3>
                                                <input
                                                type="text"
                                                :value="copyLink"
                                                ref="copyInput"
                                                class="w-full px-3 py-2 border rounded-lg bg-gray-100 text-gray-700"
                                                readonly
                                                />
                                                <div class="flex justify-between mt-4">
                                                <button @click="copyToClipboard" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                                                    Copy Link
                                                </button>
                                                <button @click="closeModal" class="bg-gray-400 text-white px-4 py-2 rounded-md">
                                                    Close
                                                </button>
                                                </div>
                                                <p v-if="copySuccess" class="text-green-500 mt-2">Copied to clipboard!</p>
                                            </div>
                                            </Modal>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
