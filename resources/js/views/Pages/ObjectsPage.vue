<template>
  <admin-panel>
    <flash-message type="success" class="mb-2"></flash-message>
    <h1 class="bd-title">Объекты</h1>
    <template v-if="!loading">
      <div class="row">
        <div class="col-6 col-lg-2">
          <router-link class="btn btn-primary btn-sm w-100 fw-bolder" :to="{name: 'ObjectsUploadForm'}" title="Импорт">
            <i class="fas fa-plus me-1"></i>
            Импорт
          </router-link>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12">
          <div class="parts-wrapper">
            <table class="table table-parts table-sm table-bordered table-hover">
              <thead class="table-light">
              <tr>
                <th scope="col">Код</th>
                <th scope="col">Наименование</th>
                <th scope="col">Раздел</th>
                <th scope="col">Цена</th>
                <th scope="col">ЦенаСП</th>
                <th scope="col">Количество</th>
                <th scope="col">Единица измерения</th>
                <th scope="col">Действия</th>
              </tr>
              </thead>
              <tbody class="parts table-group-divider">
              <template v-if="data.data.length > 0">
                <tr v-for="(object,index) in data.data" :key="index">
                  <td>{{ object.code }}</td>
                  <td>{{ object.name }}</td>
                  <td>{{ object.groups_name }}</td>
                  <td>{{ object.price }}</td>
                  <td>{{ object.price_cp }}</td>
                  <td>{{ object.count }}</td>
                  <td>{{ object.unit }}</td>
                  <td class="text-center">
                    <a href="#" title="Удалить" @click.prevent="removeItemModal(object.id)">
                      <delete-icon class="move-icon"></delete-icon>
                    </a>
                  </td>
                </tr>
              </template>
              <template v-else>
                <tr>
                  <td colspan="7" class="text-center">
                    Объекты не найдены
                  </td>
                </tr>
              </template>
              </tbody>
            </table>
            <pagination-component :paginated="data" :current-page="page" @updateList="getData"></pagination-component>
          </div>
        </div>
      </div>
    </template>
    <loading-component v-else></loading-component>
  </admin-panel>
</template>

<script lang="ts" setup>
import AdminPanel from "@/views/Layouts/AdminPanel.vue";
import {onMounted, ref} from "vue"
import {useBreadcrumbs} from '@/composables/useBreadcrumbs'
import {useModal} from "@/composables/useModal"
import {config} from "@/config";
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import FlashMessage from "@/components/System/FlashMessage.vue";
import DeleteIcon from "@/components/Icons/DeleteIcon.vue";
import SuccessModal from '@/components/Modals/SuccessModal.vue'
import axios from "axios"
import PaginationComponent from "@/components/System/PaginationComponent.vue";

const {init} = useBreadcrumbs()
const bread = [{
  'name': 'Объекты',
  'link': '/admin',
  'active': false
}]
const loading = ref(true)
const modal = useModal()
const data = ref([])
const errors = ref(null)
const page = ref(1)

init(bread, false)

onMounted(() => {
  getData()
})

//Functions
async function getData(page = 1) {
  loading.value = true
  await axios.post(config.api_url + 'objects/list', {
    page: page,
  })
    .then((response) => {
      data.value = response.data;
    })
    .catch((error) => {
      if (error) {
        errors.value = error.response;
      }
    })
    .finally(() => {
      loading.value = false;
    });
}

function removeItemModal(id: number) {
  modal.open({
    component: SuccessModal,
    modelValue: {
      title: 'Вы действительно хотите удалить данный объект?',
      subTitle: 'Вы уверены?',
      function: async () => {
        await removeItem(id)
      },
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

async function removeItem(id: number) {
  await axios.get(config.api_url + 'objects/remove/' + id)
    .then(() => {
      getData();
    })
    .catch((error) => {
      if (error) {
        errors.value = error.response;
      }
    });
}

</script>
