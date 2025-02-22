<script setup>
import { defineProps, ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    poll: Object
});

const selectedOption = ref(null);

const submitVote = () => {
    if (selectedOption.value) {
        router.post(`/polls/${props.poll.id}/vote`, { option_id: selectedOption.value });
    }
};
</script>

<template>
    <div class="flex items-start justify-center min-h-screen bg-gray-100">
        <div class="max-w-2xl w-full p-6 bg-white shadow-lg rounded-xl border border-gray-200 mt-16">
            <!-- Poll Title -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">{{ poll.question }}</h2>

            <!-- Poll Options -->
            <div class="space-y-3">
                <label
                    v-for="option in poll.options"
                    :key="option.id"
                    class="flex items-center justify-between p-4 border rounded-lg shadow-sm bg-gray-50 hover:bg-gray-100 transition cursor-pointer"
                >
                    <span class="text-gray-700 font-medium">{{ option.option_text }}</span>
                    <input
                        type="radio"
                        :value="option.id"
                        v-model="selectedOption"
                        class="h-5 w-5 text-blue-600"
                    />
                </label>
            </div>

            <!-- Submit Button -->
            <div v-if="selectedOption" class="mt-4 flex justify-center">
                <button
                    @click="submitVote"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition"
                >
                    Vote Now
                </button>
            </div>
        </div>
    </div>
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
