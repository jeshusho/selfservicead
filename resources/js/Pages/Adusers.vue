<template>
    <Head title="Usuarios" />
    <app-layout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notificaciones enviadas
            </h2>
        </template> -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
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
                        <h2 class="text-center font-bold text-2xl">Usuarios - Expiración de contraseñas</h2>
                        <div class="text-center font-bold text-base">Actualizado al {{ today }}</div>
                        <a
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
                            :href="route('adusers.export-excel')"
                        >
                            Exportar a Excel
                        </a>
                            
                        <table v-if="adusers.data.length > 0" class="w-full text-left mt-4">
                            <thead
                                class="border-b-2 border-gray-300 text-indigo-600"
                            >
                                <tr>
                                    <th class="px-6 py-3 text-left">
                                        Username
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        Nombre completo
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        Fecha de expiración
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        Contraseña<br>expirada
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        Expira<br>en
                                    </th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr v-for="(aduser,index) in adusers.data" :key="index"
                                    class="text-sm text-indigo-900 border-b border-gray-400"
                                >
                                    <td class="px-6 py-4">
                                        {{ aduser.username}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ aduser.display_name}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ aduser.expiration_str }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ aduser.password_expired ? 'SI' : 'NO' }} 
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ (aduser.expiration_days>1) ? aduser.expiration_days + ' dias': aduser.expiration_days + ' día' }} 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-center pt-5">                               
                                        <nav aria-label="Page navigation example">
                                            <ul class="inline-flex -space-x-px">
                                                <li v-for="(l,index) in adusers.links" :key="index">
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
                        <div v-else class="bg-red-100 border border-red-400 p-3 rounded-lg text-red-800 mt-5 text-left w-80">
                            No hay notificaciones enviadas
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
import route from '../../../vendor/tightenco/ziggy/src/js';

    export default {
        components: {
            AppLayout,
            JetButton,
            JetInput,
            JetInputError,
            JetModal,
            Pagination,
            ref,
            Head,
        },
        data() {
            return{
                acting: null,
                defaultacting: null,
                method: null,
                action: null,
                data:null,
                errors:null,
                disable_selects:false,
                formfilter: this.$inertia.form({
                    'message_date_ini': '',
                    'message_date_end': '',
                }),
            }
        },
        methods: {
            export_excel(){
                // console.log('hoa');
                // axios.get('/adusers-export-excel').then( response =>{
                //     return response;
                // }).catch( errors => {
                //     this.errors = errors.reponse.errors
                // });
                return route('adusers.export-excel')
            },
            submitfilter() {
                // console.log('hola que tal');
                // if(this.dateMessage === null || this.dateMessage[0] == null || this.dateMessage[1] == null){
                //     this.formfilter.message_date_ini = '';
                //     this.formfilter.message_date_end = '';
                // }
                // else{
                //     const startday = ("0" + this.dateMessage[0].getDate()).slice(-2);
                //     const startmonth = ("0" + (this.dateMessage[0].getMonth() + 1)).slice(-2);
                //     const startyear = this.dateMessage[0].getFullYear();
                //     const endday = ("0" + this.dateMessage[1].getDate()).slice(-2);
                //     const endmonth= ("0" + (this.dateMessage[1].getMonth() + 1)).slice(-2);
                //     const endyear = this.dateMessage[1].getFullYear();
                //     this.formfilter.message_date_ini = `${startyear}-${startmonth}-${startday} 00:00:01`;
                //     this.formfilter.message_date_end = `${endyear}-${endmonth}-${endday} 23:59:59`;
                // }
                // console.log(this.formfilter);
                
                // this.action = route('messages.filter',{ message_date_ini: this.formfilter.message_date_ini!='' ? this.formfilter.message_date_ini : 'NaN',
                //                                         message_date_end: this.formfilter.message_date_end!=''? this.formfilter.message_date_end : 'NaN',
                //                                     });
                // window.location.href=this.action;
            },
        },
        props: {
            adusers: Object,
            today: String,
        }
    }
</script>