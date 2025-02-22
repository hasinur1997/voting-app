<script setup>
import { defineProps, ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    poll: Object
});

const selectedOption = ref(null);
const votingMessage = ref('');
const isVoting = ref(false);
const errorMessages = {
    404: 'Poll option not found.',
    403: 'You have already voted!',
    default: 'An error occurred while submitting your vote.',
    network: 'Network error. Please try again.',
};

/**
 * Handles the vote submission process.
 *
 * This function checks if a poll option has been selected. If a valid option is selected,
 * it sends the vote request to the server. It also manages the voting state (loading)
 * and displays appropriate messages based on the outcome (success or failure).
 *
 * @async
 * @function submitVote
 */
 const submitVote = async () => {
    // Check if the user has selected a poll option
    if (isOptionSelected()) {
        // Set the voting state to true to indicate loading
        setVotingState(true);

        try {
            // Attempt to send the vote request to the server
            const response = await sendVoteRequest(selectedOption.value);

            // On successful vote submission, set the message to inform the user
            setVotingMessage(response.data.message);
        } catch (error) {
            // Handle any errors that occur during the vote submission process
            handleVoteError(error);
        } finally {
            // Regardless of success or failure, reset the voting state to false
            setVotingState(false);
        }
    } else {
        // If no option is selected, prompt the user to select an option
        setVotingMessage('Please select an option before voting.');
    }
};

// Check if an option is selected
const isOptionSelected = () => selectedOption.value !== null;

// Set the voting state (loading or not)
const setVotingState = (state) => {
    isVoting.value = state;
};

// Set the message to be displayed to the user
const setVotingMessage = (message) => {
    votingMessage.value = message;
};

// Handle the API errors
const handleVoteError = (error) => {
    let errorMessage = errorMessages.default;

    if (error.response) {
        errorMessage = errorMessages[error.response.status] || errorMessages.default;
    } else {
        errorMessage = errorMessages.network;
    }
    setVotingMessage(errorMessage);
};

// Send the vote to the API
const sendVoteRequest = (pollOptionId) => {
    return axios.post(`/api/vote/cast/${pollOptionId}`);
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

            <!-- Voting Message -->
            <p v-if="votingMessage" class="text-red-500 mt-2">{{ votingMessage }}</p>

            <!-- Submit Button -->
            <div v-if="selectedOption" class="mt-4 flex justify-center">
                <button
                    @click="submitVote"
                    :disabled="isVoting"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition"
                >
                    {{ isVoting ? 'Submitting Vote...' : 'Vote Now' }}
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
