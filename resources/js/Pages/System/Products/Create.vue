<template>
    <Head title="زیادکردنی بابەتەکان" />

  <AuthenticatedLayout>
<div class="justify-between md:flex">
    <div class="flex items-center p-4 py-7">
        <Link
        :href="route('categories.products.index', category.id)"
        class="inline-block p-2 rounded-r text-rose-300 bg-zinc-600"
      >
       <BackSvg/>
      </Link>
        <div class="justify-end p-4 text-left rounded-l whitespace-nowrap text-emerald-400 bg-zinc-700">
            فۆڕمی زیاد کردنی بابەت
        </div>
    </div>
    <div class="flex items-center p-4 py-7">

        <div class="justify-end p-4 text-left rounded text-cyan-400 bg-zinc-700">
          {{ category.name }}
        </div>
    </div>

</div>

    <form @submit.prevent="submit">
      <div class="p-4 mx-4 rounded-lg shadow-md mb-7 bg-zinc-700">
        <div class="flex flex-wrap justify-center flex-initial m-2">
          <!-- First Pair -->
          <div class="px-2 my-3 lg:w-1/2">
            <InputLabel for="name" value=" ناوی بابەت" class="relative" />
            <TextInput
              id="name"
              type="text"
                maxLength="40"
              v-model="form.name_of_product"
              class="w-full mt-1"
              placeholder="ناوی بابەت "

            />
            <InputError class="mt-2"  :message="form.errors.name_of_product ? '  هەڵە هەیە لە ناوی جۆری بابەت' : ''"/>
          </div>

          <!-- Second Pair -->
          <div class="px-2 my-3 lg:w-1/2">
            <InputLabel for="code" value="کۆدی بابەت" />
            <TextInput
              id="code"
              type="text"
                maxLength="40"
              v-model="form.code_of_product"
              class="w-full mt-1"
              placeholder="کۆدی بابەت (ئارەزوومەندانە)"

            />
            <InputError class="mt-2" :message="form.errors.code_of_product ? 'هەڵە هەیە لە کۆدی جۆری بابەت' : ''"/>
          </div>
        </div>

          <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="p_ko" class="relative"> نرخی فرۆشتنی کۆ {{ formatNumber(form.price_of_sell_ko) }}</InputLabel>
              <TextInput
                id="p_ko"
                maxLength="12"
                type="text"
                v-model="form.price_of_sell_ko"
                class="w-full mt-1"
                placeholder=" نرخی فرۆشتنی کۆ"

              />
              <InputError class="mt-2"  :message="form.errors.price_of_sell_ko ? 'هەڵە هەیە لە نرخی فرۆشتنی کۆ' : ''"/>
            </div>

            <!-- Second Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="p_tak" >نرخی فرۆشتنی تاک {{ formatNumber(form.price_of_sell_tak) }}</InputLabel>
              <TextInput
                id="p_tak"
                type="text"
                maxLength="12"
                v-model="form.price_of_sell_tak"
                class="w-full mt-1"
                placeholder="نرخی فرۆشتنی تاک"

              />
              <InputError class="mt-2" :message="form.errors.price_of_sell_tak ? 'هەڵە هەیە لە نرخی فرۆشتنی تاک' : ''"/>
            </div>
          </div>
          <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="p_buy"  class="relative" >نرخی کڕین {{ formatNumber(form.price_of_buy) }}</InputLabel>
              <TextInput
                id="p_buy"
                maxLength="12"
                type="text"
                v-model="form.price_of_buy"
                class="w-full mt-1"
                placeholder="نرخی کڕین"

              />
              <InputError class="mt-2"  :message="form.errors.price_of_buy ? ' هەڵە هەیە لە نرخی کڕین' : ''"/>
            </div>

            <!-- Second Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="alert" value="ئاگادار کردنەوەی بابەت" />
              <TextInput
                id="alert"
                type="text"
                maxLength="12"
                v-model="form.alert_of_out"
                class="w-full mt-1"
                placeholder="  ئاگادار کردنەوەی ڕۆژی نەمانی بابەت  (ئارەزوومەندانە , 15)"

              />
              <InputError class="mt-2" :message="form.errors.alert_of_out ? '  هەڵە هەیە لە کۆدی جۆری بابەت' : ''"/>
            </div>
          </div>
          <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="quantity_box" value="ژمارەی ناو کارتۆن" class="relative" />
              <TextInput
                id="quantity_box"
                type="text"
                maxLength="9"
                v-model="form.quantity_of_box"
                class="w-full mt-1"
                placeholder="ژمارەی ناو کارتۆن"

              />
              <InputError class="mt-2"  :message="form.errors.quantity_of_box ? 'هەڵە هەیە لە ژمارەی ناو کارتۆن' : ''"/>
            </div>

            <!-- Second Pair -->
            <div class="px-2 my-3 lg:w-1/2">
              <InputLabel for="quantity_store" value="ژمارەی ناو کۆگا" />
              <TextInput
                 maxLength="9"
                id="quantity_store"
                type="text"
                v-model="form.quantity_of_store"
                class="w-full mt-1"
                placeholder="ژمارەی ناو کۆگا"

              />
              <InputError class="mt-2" :message="form.errors.quantity_of_store ? 'هەڵە هەیە لە ژمارەی ناو کۆگا' : ''"/>
            </div>
          </div>

          <div class="flex flex-wrap justify-center flex-initial ">
            <!-- First Pair -->
            <div class="px-2 mt-3 lg:w-1/2">
                <div class="px-2 text-xl text-cyan-500">
                    {{ boxAndQuantity }}
                </div>
            </div>

            <!-- Second Pair -->
            <div class="px-2 mt-3 lg:w-1/2">
                <div class="flex items-center">
                    <input
                      v-model="reverseShowSelect"
                      id="green-checkbox"
                      type="checkbox"
                      value=""
                      class="w-5 h-5 border border-gray-300 rounded text-cyan-500 focus:ring-cyan-500 focus:ring-opacity-25"
                    />
                    <label
                      for="green-checkbox"
                      class="mr-5 text-sm font-medium text-gray-900 text-gray-300"
                      >کلیک بکە بۆ شاردنەوەی بابەت</label
                    >
                  </div>
            </div>
          </div>

        <div class="flex justify-center py-5 ml-4">
          <SecondaryButton  @click="resetForm" class="mx-2">بەتاڵ کردنەوە</SecondaryButton>
            <PrimaryButton :disabled="form.processing"  class="mx-2">زەخیرەکردن</PrimaryButton>
        </div>
      </div>
    </form>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import BackSvg from "@/Components/Svg/Back.vue";
