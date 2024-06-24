<template>
    <Modal
    :customClass="'relative mt-4'"
    :maxWidth="'4xl'"
    :show="ShowCreateModalInvoiceBuy"
    @close="closeCreateModalInvoiceBuy"

 >
 <div class="p-2 text-center text-gray-100 border-b">فۆڕمی زیاد کردنی بابەت</div>

<div class="px-3 py-2" v-if="InvoiceBuyFormCreate.product_id == ''" >
        <SearchableSelect
        :items="categories"
        :label="'گەڕان بۆ جۆری بابەت'"
        v-model="InvoiceBuyFormCreate.category_id"
        :searchFields="['name','code']"
        class="w-full"
        :deselectable="true"
        deselect-button-class="mt-1.5"

       >
        <template #option-content="{ option }">
            {{ option.name }} -  {{ option.code }}
        </template>
       </SearchableSelect>
    </div>
        <div class="flex flex-wrap justify-center flex-initial m-2" v-if="InvoiceBuyFormCreate.product_id == ''">
          <!-- First Pair -->
          <div class="px-2 lg:w-2/3">
            <InputLabel for="namew_p" value="ناو " class="relative" />
            <TextInput
              id="namew_p"
              type="text"
              maxLength="35"
              class="w-full mt-1"
              placeholder="ناو"

            />

          </div>

          <!-- Second Pair -->
          <div class="px-2 lg:w-1/3">
            <InputLabel for="codeP" >کۆد</InputLabel>
            <TextInput
              id="codeP"
              maxLength="12"
              type="text"
              class="w-full mt-1"
              placeholder="کۆد"

            />
          </div>
        </div>
        <div class="p-2 mx-4 my-4 overflow-hidden text-center text-gray-800 bg-gray-200 border rounded overflow-ellipsis whitespace-nowrap" v-if="InvoiceBuyFormCreate.product_id != ''"> {{ InvoiceBuyFormCreate.name}} - {{ InvoiceBuyFormCreate.code }}</div>
      <div class="flex justify-center text-center whitespace-nowrap">
        <div class="overflow-hidden text-center text-gray-100 overflow-ellipsis whitespace-nowrap" v-if="InvoiceBuyFormCreate.product_id != ''">{{ updateOfStore }}</div>
        <div class="mx-2 overflow-hidden text-center text-cyan-400 overflow-ellipsis whitespace-nowrap" v-if="InvoiceBuyFormCreate.product_id != ''">( {{ updatedQuantityOfStore }} )</div>
    </div>
        <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 lg:w-1/3">
              <InputLabel for="BoxP" value="کارتۆن" class="relative" />
              <TextInput
                id="BoxP"
                type="text"
                @input="BoxCount_Qbox"
                v-model="InvoiceBuyFormCreate.box"
                maxLength="35"
                class="w-full mt-1"
                placeholder="کارتۆن"

              />
            </div>

            <!-- Second Pair -->
            <div class="px-2 lg:w-1/3">
              <InputLabel for="QuantityBoxP" value="ژمارەی ناو کارتۆن" />
              <TextInput
                id="QuantityBoxP"
                type="text"
                maxLength="35"
                @input="BoxCount_Qbox"
                v-model="InvoiceBuyFormCreate.quantity_box"
                class="w-full mt-1"
                placeholder="ژمارەی ناو کارتۆن"

              />

            </div>
            <div class="px-2 lg:w-1/3">
                <InputLabel for="QuantP" value="کۆی ژمارە" />
                <TextInput
                  id="QuantP"
                  type="text"
                  maxLength="35"
                  @input="CountQuantity"
                  v-model="InvoiceBuyFormCreate.quantity"
                  class="w-full mt-1"
                  placeholder="کۆی ژمارە"

                />

              </div>
          </div>
          <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2" :class="repDebtForm.type_curr == 0 ? 'lg:w-full' : 'lg:w-1/2'">
                <InputLabel for="PricePrimarly" >نرخ بە {{ currencySpan }}</InputLabel>
            <TextInput
              id="PricePrimarly"
              type="text"
              maxLength="35"
              @input="PriceB"
              v-model="InvoiceBuyFormCreate.p_buy"
              class="w-full mt-1"
              placeholder="نرخ "

            />

            </div>

            <!-- Second Pair -->
            <div class="px-2 lg:w-1/2" v-if="repDebtForm.type_curr != 0" >
              <InputLabel for="BuyUSDCurr" value="نرخ بە USD" />
              <TextInput
                id="BuyUSDCurr"
                type="text"
                @input="PriceBCurr"
                v-model="InvoiceBuyFormCreate.p_buy_curr"
                maxLength="9"
                class="w-full mt-1"
                placeholder="نرخ بە USD"

              />

            </div>
          </div>
          <div class="flex flex-wrap justify-center flex-initial m-2">
            <!-- First Pair -->
            <div class="px-2 " :class="repDebtForm.type_curr == 0 ? 'lg:w-full' : 'lg:w-1/2'">
                <InputLabel for="ExOR" > خەرجی بە {{ currencySpan }}</InputLabel>
            <TextInput
              id="ExOR"
              type="text"
              maxLength="35"
                @input="ExpenseChanging"
                v-model="InvoiceBuyFormCreate.expense"
              class="w-full mt-1"
              placeholder="خەرجی"

            />

            </div>

            <!-- Second Pair -->
            <div class="px-2 lg:w-1/2" v-if="repDebtForm.type_curr != 0">
              <InputLabel for="ExUSD" value="خەرجی بە USD" />
              <TextInput
                id="ExUSD"
                v-model="InvoiceBuyFormCreate.expense_curr"
                type="text"
                @input="ExpenseChangingCurr"
                maxLength="9"
                class="w-full mt-1"
                placeholder="خەرجی بە USD"

              />

            </div>
          </div>
          <div class="flex flex-wrap justify-center flex-initial m-2" >
            <!-- First Pair -->
            <div class="px-2 " :class="repDebtForm.type_curr == 0 ? 'lg:w-full' : 'lg:w-1/2'">
                <InputLabel for="AllAAOR" > کۆی نرخ بە {{ currencySpan }}</InputLabel>
            <TextInput
              id="AllAAOR"
              type="text"
              maxLength="35"
              @input="PAllChanging"
              v-model="InvoiceBuyFormCreate.p_all_buy"
              class="w-full mt-1"
              placeholder=" کۆی نرخ "

            />

            </div>

            <!-- Second Pair -->
            <div class="px-2 lg:w-1/2" v-if="repDebtForm.type_curr != 0">
              <InputLabel for="AllIIUSD" value="کۆی نرخ بە USD" />
              <TextInput
                id="AllIIUSD"
                @input="PAllChangingCurr"
                v-model="InvoiceBuyFormCreate.p_all_buy_curr"
                type="text"
                maxLength="9"
                class="w-full mt-1"
                placeholder="کۆی نرخ بە USD"

              />

            </div>
          </div>
          <div class="flex flex-wrap justify-center flex-initial m-2" >
            <!-- First Pair -->
            <div class="px-2 lg:w-1/4" v-if="repDebtForm.type_curr != 0">
                <InputLabel for="PPPpeim"> نرخ بە {{ currencySpan }}</InputLabel>
            <TextInput
              id="PPPpeim"
              type="text"
              maxLength="35"
              v-model="InvoiceBuyFormCreate.price_all_curr"
              class="w-full mt-1"
              placeholder=" نرخ "

            />

            </div>

            <!-- Second Pair -->
            <div class="px-2 " :class="repDebtForm.type_curr == 0 ? 'lg:w-1/3' : 'lg:w-1/4'">
              <InputLabel for="alert2" value="نرخ بە USD" />
              <TextInput
                id="alert2"
                type="text"
                v-model="InvoiceBuyFormCreate.price_all"
                maxLength="9"
                class="w-full mt-1"
                placeholder="نرخ بە USD"

              />

            </div>
            <div class="px-2 " :class="repDebtForm.type_curr == 0 ? 'lg:w-1/3' : 'lg:w-1/4'">
                <InputLabel for="alert2" value="نرخی کۆ بە USD" />
                <TextInput
                  id="alert2"
                  type="text"
                  maxLength="9"
                  class="w-full mt-1"
                  v-model="InvoiceBuyFormCreate.sell_ko"
                  placeholder="نرخی کۆ بە USD"

                />

              </div>
            <div class="px-2 " :class="repDebtForm.type_curr == 0 ? 'lg:w-1/3' : 'lg:w-1/4'">
                <InputLabel for="address2" value=" نرخی تاک بە USD" />
            <TextInput
              id="address2"
              type="text"
              maxLength="35"
                v-model="InvoiceBuyFormCreate.sell_tak"
              class="w-full mt-1"
              placeholder=" نرخی تاک بە USD"

            />

            </div>

            <!-- Second Pair -->

          </div>
        <div class="flex justify-center py-5 ml-4">
          <SecondaryButton @click="closeCreateModalInvoiceBuy" class="mx-2">لابردن</SecondaryButton>
          <PrimaryButton class="mx-2 "  @click="CreateFormInvoiceBuySubmit(),closeCreateModalInvoiceBuy()">زەخیرەکردن</PrimaryButton>
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
                        v-if="!props.repDebt.seller"
                    >
                        -
                    </div>
                    <div
                        class="flex text-white"
                        v-if="
                            props.repDebt.seller &&
                            (props.repDebt.seller.phone_number ||
                                props.repDebt.seller.address ||
                                props.repDebt.seller.name_seller)
                        "
                    >
                        {{ props.repDebt.seller.name_seller }} -
                        {{ props.repDebt.seller.address }} -
                        {{ props.repDebt.seller.phone_number }}
                    </div>
                    <span
                        v-if="props.repDebt.seller"
                        class="justify-start mr-auto text-right text-rose-300"
                        >{{ formattedDate(props.last_created_at) }}</span
                    >
                </div>
                <!-- Middle Image -->
                <div class="flex my-4">
                    <div class="items-center">

                    </div>

                    <searchable-select
                        :items="sellers"
                        :label="sellerTypeLabel"
                        v-model="repDebtForm.seller_id"
                        :searchFields="[
                            'name_seller',
                            'address',
                            'phone_number',
                        ]"
                        class="w-full"
                        input-classes="rounded-l-none"
                    >
                        <template #option-content="{ option }">
                            {{ option.name_seller }} - {{ option.address }} -
                            {{ option.phone_number }}
                        </template>
                    </searchable-select>
                    <Link
                    v-if="props.repDebt.seller"
                    :href="
                        route(
                            'sellers.repdebts.index',
                            props.repDebt.seller.id
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
                    <button @click="openCreateModalInvoiceBuy" class="px-1 mt-1 bg-gray-600 border-l rounded-l border-y text-emerald-500"><CreateSvg width="24px" height="24px" /></button>
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
                                'text-rose-300 bg-gray-100': invoiceBuy.price_of_buy > invoiceBuy.price,
                                'bg-stone-600': invoiceBuy.price != invoiceBuy.last_price
                            }"   @click="openEditModalInvoiceBuy(invoiceBuy)" class="cursor-pointer" v-for="(invoiceBuy, index) in invoiceBuys.data" :key="invoiceBuy.id">
                                <TableData class="w-10" >{{ index + 1}}</TableData>
                                <TableData class="w-12" >{{ invoiceBuy.code }}</TableData>
                                <TableData class="w-96">{{ invoiceBuy.name }}</TableData>
                                <TableData class="w-10" >{{ invoiceBuy.box }}</TableData>
                                <TableData class="w-10" >{{ invoiceBuy.quantity_box }}</TableData>
                                <TableData class="w-16" >{{ invoiceBuy.quantity }}</TableData>
                                <TableData class="w-16 " >{{ formatNumber(invoiceBuy.price) }}</TableData>
                                <TableData class="w-22" >{{ formatNumber(invoiceBuy.price_all) }}</TableData>
                                <TableData @click.stop="confirmDeleteInvoiceBuy(invoiceBuy.id)" class="w-10 whitespace-nowrap" ><button    class=" text-rose-300"><DeleteSvg/></button>
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
                            <Pagination :links="invoiceBuys.links" :meta="invoiceBuys.meta" />
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
                    ژمارەی پسولە - {{ props.repDebt.s_id }}#
                </div>
                <div class="flex justify-center">

                    <div class="flex items-center text-gray-100 xl:mx-4 whitespace-nowrap">
                 جۆری دراو - {{ currencySpan }}
                    </div>
                    <div class="mx-3 mt-1.5">
                        <button
                            v-if="props.repDebt.type_notice == 1"
                            class="text-white"
                            @click="setTypeNoticeToZero"
                        >
                            <BookSvg />
                        </button>
                        <button
                            v-if="props.repDebt.type_notice == 0"
                            class="text-white"
                            @click="setTypeNoticeToOne"
                        >
                            <NotBookSvg />
                        </button>
                    </div>
                    <div
                        class="inline-block mt-1 text-xl text-white cursor-pointer xl:mx-4"
                        v-if="props.repDebt.seller && props.repDebt.new_debt == new_debt"
                   @click="repairDebt"
                        ><RepairRowSvg
                    />
                  </div>
                  <div
                  class="inline-block mt-1 text-xl cursor-pointer text-rose-300 animate-bounce xl:mx-4"
                  v-if="props.repDebt.seller && props.repDebt.new_debt != new_debt"
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
                        @input="submitrepDebt"
                        v-model="repDebtForm.created_at"
                        class="w-full mt-1"
                        placeholder="بەروار"
                    />
                    <InputError
                        class="mt-2"
                        :message="
                            repDebtForm.errors.created_at
                                ? 'هەڵە هەیە لە بەروار'
                                : ''
                        "
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="disc"
                        >
            نرخی دراو </InputLabel
                    >
                    <TextInput
                        id="cuu"
                        type="text"
                        v-model="repDebtForm.curr"
                        class="w-full mt-1"
                        placeholder="نرخی دینار"
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="old_debt" >قەرزی کۆن </InputLabel>
                    <TextInput
                        id="old_debt"
                        type="text"
                        v-model="repDebtForm.old_debt"
                        class="w-full mt-1"
                        placeholder="قەرزی کۆن"
                    />
                </div>
                <div class="px-2 my-3">
                       <InputLabel  for="price_all_all">کۆی گشتی </InputLabel>

                    <TextInput
                        id="price_all_all"
                        type="text"
                        class="w-full mt-1"
                        :value="formatNumber(totalPriceAll)"
                        placeholder="کۆی گشتی"
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel  for="new_price_all">قەرزی نوێ </InputLabel>
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
                        ><span class="flex"><span  @click="TrueClModal" class="pl-2 cursor-pointer text-cyan-400"></span> پارە وەرگرتن
                         {{
                            formatNumber(props.repDebt.amount_of_debt)
                        }} </span></InputLabel
                    >
                    <div class="flex">
                    <TextInput
                        id="amount"
                        type="text"
                        :readonly="shouldDisableAmountOfDebt"
                        v-model="repDebtForm.amount_of_debt"
                        class="w-full mt-1 "
                        placeholder="بڕی پارە وەرگرتن"
                    />
                    </div>
                    <InputError
                        class="mt-2"
                        :message="
                            repDebtForm.errors.amount_of_debt
                                ? 'هەڵە هەیە لە بڕی پارە وەرگرتن'
                                : ''
                        "
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="disc"
                        >داشکاندن
                        {{ formatNumber(props.repDebt.discount) }}</InputLabel
                    >
                    <TextInput
                        id="disc"
                        type="text"
                        v-model="repDebtForm.discount"
                        class="w-full mt-1"
                        placeholder="داشکاندن"
                    />
                    <InputError
                        class="mt-2"
                        :message="
                            repDebtForm.errors.discount
                                ? 'هەڵە هەیە لە داشکاندن'
                                : ''
                        "
                    />
                </div>
                <div class="px-2 my-3">
                    <InputLabel for="newDebt" >بڕی ماوە  </InputLabel>
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
                    {{ formatText(props.repDebt.notice_of_debt) }}</InputLabel
                >
                <TextInput
                    id="note"
                    type="text"
                    class="w-full mt-1"
                    placeholder="تێبینی"
                    v-model="repDebtForm.notice_of_debt"
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


    const props = defineProps({
    repDebt: Object,
    sellers: Object,
    products: Object,
    categories: Object,
    invoiceBuys: Object,
    totalBoxes: Object,
    totalPriceAll: Object,
});





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
const formatText = (text) => {
    if (text == null) {
        return "";
    }
    return text.replace(/\s/g, "-");
};
const formattedDate = (dateString) => {
    if (!dateString) {
        return "";
    }
    return format(new Date(dateString), "yyyy-MM-dd");
};
const createdDate = computed(() => {
    if (props.repDebt.created_at) {
        return format(new Date(props.repDebt.created_at), "yyyy-MM-dd'T'HH:mm");
    }
    return "";
});


