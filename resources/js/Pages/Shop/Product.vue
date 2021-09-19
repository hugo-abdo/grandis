<template>
	<card class="p-0 overflow-hidden border dark:border-none">
		<div class="mx-auto pb-[100%] relative overflow-hidden">
			<img
				class="w-full h-full object-cover absolute top-0"
				alt="admin image"
				src="/storage/products/product-01.jpg"
			/>
			<span class="absolute inset-0 bg-gradient-to-t from-coolGray-600 via-transparent"></span>
			<div class="absolute bottom-3 w-full text-white font-semibold px-2">
				<div class="flex justify-between items-center">
					<span
						class="text-gray-50 cursor-pointer left-4 px-1 rounded-lg shadow-md active:shadow-none bg-gradient-to-br from-groadis to-indigo-300"
					>
						<i class="las la-cart-plus text-2xl"></i>
					</span>
					<span class="text-xs">(15)⭐⭐⭐⭐⭐</span>
				</div>
			</div>
		</div>
		<div class="p-2">
			<div class="flex justify-between items-center font-medium text-gray-500 dark:text-gray-200">
				<span>Basic Tee</span>
				<span>55$</span>
			</div>
			<p
				class="text-gray-400 truncate text-xs"
			>On Retina display that never sleeps, so it’s easy to see the time and other important information, without raising or tapping</p>
		</div>
	</card>
</template>
<script>
import { defineComponent } from "vue";

export default defineComponent({
	setup() {},
});
</script>
