<template>
    <Head title="لیستی بابەتە سڕاوەکان" />
    <Modal
    :show="showConfirmRestoreAllproductModal"
    @close="closeModalResAll"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی هەموو بابەتە سڕاوەکان ؟
        </h2>
        <div class="mt-5 text-cyan-400">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا جۆری بابەتەکانیش لەگەڵی دێنەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalResAll">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreproductAll(),closeModalResAll()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
 <Modal
 :show="showConfirmDeleteAllproductModal"
 @close="closeModalAll"
>
 <div class="p-6">
     <h2 class="text-lg font-medium text-gray-200">
            ئایا تۆ دڵنیای لە سڕینەوەی یەکجاری هەموو بابەتە سڕاوەکان ؟
     </h2>
     <div class="flex justify-end mt-6">
         <SecondaryButton @click="closeModalAll">لابردن</SecondaryButton>
         <DangerButton class="mx-3 ml-3" @click="deleteproductAll(),closeModalAll()">سڕینەوە</DangerButton >
     </div>
 </div>
</Modal>
    <Modal
    :show="showConfirmRestoreproductModal"
    @close="closeModalRes"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی بابەتی ( {{ productToRestore ? productToRestore.name_of_product : '' }} ) ؟
        </h2>
        <div class="mt-5 text-cyan-400" v-if="productToRestore.category.type_delete == '0'">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا جۆری بابەتیش لەگەڵی دێتەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalRes">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreproduct(productIdToRestore.value),closeModalRes()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
   <Modal
   :show="showConfirmDeleteproductModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی بابەتی ( {{ productToDelete ? productToDelete.name_of_product : '' }} ) ؟
       </h2>
       <div class="flex justify-end mt-6">
           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>
           <DangerButton  class="mx-3 ml-3" @click="deleteproduct(productIdToDelete.value),closeModal()">سڕینەوە</DangerButton>
       </div>
   </div>
</Modal>
 <AuthenticatedLayout :searchValue="search" @updateSearchValue="handleSearchUpdate">
   <main class="h-full overflow-y-auto py-7">
     <div class="container grid px-6 mx-auto">
        <div class="items-center md:flex md:justify-between">
            <!-- First div aligned to the left -->
            <div class="flex items-center pb-7">
           <div class="justify-end p-4 text-left rounded text-rose-300 bg-zinc-700">
                 لیستی بابەتە سڕاوەکان
           </div>
       </div>
       <div class="flex items-center pb-7">
        <button class="p-4 mx-2 rounded bg-zinc-700 text-cyan-500" @click="confirmRestoreAllproduct"><RestoreSvg/></button>  <button @click="confirmDeleteAllproduct"  class="p-4 mr-2 rounded bg-zinc-700 text-rose-300"><DeleteSvg/></button>
    </div>
    </div>
       <div class="w-full overflow-hidden rounded-[5px] shadow-xs">
         <div class="w-full overflow-x-auto">
           <Table>
             <TableHead>
               <TableRowHead>
                <TableDataHead class="w-16">#</TableDataHead>
                <TableDataHead class="w-96">کۆد</TableDataHead>
                <TableDataHead class="w-96 ">ناو</TableDataHead>
                <TableDataHead class="w-16">کۆی ژ.كڕین</TableDataHead>
                <TableDataHead class="w-16">کۆی ژ.فرۆشتن</TableDataHead>
                <TableDataHead class="w-16">کۆی کۆگا</TableDataHead>
                <TableDataHead class="w-16">ژ.ناو کارتۆن</TableDataHead>
                <TableDataHead class="w-16 text-emerald-400">کارتۆن</TableDataHead>
                <TableDataHead class="w-16 text-emerald-400">ژمارە</TableDataHead>
                <TableDataHead class="w-16">نرخی کڕین</TableDataHead>
                <TableDataHead class="w-16">نرخی کۆ</TableDataHead>
                <TableDataHead class="w-16">نرخی تاک</TableDataHead>
                <TableDataHead class="w-16"></TableDataHead>
                <TableDataHead class="w-16"></TableDataHead>
               </TableRowHead>
             </TableHead>
             <TableBody>
               <TableRow class="cursor-pointer " v-for="(product, index) in products.data" :key="product.id">
                <TableData class="w-16 ">{{ index + 1}}</TableData>
                <TableData class="w-96">{{ product.code_of_product }}</TableData>
                <TableData class="w-96 ">{{ product.name_of_product }}</TableData>
                <TableData class="w-16">0</TableData>
                <TableData class="w-16">0</TableData>
                <TableData class="w-16">{{ formatNumber(product.quantity_of_store) }}</TableData>
                <TableData  class="w-16">{{ formatNumber(product.quantity_of_box )}}</TableData>
                <TableData class="w-16"    :class="{
                   ' text-rose-300':
                     splitQuantities[index].remaining < 0,
                   'text-gray-100':
                     splitQuantities[index].remaining >= 0,
                 }">{{ splitQuantities[index].boxes }}</TableData>
                <TableData class="w-16"
                :class="{
                   ' text-rose-300':
                     splitQuantities[index].remaining < 0,
                   'text-gray-100':
                     splitQuantities[index].remaining >= 0,
                 }"
                 >{{ splitQuantities[index].remaining }}</TableData>
                <TableData class="w-16">{{ formatNumber(product.price_of_buy) }}</TableData>
                <TableData class="w-16">{{ formatNumber(product.price_of_sell_ko) }}</TableData>
                <TableData class="w-16">{{ formatNumber(product.price_of_sell_tak) }}</TableData>
                <TableData v-if="isFixVisible" class="w-16">{{ formatNumber(product.fix_number) }}</TableData>
                <TableData v-if="isFixVisible" class="w-16 text-cyan-400" ><button @click="UpdateFix(product.id)" ><FixNumberSvg/></button></TableData>
                <TableData @click.stop   class="w-10 whitespace-nowrap" >
                    <button   @click="confirmRestoreproduct(product.id)" class=" text-cyan-500"><RestoreSvg/></button>
                 </TableData>
                 <TableData @click.stop  class="w-10 whitespace-nowrap" ><button   @click="confirmDeleteproduct(product.id)" class=" text-rose-300"><DeleteSvg/></button>
                 </TableData>
                </TableRow>
             </TableBody>
           </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="products.links" :meta="products.meta" />
           </div>
           <span class="flex mr-auto">

           </span>
         </div>
       </div>
     </div>
   </main>
 </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, watch,  computed  } from "vue";

