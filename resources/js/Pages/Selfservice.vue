<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100 px-4">
    <div class="w-full sm:w-2/3 md:w-1/3 bg-white p-8 shadow-md rounded-md">
      <h1 class="text-2xl font-bold mb-6 text-center">Desbloqueo de usuario</h1>
      <form @submit.prevent="handleSubmit" v-if="!this.user">
        <div class="mb-6">
          <label for="username" class="block text-sm font-medium text-gray-700">Nombre de usuario (código) <i>Ej: A0001</i></label>
          <input
            type="text"
            id="username"
            v-model="form.username"
            class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Ingrese su nombre de usuario"
            required
          />
        </div>
        <!--
        <div class="mb-6">
          <label for="phone" class="block text-sm font-medium text-gray-700">Número de celular</label>
          <input
            type="tel"
            id="phone"
            v-model="form.phone"
            class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Ingrese su número de celular"
            required
          />
        </div>
        -->
        <jet-button
            class="
                w-full py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 items-center justify-center"
            @click="method = 'post';
                    action = route('selfservice.store');
                    submit();
                    "
        >
            Enviar
        </jet-button>
      </form>
      <div v-else>
          Hola <b>{{ user.display_name }}</b>, tu usuario <b>{{ user.username }}</b> será desbloqueado en breve. Vuelva a intentar ingresar en 30 segundos.
      </div>
    </div>
  </div>
</template>

<script>
//import AppLayout from '@/Layouts/AppLayout.vue'
import JetButton from '@/Components/Button.vue'
import JetInput from '@/Components/Input.vue'
import JetInputError from '@/Components/InputError.vue'
//import JetModal from '@/Components/Modal.vue'
//import Pagination from '@/Components/Pagination.vue'

export default {
  components: {
      JetButton,
      JetInput,
      JetInputError
  },
  data() {
    return {
      method: null,
      action: null,
      acting: null,
      form: this.$inertia.form({
          'username': '',
          'phone': '',
      }),
    };
  },
  methods: {
    submit() {
        this.form.submit(this.method, this.action, {
            onSuccess: () => {
                this.form.reset('username');
                this.form.reset('phone');
                this.acting = null;
            }
        });
    },
  },
  props: {
      user: Object,
  }
};
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí si es necesario */
</style>
