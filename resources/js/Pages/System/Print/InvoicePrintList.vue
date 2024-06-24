
<template >
    <div class="page font-KurdishFont" >
       <div><img ref="printImage" alt="Logo" src="/img/koga.jpg" /></div>
       <div class="">
        <div class="flex w-full border border-slate-500">
            <div class="w-1/6 text-center border-r border-slate-500">
               {{ props.getDebt.s_id }}
            </div>
            <div class="w-2/6 text-center border-slate-500">
                ژ.پسولە / رقم الوصل
            </div>
            <div class="w-3/6 text-center border-l border-slate-500">
                {{ props.getDebt.customer ? props.getDebt.customer.name_customer : '' }}
            </div>
            <div class="w-2/6 text-center border-l border-slate-500">
 بەڕێز / السيد
            </div>
        </div>
        <div class="flex w-full border border-slate-500">
            <div class="w-1/6 text-center border-r border-slate-500">
                {{ formattedDate(props.getDebt.created_at) }}
            </div>
            <div class="w-2/6 text-center border-slate-500">
                رێكەوت / تاریخ
            </div>
            <div class="w-3/6 text-center border-l border-slate-500 ">
                {{ props.getDebt.customer ? props.getDebt.customer.address : '' }}
            </div>
            <div class="w-2/6 text-center border-l border-slate-500 whitespace-nowrap">
                ناونیشان / العنوان
            </div>

        </div>
        <div class="flex w-full border border-slate-500">
            <div class="w-1/6 text-center border-r border-slate-500">
                {{ formatTime(props.getDebt.created_at) }}
            </div>
            <div class="w-2/6 text-center border-slate-500">
                كاتژمێر / ساعة
            </div>
            <div class="w-3/6 text-center border-l border-slate-500 ">
                {{ props.getDebt.customer ? props.getDebt.customer.phone_number : '' }}
            </div>
            <div class="w-2/6 text-center border-l border-slate-500 whitespace-nowrap">
                مۆبایل / موبایل
            </div>
        </div>
        </div>


        <table class="w-full">

        <tr>
            <th class="text-center border border-slate-500">کۆی نرخ</th>
            <th class="text-center border border-slate-500">نرخ</th>
            <th class="text-center border border-slate-500" >گەڕاوە</th>
            <th class="text-center border border-slate-500" >ژمارە</th>
            <th class="text-center border border-slate-500">ناو کارتۆن</th>
            <th class="text-center border border-slate-500">کارتۆن</th>
            <th class="w-64 text-center border border-slate-500">بابەت</th>
            <th class="w-16 text-center border border-slate-500">کۆد</th>
            <th class="text-center border border-slate-500">#</th>
          </tr>
          <tr>
            <th class="text-center border border-slate-500">الاجمالي</th>
            <th class="text-center border border-slate-500">السعر</th>
            <th class="text-center border border-slate-500" >ارجاع</th>
            <th class="text-center border border-slate-500" >العدد</th>
            <th class="text-center border border-slate-500">داخل كارتون</th>
            <th class="text-center border border-slate-500">كارتون</th>
            <th class="w-64 text-center border border-slate-500">الموضوع</th>
            <th class="w-16 text-center border border-slate-500">کود</th>
            <th class="text-center border border-slate-500">#</th>
          </tr>
          <tbody>
          <tr v-for="(invoice, index) in invoices" :key="invoice"  >
            <td class="text-center border border-slate-500"> {{ formatNumber(invoice.price_all) }}</td>
            <td class="text-center border border-slate-500">  {{ formatNumber(invoice.price) }}</td>
            <td class="text-center border border-slate-500" >{{ getNegativeQuantity(invoice) }}</td>
            <td class="text-center border border-slate-500" >{{ getPositiveQuantity(invoice) }}</td>
            <td class="text-center border border-slate-500">{{ invoice.quantity_box }}</td>
            <td class="text-center border border-slate-500">{{ invoice.box }}</td>
            <td class="w-64 text-center border border-slate-500" >{{ invoice.name }}</td>
            <td class="w-16 text-center border border-slate-500" >{{ invoice.code }}</td>
            <td class="text-center border border-slate-500">   {{ index + 1 }}</td>
          </tr>
          <tr>
            <td class="text-center border border-slate-500" colspan="3">{{ user.name }}</td>
            <td class="text-center border border-slate-500" colspan="2">ژمێریار</td>
            <td class="text-center border border-slate-500" >{{ props.totalBox }}</td>
            <td class="text-center border border-slate-500" colspan="4">کۆی کارتۆن</td>

          </tr>
        </tbody>
      </table>
      <div
      class="flex justify-center w-full mx-auto text-center"
      v-if="props.getDebt.old_debt != '0'"
    >
      <div class="w-1/3 text-sm border-b border-l border-slate-500"> USD کۆی گشتی | USD المجموع</div>
      <div class="w-1/3 text-sm border-b border-x border-slate-500"> USD قەرزی کۆن  | USD ديون القديمة</div>
      <div class="w-1/3 text-sm border-b border-r border-slate-500">USD قەرزی نوێ | USD ديون جديدة</div>
    </div>

    <div
      class="flex justify-center w-full mx-auto text-center"
      v-if="props.getDebt.old_debt != '0'"
    >
      <div class="w-1/3 border-b border-l border-slate-500"> {{  formatNumber(props.totalPriceAll) }}</div>
      <div class="w-1/3 border-b border-x border-slate-500">{{ formatNumber( getDebt.old_debt) }}</div>
      <div class="w-1/3 border-b border-r border-slate-500"> {{ formatNumber( totalNewDebt) }}</div>
    </div>
    <div
    v-if="props.getDebt.amount_dollar != 0 || props.getDebt.amount_dinar !=0"
    class="flex justify-center w-full mx-auto text-center ">
        <div class="w-1/2 border-b border-l border-slate-500"> بڕی پارەدان USD | المدفوع USD</div>
        <div class="w-1/2 border-b border-x border-slate-500">بڕی پارەدان IQD |  المدفوع IQD</div>
      </div>
      <div     v-if="props.getDebt.amount_dollar != 0 || props.getDebt.amount_dinar !=0" class="flex justify-center w-full mx-auto text-center ">
        <div class="w-1/2 border-b border-l border-slate-500"> {{ formatNumber( getDebt.amount_dollar) }}</div>
        <div class="w-1/2 border-b border-x border-slate-500"> {{ formatNumber( getDebt.amount_dinar) }}</div>
      </div>
      <div      class="flex justify-center w-full mx-auto text-center ">
        <div class="w-1/2 border-b border-l border-slate-500">USD کۆی بڕی پارەدان | USD جمع المدفوع</div>
        <div class="w-1/2 border-b border-x border-slate-500">USD داشکاندن | USD الخصم</div>
      </div>
    <div class="flex justify-center w-full mx-auto text-center ">
      <div class="w-1/2 border-b border-l border-slate-500">{{ formatNumber( getDebt.amount_of_debt) }}</div>
      <div class="w-1/2 border-b border-x border-slate-500"> {{ formatNumber( getDebt.discount) }}</div>
    </div>
    <div class="flex justify-center w-full mx-auto text-center ">
      <div class="w-full border-b border-x border-slate-500">USD بڕی ماوە | USD المتبقي</div>
    </div>
    <div class="flex justify-center w-full mx-auto text-center ">
      <div class="w-full border-b border-x border-slate-500"> {{ formatNumber(getDebt.new_debt) }}</div>
    </div>
    </div>

