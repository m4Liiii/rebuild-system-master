<template>
    <Head title="لیستی پسولەکان" />
    <Modal
    :customClass="'mt-5'"

    :show="isFilterVisible"
    @close="closeFilter"
 >
    <div class="p-6">
        <h4 class="text-lg font-medium text-center text-gray-200">
فلتەر کردنی پسولەکان
        </h4>
        <div class="mx-10 my-3 ">
            <InputLabel for="NameCustKo" value="گەڕان بۆ کڕیاری کۆ" />
            <TextInput
              id="NameCustKo"
              type="text"
              placeholder="ناوی کڕیار بنووسە"
              v-model="CustSearchKo"
              class="w-full mt-1"
            />
          </div>
          <div class="mx-10 my-3 ">
            <InputLabel for="NameCustTak" value="گەڕان بۆ کڕیاری تاک" />
            <TextInput
              id="NameCustTak"
              type="text"
              placeholder="ناوی کڕیار بنووسە"
              v-model="CustSearchTak"
              class="w-full mt-1"
            />
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
          <div class="mx-10 my-3 ">
            <InputLabel for="iNvExc" value="گەڕان بۆ پسولە" />
            <TextInput
              id="iNvExc"
              type="text"
              placeholder="ژمارەی پسولە بنووسە"
              v-model="ExSearch"
              class="w-full mt-1"
            />
          </div>
          <div class="flex justify-between">
          <div class="flex items-center pt-3 mx-10">
            <input
              v-model="Note"
              id="Note"
              type="checkbox"
              value=""
              class="w-5 h-5 border border-gray-300 rounded text-cyan-500 focus:ring-cyan-500 focus:ring-opacity-25"
            />
            <label
              for="Note"
              class="mr-5 text-sm font-medium text-gray-300 "
              >بینینی پسولەی ئاماژەپێکراو</label
            >
          </div>
          <div class="flex items-center pt-3 mx-10">
            <input
              v-model="NotDiv"
              id="NotDiv"
              type="checkbox"
              value=""
              class="w-5 h-5 border border-gray-300 rounded text-cyan-500 focus:ring-cyan-500 focus:ring-opacity-25"
            />
            <label
              for="NotDiv"
              class="mr-5 text-sm font-medium text-gray-300"
              >بینینی پسولەی نەگەیەندراو</label
            >
          </div>
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
            <!-- First div aligned to the left -->
            <div class="flex items-center pb-7">


                <div class="justify-end p-4 text-left rounded text-cyan-400 bg-zinc-700">
                    لیستی پسولەکان
                </div>

            </div>
            <div class="flex">
            <!-- <div class="items-center p-2 pt-4 rounded-r mb-7 text-cyan-400 bg-zinc-700">{{ customer.name_customer }}</div> -->
            <div class="flex">
                    <div v-if="!isDropdownVisible" @click="isDropdownVisible = !isDropdownVisible" class="p-2 text-sm font-medium transition rounded cursor-pointer bg-zinc-600 text-emerald-500 mb-7">
                        <OpenFiltSvg/>
                    </div>
                    <div v-if="isDropdownVisible" @click="isDropdownVisible = !isDropdownVisible" class="p-2 text-sm font-medium transition rounded cursor-pointer bg-zinc-600 text-rose-300 mb-7">
                        <CloseFiltSvg/>
                    </div>
                    <TransitionDown>
                        <div v-if="isDropdownVisible" class="absolute w-24 mt-16 rounded">
                            <BtnDown @click="trueFilter">
                                <FilterSvg/>
                            </BtnDown>
                            <BtnDown @click="togglePdf">
                                <DlPdfSvg/>
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
                <TableDataHead class="w-8"></TableDataHead>
                 <TableDataHead class="w-16">#</TableDataHead>
                 <TableDataHead class="w-16">بەروار</TableDataHead>
                 <TableDataHead class="w-32">بەکارهێنەر</TableDataHead>
                 <TableDataHead class="w-64">کڕیار</TableDataHead>
                 <TableDataHead class="w-16">قازانج</TableDataHead>
                 <TableDataHead class="w-16">قەرزی کۆن</TableDataHead>
                 <TableDataHead class="w-16">کۆی گشتی</TableDataHead>
                 <TableDataHead class="w-16">قەرزی نوێ</TableDataHead>
                 <TableDataHead class="w-16">بڕی پارەدان</TableDataHead>
                 <TableDataHead class="w-16">داشکاندن</TableDataHead>
                 <TableDataHead class="w-16">بڕی ماوە</TableDataHead>
                 <TableDataHead class="w-8" v-if="isPdfVisible"><button class=" text-emerald-500" @click="navigateToPrintSelected"><DlPdfSvg/></button></TableDataHead>
                 <TableDataHead class="w-8"></TableDataHead>
               </TableRowHead>
             </TableHead>
             <TableBody class="bg-gray-100">
               <TableRow
               :class="{ 'bg-gray-500 hover:bg-gray-500': getDebt.type_notice == 1, 'bg-zinc-600 hover:bg-gray-600': getDebt.type_notice == 0 }"
               class="cursor-pointer " @click="GotoInvoice(getDebt)" v-for="getDebt in getDebts.data" :key="getDebt.id">
                <TableData class="w-8" @click.stop>  <div class="flex justify-center text-green-600">
                    <input
                      @click.stop="toggleDelivery(getDebt)"
                      :checked="getDebt.delivery == 1"
                      id="green-checkbox"
                      type="checkbox"
                      class="w-5 h-5 bg-gray-100 border-gray-300 rounded text-emerald-600 focus:ring-emerald-600 focus:ring-2"
                    />
                  </div></TableData>
                <TableData class="w-16 ">{{ getDebt.s_id }}</TableData>
                 <TableData class="w-16 px-1 whitespace-nowrap">{{ formattedDate(getDebt.created_at) }}</TableData>
                 <TableData class="w-32">{{ getDebt.user ? getDebt.user.name : "" }}</TableData>
                 <TableData class="w-64 ">{{ getDebt.customer ? getDebt.customer.name_customer : '' }}</TableData>
                 <TableData class="w-16">{{ formatNumber(getDebt.total_profit) }}</TableData>
                 <TableData class="w-16">{{ formatNumber(getDebt.old_debt) }}</TableData>
                 <TableData class="w-16 h-10">
                    <span v-if="getDebt.type_invoice == 0 && getDebt.type_amount == 0"><button class="text-emerald-400"><HandMoneySvg /></button></span>
                    <span v-if="getDebt.type_invoice == 0 && getDebt.type_amount == 1"><button class="text-cyan-500"><ShopMoneySvg/></button></span>
                    <span  v-if="getDebt.type_invoice == 1">{{ formatNumber(getDebt.total_price) }}</span></TableData>
                 <TableData class="w-16">{{ formatNumber(calculateLeftDebt(getDebt)) }}</TableData>
                 <TableData class="w-16">{{ formatNumber(getDebt.amount_of_debt) }}</TableData>
                 <TableData class="w-16">{{ formatNumber(getDebt.discount) }}</TableData>
                 <TableData class="w-16"> {{ formatNumber(getDebt.new_debt) }}</TableData>
                 <TableData class="w-8 "  v-if="isPdfVisible" @click.stop> <input type="checkbox"  class="w-5 h-5 bg-gray-100 border-gray-300 rounded text-cyan-600 focus:ring-cyan-600 focus:ring-2" :value="getDebt.id" v-model="selectedDebts">
                 </TableData>
                 <TableData class="w-8 text-cyan-500 " @click.stop><button @click.stop="GotoInvoicePrint(getDebt)"><PrintInvSvg/></button></TableData>

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
import OpenFiltSvg from "@/Components/Svg/OpenFilt.vue";
import DocumentSvg from "@/Components/Svg/Doc.vue";
import CloseFiltSvg from "@/Components/Svg/CloseFilt.vue";
import TableRowHead from "@/Components/TableRowHead.vue";
import { router } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import BtnDown from "@/Components/BtnDown.vue";
import FilterSvg from "@/Components/Svg/Filter.vue";
import DlPdfSvg from "@/Components/Svg/DlPdf.vue";
import PrintInvSvg from "@/Components/Svg/PrintInv.vue";
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