const search = ref(props.invoiceBuys.search);

const repDebtForm = useForm({
    old_debt: formatNumber(props.repDebt.old_debt),
    amount_of_debt: formatPrice(props.repDebt.amount_of_debt),
    discount: formatPrice(props.repDebt.discount),
    notice_of_debt: props.repDebt.notice_of_debt,
    type_notice: props.repDebt.type_notice,
    seller_id: props.repDebt.seller_id,
    curr: 1,
    created_at: createdDate.value,
    type_curr: props.repDebt.type_curr,
});

const InvoiceBuyFormCreate = useForm({
    category_id: '',
    product_id: '',
    name: '',
    code: '',
    box: '',
    quantity_box: '',
    quantity: '',
    p_buy: '',
    p_buy_curr: '',
    expense:"",
    expense_curr: "",
    p_all_buy: "",
    p_all_buy_curr: "",
    price_all: "",
    price_all_curr: "",
    sell_ko: "",
    sell_tak: "",
});

const onProductSelected = (selectedProduct) => {

openCreateModalInvoiceBuy();
InvoiceBuyFormCreate.category_id = selectedProduct.category_id;
InvoiceBuyFormCreate.product_id = selectedProduct.id;
InvoiceBuyFormCreate.name = selectedProduct.name_of_product;
InvoiceBuyFormCreate.code = selectedProduct.code_of_product;
InvoiceBuyFormCreate.quantity_box = selectedProduct.quantity_of_box;
InvoiceBuyFormCreate.sell_tak = formatPrice(selectedProduct.price_of_sell_tak);
InvoiceBuyFormCreate.sell_ko = formatPrice(selectedProduct.price_of_sell_ko);
InvoiceBuyFormCreate.p_buy = formatPrice(selectedProduct.price_of_buy);
};

