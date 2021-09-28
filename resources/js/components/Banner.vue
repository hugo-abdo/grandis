<template>
	<transition
		enter-active-class="transition ease-out duration-500"
		enter-from-class="transform opacity-0 scale-95 translate-x-80"
		enter-to-class="transform opacity-100 scale-100 translate-x-0"
		leave-active-class="transition ease-in duration-100"
		leave-from-class="transform opacity-100 scale-100 translate-y-0"
		leave-to-class="transform opacity-0 scale-95 translate-y-80"
	>
		<div
			class="shadow-md fixed rounded-lg overflow-hidden right-5 bottom-5 z-50"
			v-if="show && message"
		>
			<div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
				<div
					class="flex items-center justify-center w-12 "
					:class="{ 'bg-green-300': style == 'success', 'bg-red-500': style == 'danger' }"
				>
					<svg
						class="w-6 h-6 text-white fill-current"
						viewBox="0 0 40 40"
						xmlns="http://www.w3.org/2000/svg"
					>
						<path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
					</svg>
				</div>

				<div class="px-4 py-2 -mx-3">
					<div class="mx-3">
						<span class="font-semibold text-green-500 dark:text-green-400">{{style}}</span>
						<p class="text-sm text-gray-600 dark:text-gray-200">{{ message }}</p>
					</div>
				</div>
			</div>
		</div>
	</transition>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
	data() {
		return {
			show: false,
		};
	},

	computed: {
		style() {
			return this.$page.props.jetstream.flash?.bannerStyle || "success";
		},

		message() {
			return this.$page.props.jetstream.flash?.banner || "";
		},
	},

	watch: {
		message() {
			if (!this.show) {
				this.show = true;
				let closeNotification = setTimeout(() => {
					this.show = false;
					this.$page.props.jetstream.flash.banner = null;
					clearTimeout(closeNotification);
				}, 3000);
			}
		},
	},
});
</script>
