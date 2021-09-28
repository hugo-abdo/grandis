<template>
	<card class="w-96 mx-auto">
		<form @submit.prevent="createRole">
			<!-- Profile Photo -->
			<div class="w-max mx-auto flex items-center flex-col">
				<!-- Profile Photo File Input -->
				<input
					type="file"
					class="hidden"
					ref="photo"
					@change="updatePhotoPreview"
				/>

				<!-- Current Profile Photo -->
				<div
					class="mt-2"
					v-show="! photoPreview"
				>
					<img
						src="/assets/images/camera.png"
						class="rounded-full h-20 w-20 object-cover border bg-white shadow-md p-2"
					/>
				</div>

				<!-- New Profile Photo Preview -->
				<div
					class="mt-2"
					v-show="photoPreview"
				>
					<span
						class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
						:style="'background-image: url(\'' + photoPreview + '\');'"
					></span>
				</div>

				<jet-secondary-button
					class="mt-2 mr-2"
					type="button"
					@click.prevent="selectNewPhoto"
				>Select A New Photo</jet-secondary-button>
				<jet-input-error
					:message="form.errors.photo"
					class="mt-2"
				/>
			</div>

			<!-- Name -->
			<div class="w-72 mt-5 mx-auto">
				<div class="flex items-center">
					<jet-input
						id="name"
						type="text"
						placeholder="Role Name"
						class="mt-1 block w-full"
						v-model="form.name"
						autocomplete="name"
					/>

					<jet-input
						id="color"
						type="color"
						class="w-10 h-10 ml-2"
						v-model="form.color"
					/>
				</div>
				<jet-input-error
					:message="form.errors.name"
					class="mt-2"
				/>
				<jet-input-error
					:message="form.errors.color"
					class="mt-2"
				/>
			</div>

			<!-- actions -->
			<div class="mt-5 text-center">
				<jet-action-message
					:on="form.recentlySuccessful"
					class="mr-3"
				>Created.</jet-action-message>

				<jet-button
					:class="{ 'opacity-25': form.processing }"
					:disabled="form.processing"
				>Create</jet-button>
			</div>
		</form>
	</card>
</template>

<script>
import { defineComponent } from "vue";
import JetButton from "@/components/Button.vue";
import JetInput from "@/components/Input.vue";
import JetInputError from "@/components/InputError.vue";
import JetLabel from "@/components/Label.vue";
import JetSecondaryButton from "@/components/SecondaryButton.vue";
import JetActionMessage from "@/components/ActionMessage.vue";

export default defineComponent({
	components: {
		JetActionMessage,
		JetButton,
		JetInput,
		JetInputError,
		JetLabel,
		JetSecondaryButton,
	},

	data() {
		return {
			form: this.$inertia.form({
				name: "",
				color: "",
				photo: null,
			}),
			photoPreview: null,
		};
	},

	methods: {
		createRole() {
			if (this.$refs.photo) {
				this.form.photo = this.$refs.photo.files[0];
			}
			this.form.post(route("roles.store"), {
				onSuccess: (page) => {
					this.photoPreview = null;
					this.clearPhotoFileInput();
					this.form.reset();
				},
			});
		},

		selectNewPhoto() {
			this.$refs.photo.click();
		},

		updatePhotoPreview() {
			const photo = this.$refs.photo.files[0];

			if (!photo) return;

			const reader = new FileReader();

			reader.onload = (e) => {
				this.photoPreview = e.target.result;
			};

			reader.readAsDataURL(photo);
		},

		deletePhoto() {
			this.$inertia.delete(route("user-photo.destroy", this.oldUser.id), {
				preserveScroll: true,
				onSuccess: (page) => {
					this.photoPreview = null;
					this.clearPhotoFileInput();
				},
			});
		},

		clearPhotoFileInput() {
			if (this.$refs.photo?.value) {
				this.$refs.photo.value = null;
			}
		},
	},
});
</script>