const BoxCount_Qbox = () => {
  const Box = parseInt(InvoiceBuyFormCreate.box) || 0;
  const QuantBox = parseInt(InvoiceBuyFormCreate.quantity_box) || 0;
  const Pbuy = parseFloat(InvoiceBuyFormCreate.p_buy) || 0;
  const Curr = parseInt(repDebtForm.curr) || 0;

  const Quantity = QuantBox * Box;
  const PAllBuy = Quantity * Pbuy;
  const PAllBuyCurr = PAllBuy / Curr;


  InvoiceBuyFormCreate.quantity = formatPrice(Quantity);
  InvoiceBuyFormCreate.p_all_buy = formatPrice(PAllBuy);
  InvoiceBuyFormCreate.p_all_buy_curr = formatPrice(PAllBuyCurr);
};


const CountQuantity = () => {
  const Quant = parseInt(InvoiceBuyFormCreate.quantity) || 0;
  const Pbuy = parseFloat(InvoiceBuyFormCreate.p_buy) || 0;
  const Curr = parseInt(repDebtForm.curr) || 0;

  const PAllBuy = Quant * Pbuy;
  const PAllBuyCurr = PAllBuy / Curr;


  InvoiceBuyFormCreate.p_all_buy = formatPrice(PAllBuy);
  InvoiceBuyFormCreate.p_all_buy_curr = formatPrice(PAllBuyCurr);
};




