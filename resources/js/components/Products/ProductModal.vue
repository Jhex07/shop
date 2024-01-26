<template>
  <div class="modal fade" id="product_modal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">{{ is_create ? 'Crear' : 'Editar' }} producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <BackendError :errors="back_errors" />

                    <Form @submit="saveProduct" :validation-schema="schema" ref="form">
                        <div class="modal-body">
                            <section class="row">

                                <div class="col-12 mt-2">
                                    <label class="form-label" for="name">Nombre</label>
                                    <Field name="name" v-slot="{ errorMessage, field }" v-model="product.name">
                                    <input type="text" id="name" v-model="product.name"
                                        :class="`form-control ${errorMessage || back_errors['name'] ? 'is-invalid' : ''}`" v-bind="field">
                                    <span class="invalid-feedback">{{ errorMessage }}</span>
                                    <span class="invalid-feedback" v-if="back_errors['name']">
                                        {{ back_errors['name'] }}
                                    </span>
                                    </Field>
                                </div>

                                <div class="col-12 mt-2">
                                    <label class="form-label" for="description">Descripción</label>
                                    <Field name="description" v-slot="{ errorMessage, field }" v-model="product.description">
                                    <textarea id="description" v-model="product.description"
                                        :class="`form-control ${errorMessage || back_errors['description'] ? 'is-invalid' : ''}`" v-bind="field"></textarea>
                                    <span class="invalid-feedback">{{ errorMessage }}</span>
                                    <span class="invalid-feedback" v-if="back_errors['description']">
                                        {{ back_errors['description'] }}
                                    </span>
                                    </Field>
                                </div>

                                <div class="col-12 mt-2">
                                    <label class="form-label" for="price">Precio</label>
                                    <Field name="price" type="number" v-slot="{ errorMessage, field }" v-model="product.price">
                                        <input type="number" id="price" v-model="product.price"
                                            :class="`form-control ${errorMessage || back_errors['price'] ? 'is-invalid' : ''}`" v-bind="field">
                                        <span class="invalid-feedback">{{ errorMessage }}</span>
                                        <span class="invalid-feedback" v-if="back_errors['price']">
                                            {{ back_errors['price'] }}
                                        </span>
                                    </Field>
                                </div>

                                <div class="col-12 mt-2">
                                    <label class="form-label" for="stock">Cantidad</label>
                                    <Field name="stock" type="number" v-slot="{ errorMessage, field }" v-model="product.stock">
                                        <input type="number" id="stock" v-model="product.stock"
                                            :class="`form-control ${errorMessage || back_errors['stock'] ? 'is-invalid' : ''}`" v-bind="field">
                                        <span class="invalid-feedback">{{ errorMessage }}</span>
                                        <span class="invalid-feedback" v-if="back_errors['stock']">
                                            {{ back_errors['stock'] }}
                                        </span>
                                    </Field>
                                </div>

                                <div class="col-12 mt-2">
                                    <label class="form-label" for="category">Categoría</label>
                                    <select v-model="product.category_id" class="form-control">
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                    </select>
                                </div>
                            </section>
                        </div>

                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Almacenar</button>
                        </div>
                    </Form>
            </div>
        </div>
  </div>
</template>

<script>
import { handlerErrors, successMessage } from '@/helpers/Alerts.js';
import { Field, ErrorMessage, Form } from 'vee-validate';
import * as yup from 'yup';

export default {
    props: ['product_data'],
    components: {
        Field, ErrorMessage, Form
    },
    watch: {
        product_data(new_value) {
            this.product = new_value;
            if (!this.product.id) return;
            this.is_create = false;
        }
    },
    computed: {
        schema() {
        return yup.object({
            name: yup.string().required(),
            description: yup.string().required(),
            price: yup.number().required().positive().integer(),
            stock: yup.number().required().positive().integer(),
        });
        }
    },
    data() {
        return {
        product: {},
        is_create: true,
        back_errors: {},
        categories: [],
        };
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        async getCategories() {
            try {
                const response = await axios.get('/categories/get-categories');
                this.categories = response.data.categories;
            } catch (error) {
                console.error(error.response);
                // Manejar errores si es necesario
            }
        },
        async saveProduct() {
            try {
                if (this.is_create) await axios.post('/products/store', this.product);
                else await axios.put(`/products/update/${this.product.id}`, this.product);
                await successMessage({ is_delete: false, reload: true });
            } catch (error) {
                console.error(error.response);
            }
        },
        reset() {
        this.is_create = true;
        this.product = {};
        this.category = null
        this.back_errors = {};
        this.$parent.product = {};
        setTimeout(() => this.$refs.form.resetForm(), 100);
        }
    }
    };
</script>
