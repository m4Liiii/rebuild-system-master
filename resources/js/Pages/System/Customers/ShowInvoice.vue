<template>
    <Head title="لیستی خانەی پسولەکان" />
    <Modal
    :customClass="'mt-20'"

    :show="isFilterVisible"
    @close="closeFilter"
 >
    <div class="p-6">
      <div class="flex justify-center">
        <h4 class="text-lg font-medium text-center text-gray-200">
        فلتەر کردنی خانەی پسولەکان
        </h4>
        <span  @click="toggleSch" v-if="!ToggleSearchable" class="pr-3 text-xl cursor-pointer text-emerald-500">&gt;&gt;</span>
        <span @click="toggleSch" v-if="ToggleSearchable" class="pr-3 text-xl cursor-pointer text-emerald-500">&lt;&lt;</span>
      </div>
        <div v-if="!ToggleSearchable">
        <div class="w-full p-2 px-10 mx-auto ">
            <InputLabel for="NameCust" value="گەڕان بۆ جۆری بابەت" />
            <searchable-select
            :items="categories"
            :label="'گەڕان بۆ جۆری بابەت'"
            v-model="searchCateId"
            :searchFields="['name','code']"
            class="w-full"
            :deselectable="true"
            deselect-button-class="mt-1.5"

           >
            <template #option-content="{ option }">
                {{ option.name }} -  {{ option.code }}
            </template>
           </searchable-select>
        </div>
        <div class="w-full p-2 px-10 mx-auto ">
            <InputLabel for="NameCust" value="گەڕان بۆ بابەت" />
            <searchable-select
            :items="products"
            :label="'گەڕان بۆ بابەت'"
            v-model="searchProdId"
            :searchFields="['name_of_product','code_of_product']"
            class="w-full"
            :deselectable="true"
            deselect-button-class="mt-1.5"

           >
            <template #option-content="{ option }">
                {{ option.name_of_product }} -  {{ option.code_of_product }}
            </template>
           </searchable-select>
        </div>

    </div>
        <div v-if="ToggleSearchable">
        <div class="mx-10 my-3 ">
            <InputLabel for="NamePr" value="گەڕان بۆ بابەت" />
            <TextInput
              id="NamePr"
              type="text"
              placeholder="ناوی بابەت بنووسە"
              v-model="SearchProduct"
              class="w-full mt-1"
            />
          </div>
        </div>
        <div class="mx-10 my-3 ">
            <InputLabel for="NameADD" value="لە بەرواری" />
            <TextInput
              id="NameADD"
              type="date"
              v-model="start_date"
              class="w-full mt-1"
            />
          </div>

        <div class="mx-10 my-3 ">
            <InputLabel for="social_number2" value="تا بەرواری" />
            <TextInput
              id="social_number2"
              type="date"
              v-model="end_date"
              class="w-full mt-1"
            />
          </div>
        <div class="flex justify-center mt-6">
            <SecondaryButton @click="closeFilter"> لابردن </SecondaryButton>
            <DangerButton @click="resetSearch" class="mx-3 ml-3">بەتاڵ کردنەوە</DangerButton>
        </div>
    </div>
 </Modal>

 <AuthenticatedLayout :searchValue="search" @updateSearchValue="handleSearchUpdate">

    <main class="h-full overflow-y-auto py-7">
     <div class="container grid px-6 mx-auto">
        <div class="items-center md:flex md:justify-between">
            <div class="flex items-center pb-7">
                <div class="justify-end p-4 text-left rounded text-cyan-400 bg-zinc-700">
                    لیستی خانەی پسولەکان
                </div>
            </div>
            <div class="flex">
                <div class="items-center p-2 pt-4 rounded-r mb-7 text-cyan-400 bg-zinc-700">{{ customer.name_customer }}</div>
            <div class="flex">

                    <div v-if="!isDropdownVisible" @click="isDropdownVisible = !isDropdownVisible" class="p-2 text-sm font-medium transition rounded-l cursor-pointer bg-zinc-600 text-emerald-500 mb-7">
                        <OpenFiltSvg/>
                    </div>
                    <div v-if="isDropdownVisible" @click="isDropdownVisible = !isDropdownVisible" class="p-2 text-sm font-medium transition rounded-l cursor-pointer bg-zinc-600 text-rose-300 mb-7">
                        <CloseFiltSvg/>
                    </div>
                    <TransitionDown>
                        <div v-if="isDropdownVisible" class="absolute w-24 mt-16 rounded">
                            <BtnDown @click="trueFilter">
                                <FilterSvg/>
                            </BtnDown>
                            <BtnDown @click="repairDebts">
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
                 <TableDataHead class="w-16">بەروار</TableDataHead>
                 <TableDataHead class="w-16">کات</TableDataHead>
                 <TableDataHead class="w-32">بەکارهێنەر</TableDataHead>

                 <TableDataHead class="w-96">بابەت</TableDataHead>
                 <TableDataHead class="w-16">کۆد</TableDataHead>
                 <TableDataHead class="w-16">قازانج</TableDataHead>
                 <TableDataHead class="w-16">کارتۆن</TableDataHead>
                 <TableDataHead class="w-16">ژ.ن.کارتۆن</TableDataHead>
                 <TableDataHead class="w-16">ژمارە</TableDataHead>
                 <TableDataHead class="w-16">نرخ</TableDataHead>
                 <TableDataHead class="w-16">کۆی نرخ</TableDataHead>
               </TableRowHead>
             </TableHead>
             <TableBody class="bg-gray-100">
               <TableRow
               class="cursor-pointer " @click="GotoInvoice(invoice)" v-for="invoice in invoices.data" :key="invoice.id">
                <TableData class="w-16 ">{{ invoice.getDebt ? invoice.getDebt.s_id : "" }}</TableData>
                 <TableData class="w-32 whitespace-nowrap ">{{ formattedDate(invoice.created_at) }}</TableData>
                 <TableData class="w-16" >{{ formatTime(invoice.created_at) }}</TableData>
                 <TableData class="w-32">{{ invoice.user ? invoice.user.name : "" }}</TableData>
                 <TableData class="w-96">{{ invoice.name }}</TableData>
                 <TableData class="w-16">{{ invoice.code }}</TableData>
                 <TableData class="w-16">{{ formatNumber(invoice.profit) }}</TableData>
                 <TableData class="w-16">{{ invoice.box }}</TableData>
                 <TableData class="w-16"> {{ invoice.quantity_box }}</TableData>
                 <TableData class="w-16"> {{ invoice.quantity }}</TableData>
                 <TableData class="w-16"> {{ formatNumber(invoice.price) }}</TableData>
                 <TableData class="w-16"> {{ formatNumber(invoice.price_all) }}</TableData>
                </TableRow>
             </TableBody>
           </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="invoices.links" :meta="invoices.meta" />
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
import { ref, watch , computed ,onMounted  } from "vue";

