<script setup>
import { ref, computed ,onMounted, watch  } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link, router, usePage , useForm } from "@inertiajs/vue3";
import UserSvg from "@/Components/Svg/User.vue";
import HumburgerSvg from "@/Components/Svg/Hamburger.vue";
import SearchSvg from "@/Components/Svg/Search.vue";
import SettingSvg from "@/Components/Svg/Setting.vue";
import SellSvg from "@/Components/Svg/SideBar/Sell.vue";
import DashboardSvg from "@/Components/Svg/SideBar/Dashboard.vue";
import CustomerSvg from "@/Components/Svg/SideBar/Customer.vue";
import CategorySvg from "@/Components/Svg/SideBar/Category.vue";
import InvoiceListSvgSide from "@/Components/Svg/SideBar/InvoiceList.vue";
import UserSvgSide from "@/Components/Svg/SideBar/User.vue";
import InvoiceAllSvgSide from "@/Components/Svg/SideBar/InvoiceAll.vue";
import PermissionSvg from "@/Components/Svg/SideBar/Permission.vue";
import LogoutSvg from "@/Components/Svg/Logout.vue";
import DeleteSvg from "@/Components/Svg/Delete.vue";
import { usePermission } from "@/Composables/permissions";
import Modal from "@/Components/Modal.vue";
import { debounce } from 'lodash';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import LayersSvg from "@/Components/Svg/Layers.vue";
import DangerButton from "@/Components/DangerButton.vue";
const { hasPermission } = usePermission();


onMounted(() => {
    router.reload();
});

const isOnline = ref(navigator.onLine);

// Update isOnline on connection changes
window.addEventListener("online", () => {
  isOnline.value = true;
});
window.addEventListener("offline", () => {
  isOnline.value = false;
});


const page = usePage();
const user = computed(() => page.props.auth.user);

const sidebarVisible = ref(false);

const toggleSidebar = () => {
  sidebarVisible.value = !sidebarVisible.value;
};
const outsideClick = (event) => {
  if (sidebarRef.value && !sidebarRef.value.contains(event.target)) {
    sidebarVisible.value = false;
  }
};

const sidebarRef = ref(null);

const props = defineProps({
  searchValue: String,
  currency: Object
});

const currencyForm = useForm({
    usd: page.props.currency.usd,
    iqd: page.props.currency.iqd,
    irr: page.props.currency.irr,
    try: page.props.currency.try,

});
const submitCurr = () => {
 currencyForm.put(route("update.currency" ,  page.props.currency.id));
};

watch([() => currencyForm.irr, () => currencyForm.try , () => currencyForm.iqd], debounce((newVals, oldVals) => {
    submitCurr();
}, 200));
const emit = defineEmits(["updateSearchValue"]);

const handleInput = (event) => {
  emit("updateSearchValue", event.target.value);
};

const AlertVisible = ref(false);

const closeAlert = () => {
    AlertVisible.value = false;
}

const showAlert = () => {
    AlertVisible.value = true;
}

const TrashVisible = ref(false);

const closeTrash = () => {
    TrashVisible.value = false;
}

const showTrash = () => {
    TrashVisible.value = true;
}

const ShowCurr = () => {
  CurrVisible.value = true;
};
const CloseCurr = () => {
  CurrVisible.value = false;
};
const CurrVisible = ref(false);


const isLoading = ref(false);

const reloadPage = () => {
  isLoading.value = true;
    router.visit(window.location.pathname);
    isLoading.value = true;
};


</script>

<template>
  <Modal
  :show="AlertVisible"
  :custom-class="'mt-2'"
  :maxWidth="'sm'"
  @close="closeAlert"
  >
  <div class="p-2 ">
      <div class="pb-3 text-2xl text-center border-b border-gray-100 text-rose-300">بەشی ئاگاداریەکان</div>

  </div>
