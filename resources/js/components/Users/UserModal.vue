<template>

	<div class="modal fade" id="user_modal" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ is_create ? 'Crear' : 'Editar' }} usuario</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<BackendError :errors="back_errors" />

				<Form @submit="saveUser" :validation-schema="schema" ref="form">
					<div class="modal-body">
						<section class="row">

                            <div class="col-12 mt-2">
                                <label class="form-label" for="role">Rol</label>
                                <select v-model="user.role" class="form-control">
                                    <option v-for="role in roles" :key="role" :value="role">{{ role }}</option>
                                </select>
                            </div>



                            <div class="col-12 mt-2">
								<label class="form-label" for="number_id">Cedula</label>
								<Field name="number_id" v-slot="{ errorMessage, field }" v-model="user.number_id">
									<input type="text" id="number_id" v-model="user.number_id"
										:class="`form-control ${errorMessage || back_errors['number_id'] ? 'is-invalid' : ''}`" v-bind="field">
									<span class="invalid-feedback">{{ errorMessage }}</span>
									<span class="invalid-feedback" v-if="back_errors['number_id']">
										{{ back_errors['number_id'] }}
									</span>
								</Field>
							</div>


							<div class="col-12 mt-2">
								<label class="form-label" for="name">Nombre</label>
								<Field name="name" v-slot="{ errorMessage, field }" v-model="user.name">
									<input type="text" id="name" v-model="user.name"
										:class="`form-control ${errorMessage || back_errors['name'] ? 'is-invalid' : ''}`" v-bind="field">
									<span class="invalid-feedback">{{ errorMessage }}</span>
									<span class="invalid-feedback" v-if="back_errors['name']">
										{{ back_errors['name'] }}
									</span>
								</Field>
							</div>

							<div class="col-12 mt-2">
								<label class="form-label" for="last_name">Apellido</label>
								<Field name="last_name" v-slot="{ errorMessage, field }" v-model="user.last_name">
									<input type="text" id="last_name" v-model="user.last_name"
										:class="`form-control ${errorMessage || back_errors['last_name'] ? 'is-invalid' : ''}`" v-bind="field">
									<span class="invalid-feedback">{{ errorMessage }}</span>
									<span class="invalid-feedback" v-if="back_errors['last_name']">
										{{ back_errors['last_name'] }}
									</span>
								</Field>
							</div>


							<div class="col-12 mt-2">
								<label class="form-label" for="email">Email</label>
								<Field name="email" v-slot="{ errorMessage, field }" v-model="user.email">
									<input type="text" id="email" v-model="user.email"
										:class="`form-control ${errorMessage || back_errors['email'] ? 'is-invalid' : ''}`" v-bind="field">
									<span class="invalid-feedback">{{ errorMessage }}</span>
									<span class="invalid-feedback" v-if="back_errors['email']">
										{{ back_errors['email'] }}
									</span>
								</Field>
							</div>


                            <div class="col-12 mt-2">
                                <label class="form-label" for="password">Contraseña</label>
                                <Field name="password" type="password" v-slot="{ errorMessage, field }" v-model="user.password">
                                    <input type="password" id="password" v-model="user.password"
                                        :class="`form-control ${errorMessage || back_errors['password'] ? 'is-invalid' : ''}`" v-bind="field">
                                    <span class="invalid-feedback">{{ errorMessage }}</span>
                                    <span class="invalid-feedback" v-if="back_errors['password']">
                                        {{ back_errors['password'] }}
                                    </span>
                                </Field>
                            </div>

                            <div class="col-12 mt-2">
                                <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                                <Field name="password_confirmation" type="password" v-slot="{ errorMessage, field }" v-model="user.password_confirmation">
                                    <input type="password" id="password_confirmation" v-model="user.password_confirmation"
                                        :class="`form-control ${errorMessage || back_errors['password_confirmation'] ? 'is-invalid' : ''}`" v-bind="field">
                                    <span class="invalid-feedback">{{ errorMessage }}</span>
                                    <span class="invalid-feedback" v-if="back_errors['password_confirmation']">
                                        {{ back_errors['password_confirmation'] }}
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
import { handlerErrors, successMessage } from '@/helpers/Alerts.js'
import { Field, ErrorMessage, Form } from 'vee-validate'
import * as yup from 'yup';


export default {
	props: ['user_data'],
	components: {
		Field, ErrorMessage, Form
	},
	watch: {
		user_data(new_value) {
			this.user = new_value
			if (!this.user.id) return
			this.is_create = false
		}
	},
	computed: {
		schema() {
			return yup.object({
                number_id: yup.string().required(),
				name: yup.string().required(),
				last_name: yup.string().required(),
				email: yup.string().email().required(),
			});
		}
	},
	data() {
		return {
			user: {},
			is_create: true,
			back_errors: {},
            roles: [],
		}
	},
    mounted() {
        this.getRoles();
    },
	methods: {
		async getRoles() {
            try {

                const response = await axios.get('/users/get-roles');
                this.roles = response.data.roles;
                console.log(this.roles);
            } catch (error) {
                console.error(error.response);

            }
        },

        async saveUser() {
            try {
				if (this.is_create) await axios.post('/users/store', this.user)
				else await axios.put(`/users/update/${this.user.id}`, this.user)
				await successMessage({ is_delete: false, reload: true })

			} catch (error) {
                console.error(error.response);
				this.back_errors = await handlerErrors(error)
			}
		},
        createFormData(data) {
			const form_data = new FormData()
			for (const key in data) {
				form_data.append(key, data[key])
			}
			return form_data
		},
		reset() {
            this.is_create = true
			this.book = {}
			this.back_errors = {}
			this.$parent.user = {}
			setTimeout(() => this.$refs.form.resetForm(), 100);
		}
	}
}
</script>