import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/Table.vue";
import TableBody from "@/Components/TableBody.vue";
import TransitionDown from "@/Components/TransitionDown.vue";
import TableData from "@/Components/TableData.vue";
import TableDataHead from "@/Components/TableDataHead.vue";
import TableHead from "@/Components/TableHead.vue";
import TableRow from "@/Components/TableRow.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import CreateSvg from "@/Components/Svg/Create.vue";
import DeleteSvg from "@/Components/Svg/Delete.vue";
import OpenFiltSvg from "@/Components/Svg/OpenFilt.vue";
import EditSvg from "@/Components/Svg/Edit.vue";
import BackSvg from "@/Components/Svg/Back.vue";
import DocumentSvg from "@/Components/Svg/Doc.vue";
import SearchableSelect from "@/Components/SearchableSelect.vue";
import CloseFiltSvg from "@/Components/Svg/CloseFilt.vue";
import TableRowHead from "@/Components/TableRowHead.vue";
import { router } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import BtnDown from "@/Components/BtnDown.vue";
import FilterSvg from "@/Components/Svg/Filter.vue";
import HandMoneySvg from "@/Components/Svg/HandMoney.vue";
import ShopMoneySvg from "@/Components/Svg/ShopMoney.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { debounce } from 'lodash';
import { usePermission } from "@/Composables/permissions";
import numeral from 'numeral';
import { format } from 'date-fns';

const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};

const ToggleSearchable = ref(false);

const toggleSch = () => {
  ToggleSearchable.value = !ToggleSearchable.value;
};
const isDropdownVisible = ref(false)


const { hasPermission } = usePermission();

const formattedDate = (dateString) => {
  return format(new Date(dateString), 'yyyy-MM-dd');
};
const formatTime = (dateTime) => {
      return format(new Date(dateTime), 'HH:mm');
    };
const props = defineProps({
 invoices: Object,
 products: Object,
 customer: Object,
 categories: Object,
});




const search = ref(props.invoices.search);

const start_date = ref(props.invoices.start_date);
const end_date = ref(props.invoices.end_date);
const SearchProduct = ref(props.invoices.SearchProduct);
const searchProdId = ref(props.invoices.searchProdId);
const searchCateId = ref(props.invoices.searchCateId);


const handleSearchUpdate = (value) => {
 search.value = value;
};

watch([search , end_date, start_date,SearchProduct,searchProdId,searchCateId], debounce(([newSearch,  newend_date , newstart_date,newSearchProduct,newsearchProdId,newsearchCateId]) => {
  router.get(
    route("list.invoice.customer",{customer: props.customer.id}),
    {
    SearchProduct: newSearchProduct,
    searchProdId: newsearchProdId,
    searchCateId: newsearchCateId,
    search: newSearch,
    start_date: newstart_date,
    end_date: newend_date,

    },
    {
      preserveState: true,
      replace: true,
    }
  );
}, 100));






const trueFilter = () => {
  isFilterVisible.value = true;
};
const closeFilter = () => {
  isFilterVisible.value = false;
};
const isFilterVisible = ref(false);




const resetSearch = () => {
  isFilterVisible.value = false;
  search.value = "";
  start_date.value = "";
  end_date.value = "";
  SearchProduct.value = "";
  searchProdId.value = "";
  searchCateId.value= "";


};


    const GotoInvoice = (invoice) => {
            router.get(route('getdebts.invoices.index', { getdebt: invoice.get_debt_id  }));
    };
</script>
