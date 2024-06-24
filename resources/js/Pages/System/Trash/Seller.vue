<template>
    <Head title="لیستی فرۆشیارە سڕاوەکان" />
    <Modal
    :show="showConfirmRestoreAllsellerModal"
    @close="closeModalResAll"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی هەموو فرۆشیارە سڕاوەکان ؟
        </h2>
        <div class="mt-5 text-cyan-400">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا پسولەکانیشی لەگەڵی دێنەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalResAll">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoresellerAll(),closeModalResAll()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
 <Modal
 :show="showConfirmDeleteAllsellerModal"
 @close="closeModalAll"
>
 <div class="p-6">
     <h2 class="text-lg font-medium text-gray-200">
            ئایا تۆ دڵنیای لە سڕینەوەی یەکجاری هەموو فرۆشیارە سڕاوەکان ؟
     </h2>
     <div class="mt-5 text-rose-300">ئاگاداربە لە کاتی سڕینەوە , ئەوا پسولەکانیشی لەگەڵی دەسڕێنەوە.</div>
     <div class="flex justify-end mt-6">
         <SecondaryButton @click="closeModalAll">لابردن</SecondaryButton>
         <DangerButton class="mx-3 ml-3" @click="deletesellerAll(),closeModalAll()">سڕینەوە</DangerButton >
     </div>
 </div>
</Modal>
    <Modal
    :show="showConfirmRestoresellerModal"
    @close="closeModalRes"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی جۆری بابەتی ( {{ sellerToRestore ? sellerToRestore.name : '' }} ) ؟
        </h2>
        <div class="mt-5 text-cyan-400">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا پسولەکانیشی لەگەڵی دێنەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalRes">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreseller(sellerIdToRestore.value),closeModalRes()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
   <Modal
   :show="showConfirmDeletesellerModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی جۆری بابەتی ( {{ sellerToDelete ? sellerToDelete.name : '' }} ) ؟
       </h2>
       <div class="mt-5 text-rose-300">ئاگاداربە لە کاتی سڕینەوە , ئەوا پسولەکانیشی لەگەڵی دەسڕێنەوە.</div>
       <div class="flex justify-end mt-6">
           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>
           <DangerButton  class="mx-3 ml-3" @click="deleteseller(sellerIdToDelete.value),closeModal()">سڕینەوە</DangerButton>
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
                 لیستی فرۆشیارە سڕاوەکان
           </div>
       </div>
       <div class="flex items-center pb-7">
        <button class="p-4 mx-2 text-2xl rounded bg-zinc-700 text-cyan-500" @click="confirmRestoreAllseller"><RestoreSvg/></button>  <button @click="confirmDeleteAllseller"  class="p-4 mr-2 rounded bg-zinc-700 text-rose-300"><DeleteSvg/></button>
    </div>
    </div>
       <div class="w-full overflow-hidden rounded-[5px] shadow-xs">
         <div class="w-full overflow-x-auto">
           <Table>
             <TableHead>
               <TableRowHead>
                <TableDataHead class="w-32">#</TableDataHead>
                <TableDataHead class="w-64">ناو</TableDataHead>
                <TableDataHead class="w-32">بڕی قەرز</TableDataHead>
                <TableDataHead class="w-32">ناونیشان</TableDataHead>
                <TableDataHead class="w-32">ژمارەی مۆبایل</TableDataHead>
                <TableDataHead class="w-32">ژمارەی WH</TableDataHead>
                <TableDataHead class="w-4"></TableDataHead>
                <TableDataHead class="w-4"> </TableDataHead>
               </TableRowHead>
             </TableHead>
             <TableBody>
               <TableRow class="cursor-pointer " v-for="(seller, index) in sellers.data" :key="seller.id">
                    <TableData     :class="{
                            'text-rose-300': seller.debt_seller > 0,
                            'text-gray-100 ': seller.debt_seller <= 0,
                          }" class="w-32">{{ index + 1}}</TableData>
                     <TableData     :class="{
                            'text-rose-300': seller.debt_seller > 0,
                            'text-gray-100 ': seller.debt_seller <= 0,
                          }" class="w-64">{{ seller.name_seller }}</TableData>
                     <TableData     :class="{
                            'text-rose-300': seller.debt_seller > 0,
                            'text-gray-100 ': seller.debt_seller <= 0,
                          }" class="w-32">{{ formatNumber(seller.debt_seller)}}</TableData>
                     <TableData     :class="{
                            'text-rose-300': seller.debt_seller > 0,
                            'text-gray-100 ': seller.debt_seller <= 0,
                          }" class="w-32">{{ seller.address }}</TableData>
                     <TableData     :class="{
                            'text-rose-300': seller.debt_seller > 0,
                            'text-gray-100 ': seller.debt_seller <= 0,
                          }" class="w-32">{{ seller.phone_number }}</TableData>
                     <TableData     :class="{
                            'text-rose-300': seller.debt_seller > 0,
                            'text-gray-100 ': seller.debt_seller <= 0,
                          }" class="w-32">{{ seller.social_number }}</TableData>
                          <TableData @click.stop   class="w-10 whitespace-nowrap" >
                            <button   @click="confirmRestoreseller(seller.id)" class=" text-cyan-500"><RestoreSvg/></button>
                         </TableData>
                         <TableData @click.stop class="w-10 whitespace-nowrap" ><button   @click="confirmDeleteseller(seller.id)" class=" text-rose-300"><DeleteSvg/></button>
                        </TableData>
               </TableRow>
             </TableBody>
           </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="sellers.links" :meta="sellers.meta" />
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


