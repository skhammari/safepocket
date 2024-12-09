<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import {list} from "postcss";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const getButtonClass = () => {
    if (!form.email || !form.password) {
        return 'bg-colors-natural-8 hover:bg-colors-natural-9 text-colors-natural-3 cursor-not-allowed';
    }

    return 'bg-colors-primary-60 hover:bg-colors-primary-80 text-colors-natural-8'
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="mt-8">
            <h1 class="text-center text-2xl font-bold text-gray-800">
                Hi, Welcome Back! <span class="ml-2">👋</span>
            </h1>
        </div>

        <form @submit.prevent="submit" class="mt-6 px-6">
            <div class="mb-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full p-3 rounded-xl border-colors-natural-3"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Enter Your Email"
                />
<!--                <InputError class="mt-2" :message="form.errors.email" />-->
            </div>

            <div class="mb-4">
                <InputLabel for="password" value="Password" />
                <div class="relative">
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full p-3 rounded-xl border-colors-natural-3"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter Your Password"
                    />
                    <button
                        type="button"
                        class="absolute inset-y-0 right-4 flex items-center text-gray-400"
                    >
                    <svg width="19" height="13" viewBox="0 0 19 13" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.5 6.5C0.5 6.5 3.875 0.3125 9.5 0.3125C15.125 0.3125 18.5 6.5 18.5 6.5C18.5 6.5 15.125 12.6875 9.5 12.6875C3.875 12.6875 0.5 6.5 0.5 6.5ZM9.5 10.4375C10.5443 10.4375 11.5458 10.0227 12.2842 9.28423C13.0227 8.54581 13.4375 7.54429 13.4375 6.5C13.4375 5.45571 13.0227 4.45419 12.2842 3.71577C11.5458 2.97734 10.5443 2.5625 9.5 2.5625C8.45571 2.5625 7.45419 2.97734 6.71577 3.71577C5.97734 4.45419 5.5625 5.45571 5.5625 6.5C5.5625 7.54429 5.97734 8.54581 6.71577 9.28423C7.45419 10.0227 8.45571 10.4375 9.5 10.4375Z" fill="url(#paint0_linear_726_10256)"/>
<defs>
<linearGradient id="paint0_linear_726_10256" x1="9.5" y1="0.3125" x2="9.5" y2="12.6875" gradientUnits="userSpaceOnUse">
<stop stop-color="#292739"/>
<stop offset="1"/>
</linearGradient>
</defs>
</svg>

                    </button>
                </div>
                <p v-if="form.errors.email" class="block w-full mt-2 text-sm text-colors-state-error" style="font-size: 17px; line-height: 25px">
                    We couldn’t find any account with this email
                    please try again or <a class="underline font-bold" :href="route('register')">Create a new account</a>
                </p>
                <p v-if="form.errors.password" class="block w-full mt-2 text-sm text-colors-state-error" style="font-size: 17px; line-height: 25px">
                    {{ form.errors.password }}
                </p>
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <Checkbox
                        name="remember"
                        v-model:checked="form.remember"
                    />
                    <span class="ms-2 text-sm text-natural-1">
                        Remember Me
                    </span>
                </label>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm font-medium text-error hover:underline"
                >
                    Forgot Password?
                </Link>
            </div>

            <div>
                <PrimaryButton
                    class="w-full mt-12 justify-center rounded-lg py-3 font-semibold"
                    :disabled="form.processing || !form.email || !form.password"
                    :class="getButtonClass()"
                >
                    Next
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
                    <span class="mr-2">📘</span> Login with Facebook
                </button>
                <button
                    type="button"
                    class="flex items-center justify-center rounded-lg border border-gray-300 text-gray-800 py-3 font-medium hover:bg-gray-100"
                >
                    <span class="mr-2">🌐</span> Login with Google
                </button>
            </div>
        </form>

        <div class="mt-6 text-center mb-12">
            <span class="text-sm text-natural-1">
                Don’t have an account?
            </span>
            <Link
                :href="route('register')"
                class="font-medium text-primary-80 hover:underline"
            >
                Sign Up
            </Link>
        </div>
    </GuestLayout>
</template>
