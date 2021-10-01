<template>

	<Head title="Register" />
	<jet-authentication-card>
		<template #logo>
			<jet-authentication-card-logo />
		</template>

		<jet-validation-errors class="mb-4" />

		<form @submit.prevent="submit">
			<p class="text-xl text-center text-gray-600 dark:text-gray-200">Welcome.</p>

			<div class="space-y-2">
				<div>
					<jet-label
						for="name"
						value="Name"
					/>
					<jet-input
						id="name"
						type="text"
						class="block w-full"
						v-model="form.name"
						required
						autofocus
						autocomplete="name"
					/>
				</div>

				<div>
					<jet-label
						for="email"
						value="Email"
					/>
					<jet-input
						id="email"
						type="email"
						class="block w-full"
						v-model="form.email"
						required
					/>
				</div>

				<div>
					<jet-label
						for="password"
						value="Password"
					/>
					<jet-input
						id="password"
						type="password"
						class="block w-full"
						v-model="form.password"
						required
						autocomplete="new-password"
					/>
				</div>

				<div>
					<jet-label
						for="password_confirmation"
						value="Confirm Password"
					/>
					<jet-input
						id="password_confirmation"
						type="password"
						class="block w-full"
						v-model="form.password_confirmation"
						required
						autocomplete="new-password"
					/>
				</div>
			</div>

			<div
				class="mt-2"
				v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
			>
				<jet-label for="terms">
					<div class="flex items-center">
						<jet-checkbox
							name="terms"
							id="terms"
							v-model:checked="form.terms"
						/>

						<div class="ml-2">
							I agree to the <a
								target="_blank"
								:href="route('terms.show')"
								class="underline text-sm text-groadis"
							>Terms of Service</a> and <a
								target="_blank"
								:href="route('policy.show')"
								class="underline text-sm text-groadis"
							>Privacy Policy</a>
						</div>
					</div>
				</jet-label>
			</div>
			<div class="mt-4">
				<jet-button
					class="w-full text-center"
					:class="{ 'opacity-25': form.processing }"
					:disabled="form.processing"
				>Register</jet-button>

				<div class="flex items-center justify-between mt-4">
					<span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>

					<Link
						:href="route('login')"
						class="text-xs text-gray-500 capitalize dark:text-gray-400 hover:underline"
					>Already registered?</Link>

					<span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>
				</div>

			</div>
		</form>
	</jet-authentication-card>
</template>

<script>
import { defineComponent } from "vue";
import JetAuthenticationCard from "@/components/AuthenticationCard.vue";
import JetAuthenticationCardLogo from "@/components/AuthenticationCardLogo.vue";
import JetButton from "@/components/Button.vue";
import JetInput from "@/components/Input.vue";
import JetCheckbox from "@/components/Checkbox.vue";
import JetLabel from "@/components/Label.vue";
import JetValidationErrors from "@/components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import EmptyVue from "../../Layouts/Empty.vue";

export default defineComponent({
	components: {
		Head,
		JetAuthenticationCard,
		JetAuthenticationCardLogo,
		JetButton,
		JetInput,
		JetCheckbox,
		JetLabel,
		JetValidationErrors,
		Link,
	},
	layout: EmptyVue,

	data() {
		return {
			form: this.$inertia.form({
				name: "",
				email: "",
				role: 2,
				password: "",
				password_confirmation: "",
				terms: false,
			}),
		};
	},

	methods: {
		submit() {
			this.form.post(this.route("register"), {
				onFinish: () =>
					this.form.reset("password", "password_confirmation"),
			});
		},
	},
});
</script>