const isDropdownVisible = ref(false)


const { hasPermission } = usePermission();

const formattedDate = (dateString) => {
  return format(new Date(dateString), 'yyyy-MM-dd');
};

const props = defineProps({
 getDebts: Object,
});


    const selectedDebts = ref([]);


    const navigateToPrintSelected = () => {
      selectedDebts.value.forEach(debtId => {
        const url = route("download.invoice", { getdebt: debtId });
        window.open(url, "_blank", "width=2000,height=600");
      });

    };

    const GotoInvoicePrint = (getDebt) => {
        const url = route("print.invoice", { getdebt: getDebt.id });
        window.open(url, "_blank", "width=900,height=600");

    };

    const toggleDelivery = (getDebt) => {
      getDebt.delivery = getDebt.delivery == 1 ? 0 : 1;
      router.put(route("update.delivery", { getdebt: getDebt.id }), {
        delivery: getDebt.delivery,
      });
    };

const search = ref(props.getDebts.search);

const start_date = ref(props.getDebts.start_date);
const end_date = ref(props.getDebts.end_date);
const ExSearch = ref(props.getDebts.ExSearch);
const CustSearchKo = ref(props.getDebts.CustSearchKo);
const CustSearchTak = ref(props.getDebts.CustSearchTak);
const NotDiv = ref(props.getDebts.NotDiv);
const Note = ref(props.getDebts.Note);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch([search , end_date, start_date , ExSearch , CustSearchKo  , CustSearchTak, NotDiv , Note], debounce(([newSearch,  newend_date , newstart_date , newExSearch , newCustSearchKo , newCustSearchTak , newNotDiv , newNote]) => {
  router.get(
    route("list.invoice"),
    {

    search: newSearch,
    ExSearch: newExSearch,
    NotDiv: newNotDiv ? 'equal' : 'all',
    Note: newNote ? 'greater' : 'all',
    CustSearchTak: newCustSearchTak,
    CustSearchKo: newCustSearchKo,
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
  ExSearch.value = "";
  CustSearchKo.value = "";
  CustSearchTak.value = "";
  NotDiv.value = "";
};


const calculateLeftDebt = (getDebt) => {
            if (getDebt) {
                return parseFloat(getDebt.old_debt || 0) + parseFloat(getDebt.total_price || 0);
            } else {
                return 0;
            }
        };

    const GotoInvoice = (getDebt) => {
        if (getDebt.type_invoice == 0) {
            router.get(route('customers.getdebts.edit', {  customer: getDebt.customer_id , getdebt: getDebt.id,}));
        } else if (getDebt.type_invoice == 1) {
            router.get(route('getdebts.invoices.index', { getdebt: getDebt.id  }));
        }
    };

    const isPdfVisible = ref(false);

const togglePdf = () => {
  isPdfVisible.value = !isPdfVisible.value;
};
</script>
