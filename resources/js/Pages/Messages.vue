<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notificaciones enviadas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="
                    bg-white
                    overflow-hidden
                    shadow-xl
                    rounded-lg
                    p-6
                    border-b
                    border-gray-200
                    flex
                    flex-col
                    text-xl
                ">
                    <div class="mx-auto text-right">
                        <h2 class="text-center font-bold text-2xl">Notificaciones enviadas</h2>
                            <!-- <jet-button
                                class="
                                    p-3
                                    border-2
                                    border-blue-100
                                    text-blue-500
                                    bg-blue-100
                                    hover:bg-blue-200
                                    font-bold
                                    rounded-xl"
                                @click="acting =  true;
                                        method = 'post';
                                        action = route('slas.store')
                                        form.reset('zendesk_group_id');
                                        form.reset('zendesk_tickettype_id');
                                        form.reset('zendesk_priority_id');
                                        form.reset('sla_hours');
                                        disable_selects = false;
                                "
                            >
                                Nuevo +
                            </jet-button>
                            <jet-modal :show="acting" :closeable="true" @close="acting = null">
                                <div class="bg-gray-50 shadow-2xl p-4">
                                    <h3 class="text-center text-lg font-bold ">Datos del SLA</h3>
                                    <form
                                        class="flex flex-col items-center p-6"
                                        @submit.prevent="submit"
                                    >

                                    <select 
                                        class="w-96 border border-gray-600 rounded"
                                        v-model="form.zendesk_group_id"
                                        :disabled="disable_selects"
                                    >
                                        <option value="">Seleccionar grupo</option>
                                        <option v-for="(group,index) in groups" :value="group.id" :key="index">
                                            {{ group.name }}
                                        </option>
                                    </select>
                                    <jet-input-error :message="form.errors.zendesk_group_id" />

                                    <select 
                                        class="w-96 border border-gray-600 rounded mt-5"
                                        v-model="form.zendesk_tickettype_id"
                                        :disabled="disable_selects"
                                    >
                                        <option value="">Seleccionar Tipo de Ticket</option>
                                        <option v-for="(tickettype,index) in tickettypes" :value="tickettype.id" :key="index">
                                            {{ tickettype.name }}
                                        </option>
                                    </select>
                                    <jet-input-error :message="form.errors.zendesk_tickettype_id" />

                                    <select 
                                        class="w-96 border border-gray-600 rounded mt-5"
                                        v-model="form.zendesk_priority_id"
                                        :disabled="disable_selects"
                                    >
                                        <option value="">Seleccionar Prioridad</option>
                                        <option v-for="(priority,index) in priorities" :value="priority.id" :key="index">
                                            {{ priority.name }}
                                        </option>
                                    </select>
                                    <jet-input-error :message="form.errors.zendesk_priority_id" />

                                    <jet-input
                                        class="px-5 py-3 mt-5 w-96 border border-gray-600 rounded"
                                        type="number"
                                        step="0.25"
                                        name="name"
                                        placeholder="Horas"
                                        v-model="form.sla_hours"
                                    ></jet-input>
                                    <jet-input-error :message="form.errors.sla_hours" />

                                    <jet-button
                                        class="px-5 py-3 mt-5 w-96 bg-purple-400 justify-center rounded-xl text-sm"
                                        :disabled="form.processing"
                                    >
                                        <span class="animate-spin mr-1" v-show="form.processing">
                                            &#9696;
                                        </span>
                                        <span  v-show="!form.processing">
                                            Guardar
                                        </span>
                                        
                                    </jet-button>

                                    </form>
                                </div>
                            </jet-modal> -->

                        <table v-if="messages.data.length > 0" class="w-full text-left">
                            <thead
                                class="border-b-2 border-gray-300 text-indigo-600"
                            >
                                <tr>
                                    <th class="px-6 py-3 text-left">
                                        ID
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        Sending_time
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        Days
                                    </th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr v-for="(message,index) in messages.data" :key="index"
                                    class="text-sm text-indigo-900 border-b border-gray-400"
                                >
                                    <td class="px-6 py-4">
                                        {{ message.aduser_id}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ message.sending_time }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ message.days }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-center pt-5">                               
                                        <nav aria-label="Page navigation example">
                                            <ul class="inline-flex -space-x-px">
                                                <li v-for="(l,index) in messages.links" :key="index">
                                                    <a v-if="l.label.includes('laquo')" :href="l.url" class="py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Anterior</a>
                                                    <a v-else-if="l.label.includes('raquo')" :href="l.url" class="py-2 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Próximo</a>
                                                    <a v-else-if="!l.active" :href="l.url" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{l.label}}</a>
                                                    <a v-else-if="l.active" :href="l.url" aria-current="page" class="py-2 px-3 text-blue-600 bg-blue-50 border border-gray-300 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{l.label}}</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="bg-red-100 border border-red-400 p-3 rounded-lg text-red-800 mt-5 text-left">
                            No hay notificaciones enviadas
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import JetButton from '@/Components/Button.vue'
    import JetInput from '@/Components/Input.vue'
    import JetInputError from '@/Components/InputError.vue'
    import JetModal from '@/Components/Modal.vue'
    import Pagination from '@/Components/Pagination.vue'

    export default {
        components: {
            AppLayout,
            JetButton,
            JetInput,
            JetInputError,
            JetModal,
            Pagination,
        },
        data() {
            return{
                acting: null,
                defaultacting: null,
                method: null,
                action: null,
                disable_selects:false,
                form: this.$inertia.form({
                    'zendesk_group_id': '',
                    'zendesk_tickettype_id': '',
                    'zendesk_priority_id': '',
                    'sla_hours': ''
                }),
                formdefault: this.$inertia.form({
                    'zendesk_tickettype_id': '',
                    'zendesk_priority_id': '',
                    'sla_hours': ''
                }),
            }
        },
        methods: {
            submit() {
                this.form.submit( this.method, this.action, {
                    onSuccess: () => {
                        this.form.reset('zendesk_group_id');
                        this.form.reset('zendesk_tickettype_id');
                        this.form.reset('zendesk_priority_id');
                        this.form.reset('sla_hours');
                        this.acting = null;
                    }
                });
            },
            defaultsubmit() {
                this.formdefault.submit( this.method, this.action, {
                    onSuccess: () => {
                        this.formdefault.reset('zendesk_tickettype_id');
                        this.formdefault.reset('zendesk_priority_id');
                        this.formdefault.reset('sla_hours');
                        this.defaultacting = null;
                    }
                });
            }
        },
        props: {
            messages: Object,
        }
    }
</script>