const PriceBCurr = () => {
  const Quant = parseInt(InvoiceBuyFormCreate.quantity) || 0;
  const PbuyCurr = parseFloat(InvoiceBuyFormCreate.p_buy_curr) || 0;
  const Curr = parseInt(repDebtForm.curr) || 0;
  const Expense = parseFloat(InvoiceBuyFormCreate.expense) || 0;
  const Expense_curr = parseFloat(InvoiceBuyFormCreate.expense_curr) || 0;

  const PbuyB = PbuyCurr * Curr;
  const PAllBuy = Quant * PbuyB;
  const PAllBuyCurr = PAllBuy / Curr;
  const Price = Expense + PbuyB;
  const PriceCurr = PbuyCurr + Expense_curr;

  InvoiceBuyFormCreate.price_all = formatPrice(PriceCurr);
  InvoiceBuyFormCreate.price_all_curr = formatPrice(Price);
  InvoiceBuyFormCreate.p_buy = formatPrice(PbuyB);
  InvoiceBuyFormCreate.p_all_buy = formatPrice(PAllBuy);
  InvoiceBuyFormCreate.p_all_buy_curr = formatPrice(PAllBuyCurr);
};

const PriceB = () => {
  const Quant = parseInt(InvoiceBuyFormCreate.quantity) || 0;
  const Pbuy = parseFloat(InvoiceBuyFormCreate.p_buy) || 0;
  const Curr = parseInt(repDebtForm.curr) || 0;
  const Expense = parseFloat(InvoiceBuyFormCreate.expense) || 0;
  const Expense_curr = parseFloat(InvoiceBuyFormCreate.expense_curr) || 0;



  const PAllBuy = Quant * Pbuy;
  const PAllBuyCurr = PAllBuy / Curr;
  const PbuyCurr = Pbuy / Curr;
  const Price = Expense + Pbuy;
  const PriceCurr = PbuyCurr + Expense_curr;


  InvoiceBuyFormCreate.price_all = formatPrice(PriceCurr);
  InvoiceBuyFormCreate.price_all_curr = formatPrice(Price);
  InvoiceBuyFormCreate.p_buy_curr = formatPrice(PbuyCurr);
  InvoiceBuyFormCreate.p_all_buy = formatPrice(PAllBuy);
  InvoiceBuyFormCreate.p_all_buy_curr = formatPrice(PAllBuyCurr);
};

