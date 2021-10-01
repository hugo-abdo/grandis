<template>
	<span
		class="block duration-200 bg-gray-200 dark:bg-groadis-darker overflow-hidden"
		v-if="active"
	>
		<span class="bg-white duration-200 dark:bg-groadis-dark block p-1 rounded-br-lg"></span>
	</span>
	<div :class="[
			'text-gray-500 dark:text-gray-300 w-full duration-200',
			active ?'bg-gray-200 dark:bg-groadis-darker rounded-l-lg shadow-r text-groadis' : ''
			]">
		<slot />
	</div>
	<span
		class="block duration-200 bg-gray-200 dark:bg-groadis-darker overflow-hidden"
		v-if="active"
	>
		<span class="bg-white duration-200 dark:bg-groadis-dark block p-1 rounded-tr-lg"></span>
	</span>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
	props: ["active"],
});
</script>
