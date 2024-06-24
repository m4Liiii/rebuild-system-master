<template>
    <Head title="لیستی کڕیارە سڕاوەکان" />
    <Modal
    :show="showConfirmRestoreAllofficeModal"
    @close="closeModalResAll"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی هەموو کڕیارە سڕاوەکان ؟
        </h2>
        <div class="mt-5 text-cyan-400">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا پسولەکانیشی لەگەڵی دێنەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalResAll">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreofficeAll(),closeModalResAll()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
 <Modal
 :show="showConfirmDeleteAllofficeModal"
 @close="closeModalAll"
>
 <div class="p-6">
     <h2 class="text-lg font-medium text-gray-200">
            ئایا تۆ دڵنیای لە سڕینەوەی یەکجاری هەموو کڕیارە سڕاوەکان ؟
     </h2>
     <div class="mt-5 text-rose-300">ئاگاداربە لە کاتی سڕینەوە , ئەوا پسولەکانیشی لەگەڵی دەسڕێنەوە.</div>
     <div class="flex justify-end mt-6">
         <SecondaryButton @click="closeModalAll">لابردن</SecondaryButton>
         <DangerButton class="mx-3 ml-3" @click="deleteofficeAll(),closeModalAll()">سڕینەوە</DangerButton >
     </div>
 </div>
</Modal>
    <Modal
    :show="showConfirmRestoreofficeModal"
    @close="closeModalRes"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی جۆری بابەتی ( {{ officeToRestore ? officeToRestore.name : '' }} ) ؟
        </h2>
        <div class="mt-5 text-cyan-400">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا پسولەکانیشی لەگەڵی دێنەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalRes">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreoffice(officeIdToRestore.value),closeModalRes()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
   <Modal
   :show="showConfirmDeleteofficeModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی جۆری بابەتی ( {{ officeToDelete ? officeToDelete.name : '' }} ) ؟
       </h2>
       <div class="mt-5 text-rose-300">ئاگاداربە لە کاتی سڕینەوە , ئەوا پسولەکانیشی لەگەڵی دەسڕێنەوە.</div>
       <div class="flex justify-end mt-6">
           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>
           <DangerButton  class="mx-3 ml-3" @click="deleteoffice(officeIdToDelete.value),closeModal()">سڕینەوە</DangerButton>
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
                 لیستی کڕیارە سڕاوەکان
           </div>
       </div>
       <div class="flex items-center pb-7">
        <button class="p-4 mx-2 text-2xl rounded bg-zinc-700 text-cyan-500" @click="confirmRestoreAlloffice"><RestoreSvg/></button>  <button @click="confirmDeleteAlloffice"  class="p-4 mr-2 rounded bg-zinc-700 text-rose-300"><DeleteSvg/></button>
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
               <TableRow class="cursor-pointer " v-for="(office, index) in offices.data" :key="office.id">
                    <TableData     :class="{
                            'text-rose-300': office.debt_office > 0,
                            'text-gray-100 ': office.debt_office <= 0,
                          }" class="w-32">{{ index + 1}}</TableData>
                     <TableData     :class="{
                            'text-rose-300': office.debt_office > 0,
                            'text-gray-100 ': office.debt_office <= 0,
                          }" class="w-64">{{ office.name_office }}</TableData>
                     <TableData     :class="{
                            'text-rose-300': office.debt_office > 0,
                            'text-gray-100 ': office.debt_office <= 0,
                          }" class="w-32">{{ formatNumber(office.debt_office)}}</TableData>
                     <TableData     :class="{
                            'text-rose-300': office.debt_office > 0,
                            'text-gray-100 ': office.debt_office <= 0,
                          }" class="w-32">{{ office.address }}</TableData>
                     <TableData     :class="{
                            'text-rose-300': office.debt_office > 0,
                            'text-gray-100 ': office.debt_office <= 0,
                          }" class="w-32">{{ office.phone_number }}</TableData>
                     <TableData     :class="{
                            'text-rose-300': office.debt_office > 0,
                            'text-gray-100 ': office.debt_office <= 0,
                          }" class="w-32">{{ office.social_number }}</TableData>
                          <TableData @click.stop   class="w-10 whitespace-nowrap" >
                            <button   @click="confirmRestoreoffice(office.id)" class=" text-cyan-500"><RestoreSvg/></button>
                         </TableData>
                         <TableData @click.stop class="w-10 whitespace-nowrap" ><button   @click="confirmDeleteoffice(office.id)" class=" text-rose-300"><DeleteSvg/></button>
                        </TableData>
               </TableRow>
             </TableBody>
           </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="offices.links" :meta="offices.meta" />
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
 offices: Object,
});

const search = ref(props.offices.search);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch(search, debounce((value) => {
 router.get(
   route("office.trash_show"),
   { search: value,  },
   {
     preserveState: true,
     replace: true,
   }
 );
}, 100));






const deleteoffice = (id) => {
   router.delete(route('offices.destroy', { office: officeIdToDelete.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};

const restoreoffice = (id) => {
   router.put(route('office.type_restore', { office: officeIdToRestore.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};


const restoreofficeAll = () => {
   router.put(route('office.type_restore_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};

const deleteofficeAll = () => {
   router.delete(route('office.type_delete_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};




const showConfirmDeleteofficeModal = ref(false);

const officeIdToDelete = ref(null);

const showConfirmRestoreofficeModal = ref(false);

const showConfirmRestoreAllofficeModal = ref(false);
const showConfirmDeleteAllofficeModal = ref(false);


const confirmDeleteoffice = (id) => {
   officeIdToDelete.value = id;
   showConfirmDeleteofficeModal.value = true;
};

const confirmDeleteAlloffice = (id) => {
    showConfirmDeleteAllofficeModal.value = true;
};
const confirmRestoreAlloffice = (id) => {
    showConfirmRestoreAllofficeModal.value = true;
};


// // this is for close
const closeModal = () => {
   showConfirmDeleteofficeModal.value = false;
};
const closeModalAll = () => {
    showConfirmDeleteAllofficeModal.value = false;
};
const closeModalResAll = () => {
    showConfirmRestoreAllofficeModal.value = false;
};


const officeIdToRestore = ref(null);
// //thi is open by id

const confirmRestoreoffice = (id) => {
   officeIdToRestore.value = id;
   showConfirmRestoreofficeModal.value = true;
};
const closeModalRes = () => {
   showConfirmRestoreofficeModal.value = false;
};
// //find data by id
const officeToDelete = computed(() => {
   return props.offices.data.find(office => office.id == officeIdToDelete.value);
});
const officeToRestore = computed(() => {
   return props.offices.data.find(office => office.id == officeIdToRestore.value);
});


</script>
