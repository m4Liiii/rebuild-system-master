<template>
    <Modal
    :show="isInvDeleteVisible"
    @close="closeInvDelete"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە سڕینەوەی پسولەی ( {{ props.getDebt.s_id }} ) ؟
        </h2>
        <div class="flex justify-end mt-6">

            <SecondaryButton @click="closeInvDelete()"> لابردن </SecondaryButton>

            <DangerButton  class="mx-3 ml-3" @click="DeleteInvoiceGet(),closeInvDelete()">سڕینەوە</DangerButton>

        </div>
    </div>
 </Modal>
    <Modal
    :show="isPrint"
    :custom-class="'mt-2'"
    :maxWidth="'sm'"
    @close="closePrint"
    >
    <div class="p-2 ">
        <div class="pb-3 text-2xl text-center text-gray-100 border-b border-cyan-200"> پسولە</div>
    </div>
<div class="pb-4">
    <table class="mx-auto">
        <thead>
            <tr>
                <th>
                    <div class="p-2 m-1 text-center rounded text-cyan-200">پسولە بە USD</div>
                </th>
                <th>
                    <div class="p-2 m-1 text-center rounded text-cyan-200">پسولە بە IQD</div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="p-2 m-1 bg-indigo-500 rounded" @click="navigateToInvoicePrint"><PrintSvg width="130px"  height="130px" class="text-gray-100 "  /></div>
                </td>
                <td>
                    <div class="p-2 m-1 bg-indigo-500 rounded" @click="navigateToInvoicePrintIQD"><PrintSvg width="130px"  height="130px" class="text-gray-100 " /></div>
                </td>
            </tr>

        </tbody>
    </table>
    <div class="flex justify-center mx-auto my-3">
    <DangerButton @click="closePrint">لابردن</DangerButton>
</div>
</div>
    </Modal>
    <Modal
    :show="isPrintConn"
    :custom-class="'mt-2'"
    :maxWidth="'sm'"
    @close="closeConn"
    >
    <div class="p-2 ">
        <div class="pb-3 text-2xl text-center text-gray-100 border-b border-cyan-200"> ناردن بۆ تۆڕە کۆمەڵایەتیەکان </div>

    </div>
<div class="pb-4">
    <table class="mx-auto">
        <thead>
            <tr>
                <th>
                    <div class="p-2 m-1 text-center rounded text-cyan-200">ناردن بە دراوی USD</div>

                </th>
                <th>
                    <div class="p-2 m-1 text-center rounded text-cyan-200">ناردن بە دراوی IQD</div>

                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="p-2 m-1 bg-gray-100 rounded" @click="SendToWhatsAppUSD"><WhatsappSvg/></div>
                </td>
                <td>
                    <div class="p-2 m-1 bg-gray-100 rounded" @click="SendToWhatsAppIQD"><WhatsappSvg/></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="p-2 m-1 bg-gray-100 rounded" @click="SendToWhatsAppUSD"><ViberSvg/></div>
                </td>
                <td>
                    <div class="p-2 m-1 bg-gray-100 rounded" @click="SendToWhatsAppUSD"><ViberSvg/></div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="flex justify-center mx-auto my-3">
    <DangerButton @click="closeConn">لابردن</DangerButton>
</div>
</div>
    </Modal>
    <Modal
    :show="showCalculateModal"
    :custom-class="'mt-10'"
    @close="CloseClModal"
 >
 <div class="mt-4 text-xl text-center text-white">فۆڕمی بڕی پارە وەرگرتن</div>
 <div class="p-4">
 <div class="px-2 my-3">
    <InputLabel for="a-usd"
        >بڕی پارە وەرگرتن بە USD
        {{
            formatNumber(getDebtForm.amount_dollar)
        }}</InputLabel
    >
    <div class="flex">
    <TextInput
        id="a-usd"
        type="text"
        v-model="getDebtForm.amount_dollar"
        class="w-full mt-1 rounded-l-none"
        placeholder="بڕی پارە وەرگرتن بە USD"
    />
    <button class="p-2 mt-1 text-white rounded-r-none rounded-l-md bg-cyan-500" @click="addToDebtUSD">
        <CalDollarSvg/>
       </button>
    </div>
    <InputError
        class="mt-2"
        :message="
            getDebtForm.errors.amount_dollar
                ? 'هەڵە هەیە لە بڕی پارە وەرگرتن بە USD'
                : ''
        "
    />
</div>

<div class="px-2 my-3">
    <InputLabel for="iqd-am"
        >({{formatNumber(dinarAmountConverted)}} $) بڕی پارە وەرگرتن بە IQD
        {{
            formatNumber(getDebtForm.amount_dinar)
        }} </InputLabel
    >
    <div class="flex">
    <TextInput
        id="iqd-am"
        type="text"
        v-model="getDebtForm.amount_dinar"
        class="w-full mt-1 rounded-l-none"
        placeholder="بڕی پارە وەرگرتن بە IQD"
    />
    <button class="p-2 mt-1 text-white rounded-r-none rounded-l-md bg-cyan-500" @click="addToDebtIQD">
        <CalDollarSvg/>
       </button>
    </div>
    <InputError
        class="mt-2"
        :message="
            getDebtForm.errors.amount_dinar
                ? 'هەڵە هەیە لە بڕی پارە وەرگرتن'
                : ''
        "
    />
</div>
<div class="text-xl text-center text-white">کۆی بڕی پارە وەرگرتن : {{ formatNumber(props.getDebt.amount_of_debt) }} $</div>
<InputError
    class="mt-2 text-center"
    :message="
        getDebtForm.errors.amount_of_debt
            ? 'هەڵە هەیە لە کۆی بڕی پارە وەرگرتن'
            : ''
    "
/>

<div class="pt-3 my-3 text-xl text-center text-white border-t"> بڕی ماوە بە USD : {{ formatNumber(new_debt) }}</div>
<div class="pt-3 my-3 text-xl text-center text-white border-t"> بڕی ماوە بە IQD : {{ formatNumber(new_debt_iqd) }}</div>
<div class="flex justify-center mt-6">
    <SecondaryButton class="mx-3" @click="CloseClModal"> لابردن </SecondaryButton>
    <DangerButton @click="resetAmounts" class="mx-3">بەتاڵ کردنەوە</DangerButton>