const PAllChangingCurr = () => {
    const Changing = parseFloat(InvoiceBuyFormCreate.p_all_buy_curr) || 0;
    const Curr = parseInt(repDebtForm.curr) || 0;

    const Chang  = Changing * Curr;

    InvoiceBuyFormCreate.p_all_buy = formatPrice(Chang);
};


const PAllChanging = () => {
    const Changing = parseFloat(InvoiceBuyFormCreate.p_all_buy) || 0;
    const Curr = parseInt(repDebtForm.curr) || 0;

    const Chang  = Changing / Curr;

    InvoiceBuyFormCreate.p_all_buy_curr = formatPrice(Chang);
};


const ExpenseChanging = () => {
    const Curr = parseInt(repDebtForm.curr) || 0;
    const ExChanging = parseFloat(InvoiceBuyFormCreate.expense) || 0;
    const PBuy = parseFloat(InvoiceBuyFormCreate.p_buy) || 0;
    const PBuyCurr = parseFloat(InvoiceBuyFormCreate.p_buy_curr) || 0;

    const Xchanging = ExChanging / Curr;
    const PAllBuyCurr = ExChanging + PBuy;
    const PAllBuy = Xchanging + PBuyCurr;

    InvoiceBuyFormCreate.expense_curr = formatPrice(Xchanging);
    InvoiceBuyFormCreate.price_all = formatPrice(PAllBuy);
    InvoiceBuyFormCreate.price_all_curr = formatPrice(PAllBuyCurr);

};

