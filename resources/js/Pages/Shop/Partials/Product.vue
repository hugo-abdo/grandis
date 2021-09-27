<template>
	<card class="p-0 overflow-hidden border border-b-0 dark:border-none">
		<div class="mx-auto pb-[100%] relative overflow-hidden">
			<img
				class="w-full h-full object-cover absolute top-0"
				alt="admin image"
				src="http://grandis.test/storage/products/product-01.jpg"
			/>
			<span class="absolute inset-0 bg-gradient-to-t from-coolGray-600 via-transparent"></span>
			<div class="absolute bottom-3 w-full text-white font-semibold px-2">
				<div class="flex justify-between items-center">
					<span class="text-xs">(15)⭐⭐⭐⭐⭐</span>
					<span>55$</span>
				</div>
			</div>
		</div>
		<div class="p-2">
			<div class="font-medium text-gray-500 dark:text-gray-200 truncate">
				<span>Basic Tee</span>
			</div>
			<p class="text-gray-400 truncate text-xs">On Retina display that never sleeps, so it’s easy to see the time and other important information, without raising or tapping</p>
		</div>
		<div class="grid grid-cols-2 tracking-wider font-medium text-sm">
			<span class="text-center dark:text-gray-200 text-gray-600 p-1.5 duration-200 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer">
				<i class="las la-heart text-red-500"></i>
				Wishlist
			</span>
			<button class="bg-groadis text-white hover:bg-indigo-500 p-1.5"><i class="las la-shopping-cart"></i>Add to Cart</button>
		</div>
	</card>
</template>
<script>
import { defineComponent } from "vue";

export default defineComponent({
	setup() {},
});
</script>
