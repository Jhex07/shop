<template>
	<div class="card">
		<div class="card-header d-flex justify-content-end">
			<button class="btn btn-primary" @click="openModal">Crear usuario</button>
		</div>
		<div class="card-body">
			<div class="table-responsive my-4 mx-2">
				<table class="table table-bordered" id="users_table">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Apellido</th>
							<th>Email</th>
                            <th>Rol</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(user, index) in users" :key="index">
							<td>{{ user.name }}</td>
							<td>{{ user.last_name }}</td>
							<td>{{ user.email }}</td>
                            <td>{{ user.roles.map(role => role.name).join()}}</td>
							<td>
								<div class="d-flex justify-content-center">
									<button @click="editUser(user)" class="btn btn-warning btn-sm" title="Editar">
										<i class="fas fa-pencil-alt"></i>
									</button>
									<button @click="deleteUser(user)" class="btn btn-danger btn-sm ms-2" title="Eliminar">
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
			<user-modal ref="user_modal" :user_data="user" />
		</div>
	</div>
</template>

<script>
import { handlerErrors, successMessage, deleteMessage } from '@/helpers/Alerts.js'
import UserModal from './UserModal.vue'
export default {
	props: ['users'],
	components: { UserModal },
	data() {
		return {
			modal: null,
			load_modal: true,
			user: {}
		}
	},
	mounted() {
		this.index()
	},
	methods: {
		index() {
            $('#users_table').DataTable();

            if (!this.modal) {
                const modal_id = document.getElementById('user_modal');
                this.modal = new bootstrap.Modal(modal_id, {
                    backdrop: 'static',
                    keyboard: false
                });

                modal_id.addEventListener('hidden.bs.modal', e => {
                    this.$refs.user_modal.reset();
                });
            }
        },
		editUser(user) {
			this.user = user
			this.openModal()
		},
		async deleteUser({ id }) {
			if (!await deleteMessage()) return
			try {
                await axios.delete(`/users/${id}`)
				await successMessage({ is_delete: true, reload: true })
			} catch (error) {
				await handlerErrors(error)
			}
		},
		openModal() {
            this.modal.show();
        }
	}
}
</script>