const ExpenseChangingCurr = () => {
    const Curr = parseInt(repDebtForm.curr) || 0;
    const ExChanging = parseFloat(InvoiceBuyFormCreate.expense_curr) || 0;
    const PBuy = parseFloat(InvoiceBuyFormCreate.p_buy) || 0;
    const PBuyCurr = parseFloat(InvoiceBuyFormCreate.p_buy_curr) || 0;


    const Xchanging = ExChanging * Curr;
    const PAllBuyCurr = ExChanging + PBuyCurr;
    const PAllBuy = Xchanging + PBuy;


    InvoiceBuyFormCreate.expense = formatPrice(Xchanging);
    InvoiceBuyFormCreate.price_all = formatPrice(PAllBuyCurr);
    InvoiceBuyFormCreate.price_all_curr = formatPrice(PAllBuy);
};





const selectedCategoryId = ref(null);
const filteredProducts = computed(() => {
  if (selectedCategoryId.value) {
    return props.products.filter(product => product.category_id == selectedCategoryId.value);
  }
  return props.products;
});



  const currencySpan = computed(() => {
    switch (repDebtForm.type_curr) {
      case 0: return 'USD';
      case 1: return 'IQD';
      case 2: return 'IRR';
      case 3: return 'TRY';
      default: return '';
    }
  });
  const submitRepDebt = () => {
    const originalSellerId = props.repDebt.seller_id;
    repDebtForm.put(route("Update.RepDebt.InvoiceBuy", props.repDebt.id), {
        preserveScroll: true,
        onSuccess: () => {
            if (repDebtForm.seller_id != originalSellerId) {
                router.visit(window.location);
            }
        },
    });
};
  watch(
    () => repDebtForm.seller_id,
    debounce((newVal, oldVal) => {
        submitRepDebt();
    }, 100)
);
const ShowCreateModalInvoiceBuy = ref(false);

