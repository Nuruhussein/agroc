<template>
    <section class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 py-20">
        <div class="container flex flex-col items-center px-4 mx-auto text-center">
            <h2 class="text-4xl font-bold tracking-tight text-gray-900 xl:text-5xl dark:text-white">
                Join Our Marketplace Today
            </h2>

            <p class="block max-w-3xl mt-6 text-xl text-gray-600 dark:text-gray-300">
                Connect directly with local farmers or buyers. Experience a seamless agricultural marketplace designed for modern needs.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 mt-12 w-full sm:w-auto">
                <a
                    href="#"
                    class="relative inline-flex items-center justify-center px-8 py-4 overflow-hidden text-lg font-medium text-white transition-all duration-300 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl group hover:from-green-600 hover:to-emerald-700 focus:ring-4 focus:ring-emerald-300 focus:ring-opacity-80 shadow-lg hover:shadow-emerald-500/20"
                >
                    <span class="absolute top-0 right-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-emerald-700 rounded group-hover:-mr-4 group-hover:-mt-4">
                        <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
                    </span>
                    <span class="absolute bottom-0 left-0 w-full h-full transition-all duration-500 ease-in-out delay-200 -translate-x-full translate-y-full bg-emerald-600 rounded-2xl group-hover:mb-12 group-hover:translate-x-0"></span>
                    <span class="relative w-full text-left flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        Register as Farmer
                    </span>
                </a>

                <a
                    href="#"
                    class="relative inline-flex items-center justify-center px-8 py-4 overflow-hidden text-lg font-medium text-white transition-all duration-300 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl group hover:from-blue-600 hover:to-indigo-700 focus:ring-4 focus:ring-blue-300 focus:ring-opacity-80 shadow-lg hover:shadow-blue-500/20"
                >
                    <span class="absolute top-0 right-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-indigo-700 rounded group-hover:-mr-4 group-hover:-mt-4">
                        <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
                    </span>
                    <span class="absolute bottom-0 left-0 w-full h-full transition-all duration-500 ease-in-out delay-200 -translate-x-full translate-y-full bg-indigo-600 rounded-2xl group-hover:mb-12 group-hover:translate-x-0"></span>
                    <span class="relative w-full text-left flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Register as Buyer
                    </span>
                </a>
            </div>

            <div class="mt-16 text-gray-500 dark:text-gray-400">
                <p class="text-sm">Already have an account? <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">Sign in here</a></p>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "Cta",
};
</script>

<style scoped>
/* Animation for the button hover effect */
.group:hover .group-hover\:translate-x-0 {
    transform: translateX(0);
}
.group:hover .group-hover\:-mr-4 {
    margin-right: -1rem;
}
.group:hover .group-hover\:-mt-4 {
    margin-top: -1rem;
}
</style>