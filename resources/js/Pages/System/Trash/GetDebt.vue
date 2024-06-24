<template>
    <Head title="لیستی پسولە سڕاوەکان" />
    <Modal
    :show="showConfirmRestoreAllgetDebtModal"
    @close="closeModalResAll"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی هەموو پسولە سڕاوەکان ؟
        </h2>
        <div class="mt-5 text-cyan-400" >ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا کڕیارەکانیشی لەگەڵی دێتەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalResAll">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoregetDebtAll(),closeModalResAll()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
 <Modal
 :show="showConfirmDeleteAllgetDebtModal"
 @close="closeModalAll"
>
 <div class="p-6">
     <h2 class="text-lg font-medium text-gray-200">
            ئایا تۆ دڵنیای لە سڕینەوەی یەکجاری هەموو پسولە سڕاوەکان ؟
     </h2>
     <div class="flex justify-end mt-6">
         <SecondaryButton @click="closeModalAll">لابردن</SecondaryButton>
         <DangerButton class="mx-3 ml-3" @click="deletegetDebtAll(),closeModalAll()">سڕینەوە</DangerButton >
     </div>
 </div>
</Modal>
    <Modal
    :show="showConfirmRestoregetDebtModal"
    @close="closeModalRes"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی پسولەی ( {{ getDebtToRestore ? getDebtToRestore.id : '' }} ) ؟
        </h2>
        <div class="mt-5 text-cyan-400" v-if="getDebtToRestore.customer && getDebtToRestore.customer.type_delete == '0'">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا کڕیارەکەش لەگەڵی دێتەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalRes">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoregetDebt(getDebtIdToRestore.value),closeModalRes()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
   <Modal
   :show="showConfirmDeletegetDebtModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی پسولەی ( {{ getDebtToDelete ? getDebtToDelete.id : '' }} ) ؟
       </h2>
       <div class="flex justify-end mt-6">
           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>
           <DangerButton  class="mx-3 ml-3" @click="deletegetDebt(getDebtIdToDelete.value),closeModal()">سڕینەوە</DangerButton>
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
                 لیستی پسولە سڕاوەکان
           </div>
       </div>
       <div class="flex items-center pb-7">
        <button class="p-4 mx-2 rounded bg-zinc-700 text-cyan-500" @click="confirmRestoreAllgetDebt"><RestoreSvg/></button>  <button @click="confirmDeleteAllgetDebt"  class="p-4 mr-2 rounded bg-zinc-700 text-rose-300"><DeleteSvg/></button>
    </div>
    </div>
       <div class="w-full overflow-hidden rounded-[5px] shadow-xs">
         <div class="w-full overflow-x-auto">
            <Table>
                <TableHead>
                  <TableRowHead>
                    <TableDataHead class="w-12">#</TableDataHead>
                    <TableDataHead class="w-12">بەروار</TableDataHead>
                    <TableDataHead class="w-12">بەکارهێنەر</TableDataHead>
                    <TableDataHead class="w-32">کڕیار</TableDataHead>
                    <TableDataHead class="w-12">کۆی گشتی</TableDataHead>
                    <TableDataHead class="w-12">بڕی پارەدان</TableDataHead>
                    <TableDataHead class="w-12">داشکاندن</TableDataHead>
                    <TableDataHead class="w-12"></TableDataHead>
                    <TableDataHead class="w-12"></TableDataHead>
                  </TableRowHead>
                </TableHead>
                <TableBody>
                  <TableRow v-for="getDebt in getDebts.data" :key="getDebt.id">
                   <TableData class="w-12 ">{{ getDebt.s_id }}</TableData>
                   <TableData class="w-12 ">{{ formattedDate(getDebt.created_at) }}</TableData>
                    <TableData class="w-12">{{ getDebt.user ? getDebt.user.name : "" }}</TableData>
                    <TableData class="w-12">{{ getDebt.customer ? getDebt.customer.name_customer : "" }}</TableData>
                    <TableData class="w-12">{{ formatNumber(getDebt.total_price) }}</TableData>
                    <TableData class="w-12">{{ formatNumber(getDebt.amount_of_debt) }}</TableData>
                    <TableData class="w-12">{{ formatNumber(getDebt.discount) }}</TableData>
                    <TableData class=" whitespace-nowrap" ><button   @click="confirmDeletegetDebt(getDebt.id)" class="text-rose-300"><DeleteSvg/></button>
                    </TableData>
                    <TableData  class="w-12">
                   <button class="text-cyan-500"  @click="confirmRestoregetDebt(getDebt.id)"> <RestoreSvg/> </button></TableData>

                   </TableRow>


                </TableBody>
              </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="getDebts.links" :meta="getDebts.meta" />
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
import { format } from 'date-fns';




const props = defineProps({
 getDebts: Object,
});
const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};
const formattedDate = (dateString) => {
  return format(new Date(dateString), 'yyyy-MM-dd');
};

const search = ref(props.getDebts.search);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch(search, debounce((value) => {
 router.get(
   route("getdebt.trash_show"),
   { search: value,  },
   {
     preserveState: true,
     replace: true,
   }
 );
}, 100));







const deletegetDebt = (id) => {
  const customerId = getDebtToDelete.value ? getDebtToDelete.value.customer_id : '';
  router.delete(route('customers.getdebts.destroy', { customer: customerId, getdebt: getDebtIdToDelete.value }), {
    onSuccess: () => closeModal(),
    preserveState: true,
    preserveScroll: true,
  });
};


const restoregetDebt = (id) => {
   router.put(route('getdebt.type_restore', { getdebt: getDebtIdToRestore.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};


const restoregetDebtAll = () => {
   router.put(route('getdebt.type_restore_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};

const deletegetDebtAll = () => {
   router.delete(route('getdebt.type_delete_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};




const showConfirmDeletegetDebtModal = ref(false);

const getDebtIdToDelete = ref(null);

const showConfirmRestoregetDebtModal = ref(false);

const showConfirmRestoreAllgetDebtModal = ref(false);
const showConfirmDeleteAllgetDebtModal = ref(false);


const confirmDeletegetDebt = (id) => {
   getDebtIdToDelete.value = id;
   showConfirmDeletegetDebtModal.value = true;
};

const confirmDeleteAllgetDebt = (id) => {
    showConfirmDeleteAllgetDebtModal.value = true;
};
const confirmRestoreAllgetDebt = (id) => {
    showConfirmRestoreAllgetDebtModal.value = true;
};


// // this is for close
const closeModal = () => {
   showConfirmDeletegetDebtModal.value = false;
};
const closeModalAll = () => {
    showConfirmDeleteAllgetDebtModal.value = false;
};
const closeModalResAll = () => {
    showConfirmRestoreAllgetDebtModal.value = false;
};


const getDebtIdToRestore = ref(null);
// //thi is open by id

const confirmRestoregetDebt = (id) => {
   getDebtIdToRestore.value = id;
   showConfirmRestoregetDebtModal.value = true;
};
const closeModalRes = () => {
   showConfirmRestoregetDebtModal.value = false;
};
// //find data by id
const getDebtToDelete = computed(() => {
   return props.getDebts.data.find(getDebt => getDebt.id == getDebtIdToDelete.value);
});
const getDebtToRestore = computed(() => {
   return props.getDebts.data.find(getDebt => getDebt.id == getDebtIdToRestore.value);
});


</script>
