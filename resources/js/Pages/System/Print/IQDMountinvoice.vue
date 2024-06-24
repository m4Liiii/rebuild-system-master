
<template >
    <div class="page font-KurdishFont" ref="contentToPrint">
       <div><img alt="Logo" src="/img/koga.jpg" /></div>
       <div class="">
        <div class="flex w-full border border-slate-500">
            <div class="w-1/6 text-center border-r border-slate-500">
                <div class="pb-5">{{ props.getDebt.s_id }}</div>
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
            <div class="w-1/6 text-sm text-center border-r border-slate-500">
                <div class="pb-5">{{ formattedDate(props.getDebt.created_at) }}</div>
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
                <div class="pb-5">{{ formatTime(props.getDebt.created_at) }}</div>
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
            <th class="pb-5 text-center border border-slate-500">کۆی نرخ</th>
            <th class="pb-5 text-center border border-slate-500">نرخ</th>
            <th class="pb-5 text-center border border-slate-500" >گەڕاوە</th>
            <th class="pb-5 text-center border border-slate-500" >ژمارە</th>
            <th class="pb-5 text-center border border-slate-500">ناو کارتۆن</th>
            <th class="pb-5 text-center border border-slate-500">کارتۆن</th>
            <th class="w-64 pb-5 text-center border border-slate-500">بابەت</th>
            <th class="w-16 pb-5 text-center border border-slate-500">کۆد</th>
            <th class="pb-5 text-center border border-slate-500">#</th>
          </tr>
          <tr>
            <th class="pb-5 text-center border border-slate-500">الاجمالي</th>
            <th class="pb-5 text-center border border-slate-500">السعر</th>
            <th class="pb-5 text-center border border-slate-500" >ارجاع</th>
            <th class="pb-5 text-center border border-slate-500" >العدد</th>
            <th class="pb-5 text-center border border-slate-500">داخل كارتون</th>
            <th class="pb-5 text-center border border-slate-500">كارتون</th>
            <th class="w-64 pb-5 text-center border border-slate-500">الموضوع</th>
            <th class="w-16 pb-5 text-center border border-slate-500">کود</th>
            <th class="pb-5 text-center border border-slate-500">#</th>
          </tr>
          <tbody>
          <tr v-for="(invoice, index) in invoices" :key="invoice"  >
            <td class="pb-5 text-center border border-slate-500"> {{ formatNumber(PriceAllIQD(invoice)) }}</td>
            <td class="pb-5 text-center border border-slate-500">  {{ formatNumber(PriceIQD(invoice)) }}</td>
            <td class="pb-5 text-center border border-slate-500" >{{ getNegativeQuantity(invoice) }}</td>
            <td class="pb-5 text-center border border-slate-500" >{{ getPositiveQuantity(invoice) }}</td>
            <td class="pb-5 text-center border border-slate-500">{{ invoice.quantity_box }}</td>
            <td class="pb-5 text-center border border-slate-500">{{ invoice.box }}</td>
            <td class="w-64 pb-5 text-center border border-slate-500" >{{ invoice.name }}</td>
            <td class="w-16 pb-5 text-center border border-slate-500" >{{ invoice.code }}</td>
            <td class="pb-5 text-center border border-slate-500">   {{ index + 1 }}</td>
          </tr>
          <tr>
            <td class="pb-5 text-center border border-slate-500" colspan="3">{{ user.name }}</td>
            <td class="pb-5 text-center border border-slate-500" colspan="2">ژمێریار</td>
            <td class="pb-5 text-center border border-slate-500" >{{ props.totalBox }}</td>
            <td class="pb-5 text-center border border-slate-500" colspan="4">کۆی کارتۆن</td>

          </tr>
        </tbody>
      </table>
      <div
      class="flex justify-center w-full mx-auto text-center"
      v-if="props.getDebt.old_debt != '0'"
    >
      <div class="w-1/3 text-sm border-b border-l border-slate-500"> IQD کۆی گشتی | IQD المجموع</div>
      <div class="w-1/3 text-sm border-b border-x border-slate-500"> <div class="pb-5">IQD قەرزی کۆن  | IQD ديون القديمة</div></div>
      <div class="w-1/3 text-sm border-b border-r border-slate-500">IQD قەرزی نوێ | IQD ديون جديدة</div>
    </div>

    <div
      class="flex justify-center w-full mx-auto text-center"
      v-if="props.getDebt.old_debt != '0'"
    >
      <div class="w-1/3 border-b border-l border-slate-500"> {{  formatNumber(Price_All) }}</div>
      <div class="w-1/3 border-b border-x border-slate-500"><div class="pb-4">{{ formatNumber(Old_Debt) }}</div></div>
      <div class="w-1/3 border-b border-r border-slate-500"> {{ formatNumber( totalNewDebt) }}</div>
    </div>
    <div
    v-if="props.getDebt.amount_dollar != 0 || props.getDebt.amount_dinar !=0"
    class="flex justify-center w-full mx-auto text-center ">
        <div class="w-1/2 border-b border-l border-slate-500"> بڕی پارەدان USD | المدفوع USD</div>
        <div class="w-1/2 border-b border-x border-slate-500"> <div class="pb-5">بڕی پارەدان IQD |  المدفوع IQD</div></div>
      </div>
      <div     v-if="props.getDebt.amount_dollar != 0 || props.getDebt.amount_dinar !=0" class="flex justify-center w-full mx-auto text-center ">
        <div class="w-1/2 border-b border-l border-slate-500"> {{ formatNumber( getDebt.amount_dollar) }}</div>
        <div class="w-1/2 border-b border-x border-slate-500"><div class="pb-4"> {{ formatNumber( getDebt.amount_dinar) }}</div></div>
      </div>
      <div      class="flex justify-center w-full mx-auto text-center ">
        <div class="w-1/2 border-b border-l border-slate-500">IQD کۆی بڕی پارەدان | IQD جمع المدفوع</div>
        <div class="w-1/2 border-b border-x border-slate-500"><div class="pb-5">IQD داشکاندن | IQD الخصم</div></div>
      </div>
    <div class="flex justify-center w-full mx-auto text-center ">
      <div class="w-1/2 border-b border-l border-slate-500">{{ formatNumber(Amount) }}</div>
      <div class="w-1/2 border-b border-x border-slate-500"> <div class="pb-4">{{ formatNumber(Discount) }}</div></div>
    </div>
    <div class="flex justify-center w-full mx-auto text-center ">
      <div class="w-full border-b border-x border-slate-500"><div class="pb-5">IQD بڕی ماوە | IQD المتبقي</div></div>
    </div>
    <div class="flex justify-center w-full mx-auto text-center ">
      <div class="w-full border-b border-x border-slate-500"><div class="pb-4"></div> {{ formatNumber(New_Debt) }}</div></div>
    </div>


