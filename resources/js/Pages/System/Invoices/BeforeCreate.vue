<template>
    <div v-if="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 ">
        <div class="text-gray-300 animate-spin">
            <LoaderDebtSvg/>
        </div>
      </div>
    <Modal
    :customClass="'relative mt-10'"
    :maxWidth="'md'"
    :show="ShowCreateModalInvoice"
    @close="closeCreateModalInvoice"

 >
 <div dir="ltr" class="p-6 overflow-hidden text-left align-middle transition-all transform bg-gray-600 rounded-md shadow-xl">
    <div class="p-2">
        <div class="mt-2">
            <div>
              <div class="flex items-center gap-1 pb-2">
                <input
                  v-model="InvoiceFormCreate.name"
                  disabled
                  type="text"
                  id="name"
                  placeholder="0"
                  class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-gray-200 border-y-gray-200 focus:outline-none focus:ring-0 sm:text-sm focus:border-indigo-500"
                />
                <label
                  for="name"
                  class="w-1/2 p-2 ml-3 text-center text-gray-100 bg-gray-600 border border-gray-100 whitespace-nowrap"
                >
                  ناوی بابەت</label
                >
              </div>
              <div class="flex items-center gap-1 pb-2">
                <input
                  v-model="InvoiceFormCreate.code"
                  type="text"
                  id="code"
                  placeholder="0"
                  disabled
                  class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-gray-200 border-y-gray-200 focus:outline-none focus:ring-0 sm:text-sm focus:border-indigo-500"
                />
                <label
                  for="code"
                  class="w-1/2 p-2 ml-3 text-center text-gray-100 bg-gray-600 border border-gray-100 whitespace-nowrap">
                  کۆدی بابەت</label>
              </div>
              <div class="flex items-center gap-1 pb-2">
                <input
                  placeholder="0"
                  v-model="InvoiceFormCreate.quantity_box"
                  type="text"
                  id="quantity_box"
                  disabled
                  class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-gray-200 border-y-gray-200 focus:outline-none focus:ring-0 sm:text-sm focus:border-indigo-500"
                />

                <label
                  for="quantity_box"
                  class="w-1/2 p-2 ml-3 text-center text-gray-100 bg-gray-600 border border-gray-100 whitespace-nowrap"
                  >ژمارەی ناو کارتۆن</label
                >
              </div>
              <div class="flex items-center gap-1 pb-2">
                <input
                  v-model="InvoiceFormCreate.p_buy"
                  type="text"
                  disabled
                  id="price_of_buy"
                  placeholder="0"
                  class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-gray-200 border-y-gray-200 focus:outline-none focus:ring-0 sm:text-sm focus:border-indigo-500"
                />

                <label
                  for="price_of_buy"
                  class="w-1/2 p-2 ml-3 text-center text-gray-100 bg-gray-600 border border-gray-100 whitespace-nowrap"
                >
                  نرخی کڕین</label
                >
              </div>
              <div class="flex items-center gap-1 pb-2">
                <input
                  placeholder="0"
                  v-model="InvoiceFormCreate.p_ko"
                  type="text"
                  id="price_of_sell_ko"
                  disabled
                  class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-gray-200 border-y-gray-200 focus:outline-none focus:ring-0 sm:text-sm focus:border-indigo-500"
                />

                <label
                  for="price_of_sell_ko"
                  class="w-1/2 p-2 ml-3 text-center text-gray-100 bg-gray-600 border border-gray-100 whitespace-nowrap"
                  >نرخی کۆ
                </label>
              </div>
              <div class="flex items-center gap-1 pb-2">
                <input
                  placeholder="0"
                  disabled
                  v-model="InvoiceFormCreate.p_tak"
                  type="text"
                  id="price_of_sell_tak"
                  class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-gray-200 border-y-gray-200 focus:outline-none focus:ring-0 sm:text-sm focus:border-indigo-500"
                />

                <label
                  for="price_of_sell_tak"
                  class="w-1/2 p-2 ml-3 text-center text-gray-100 bg-gray-600 border border-gray-100 whitespace-nowrap"
                >
                  نرخی تاک
                </label>
              </div>
            </div>
          </div>
          <div
            class="justify-center mt-3 text-lg text-center text-white "
          >
            <p>{{ updatedQuantityOfStore }}</p>
          </div>
          <div class="flex justify-center mt-4">
            <SecondaryButton
              @click="closeCreateModalInvoice"
            >
              لابردن
            </SecondaryButton>
          </div>

    </div>