<div class="pb-4">
  <table class="mx-auto">

      <tbody>
          <tr>
              <td>
                  <div class="flex justify-center">
                      <Link class="inline-block w-40 p-2 m-2 text-center text-gray-100 rounded-sm whitespace-nowrap bg-zinc-500 hover:bg-gray-600" :href="route('category.trash_show')">جۆری بابەتەکان <span class="text-rose-300">(343)</span></Link>
              </div>
              </td>
              <td>
                  <div class="flex justify-center">
                      <Link class="inline-block w-40 p-2 m-2 text-center text-gray-100 rounded-sm whitespace-nowrap bg-zinc-500 hover:bg-gray-600" :href="route('product.trash_show')">بابەتەکان <span class="text-rose-300">(33)</span></Link>
                  </div>
              </td>
          </tr>
      </tbody>
  </table>
  <div class="flex justify-center mx-auto my-3">
  <DangerButton @click="closeAlert">لابردن</DangerButton>
</div>
</div>
  </Modal>
    <Modal
    :show="TrashVisible"
    :custom-class="'mt-2'"
    :maxWidth="'sm'"
    @close="closeTrash"
    >
    <div class="p-2 ">
        <div class="pb-3 text-2xl text-center border-b border-gray-100 text-rose-300">بەشی سڕاوەکان</div>

    </div>
<div class="pb-4">
    <table class="mx-auto">

        <tbody>
            <tr>
                <td>
                    <div class="flex justify-center">
                        <Link class="inline-block w-40 p-2 m-2 text-center rounded-sm whitespace-nowrap text-cyan-400 bg-zinc-500 hover:bg-gray-600" :href="route('category.trash_show')">جۆری بابەتەکان</Link>
                </div>
                </td>
                <td>
                    <div class="flex justify-center">
                        <Link class="inline-block w-40 p-2 m-2 text-center rounded-sm whitespace-nowrap text-cyan-400 bg-zinc-500 hover:bg-gray-600" :href="route('product.trash_show')">بابەتەکان</Link>
                    </div>
                </td>

            </tr>
            <tr>
                <td>
                    <div class="flex justify-center">
                        <Link class="inline-block w-40 p-2 m-2 text-center rounded-sm whitespace-nowrap text-cyan-400 bg-zinc-500 hover:bg-gray-600" :href="route('customer.trash_show')">کڕیارەکان</Link>
                </div>
                </td>
                <td>
                    <div class="flex justify-center">
                        <Link class="inline-block w-40 p-2 m-2 text-center rounded-sm whitespace-nowrap text-cyan-400 bg-zinc-500 hover:bg-gray-600" :href="route('getdebt.trash_show')">پسولەکانی کڕیار</Link>

                    </div>
                </td>

            </tr>
            <tr>
                <td>
                    <div class="flex justify-center">
                        <Link class="inline-block w-40 p-2 m-2 text-center rounded-sm whitespace-nowrap text-cyan-400 bg-zinc-500 hover:bg-gray-600" :href="route('office.trash_show')">نوسینگەکان</Link>
                </div>
                </td>
                <td>
                    <div class="flex justify-center">
                        <Link class="inline-block w-40 p-2 m-2 text-center rounded-sm whitespace-nowrap text-cyan-400 bg-zinc-500 hover:bg-gray-600" :href="route('offdebt.trash_show')">پسولەکانی نوسینگە</Link>
                    </div>
                </td>

            </tr>
            <tr>
                <td>
                    <div class="flex justify-center">
                        <Link class="inline-block w-40 p-2 m-2 text-center rounded-sm whitespace-nowrap text-cyan-400 bg-zinc-500 hover:bg-gray-600" :href="route('seller.trash_show')">فرۆشیارەکان</Link>
                </div>
                </td>
                <td>
                    <div class="flex justify-center">
                        <Link class="inline-block w-40 p-2 m-2 text-center rounded-sm whitespace-nowrap text-cyan-400 bg-zinc-500 hover:bg-gray-600" :href="route('category.trash_show')">پسولەکانی فرۆشیار</Link>

                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="flex justify-center">
                        <Link class="inline-block w-40 p-2 m-2 text-center rounded-sm whitespace-nowrap text-cyan-400 bg-zinc-500 hover:bg-gray-600" :href="route('category.trash_show')">قەرزارەکان</Link>
                </div>
                </td>
                <td>
                    <div class="flex justify-center">
                        <Link class="inline-block w-40 p-2 m-2 text-center rounded-sm whitespace-nowrap text-cyan-400 bg-zinc-500 hover:bg-gray-600" :href="route('category.trash_show')">پسولەکانی قەرزارەکان</Link>

                    </div>
                </td>

            </tr>
        </tbody>
    </table>
    <div class="flex justify-center mx-auto my-3">
    <DangerButton @click="closeTrash">لابردن</DangerButton>
