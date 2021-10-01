<template>
	<div class="max-w-sm mx-auto min-h-screen py-10 lg:max-w-4xl flex justify-center items-center ">
		<div class="w-full flex overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
			<div
				class="hidden bg-cover lg:flex lg:w-1/2  items-center justify-center"
				style="background-image:url('/assets/images/photo-1606660265514-358ebbadc80d.jpg')"
			>
				<div class="dark:bg-gray-900 bg-gray-50 shadow !bg-opacity-50 w-11/12 py-5 rounded-lg">
					<slot name="logo" />
				</div>
			</div>
			<div class="w-full px-6 py-8 md:px-8 lg:w-1/2">
				<slot />
			</div>
		</div>
	</div>
</template>
