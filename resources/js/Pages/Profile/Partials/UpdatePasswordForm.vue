<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const updatePassword = () => {
  form.put(route("password.update"), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.password) {
        form.reset("password", "password_confirmation");
        passwordInput.value.focus();
      }
      if (form.errors.current_password) {
        form.reset("current_password");
        currentPasswordInput.value.focus();
      }
    },
  });
};
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-200">گۆڕینی وشەی نهێنی بەکار‌هێنەر</h2>

      <p class="mt-1 text-sm text-gray-600">
        Ensure your account is using a long, random password to stay secure.
      </p>
    </header>

    <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
      <div>
        <InputLabel for="current_password" value="وشەی نهێنی ئێستا" />

        <TextInput
          id="current_password"
          ref="currentPasswordInput"
          v-model="form.current_password"
          type="password"
          placeholder=" وشەی نهێنی ئێستا "
          class="block w-full mt-1"
          autocomplete="current-password"
        />

        <InputError
          :message="form.errors.current_password ? '  هەڵە هەیە لە وشەی نهێنی ئێستا' : ''"
          class="mt-2"
        />
      </div>

      <div>
        <InputLabel for="password" value="وشەی نهێنی نوێ" />

        <TextInput
          id="password"
          ref="passwordInput"
          v-model="form.password"
          type="password"
          placeholder=" وشەی نهێنی نوێ "
          class="block w-full mt-1"
          autocomplete="new-password"
        />

        <InputError
          :message="form.errors.password ? 'هەڵە هەیە لە وشەی نهێنی نوێ' : ''"
          class="mt-2"
        />
      </div>

      <div>
        <InputLabel for="password_confirmation" value="دڵنیا بونەوەی وشەی نهێنی" />

        <TextInput
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          placeholder=" دڵنیا ببەوە لە وشەی نهێنیەکەت"
          class="block w-full mt-1"
          autocomplete="new-password"
        />

        <InputError
          :message="
            form.errors.password_confirmation
              ? 'هەڵە هەیە لە دڵنیا بونەوەی وشەی نهێنی'
              : ''
          "
          class="mt-2"
        />
      </div>

      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">زەخیرەکردن</PrimaryButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-emerald-400">
            سەرکەوتوبوو
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>
