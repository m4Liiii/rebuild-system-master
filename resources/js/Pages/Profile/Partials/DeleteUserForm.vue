<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6 ">
        <header>
            <h2 class="text-lg font-medium text-gray-200">سڕینەوەی بەکارهێنەر</h2>

            <p class="mt-1 text-sm text-red-200">
          ئاگاداربە ، لەکاتی سڕینەوەی ئەم بەکار‌هێنەرە ئەوا هیچ مافێک و مۆڵەتێکی نامێنێ بۆ هاتنەژوورە
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">سڕینەوە</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-200">
                  ئایا تۆ دڵنیای لە سڕینەوەی ئەم بەکارهێنەرە؟
                </h2>


                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="block w-3/4 mt-1"
                        placeholder="بۆ سڕینەوە ژمارەی نهێنی "
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password ? '  هەڵە هەیە لە ژمارەی نهێنی ' : ''" class="mt-2" />
                </div>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>

                    <DangerButton
                        class="mx-3 ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                      سڕینەوە
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
