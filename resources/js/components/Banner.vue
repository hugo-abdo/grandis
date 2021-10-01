<template>
	<div
		v-if="banner.bannerStyle == 'notification'"
		class="flex w-full border dark:border-groadis-darker max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800"
	>
		<div class="w-2 bg-groadis"></div>

		<div class="flex items-center px-2 py-2">
			<div class="w-10 h-10 rounded-full overflow-hidden">
				<img
					class="object-cover w-full h-full "
					alt="User avatar"
					:src="banner.user.profile_photo_url"
				>
			</div>

			<div class="mx-3">
				<p class="text-gray-600 dark:text-gray-200">
					<a class="text-blue-500 dark:text-blue-300 hover:text-blue-400 hover:underline">{{banner.user.name}}</a>
					{{banner.banner}}
				</p>
			</div>
		</div>
	</div>
	<div
		v-else
		:class="{
					'shadow-md bg-white dark:bg-groadis-dark border rounded-lg overflow-hidden flex w-full max-w-xs':true,
					'border-green-300':banner.bannerStyle == 'success',
					'border-red-500': banner.bannerStyle == 'error',
					'border-blue-500': banner.bannerStyle == 'info',
					'border-yellow-500': banner.bannerStyle == 'warning',
				}"
	>
		<div :class="[
						'flex items-center justify-center w-12',
							{
								'bg-green-300': banner.bannerStyle == 'success',
								'bg-red-500': banner.bannerStyle == 'error',
								'bg-blue-500': banner.bannerStyle == 'info',
								'bg-yellow-500': banner.bannerStyle == 'warning',
							}
						]">
			<banner-icon :type="banner.bannerStyle" />
		</div>
		<div class="px-4 py-2 -mx-3">
			<div class="mx-3 text-sm tracking-wider capitalize ">
				<span :class="[
							'font-semibold',
								{
									'text-green-300':banner.bannerStyle == 'success',
									'text-red-500': banner.bannerStyle == 'error',
									'text-blue-500': banner.bannerStyle == 'info',
									'text-yellow-500': banner.bannerStyle == 'warning',
								}
							]">{{banner.bannerStyle}}</span>
				<p class="text-gray-600 font-medium dark:text-gray-200">{{banner.banner}}</p>
			</div>
		</div>
	</div>
</template>

<script>
import { defineComponent } from "vue";
import BannerIcon from "./BannerIcon.vue";

export default defineComponent({
	components: { BannerIcon },
	props: ["banner"],
	created() {
		setTimeout(() => {
			this.$emit("removeFromeList", this.banner.id);
		}, 5000);
	},
});
</script>