</div>
</div>
    </Modal>
    <Modal
    :customClass="'mt-5'"
    :show="CurrVisible"
    @close="CloseCurr"
    :maxWidth="'md'"
 >
    <div class="p-6">
        <div class="text-lg font-medium text-center text-emerald-300">
         بۆڕسە
        </div>
     <div class="mt-5 text-2xl text-center text-white"> نرخی ( 1 USD ) بەرامبەرە بە </div>

     <div class="mx-10 my-3 ">
            <InputLabel for="iqd" value="IQD" />
            <TextInput
              id="iqd"
              type="text"
              v-model="currencyForm.iqd"
              placeholder="IQD"
              class="w-full mt-1"
            />
          </div>
          <div class="mx-10 my-3 ">
            <InputLabel for="irr" value="IRR" />
            <TextInput
              id="irr"
              type="text"
              v-model="currencyForm.irr"
              placeholder="IRR"
              class="w-full mt-1"
            />
          </div>
          <div class="mx-10 my-3 ">
            <InputLabel for="try" value="TRY" />
            <TextInput
              id="try"
              type="text"
              v-model="currencyForm.try"
              placeholder="TRY"
              class="w-full mt-1"
            />
          </div>

        <div class="flex justify-center mt-6">
            <SecondaryButton @click="CloseCurr"> لابردن </SecondaryButton>
        </div>
    </div>
 </Modal>

  <div
    dir="rtl"
    class="flex h-screen overflow-hidden bg-zinc-500 font-KurdishFont"
    @click="outsideClick"
  >
    <!-- Desktop sidebar -->
    <aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-zinc-700 md:block">
      <div class="py-4 text-gray-500">
        <div class="text-3xl font-bold text-center uppercase text-emerald-400">
          rebuild
        </div>
        <div class="pt-4 pb-0.5 text-center border-b border-emerald-500 mx-1"></div>
        <div v-if="!isOnline" class="fixed right-0 p-2 text-white bg-red-600 bottom-5">
            ئاگاداربە هێڵی ئینتەرنێتەکەت پچڕاوە
          </div>
        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
          <span class="ml-2"><DashboardSvg /></span> بەشی سەرەکی
        </NavLink>
        <NavLink
          v-if="hasPermission('show_user')"
          :href="route('users.index')"
          :active="route().current('users.index') || route().current('users.create') || route().current('users.edit')"
        >
          <span class="ml-2"><UserSvgSide /></span> بەشی بەکار‌هێنەر
        </NavLink>
        <NavLink
        v-if="hasPermission('show_role')"
        :href="route('roles.index')"
        :active="route().current('roles.index') || route().current('roles.create') || route().current('roles.edit')"
      >
        <span class="ml-2"><PermissionSvg /></span> بەشی مۆڵەت
      </NavLink>
      <NavLink
      v-if="hasPermission('show_category')"
      :href="route('categories.index')"
      :active="route().current('categories.index') || route().current('categories.create')
       || route().current('categories.products.index') || route().current('categories.products.create') || route().current('categories.products.edit') "
    >
      <span class="ml-2"><CategorySvg /></span> بەشی بابەتەکان
    </NavLink>

    <NavLink
    v-if="hasPermission('show_getdebt')"
    :href="route('customers.index')"
    :active="route().current('customers.index') || route().current('customers.create') || route().current('customers.edit')
    || route().current('customers.getdebts.index')|| route().current('customers.getdebts.create')|| route().current('customers.getdebts.edit') "
  >
    <span class="ml-2"><CustomerSvg /></span> بەشی کڕیارەکان
  </NavLink>
  <NavLink
  v-if="hasPermission('create_getdebt')"
  :href="route('before.create.invoice')"
  :active="route().current('before.create.invoice') || route().current('getdebts.invoices.index')"
>
  <span class="ml-2"><SellSvg /></span> بەشی فرۆشتن