</div>
</div>
 </Modal>
    <Modal
    :customClass="'relative mt-4'"
    :maxWidth="'md'"
    :show="ShowCreateModalInvoice"
    @close="closeCreateModalInvoice"

 >
 <div dir="ltr" class="p-6 overflow-hidden text-left align-middle transition-all transform bg-gray-600 rounded-md shadow-xl">
    <div class="p-2">
        <div class="text-xl text-center text-white ">فۆڕمی زیادکردنی بابەت <Link v-if="InvoiceFormCreate.product_id" class="text-rose-300 inline_block" :href="route('categories.products.edit' , {category : InvoiceFormCreate.category_id , product: InvoiceFormCreate.product_id})"> -&gt; </Link></div>
        <div
        v-show="InvoiceFormCreate.product_id != '' && !showPrices"
        class="p-2 my-2 overflow-hidden text-center text-white bg-gray-600 border border-gray-100 rounded overflow-ellipsis whitespace-nowrap"
        @mouseover="showPrices = true"
        @mouseleave="showPrices = false"
      >
        {{ InvoiceFormCreate.code }} - {{ InvoiceFormCreate.name }}
      </div>


      <div
        v-show="InvoiceFormCreate.product_id != '' && showPrices"
        class="p-2 my-2 overflow-hidden text-center text-white bg-gray-600 border border-gray-100 rounded overflow-ellipsis whitespace-nowrap"
        @mouseover="showPrices = true"
        @mouseleave="showPrices = false"
      >
        {{ InvoiceFormCreate.p_tak }} -
        {{ InvoiceFormCreate.p_ko }} -
        {{ InvoiceFormCreate.p_buy }}
      </div>

      <div class="py-2" v-show="InvoiceFormCreate.product_id == ''">
        <label
          dir="RTL"
          for="namepr"
          class="relative block px-3 pt-3 overflow-hidden border border-gray-200 rounded-md shadow-sm focus-within:border-cyan-600 focus-within:ring-1 focus-within:ring-cyan-600"
        >
          <input
            autocomplete="off"
            maxlength="125"
            v-model="InvoiceFormCreate.name"
            type="text"
            id="namepr"
            placeholder="text"
            class="w-full h-8 p-0 text-white placeholder-transparent bg-transparent border-none peer focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm"
          />

          <span
            class="absolute text-xs text-white transition-all -translate-y-1/2 start-3 top-3 peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-3 peer-focus:text-xs"
          >
            ناوی بابەت
          </span>
        </label>
      </div>
      <div
      class="justify-center text-lg text-center "

    >  <p class="text-rose-300" v-if="!hasRemainingQuantity">{{ updatedQuantityOfStore }}</p>
      <p class="text-white" v-if="hasRemainingQuantity">{{ updatedQuantityOfStore }}</p>
    </div>
      <div class="pb-2" v-show="InvoiceFormCreate.product_id == ''">
        <label
          dir="RTL"
          for="codepr"
          class="relative block px-3 pt-3 overflow-hidden border border-gray-200 rounded-md shadow-sm focus-within:border-cyan-600 focus-within:ring-1 focus-within:ring-cyan-600"
        >
          <input
            autocomplete="off"
            maxlength="125"
            v-model="InvoiceFormCreate.code"
            type="text"
            id="codepr"
            placeholder="text"
            class="w-full h-8 p-0 text-white placeholder-transparent bg-transparent border-none peer focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm"
          />

          <span
            class="absolute text-xs text-white transition-all -translate-y-1/2 start-3 top-3 peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-3 peer-focus:text-xs"
          >
            کۆدی بابەت
          </span>
        </label>
      </div>
        <div class="flex items-center gap-1 pb-2">
            <button
              @click="increment_box"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-l bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &plus;
            </button>

            <input
              autocomplete="off"
              maxlength="12"
              @input="updateBox"
              v-model="InvoiceFormCreate.box"
              type="text"
              id="Box"
              placeholder="0"
              class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-cyan-500 border-y-gray-200 focus:outline-none focus:ring-0 sm:text-sm focus:border-cyan-500"
            />

            <button
              @click="decrement_box"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-r bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &minus;
            </button>
            <label
              for="Box"
              class="w-2/5 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded whitespace-nowrap"
            >
              کارتۆن</label
            >
          </div>
          <div class="flex items-center gap-1 pb-2">
            <button
              @click="increment_quantity_box"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-l bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &plus;
            </button>

            <input
              autocomplete="off"
              maxlength="12"
              placeholder="0"
              @input="updateQuantityBox"
              v-model="InvoiceFormCreate.quantity_box"
              type="text"
              id="Quantity_box"
              class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-cyan-500 border-y-gray-200 focus:outline-none focus:ring-0 sm:text-sm focus:border-cyan-500"
            />

            <button
              @click="decrement_quantity_box"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-r bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &minus;
            </button>
            <label
              for="Quantity_box"
              class="w-2/5 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded whitespace-nowrap"
              >ژ.ناو کارتۆن</label
            >
          </div>
          <div class="flex items-center gap-1 pb-2">
            <button
              @click="increment_quantity"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-l bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &plus;
            </button>

            <input
              autocomplete="off"
              maxlength="12"
              placeholder="0"
              @input="updateQuantity"
              v-model="InvoiceFormCreate.quantity"
              type="text"
              id="Quantity"
              class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-cyan-500 border-y-gray-200 focus:border-cyan-500 focus:outline-none focus:ring-0 sm:text-sm"
            />

            <button
              @click="decrement_quantity"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-r bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &minus;
            </button>
            <label
              for="Quantity"
              class="w-2/5 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded whitespace-nowrap"
            >
              <span
              @click="makeQuantityNegative"
              :class="{
                'text-rose-300':
                InvoiceFormCreate.quantity < 0,
              }"
                class="pl-1 cursor-pointer"

                >گەڕاوە</span
              >
              <span
              @click="makeQuantityPositive"
              :class="{
                'text-emerald-400':
                InvoiceFormCreate.quantity > 0,
              }"
                class="pr-1 border-r-2 border-gray-100 cursor-pointer"

                >ژمارە</span
              >
            </label>
          </div>

          <div class="flex items-center gap-1 pb-2">
            <button
              @click="increment_price"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-l bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &plus;
            </button>

            <input
              autocomplete="off"
               maxlength="12"
              @input="updatePrice"
              placeholder="0"
              v-model="InvoiceFormCreate.price"
              type="text"

              id="Price"
              class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-cyan-500 border-y-gray-200 focus:border-cyan-500 focus:outline-none focus:ring-0 sm:text-sm"
            />

            <button
              @click="decrement_price"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-r bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &minus;
            </button>
            <label
              for="Price"
              class="w-2/5 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded whitespace-nowrap"
              >$ نرخ</label
            >
          </div>
          <div class="flex items-center gap-1 pb-2">
            <input
              autocomplete="off"
              maxlength="25"
              placeholder="0"
              :value="price_iqd"
              readonly
              type="text"
              id="Price_iqd"
              class="w-full h-10  bg-gray-600 focus:border-cyan-500 text-white placeholder-gray-200 focus:outline-none rounded-sm focus:ring-0 border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
            />

            <label
              for="Price_iqd"
              class="w-2/3 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded-sm whitespace-nowrap"
            >
              نرخ د.ع</label
            >
          </div>
          <div class="flex items-center gap-1 pb-2">
            <input
              autocomplete="off"
               maxlength="12"
              placeholder="0"
              v-model="InvoiceFormCreate.price_all"
              type="text"

              id="Price_all"
              class="w-full h-10   bg-gray-600 focus:border-cyan-500 text-white placeholder-gray-200 focus:outline-none rounded-sm focus:ring-0 border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
            />

            <label
              for="Price_all"
              class="w-2/3 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded-sm whitespace-nowrap"
              >$ کۆی نرخ
            </label>
          </div>
          <div class="flex items-center gap-1">
            <input
              autocomplete="off"
              maxlength="25"
              placeholder="0"
                :value="price_iqd_all"
              readonly
              type="text"
              id="price_iqd_all"
              class="w-full h-10   bg-gray-600 focus:border-cyan-500 text-white placeholder-gray-200 focus:outline-none rounded-sm focus:ring-0 border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
            />

            <label
              for="price_iqd_all"
              class="w-2/3 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded-sm whitespace-nowrap"
              >کۆی نرخ د.ع
            </label>
          </div>

          <div
           v-if="
            props.lastGet_debt_id &&
            props.lastPrice"
             class="my-3 text-center ">
           <div class="mx-1 text-white cursor-pointer" @click="addToFormPrice"><span><span class="text-cyan-400">$</span> نرخی کۆتا پسولە</span> - <span class="text-cyan-400">{{ formatNumber(props.lastPrice) }}</span></div>

           <div class="mt-3 ml-7"><span class="mx-1 text-white"> ژمارەی کۆتا پسولە -</span><span class="text-cyan-400">{{ props.lastGet_debt_id }}</span><Link class="text-rose-300 " :href="route('getdebts.invoices.index', { getdebt: props.lastGet_debt_id })"> -&gt; </Link> </div>
        </div>
        <div class="flex justify-center mt-6">
            <PrimaryButton @click="CreateFormInvoiceSubmit(), closeCreateModalInvoice()" class="mx-3">زەخیرەکردن</PrimaryButton>
            <SecondaryButton class="mx-3" @click="closeCreateModalInvoice"> لابردن </SecondaryButton>
        </div>
    </div>
