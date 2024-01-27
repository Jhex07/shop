<template>
  <div class="modal fade" id="category_modal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">{{ is_create ? 'Crear' : 'Editar' }} categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <BackendError :errors="back_errors" />

                    <Form @submit="saveCategory" :validation-schema="schema" ref="form">
                        <div class="modal-body">
                            <section class="row">

                                <div class="col-12 mt-2">
                                    <label class="form-label" for="name">Nombre</label>
                                    <Field name="name" v-slot="{ errorMessage, field }" v-model="category.name">
                                    <input type="text" id="name" v-model="category.name"
                                        :class="`form-control ${errorMessage || back_errors['name'] ? 'is-invalid' : ''}`" v-bind="field">
                                    <span class="invalid-feedback">{{ errorMessage }}</span>
                                    <span class="invalid-feedback" v-if="back_errors['name']">
                                        {{ back_errors['name'] }}
                                    </span>
                                    </Field>
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
    props: ['category_data'],
    components: {
        Field, ErrorMessage, Form
    },
    watch: {
        category_data(new_value) {
            this.category = new_value;
            if (!this.category.id) return;
            this.is_create = false;
        }
    },
    computed: {
        schema() {
        return yup.object({
            name: yup.string().required(),
        });
        }
    },
    data() {
        return {
        category: {},
        is_create: true,
        back_errors: {},
        };
    },
    methods: {
        async saveCategory() {
            try {
                if (this.is_create) await axios.post('/categories/store', this.category);
                else await axios.put(`/categories/update/${this.category.id}`, this.category);
                await successMessage({ is_delete: false, reload: true });
            } catch (error) {
                console.error(error.response);
            }
        },
        reset() {
        this.is_create = true;
        this.category = {};
        this.back_errors = {};
        setTimeout(() => this.$refs.form.resetForm(), 100);
        }
    }
    };
</script>
