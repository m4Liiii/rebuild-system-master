<template>
    <title>بابەتەکان</title>
  <div class="page font-KurdishFont">
    <table class="min-w-full bg-white">
      <thead>
        <tr
          class="h-1 bg-white border-b border-slate-500 "
        >
          <th
            v-if="selectedTableComputed == 'table1'"
            class="pr-6 text-sm font-normal tracking-normal text-center text-gray-600"
          >
            نرخی فرۆشتنی کۆ
          </th>

          <th
            v-else-if="selectedTableComputed == 'table2'"
            class="pr-6 text-sm font-normal tracking-normal text-center text-gray-600"
          >
            نرخی فرۆشتنی تاک
          </th>
          <th
            v-else-if="selectedTableComputed == 'table3'"
            class="pr-6 text-sm font-normal tracking-normal text-center text-gray-600"
          >
            نرخی کڕین
          </th>

          <th
            class="pr-6 text-sm font-normal tracking-normal text-center text-gray-600"
          >
            ژمارەی ناو کارتۆن
          </th>

          <th
            class="pr-6 text-sm font-normal tracking-normal text-center text-gray-600"
          >
            کۆی کۆگا
          </th>
          <th
            class="pr-6 text-sm font-normal tracking-normal text-center text-gray-600"
          >
            ناوی بابەت
          </th>
          <th
            class="pr-6 text-sm font-normal tracking-normal text-center text-gray-600"
          >
            کۆدی بابەت
          </th>
          <th
            class="pr-6 text-sm font-normal tracking-normal text-center text-gray-600"
          >
            #
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(product, index) in products"
          :key="product.id"
          class="h-1 bg-white border-b border-slate-500 "
        >
          <td
            v-if="selectedTableComputed == 'table1'"
            class="h-5 pr-6 overflow-y-hidden text-sm tracking-normal text-center text-gray-100 text-gray-800 whitespace-no-wrap"
          >
            {{ formatNumber(product.price_of_sell_ko) }}
          </td>
          <td
            v-else-if="selectedTableComputed == 'table2'"
            class="h-5 pr-6 overflow-y-hidden text-sm tracking-normal text-center text-gray-100 text-gray-800 whitespace-no-wrap"
          >
            {{ formatNumber(product.price_of_sell_tak) }}
          </td>
          <td
            v-else-if="selectedTableComputed == 'table3'"
            class="pr-6 overflow-y-hidden text-sm tracking-normal text-center text-gray-100 text-gray-800 whitespace-no-wrap"
          >
            {{ formatNumber(product.price_of_buy) }}
          </td>

          <td
            class="pr-6 overflow-y-hidden text-sm tracking-normal text-center text-gray-100 text-gray-800 whitespace-no-wrap"
          >
            {{ product.quantity_of_box }}
          </td>
          <td
            class="pr-6 overflow-y-hidden text-sm tracking-normal text-center text-gray-100 text-gray-800 whitespace-no-wrap"
          >
            {{ product.quantity_of_store }}
          </td>
          <td
            class="pr-6 overflow-y-hidden text-sm tracking-normal text-center text-gray-100 text-gray-800 whitespace-no-wrap"
          >
            {{ product.name_of_product }}
          </td>
          <td
            class="pr-6 overflow-y-hidden text-sm tracking-normal text-center text-gray-100 text-gray-800 whitespace-no-wrap"
          >
            {{ product.code_of_product }}
          </td>
          <td
            class="pr-6 overflow-y-hidden text-sm tracking-normal text-center text-gray-100 text-gray-800 whitespace-no-wrap"
          >
            {{ index + 1 }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import numeral from 'numeral';
import { ref, watch , computed  } from "vue";
const formatNumber = (number) => {
  return number == null || isNaN(number) ? "-" : numeral(number).format('0,0.[000]');
};


const props = defineProps({
 products: Object,
 category: Object,
 selectedTable: String
});

const selectedTableComputed = computed(() => props.selectedTable);

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
  margin: 0;
  margin-top: 30px;
}

@media print {
  tbody tr:nth-child(43n)::after {
    content: "";
    display: block;
    page-break-after: always;
  }

  .page {
    margin: -15px;
    border: initial;
    width: initial;
    min-height: initial;
    box-shadow: initial;
    background: initial;
    page-break-after: always;
  }
}
</style>
