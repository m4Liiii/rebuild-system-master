<template>
    <Head title="لیستی ڕۆڵەکان" />

    <Modal
    :show="showConfirmDeleteRoleModal"
    @close="closeModal"
>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-200">
               ئایا تۆ دڵنیای لە سڕینەوەی ڕۆڵی ( {{ roleToDelete ? roleToDelete.name : '' }} ) ؟
        </h2>
        <div class="flex justify-end mt-6">

            <SecondaryButton @click="closeModal"> لابردن </SecondaryButton>

            <DangerButton  class="mx-3 ml-3" @click="deleteRole(roleIdToDelete.value)">سڕینەوە</DangerButton>

        </div>
    </div>
</Modal>
  <AuthenticatedLayout :searchValue="search" @updateSearchValue="handleSearchUpdate">
    <main class="h-full overflow-y-auto py-7">
      <div class="container grid px-6 mx-auto">
        <div class="flex items-center pb-7">

            <Link
            v-if="hasPermission('create_role')"
            :href="route('roles.create')"
            class="inline-block p-2 rounded-r text-emerald-500 bg-zinc-600"
          >

           <CreateSvg/>
          </Link>

            <div class="justify-end p-4 text-left rounded-l text-cyan-400 bg-zinc-700">
                  لیستی ڕۆڵەکان
            </div>


        </div>
        <div class="w-full overflow-hidden rounded-[5px] shadow-xs">
          <div class="w-full overflow-x-auto">
            <Table>
              <TableHead>
                <TableRowHead>
                  <TableDataHead class="w-32">#</TableDataHead>
                  <TableDataHead class="w-64">ناوی ڕۆڵ</TableDataHead>
                  <TableDataHead  v-if="hasPermission('delete_role')" class="w-10"></TableDataHead>
                  <TableDataHead  v-if="hasPermission('edit_role')" class="w-10"></TableDataHead>
                </TableRowHead>
              </TableHead>
              <TableBody>
                <TableRow v-for="(role, index) in roles.data" :key="role.id">
                  <TableData class="w-32">{{ index + 1 }}</TableData>
                  <TableData class="w-64">{{ role.name }}</TableData>
                  <TableData  v-if="hasPermission('delete_role')" class="w-10 whitespace-nowrap" ><button  @click="confirmDeleteRole(role.id)" class=" text-rose-300"><DeleteSvg/></button>
             </TableData>
                    <TableData  v-if="hasPermission('edit_role')" class="w-10 whitespace-nowrap" >
                        <Link  :href="route('roles.edit' , role.id)" class="inline-flex text-emerald-400"><EditSvg/></Link></TableData>
                </TableRow>
              </TableBody>
            </Table>
          </div>
          <div
            class="lg:flex px-6 py-1.5 text-xs text-gray-400 bg-zinc-700 border-t border-gray-700"
          >
            <div class="flex justify-start mt-1.5 pb-1.5">
              <Pagination :links="roles.links" :meta="roles.meta" />
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
import { ref, watch,  computed  } from "vue";

import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/Table.vue";
import TableBody from "@/Components/TableBody.vue";
import TableData from "@/Components/TableData.vue";
import TableHead from "@/Components/TableHead.vue";
import TableRow from "@/Components/TableRow.vue";
import CreateSvg from "@/Components/Svg/Create.vue";
import TableDataHead from "@/Components/TableDataHead.vue"
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
  roles: Object,
});

const search = ref(props.roles.search);

const handleSearchUpdate = (value) => {
  search.value = value;
};

watch(search, debounce((value) => {
  router.get(
    route("roles.index"),
    { search: value,  },
    {
      preserveState: true,
      replace: true,
    }
  );
}, 100));




const deleteRole = (id) => {
    router.delete(route('roles.destroy', { role: roleIdToDelete.value }), {
    onSuccess: () => closeModal(),
    preserveState: true,
  });
};
const showConfirmDeleteRoleModal = ref(false);

//this is for add id role you want
const roleIdToDelete = ref(null);

const confirmDeleteRole = (id) => {
    roleIdToDelete.value = id;
    showConfirmDeleteRoleModal.value = true;
};

// this is for close
const closeModal = () => {
    showConfirmDeleteRoleModal.value = false;
};



//find data by id
const roleToDelete = computed(() => {
    return props.roles.data.find(role => role.id == roleIdToDelete.value);
});
</script>