</template>
<script setup>
import { Link, router, usePage , useForm } from "@inertiajs/vue3";
import { ref, onMounted,computed } from 'vue';
import numeral from 'numeral';
import { format } from 'date-fns';
import html2pdf from 'html2pdf.js';



const props = defineProps({
  invoices: Object,
  getDebt: Object,
  totalPriceAll: Object,
  totalBox: Object,

});

const contentToPrint = ref(null);

const generatePDF = () => {
        // Calculate the height of the content
        const contentHeight = contentToPrint.value.scrollHeight;

// Convert height from pixels to mm (assuming 96 DPI)
const heightInMm = (contentHeight / 96) * 25.4;
    const fileName = `${props.getDebt.id}-${props.getDebt.customer ? props.getDebt.customer.name_customer : ''}.pdf`;
      if (contentToPrint.value) {
        html2pdf().from(contentToPrint.value).set({
          margin: 10,
          filename: fileName,
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2 },
          jsPDF: {  unit: 'mm', format: [210, heightInMm + 100], orientation: 'portrait' }
        }).save().then(() => {
            closeTab();
        });
      }
    };

    const closeTab = () => {
      window.close();
    };

    onMounted(() => {
      generatePDF();
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
  const oldDebt = parseFloat(props.getDebt.old_debt) || 0;
  const curr = parseFloat(props.getDebt.curr) || 0;
  const totalPriceAll = parseFloat(props.totalPriceAll) || 0;
 const TotalPAll = (totalPriceAll*curr);
 const OldPAll = (oldDebt*curr);
  return (TotalPAll) + (OldPAll) ;

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


const PriceIQD = (invoice) => {
            if (invoice) {
                return parseFloat(invoice.price || 0) * parseFloat(props.getDebt.curr || 0);
            } else {
                return 0;
            }
        };
        const PriceAllIQD = (invoice) => {
            if (invoice) {
                return parseFloat(invoice.price_all || 0) * parseFloat(props.getDebt.curr || 0);
            } else {
                return 0;
            }
        };
            const New_Debt = computed(() => {
                return parseFloat(props.getDebt.new_debt || 0) * parseFloat(props.getDebt.curr || 0);
            });
            const Old_Debt = computed(() => {
                return parseFloat(props.getDebt.old_debt || 0) * parseFloat(props.getDebt.curr || 0);
            });
            const Price_All = computed(() => {
                return parseFloat(props.totalPriceAll || 0) * parseFloat(props.getDebt.curr || 0);
            });
            const Discount = computed(() => {
                return parseFloat(props.getDebt.discount || 0) * parseFloat(props.getDebt.curr || 0);
            });
            const Amount = computed(() => {
                return parseFloat(props.getDebt.amount_of_debt || 0) * parseFloat(props.getDebt.curr || 0);
            });
</script>

<style>
.page {
    width: 100;
    min-height: 29.7cm;
    padding: 1cm;
    margin: 1cm auto;
    border: 1px #d3d3d3 solid;
    background: white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  }

  @page {
    size: A4;
    margin: 0;

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
      border: initial;
      width: initial;
      min-height: initial;
      box-shadow: initial;
      background: initial;
      page-break-after: always;
    }
  }
</style>

