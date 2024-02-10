<template>
  <admin-panel>
    <div class="row">
      <div class="col-lg-4">
        <flash-message type="success" class="mb-2"></flash-message>
        <loading-component v-if="loading"></loading-component>
        <div class="card" v-else>
          <div class="card-body">
            <display-errors v-if="errors" :errors="errors"></display-errors>
            <form @submit.prevent="submitForm">
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3 d-flex flex-column">
                    <h4>Файл</h4>
                    <label class="input-file mt-3" v-if="!form.file">
                      <input
                        type="file"
                        @change="onFileChanged($event)"
                        accept=".csv"
                      />
                      <span>Выберите файл</span>
                    </label>
                    <div class="d-flex justify-content-between align-items-center" v-else>
                      <div>{{ form.file.name }}</div>
                      <delete-icon @click.prevent="deleteFile" class="icon cursor-p"/>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="mt-2">
                    <div class="alert alert-info">
                      <div>
                        Требования к структуре файла
                        <ul>
                          <li>Формат файла *.csv</li>
                        </ul>
                      </div>
                      <a href="/files/sample.xlsx" target="_blank">Скачать образец файла загрузки</a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mt-3">
                  <div class="row">
                    <div class="col-6">
                      <button type="submit" class="btn btn-primary btn-sm w-100" :disabled="!accessSubmit">Сохранить</button>
                    </div>
                    <div class="col-6">
                      <a class="btn btn-light btn-sm w-100" href="/admin">Назад</a>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </admin-panel>
</template>

<script lang="ts" setup>
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import DisplayErrors from "@/components/System/DisplayErrors.vue";
import FileUpload from 'vue-upload-component'
import AdminPanel from "@/views/Layouts/AdminPanel.vue";
import FlashMessage from "@/components/System/FlashMessage.vue";
import {flashMessages} from "@/stores/flashMessagesStore";
import {onMounted, ref, computed} from "vue"
import {useRoute, useRouter} from 'vue-router';
import {config} from "@/config";
import axios from "axios"
import DeleteIcon from "@/components/Icons/DeleteIcon.vue";

const loading = ref(false)
const file = ref<File | null>()
const form = ref({
  file: ref<[] | null>()
})
const errors: any = ref(null)
const token = ref('')
const route = useRoute();
const router = useRouter();

onMounted(() => {
  if (document) {
    let documentToken = document.head.querySelector('meta[name="csrf-token"]');
    if (documentToken) {
      token.value = documentToken.content
    }
  }
})

const accessSubmit = computed(() => {
  return form.value.file;
});

function onFileChanged($event: Event) {
  const target = $event.target as HTMLInputElement;
  if (target && target.files) {
    file.value = target.files[0];
    if (file.value) {
      saveTmpFile();
    }
  }
}

function deleteFile() {
  form.value.file = null;
}

async function saveTmpFile() {
  loading.value = true;
  let formData: any = new FormData();
  formData.append('file', file.value);
  await axios.post(config.api_url + 'files/uploadFiles',
    formData,
    {
      headers: {
        'Content-Type': 'multipart/form-data',
        'X-CSRF-TOKEN': token.value
      }
    }
  )
    .then((response) => {
      form.value.file = response.data;
      errors.value = null;
    })
    .catch((error) => {
      errors.value = error.response.data.errors;
    }).finally(() => {
      loading.value = false;
    });
}

function submitForm() {
  loading.value = true;
  const messages = flashMessages();
  axios.post(config.api_url + 'objects/store', form.value)
    .then((response) => {
      errors.value = null;
      if (response.data.status) {
        messages.addMessage('Выгрузка прошла успешно', 'success');
        router.push({name: 'ObjectsPage'})
      } else {
        errors.value = ['Что-то пошло не так..'];
      }
    })
    .catch((error) => {
      errors.value = error.response.data.errors;
    }).finally(() => {
    loading.value = false;
  });
}

function getFileName(file: any, field: string = 'path') {
  let str;
  if (field === 'path') {
    str = file['path'].split('/').pop();
  } else {
    str = file['name'];
  }
  return str.slice(0, str.indexOf(str.split('.').pop()) - 1);
}
</script>

<style scoped>
.cursor-p{
  cursor: pointer;
}
.input-file {
  position: relative;
  display: inline-block;
}

.input-file span {
  position: relative;
  display: inline-block;
  cursor: pointer;
  outline: none;
  text-decoration: none;
  font-size: 14px;
  vertical-align: middle;
  color: rgb(255 255 255);
  text-align: center;
  border-radius: 4px;
  background-color: #007aff;
  padding: 10px 20px;
  box-sizing: border-box;
  border: none;
  margin: 0;
  transition: background-color 0.2s;
}

.input-file input[type=file] {
  position: absolute;
  z-index: -1;
  opacity: 0;
  display: block;
  width: 0;
  height: 0;
}

/* Focus */
.input-file input[type=file]:focus + span {
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
}

/* Hover/active */
.input-file:hover span {
  background-color: #387dc9;
}

.input-file:active span {
  background-color: #007aff;
}

/* Disabled */
.input-file input[type=file]:disabled + span {
  background-color: #eee;
}
</style>
