<template>
  <Head title="گۆڕینی ڕۆڵ" />
    <AuthenticatedLayout>

      <div class="flex items-center p-4 py-7">
          <Link
          :href="route('roles.index')"
          class="inline-block p-2 rounded-r text-rose-300 bg-zinc-600"
        >
         <BackSvg/>
        </Link>
          <div class="justify-end p-4 text-left rounded-l text-emerald-400 bg-zinc-700">
              فۆڕمی گۆڕینی ڕۆڵ
          </div>


      </div>


      <form @submit.prevent="submit">
        <div class="p-4 mx-4 rounded-lg shadow-md bg-zinc-700">
          <div class="flex flex-wrap justify-center flex-initial m-2 m">

            <div class="my-3 lg:w-2/5">
              <InputLabel for="name1" value="ناو" class="relative" />
              <TextInput
                id="name1"

                type="text"
                v-model="form.name"

                class="w-full mt-1"
                placeholder="ناوی بەکارهێنەر بنوسە"

              />
              <InputError class="mt-2"   :message="form.errors.name ? '  هەڵە هەیە لە ناوی بەکارهێنەر' : ''" />
            </div>
          </div>

          <div class="flex justify-center py-5 ml-4">
            <SecondaryButton @click="resetForm" class="mx-2">بەتاڵ کردنەوە</SecondaryButton>
            <PrimaryButton :disabled="form.processing" class="mx-2">زەخیرەکردن</PrimaryButton>
          </div>
        </div>
      </form>
      <div class="p-4">
        <div class="w-full overflow-hidden rounded-[5px] shadow-xs">
        <Table >
          <TableHead>
            <TableRowHead>
              <TableDataHead>#</TableDataHead>
              <TableDataHead> مۆڵەت</TableDataHead>
              <TableDataHead></TableDataHead>
            </TableRowHead>
          </TableHead>
          <TableBody>
            <TableRow v-for="permission in permissions" :key="permission.id">
                <TableData>{{ permission.id }}</TableData>
                <TableData>{{ permission.name }}</TableData>
                <TableData>
                  <input type="checkbox" class="w-5 h-5 border border-gray-300 rounded text-emerald-500 focus:ring-emerald-400 focus:ring-opacity-25" v-model="selectedPermissions" :value="permission.id">
                </TableData>
            </TableRow>

          </TableBody>
        </Table>
      </div>
  </div>

    </AuthenticatedLayout>
  </template>
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import InputError from "@/Components/InputError.vue";
  import InputLabel from "@/Components/InputLabel.vue";
  import PrimaryButton from "@/Components/PrimaryButton.vue";
  import SecondaryButton from "@/Components/SecondaryButton.vue";
  import TextInput from "@/Components/TextInput.vue";
  import BackSvg from "@/Components/Svg/Back.vue";
  import Table from "@/Components/Table.vue";
  import TableDataHead from "@/Components/TableDataHead.vue";
  import TableBody from "@/Components/TableBody.vue";
  import TableData from "@/Components/TableData.vue";
  import TableHead from "@/Components/TableHead.vue";
  import TableRow from "@/Components/TableRow.vue";
  import TableRowHead from "@/Components/TableRowHead.vue";
  import { Head, Link, useForm, usePage , router } from "@inertiajs/vue3";
  import { ref , watch } from 'vue'

  //props
    const role = usePage().props.role;
    const permissions = usePage().props.permissions;



    const selectedPermissions = ref(role.permissions.map(permission => permission.id));



    //form
    const form = useForm({
    name: role.name,
    permission: [],
  });

  watch(selectedPermissions, (newVal) => {
    console.log(newVal);
});



  const submit = () => {
    form.permission = selectedPermissions.value;

    form.put(route('roles.update', role.id), {
        preserveScroll: true,
        onError: (errors) => {
            form.errors = errors;
        },
    });
};

  function resetForm() {
      form.name = "";
  }

  </script>