</NavLink>

<NavLink
v-if="hasPermission('show_getdebt')"
:href="route('list.invoice')"
:active="route().current('list.invoice')"
>
<span class="ml-2"><InvoiceListSvgSide /></span> بەشی ڕاپۆرتی فرۆشتن
</NavLink>

<NavLink
v-if="hasPermission('show_getdebt')"
:href="route('list.invoice.all')"
:active="route().current('list.invoice.all')"
>
<span class="ml-2"><InvoiceAllSvgSide /></span> بەشی  ڕاپۆرتی گشتی فرۆشتن
</NavLink>
<NavLink
v-if="hasPermission('show_getdebt')"
:href="route('sellers.index')"
:active="route().current('sellers.index')"
>
<span class="ml-2"><CustomerSvg /></span> بەشی فرۆشیارەکان
</NavLink>
<NavLink
v-if="hasPermission('create_getdebt')"
:href="route('before.create.invoicebuy')"
:active="route().current('before.create.invoicebuy')"
>
<span class="ml-2"><SellSvg /></span> بەشی کڕین
</NavLink>
<NavLink
v-if="hasPermission('show_getdebt')"
:href="route('offices.index')"
:active="route().current('offices.index') || route().current('offices.create') || route().current('offices.edit') || route().current('offices.offdebts.index') || route().current('offices.offdebts.create') || route().current('offices.offdebts.edit')"
>
<span class="ml-2"><InvoiceAllSvgSide /></span> بەشی نوسینگەکان
</NavLink>
<NavLink
v-if="hasPermission('show_debtor')"
:href="route('debtors.index')"
:active="route().current('debtors.index') || route().current('debtors.create') || route().current('debtors.edit') || route().current('debtors.onlydebts.index') || route().current('debtors.onlydebts.create') || route().current('debtors.onlydebts.edit')"
>
<span class="ml-2"><InvoiceAllSvgSide /></span> بەشی قەرزەکان
</NavLink>
<ul class="my-3 mr-0.5">
    <li class="relative px-4 py-2">
              <span class="inline-flex items-center w-full text-sm text-gray-100 transition-colors duration-150 cursor-pointer hover:text-gray-300">
                <span class="ml-2 "><LayersSvg /></span> بەشی ئاگاداریەکان  <span class="mx-2 text-rose-300">22</span>
              </span>

      </li>
  </ul>
  <ul class="my-3 mr-0.5">
    <li class="relative px-4 py-2">
              <span
              v-if="route().current('category.trash_show')"
                class="absolute inset-y-0 right-0 w-1 rounded-tl-lg rounded-bl-lg bg-cyan-500"
              ></span>
              <span @click="showTrash" class="inline-flex items-center w-full text-sm transition-colors duration-150 cursor-pointer "
              :class="{ 'text-cyan-500 hover:text-cyan-600': route().current('category.trash_show'), 'text-gray-100 hover:text-gray-300': !route().current('category.trash_show') }">
            <span class="ml-2"><DeleteSvg /></span> بەشی سڕاوەکان
        </span>
      </li>
  </ul>
      </div>
    </aside>
    <!-- Mobile sidebar -->
    <aside
      ref="sidebarRef"
      class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-[70px] overflow-y-auto bg-zinc-700 md:hidden"
      v-if="sidebarVisible"
    >
      <div class="py-4 text-gray-500">
        <div class="text-3xl font-bold text-center uppercase text-emerald-400">
            rebuild
          </div>
          <div class="pt-4 pb-0.5 text-center border-b border-emerald-500 mx-1"></div>
        <div v-if="!isOnline" class="fixed right-0 p-2 text-white bg-red-600 bottom-5">
            ئاگاداربە هێڵی ئینتەرنێتەکەت پچڕاوە
          </div>
          <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
            <span class="ml-2"><DashboardSvg /></span> بەشی سەرەکی
          </NavLink>
          <NavLink
            v-if="hasPermission('show_user')"
            :href="route('users.index')"
            :active="route().current('users.index') || route().current('users.create') || route().current('users.edit')"
          >
            <span class="ml-2"><UserSvgSide /></span> بەشی بەکار‌هێنەر
          </NavLink>
          <NavLink
          v-if="hasPermission('show_role')"
          :href="route('roles.index')"
          :active="route().current('roles.index') || route().current('roles.create') || route().current('roles.edit')"
        >
          <span class="ml-2"><PermissionSvg /></span> بەشی مۆڵەت
        </NavLink>
        <NavLink
        v-if="hasPermission('show_category')"
        :href="route('categories.index')"
        :active="route().current('categories.index') || route().current('categories.create')
         || route().current('categories.products.index') || route().current('categories.products.create') || route().current('categories.products.edit') "
      >
        <span class="ml-2"><CategorySvg /></span> بەشی بابەتەکان
      </NavLink>

      <NavLink
      v-if="hasPermission('show_getdebt')"
      :href="route('customers.index')"
      :active="route().current('customers.index') || route().current('customers.create') || route().current('customers.edit')
      || route().current('customers.getdebts.index')|| route().current('customers.getdebts.create')|| route().current('customers.getdebts.edit') "
    >
      <span class="ml-2"><CustomerSvg /></span> بەشی کڕیارەکان
    </NavLink>
    <NavLink
    v-if="hasPermission('create_getdebt')"
    :href="route('before.create.invoice')"
    :active="route().current('before.create.invoice') || route().current('getdebts.invoices.index')"
  >
    <span class="ml-2"><SellSvg /></span> بەشی فرۆشتن
  </NavLink>

  <NavLink
  v-if="hasPermission('show_getdebt')"
  :href="route('list.invoice')"
  :active="route().current('list.invoice')"
  >
  <span class="ml-2"><InvoiceListSvgSide /></span> بەشی ڕاپۆرتی فرۆشتن
  </NavLink>

  <NavLink
  v-if="hasPermission('show_getdebt')"
  :href="route('list.invoice.all')"
  :active="route().current('list.invoice.all')"
  >
  <span class="ml-2"><InvoiceAllSvgSide /></span> بەشی  ڕاپۆرتی گشتی فرۆشتن
  </NavLink>
  <NavLink
  v-if="hasPermission('show_getdebt')"
  :href="route('sellers.index')"
  :active="route().current('sellers.index')"
