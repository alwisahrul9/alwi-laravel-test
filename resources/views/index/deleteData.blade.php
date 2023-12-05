<div id="deleteData" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-3 text-lg font-normal text-black dark:text-gray-400">Do you want delete <span id="name_delete" class="fw-semibold"></span>?</h3>
                <p class="mb-5 text-black dark:text-white font-base text-lg">*If you delete this data, all employees data in this company will be removed</p>
                <p class="dark:text-white font-semibold text-lg" id="time"></p>
                <div class="flex justify-center w-full" id="decisionBtn">
                    <button id="deleteCompany" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                        Yes, I'm sure
                    </button>
                    <button type="button" onclick="{
                        // Define delete data modal
                        const $modalDeleteData= document.getElementById('deleteData');
                        const modalDelete = new Modal($modalDeleteData)
                        // Hiding modal
                        modalDelete.hide()
                    }"
                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                    >
                      No, cancel
                    </button>
                </div>
                <div class="w-full hidden mt-5" id="cancelDeteleBtn">
                    <button class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>