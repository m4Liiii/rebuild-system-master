<template>
    <Head title="لیستی بابەتەکان" />
    <Modal
    :show="showProductShow"
    @close="closeModalProductShow"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
        کلیک بکە بۆ بینینی بابەتەکان و جۆری نرخ دیاری بکە بەپێی ویست.
        </h2>
        <div class="py-4" >
            <select

            v-model="selectedTable"
            id="countries"
            class="w-full pr-8 text-sm text-gray-100 border-transparent rounded-md border-zinc-900 bg-zinc-700 focus:border-gray-500 focus:bg-zinc-700 focus:ring-0"
          >
            <option   class="block w-full text-sm text-gray-100 border-gray-600 active:bg-cyan-100 bg-zinc-600" value="table1">نرخی کۆ</option>
            <option   class="block w-full text-sm text-gray-100 border-gray-600 active:bg-cyan-100 bg-zinc-600" value="table2">نرخی تاک</option>
            <option   class="block w-full text-sm text-gray-100 border-gray-600 active:bg-cyan-100 bg-zinc-600" value="table3">نرخی کڕین</option>
          </select>
        </div>
        <div class="ml-auto" dir="ltr">

            <PrimaryButton  class="mr-3 " @click="print">فلتەر کردن</PrimaryButton>
            <SecondaryButton  @click="closeModalProductShow"> لابردن </SecondaryButton>


        </div>

    </div>
 </Modal>
   <Modal
   :show="showConfirmDeleteProductModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی بابەتی ( {{ productToDelete ? productToDelete.name_of_product : '' }} ) ؟
       </h2>
       <div class="flex justify-end mt-6">

           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>

           <DangerButton  class="mx-3 ml-3" @click="deleteProduct(productIdToDelete.value),closeModal()">سڕینەوە</DangerButton>

       </div>
   </div>
</Modal>
 <AuthenticatedLayout :searchValue="search" @updateSearchValue="handleSearchUpdate">
   <main class="h-full overflow-y-auto py-7">
     <div class="container grid px-6 mx-auto">
        <div class="items-center md:flex md:justify-between">
            <!-- First div aligned to the left -->
            <div class="flex items-center pb-7">

                <Link
                :href="route('categories.index')"
                class="inline-block p-2 rounded-r text-rose-300 bg-zinc-600">
                <BackSvg/>
            </Link>
                <div class="justify-end p-4 text-left text-cyan-400 bg-zinc-700">
                    لیستی بابەتەکان
                </div>
                <Link
                    v-if="hasPermission('create_product')"
                    :href="route('categories.products.create', category.id)"
                    class="inline-block p-2 rounded-l text-emerald-500 bg-zinc-600">
                    <CreateSvg/>
                </Link>
            </div>
            <div class="flex">
            <div class="items-center p-2 pt-4 rounded-r mb-7 text-cyan-400 bg-zinc-700">{{ category.name }}</div>

            <div class="flex">

                    <div v-if="!isDropdownVisible" @click="isDropdownVisible = !isDropdownVisible" class="p-2 text-sm font-medium transition rounded rounded-r-none cursor-pointer bg-zinc-600 text-emerald-500 mb-7">

                        <OpenFiltSvg/>

                    </div>
                    <div v-if="isDropdownVisible" @click="isDropdownVisible = !isDropdownVisible" class="p-2 text-sm font-medium transition rounded rounded-r-none cursor-pointer bg-zinc-600 text-rose-300 mb-7">

                        <CloseFiltSvg/>

                    </div>


                    <TransitionDown>
                        <div v-if="isDropdownVisible" class="absolute w-24 mt-16 rounded">
                            <BtnDown @click="toggleFix" v-if="hasPermission('edit_product')">
                                <FixNumberSvg/>
                            </BtnDown>
                            <BtnDown @click="confirmModalProductShow">
                                <DocumentSvg/>
                            </BtnDown>
                        </div>
                    </TransitionDown>
                </div>
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
                 <TableDataHead v-if="isFixVisible" class="w-16 text-cyan-400">گۆڕانکاری ژ.بابەت</TableDataHead>
                 <TableDataHead v-if="isFixVisible" class="w-16"></TableDataHead>
                 <TableDataHead v-if="hasPermission('delete_product')" class="w-16"></TableDataHead>
                 <TableDataHead v-if="hasPermission('edit_product')" class="w-16"></TableDataHead>
               </TableRowHead>
             </TableHead>
             <TableBody>
               <TableRow v-for="(product, index) in products.data" :key="product.id">
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
                 <TableData  v-if="hasPermission('delete_product')" class=" whitespace-nowrap" ><button   @click="confirmDeleteProduct(product.id)" class="text-rose-300"><DeleteSvg/></button>
                 </TableData>
                 <TableData  v-if="hasPermission('edit_product')" class=" whitespace-nowrap" >
                   <Link   :href="route('categories.products.edit' , {category: category.id , product: product.id})" class="inline-flex text-emerald-400"><EditSvg/></Link></TableData>

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
import { ref, watch , computed  } from "vue";

