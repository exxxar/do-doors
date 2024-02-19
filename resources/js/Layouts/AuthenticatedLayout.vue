<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Главная
                                </NavLink>
                                <NavLink :href="route('calc')" :active="route().current('calc')">
                                    Калькулятор
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
    <div class="cart-fixed-btn">
        <a class="btn btn-outline-primary rounded-5 shadow-lg"
                data-bs-toggle="offcanvas"
                href="#cart" role="button"
           aria-controls="cart">
            <i class="fa-solid fa-basket-shopping text-primary"></i>
            <span class="badge text-primary font-bold">3</span>
        </a>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="cart" aria-labelledby="cart">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title font-bold">Вы выбрали</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="/images/logo.jpg" alt="" class="w-100 object-fit-cover" >
                        </div>
                        <div class="col-md-8">Комплект 2200х800х57 (черный) лицо зеркало /зеркало петли L стандарт 5 шт (черный), НА СЕБЯ , отв. под ручку</div>
                    </div>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="/images/logo.jpg" alt="" class="w-100 object-fit-cover" >
                        </div>
                        <div class="col-md-8">Комплект 2200х800х57 (черный) лицо зеркало /зеркало петли L стандарт 5 шт (черный), НА СЕБЯ , отв. под ручку</div>
                    </div>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="/images/logo.jpg" alt="" class="w-100 object-fit-cover" >
                        </div>
                        <div class="col-md-8">Комплект 2200х800х57 (черный) лицо зеркало /зеркало петли L стандарт 5 шт (черный), НА СЕБЯ , отв. под ручку</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer p-3">
           <div class="card">
               <div class="card-body">
                    <h6 class="font-bold">Итого цена 78000 ₽</h6>
                   <p class="mb-2"><small>Возможно в рассрочку!</small></p>
                   <p class="mb-2" style="line-height: 80%;"><small>От цвета шпона или цвета покраски стекла цена не зависит, просто уточните эти детали в бесседе с менеджером</small></p>
                    <button class="btn btn-outline-primary rounded-5 w-100 mb-2">Обсудить заказ с менеджером</button>
                    <button class="btn btn-outline-primary rounded-5 w-100 mb-2">Получить цену на почту</button>
                    <button class="btn btn-outline-primary rounded-5 w-100 mb-2">Получить цену в Telegram</button>
               </div>
           </div>
        </div>
    </div>
</template>
<style lang="scss">
.cart-fixed-btn {
    position: fixed;
    bottom: 50px;
    right: 20px;
    padding: 10px;
    z-index: 10;
    .btn {
        background-color: white;
    }
}
</style>
