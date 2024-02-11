<template>
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">
        <a href="/admin" class="logo">
          <img src="../../../../public/assets/images/logo_white.png" alt="">
        </a>
      </h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav flex-column my-admin">
        <li class="nav-item">
          <a class="nav-link" href="/admin">
            <div class="wrapper-link">
              Объекты
            </div>
          </a>
        </li>
        <!--                Выход-->
        <li class="nav-item">
          <a class="nav-link" href="/api/admin/logout">
            <div class="wrapper-link">
              Выход
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>
<script setup lang="ts">
import LogoIcon from "@/components/Icons/LogoIcon.vue";
</script>
<style scoped>
.offcanvas {
  background-color: #2a3f54;
}
</style>