</div>
 </Modal>
    <Modal
    :customClass="'relative mt-4'"
    :maxWidth="'md'"
    :show="ShowEditModalInvoice"
    @close="closeEditModalInvoice"

 >
 <div dir="ltr" class="p-6 overflow-hidden text-left align-middle transition-all transform bg-gray-600 rounded-md shadow-xl">
    <div class="p-2">
        <div class="flex mb-3 border-b"  v-if="isIdsVisible">
            <div class="w-full p-2 -mt-5">
            <searchable-select
            :items="getDebtIds"
            :label="'گواستنەوەی خانە بۆ پسولەی تر'"
            v-model="InvoiceFormEdit.get_debt_id"
            :searchFields="['id']"
            class="w-full"
            :deselectable="true"
            deselect-button-class="mt-1.5"
            input-classes="rounded-l-none rounded-r-none "
           >
            <template #option-content="{ option }">
                {{ option.id }}
            </template>
           </searchable-select>
        </div>
          </div>
        <div class="flex justify-center text-xl text-center text-white">
             <div  v-if="props.getDebt.customer_id"   class="px-3 cursor-pointer text-cyan-500">
                <span @click="toggleIds" v-if="!isIdsVisible">&lt;&lt;</span><span  @click="toggleIds" v-else>&gt;&gt;</span>
            </div><span class="mx-3 text-white">فۆڕمی گۆڕینی بابەت </span> <div v-if="InvoiceFormEdit.product_id"><Link class="text-rose-300 inline_block" :href="route('categories.products.edit' , {category : InvoiceFormEdit.category_id , product: InvoiceFormEdit.product_id})"> -&gt; </Link></div></div>
        <div
        v-show="InvoiceFormEdit.product_id != '' && !showPrices"
        class="p-2 my-2 overflow-hidden text-center text-white bg-gray-600 border border-gray-100 rounded overflow-ellipsis whitespace-nowrap"
        @mouseover="showPrices = true"
        @mouseleave="showPrices = false"
      >
        {{ InvoiceFormEdit.code }} - {{ InvoiceFormEdit.name }}
      </div>


      <!-- Div for showing prices -->
      <div
        v-show="InvoiceFormEdit.product_id && showPrices"
        class="p-2 my-2 overflow-hidden text-center text-white bg-gray-600 border border-gray-100 rounded overflow-ellipsis whitespace-nowrap"
        @mouseover="showPrices = true"
        @mouseleave="showPrices = false"
      >
      {{ InvoiceFormEdit.price_of_sell_tak }} -
      {{ InvoiceFormEdit.price_of_sell_ko }} -
      {{ InvoiceFormEdit.price_of_buy }}


      </div>
      <div
      class="justify-center text-lg text-center "

    >  <p class="text-rose-300" v-if="!hasRemainingQuantityUpdate">{{ updatedQuantityOfStoreUpdate }}</p>
      <p class="text-white" v-if="hasRemainingQuantityUpdate">{{ updatedQuantityOfStoreUpdate }}</p>

    </div>
        <div class="flex items-center gap-1 pb-2">
            <button
              @click="increment_box_edit"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-l bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &plus;
            </button>

            <input
              autocomplete="off"
              maxlength="12"
              @input="updateBox"
              v-model="InvoiceFormEdit.box"
              type="text"
              id="Box"
              placeholder="0"
              class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-cyan-500 border-y-gray-200 focus:outline-none focus:ring-0 sm:text-sm focus:border-cyan-500"
            />

            <button
              @click="decrement_box_edit"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-r bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &minus;
            </button>
            <label
              for="Box"
              class="w-2/5 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded whitespace-nowrap"
            >
              کارتۆن</label
            >
          </div>
          <div class="flex items-center gap-1 pb-2">
            <button
              @click="increment_quantity_box_edit"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-l bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &plus;
            </button>

            <input
              autocomplete="off"
              maxlength="12"
              placeholder="0"
              @input="updateQuantityBox"
              v-model="InvoiceFormEdit.quantity_box"
              type="text"
              id="Quantity_box"
              class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-cyan-500 border-y-gray-200 focus:outline-none focus:ring-0 sm:text-sm focus:border-cyan-500"
            />

            <button
              @click="decrement_quantity_box_edit"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-r bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &minus;
            </button>
            <label
              for="Quantity_box"
              class="w-2/5 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded whitespace-nowrap"
              >ژ.ناو کارتۆن</label
            >
          </div>
          <div class="flex items-center gap-1 pb-2">
            <button
              @click="increment_quantity_edit"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-l bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &plus;
            </button>

            <input
              autocomplete="off"
              maxlength="12"
              placeholder="0"
              @input="updateQuantity"
              v-model="InvoiceFormEdit.quantity"
              type="text"
              id="Quantity"
              class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-cyan-500 border-y-gray-200 focus:border-cyan-500 focus:outline-none focus:ring-0 sm:text-sm"
            />

            <button
              @click="decrement_quantity_edit"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-r bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &minus;
            </button>
            <label
              for="Quantity"
              class="w-2/5 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded whitespace-nowrap"
            >
            <span
            @click="makeQuantityNegativeUpdate"
            :class="{
              'text-rose-300':
              InvoiceFormEdit.quantity < 0,
            }"
              class="pl-1 cursor-pointer"

              >گەڕاوە</span
            >
            <span
            @click="makeQuantityPositiveUpdate"
            :class="{
              'text-emerald-400':
              InvoiceFormEdit.quantity > 0,
            }"
                class="pr-1 border-r-2 border-gray-100 cursor-pointer"

                >ژمارە</span
              >
            </label>
          </div>

          <div class="flex items-center gap-1 pb-2">
            <button
              @click="increment_price_edit"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-l bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &plus;
            </button>

            <input
              autocomplete="off"
               maxlength="12"
              @input="updatePrice"
              placeholder="0"
              v-model="InvoiceFormEdit.price"
              type="text"

              id="Price"
              class="w-1/2 h-10 -mx-1 text-center text-white placeholder-gray-300 bg-gray-600 border-x-cyan-500 border-y-gray-200 focus:border-cyan-500 focus:outline-none focus:ring-0 sm:text-sm"
            />

            <button
              @click="decrement_price_edit"
              type="button"
              class="w-10 h-10 leading-10 text-gray-100 transition rounded-r bg-cyan-500 active:bg-cyan-600 hover:opacity-90"
            >
              &minus;
            </button>
            <label
              for="Price"
              class="w-2/5 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded whitespace-nowrap"
              >$ نرخ</label
            >
          </div>
          <div class="flex items-center gap-1 pb-2">
            <input
              autocomplete="off"
              maxlength="25"
              placeholder="0"
              :value="price_iqd_edit"
              readonly
              type="text"
              id="Price_iqd"
              class="w-full h-10  bg-gray-600 focus:border-cyan-500 text-white placeholder-gray-200 focus:outline-none rounded-sm focus:ring-0 border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
            />

            <label
              for="Price_iqd"
              class="w-2/3 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded-sm whitespace-nowrap"
            >
              نرخ د.ع</label
            >
          </div>
          <div class="flex items-center gap-1 pb-2">
            <input
              autocomplete="off"
               maxlength="12"
              placeholder="0"
              v-model="InvoiceFormEdit.price_all"
              type="text"

              id="Price_all"
              class="w-full h-10   bg-gray-600 focus:border-cyan-500 text-white placeholder-gray-200 focus:outline-none rounded-sm focus:ring-0 border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
            />

            <label
              for="Price_all"
              class="w-2/3 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded-sm whitespace-nowrap"
              >$ کۆی نرخ
            </label>
          </div>
          <div class="flex items-center gap-1">
            <input
              autocomplete="off"
              maxlength="25"
              placeholder="0"
                :value="price_iqd_all_edit"
              readonly
              type="text"
              id="price_iqd_all_edit"
              class="w-full h-10   bg-gray-600 focus:border-cyan-500 text-white placeholder-gray-200 focus:outline-none rounded-sm focus:ring-0 border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
            />

            <label
              for="price_iqd_all_edit"
              class="w-2/3 p-2 text-center text-gray-100 bg-gray-600 border border-gray-100 rounded-sm whitespace-nowrap"
              >کۆی نرخ د.ع
            </label>
          </div>
          <div
           v-if="InvoiceFormEdit.customer_id &&
            InvoiceFormEdit.product_id &&
            InvoiceFormEdit.last_get_debt_id &&
            InvoiceFormEdit.last_price"
             class="my-3 text-center ">
           <div class="mx-1 text-white cursor-pointer" @click="addToFormPriceEdit"><span><span class="text-cyan-400">$</span> نرخی کۆتا پسولە</span> - <span class="text-cyan-400">{{ formatNumber(InvoiceFormEdit.last_price) }}</span></div>

           <div class="mt-3 ml-7"><span class="mx-1 text-white"> ژمارەی کۆتا پسولە -</span><span class="text-cyan-400">{{ InvoiceFormEdit.last_get_debt_id }}</span><Link class="text-rose-300 " :href="route('getdebts.invoices.index', { getdebt: InvoiceFormEdit.last_get_debt_id })"> -&gt; </Link> </div>
        </div>
        <div class="flex justify-center mt-6">
            <PrimaryButton @click="EditFormInvoiceSubmit(), closeEditModalInvoice()" class="mx-3">زەخیرەکردن</PrimaryButton>
            <SecondaryButton class="mx-3" @click="closeEditModalInvoice"> لابردن </SecondaryButton>
        </div>
    </div>