const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};

const props = defineProps({
 sellers: Object,
});

const search = ref(props.sellers.search);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch(search, debounce((value) => {
 router.get(
   route("seller.trash_show"),
   { search: value,  },
   {
     preserveState: true,
     replace: true,
   }
 );
}, 100));






const deleteseller = (id) => {
   router.delete(route('sellers.destroy', { seller: sellerIdToDelete.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};

const restoreseller = (id) => {
   router.put(route('seller.type_restore', { seller: sellerIdToRestore.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};


const restoresellerAll = () => {
   router.put(route('seller.type_restore_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};

const deletesellerAll = () => {
   router.delete(route('seller.type_delete_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};




const showConfirmDeletesellerModal = ref(false);

const sellerIdToDelete = ref(null);

const showConfirmRestoresellerModal = ref(false);

const showConfirmRestoreAllsellerModal = ref(false);
const showConfirmDeleteAllsellerModal = ref(false);


const confirmDeleteseller = (id) => {
   sellerIdToDelete.value = id;
   showConfirmDeletesellerModal.value = true;
};

const confirmDeleteAllseller = (id) => {
    showConfirmDeleteAllsellerModal.value = true;
};
const confirmRestoreAllseller = (id) => {
    showConfirmRestoreAllsellerModal.value = true;
};


// // this is for close
const closeModal = () => {
   showConfirmDeletesellerModal.value = false;
};
const closeModalAll = () => {
    showConfirmDeleteAllsellerModal.value = false;
};
const closeModalResAll = () => {
    showConfirmRestoreAllsellerModal.value = false;
};


const sellerIdToRestore = ref(null);
// //thi is open by id

const confirmRestoreseller = (id) => {
   sellerIdToRestore.value = id;
   showConfirmRestoresellerModal.value = true;
};
const closeModalRes = () => {
   showConfirmRestoresellerModal.value = false;
};
// //find data by id
const sellerToDelete = computed(() => {
   return props.sellers.data.find(seller => seller.id == sellerIdToDelete.value);
});
const sellerToRestore = computed(() => {
   return props.sellers.data.find(seller => seller.id == sellerIdToRestore.value);
});


</script>
