<template>
	<card class="p-0 overflow-hidden">
		<div class="mx-auto pb-[100%] relative overflow-hidden">
			<img
				class="w-full h-full object-cover absolute top-0"
				alt="admin image"
				src="/storage/products/product-01.jpg"
			/>
			<span class="absolute inset-0 bg-gradient-to-t from-coolGray-600 via-transparent"></span>
			<span class="absolute bottom-3 text-white font-semibold right-4">55$</span>
			<span
				class="text-lg absolute bottom-3 text-gray-600 font-semibold left-4 px-1 bg-gray-300 rounded-lg shadow-md active:shadow-none"
			>
				<i class="las la-shopping-cart"></i>
			</span>
		</div>
		<div class="p-2">
			<div class="flex justify-between items-center">
				<span class="font-medium text-gray-500 dark:text-gray-200">Basic Tee</span>
				<span class="text-xs">(15)⭐⭐⭐⭐⭐</span>
			</div>
		</div>
	</card>
</template>

<script>
export default {};
</script>