</div>
 </Modal>
    <Modal
    :show="showConfirmDeleteInvoiceModal"
    @close="closeModalDelete"
 >
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە سڕینەوەی خانەی ( {{ invoiceToDelete ? invoiceToDelete.name : '' }} ) ؟
        </h2>
        <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModalDelete"> لابردن </SecondaryButton>
            <DangerButton  class="mx-3 ml-3" @click="deleteInvoice(invoiceIdToDelete.value)">سڕینەوە</DangerButton>
        </div>
    </div>
 </Modal>
    <Modal
        :customClass="'mt-5'"
        :show="isCreateCustomerVisible"
        @close="closeCreateCustomer"
    >
        <div class="p-6">
            <h4 class="text-lg font-medium text-center text-gray-200">
                فۆڕمی زیاد کردنی کڕیار
            </h4>
            <div class="mx-10 my-3">
                <InputLabel for="NameADD" value="ناو" />
                <TextInput
                    id="NameADD"
                    type="text"
                    v-model="CustomerForm.name_customer"
                    placeholder="ناو"
                    class="w-full mt-1"
                />
                <InputError
                    class="mt-2"
                    :message="
                        CustomerForm.errors.name_customer
                            ? 'هەڵە هەیە لە ناوی کڕیار'
                            : ''
                    "
                />
            </div>
            <div class="mx-10 my-3">
                <InputLabel for="oldDebt" value="قەرزی کۆن" />
                <TextInput
                    id="oldDebt"
                    type="text"
                    v-model="CustomerForm.debt_customer"
                    placeholder="قەرزی کۆن (ئارەزوومەندانە)"
                    class="w-full mt-1"
                />
                <InputError
                    class="mt-2"
                    :message="
                        CustomerForm.errors.debt_customer
                            ? 'هەڵە هەیە لە قەرزی کۆن'
                            : ''
                    "
                />
            </div>
            <div class="mx-10 my-3">
                <InputLabel for="address" value="ناونیشان" />
                <TextInput
                    id="address"
                    v-model="CustomerForm.address"
                    type="text"
                    placeholder="ناونیشان (ئارەزوومەندانە)"
                    class="w-full mt-1"
                />
                <InputError
                    class="mt-2"
                    :message="
                        CustomerForm.errors.address
                            ? 'هەڵە هەیە لە ناونیشان'
                            : ''
                    "
                />
            </div>
            <div class="mx-10 my-3">
                <InputLabel for="phone_number" value="ژمارەی مۆبایل" />
                <TextInput
                    id="phone_number"
                    type="text"
                    v-model="CustomerForm.phone_number"
                    placeholder="ژمارەی مۆبایل (ئارەزوومەندانە)"
                    class="w-full mt-1"
                />
                <InputError
                    class="mt-2"
                    :message="
                        CustomerForm.errors.phone_number
                            ? '  هەڵە هەیە لە ژمارەی مۆبایل'
                            : ''
                    "
                />
            </div>

            <div class="mx-10 my-3">
                <InputLabel for="social_num" value="ژمارەی کۆمەڵایەتی" />
                <TextInput
                    id="social_num"
                    type="text"
                    v-model="CustomerForm.social_number"
                    placeholder="ژمارەی کۆمەڵایەتی (ئارەزوومەندانە)"
                    class="w-full mt-1"
                />
                <InputError
                    class="mt-2"
                    :message="
                        CustomerForm.errors.social_number
                            ? 'هەڵە هەیە لە ژ.مۆبایلی کۆمەڵایەتی'
                            : ''
                    "
                />
            </div>
            <div class="mx-10 my-3">
                <InputLabel for="alrt" value="دیاری کردنی ڕۆژی پارە وەرگرتن" />
                <TextInput
                    id="alrt"
                    v-model="CustomerForm.alert_of_debt"
                    type="text"
                    placeholder="دیاری کردنی ڕۆژی پارە وەرگرتن (ئارەزوومەندانە)"
                    class="w-full mt-1"
                />
                <InputError
                    class="mt-2"
                    :message="
                        CustomerForm.errors.notice
                            ? '  هەڵە هەیە لە تێبینی'
                            : ''
                    "
                />
            </div>
            <div class="flex mx-10 my-3">
                <div class="flex items-center xl:mx-4">
                    <input
                        id="tak_form"
                        type="radio"
                        v-model="CustomerForm.type_customer"
                        value="0"
                        name="type-price-radio_form"
                        class="w-4 h-4 text-cyan-600 focus:ring-cyan-600 ring-offset-gray-800 focus:ring-2"
                    />
                    <label for="tak_form" class="mx-1 text-gray-300">تاک</label>
                </div>
                <div class="flex items-center xl:mx-4">
                    <input
                        id="ko_form"
                        type="radio"
                        v-model="CustomerForm.type_customer"
                        value="1"
                        name="type-price-radio_form"
                        class="w-4 h-4 text-emerald-600 focus:ring-emerald-600 ring-offset-gray-800 focus:ring-2"
                    />
                    <label for="ko_form" class="mx-1 text-gray-300">کۆ</label>
                </div>
            </div>
            <div class="flex justify-center mt-6">
                <SecondaryButton @click="closeCreateCustomer">
                    لابردن
                </SecondaryButton>
                <PrimaryButton @click="SubmitCustomerForm" class="mx-3 ml-3"
                    >زەخیرەکردن</PrimaryButton
                >
            </div>
        </div>
    </Modal>
    <AuthenticatedLayout :searchValue="search" @updateSearchValue="handleSearchUpdate">
        <div class="m-5 overflow-hidden lg:flex">
            <!-- Left Section (3/4 of the screen) -->
            <div class="p-4 mx-2 rounded-sm bg-zinc-600 lg:w-3/4">
                <!-- Header -->
                <div class="border-b md:flex">
                    <div
                        class="bg-zinc-600 text-zinc-600"
                        v-if="!props.getDebt.customer"
                    >
                        -
                    </div>
                    <div
                        class="flex text-white"
                        v-if="
                            props.getDebt.customer &&
                            (props.getDebt.customer.phone_number ||
                                props.getDebt.customer.address ||
                                props.getDebt.customer.name_customer)
                        "
                    >
                        {{ props.getDebt.customer.name_customer }} -
                        {{ props.getDebt.customer.address }} -
                        {{ props.getDebt.customer.phone_number }}
                    </div>
                    <span
                        v-if="props.getDebt.customer"
                        class="justify-start mr-auto text-right text-rose-300"
                        >{{ formattedDate(props.last_created_at) }}</span
                    >
                </div>
                <!-- Middle Image -->
                <div class="flex my-4">
                    <div class="items-center">
                        <div class="flex items-center pt-1 pl-2">
                            <input
                                id="ko"
                                type="radio"
                                value="1"
                                v-model="selectedType"
                                name="selected-type-radio"
                                class="w-4 h-4 text-emerald-600 focus:ring-emerald-600 ring-offset-gray-800 focus:ring-2"
                            />
                        </div>
                        <div class="flex items-center pt-1 pl-2">
                            <input
                                id="tak"
                                type="radio"
                                value="0"
                                v-model="selectedType"
                                name="selected-type-radio"
                                class="w-4 h-4 text-cyan-600 focus:ring-cyan-600 ring-offset-gray-800 focus:ring-2"
                            />
                        </div>
                    </div>
                    <div
                        @click="trueCreateCustomer"
                        class="flex items-center px-1 mt-1 text-3xl text-white bg-gray-600 border rounded-r cursor-pointer border-l-none"
                    >
                        <CustomerSvg  width="22px" height="22px" />
                    </div>
                    <searchable-select
                        :items="filteredCustomers"
                        :label="customerTypeLabel"
                        v-model="getDebtForm.customer_id"
                        :searchFields="[
                            'name_customer',
                            'address',
                            'phone_number',
                        ]"
                        class="w-full"
                        input-classes=" rounded-l-none rounded-r-none  "
                    >
                        <template #option-content="{ option }">
                            {{ option.name_customer }} - {{ option.address }} -
                            {{ option.phone_number }}
                        </template>
                    </searchable-select>
                    <Link
                    v-if="props.getDebt.customer"
                    :href="
                        route(
                            'customers.getdebts.index',
                            props.getDebt.customer.id
                        )
                    "
                    class="flex items-center px-1 mt-1 text-white bg-gray-600 border rounded-l cursor-pointer border-l-none"
                >
                   <BackSvg width="22px" height="22px" />
                </Link>
                <div v-else  class="flex items-center px-1 mt-1 text-white bg-gray-600 border rounded-l cursor-pointer border-l-none"
                >
                   <BackSvg width="22px" height="22px" />

                </div>
                </div>
                <div class="lg:flex">
                    <div class="flex lg:pl-2 lg:w-1/4">

                        <searchable-select
                        :items="categories"
                        v-model="selectedCategoryId"
                        label="گەڕان بۆ جۆری بابەت"
                        :searchFields="[
                            'name',
                            'code',
                        ]"
                        deselect-button-class="mt-2.5"
                        class="w-full"
                        input-classes=" rounded-l-none"
                        :deselectable="true"
                    >
                        <template #option-content="{ option }">
                            {{ option.name }} - {{ option.code }}
                        </template>
                    </searchable-select>
                    <button @click="openCreateModalInvoice" class="px-1 mt-1 bg-gray-600 border-l rounded-l border-y text-emerald-500"><CreateSvg width="24px" height="24px" /></button>
                </div>
                    <div class="lg:w-3/4">
                    <SearchableProduct
                    :items="filteredProducts"
                    label="گەڕان بۆ بابەت"
                    :searchFields="[
                        'name_of_product',
                        'code_of_product',
                    ]"
                    class="w-full"

                    deselect-button-class="mt-1.5"
                    :deselectable="true"
                    @product-selected="onProductSelected"
                >
                    <template #option-content="{ option }">
                       <span> {{ option.name_of_product }} </span> - <span class="text-indigo-200"> {{ option.code_of_product }} </span>
                    </template>
                </SearchableProduct>
            </div>
                </div>
                <main class="h-full overflow-y-auto py-7">
                    <div class="container grid mx-auto">
                      <div class="w-full overflow-hidden rounded-[5px] shadow-xs">
                        <div class="w-full overflow-x-auto">
                          <Table >
                            <TableHead>
                              <TableRowHead class="border border-gray-100">
                                <TableDataHead class="w-10" >#</TableDataHead>
                                <TableDataHead class="w-12" >کۆد</TableDataHead>
                                <TableDataHead class="w-96">ناو</TableDataHead>
                                <TableDataHead class="w-10" >کارتۆن</TableDataHead>
                                <TableDataHead class="w-10" >ژ.ن.کارتۆن</TableDataHead>
                                <TableDataHead class="w-16" >ژمارە</TableDataHead>
                                <TableDataHead class="w-16" >گەڕاوە</TableDataHead>
                                <TableDataHead class="w-16" >نرخ</TableDataHead>
                                <TableDataHead class="w-22" >کۆی نرخ</TableDataHead>
                                <TableDataHead class="w-10" ></TableDataHead>
                            </TableRowHead>
                            </TableHead>
                            <TableBody>
                              <TableRow :class="{
                                'text-rose-300 bg-gray-100': invoice.price_of_buy > invoice.price,
                                'bg-stone-600': invoice.price != invoice.last_price
                            }"   @click="openEditModalInvoice(invoice)" class="cursor-pointer" v-for="(invoice, index) in invoices.data" :key="invoice.id">
                                <TableData class="w-10" >{{ index + 1}}</TableData>
                                <TableData class="w-12" >{{ invoice.code }}</TableData>
                                <TableData class="w-96">{{ invoice.name }}</TableData>
                                <TableData class="w-10" >{{ invoice.box }}</TableData>
                                <TableData class="w-10" >{{ invoice.quantity_box }}</TableData>
                                <TableData class="w-16" >{{ getPositiveQuantity(invoice).value }}</TableData>
                                <TableData class="w-16" >{{ getNegativeQuantity(invoice).value }}</TableData>
                                <TableData class="w-16 " >{{ formatNumber(invoice.price) }}</TableData>
                                <TableData class="w-22" >{{ formatNumber(invoice.price_all) }}</TableData>
                                <TableData @click.stop="confirmDeleteInvoice(invoice.id)" class="w-10 whitespace-nowrap" ><button    class=" text-rose-300"><DeleteSvg/></button>
                               </TableData>
                              </TableRow>
                            </TableBody>
                            <TableHead>
                                <TableRowHead>
                                 <TableDataHead colspan="3" class="w-16">کۆی کارتۆن</TableDataHead>
                                  <TableDataHead class="w-16">{{ props.totalBoxes }}</TableDataHead>
                                  <TableDataHead colspan="4" class="w-16">کۆی گشتی بە USD</TableDataHead>
                                  <TableDataHead colspan="2" class="w-16">{{ formatNumber(props.totalPriceAll) }}</TableDataHead>
                                </TableRowHead>
                              </TableHead>
                              <TableHead>
                                <TableRowHead>
                                  <TableDataHead colspan="3" class="w-16"></TableDataHead>
                                  <TableDataHead  class="w-16"></TableDataHead>
                                  <TableDataHead colspan="4" class="w-16">کۆی گشتی بە IQD</TableDataHead>
                                  <TableDataHead colspan="2" class="w-16">{{ formatNumber(totalPriceAllDinar) }}</TableDataHead>
                                </TableRowHead>
                              </TableHead>
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
            </div>
            <!-- Right Section (1/4 of the screen) -->
            <div class="p-4 mx-2 rounded-sm bg-zinc-600 lg:w-1/4">
                <div
                    class="pb-2 mb-2 text-center text-white border-b border-white"
                >
                    ژمارەی پسولە - {{ props.getDebt.s_id }}#
                </div>
                <div class="flex justify-center">
                    <div class="flex items-center xl:mx-4">
                        <input
                            id="cyan-radio"
                            type="radio"
                            :value="0"
                            v-model="getDebtForm.type_price"
                            name="type-price-radio"
                            class="w-4 h-4 text-cyan-600 focus:ring-cyan-600 ring-offset-gray-800 focus:ring-2"
                        />
                        <label for="cyan-radio" class="mx-1 text-gray-300"
                            >تاک</label
                        >
                    </div>
                    <div class="flex items-center xl:mx-4">
                        <input
                            id="emerald-radio"
                            type="radio"
                            :value="1"
                            v-model="getDebtForm.type_price"
                            name="type-price-radio"
                            class="w-4 h-4 text-emerald-600 focus:ring-emerald-600 ring-offset-gray-800 focus:ring-2"
                        />
                        <label for="emerald-radio" class="mx-1 text-gray-300"
                            >کۆ</label
                        >
                    </div>
                    <div class="mx-3 mt-1.5">
                        <button
                            v-if="props.getDebt.type_notice == 1"
                            class="text-white"
                            @click="setTypeNoticeToZero"
                        >
                            <BookSvg />
                        </button>
                        <button
                            v-if="props.getDebt.type_notice == 0"
                            class="text-white"
                            @click="setTypeNoticeToOne"
                        >
                            <NotBookSvg />
                        </button>
                    </div>
                    <div
                        class="inline-block mt-1 text-xl text-white cursor-pointer xl:mx-4"
                        v-if="props.getDebt.customer && props.getDebt.new_debt == new_debt"
                   @click="repairDebt"
                        ><RepairRowSvg
                    />
                  </div>
                  <div
                  class="inline-block mt-1 text-xl cursor-pointer text-rose-300 animate-bounce xl:mx-4"
                  v-if="props.getDebt.customer && props.getDebt.new_debt != new_debt"
             @click="repairDebt"
                  ><RepairRowSvg
              />
            </div>
                    <div v-if="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 ">
                        <div class="text-gray-300 animate-spin">
                            <LoaderDebtSvg/>
                        </div>
                      </div>
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="date" value="بەروار" />
                    <TextInput
                        id="date"
                        type="datetime-local"
                        @input="submitGetDebt"
                        v-model="getDebtForm.created_at"
                        class="w-full mt-1"
                        placeholder="بەروار"
                    />
                    <InputError
                        class="mt-2"
                        :message="
                            getDebtForm.errors.created_at
                                ? 'هەڵە هەیە لە بەروار'
                                : ''
                        "
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="disc"
                        >نرخی دینار
                        {{ formatNumber(props.getDebt.curr) }}</InputLabel
                    >
                    <TextInput
                        id="cuu"
                        type="text"
                        v-model="getDebtForm.curr"
                        class="w-full mt-1"
                        placeholder="نرخی دینار"
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="old_debt" value="قەرزی کۆن" />
                    <TextInput
                        id="old_debt"
                        type="text"
                        v-model="getDebtForm.old_debt"
                        class="w-full mt-1"
                        placeholder="قەرزی کۆن"
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="price_all_all" value="کۆی گشتی" />
                    <TextInput
                        id="price_all_all"
                        type="text"
                        class="w-full mt-1"
                        :value="formatNumber(totalPriceAll)"
                        placeholder="کۆی گشتی"
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="new_price_all" value="قەرزی نوێ" />
                    <TextInput
                        id="new_price_all"
                        type="text"
                        :value="formatNumber(totalNewDebt)"
                        class="w-full mt-1"
                        placeholder="قەرزی نوێ"
                    />
                </div>


                <div class="px-2 my-3">
                    <InputLabel for="amount"
                    class="flex"
                        ><span class="flex"><span  @click="TrueClModal" class="pl-2 cursor-pointer text-cyan-400"><CalDollarSvg/></span>بڕی پارە وەرگرتن
                        {{
                            formatNumber(props.getDebt.amount_of_debt)
                        }} </span></InputLabel
                    >
                    <div class="flex">
                    <TextInput
                        id="amount"
                        type="text"
                        :readonly="shouldDisableAmountOfDebt"
                        v-model="getDebtForm.amount_of_debt"
                        class="w-full mt-1 rounded-l-none"
                        placeholder="بڕی پارە وەرگرتن"
                    /><button class="p-2 mt-1 text-white rounded-l-md bg-emerald-500"   @dblclick="addToDebtAmount" @click="addToAmountOfDebt">
                        <CalDollarSvg/>
                       </button>
                    </div>
                    <InputError
                        class="mt-2"
                        :message="
                            getDebtForm.errors.amount_of_debt
                                ? 'هەڵە هەیە لە بڕی پارە وەرگرتن'
                                : ''
                        "
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="disc"
                        >داشکاندن
                        {{ formatNumber(props.getDebt.discount) }}</InputLabel
                    >
                    <TextInput
                        id="disc"
                        type="text"
                        v-model="getDebtForm.discount"
                        class="w-full mt-1"
                        placeholder="داشکاندن"
                    />
                    <InputError
                        class="mt-2"
                        :message="
                            getDebtForm.errors.discount
                                ? 'هەڵە هەیە لە داشکاندن'
                                : ''
                        "
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="newDebt" value="بڕی ماوە" />
                    <TextInput
                        id="newDebt"
                        type="text"
                        class="w-full mt-1"
                        placeholder="بڕی ماوە"
                        :value="formatNumber(new_debt)"
                    />
                </div>
                <div>
                <div class="flex justify-between p-1 px-2">
                    <button  class="w-1/2 text-gray-100 bg-teal-500 rounded-sm hover:opacity-80 active:opacity-90 p-7 " @click="CreateAnotherInvoice">
                        <div class="flex justify-center ">
                            <CreateSvg width="40px" height="40px" />
                        </div></button>
                        <span class="px-1.5 pr-1"/>
                        <button @click="trueInvDelete" class="w-1/2 text-gray-100 rounded-sm hover:opacity-80 active:opacity-90 bg-rose-400 p-7">
                            <div class="flex justify-center "><DeleteSvg width="40px" height="40px"  />
                            </div></button>
                        </div>
            </div>
            <div class="mt-1.5">
                <div class="flex justify-between p-1 px-2">
                    <button class="w-1/2 text-gray-100 rounded-sm bg-sky-500 p-7 hover:opacity-80 active:opacity-90" @click="trueConn"><div class="flex justify-center ">
                        <ShareSvg width="40px" height="40px" />
                    </div></button>
                        <span  class="px-1.5 pr-1"/><button class="w-1/2 text-gray-100 bg-indigo-500 rounded-sm p-7 hover:opacity-80 active:opacity-90" @click="truePrint">
                            <div class="flex justify-center "><PrintSvg width="40px" height="40px" />
                            </div></button>
                        </div>
            </div>
            </div>
        </div>

        <div class="p-2 pt-1 mb-4 rounded-sm mx-7 bg-zinc-600">
            <div class="px-2 my-3">
                <InputLabel for="note"
                    >تێبینی
                    {{ formatText(props.getDebt.notice_of_debt) }}</InputLabel
                >
                <TextInput
                    id="note"
                    type="text"
                    class="w-full mt-1"
                    placeholder="تێبینی"
                    v-model="getDebtForm.notice_of_debt"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import numeral from "numeral";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TableRowHead from "@/Components/TableRowHead.vue";
