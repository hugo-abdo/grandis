<template>
	<slot :activate="confirmUserDeletion" />

	<!-- Delete Account Confirmation Modal -->
	<jet-dialog-modal :show="confirmingUserDeletion" @close="closeModal">
		<template #title>Delete Account</template>

		<template #content>
			Are you sure you want to delete this account? Once this account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete this account.
			<div class="mt-4">
				<jet-input
					type="password"
					class="mt-1 block w-3/4"
					placeholder="Your Password"
					ref="password"
					v-model="form.password"
					@keyup.enter="deleteUser"
				/>

				<jet-input-error :message="form.errors.password" class="mt-2" />
			</div>
		</template>

		<template #footer>
			<jet-secondary-button @click="closeModal">Cancel</jet-secondary-button>

			<jet-danger-button
				class="ml-2"
				@click="deleteUser"
				:class="{ 'opacity-25': form.processing }"
				:disabled="form.processing"
			>Delete Account</jet-danger-button>
		</template>
	</jet-dialog-modal>
</template>

<script>
import { defineComponent } from "vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

export default defineComponent({
	components: {
		JetActionSection,
		JetDangerButton,
		JetDialogModal,
		JetInput,
		JetInputError,
		JetSecondaryButton,
	},

	props: ["data"],

	data() {
		return {
			confirmingUserDeletion: false,

			form: this.$inertia.form({
				password: "",
				users: null,
			}),
		};
	},

	methods: {
		confirmUserDeletion() {
			this.confirmingUserDeletion = true;

			setTimeout(() => this.$refs.password.focus(), 250);
		},

		async deleteUser() {
			if (typeof this.data == "number") {
				try {
					await this.$store.dispatch("deleteUser", {
						form: this.form,
						userId: this.data,
					});
					this.closeModal();
				} catch (error) {
					this.$refs.password.focus();
				}
			} else {
				// push the users selection to the  form
				this.form.users = this.data;
				try {
					await this.$store.dispatch("deleteMulipelUsers", {
						form: this.form,
						usersSelected: this.data,
					});
					this.form.users = null;
					this.closeModal();
				} catch (error) {
					this.$refs.password.focus();
				}
			}
		},

		closeModal() {
			this.confirmingUserDeletion = false;
			this.form.reset();
		},
	},
});
</script>