const closeCreateModalInvoiceBuy = () => {
    ShowCreateModalInvoiceBuy.value = false;
    InvoiceBuyFormCreate.reset();
}

const openCreateModalInvoiceBuy = () => {
    ShowCreateModalInvoiceBuy.value = true;
}

const CreateFormInvoiceBuySubmit = () => {
    InvoiceBuyFormCreate.post(route("repdebts.invoicebuys.store",props.repDebt.id));
};
const getProductById = (productId) => {
  return props.products.find((product) => product.id == productId);
};

const updatedQuantityOfStore = computed(() => {
  if (InvoiceBuyFormCreate.product_id) {
    const selectedProduct = getProductById(InvoiceBuyFormCreate.product_id);
    const quantity = parseInt(InvoiceBuyFormCreate.quantity) || 0;
    const quantity_of_store = parseInt(selectedProduct.quantity_of_store) || 0;
    const koga =  parseInt(quantity_of_store + quantity) || 0;
    return `${koga} `;
  }
  return "";
});

// Computed property for updateOfStore
const updateOfStore = computed(() => {
  if (InvoiceBuyFormCreate.product_id) {
    const UpdateStore = parseInt(updatedQuantityOfStore.value) || 0;
    const QuantityBox = parseInt(InvoiceBuyFormCreate.quantity_box) || 0;
    const remainder = (UpdateStore % QuantityBox) || 0;
    const boxes = parseInt(UpdateStore / QuantityBox) || 0;

    return `${boxes} کارتۆن , ${remainder} ژمارە `;
  }
  return "";
});
</script>
