<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-6 py-12">
        <div class="max-w-lg w-full p-8 bg-white shadow-lg rounded-xl text-center">
            <!-- Heading -->
            <h1 class="text-3xl font-semibold text-gray-800 mb-6">
                Welcome to Our Voting App
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                Your one-stop solution to vote and make an impact. Sign in to start exploring.
            </p>

            <!-- Login Button -->
            <div class="flex justify-center">
                <Link href="/login" class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200">
                    Login
                </Link>
            </div>

            <!-- Footer text -->
            <div class="mt-6 text-sm text-gray-500">
                <p>By logging in, you agree to our <span class="text-blue-600">Terms & Conditions</span></p>
            </div>
        </div>
    </div>
</template>
