<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="
                    bg-white
                    overflow-hidden
                    shadow-xl
                    rounded-lg
                    p-12
                    border-b
                    border-gray-200
                    flex
                    flex-col
                    text-xl
                ">
                    <div class=" mx-auto text-right">
                        <div class="flex flex-row justify-between">
                            <h2 class="text-center font-bold text-2xl">Avisos</h2>
                            <jet-button
                                class="
                                    p-3
                                    border-2
                                    border-blue-100
                                    text-blue-500
                                    bg-blue-100
                                    hover:bg-blue-200
                                    font-bold
                                    rounded-xl"
                                @click="form_notification.name = '';
                                        form_notification.days = '';
                                        acting_notification =  true;
                                        method_notification = 'post';
                                        action_notification = route('notifications.store');
                                        "
                            >
                                Nuevo Aviso +
                            </jet-button>
                        </div>

                        <jet-modal :show="acting_notification" :closeable="true" @close="acting_notification = null">
                            <div class="bg-gray-50 shadow-2xl p-2">
                                <form
                                    class="flex flex-col items-center p-12"
                                    @submit.prevent="submit_notification"
                                >

                                <div class="mx-auto justify-center my-3">
                                <div class="text-left text-indigo-800 font-semibold">Detalle de Aviso</div>
                                <div class="flex flex-row justify-between w-full">
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" v-model="form_notification.name"
                                                class="focus:ring-mv-blue focus:border-mv-blue block pl-4 pr-1 sm:text-sm border-gray-300 rounded-md w-64"
                                                placeholder="Nombre del aviso"
                                                
                                        >
                                        <jet-input-error :message="form_notification.errors.name" />
                                    </div>
                                    <div class="mt-1 ml-12 relative rounded-md shadow-sm">
                                        <input type="number" v-model="form_notification.days" name="days"
                                                class="focus:ring-mv-blue focus:border-mv-blue block pl-4 pr-1 sm:text-sm border-gray-300 rounded-md w-32"
                                                placeholder="0" :step="1" :min="1" :max="365"
                                        >
                                        <div class="absolute inset-y-[1px] right-0 px-2 flex items-center pointer-events-none bg-gray-200 rounded rounded-tl-none rounded-tr-md rounded-br-md rounded-bl-none">
                                            <span class="text-gray-800 sm:text-sm"> Días </span>
                                        </div>
                                        <jet-input-error :message="form_notification.errors.days" />
                                    </div>
                                    
                                </div>
                                
                                
                                </div>

                                <jet-button
                                    class="px-5 py-3 mt-5 w-96 bg-purple-400 justify-center rounded-xl text-sm"
                                    :disabled="form_notification.processing"
                                >
                                    <span class="animate-spin mr-1" v-show="form_notification.processing">
                                        &#9696;
                                    </span>
                                    <span  v-show="!form_notification.processing">
                                        Guardar
                                    </span>
                                    
                                </jet-button>

                                </form>
                            </div>
                        </jet-modal>
                        <table v-if="notifications.length > 0" class="w-full text-left">
                            <thead
                                class="border-b-2 border-gray-300 text-indigo-600 text-base"
                            >
                                <tr>
                                    <th class="px-6 py-2 text-center">
                                        Aviso
                                    </th>
                                    <th class="px-6 py-2 text-center">
                                        Días de anticipación<br>(vencimiento de contraseña)
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-for="(field,index) in notifications" :key="index">
                                <tr
                                    class="text-sm text-indigo-900 border-b border-gray-400"
                                >
                                    <td class="px-6 py-3">
                                        {{ field.name }}
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        {{ (field.days>1) ? field.days + ' dias': field.days + ' día' }} 
                                    </td>                                   
                                    <td class="px-6 py-3">
                                        <jet-button
                                            class="border border-indigo-500 text-indigo-500 bg-indigo-50 hover:bg-indigo-100 mr-2 text-xs"
                                            @click="
                                                acting_notification =  true;
                                                method_notification = 'put';
                                                action_notification = route('notifications.update', [field.id]);
                                                form_notification.name = field.name;
                                                form_notification.days = field.days;
                                            "
                                        >
                                            Editar
                                        </jet-button>
                                        <jet-button
                                            class="border border-red-500 text-red-500 bg-red-50 hover:bg-red-100 ml-2"
                                            @click="
                                                method_notification = 'delete';
                                                action_notification = route('notifications.destroy', [field.id]);
                                                submit_notification();
                                            "
                                        >
                                            Eliminar
                                        </jet-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="bg-red-100 border border-red-400 p-3 rounded-lg text-red-800 mt-5 text-left">
                            No hay avisos configurados
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="
                    bg-white
                    overflow-hidden
                    shadow-xl
                    rounded-lg
                    p-12
                    border-b
                    border-gray-200
                    flex
                    flex-col
                    text-xl
                ">
                    <div class="w-3/4 mx-auto text-right">
                        <div class="flex flex-row justify-between">
                            <h2 class="text-center font-bold text-2xl">Horarios de notificación</h2>
                            <jet-button
                                class="
                                    p-3
                                    border-2
                                    border-blue-100
                                    text-blue-500
                                    bg-blue-100
                                    hover:bg-blue-200
                                    font-bold
                                    rounded-xl"
                                @click="form_schedule.hours = 0;
                                        form_schedule.minutes = 0;
                                        acting_schedule =  true;
                                        method_schedule = 'post';
                                        action_schedule = route('schedules.store');
                                        "
                            >
                                Nuevo horario +
                            </jet-button>
                        </div>

                        <jet-modal :show="acting_schedule" :closeable="true" @close="acting_schedule = null">
                            
                            <div class="bg-gray-50 shadow-2xl p-2">
                                <form
                                    class="flex flex-col items-center p-12"
                                    @submit.prevent="submit_schedule"
                                >

                                <div class="mx-auto justify-center my-3">
                                <div class="text-left text-indigo-800 font-semibold">Horario de notificación</div>
                                <div class="flex flex-row justify-between w-full">
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" v-model="form_schedule.hours" name="ini_hours"
                                                class="focus:ring-mv-blue focus:border-mv-blue block pl-4 pr-1 sm:text-sm border-gray-300 rounded-md w-32"
                                                placeholder="0" :step="1" :min="0" :max="23"
                                                
                                        >
                                        <div class="absolute inset-y-[1px] right-0 px-2 flex items-center pointer-events-none bg-gray-200 rounded rounded-tl-none rounded-tr-md rounded-br-md rounded-bl-none">
                                            <span class="text-gray-800 sm:text-sm"> Horas </span>
                                        </div>
                                    </div>
                                    <div class="mt-1 ml-12 relative rounded-md shadow-sm">
                                        <input type="number" v-model="form_schedule.minutes" name="ini_minutes"
                                                class="focus:ring-mv-blue focus:border-mv-blue block pl-4 pr-1 sm:text-sm border-gray-300 rounded-md w-32"
                                                placeholder="0" :step="1" :min="0" :max="59"
                                        >
                                        <div class="absolute inset-y-[1px] right-0 px-2 flex items-center pointer-events-none bg-gray-200 rounded rounded-tl-none rounded-tr-md rounded-br-md rounded-bl-none">
                                            <span class="text-gray-800 sm:text-sm"> Minutos </span>
                                        </div>
                                    </div>
                                </div>
                                <jet-input-error :message="form_schedule.errors.hours" />
                                <jet-input-error :message="form_schedule.errors.minutes" />
                                </div>

                                <jet-button
                                    class="px-5 py-3 mt-5 w-96 bg-purple-400 justify-center rounded-xl text-sm"
                                    :disabled="form_schedule.processing"
                                >
                                    <span class="animate-spin mr-1" v-show="form_schedule.processing">
                                        &#9696;
                                    </span>
                                    <span  v-show="!form_schedule.processing">
                                        Guardar
                                    </span>
                                    
                                </jet-button>

                                </form>
                            </div>
                        </jet-modal>
                        <table v-if="schedules.length > 0" class=" mx-auto text-left">
                            <thead
                                class="border-b-2 border-gray-300 text-indigo-600"
                            >
                                <tr>
                                    <th class="px-12 py-4 text-center text-base">
                                        Horario programado
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-for="(field,index) in schedules" :key="index">
                                <tr
                                    class="text-sm text-indigo-900 border-b border-gray-400"
                                >
                                    <td class="px-6 py-3">
                                        {{ field.hours }} hrs. {{ field.minutes }} min.
                                    </td>                               
                                    <td class="px-6 py-3">
                                        <jet-button
                                            class="border border-indigo-500 text-indigo-500 bg-indigo-50 hover:bg-indigo-100 mr-2"
                                            @click="
                                                acting_schedule =  true;
                                                method_schedule = 'put';
                                                action_schedule = route('schedules.update', [field.id]);
                                                form_schedule.hours = field.hours;
                                                form_schedule.minutes = field.minutes;
                                            "
                                        >
                                            Editar
                                        </jet-button>
                                        <jet-button
                                            class="border border-red-500 text-red-500 bg-red-50 hover:bg-red-100 ml-2"
                                            @click="
                                                method_schedule = 'delete';
                                                action_schedule = route('schedules.destroy', [field.id]);
                                                submit_schedule();
                                            "
                                        >
                                            Eliminar
                                        </jet-button>
                                    </td>
                                </tr>
                                
                            </tbody>
                            <tr>
                                <td colspan="2" class="text-xs pt-6 text-justify">
                                Tener en cuenta que para que las notificaciones sean enviadas en el horario programado, la <b>tarea programada</b> que envía la información del vencimiento de las contraseñas del Directorio Activo desde el servidor Windows, debe ser ejecutada en un máximo de <b>{{ max_delay }} minutos antes</b> del horario programado.
                                </td>
                            </tr>
                        </table>
                        <div v-else class="bg-red-100 border border-red-400 p-3 rounded-lg text-red-800 mt-5 text-left">
                            No hay horarios configurados
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-Layout>
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
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
                fieldacting: null,
                acting_notification: null,
                method_notification: null,
                action_notification: null,
                acting_schedule: null,
                method_schedule: null,
                action_schedule: null,
                form_notification: this.$inertia.form({
                    'name': '',
                    'days': '',
                }),
                form_schedule: this.$inertia.form({
                    'hours': '',
                    'minutes': '',
                }),
            }
        },
        methods: {
            submit_notification() {
                this.form_notification.submit(this.method_notification, this.action_notification, {
                    onSuccess: () => {
                        this.form_notification.reset('name');
                        this.form_notification.reset('days');
                        this.acting_notification = null;
                    }
                });
            },
            submit_schedule() {
                this.form_schedule.submit(this.method_schedule, this.action_schedule, {
                    onSuccess: () => {
                        this.form_schedule.reset('name');
                        this.form_schedule.reset('days');
                        this.acting_schedule = null;
                    }
                });
            }
        },
        props: {
            notifications: Object,
            schedules: Object,
            max_delay: Number,
        }
    }
</script>