</div>
 </Modal>
    <AuthenticatedLayout>
        <div class="w-full py-3 mx-auto my-3 overflow-hidden rounded bg-zinc-700 lg:w-3/4">
            <span class="flex justify-center text-2xl text-gray-100 lg:text-4xl">زیاد کردنی پسولە</span>
            <div class="flex justify-center mb-4 text-center mt-7 text-cyan-400 animate-bounce">
        <svg width="66px" height="66px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 20L18 14M12 20L6 14M12 20L12 9.5M12 4V6.5" stroke="CurrentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg></div>
    <button @click="submit" class="flex justify-center py-1 mx-auto text-5xl text-center text-gray-100 rounded w-52 bg-emerald-500 hover:bg-emerald-600"><CreateSvg/></button>
    <div class="my-5 border border-zinc-500"/>
    <div class="flex justify-center text-2xl text-gray-100 lg:text-4xl">سەیر کردنی بابەت</div>
    <div class="w-full mx-auto mb-4 lg:w-3/4">
        <SearchableProduct
        :items="products"
        label="گەڕان بۆ بابەت"
        :searchFields="[
            'name_of_product',
            'code_of_product',
        ]"
        class="w-full"
        deselect-button-class="mt-1.5"
        :deselectable="true"
        @product-selected="onProductSelected"
    >
        <template #option-content="{ option }">
           <span> {{ option.name_of_product }} </span> - <span class="text-indigo-200"> {{ option.code_of_product }} </span>
        </template>
    </SearchableProduct>
</div>
<div class="my-3 border border-zinc-500"/>
<div class="p-2 px-4">
    <div class="p-2 text-xl text-cyan-400 lg:text-2xl">تێبینی :-</div>
    <ul class="p-2 text-sm text-gray-100 lg:text-base">
        <li class="py-2">
           1- لە کاتی بوونی هەر کێشەیەک دەتوانی ئاگادارمان بکەیتەوە.
        </li>
        <li class="py-2">
            2- ئەم سیستەمە وا پڕۆگرام کراوە کە ئەگەر هەرچەندە داتا زۆربێ کار نەکاتە سەر خێرایی بۆیە تکایە هەموو کاتێک لە هێڵی ئینتەرنێتەکەت دڵنیابە.
        </li>
        <li class="py-2 ">
            3- هەر کێشەیەک لە پسولەکانت دا هەبوو ئەتوانی کلیک لە <span @click="repairAll" class="mx-0.5  px-1 bg-gray-600 rounded cursor-pointer text-indigo-300 hover:text-indigo-400">نوێکردنەوەی هەموو پسولەکان</span> بکەیت.
        </li>
    </ul>
</div>
</div>
</AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CreateSvg from "@/Components/Svg/Create.vue";
import LoaderDebtSvg from "@/Components/Svg/LoaderDebt.vue";
import { router, useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import {ref , computed} from "vue";
import SearchableProduct from "@/Components/Searchable-Product.vue";
import numeral from "numeral";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    products:Object
});
const submit = () => {
  router.post(route("before.store.invoice"));
};

const loading = ref(false);

const repairAll = () => {
  loading.value = true;
  router.put(route("repair.all"), {}, {
    onFinish: () => loading.value = false
  });
};
const ShowCreateModalInvoice = ref(false);

const closeCreateModalInvoice = () => {
    ShowCreateModalInvoice.value = false;
    InvoiceFormCreate.reset();
}

const openCreateModalInvoice = () => {

    ShowCreateModalInvoice.value = true;
}
const InvoiceFormCreate = useForm({
    category_id: '',
    product_id: '',
    name: '',
    code: '',
    box: '',
    quantity_box: '',
    quantity: '',
    profit: '',
    price_tak: '',
    price_ko: '',
    price_all: '',
    p_tak:"",
    p_ko: "",
    p_buy: "",
});
const formatNumber = (number) => {
    return number == null || isNaN(number)
        ? "0"
        : numeral(number).format("0,0.[000]");
};
const onProductSelected = (selectedProduct) => {
openCreateModalInvoice();
InvoiceFormCreate.category_id = selectedProduct.category_id;
InvoiceFormCreate.product_id = selectedProduct.id;
InvoiceFormCreate.name = selectedProduct.name_of_product;
InvoiceFormCreate.code = selectedProduct.code_of_product;
InvoiceFormCreate.quantity_box = selectedProduct.quantity_of_box;
InvoiceFormCreate.p_tak = formatNumber(selectedProduct.price_of_sell_tak);
InvoiceFormCreate.p_ko = formatNumber(selectedProduct.price_of_sell_ko);
InvoiceFormCreate.p_buy = formatNumber(selectedProduct.price_of_buy);
};
const getProductById = (productId) => {
  return props.products.find((product) => product.id == productId);
};
const updatedQuantityOfStore = computed(() => {
  if (InvoiceFormCreate.product_id) {
    const selectedProduct = getProductById(InvoiceFormCreate.product_id);
    const quantity = parseInt(InvoiceFormCreate.quantity) || 0;
    const remainder =
      (selectedProduct.quantity_of_store - quantity) %
      selectedProduct.quantity_of_box;
    const boxes = parseInt(
      (selectedProduct.quantity_of_store - quantity) / selectedProduct.quantity_of_box
    );

    return `${boxes} ژمارە  ${remainder} , کارتۆن`;
  }
  return "";
});

</script>
