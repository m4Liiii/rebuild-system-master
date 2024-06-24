<template>
    <Head title="لیستی جۆری بابەتەکان" />

   <Modal
   :show="showConfirmDeleteCategoryModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی جۆری بابەتی ( {{ categoryToDelete ? categoryToDelete.name : '' }} ) ؟
       </h2>
       <div class="flex justify-end mt-6">
           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>
           <DangerButton  class="mx-3 ml-3" @click="deleteCategory(categoryIdToDelete.value),closeModal()">سڕینەوە</DangerButton>
       </div>
   </div>
</Modal>
 <AuthenticatedLayout :searchValue="search" @updateSearchValue="handleSearchUpdate">
   <main class="h-full overflow-y-auto py-7">
     <div class="container grid px-6 mx-auto">
       <div class="flex items-center pb-7">
           <Link
           v-if="hasPermission('create_category')"
           :href="route('categories.create')"
           class="inline-block p-2 rounded-r text-emerald-500 bg-zinc-600"
         >
          <CreateSvg/>
         </Link>
           <div class="justify-end p-4 text-left rounded-l text-cyan-400 bg-zinc-700">
                 لیستی جۆری بابەتەکان
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
                 <TableDataHead v-if="hasPermission('delete_category')" class="w-10"></TableDataHead>
                 <TableDataHead  v-if="hasPermission('edit_category')" class="w-10"></TableDataHead>
               </TableRowHead>
             </TableHead>
             <TableBody>
               <TableRow @click="navigateToProducts(category)" class="cursor-pointer " v-for="(category, index) in categories.data" :key="category.id">
                <TableData class="w-32">{{ index + 1}}</TableData>
                 <TableData class="w-32">{{ category.code }}</TableData>
                 <TableData class="w-64">{{ category.name }}</TableData>
                 <TableData class="w-32">{{ category.products_count }}</TableData>
                 <TableData @click.stop v-if="hasPermission('delete_category')" class="w-10 whitespace-nowrap" ><button v-if="category.id != 1"   @click="confirmDeleteCategory(category.id)" class=" text-rose-300"><DeleteSvg/></button>
                </TableData>
                <TableData @click.stop  v-if="hasPermission('edit_category')" class="w-10 whitespace-nowrap" >
                    <Link v-if="category.id != 1"   :href="route('categories.edit' , category.id)" class="inline-flex text-emerald-400"><EditSvg/></Link>
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
import DeleteSvg from "@/Components/Svg/Delete.vue";
import EditSvg from "@/Components/Svg/Edit.vue";
import TableRowHead from "@/Components/TableRowHead.vue";
import TableDataHead from "@/Components/TableDataHead.vue";
import { router } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { debounce } from 'lodash';
import { usePermission } from "@/Composables/permissions";
const { hasPermission } = usePermission();


const props = defineProps({
 categories: Object,
});

const search = ref(props.categories.search);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch(search, debounce((value) => {
 router.get(
   route("categories.index"),
   { search: value,  },
   {
     preserveState: true,
     replace: true,
   }
 );
}, 100));





const deleteCategory = (id) => {
   router.put(route('category.type_delete', { category: categoryIdToDelete.value }), {
   onSuccess: () => closeModal(),
   preserveState: true,
   preserveScroll: true,
 });
};


// this is for false to true
const showConfirmDeleteCategoryModal = ref(false);

//this is for add id user you want
const categoryIdToDelete = ref(null);


// //thi is open by id
const confirmDeleteCategory = (id) => {
   categoryIdToDelete.value = id;
   showConfirmDeleteCategoryModal.value = true;
};

// // this is for close
const closeModal = () => {
   showConfirmDeleteCategoryModal.value = false;
};

// //find data by id
const categoryToDelete = computed(() => {
   return props.categories.data.find(category => category.id == categoryIdToDelete.value);
});

function navigateToProducts(category) {
  router.get(route('categories.products.index', category.id))
}
</script>