import TableDataHead from "@/Components/TableDataHead.vue";
import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/Table.vue";
import TableBody from "@/Components/TableBody.vue";
import TableData from "@/Components/TableData.vue";
import TableHead from "@/Components/TableHead.vue";
import TextInput from "@/Components/TextInput.vue";
import WhatsappSvg from "@/Components/Svg/Whatsapp.vue";
import ViberSvg from "@/Components/Svg/Viber.vue";
import PrintSvg from "@/Components/Svg/PrintInv.vue";
import RepairRowSvg from "@/Components/Svg/RepairRow.vue";
import ShareSvg from "@/Components/Svg/Share.vue";
import LoaderDebtSvg from "@/Components/Svg/LoaderDebt.vue";
import BackSvg from "@/Components/Svg/Back.vue";
import DeleteSvg from "@/Components/Svg/Delete.vue";
import TableRow from "@/Components/TableRow.vue";
import SearchableSelect from "@/Components/SearchableSelect.vue";
import SearchableProduct from "@/Components/Searchable-Product.vue";
import { format } from "date-fns";
import { debounce } from "lodash";
import CreateSvg from "@/Components/Svg/Create.vue";
import CalDollarSvg from "@/Components/Svg/CalcDollar.vue";
import CustomerSvg from "@/Components/Svg/SideBar/Customer.vue";
import BookSvg from "@/Components/Svg/Book.vue";
import NotBookSvg from "@/Components/Svg/NotBook.vue";
import { computed, ref, watch } from "vue";
import { Head, Link, useForm, usePage, router } from "@inertiajs/vue3";
////// functionality-default-start //////////
const props = defineProps({
    getDebt: Object,
    customers: Object,
    last_created_at: Object,
    last_customer_id: Object,
    products: Object,
    categories: Object,
    invoices: Object,
    totalBoxes: Object,
    totalPriceAll: Object,
    getDebtIds: Object,
    lastPrice: Object,
    lastGet_debt_id: Object
});

