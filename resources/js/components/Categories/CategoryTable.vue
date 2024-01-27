<template>
  <div class="card">
    <div class="card-header d-flex justify-content-end">
      <button class="btn btn-primary" @click="openModal">Crear categoría</button>
    </div>
    <div class="card-body">
      <div class="table-responsive my-4 mx-2">
        <table class="table table-bordered" id="categories_table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(category, index) in categories" :key="index">
              <td>{{ category.name }}</td>
              <td>
                <div class="d-flex justify-content-center">
                  <button @click="editCategory(category)" class="btn btn-warning btn-sm" title="Editar">
                    <i class="fas fa-pencil-alt"></i>
                  </button>
                  <button @click="deleteCategory(category)" class="btn btn-danger btn-sm ms-2" title="Eliminar">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div>
      <category-modal ref="category_modal" :category_data="category" />
    </div>
  </div>
</template>

<script>
import { handlerErrors, successMessage, deleteMessage } from '@/helpers/Alerts.js';
import CategoryModal from './CategoryModal.vue';

export default {
  props: ['categories'],
  components: { CategoryModal },
  data() {
    return {
      modal: null,
      load_modal: true,
      category: {},
    };
  },
  mounted() {
    this.index();
  },
  methods: {
    index() {
      $('#categories_table').DataTable();

      if (!this.modal) {
        const modal_id = document.getElementById('category_modal');
        this.modal = new bootstrap.Modal(modal_id, {
          backdrop: 'static',
          keyboard: false,
        });

        modal_id.addEventListener('hidden.bs.modal', (e) => {
          this.$refs.category_modal.reset();
        });
      }
    },
    editCategory(category) {
      this.category = category;
      this.openModal();
    },
    async deleteCategory({ id }) {
      if (!(await deleteMessage())) return;
      try {
        await axios.delete(`/categories/${id}`);
        await successMessage({ is_delete: true, reload: true });
      } catch (error) {
        await handlerErrors(error);
      }
    },
    openModal() {
      this.modal.show();
    },
  },
};
</script>
