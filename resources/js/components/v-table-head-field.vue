<template>
	<slot
		:searchIsActive="searchIsActive"
		:toggleActiveSearch="toggleActiveSearch"
	/>
</template>

<script>
	export default {
		data() {
			return {
				searchIsActive: false,
			};
		},
		methods: {
			toggleActiveSearch() {
				this.searchIsActive = !this.searchIsActive;
			},
		},
	};
</script>