const search = ref(props.invoices.search);


const CreateAnotherInvoice = () => {
    router.get(route("before.create.invoice"));
};



const navigateToInvoicePrint = () => {
        const url = route("print.invoice", { getdebt: props.getDebt.id });
        const printWindow = window.open(url, "_blank", "width=900,height=600");
      };
      const navigateToInvoicePrintIQD = () => {
        const url = route("print.invoice.IQD", { getdebt: props.getDebt.id });
        const printWindow = window.open(url, "_blank", "width=900,height=600");
      };

const loading = ref(false);

const repairDebt = () => {
  loading.value = true;
  router.put(route("repair.getdebts" , {customer: props.getDebt.customer.id}), {}, {
    onFinish: () => loading.value = false
  });
};

const handleSearchUpdate = (value) => {
 search.value = value;
};

watch([search], debounce(([newSearch]) => {
  router.get(
    route("getdebts.invoices.index" , props.getDebt.id),
    {
        search: newSearch,
    },
    {
      preserveState: true,
      replace: true,
    }
  );
}, 100));
const fetchLastPrice = () => {
      if (props.getDebt.customer_id && InvoiceFormCreate.product_id) {
        router.get(
          route("getdebts.invoices.index" , {getdebt: props.getDebt.id}),
          {
            search: search.value,
            customer_id: props.getDebt.customer_id,
            product_id: InvoiceFormCreate.product_id,
          },
          {
          preserveState: true,
            replace: true,
          }
        );
      }
    };


const formatPrice = (number) => {
    return number == null || isNaN(number)
        ? "0"
        : numeral(number).format("0.[000]");
};
const formatNumber = (number) => {
    return number == null || isNaN(number)
        ? "0"
        : numeral(number).format("0,0.[000]");
};
const formattedDate = (dateString) => {
    if (!dateString) {
        return "";
    }
    return format(new Date(dateString), "yyyy-MM-dd");
};

const trueConn = () => {
    isPrintConn.value = true;
};
const closeConn = () => {
    isPrintConn.value = false;
};
const isPrintConn = ref(false);


const truePrint = () => {
    isPrint.value = true;
};
const closePrint = () => {
    isPrint.value = false;
};
const isPrint = ref(false);





const getProductById = (productId) => {
  return props.products.find((product) => product.id == productId);
};
const getPositiveQuantity = (invoice) => {
  return computed(() => {
    return invoice.quantity >= 0 ? invoice.quantity : "0";
  });
};

const getNegativeQuantity = (invoice) => {
  return computed(() => {
    return invoice.quantity < 0 ? invoice.quantity : "0";
  });
};

const openWhatsApp = () => {
          let phoneNumber = props.getDebt.customer.social_number;
          let textMessage = "";
          let whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(textMessage)}`;
          window.open(whatsappUrl, '_blank');
      };

      const openViber = () => {
  let phoneNumber = props.getDebt.customer.social_number; // Ensure this is in international format
  let viberUrl = `viber://chat?number=${encodeURIComponent(phoneNumber)}`;
  window.open(viberUrl, '_blank');
};




const SendToWhatsAppUSD = () =>{
    openWhatsApp();
    const url = route("download.invoice", { getdebt: props.getDebt.id });
        window.open(url, "_blank", "width=900,height=600");
};

const SendToWhatsAppIQD = () =>{
    openWhatsApp();
    const url = route("download.invoice.IQD", { getdebt: props.getDebt.id });
        window.open(url, "_blank", "width=2000,height=600");
};

////// functionality-default-end //////////

//////////// get debt --- start --- //////////////////////

//// customer from getdebt -start- ////



const trueCreateCustomer = () => {
    isCreateCustomerVisible.value = true;
};
const closeCreateCustomer = () => {
    isCreateCustomerVisible.value = false;
    CustomerForm.reset();
};
const isCreateCustomerVisible = ref(false);

const CustomerForm = useForm({
    name_customer: "",
    debt_customer: "",
    alert_of_debt: "",
    address: "",
    phone_number: "",
    social_number: "",
    notice: "",
    type_customer: "1",
    type_delete: "1",
});

const SubmitCustomerForm = () => {
    CustomerForm.post(route("form.customer.store"), {
        onSuccess: () => {
            closeCreateCustomer();
            CustomerForm.reset();
            updateCustomerIdToLast();
        },
    });
};

const customerTypeLabel = computed(() => {
    return selectedType.value == "1"
        ? "گەڕان بۆ کڕیاری کۆ"
        : "گەڕان بۆ کڕیاری تاک";
});

const initialSelectedType = computed(() => {
    if (
        props.getDebt.customer &&
        props.getDebt.customer.type_customer != null
    ) {
        return props.getDebt.customer.type_customer.toString();
    }
    return "1";
});
const selectedType = ref(initialSelectedType.value);
const filteredCustomers = computed(() => {
    if (!props.customers || !Array.isArray(props.customers)) {
        return [];
    }
    return props.customers.filter(
        (customer) => customer.type_customer.toString() == selectedType.value
    );
});
const updateCustomerIdToLast = () => {
    if (props.last_customer_id) {
        getDebtForm.customer_id = props.last_customer_id.id;
        submitGetDebt();
    }
};

//// customer from getdebt -end- ////

const createdDate = computed(() => {
    if (props.getDebt.created_at) {
        return format(new Date(props.getDebt.created_at), "yyyy-MM-dd'T'HH:mm");
    }
    return "";
});

const formatText = (text) => {
    if (text == null) {
        return "";
    }
    return text.replace(/\s/g, "-");
};
const getDebtForm = useForm({
    old_debt: formatNumber(props.getDebt.old_debt),
    amount_of_debt: formatPrice(props.getDebt.amount_of_debt),
    discount: formatPrice(props.getDebt.discount),
    amount_dollar: formatPrice(props.getDebt.amount_dollar),
    amount_dinar: props.getDebt.amount_dinar,
    notice_of_debt: props.getDebt.notice_of_debt,
    type_price: props.getDebt.type_price,
    type_notice: props.getDebt.type_notice,
    customer_id: props.getDebt.customer_id,
    curr: props.getDebt.curr,
    created_at: createdDate.value,
});