>
  <span class="ml-2"><CustomerSvg /></span> بەشی فرۆشیارەکان
</NavLink>
  <NavLink
  v-if="hasPermission('show_getdebt')"
  :href="route('offices.index')"
  :active="route().current('offices.index') || route().current('offices.create') || route().current('offices.edit') || route().current('offices.offdebts.index') || route().current('offices.offdebts.create') || route().current('offices.offdebts.edit')"
  >
  <span class="ml-2"><InvoiceAllSvgSide /></span> بەشی نوسینگەکان
  </NavLink>
  <NavLink
  v-if="hasPermission('show_debtor')"
  :href="route('debtors.index')"
  :active="route().current('debtors.index') || route().current('debtors.create') || route().current('debtors.edit') || route().current('debtors.onlydebts.index') || route().current('debtors.onlydebts.create') || route().current('debtors.onlydebts.edit')"
  >
  <span class="ml-2"><InvoiceAllSvgSide /></span> بەشی قەرزەکان
  </NavLink>
  <ul class="my-3 mr-0.5">
      <li class="relative px-4 py-2">
                <span class="inline-flex items-center w-full text-sm text-gray-100 transition-colors duration-150 cursor-pointer hover:text-gray-300">
                  <span class="ml-2 "><LayersSvg /></span> بەشی ئاگاداریەکان  <span class="mx-2 text-rose-300">22</span>
                </span>

        </li>
    </ul>
    <ul class="my-3 mr-0.5">
      <li class="relative px-4 py-2">
                <span
                v-if="route().current('category.trash_show')"
                  class="absolute inset-y-0 right-0 w-1 rounded-tl-lg rounded-bl-lg bg-cyan-500"
                ></span>
                <span @click="showTrash" class="inline-flex items-center w-full text-sm transition-colors duration-150 cursor-pointer "
                :class="{ 'text-cyan-500 hover:text-cyan-600': route().current('category.trash_show'), 'text-gray-100 hover:text-gray-300': !route().current('category.trash_show') }">
              <span class="ml-2"><LayersSvg /></span> بەشی سڕاوەکان
          </span>

        </li>
    </ul>
      </div>
    </aside>
    <div class="flex flex-col flex-1">
      <header class="z-10 py-4 shadow-md bg-zinc-600">
        <div
          class="container flex items-center justify-between h-full px-6 mx-auto text-cyan-500"
        >
          <button
            @click.stop="toggleSidebar"
            class="p-1 px-4 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
          >
            <HumburgerSvg />
          </button>
          <!-- Search input -->
          <div class="absolute hidden mx-2 cursor-pointer md:block whitespace-nowrap" @click="ShowCurr">
            USD 1 = IQD {{ page.props.currency.iqd }}
          </div>

          <div class="flex justify-center flex-1">
            <div class="relative w-full max-w-xl ml-2" >
              <div class="absolute inset-y-0 flex items-center mr-2" >
                <SearchSvg />
              </div>
              <input
                :value="searchValue"
                @input="handleInput"
                maxlength="40"
                class="w-full text-sm placeholder-gray-600 bg-gray-200 rounded-md focus:ring-stone-600 focus:border-stone-600 hover:border-transpent text-cyan-600 ml-9 pr-9"
                type="text"
                placeholder="گەڕان"
              />

            </div>

          </div>



          <ul class="flex items-center flex-shrink-0 space-x-6">
            <!-- Notifications menu -->
            <li class="relative">
              <button
                class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple"
                @click="toggleNotificationsMenu"
                @keydown.escape="closeNotificationsMenu"
                aria-label="Notifications"
                aria-haspopup="true"
              >
                <div class="relative ml-3">
                    <div class="text-sm text-gray-100 cursor-default">{{ user.name }}</div>

                </div>
              </button>
            </li>
          </ul>

        </div>
      </header>

      <main class="overflow-auto">
        <slot />

      </main>

    </div>

  </div>
  <div class="fixed bottom-0 w-full h-5 bg-gray-400 bg-opacity-50 md:pr-[280px]">

    <div class="flex justify-center">
         <div class="flex space-x-10 lg:space-x-96">
            <Dropdown >
                <template #trigger>
                    <div><SettingSvg  width="20px" height="20px" class="text-green-800 cursor-pointer hover:text-green-700" /></div>
                </template>

                <template  #content>
                  <DropdownLink :href="route('profile.edit')" class="my-1 bg-gray-500 rounded hover:bg-gray-600 focus:bg-slate-500">
                    <span class="text-cyan-500">
                      <SettingSvg />
                    </span>
                  </DropdownLink>
                  <DropdownLink :href="route('profile.edit')" class="my-1 bg-gray-500 rounded hover:bg-gray-600 focus:bg-slate-500">
                    <span class="text-emerald-500">
                      <UserSvg  width="30px" height="30px" />
                    </span>
                  </DropdownLink>
                  <DropdownLink :href="route('logout')" method="post" as="button" class="my-1 bg-gray-500 rounded focus:bg-slate-500 hover:bg-gray-600">
                    <span class="justify-start mr-auto text-right text-rose-300 hover:bg-gray-700">
                      <LogoutSvg  />
                    </span>
                  </DropdownLink>
                </template>
              </Dropdown>
            <div>   <button @click="reloadPage" class="text-gray-700 rounded hover:text-gray-600" dir="LTR"  :class="{ 'animate-spin ': isLoading }">
                <svg viewBox="0 0 24 24" width="20px" height="20px" fill="none" xmlns="http://www.w3.org/2000/svg" transform="matrix(-1, 0, 0, 1, 0, 0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3.67981 11.3333H2.92981H3.67981ZM3.67981 13L3.15157 13.5324C3.44398 13.8225 3.91565 13.8225 4.20805 13.5324L3.67981 13ZM5.88787 11.8657C6.18191 11.574 6.18377 11.0991 5.89203 10.8051C5.60029 10.511 5.12542 10.5092 4.83138 10.8009L5.88787 11.8657ZM2.52824 10.8009C2.2342 10.5092 1.75933 10.511 1.46759 10.8051C1.17585 11.0991 1.17772 11.574 1.47176 11.8657L2.52824 10.8009ZM18.6156 7.39279C18.8325 7.74565 19.2944 7.85585 19.6473 7.63892C20.0001 7.42199 20.1103 6.96007 19.8934 6.60721L18.6156 7.39279ZM16.8931 3.60787C16.5403 3.39077 16.0784 3.50074 15.8613 3.8535C15.6442 4.20626 15.7541 4.66822 16.1069 4.88532L16.8931 3.60787ZM12.4633 3.75939C12.877 3.77966 13.2288 3.46071 13.2491 3.047C13.2694 2.63328 12.9504 2.28146 12.5367 2.26119L12.4633 3.75939ZM12.0789 2.25C7.03155 2.25 2.92981 6.3112 2.92981 11.3333H4.42981C4.42981 7.15072 7.84884 3.75 12.0789 3.75V2.25ZM2.92981 11.3333L2.92981 13H4.42981L4.42981 11.3333H2.92981ZM4.20805 13.5324L5.88787 11.8657L4.83138 10.8009L3.15157 12.4676L4.20805 13.5324ZM4.20805 12.4676L2.52824 10.8009L1.47176 11.8657L3.15157 13.5324L4.20805 12.4676ZM19.8934 6.60721C19.1441 5.38846 18.1143 4.35941 16.8931 3.60787L16.1069 4.88532C17.1287 5.51419 17.9899 6.37506 18.6156 7.39279L19.8934 6.60721ZM12.5367 2.26119C12.385 2.25376 12.2323 2.25 12.0789 2.25V3.75C12.2078 3.75 12.336 3.75316 12.4633 3.75939L12.5367 2.26119Z" fill="CurrentColor"></path> <path d="M11.8825 21V21.75V21ZM20.3137 12.6667H21.0637H20.3137ZM20.3137 11L20.8409 10.4666C20.5487 10.1778 20.0786 10.1778 19.7864 10.4666L20.3137 11ZM18.1002 12.1333C17.8056 12.4244 17.8028 12.8993 18.094 13.1939C18.3852 13.4885 18.86 13.4913 19.1546 13.2001L18.1002 12.1333ZM21.4727 13.2001C21.7673 13.4913 22.2421 13.4885 22.5333 13.1939C22.8245 12.8993 22.8217 12.4244 22.5271 12.1332L21.4727 13.2001ZM5.31769 16.6061C5.10016 16.2536 4.63806 16.1442 4.28557 16.3618C3.93307 16.5793 3.82366 17.0414 4.0412 17.3939L5.31769 16.6061ZM11.5331 20.2423C11.1193 20.224 10.769 20.5447 10.7507 20.9585C10.7325 21.3723 11.0531 21.7226 11.4669 21.7408L11.5331 20.2423ZM7.11292 20.4296C7.4677 20.6433 7.92861 20.529 8.14239 20.1742C8.35617 19.8195 8.24186 19.3586 7.88708 19.1448L7.11292 20.4296ZM11.8825 21.75C16.9448 21.75 21.0637 17.6915 21.0637 12.6667H19.5637C19.5637 16.8466 16.133 20.25 11.8825 20.25V21.75ZM21.0637 12.6667V11H19.5637V12.6667H21.0637ZM19.7864 10.4666L18.1002 12.1333L19.1546 13.2001L20.8409 11.5334L19.7864 10.4666ZM19.7864 11.5334L21.4727 13.2001L22.5271 12.1332L20.8409 10.4666L19.7864 11.5334ZM11.4669 21.7408C11.6047 21.7469 11.7433 21.75 11.8825 21.75V20.25C11.7653 20.25 11.6488 20.2474 11.5331 20.2423L11.4669 21.7408ZM4.0412 17.3939C4.80569 18.6327 5.86106 19.6752 7.11292 20.4296L7.88708 19.1448C6.83872 18.5131 5.95602 17.6405 5.31769 16.6061L4.0412 17.3939Z" fill="CurrentColor"></path> </g></svg>
             </button></div>
            <div @click="showAlert" class="cursor-pointer text-rose-800 hover:text-rose-600">! 03</div>
          </div>
    </div>
</div>
</template>
