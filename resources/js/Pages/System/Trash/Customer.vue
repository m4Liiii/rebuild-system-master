<template>
    <Head title="لیستی کڕیارە سڕاوەکان" />
    <Modal
    :show="showConfirmRestoreAllcustomerModal"
    @close="closeModalResAll"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی هەموو کڕیارە سڕاوەکان ؟
        </h2>
        <div class="mt-5 text-cyan-400">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا پسولەکانیشی لەگەڵی دێنەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalResAll">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restorecustomerAll(),closeModalResAll()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
 <Modal
 :show="showConfirmDeleteAllcustomerModal"
 @close="closeModalAll"
>
 <div class="p-6">
     <h2 class="text-lg font-medium text-gray-200">
            ئایا تۆ دڵنیای لە سڕینەوەی یەکجاری هەموو کڕیارە سڕاوەکان ؟
     </h2>
     <div class="mt-5 text-rose-300">ئاگاداربە لە کاتی سڕینەوە , ئەوا پسولەکانیشی لەگەڵی دەسڕێنەوە.</div>
     <div class="flex justify-end mt-6">
         <SecondaryButton @click="closeModalAll">لابردن</SecondaryButton>
         <DangerButton class="mx-3 ml-3" @click="deletecustomerAll(),closeModalAll()">سڕینەوە</DangerButton >
     </div>
 </div>
</Modal>
    <Modal
    :show="showConfirmRestorecustomerModal"
    @close="closeModalRes"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی جۆری بابەتی ( {{ customerToRestore ? customerToRestore.name : '' }} ) ؟
        </h2>
        <div class="mt-5 text-cyan-400">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا پسولەکانیشی لەگەڵی دێنەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalRes">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restorecustomer(customerIdToRestore.value),closeModalRes()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
   <Modal
   :show="showConfirmDeletecustomerModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی جۆری بابەتی ( {{ customerToDelete ? customerToDelete.name : '' }} ) ؟
       </h2>
       <div class="mt-5 text-rose-300">ئاگاداربە لە کاتی سڕینەوە , ئەوا پسولەکانیشی لەگەڵی دەسڕێنەوە.</div>
       <div class="flex justify-end mt-6">
           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>
           <DangerButton  class="mx-3 ml-3" @click="deletecustomer(customerIdToDelete.value),closeModal()">سڕینەوە</DangerButton>
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
        <button class="p-4 mx-2 text-2xl rounded bg-zinc-700 text-cyan-500" @click="confirmRestoreAllcustomer"><RestoreSvg/></button>  <button @click="confirmDeleteAllcustomer"  class="p-4 mr-2 rounded bg-zinc-700 text-rose-300"><DeleteSvg/></button>
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
               <TableRow class="cursor-pointer " v-for="(customer, index) in customers.data" :key="customer.id">
                    <TableData     :class="{
                            'text-rose-300': customer.debt_customer > 0,
                            'text-gray-100 ': customer.debt_customer <= 0,
                          }" class="w-32">{{ index + 1}}</TableData>
                     <TableData     :class="{
                            'text-rose-300': customer.debt_customer > 0,
                            'text-gray-100 ': customer.debt_customer <= 0,
                          }" class="w-64">{{ customer.name_customer }}</TableData>
                     <TableData     :class="{
                            'text-rose-300': customer.debt_customer > 0,
                            'text-gray-100 ': customer.debt_customer <= 0,
                          }" class="w-32">{{ formatNumber(customer.debt_customer)}}</TableData>
                     <TableData     :class="{
                            'text-rose-300': customer.debt_customer > 0,
                            'text-gray-100 ': customer.debt_customer <= 0,
                          }" class="w-32">{{ customer.address }}</TableData>
                     <TableData     :class="{
                            'text-rose-300': customer.debt_customer > 0,
                            'text-gray-100 ': customer.debt_customer <= 0,
                          }" class="w-32">{{ customer.phone_number }}</TableData>
                     <TableData     :class="{
                            'text-rose-300': customer.debt_customer > 0,
                            'text-gray-100 ': customer.debt_customer <= 0,
                          }" class="w-32">{{ customer.social_number }}</TableData>
                          <TableData @click.stop   class="w-10 whitespace-nowrap" >
                            <button   @click="confirmRestorecustomer(customer.id)" class=" text-cyan-500"><RestoreSvg/></button>
                         </TableData>
                         <TableData @click.stop class="w-10 whitespace-nowrap" ><button   @click="confirmDeletecustomer(customer.id)" class=" text-rose-300"><DeleteSvg/></button>
                        </TableData>
               </TableRow>
             </TableBody>
           </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="customers.links" :meta="customers.meta" />
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
 customers: Object,
});

const search = ref(props.customers.search);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch(search, debounce((value) => {
 router.get(
   route("customer.trash_show"),
   { search: value,  },
   {
     preserveState: true,
     replace: true,
   }
 );
}, 100));






const deletecustomer = (id) => {
   router.delete(route('customers.destroy', { customer: customerIdToDelete.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};

const restorecustomer = (id) => {
   router.put(route('customer.type_restore', { customer: customerIdToRestore.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};


const restorecustomerAll = () => {
   router.put(route('customer.type_restore_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};

const deletecustomerAll = () => {
   router.delete(route('customer.type_delete_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};




const showConfirmDeletecustomerModal = ref(false);

const customerIdToDelete = ref(null);

const showConfirmRestorecustomerModal = ref(false);

const showConfirmRestoreAllcustomerModal = ref(false);
const showConfirmDeleteAllcustomerModal = ref(false);


const confirmDeletecustomer = (id) => {
   customerIdToDelete.value = id;
   showConfirmDeletecustomerModal.value = true;
};

const confirmDeleteAllcustomer = (id) => {
    showConfirmDeleteAllcustomerModal.value = true;
};
const confirmRestoreAllcustomer = (id) => {
    showConfirmRestoreAllcustomerModal.value = true;
};


// // this is for close
const closeModal = () => {
   showConfirmDeletecustomerModal.value = false;
};
const closeModalAll = () => {
    showConfirmDeleteAllcustomerModal.value = false;
};
const closeModalResAll = () => {
    showConfirmRestoreAllcustomerModal.value = false;
};


const customerIdToRestore = ref(null);
// //thi is open by id

const confirmRestorecustomer = (id) => {
   customerIdToRestore.value = id;
   showConfirmRestorecustomerModal.value = true;
};
const closeModalRes = () => {
   showConfirmRestorecustomerModal.value = false;
};
// //find data by id
const customerToDelete = computed(() => {
   return props.customers.data.find(customer => customer.id == customerIdToDelete.value);
});
const customerToRestore = computed(() => {
   return props.customers.data.find(customer => customer.id == customerIdToRestore.value);
});


</script>