const submitGetDebt = () => {
    const originalCustomerId = props.getDebt.customer_id;
    getDebtForm.put(route("Update.GetDebt.Invoice", props.getDebt.id), {
        preserveScroll: true,
        onSuccess: () => {
            if (getDebtForm.customer_id != originalCustomerId) {
                router.visit(window.location);
            }
        },
    });
};

watch(
    [
        () => getDebtForm.amount_of_debt,
        () => getDebtForm.discount,
        () => getDebtForm.curr,
    ],
    debounce((newVals, oldVals) => {
        submitGetDebt();
    }, 200)
);

watch(
    () => getDebtForm.notice_of_debt,
    debounce((newVal, oldVal) => {
        submitGetDebt();
    }, 500)
);

watch(
    () => getDebtForm.type_price,
    debounce((newVal, oldVal) => {
        submitGetDebt();
    }, 100)
);
watch(
    () => getDebtForm.customer_id,
    debounce((newVal, oldVal) => {
        submitGetDebt();
    }, 100)
);

const new_debt = computed(() => {
      const amountOfDebt = parseFloat(props.getDebt.amount_of_debt) || 0;
      const discount = parseFloat(props.getDebt.discount) || 0;
      const oldDebt = parseFloat(props.getDebt.old_debt) || 0;
      const totalPriceAll = parseFloat(props.totalPriceAll) || 0;

      return totalPriceAll + oldDebt - amountOfDebt - discount;
    });
    const new_debt_iqd = computed(() => {
      const amountOfDebt = parseFloat(props.getDebt.amount_of_debt) || 0;
      const discount = parseFloat(props.getDebt.discount) || 0;
      const oldDebt = parseFloat(props.getDebt.old_debt) || 0;
      const totalPriceAll = parseFloat(props.totalPriceAll) || 0;
      const curr = parseFloat(props.getDebt.curr) || 0;
      return Math.round(curr * (totalPriceAll + oldDebt - amountOfDebt - discount));
    });
const setTypeNoticeToOne = () => {
    getDebtForm.type_notice = 1;
    submitGetDebt();
};
const setTypeNoticeToZero = () => {
    getDebtForm.type_notice = 0;
    submitGetDebt();
};

const updateAmountOfDebt = () => {
  const dollarAmount = parseFloat(getDebtForm.amount_dollar) || 0;
  const dinarAmount = parseInt(getDebtForm.amount_dinar) / getDebtForm.curr || 0;
  const totalAmount = dollarAmount + dinarAmount;

  getDebtForm.amount_of_debt = formatPrice(totalAmount);
};
watch([() => getDebtForm.amount_dollar, () => getDebtForm.amount_dinar, () => getDebtForm.curr], updateAmountOfDebt);

const shouldDisableAmountOfDebt = computed(() => {
  const dollarAmount = parseFloat(getDebtForm.amount_dollar);
  const dinarAmount = parseInt(getDebtForm.amount_dinar);

  return (!isNaN(dollarAmount) && dollarAmount != 0) || (!isNaN(dinarAmount) && dinarAmount != 0);
});
//start//
const calculateDinarAmount = () => {
  const dinarAmount = parseInt(getDebtForm.amount_dinar) / getDebtForm.curr || 0;
  return dinarAmount;
};
const dinarAmountConverted = computed(() => {
  return calculateDinarAmount();
});
const totalPriceAllDinar = computed(() => {
  return props.totalPriceAll * props.getDebt.curr;
});
const totalNewDebt = computed(() => {
  const totalPriceAll = parseFloat(props.totalPriceAll) || 0;
  const oldDebt = parseFloat(props.getDebt.old_debt) || 0;
  return totalPriceAll + oldDebt;
});
const addToAmountOfDebt = () => {
    if (shouldDisableAmountOfDebt.value) return;
  const totalPriceAll = parseFloat(props.totalPriceAll) || 0;
  getDebtForm.amount_of_debt = totalPriceAll;
};
const addToDebtAmount = () => {
    if (shouldDisableAmountOfDebt.value) return;
  getDebtForm.amount_of_debt = totalNewDebt.value;
};
const addToDebtUSD = () => {
  getDebtForm.amount_dollar = totalNewDebt.value - formatNumber(getDebtForm.amount_dinar / getDebtForm.curr);
};
const addToDebtIQD = () => {
  getDebtForm.amount_dinar = totalNewDebt.value * getDebtForm.curr - Math.round(getDebtForm.amount_dollar * getDebtForm.curr);
};

const resetAmounts = () => {
    CloseClModal();
    getDebtForm.amount_dinar = 0;
    getDebtForm.amount_dollar = 0;
  };
  const TrueClModal = () => {
    showCalculateModal.value = true;
};
const CloseClModal = () => {
    showCalculateModal.value = false;
};
const showCalculateModal = ref(false);

const isIdsVisible = ref(false);

const toggleIds = () => {
  isIdsVisible.value = !isIdsVisible.value;
};


//end//
////////////// get debt --- end --- /////////////////////

///////////////products ---- start ---- //////////////////////
const selectedCategoryId = ref(null);

const filteredProducts = computed(() => {
  if (selectedCategoryId.value) {
    return props.products.filter(product => product.category_id == selectedCategoryId.value);
  }
  return props.products;
});
////////////////// products ----end----- //////////////////

///////////// invoices --- start --- ////////////////


/// delete -start- ///
const showConfirmDeleteInvoiceModal = ref(false);
const invoiceIdToDelete = ref(null);

const confirmDeleteInvoice = (id) => {
   invoiceIdToDelete.value = id;
   showConfirmDeleteInvoiceModal.value = true;
};
const closeModalDelete = () => {
   showConfirmDeleteInvoiceModal.value = false;
};

const invoiceToDelete = computed(() => {
   return props.invoices.data.find(invoice => invoice.id == invoiceIdToDelete.value);
});
const deleteInvoice = () => {
   router.delete(route('getdebts.invoices.destroy', { getdebt: props.getDebt.id, invoice: invoiceIdToDelete.value }), {
   onSuccess: () => closeModalDelete(),
   preserveState: true,
 });
};
/// delete -end- ///


/// edit -start- ///


const InvoiceFormEdit = useForm({
    id: '',
    product_id: '',
    name: '',
    code: '',
    box: '',
    quantity_box: '',
    quantity: '',
    profit: '',
    price: '',
    price_all: '',
    get_debt_id: '',
    last_get_debt_id: '',
    last_price: '',
});

const editInvoice = (invoice) => {
    InvoiceFormEdit.id = invoice.id;
    InvoiceFormEdit.product_id = invoice.product_id;
    InvoiceFormEdit.category_id = invoice.category_id;
    InvoiceFormEdit.customer_id = invoice.customer_id;
    InvoiceFormEdit.name = invoice.name;
    InvoiceFormEdit.code = invoice.code;
    InvoiceFormEdit.box = invoice.box;
    InvoiceFormEdit.get_debt_id = invoice.get_debt_id;
    InvoiceFormEdit.quantity_box = invoice.quantity_box;
    InvoiceFormEdit.quantity = invoice.quantity;
    InvoiceFormEdit.profit = invoice.profit;
    InvoiceFormEdit.price = formatPrice(invoice.price);
    InvoiceFormEdit.price_all = formatPrice(invoice.price_all);
    InvoiceFormEdit.price_of_buy = formatPrice(invoice.price_of_buy);
    InvoiceFormEdit.price_of_sell_ko = formatNumber(invoice.price_of_sell_ko);
    InvoiceFormEdit.price_of_sell_tak = formatNumber(invoice.price_of_sell_tak);
    InvoiceFormEdit.last_get_debt_id = invoice.last_get_debt_id;
    InvoiceFormEdit.last_price = invoice.last_price;
};


const EditFormInvoiceSubmit = () => {
  InvoiceFormEdit.put(route("getdebts.invoices.update" , {getdebt: props.getDebt.id , invoice: InvoiceFormEdit.id} ,{
        preserveScroll: true,
        onError: (errors) => {
            InvoiceFormEdit.errors = errors;
        },
  }));
};

const ShowEditModalInvoice = ref(false);

const closeEditModalInvoice = () => {
    ShowEditModalInvoice.value = false;
    InvoiceFormEdit.reset();
    isIdsVisible.value = false;
}

const openEditModalInvoice = (invoice) => {
    ShowEditModalInvoice.value = true;
    editInvoice(invoice);
}

const updateBox = () => {
  InvoiceFormEdit.quantity = InvoiceFormEdit.box * InvoiceFormEdit.quantity_box;
  updatePrice();
  updateQuantity();
};

const updateQuantityBox = () => {
  InvoiceFormEdit.quantity = InvoiceFormEdit.box * InvoiceFormEdit.quantity_box;
  updatePrice();
  updateQuantity();
};

const updatePrice = () => {
  InvoiceFormEdit.price_all = InvoiceFormEdit.price * InvoiceFormEdit.quantity;
};

