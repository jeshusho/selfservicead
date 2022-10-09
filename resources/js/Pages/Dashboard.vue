<template>
    <Head title="Inicio" />
    <app-layout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notificaciones enviadas
            </h2>
        </template> -->

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-6">
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
                        <div class="max-w-xs mx-auto my-4">
                            <Datepicker v-model="dateMessage" :previewFormat="format" locale="es" cancelText="Cancelar" selectText="Seleccionar" :format="formatMessage" :enableTimePicker="false" @update:modelValue="handleDate" range />
                        </div>
                            <a v-if="messages.data.length > 0"
                                class="
                                    p-3
                                    border-2
                                    border-blue-100
                                    text-blue-500
                                    bg-blue-100
                                    hover:bg-blue-200
                                    font-bold
                                    text-lg
                                    rounded-xl"
                                :href="`/messages-export-excel/${datetime_ini_local}/${datetime_end_local}`"
                            >
                                Exportar a Excel
                            </a>
                        <table v-if="messages.data.length > 0" class="w-full text-left mt-4">
                            <thead
                                class="border-b-2 border-gray-300 text-indigo-600 text-base"
                            >
                                <tr>
                                    <th class="px-6 py-3 text-left">
                                        Username
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        Mail
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        Fecha/Hora envío
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        Días para expirar
                                    </th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr v-for="(message,index) in messages.data" :key="index"
                                    class="text-sm text-indigo-900 border-b border-gray-400"
                                >
                                    <td class="px-6 py-4">
                                        {{ message.aduser.username}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ message.aduser.mail}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ message.sending_time }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ (Math.abs(message.days)>1) ? message.days + ' dias': message.days + ' día' }} 
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
                        <div v-else class="bg-red-100 border border-red-400 p-3 rounded-lg text-red-800 mt-5 text-left w-80 text-base">
                            No hay notificaciones enviadas.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { ref, onMounted } from 'vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import JetButton from '@/Components/Button.vue'
    import JetInput from '@/Components/Input.vue'
    import JetInputError from '@/Components/InputError.vue'
    import JetModal from '@/Components/Modal.vue'
    import Pagination from '@/Components/Pagination.vue'
    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';

    export default {
        components: {
            AppLayout,
            JetButton,
            JetInput,
            JetInputError,
            JetModal,
            Pagination,
            Datepicker,
            ref,
            Head,
        },
        setup(props){
            
            const dateMessage = ref();
            /*
            const now = new Date();
            const startDateMessage = now.toLocaleString("en-US", {timeZone: "America/Lima"});
            const endDateMessage = new Date(new Date().setDate(now.getDate() + 0)).toLocaleString("en-US", {timeZone: "America/Lima"});
            */
            const startDateMessage = new Date(props.datetime_ini_local);
            const endDateMessage = new Date(props.datetime_end_local);
            const formatMessage = ([startDateMessage,endDateMessage]) => {
                const startday = ("0" + startDateMessage.getDate()).slice(-2);
                const startmonth =  ("0" + (startDateMessage.getMonth() + 1)).slice(-2);
                const startyear = startDateMessage.getFullYear();
                const endday = ("0" + endDateMessage.getDate()).slice(-2);
                const endmonth= ("0" + (endDateMessage.getMonth() + 1)).slice(-2);
                const endyear = endDateMessage.getFullYear();
                return `del ${startday}/${startmonth}/${startyear} al ${endday}/${endmonth}/${endyear}`;
            }

            const handleDate = ([startDateMessage,endDateMessage]) => {
                let message_date_ini = '';
                let message_date_end = '';
                if(startDateMessage !== null && endDateMessage !== null){
                    const startday = ("0" + startDateMessage.getDate()).slice(-2);
                    const startmonth = ("0" + (startDateMessage.getMonth() + 1)).slice(-2);
                    const startyear = startDateMessage.getFullYear();
                    const endday = ("0" + endDateMessage.getDate()).slice(-2);
                    const endmonth= ("0" + (endDateMessage.getMonth() + 1)).slice(-2);
                    const endyear = endDateMessage.getFullYear();
                    message_date_ini = `${startyear}-${startmonth}-${startday} 00:00:01`;
                    message_date_end = `${endyear}-${endmonth}-${endday} 23:59:59`;
                }
                console.log(message_date_ini + message_date_end);
                
                const action = route('messages.filter',{ message_date_ini: message_date_ini!='' ? message_date_ini : 'NaN',
                                                        message_date_end: message_date_end!=''? message_date_end : 'NaN',
                                                    });
                window.location.href=action;
            }

            onMounted(() => {
                dateMessage.value = [startDateMessage, endDateMessage];
            })
            
            const format = ([startDateMessage,endDateMessage]) => {
                const star_day = startDateMessage.getDate();
                const star_month = startDateMessage.getMonth() + 1;
                const star_year = startDateMessage.getFullYear();
                const end_day = endDateMessage.getDate();
                const end_month = endDateMessage.getMonth() + 1;
                const end_year = endDateMessage.getFullYear();


                return `${star_day}/${star_month}/${star_year} - \n ${end_day}/${end_month}/${end_year}`;
            }
            return {
                dateMessage,
                formatMessage,
                handleDate,
                format
            }
        },
        data() {
            return{
                acting: null,
                defaultacting: null,
                method: null,
                action: null,
                disable_selects:false,
                formfilter: this.$inertia.form({
                    'message_date_ini': '',
                    'message_date_end': '',
                }),
            }
        },
        methods: {
            submitfilter() {
                if(this.dateMessage === null || this.dateMessage[0] == null || this.dateMessage[1] == null){
                    this.formfilter.message_date_ini = '';
                    this.formfilter.message_date_end = '';
                }
                else{
                    const startday = ("0" + this.dateMessage[0].getDate()).slice(-2);
                    const startmonth = ("0" + (this.dateMessage[0].getMonth() + 1)).slice(-2);
                    const startyear = this.dateMessage[0].getFullYear();
                    const endday = ("0" + this.dateMessage[1].getDate()).slice(-2);
                    const endmonth= ("0" + (this.dateMessage[1].getMonth() + 1)).slice(-2);
                    const endyear = this.dateMessage[1].getFullYear();
                    this.formfilter.message_date_ini = `${startyear}-${startmonth}-${startday} 00:00:01`;
                    this.formfilter.message_date_end = `${endyear}-${endmonth}-${endday} 23:59:59`;
                }
                console.log(this.formfilter);
                
                this.action = route('messages.filter',{ message_date_ini: this.formfilter.message_date_ini!='' ? this.formfilter.message_date_ini : 'NaN',
                                                        message_date_end: this.formfilter.message_date_end!=''? this.formfilter.message_date_end : 'NaN',
                                                    });
                window.location.href=this.action;
            },
        },
        props: {
            messages: Object,
            datetime_ini_local: String,
            datetime_end_local: String,
        }
    }
</script>