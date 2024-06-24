<template>
    <div v-if="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 ">
        <div class="text-gray-300 animate-spin">
            <LoaderDebtSvg/>
        </div>
      </div>
    <Head title="لیستی پسولەکان" />
    <Modal
    :customClass="'mt-36'"
    :show="isFilterVisible"
    @close="closeFilter"
 >
    <div class="p-6">
        <h4 class="text-lg font-medium text-center text-gray-200">
          فلتەر کردنی پسولەکانی ( {{ seller.name_seller }} )
        </h4>
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
   <Modal
   :show="showConfirmDeleterepDebtModal"
   @close="closeModal"
>
   <div class="p-6">
       <h2 class="text-lg font-medium text-gray-200">
              ئایا تۆ دڵنیای لە سڕینەوەی پسولەی ( {{ repDebtToDelete ? repDebtToDelete.id : '' }} ) ؟
       </h2>
       <div class="flex justify-end mt-6">

           <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>

           <DangerButton  class="mx-3 ml-3" @click="deleterepDebt(repDebtIdToDelete.value),closeModal()">سڕینەوە</DangerButton>

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
                :href="route('sellers.index')"
                class="inline-block p-2 rounded-r text-rose-300 bg-zinc-600">
                <BackSvg/>
            </Link>
                <div class="justify-end p-4 text-left text-cyan-400 bg-zinc-700">
                    لیستی پسولەکان
                </div>
                <Link
                    v-if="hasPermission('create_repdebt')"
                    :href="route('sellers.repdebts.create', seller.id)"
                    class="inline-block p-2 rounded-l text-emerald-500 bg-zinc-600">
                    <CreateSvg/>
                </Link>
            </div>
            <div class="flex">
            <div class="items-center p-2 pt-4 rounded-r mb-7 text-cyan-400 bg-zinc-700">{{ seller.name_seller }}</div>
            <div class="flex">
                    <div v-if="!isDropdownVisible" @click="isDropdownVisible = !isDropdownVisible" class="p-2 text-sm font-medium transition rounded rounded-r-none cursor-pointer bg-zinc-600 text-emerald-500 mb-7">
                        <OpenFiltSvg/>
                    </div>
                    <div v-if="isDropdownVisible" @click="isDropdownVisible = !isDropdownVisible" class="p-2 text-sm font-medium transition rounded rounded-r-none cursor-pointer bg-zinc-600 text-rose-300 mb-7">
                        <CloseFiltSvg/>
                    </div>
                    <TransitionDown>
                        <div v-if="isDropdownVisible" class="absolute w-24 mt-16 rounded">
                            <BtnDown @click="trueFilter">
                                <FilterSvg/>
                            </BtnDown>
                            <BtnDown @click="repairDebts">
                                <RepairRowSvg/>
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
                <TableDataHead class="w-10"></TableDataHead>
                 <TableDataHead class="w-32">#</TableDataHead>
                 <TableDataHead class="w-32">بەروار</TableDataHead>
                 <TableDataHead class="w-32">بەکارهێنەر</TableDataHead>
                 <TableDataHead class="w-32">قازانج</TableDataHead>
                 <TableDataHead class="w-32">قەرزی کۆن</TableDataHead>
                 <TableDataHead class="w-32">کۆی گشتی</TableDataHead>
                 <TableDataHead class="w-32">قەرزی نوێ</TableDataHead>
                 <TableDataHead class="w-32">بڕی پارەدان</TableDataHead>
                 <TableDataHead class="w-32">داشکاندن</TableDataHead>
                 <TableDataHead class="w-32">بڕی ماوە</TableDataHead>
                 <TableDataHead class="w-32"></TableDataHead>

               </TableRowHead>
             </TableHead>
             <TableBody>
               <TableRow   :class="{ 'bg-gray-500 hover:bg-gray-500': repDebt.type_notice == 1, 'bg-zinc-600 hover:bg-gray-600': repDebt.type_notice !== 1 }" class="cursor-pointer" @click="GotoInvoice(repDebt)" v-for="repDebt in repDebts.data" :key="repDebt.id">
                <TableData class="w-10" @click.stop>  <div class="flex justify-center text-green-600">
                    <input
                      @click.stop="toggleDelivery(repDebt)"
                      :checked="repDebt.delivery == 1"
                      id="green-checkbox"
                      type="checkbox"
                      class="w-5 h-5 bg-gray-100 border-gray-300 rounded text-emerald-600 focus:ring-emerald-600 focus:ring-2"
                    />
                  </div></TableData>
                <TableData class="w-32 ">{{ repDebt.s_id }}</TableData>
                 <TableData class="w-32 ">{{ formattedDate(repDebt.created_at) }}</TableData>
                 <TableData class="w-32">{{ repDebt.user ? repDebt.user.name : "" }}</TableData>
                 <TableData class="w-32">{{ formatNumber(repDebt.total_profit) }}</TableData>
                 <TableData class="w-32">{{ formatNumber(repDebt.old_debt) }}</TableData>
                 <TableData class="w-32 h-10">
                    <span v-if="repDebt.type_invoice == 0 && repDebt.type_amount == 0"><button class="text-emerald-400"><HandMoneySvg/></button></span>
                    <span v-if="repDebt.type_invoice == 0 && repDebt.type_amount == 1"><button class="text-cyan-500"><ShopMoneySvg/></button></span>
                    <span  v-if="repDebt.type_invoice == 1">{{ formatNumber(repDebt.total_price) }}</span></TableData>
                 <TableData class="w-32">{{ formatNumber(calculateLeftDebt(repDebt)) }}</TableData>
                 <TableData class="w-32">{{ formatNumber(repDebt.amount_of_debt) }}</TableData>
                 <TableData class="w-32">{{ formatNumber(repDebt.discount) }}</TableData>
                 <TableData class="w-32"> {{ formatNumber(repDebt.new_debt) }}</TableData>
                 <TableData @click.stop v-if="hasPermission('delete_repdebt')" class=" whitespace-nowrap" ><button   @click.stop="confirmDeleterepDebt(repDebt.id)" class="text-rose-300"><DeleteSvg/></button>
                 </TableData>
                </TableRow>
             </TableBody>
           </Table>
         </div>
         <div
           class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
         >
           <div class="flex justify-start mt-1.5 pb-1.5">
             <Pagination :links="repDebts.links" :meta="repDebts.meta" />
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
import BackSvg from "@/Components/Svg/Back.vue";
import LoaderDebtSvg from "@/Components/Svg/LoaderDebt.vue";
import DocumentSvg from "@/Components/Svg/Doc.vue";
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
import RepairRowSvg from "@/Components/Svg/RepairRow.vue";
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
 repDebts: Object,
 seller: Object
});



