<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100 px-4">
    <div class="w-full sm:w-2/3 md:w-1/3 bg-white p-8 shadow-md rounded-md">
      <h1 class="text-2xl font-bold mb-6 text-center">Desbloqueo de usuario</h1>
      <form @submit.prevent="handleSubmit">
        <div class="mb-6">
          <label for="username" class="block text-sm font-medium text-gray-700">Nombre de usuario (código). <i>Ej: A0001</i></label>
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
        <button
          type="submit"
          class="w-full py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Enviar
        </button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        username: '',
        phone: ''
      }
    };
  },
  methods: {
    handleSubmit() {
      // Aquí se puede manejar el envío de datos, por ejemplo, enviando una solicitud al backend
      this.$inertia.post('/ruta-al-controlador', this.form)
        .then(() => {
          // Opcional: acción después de enviar exitosamente
          alert('Formulario enviado con éxito');
        })
        .catch(error => {
          // Opcional: manejo de errores
          console.error('Error al enviar el formulario:', error);
        });
    }
  }
};
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí si es necesario */
</style>
