<template>
    <Head title="لیستی جۆری بابەتە سڕاوەکان" />
    <Modal
    :show="showConfirmRestoreAllCategoryModal"
    @close="closeModalResAll"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی هەموو جۆری بابەتە سڕاوەکان ؟
        </h2>
        <div class="mt-5 text-cyan-400">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا بابەتەکانیشی لەگەڵی دێنەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalResAll">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreCategoryAll(),closeModalResAll()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
 <Modal
 :show="showConfirmDeleteAllCategoryModal"
 @close="closeModalAll"
>
 <div class="p-6">
     <h2 class="text-lg font-medium text-gray-200">
            ئایا تۆ دڵنیای لە سڕینەوەی یەکجاری هەموو جۆری بابەتە سڕاوەکان ؟
     </h2>
     <div class="mt-5 text-rose-300">ئاگاداربە لە کاتی سڕینەوە , ئەوا بابەتەکانیشی لەگەڵی دەسڕێنەوە.</div>
     <div class="flex justify-end mt-6">
         <SecondaryButton @click="closeModalAll">لابردن</SecondaryButton>
         <DangerButton class="mx-3 ml-3" @click="deleteCategoryAll(),closeModalAll()">سڕینەوە</DangerButton >
     </div>
 </div>
</Modal>
    <Modal
    :show="showConfirmRestoreCategoryModal"
    @close="closeModalRes"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە گەڕاندنەوەی جۆری بابەتی ( {{ categoryToRestore ? categoryToRestore.name : '' }} ) ؟
        </h2>
        <div class="mt-5 text-cyan-400">ئاگاداربە لە کاتی گەڕاندنەوە , ئەوا بابەتەکانیشی لەگەڵی دێنەوە.</div>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalRes">لابردن</SecondaryButton>
            <PrimaryButton  class="mx-3 ml-3" @click="restoreCategory(categoryIdToRestore.value),closeModalRes()">گەڕاندنەوە</PrimaryButton>
        </div>
    </div>
 </Modal>
   <Modal
   :show="showConfirmDeleteCategoryModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی جۆری بابەتی ( {{ categoryToDelete ? categoryToDelete.name : '' }} ) ؟
       </h2>
       <div class="mt-5 text-rose-300">ئاگاداربە لە کاتی سڕینەوە , ئەوا بابەتەکانیشی لەگەڵی دەسڕێنەوە.</div>
       <div class="flex justify-end mt-6">
           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>
           <DangerButton  class="mx-3 ml-3" @click="deleteCategory(categoryIdToDelete.value),closeModal()">سڕینەوە</DangerButton>
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
                 لیستی جۆری بابەتە سڕاوەکان
           </div>
       </div>
       <div class="flex items-center pb-7">
        <button class="p-4 mx-2 text-2xl rounded bg-zinc-700 text-cyan-500" @click="confirmRestoreAllCategory"><RestoreSvg/></button>  <button @click="confirmDeleteAllCategory"  class="p-4 mr-2 rounded bg-zinc-700 text-rose-300"><DeleteSvg/></button>
    </div>
    </div>
       <div class="w-full overflow-hidden rounded-[5px] shadow-xs">
         <div class="w-full overflow-x-auto">
           <Table>
             <TableHead>
               <TableRowHead>
                 <TableDataHead class="w-32">#</TableDataHead>
                 <TableDataHead class="w-32">کۆد</TableDataHead>
                 <TableDataHead class="w-64">ناو</TableDataHead>
                 <TableDataHead class="w-32">کۆی بابەت</TableDataHead>
                 <TableDataHead class="w-10"></TableDataHead>
                 <TableDataHead  class="w-10"></TableDataHead>
               </TableRowHead>
             </TableHead>
             <TableBody>
               <TableRow class="cursor-pointer " v-for="(category, index) in categories.data" :key="category.id">
                <TableData class="w-32">{{ index + 1}}</TableData>
                 <TableData class="w-32">{{ category.code }}</TableData>
                 <TableData class="w-64">{{ category.name }}</TableData>
                 <TableData class="w-32">{{ category.products_count }}</TableData>
                 <TableData @click.stop   class="w-10 whitespace-nowrap" >
                    <button   @click="confirmRestoreCategory(category.id)" class=" text-cyan-500"><RestoreSvg/></button>
                 </TableData>
                 <TableData @click.stop class="w-10 whitespace-nowrap" ><button   @click="confirmDeleteCategory(category.id)" class=" text-rose-300"><DeleteSvg/></button>
                </TableData>
               </TableRow>
             </TableBody>
           </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="categories.links" :meta="categories.meta" />
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


const props = defineProps({
 categories: Object,
});

const search = ref(props.categories.search);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch(search, debounce((value) => {
 router.get(
   route("category.trash_show"),
   { search: value,  },
   {
     preserveState: true,
     replace: true,
   }
 );
}, 100));






const deleteCategory = (id) => {
   router.delete(route('categories.destroy', { category: categoryIdToDelete.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};

const restoreCategory = (id) => {
   router.put(route('category.type_restore', { category: categoryIdToRestore.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};


const restoreCategoryAll = () => {
   router.put(route('category.type_restore_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};

const deleteCategoryAll = () => {
   router.delete(route('category.type_delete_all'), {
   preserveState: true,
   preserveScroll: true,
 });
};




const showConfirmDeleteCategoryModal = ref(false);

const categoryIdToDelete = ref(null);

const showConfirmRestoreCategoryModal = ref(false);

const showConfirmRestoreAllCategoryModal = ref(false);
const showConfirmDeleteAllCategoryModal = ref(false);


const confirmDeleteCategory = (id) => {
   categoryIdToDelete.value = id;
   showConfirmDeleteCategoryModal.value = true;
};

const confirmDeleteAllCategory = (id) => {
    showConfirmDeleteAllCategoryModal.value = true;
};
const confirmRestoreAllCategory = (id) => {
    showConfirmRestoreAllCategoryModal.value = true;
};


// // this is for close
const closeModal = () => {
   showConfirmDeleteCategoryModal.value = false;
};
const closeModalAll = () => {
    showConfirmDeleteAllCategoryModal.value = false;
};
const closeModalResAll = () => {
    showConfirmRestoreAllCategoryModal.value = false;
};


const categoryIdToRestore = ref(null);
// //thi is open by id

const confirmRestoreCategory = (id) => {
   categoryIdToRestore.value = id;
   showConfirmRestoreCategoryModal.value = true;
};
const closeModalRes = () => {
   showConfirmRestoreCategoryModal.value = false;
};
// //find data by id
const categoryToDelete = computed(() => {
   return props.categories.data.find(category => category.id == categoryIdToDelete.value);
});
const categoryToRestore = computed(() => {
   return props.categories.data.find(category => category.id == categoryIdToRestore.value);
});


</script>
