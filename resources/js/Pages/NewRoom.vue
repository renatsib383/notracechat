<script setup>
import GuestLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/BreezeComponents/InputLabel.vue';
import PrimaryButton from '@/BreezeComponents/PrimaryButton.vue';
import TextInput from '@/BreezeComponents/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const user = usePage().props.auth.user;

defineProps({

});

const form = useForm({
    name: '',
    owner: user.id,
});


const submit = () => {
    form.post(route('room.save'));
};



</script>

<template>
    <AuthenticatedLayout>
        <Head title="Log in" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Название комнаты" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>


            <div class="mt-4 flex items-center justify-end">


                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Создать
                </PrimaryButton>
            </div>
        </form>

    </AuthenticatedLayout>
</template>