const search = ref(props.repDebts.search);

const start_date = ref(props.repDebts.start_date);
const end_date = ref(props.repDebts.end_date);
const Note = ref(props.repDebts.Note);

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch([search,end_date,start_date,Note], debounce(([newSearch,newend_date,newstart_date,newNote]) => {
  router.get(
    route("sellers.repdebts.index" , props.seller.id),
    {
    search: newSearch,
    Note: newNote ? 'greater' : 'all',
    start_date: newstart_date,
    end_date: newend_date,
    },
    {
      preserveState: true,
      replace: true,
    }
  );
}, 100));


const toggleDelivery = (repDebt) => {
      repDebt.delivery = repDebt.delivery == 1 ? 0 : 1;
      router.put(route("update.delivery", { repdebt: repDebt.id }), {
        delivery: repDebt.delivery,
      });
    };






// const deleterepDebt = () => {
//    router.put(route('repdebt.type_delete', {repdebt: repDebtIdToDelete.value }), {
//    preserveState: true,
//  });
// };

const loading = ref(false);
// const repairDebts = () => {
//   loading.value = true;
//   router.put(route("repair.repdebts" , {seller: props.seller.id}), {}, {
//     onFinish: () => loading.value = false
//   });
// };


// this is for false to true
const showConfirmDeleterepDebtModal = ref(false);


const repDebtIdToDelete = ref(null);


// // //thi is open by id
const confirmDeleterepDebt = (id) => {
   repDebtIdToDelete.value = id;
   showConfirmDeleterepDebtModal.value = true;
};

const trueFilter = () => {
  isFilterVisible.value = true;
};
const closeFilter = () => {
  isFilterVisible.value = false;
};
const isFilterVisible = ref(false);


const closeModal = () => {
   showConfirmDeleterepDebtModal.value = false;
};

const repDebtToDelete = computed(() => {
   return props.repDebts.data.find(repDebt => repDebt.id == repDebtIdToDelete.value);
});

const resetSearch = () => {
  isFilterVisible.value = false;
  search.value = "";
  start_date.value = "";
  end_date.value = "";

};


const calculateLeftDebt = (repDebt) => {
            if (repDebt) {
                return parseFloat(repDebt.old_debt || 0) + parseFloat(repDebt.total_price || 0);
            } else {
                return 0;
            }
        };

    const GotoInvoice = (repDebt) => {
        if (repDebt.type_invoice == 0) {
            router.get(route('sellers.repdebts.edit', { repdebt: repDebt.id, seller: props.seller.id }));
        } else if (repDebt.type_invoice == 1) {
            router.get(route('repdebts.invoices.index', { repdebt: repDebt.id  }));
        }
    };
</script>