import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/Table.vue";
import TableBody from "@/Components/TableBody.vue";
import TransitionDown from "@/Components/TransitionDown.vue";
import TableData from "@/Components/TableData.vue";
import TableDataHead from "@/Components/TableDataHead.vue";
import TableHead from "@/Components/TableHead.vue";
import TableRow from "@/Components/TableRow.vue";
import CreateSvg from "@/Components/Svg/Create.vue";
import DeleteSvg from "@/Components/Svg/Delete.vue";
import OpenFiltSvg from "@/Components/Svg/OpenFilt.vue";
import EditSvg from "@/Components/Svg/Edit.vue";
import BackSvg from "@/Components/Svg/Back.vue";
import DocumentSvg from "@/Components/Svg/Doc.vue";
import FixNumberSvg from "@/Components/Svg/FixNumber.vue";
import CloseFiltSvg from "@/Components/Svg/CloseFilt.vue";
import TableRowHead from "@/Components/TableRowHead.vue";
import { router } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BtnDown from "@/Components/BtnDown.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { debounce } from 'lodash';
import { usePermission } from "@/Composables/permissions";
import numeral from 'numeral';

const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};

const print = () => {
    showProductShow.value = false;
 const url = route("product.show", {
  category: props.category.id,
  search: search.value,
  selectedTable: selectedTable.value
}, true);
  window.open(url, "_blank", "width=800,height=600");
};
const isDropdownVisible = ref(false)


const { hasPermission } = usePermission();


const props = defineProps({
 products: Object,
 category: Object
});

const selectedTable = ref('table1')

const search = ref(props.products.search);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch(search, debounce((value) => {
 router.get(
   route("categories.products.index" , props.category.id),
   { search: value,  },
   {
     preserveState: true,
     replace: true,
   }
 );
}, 100));






const deleteProduct = (id) => {
   router.put(route('product.type_delete', {product: productIdToDelete.value }), {
   preserveState: true,
 });
};

const UpdateFix = (productId) => {
   router.put(route('fix.product', {  product: productId }), {
   preserveState: true,
 });
};

// this is for false to true
const showConfirmDeleteProductModal = ref(false);

const showProductShow = ref(false);
// //this is for add id user you want
const productIdToDelete = ref(null);


// // //thi is open by id
const confirmDeleteProduct = (id) => {
   productIdToDelete.value = id;
   showConfirmDeleteProductModal.value = true;
};

// // // this is for close
const closeModalProductShow = () => {
    showProductShow.value = false;
};

const confirmModalProductShow = ()=> {
    showProductShow.value = true;
};

const closeModal = () => {
   showConfirmDeleteProductModal.value = false;
};

const productToDelete = computed(() => {
   return props.products.data.find(product => product.id == productIdToDelete.value);
});

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

const isFixVisible = ref(false);

const toggleFix = () => {
  isFixVisible.value = !isFixVisible.value;
};
</script>
