<template>
     <Head title="لیستی بەکارهێنەرەکان" />

    <Modal
    :show="showConfirmDeleteUserModal"
    @close="closeModal"
>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە سڕینەوەی بەکار‌هێنەری ( {{ userToDelete ? userToDelete.name : '' }} ) ؟
        </h2>
        <div class="flex justify-end mt-6">

            <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>

            <DangerButton  class="mx-3 ml-3" @click="deleteUser(userIdToDelete.value)">سڕینەوە</DangerButton>

        </div>
    </div>
</Modal>
  <AuthenticatedLayout :searchValue="search" @updateSearchValue="handleSearchUpdate">
    <main class="h-full overflow-y-auto py-7">
      <div class="container grid px-6 mx-auto">
        <div class="flex items-center pb-7">

            <Link
            v-if="hasPermission('create_user')"
            :href="route('users.create')"
            class="inline-block p-2 rounded-r text-emerald-500 bg-zinc-600"
          >

           <CreateSvg/>
          </Link>

            <div class="justify-end p-4 text-left rounded-l text-cyan-400 bg-zinc-700">
                  لیستی بەکارهێنەرەکان
            </div>


        </div>
        <div class="w-full overflow-hidden rounded-[5px] shadow-xs">
          <div class="w-full overflow-x-auto">
            <Table>
              <TableHead>
                <TableRowHead>
                  <TableDataHead class="w-32">#</TableDataHead>
                  <TableDataHead class="w-64">ناو</TableDataHead>
                  <TableDataHead class="w-32">کۆی بابەت</TableDataHead>
                  <TableDataHead  v-if="hasPermission('delete_user')" class="w-10"></TableDataHead>
                  <TableDataHead  v-if="hasPermission('edit_user')" class="w-10"></TableDataHead>
                </TableRowHead>
              </TableHead>
              <TableBody>
                <TableRow v-for="(user, index) in users.data" :key="user.id">
                  <TableData class="w-32">{{ index + 1 }}</TableData>
                  <TableData class="w-64">{{ user.name }}</TableData>
                  <TableData class="w-32">0</TableData>
                  <TableData  v-if="hasPermission('delete_user')" class="w-10 whitespace-nowrap" ><button   @click="confirmDeleteUser(user.id)" class=" text-rose-300"><DeleteSvg/></button>
                </TableData>
                    <TableData  v-if="hasPermission('edit_user')" class="w-10 whitespace-nowrap" >
                        <Link   :href="route('users.edit' , user.id)" class="inline-flex text-emerald-400"><EditSvg/></Link></TableData>
                </TableRow>
              </TableBody>
            </Table>
          </div>
          <div
            class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
          >
            <div class="flex justify-start mt-1.5 pb-1.5">
              <Pagination :links="users.links" :meta="users.meta" />
            </div>


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
import TableData from "@/Components/TableData.vue";
import TableHead from "@/Components/TableHead.vue";
import TableDataHead from "@/Components/TableDataHead.vue";
import TableRow from "@/Components/TableRow.vue";
import CreateSvg from "@/Components/Svg/Create.vue";
import DeleteSvg from "@/Components/Svg/Delete.vue";
import EditSvg from "@/Components/Svg/Edit.vue";
import TableRowHead from "@/Components/TableRowHead.vue";
import { router } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { debounce } from 'lodash';
import { usePermission } from "@/Composables/permissions";
const { hasPermission } = usePermission();


const props = defineProps({
  users: Object,
});

const search = ref(props.users.search);

const handleSearchUpdate = (value) => {
  search.value = value;
};

watch(search, debounce((value) => {
  router.get(
    route("users.index"),
    { search: value,  },
    {
      preserveState: true,
      replace: true,
    }
  );
}, 100));







const deleteUser = (id) => {
    router.delete(route('users.destroy', { user: userIdToDelete.value }), {
    onSuccess: () => closeModal(),
    preserveState: true,
  });
};


//this is for false to true
const showConfirmDeleteUserModal = ref(false);

//this is for add id user you want
const userIdToDelete = ref(null);


//thi is open by id
const confirmDeleteUser = (id) => {
    userIdToDelete.value = id;
    showConfirmDeleteUserModal.value = true;
};

// this is for close
const closeModal = () => {
    showConfirmDeleteUserModal.value = false;
};

//find data by id
const userToDelete = computed(() => {
    return props.users.data.find(user => user.id == userIdToDelete.value);
});
</script>
