<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const { userRole, title } = usePage().props;

const form = useForm({
    name: '',
    email: '',
    phone: userRole ? '' : undefined,
    region: userRole ? '' : undefined,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    const routeName = userRole === 'farmer' 
        ? 'register.farmer.store' 
        : userRole === 'buyer' 
            ? 'register.buyer.store' 
            : 'register';
    
    form.post(route(routeName), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthBase title="title" :description="userRole ? `Enter your details to register as a ${userRole}` : 'Enter your details to create an account'">
        <Head title="title" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Full Name</Label>
                    <Input id="name" type="text" required autofocus autocomplete="name" v-model="form.name" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email Address</Label>
                    <Input id="email" type="email" required autocomplete="email" v-model="form.email" />
                    <InputError :message="form.errors.email" />
                </div>

                <template v-if="userRole">
                    <div class="grid gap-2">
                        <Label for="phone">Phone Number</Label>
                        <Input id="phone" type="tel" required autocomplete="tel" v-model="form.phone" />
                        <InputError :message="form.errors.phone" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="region">Region</Label>
                        <Input id="region" type="text" required autocomplete="region" v-model="form.region" />
                        <InputError :message="form.errors.region" />
                    </div>
                </template>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input id="password" type="password" required autocomplete="new-password" v-model="form.password" />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm Password</Label>
                    <Input id="password_confirmation" type="password" required autocomplete="new-password" v-model="form.password_confirmation" />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-2 w-full" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    {{ userRole ? `Register as ${userRole}` : 'Create account' }}
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4">Log in</TextLink>
            </div>
        </form>
    </AuthBase>
</template>