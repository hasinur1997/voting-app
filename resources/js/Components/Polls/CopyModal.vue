<script setup>
import { defineProps, defineEmits, ref } from 'vue';
import Modal from "@/Components/Modal.vue";

const props = defineProps({ show: Boolean, copyLink: String });

const emit = defineEmits(["close"]);

const copySuccess = ref(false);

const copyToClipboard = async () => {
    try {
        await navigator.clipboard.writeText(props.copyLink);
        copySuccess.value = true;
        setTimeout(() => (copySuccess.value = false), 2000);
    } catch (err) {
        console.error('Failed to copy text:', err);
    }
};
</script>

<template>
    <Modal :show="show" maxWidth="md" @close="emit('close')">
        <div class="p-5">
            <h3 class="text-lg font-bold mb-3">Share Poll Link</h3>
            <input type="text" :value="copyLink" class="w-full px-3 py-2 border rounded-lg bg-gray-100 text-gray-700" readonly />
            <div class="flex justify-between mt-4">
                <button @click="copyToClipboard" class="bg-blue-600 text-white px-4 py-2 rounded-md">Copy Link</button>
                <button @click="emit('close')" class="bg-gray-400 text-white px-4 py-2 rounded-md">Close</button>
            </div>
            <p v-if="copySuccess" class="text-green-500 mt-2">Copied to clipboard!</p>
        </div>
    </Modal>
</template>
