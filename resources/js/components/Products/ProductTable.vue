<template>
  <div class="card">
    <div class="card-header d-flex justify-content-end">
      <button class="btn btn-primary" @click="openModal">Crear producto</button>
    </div>
    <div class="card-body">
      <div class="table-responsive my-4 mx-2">
        <table class="table table-bordered" id="products_table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Precio</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(product, index) in products" :key="index">
              <td>{{ product.name }}</td>
              <td>{{ product.description }}</td>
              <td>{{ product.price }}</td>
              <td>
                <div class="d-flex justify-content-center">
                  <button @click="editProduct(product)" class="btn btn-warning btn-sm" title="Editar">
                    <i class="fas fa-pencil-alt"></i>
                  </button>
                  <button @click="deleteProduct(product)" class="btn btn-danger btn-sm ms-2" title="Eliminar">
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
      <product-modal ref="product_modal" :product_data="product" />
    </div>
  </div>
</template>

<script>
import { handlerErrors, successMessage, deleteMessage } from '@/helpers/Alerts.js';
import ProductModal from './ProductModal.vue';

export default {
  props: ['products'],
  components: { ProductModal },
  data() {
    return {
      modal: null,
      load_modal: true,
      product: {},
    };
  },
  mounted() {
    this.index();
  },
  methods: {
    index() {
      $('#products_table').DataTable();

      if (!this.modal) {
        const modal_id = document.getElementById('product_modal');
        this.modal = new bootstrap.Modal(modal_id, {
          backdrop: 'static',
          keyboard: false,
        });

        modal_id.addEventListener('hidden.bs.modal', (e) => {
          this.$refs.product_modal.reset();
        });
      }
    },
    editProduct(product) {
      this.product = product;
      this.openModal();
    },
    async deleteProduct({ id }) {
      if (!(await deleteMessage())) return;
      try {
            await axios.delete(`/products/${id}`);
            await successMessage({ is_delete: true, reload: true });
        }catch (error) {
            await handlerErrors(error);
      }
    },
    openModal() {
      this.modal.show();
    },
  },
};
</script>
