<script setup>
import RoleTable from "@/Components/Admin/Roles/RoleTable.vue";
import PermissionTable from "@/Components/Admin/Permissions/PermissionTable.vue";
</script>
<template>

    <form action="" v-on:submit.prevent="submit">
        <div class="form-floating mb-3">
            <input type="text"
                   v-model="form.name"
                   class="form-control" id="user-name"
                   required>
            <label for="user-title">Имя пользователя</label>
        </div>

        <div class="form-floating mb-3">
            <input type="email"
                   v-model="form.email"
                   class="form-control" id="user-email"
                   required>
            <label for="user-email">Почта пользователя</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password"
                   v-model="form.password"
                   class="form-control" id="user-password">
            <label for="user-password">Пароль</label>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="input-group ">

                    <div class="form-floating " @click="openRoleSearchModal">
                        <p class="form-control rounded-0 border-secondary" v-if="form.roles.length>0">{{ form.roles[0].name }}</p>
                        <p class="form-control rounded-0 border-secondary" v-else>Не выбрана</p>
                        <label for="client-user_id">Роль</label>
                    </div>

                    <button
                        type="button"
                        class="btn btn-outline-secondary rounded-0"
                        @click="form.roles = []"
                        v-if="form.roles.length>0"><i class="fa-solid fa-ban"></i></button>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 mb-3">
                <button
                    type="button"
                    @click="openPermissionsSearchModal"
                    class="btn btn-dark rounded-0">
                    <i class="fa-solid fa-plus mr-1"></i> Добавить разрешение
                </button>
            </div>
            <div class="col-md-4 col-12 mb-3" v-for="(item, index) in form.permissions">
                <div class="input-group ">
                    <div class="form-floating ">
                        <p class="form-control rounded-0 border-secondary" v-if="form.permissions[index]">
                            {{ form.permissions[index].name }}</p>
                        <p class="form-control rounded-0 border-secondary" v-else>Не выбрана</p>
                        <label for="client-user_id">Разрешение</label>
                    </div>

                    <button
                        type="button"
                        class="btn btn-outline-secondary rounded-0"
                        @click="removePermission(index)"
                        v-if="form.permissions[index]"><i class="fa-solid fa-ban"></i></button>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-12">
                <div
                    v-if="messages.length>0"
                    v-for="(message, index) in messages"
                    class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Внимание!</strong> {{ message || 'Ошибка' }}
                    <button type="button" class="btn-close"
                            @click="removeMessage(index)"></button>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                <button
                    :disabled="!needClearForm"
                    class="btn btn-dark rounded-0">
                    <i class="fa-regular fa-floppy-disk mr-1" v-if="!loading"></i>
                    <span class="spinner-border spinner-border-sm  text-success"
                          role="status" v-else></span>
                    Сохранить пользователя
                </button>
                <button
                    v-if="needClearForm&&!loading"
                    type="button"
                    @click="resetForm"
                    class="btn btn-outline-secondary rounded-0 ml-2">
                    <i class="fa-solid fa-xmark mr-1"></i>
                    Очистить форму
                </button>

            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade " id="search-roles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content rounded-0 border-secondary">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Поиск роли</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body 0">
                    <RoleTable
                        :for-select="true"
                        v-on:select="selectRole"></RoleTable>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-0 border-secondary"
                            data-bs-dismiss="modal">Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="search-permissions" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content rounded-0 border-secondary">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Поиск разрешения</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body 0">
                    <PermissionTable
                        :for-select="true"
                        :selected="preparedPermissions"
                        v-on:select="selectPermissions"></PermissionTable>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-0 border-secondary"
                            data-bs-dismiss="modal">Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["item"],
    data() {
        return {
            roleSearchModal: null,
            permissionSearchModal: null,
            messages: [],
            loading: false,

            form: {
                id: null,
                email: null,
                name: null,
                password: null,
                roles: [],
                permissions: [],

            }
        }
    },
    computed: {
        preparedPermissions() {
            return this.form.permissions.map(o => o["id"]);
        },
        needClearForm() {
            return this.form.id ||
                this.form.email ||
                this.form.name ||
                this.form.password ||
                this.form.roles.length>0 ||
                this.form.permissions.length > 0


        }
    },
    mounted() {
        this.roleSearchModal = new bootstrap.Modal(document.getElementById('search-roles'), {})
        this.permissionSearchModal = new bootstrap.Modal(document.getElementById('search-permissions'), {})

        if (this.item)
            this.$nextTick(() => {
                this.form = {
                    id: this.item.id || null,
                    email: this.item.email || null,
                    name: this.item.name || null,
                    roles: this.item.roles || [],
                    permissions: this.item.permissions || [],

                }
            })
    },
    methods: {
        openRoleSearchModal() {
            this.roleSearchModal.show()
        },
        openPermissionsSearchModal() {
            this.permissionSearchModal.show()
        },
        alert(msg) {
            this.messages.push(msg)
        },
        selectRole(item) {
            this.form.roles = []
            this.form.roles.push(item)
            this.roleSearchModal.hide()
        },
        removePermission(index){
            this.form.permissions.splice(index, 1)
            this.$notify({
                title: "DoDoors",
                text: "Разрешение успешно удалено",
                type: "success"
            });
        },
        selectPermissions(item) {
            let index = this.form.permissions.findIndex(p => p.id === item.id)
            if (index === -1) {
                this.form.permissions.push(item)

                this.$notify({
                    title: "DoDoors",
                    text: "Разрешение успешно добавлено",
                    type: "success"
                });
            } else {
                this.form.permissions.splice(index, 1)
                this.$notify({
                    title: "DoDoors",
                    text: "Разрешение успешно удалено",
                    type: "success"
                });
            }


        },
        resetForm() {

            this.form.id = null
            this.form.name = null
            this.form.email = null
            this.form.password = null
            this.form.roles =[]
            this.form.permissions = []

            this.$emit("callback")

        },

        removeMessage(index) {
            this.messages.splice(index, 1)
        },
        submit() {
            let data = new FormData();
            Object.keys(this.form)
                .forEach(key => {
                    const item = this.form[key] || ''
                    if (typeof item === 'object')
                        data.append(key, JSON.stringify(item))
                    else
                        data.append(key, item)
                });


            this.$store.dispatch("storeUser", {
                userForm: data
            }).then((response) => {
                this.$emit("callback")
                this.resetForm()
            }).catch(error => {

            })


        }
    }
}
</script>
<style lang="scss">
.uploaded-image-mini {
    width: 100%;
    object-fit: contain;
    max-height: 200px;
}

.image-preview {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;


    & > .shadow {
        display: none;
        position: absolute;
        z-index: 1;
        background-color: rgba(0, 0, 0, 0.5);
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        a {
            color: white;
        }
    }

    &:hover {
        .shadow {
            display: flex;
        }
    }
}
</style>
