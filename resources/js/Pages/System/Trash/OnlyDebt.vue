<template>
    <Head title="لیستی پسولە سڕاوەکان" />
    <Modal
    :show="showConfirmRestoreAllonlyDebtModal"
    @close="closeModalResAll"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی هەموو پسولە سڕاوەکان ؟
        </h2>
        <div class="mt-5 text-cyan-400" >ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا قەرزارەکانیش لەگەڵی دێتەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalResAll">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreonlyDebtAll(),closeModalResAll()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
 <Modal
 :show="showConfirmDeleteAllonlyDebtModal"
 @close="closeModalAll"
>
 <div class="p-6">
     <h2 class="text-lg font-medium text-gray-200">
            ئایا تۆ دڵنیای لە سڕینەوەی یەکجاری هەموو پسولە سڕاوەکان ؟
     </h2>
     <div class="flex justify-end mt-6">
         <SecondaryButton @click="closeModalAll">لابردن</SecondaryButton>
         <DangerButton class="mx-3 ml-3" @click="deleteonlyDebtAll(),closeModalAll()">سڕینەوە</DangerButton >
     </div>
 </div>
</Modal>
    <Modal
    :show="showConfirmRestoreonlyDebtModal"
    @close="closeModalRes"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی پسولەی ( {{ onlyDebtToRestore ? onlyDebtToRestore.id : '' }} ) ؟
        </h2>
        <div class="mt-5 text-cyan-400" v-if="onlyDebtToRestore.debtor && onlyDebtToRestore.debtor.type_delete == '0'">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا کڕیارەکەش لەگەڵی دێتەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalRes">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreonlyDebt(onlyDebtIdToRestore.value),closeModalRes()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
   <Modal
   :show="showConfirmDeleteonlyDebtModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی پسولەی ( {{ onlyDebtToDelete ? onlyDebtToDelete.id : '' }} ) ؟
       </h2>
       <div class="flex justify-end mt-6">
           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>
           <DangerButton  class="mx-3 ml-3" @click="deleteonlyDebt(onlyDebtIdToDelete.value),closeModal()">سڕینەوە</DangerButton>
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
        <button class="p-4 mx-2 rounded bg-zinc-700 text-cyan-500" @click="confirmRestoreAllonlyDebt"><RestoreSvg/></button>  <button @click="confirmDeleteAllonlyDebt"  class="p-4 mr-2 rounded bg-zinc-700 text-rose-300"><DeleteSvg/></button>
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
                  <TableRow v-for="onlyDebt in onlyDebts.data" :key="onlyDebt.id">
                   <TableData class="w-12 ">{{ onlyDebt.id }}</TableData>
                   <TableData class="w-12 ">{{ formattedDate(onlyDebt.created_at) }}</TableData>
                    <TableData class="w-12">{{ onlyDebt.user ? onlyDebt.user.name : "" }}</TableData>
                    <TableData class="w-12">{{ onlyDebt.debtor ? onlyDebt.debtor.name_debtor : "" }}</TableData>
                    <TableData class="w-12">{{ formatNumber(onlyDebt.total_price) }}</TableData>
                    <TableData class="w-12">{{ formatNumber(onlyDebt.amount_of_debt) }}</TableData>
                    <TableData class="w-12">{{ formatNumber(onlyDebt.discount) }}</TableData>
                    <TableData class=" whitespace-nowrap" ><button   @click="confirmDeleteonlyDebt(onlyDebt.id)" class="text-rose-300"><DeleteSvg/></button>
                    </TableData>
                    <TableData  class="w-12">
                   <button class="text-cyan-500"  @click="confirmRestoreonlyDebt(onlyDebt.id)"> <RestoreSvg/> </button></TableData>

                   </TableRow>


                </TableBody>
              </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="onlyDebts.links" :meta="onlyDebts.meta" />
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
 onlyDebts: Object,
});
const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};
const formattedDate = (dateString) => {
  return format(new Date(dateString), 'yyyy-MM-dd');
};

const search = ref(props.onlyDebts.search);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch(search, debounce((value) => {
 router.get(
   route("onlydebt.trash_show"),
   { search: value,  },
   {
     preserveState: true,
     replace: true,
   }
 );
}, 100));






const deleteonlyDebt = (id) => {
  const debtorId = onlyDebtToDelete.value ? onlyDebtToDelete.value.debtor_id : '';
  router.delete(route('debtors.onlydebts.destroy', { debtor: debtorId, onlydebt: onlyDebtIdToDelete.value }), {
    onSuccess: () => closeModal(),
    preserveState: true,
    preserveScroll: true,
  });
};


const restoreonlyDebt = (id) => {
   router.put(route('onlydebt.type_restore', { onlydebt: onlyDebtIdToRestore.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};


const restoreonlyDebtAll = () => {
   router.put(route('onlydebt.type_restore_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};

const deleteonlyDebtAll = () => {
   router.delete(route('onlydebt.type_delete_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};




const showConfirmDeleteonlyDebtModal = ref(false);

const onlyDebtIdToDelete = ref(null);

const showConfirmRestoreonlyDebtModal = ref(false);

const showConfirmRestoreAllonlyDebtModal = ref(false);
const showConfirmDeleteAllonlyDebtModal = ref(false);


const confirmDeleteonlyDebt = (id) => {
   onlyDebtIdToDelete.value = id;
   showConfirmDeleteonlyDebtModal.value = true;
};

const confirmDeleteAllonlyDebt = (id) => {
    showConfirmDeleteAllonlyDebtModal.value = true;
};
const confirmRestoreAllonlyDebt = (id) => {
    showConfirmRestoreAllonlyDebtModal.value = true;
};


// // this is for close
const closeModal = () => {
   showConfirmDeleteonlyDebtModal.value = false;
};
const closeModalAll = () => {
    showConfirmDeleteAllonlyDebtModal.value = false;
};
const closeModalResAll = () => {
    showConfirmRestoreAllonlyDebtModal.value = false;
};


const onlyDebtIdToRestore = ref(null);
// //thi is open by id

const confirmRestoreonlyDebt = (id) => {
   onlyDebtIdToRestore.value = id;
   showConfirmRestoreonlyDebtModal.value = true;
};
const closeModalRes = () => {
   showConfirmRestoreonlyDebtModal.value = false;
};
// //find data by id
const onlyDebtToDelete = computed(() => {
   return props.onlyDebts.data.find(onlyDebt => onlyDebt.id == onlyDebtIdToDelete.value);
});
const onlyDebtToRestore = computed(() => {
   return props.onlyDebts.data.find(onlyDebt => onlyDebt.id == onlyDebtIdToRestore.value);
});


</script>