import { Head, Link, useForm , usePage } from "@inertiajs/vue3";
import { computed } from 'vue';
import numeral from 'numeral';

const category = usePage().props.category;

const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};

const boxAndQuantity = computed(() => {
  const totalQuantity = parseInt(form.quantity_of_store) || 0;
  const boxQuantity = parseInt(form.quantity_of_box) || 1;
  const numberOfBoxes = Math.floor(totalQuantity / boxQuantity);
  const remainingQuantity = totalQuantity % boxQuantity;
  return `${remainingQuantity}  ژمارە , ${numberOfBoxes}  کارتۆن`;
});
const reverseShowSelect = computed({
  get: () => form.ShowSelect == 0,
  set: (value) => { form.ShowSelect = value ? 0 : 1; }
});

const form = useForm({
  category_id: category.id,
  name_of_product: "",
  code_of_product: "",
  alert_of_out: "",
  quantity_of_box: "",
  quantity_of_store: "",
  price_of_buy: "",
  price_of_sell_tak: "",
  price_of_sell_ko: "",
  ShowSelect: 1,
  type_delete: 1,
});

const submit = () => {
  form.post(route("categories.products.store" , category.id));
};

function resetForm() {
    form.name_of_product = "";
    form.code_of_product = "";
    form.alert_of_out = "";
    form.quantity_of_box = "";
    form.quantity_of_store = "";
    form.price_of_buy = "";
    form.price_of_sell_tak = "";
    form.price_of_sell_ko = "";
    form.ShowSelect = 1;
}

</script>
