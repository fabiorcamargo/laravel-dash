<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

  <div id="modal" x-data="{ modelOpen: true }">

  
      <div id="modal" x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
          <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
              <div x-cloak  x-show="modelOpen" 
                  x-transition:enter="transition ease-out duration-300 transform"
                  x-transition:enter-start="opacity-0" 
                  x-transition:enter-end="opacity-100"
                  x-transition:leave="transition ease-in duration-200 transform"
                  x-transition:leave-start="opacity-100" 
                  x-transition:leave-end="opacity-0"
                  class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"
              ></div>
  
              <div x-cloak x-show="modelOpen" 
                  x-transition:enter="transition ease-out duration-300 transform"
                  x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                  x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                  x-transition:leave="transition ease-in duration-200 transform"
                  x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                  x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                  class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
              >
                  <div class="flex items-center justify-between space-x-4">
                      <h1 class="text-xl font-medium text-gray-800 ">@yield('title-modal')</h1>
  
                      <div id="b2"  class="text-gray-600 focus:outline-none hover:text-gray-700">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                        </div>
                  </div>
  
                  <p class="mt-2 text-sm text-gray-500 ">
                    @yield('desc-modal')
                  </p>
  
 
                      
                      <div class="flex justify-end mt-6">
                          <button id="b3" type="button" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                              Fechar
                          </button>
                      </div>
                  
              </div>
          </div>
      </div>
  </div>



  <script type="text/javascript">

    window.onload = function() {closeModal('modal')}


    let btn = document.getElementById("b3");
    
    btn.onclick = function() {closeModal('modal')}
    
    window.openModal = function(modalId) {
      document.getElementById(modalId).style.display = 'block'
      document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden')
    }
    
    window.closeModal = function(modalId) {
      document.getElementById(modalId).style.display = 'none'
      document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
    }
    
    // Close all modals when press ESC
    document.onkeydown = function(event) {
      event = event || window.event;
      if (event.keyCode === 27) {
        document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
        let modals = document.getElementsByClassName('modal');
        Array.prototype.slice.call(modals).forEach(i => {
          i.style.display = 'none'
        })
      }
    };
    </script>