import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/Table.vue";
import TableBody from "@/Components/TableBody.vue";
import TableData from "@/Components/TableData.vue";
import TableHead from "@/Components/TableHead.vue";
import TableRow from "@/Components/TableRow.vue";
import CreateSvg from "@/Components/Svg/Create.vue";
import RestoreSvg from "@/Components/Svg/Restore.vue";
import DeleteSvg from "@/Components/Svg/Delete.vue";
import EditSvg from "@/Components/Svg/Edit.vue";
import TableRowHead from "@/Components/TableRowHead.vue";
import TableDataHead from "@/Components/TableDataHead.vue";
import { router } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { debounce } from 'lodash';
import PrimaryButton from"@/Components/PrimaryButton.vue";
import numeral from 'numeral';


const props = defineProps({
 products: Object,
});

const search = ref(props.products.search);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch(search, debounce((value) => {
 router.get(
   route("product.trash_show"),
   { search: value,  },
   {
     preserveState: true,
     replace: true,
   }
 );
}, 100));







const deleteproduct = (id) => {
  const categoryId = productToDelete.value ? productToDelete.value.category_id : '';
  router.delete(route('categories.products.destroy', { category: categoryId, product: productIdToDelete.value }), {
    onSuccess: () => closeModal(),
    preserveState: true,
    preserveScroll: true,
  });
};


const restoreproduct = (id) => {
   router.put(route('product.type_restore', { product: productIdToRestore.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};


const restoreproductAll = () => {
   router.put(route('product.type_restore_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};

const deleteproductAll = () => {
   router.delete(route('product.type_delete_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};

const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};

const splitQuantities = computed(() => {
  return props.products.data.map((product) => {
    const boxes = Math.floor(product.quantity_of_store / product.quantity_of_box);
    const remaining = product.quantity_of_store % product.quantity_of_box;
    return {
      boxes,
      remaining
    };
  });
});

const showConfirmDeleteproductModal = ref(false);

const productIdToDelete = ref(null);

const showConfirmRestoreproductModal = ref(false);

const showConfirmRestoreAllproductModal = ref(false);
const showConfirmDeleteAllproductModal = ref(false);


const confirmDeleteproduct = (id) => {
   productIdToDelete.value = id;
   showConfirmDeleteproductModal.value = true;
};

const confirmDeleteAllproduct = (id) => {
    showConfirmDeleteAllproductModal.value = true;
};
const confirmRestoreAllproduct = (id) => {
    showConfirmRestoreAllproductModal.value = true;
};


// // this is for close
const closeModal = () => {
   showConfirmDeleteproductModal.value = false;
};
const closeModalAll = () => {
    showConfirmDeleteAllproductModal.value = false;
};
const closeModalResAll = () => {
    showConfirmRestoreAllproductModal.value = false;
};


const productIdToRestore = ref(null);
// //thi is open by id

const confirmRestoreproduct = (id) => {
   productIdToRestore.value = id;
   showConfirmRestoreproductModal.value = true;
};
const closeModalRes = () => {
   showConfirmRestoreproductModal.value = false;
};
// //find data by id
const productToDelete = computed(() => {
   return props.products.data.find(product => product.id == productIdToDelete.value);
});
const productToRestore = computed(() => {
   return props.products.data.find(product => product.id == productIdToRestore.value);
});


</script>
