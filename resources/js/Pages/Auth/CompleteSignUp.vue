<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true
    },
    token: {
        type: String,
        required: true
    }
});

const form = useForm({
    username: '',
    password: '',
    password_confirmation: '',
    email: props.email,
    token: props.token
});

const submit = () => {
    form.post(route('signup.complete'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const getButtonClass = () => {
    if (!form.username || !form.password || !form.password_confirmation) {
        return 'bg-colors-natural-8 hover:bg-colors-natural-9 text-colors-natural-3 cursor-not-allowed';
    }
    return 'bg-colors-primary-60 hover:bg-colors-primary-80 text-colors-natural-8';
};
</script>

<template>
    <GuestLayout>
        <Head title="Complete Sign Up" />

        <div class="mt-8">
            <h1 class="text-center text-2xl font-bold text-gray-800">
                Complete Your Account Setup <span class="ml-2">🔐</span>
            </h1>
        </div>

        <form @submit.prevent="submit" class="mt-6 px-6">
            <div class="mb-4">
                <InputLabel for="username" value="Username" />
                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full p-3 rounded-xl border-colors-natural-3"
                    v-model="form.username"
                    required
                    autofocus
                    placeholder="Choose Your Username"
                />
                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div class="mb-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full p-3 rounded-xl border-colors-natural-3"
                    v-model="form.password"
                    required
                    placeholder="Create Your Password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mb-6">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full p-3 rounded-xl border-colors-natural-3"
                    v-model="form.password_confirmation"
                    required
                    placeholder="Confirm Your Password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div>
                <PrimaryButton
                    class="w-full justify-center rounded-lg py-3 font-semibold"
                    :disabled="form.processing || !form.username || !form.password || !form.password_confirmation"
                    :class="getButtonClass()"
                >
                    Complete Sign Up
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template> 