const updateQuantity = () => {
  InvoiceFormEdit.price_all = InvoiceFormEdit.price * InvoiceFormEdit.quantity;
};

const increment_quantity_box_edit = () => {
  InvoiceFormEdit.quantity_box++;
  updateBox();
};

const decrement_quantity_box_edit = () => {
  InvoiceFormEdit.quantity_box--;
  updateBox();
};

const increment_box_edit = () => {
  InvoiceFormEdit.box++;
  updateBox();
};

const decrement_box_edit = () => {
  InvoiceFormEdit.box--;
  updateBox();
};

const increment_quantity_edit = () => {
  InvoiceFormEdit.quantity++;
  updatePrice();
  updateQuantity();
};

const decrement_quantity_edit = () => {
  InvoiceFormEdit.quantity--;
  updatePrice();
  updateQuantity();
};

const increment_price_edit = () => {
  InvoiceFormEdit.price++;
  updatePrice();
};

const decrement_price_edit = () => {
  InvoiceFormEdit.price--;
  updatePrice();
};
const price_iqd_all_edit = computed(() => {
  const priceAll = parseInt(InvoiceFormEdit.price_all || 0);
  const curr = parseInt(props.getDebt.curr || 0);
  return (priceAll * curr).toString();
})
const price_iqd_edit = computed(() => {
  const price = parseInt(InvoiceFormEdit.price || 0);
  const curr = parseInt(props.getDebt.curr || 0);
  return (price * curr).toString();
})

const addToFormPriceEdit = () => {
    InvoiceFormEdit.price = formatPrice(InvoiceFormEdit.last_price);
};

const totalInvoiceQuantity = computed(() => {
  if (!InvoiceFormEdit.id) {
    return 0;
  }
  const invoicesArray = props.invoices.data;
  return invoicesArray.reduce((total, invoice) => {
    return invoice.id == InvoiceFormEdit.id ? total + parseInt(invoice.quantity) : total;
  }, 0);
});
const updatedQuantityOfStoreUpdate = computed(() => {
      if (InvoiceFormEdit.product_id) {
        const selectedProduct = getProductById(InvoiceFormEdit.product_id);
        if (!selectedProduct) return "";

        const quantity = parseInt(InvoiceFormEdit.quantity) || 0;
        const totalQuantity = selectedProduct.quantity_of_store - quantity + totalInvoiceQuantity.value;
        const remainder = totalQuantity % selectedProduct.quantity_of_box;
        const boxes = parseInt(totalQuantity / selectedProduct.quantity_of_box);

        return `${boxes} ژمارە  ${remainder} , کارتۆن`;
      }
      return "";
    });

const hasRemainingQuantityUpdate = computed(() => {
  if (InvoiceFormEdit.product_id) {
    const selectedProduct = getProductById(InvoiceFormEdit.product_id);
    const quantity = parseInt(InvoiceFormEdit.quantity) || 0;
    return (selectedProduct.quantity_of_store - quantity + totalInvoiceQuantity.value) >= 0;
  }
  return false;
});

/// edit -end- ////


/// create -start- ///
const addToFormPrice = () => {
    InvoiceFormCreate.price = formatPrice(props.lastPrice);
};
const showPrices = ref(false);

const ShowCreateModalInvoice = ref(false);

const closeCreateModalInvoice = () => {
    ShowCreateModalInvoice.value = false;
    InvoiceFormCreate.reset();
}

const openCreateModalInvoice = () => {
    ShowCreateModalInvoice.value = true;
}

const InvoiceFormCreate = useForm({
    category_id: '',
    product_id: '',
    name: '',
    code: '',
    box: '',
    quantity_box: '',
    quantity: '',
    profit: '',
    price: '',
    price_all: '',
    p_tak:"",
    p_ko: "",
    p_buy: "",
});
const onProductSelected = (selectedProduct) => {

    setTimeout(() => {
    fetchLastPrice();
  },50);

  openCreateModalInvoice();
  InvoiceFormCreate.category_id = selectedProduct.category_id;
  InvoiceFormCreate.product_id = selectedProduct.id;
  InvoiceFormCreate.name = selectedProduct.name_of_product;
  InvoiceFormCreate.code = selectedProduct.code_of_product;
  InvoiceFormCreate.quantity_box = selectedProduct.quantity_of_box;
  if (props.getDebt.type_price == 0) {
    InvoiceFormCreate.price = formatPrice(selectedProduct.price_of_sell_tak);
  } else if (props.getDebt.type_price == 1) {
    InvoiceFormCreate.price = formatPrice(selectedProduct.price_of_sell_ko);
  }
  InvoiceFormCreate.p_tak = formatNumber(selectedProduct.price_of_sell_tak);
  InvoiceFormCreate.p_ko = formatNumber(selectedProduct.price_of_sell_ko);
  InvoiceFormCreate.p_buy = formatNumber(selectedProduct.price_of_buy);
};
const CreateFormInvoiceSubmit = () => {
    InvoiceFormCreate.post(route("getdebts.invoices.store" , props.getDebt.id));
};

const DeleteInvoiceGet = () => {
    router.put(route("getdebt.type_delete.inv" , props.getDebt.id));
};

const increment_quantity_box = () => {
      InvoiceFormCreate.quantity_box++;
    };
    const decrement_quantity_box = () => {
      InvoiceFormCreate.quantity_box--;
    };
    const increment_box = () => {
      InvoiceFormCreate.box++;
    };
    const decrement_box = () => {
      InvoiceFormCreate.box--;
    };
    const increment_quantity = () => {
      InvoiceFormCreate.quantity++;
    };
    const decrement_quantity = () => {
      InvoiceFormCreate.quantity--;
    };
    const increment_price = () => {
      InvoiceFormCreate.price++;
    };
    const decrement_price = () => {
      InvoiceFormCreate.price--;
    };
    const calculateQuantity = () => {
  const box = parseInt(InvoiceFormCreate.box) || 0;
  const quantityBox = parseInt(InvoiceFormCreate.quantity_box) || 0;
  InvoiceFormCreate.quantity = box * quantityBox;
};

const calculateTotalPrice = () => {
  const quantity = InvoiceFormCreate.quantity || 0;
  const price = InvoiceFormCreate.price || 0;
  InvoiceFormCreate.price_all = quantity * price;
};


watch(
  [() => InvoiceFormCreate.box, () => InvoiceFormCreate.quantity_box],
  calculateQuantity,
  { immediate: true }
);

watch(
  [() => InvoiceFormCreate.quantity, () => InvoiceFormCreate.price],
  calculateTotalPrice,
  { immediate: true }
);

const price_iqd_all = computed(() => {
  const priceAll = parseInt(InvoiceFormCreate.price_all || 0);
  const curr = parseInt(props.getDebt.curr || 0);
  return (priceAll * curr).toString();
})
const price_iqd = computed(() => {
  const price = parseInt(InvoiceFormCreate.price || 0);
  const curr = parseInt(props.getDebt.curr || 0);
  return (price * curr).toString();
})

const updatedQuantityOfStore = computed(() => {
  if (InvoiceFormCreate.product_id) {
    const selectedProduct = getProductById(InvoiceFormCreate.product_id);
    const quantity = parseInt(InvoiceFormCreate.quantity) || 0;
    const remainder =
      (selectedProduct.quantity_of_store - quantity) %
      selectedProduct.quantity_of_box;
    const boxes = parseInt(
      (selectedProduct.quantity_of_store - quantity) / selectedProduct.quantity_of_box
    );

    return `${boxes} ژمارە  ${remainder} , کارتۆن`;
  }
  return "";
});



const hasRemainingQuantity = computed(() => {
  if (InvoiceFormCreate.product_id) {
    const selectedProduct = getProductById(InvoiceFormCreate.product_id);
    const quantity = parseInt(InvoiceFormCreate.quantity) || 0;
    return (selectedProduct.quantity_of_store - quantity) >= 0;
  }
  return false;
});



/// create -end- ///

////////////// invoices --- end --- /////////////
const makeQuantityPositive = () => {
      InvoiceFormCreate.quantity = Math.abs(InvoiceFormCreate.quantity);
    };

    const makeQuantityNegative = () => {
      InvoiceFormCreate.quantity = -Math.abs(InvoiceFormCreate.quantity);
    };
    const makeQuantityNegativeUpdate = () => {
      let quantity = Number(InvoiceFormEdit.quantity);
      let price_all = Number(InvoiceFormEdit.price_all);

      if (quantity > 0) {
        InvoiceFormEdit.quantity = -quantity;
        InvoiceFormEdit.price_all = -price_all;
      }
    };

    const makeQuantityPositiveUpdate = () => {
      let quantity = Number(InvoiceFormEdit.quantity);
      let price_all = Number(InvoiceFormEdit.price_all);

      if (quantity < 0) {
        InvoiceFormEdit.quantity = -quantity;
        InvoiceFormEdit.price_all = -price_all;
      }
    };


    const trueInvDelete = () => {
    isInvDeleteVisible.value = true;
};
const closeInvDelete = () => {
    isInvDeleteVisible.value = false;
};
const isInvDeleteVisible = ref(false);
</script>