</template>
<script setup>
import { Link, router, usePage , useForm } from "@inertiajs/vue3";
import { ref, onMounted,computed } from 'vue';
import numeral from 'numeral';
import { format } from 'date-fns';



const props = defineProps({
  invoices: Object,
  getDebt: Object,
  totalPriceAll: Object,
  totalBox: Object,

});
const page = usePage();
const user = computed(() => page.props.auth.user);

const formattedDate = (dateString) => {
  return format(new Date(dateString), 'yyyy-MM-dd');
};
const formatTime = (dateTime) => {
      return format(new Date(dateTime), 'HH:mm');
    };


const totalNewDebt = computed(() => {
  const totalPriceAll = parseFloat(props.totalPriceAll) || 0;
  const oldDebt = parseFloat(props.getDebt.old_debt) || 0;
  return totalPriceAll + oldDebt;
});

const formatNumber = (number) => {
  return number == null || isNaN(number)
    ? "0"
    : numeral(number).format("0,0.[000]");
};

const getPositiveQuantity = (invoice) => {
  return invoice.quantity >= 0 ? invoice.quantity : 0;
};

const getNegativeQuantity = (invoice) => {
  return invoice.quantity < 0 ? invoice.quantity : 0;
};

const printImage = ref(null);

onMounted(() => {
  if (printImage.value) {
    printImage.value.addEventListener('load', () => {
      window.print();
    });
  }
});
</script>

<style>
.page {
  width: 21cm;
  min-height: 29.7cm;
  padding: 1cm;
  margin: 1cm auto;
  border: 1px #d3d3d3 solid;
  background: white;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

@page {
  size: A4;
  margin-left: 0;
  margin-bottom: 0;
  margin-top: 30px;
}

@media print {
  .no-print {
    display: none !important;
  }
  tbody tr:nth-child(16n)::after {
    content: "";
    display: block;
    page-break-after: always;
  }

  .page {
    margin: -15px -35px 0 10px;
    border: initial;
    width: initial;
    min-height: initial;
    box-shadow: initial;
    background: initial;
    page-break-after: always;
  }
}
</style>

