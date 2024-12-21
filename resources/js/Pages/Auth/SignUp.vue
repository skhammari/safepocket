<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    full_name: '',
    email: '',
    accept_terms: false,
});

const submit = () => {
    form.post(route('signup.request'), {
        onFinish: () => form.reset(),
    });
};

const getButtonClass = () => {
    if (!form.full_name || !form.email || !form.accept_terms) {
        return 'bg-colors-natural-8 hover:bg-colors-natural-9 text-colors-natural-3 cursor-not-allowed';
    }
    return 'bg-colors-primary-60 hover:bg-colors-primary-80 text-colors-natural-8';
};
</script>

<template>
    <GuestLayout>
        <Head title="Sign Up" />

        <div class="mt-8">
            <h1 class="text-center text-2xl font-bold text-gray-800">
                Create Your Account <span class="ml-2">✨</span>
            </h1>
        </div>

        <form @submit.prevent="submit" class="mt-6 px-6">
            <div class="mb-4">
                <InputLabel for="full_name" value="Full Name" />
                <TextInput
                    id="full_name"
                    type="text"
                    class="mt-1 block w-full p-3 rounded-xl border-colors-natural-3"
                    v-model="form.full_name"
                    required
                    autofocus
                    placeholder="Enter Your Full Name"
                />
                <InputError class="mt-2" :message="form.errors.full_name" />
            </div>

            <div class="mb-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full p-3 rounded-xl border-colors-natural-3"
                    v-model="form.email"
                    required
                    placeholder="Enter Your Email"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <Checkbox
                        name="accept_terms"
                        v-model:checked="form.accept_terms"
                        required
                    />
                    <span class="ms-2 text-sm text-natural-1">
                        I agree to the <a href="#" class="text-primary-60 hover:underline">Terms of Service</a> and <a href="#" class="text-primary-60 hover:underline">Privacy Policy</a>
                    </span>
                </label>
                <InputError class="mt-2" :message="form.errors.accept_terms" />
            </div>

            <div>
                <PrimaryButton
                    class="w-full mt-6 justify-center rounded-lg py-3 font-semibold"
                    :disabled="form.processing || !form.full_name || !form.email || !form.accept_terms"
                    :class="getButtonClass()"
                >
                    Create Account
                </PrimaryButton>
            </div>

            <div class="my-6 flex items-center justify-between">
                <span class="h-px w-1/3 bg-natural-2"></span>
                <span class="text-sm text-natural-2">Or With</span>
                <span class="h-px w-1/3 bg-natural-2"></span>
            </div>

            <div class="flex flex-col gap-4">
                <button
                    type="button"
                    class="flex items-center justify-center rounded-lg bg-primary-60 text-white py-3 font-medium hover:bg-primary-100"
                >
                    <span class="mr-2">📘</span> Continue with Facebook
                </button>
                <button
                    type="button"
                    class="flex items-center justify-center rounded-lg border border-gray-300 text-gray-800 py-3 font-medium hover:bg-gray-100"
                >
                    <span class="mr-2">🌐</span> Continue with Google
                </button>
            </div>
        </form>

        <div class="mt-6 text-center mb-12">
            <span class="text-sm text-natural-1">
                Already have an account?
            </span>
            <Link
                :href="route('login')"
                class="font-medium text-primary-80 hover:underline"
            >
                Log In
            </Link>
        </div>
    </GuestLayout>
</template> 