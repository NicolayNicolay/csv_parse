<template>
  <div class="admin-wrapper">
    <div class="container-fluid p-0">
      <div class="bd-body">
        <div class="bd-sidebar slideout-menu slideout-menu-left" id="bd_sidebar">
          <div class="bd-logo">
            <a href="/admin" class="logo">
              <img src="/assets/images/logo_white.png" alt="" class="w-100">
            </a>
          </div>
          <div class="bd-login">
            <div class="dropdown">
              <div class="d-flex">
                <user-icon class="user-icon"/>
                <div class="role mt-2 small ms-2" v-if="user"> {{ user.name }}</div>
              </div>
            </div>
          </div>
          <div class="scrollbar-outer">
            <div class="bd-menu">
              <ul class="nav flex-column my-admin">
                <li class="nav-item">
                  <router-link class="nav-link" :to="{name: 'ObjectsPage'}">
                    <div class="wrapper-link">
                      <span class="icon text-primary">
                        <projects-icon/>
                    </span>
                      Объекты
                    </div>
                  </router-link>
                </li>
                <!--                Выход-->
                <li class="nav-item">
                  <a class="nav-link" href="/admin/logout">
                    <div class="wrapper-link">
                    <span class="icon text-primary">
                      <exit-icon/>
                    </span>
                      Выход
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <main class="bd-content" id="bd_content">
          <div class="bd-head-mobile">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12 text-center">
                  <div class="brand">
                    <div class="logo">
                      <a href="/admin" class="logo">
                        <img src="/assets/images/logo_white.png" alt="" class="icon">
                      </a>
                    </div>
                    <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                      <mobile-icon/>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="content-wrapper">
            <breadcrumb-component/>
            <slot></slot>
          </div>
        </main>
      </div>
    </div>
  </div>
  <mobile-menu/>
  <modal-component />
</template>

<script lang="ts" setup>
import {authStore} from "@/stores/authStore";
import {ref} from "vue"
import ProjectsIcon from "@/components/Icons/ProjectsIcon.vue";
import ExitIcon from "@/components/Icons/ExitIcon.vue";
import LogoIcon from "@/components/Icons/LogoIcon.vue";
import MobileMenu from "@/components/Mobile/MobileMenu.vue";
import MobileIcon from "@/components/Icons/MobileIcon.vue";
import BreadcrumbComponent from "@/components/System/BreadcrumbComponent.vue";
import UserIcon from "@/components/Icons/UserIcon.vue";
import ModalComponent from "@/components/Modals/ModalComponent.vue";

const user = ref(authStore().userData)
</script>

