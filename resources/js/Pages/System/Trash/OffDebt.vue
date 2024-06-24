<template>
    <Head title="لیستی پسولە سڕاوەکان" />
    <Modal
    :show="showConfirmRestoreAlloffDebtModal"
    @close="closeModalResAll"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی هەموو پسولە سڕاوەکان ؟
        </h2>
        <div class="mt-5 text-cyan-400" >ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا کڕیارەکانیشی لەگەڵی دێتەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalResAll">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreoffDebtAll(),closeModalResAll()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
 <Modal
 :show="showConfirmDeleteAlloffDebtModal"
 @close="closeModalAll"
>
 <div class="p-6">
     <h2 class="text-lg font-medium text-gray-200">
            ئایا تۆ دڵنیای لە سڕینەوەی یەکجاری هەموو پسولە سڕاوەکان ؟
     </h2>
     <div class="flex justify-end mt-6">
         <SecondaryButton @click="closeModalAll">لابردن</SecondaryButton>
         <DangerButton class="mx-3 ml-3" @click="deleteoffDebtAll(),closeModalAll()">سڕینەوە</DangerButton >
     </div>
 </div>
</Modal>
    <Modal
    :show="showConfirmRestoreoffDebtModal"
    @close="closeModalRes"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی پسولەی ( {{ offDebtToRestore ? offDebtToRestore.id : '' }} ) ؟
        </h2>
        <div class="mt-5 text-cyan-400" v-if="offDebtToRestore.office && offDebtToRestore.office.type_delete == '0'">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا کڕیارەکەش لەگەڵی دێتەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalRes">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreoffDebt(offDebtIdToRestore.value),closeModalRes()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
   <Modal
   :show="showConfirmDeleteoffDebtModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی پسولەی ( {{ offDebtToDelete ? offDebtToDelete.id : '' }} ) ؟
       </h2>
       <div class="flex justify-end mt-6">
           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>
           <DangerButton  class="mx-3 ml-3" @click="deleteoffDebt(offDebtIdToDelete.value),closeModal()">سڕینەوە</DangerButton>
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
        <button class="p-4 mx-2 rounded bg-zinc-700 text-cyan-500" @click="confirmRestoreAlloffDebt"><RestoreSvg/></button>  <button @click="confirmDeleteAlloffDebt"  class="p-4 mr-2 rounded bg-zinc-700 text-rose-300"><DeleteSvg/></button>
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

                    <TableDataHead class="w-12">بڕی پارەدان</TableDataHead>
                    <TableDataHead class="w-12">داشکاندن</TableDataHead>
                    <TableDataHead class="w-12"></TableDataHead>
                    <TableDataHead class="w-12"></TableDataHead>
                  </TableRowHead>
                </TableHead>
                <TableBody>
                  <TableRow v-for="offDebt in offDebts.data" :key="offDebt.id">
                   <TableData class="w-12 ">{{ offDebt.id }}</TableData>
                   <TableData class="w-12 ">{{ formattedDate(offDebt.created_at) }}</TableData>
                    <TableData class="w-12">{{ offDebt.user ? offDebt.user.name : "" }}</TableData>
                    <TableData class="w-12">{{ offDebt.office ? offDebt.office.name_office : "" }}</TableData>

                    <TableData class="w-12">{{ formatNumber(offDebt.amount_of_debt) }}</TableData>
                    <TableData class="w-12">{{ formatNumber(offDebt.discount) }}</TableData>
                    <TableData class=" whitespace-nowrap" ><button   @click="confirmDeleteoffDebt(offDebt.id)" class="text-rose-300"><DeleteSvg/></button>
                    </TableData>
                    <TableData  class="w-12">
                   <button class="text-cyan-500"  @click="confirmRestoreoffDebt(offDebt.id)"> <RestoreSvg/> </button></TableData>

                   </TableRow>


                </TableBody>
              </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="offDebts.links" :meta="offDebts.meta" />
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
 offDebts: Object,
});
const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};
const formattedDate = (dateString) => {
  return format(new Date(dateString), 'yyyy-MM-dd');
};

const search = ref(props.offDebts.search);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch(search, debounce((value) => {
 router.get(
   route("offdebt.trash_show"),
   { search: value,  },
   {
     preserveState: true,
     replace: true,
   }
 );
}, 100));






const deleteoffDebt = (id) => {
  const officeId = offDebtToDelete.value ? offDebtToDelete.value.office_id : '';
  router.delete(route('offices.offdebts.destroy', { office: officeId, offdebt: offDebtIdToDelete.value }), {
    onSuccess: () => closeModal(),
    preserveState: true,
    preserveScroll: true,
  });
};


const restoreoffDebt = (id) => {
   router.put(route('offdebt.type_restore', { offdebt: offDebtIdToRestore.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};


const restoreoffDebtAll = () => {
   router.put(route('offdebt.type_restore_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};

const deleteoffDebtAll = () => {
   router.delete(route('offdebt.type_delete_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};




const showConfirmDeleteoffDebtModal = ref(false);

const offDebtIdToDelete = ref(null);

const showConfirmRestoreoffDebtModal = ref(false);

const showConfirmRestoreAlloffDebtModal = ref(false);
const showConfirmDeleteAlloffDebtModal = ref(false);


const confirmDeleteoffDebt = (id) => {
   offDebtIdToDelete.value = id;
   showConfirmDeleteoffDebtModal.value = true;
};

const confirmDeleteAlloffDebt = (id) => {
    showConfirmDeleteAlloffDebtModal.value = true;
};
const confirmRestoreAlloffDebt = (id) => {
    showConfirmRestoreAlloffDebtModal.value = true;
};


// // this is for close
const closeModal = () => {
   showConfirmDeleteoffDebtModal.value = false;
};
const closeModalAll = () => {
    showConfirmDeleteAlloffDebtModal.value = false;
};
const closeModalResAll = () => {
    showConfirmRestoreAlloffDebtModal.value = false;
};


const offDebtIdToRestore = ref(null);
// //thi is open by id

const confirmRestoreoffDebt = (id) => {
   offDebtIdToRestore.value = id;
   showConfirmRestoreoffDebtModal.value = true;
};
const closeModalRes = () => {
   showConfirmRestoreoffDebtModal.value = false;
};
// //find data by id
const offDebtToDelete = computed(() => {
   return props.offDebts.data.find(offDebt => offDebt.id == offDebtIdToDelete.value);
});
const offDebtToRestore = computed(() => {
   return props.offDebts.data.find(offDebt => offDebt.id == offDebtIdToRestore.value);
});


</script>
