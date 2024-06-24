<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const user = usePage().props.auth.user;

const form = useForm({
  name: user.name,
  email: user.email,
});
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-200">گۆڕینی ناوی بەکارهێنەر</h2>
    </header>

    <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
      <div>
        <InputLabel for="name" value="ناو" />

        <TextInput
          id="name"
          type="text"
          class="block w-full mt-1"
          v-model="form.name"
          placeholder="گۆڕینی ناو"
          autocomplete="name"
        />

        <InputError
          class="mt-2"
          :message="form.errors.name ? 'هەڵە هەیە لە ناودا' : ''"
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
