<script setup>
import {ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link} from '@inertiajs/vue3';
import CalcCartSimple from '@/Components/Calc/CalcCartSimple.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>


    <div>

        <notifications position="top right"/>

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
                                <NavLink
                                    data-bs-toggle="offcanvas"
                                    href="#main-side-admin-menu"
                                    role="button"
                                    aria-controls="main-side-admin-menu"
                                    v-if="can('manage-views-adminmenu')">
                                    Админ.меню
                                </NavLink>

                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Главная
                                </NavLink>
                                <!--                                <NavLink
                                                                    v-if="can('manage-calc')"
                                                                    :href="route('calc')" :active="route().current('calc')">
                                                                    Калькулятор
                                                                </NavLink>-->

                                <NavLink
                                    v-if="cartTotalCount>0"
                                    :href="route('basket')" :active="route().current('basket')">
                                    Корзина <span class="badge bg-danger ml-1 rounded-full">{{ cartTotalCount }}</span>
                                </NavLink>


                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-0">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-0 text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
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
                                        <DropdownLink :href="route('profile.edit')"> Профиль</DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Выход
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
                            Главная страница
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
                            <ResponsiveNavLink :href="route('profile.edit')"> Профиль</ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Выход
                            </ResponsiveNavLink>
                            <hr>
                        </div>

                        <div class="mt-3 space-y-1">

                            <ResponsiveNavLink
                                class="p-3"
                                v-if="can('manage-users')"
                                :href="route('users')" :active="route().current('users')">
                                Пользователи
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                class="p-3"
                                v-if="can('manage-clients')"
                            >
                                <!--                                :href="route('clients')" :active="route().current('clients')"-->
                                Клиенты <i class="fa-solid fa-lock"></i>
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                class="p-3"
                                v-if="can('manage-orders')"
                            >
                                <!--                                :href="route('orders')" :active="route().current('orders')"-->
                                Заказы <i class="fa-solid fa-lock"></i>
                            </ResponsiveNavLink>


                            <ResponsiveNavLink
                                class="p-3"
                                v-if="can('manage-materials')"
                                :href="route('materials')" :active="route().current('materials')">
                                Материалы
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                class="p-3"
                                v-if="can('manage-handles')"
                                :href="route('handles')" :active="route().current('handles')">
                                Ручки
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                class="p-3"
                                v-if="can('manage-hinges')"
                                :href="route('hinges')" :active="route().current('hinges')">
                                Петли
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                class="p-3"
                                v-if="can('manage-door-variants')"
                                :href="route('door-variants')" :active="route().current('door-variants')">
                                Типы дверей
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                class="p-3"
                                v-if="can('manage-colors')"
                                :href="route('colors')" :active="route().current('colors')">
                                Цвета
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                class="p-3"
                                v-if="can('manage-sizes')"
                                :href="route('sizes')" :active="route().current('sizes')">
                                Размеры
                            </ResponsiveNavLink>




                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>


        </div>
    </div>

    <div class="container border-b border-gray-100">
        <footer class="py-3 my-4">

            <div class="d-flex justify-center">
                <img src="/images/logo.jpg" style="width: 100px;" alt="">
            </div>
            <p class="text-center text-muted">© 2024 DoDoors</p>
        </footer>
    </div>

    <div class="cart-fixed-btn" v-if="cartTotalCount>0">
        <a class="btn rounded-0 shadow-lg"
           data-bs-toggle="offcanvas"
           href="#cart" role="button"
           aria-controls="cart">
            <i class="fa-solid fa-basket-shopping text-primary"></i>
            <span class="badge text-primary font-bold">{{ cartTotalCount }} шт.</span>

        </a>
    </div>

    <CalcCartSimple></CalcCartSimple>

    <div class="offcanvas offcanvas-start"
         data-bs-scroll="true" data-bs-backdrop="false"
         tabindex="-1" id="main-side-admin-menu" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                DoDoors
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="offcanvas-body">


            <div class="row">
                <div class="col-md-6">
                    <button class="btn w-100 rounded-0"
                            v-bind:class="{'btn-dark':menuTab === 0, 'btn-outline-secondary':menuTab!==0}"
                            @click="menuTab = 0"><i class="fa-solid fa-user-tie mr-2"></i>Общее
                    </button>
                </div>
                <div class="col-md-6">
                    <button class="btn w-100 rounded-0"
                            v-bind:class="{'btn-dark':menuTab === 1, 'btn-outline-secondary':menuTab!==1}"
                            @click="menuTab = 1"><i class="fa-solid fa-screwdriver-wrench mr-2"></i>Админ
                    </button>
                </div>
            </div>
            <div class="py-5">
                <nav class="d-flex flex-col align-items-center" v-if="menuTab===0">
                    <NavLink
                        class="p-3"
                        v-if="can('manage-calc')"
                        :href="route('calc')" :active="route().current('calc')">
                        Калькулятор
                    </NavLink>
                    <NavLink
                        class="p-3"
                        v-if="can('manage-clients')"
                        :href="route('clients')" :active="route().current('clients')">
                        Клиенты
                    </NavLink>

                    <NavLink
                        class="p-3"
                        v-if="can('manage-clients')"
                        :href="route('documents')" :active="route().current('documents')">
                        Договора (Документы)
                    </NavLink>

                    <NavLink
                        class="p-3"
                        v-if="can('manage-orders')"
                        :href="route('orders')" :active="route().current('orders')">
                        Заказы
                    </NavLink>
                    <NavLink
                        class="p-3"
                        v-if="can('manage-promo-codes')"
                        :href="route('promo-codes')" :active="route().current('promo-codes')">
                        Промокоды
                    </NavLink>
                </nav>
                <nav class="d-flex flex-col align-items-center" v-if="menuTab===1">
                    <NavLink
                        class="p-3"
                        v-if="can('manage-users')"
                        :href="route('users')" :active="route().current('users')">
                        Пользователи
                    </NavLink>

                    <NavLink
                        class="p-3"
                        v-if="can('manage-roles')"
                        :href="route('roles')" :active="route().current('roles')">
                        Роли пользователей
                    </NavLink>

                    <NavLink
                        class="p-3"
                        v-if="can('manage-permissions')"
                        :href="route('permissions')" :active="route().current('permissions')">
                        Разрешения пользователей
                    </NavLink>

                    <NavLink
                        class="p-3"
                        v-if="can('manage-materials')"
                        :href="route('materials')" :active="route().current('materials')">
                        Материалы
                    </NavLink>
                    <NavLink
                        class="p-3"
                        v-if="can('manage-handles')"
                        :href="route('handles')" :active="route().current('handles')">
                        Ручки
                    </NavLink>
                    <NavLink
                        class="p-3"
                        v-if="can('manage-hinges')"
                        :href="route('hinges')" :active="route().current('hinges')">
                        Петли
                    </NavLink>
                    <NavLink
                        class="p-3"
                        v-if="can('manage-door-variants')"
                        :href="route('door-variants')" :active="route().current('door-variants')">
                        Типы дверей
                    </NavLink>

                    <NavLink
                        class="p-3"
                        v-if="can('manage-colors')"
                        :href="route('colors')" :active="route().current('colors')">
                        Цвета
                    </NavLink>
                    <NavLink
                        class="p-3"
                        v-if="can('manage-sizes')"
                        :href="route('sizes')" :active="route().current('sizes')">
                        Размеры
                    </NavLink>
                </nav>

            </div>

        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    data() {
        return {
            menuTab: 0
        }
    },
    computed: {
        ...mapGetters(['getErrors', 'cartTotalCount', 'cartProducts']),

    },
    mounted() {

    },
    methods: {
        hasRoles(role) {
            return (this.$page.props.auth.roles || []).includes(role)
        },
        can(permission) {

            return (this.$page.props.auth.permissions || []).includes(permission)
        }
    }
}
</script>
<style lang="scss">
.cart-fixed-btn {
    position: fixed;
    bottom: 111px;
    right: 13px;
    padding: 10px;
    z-index: 10;
    box-sizing: border-box;

    @media (max-width: 767.98px) {
        bottom: 10px;
        right: 0px;
        width: 100%;
        .btn {
            width: 100%;
        }
    }

    .btn {
        background-color: white;
    }
}

.btn-dark {
    background-color: black;
}
</style>
