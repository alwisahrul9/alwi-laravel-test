<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>

    // Id Company
    let idCompany

    $(document).ready( function(){
      // Define Add Data Modal
      const $modalAddData = document.getElementById('addData');
      const modalAdd = new Modal($modalAddData)

      var table = $('#myTable').DataTable({
        ajax: { url: '/api/company/' },
        processing: true,
        serverside: true,
        columnDefs: [
          {
            searchable: false,
            orderable: false,
            targets: 0
          }
        ],
        order: [[1, 'asc']],
        columns: [
          { data: 'id' },
          { data: 'name' },
          { data: 'address' },
          { data: 'email' },
          {
            data: null,
            orderable: false,
            render: function (e) {
              return `
                <div class="flex">
                      <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onclick="window.location.href = '/details/${e.id}'">
                        Show
                      </button>  

                      <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                        data-id-company="${e.id}"
                        data-name-company="${e.name}"
                        data-address-company="${e.address}"
                        data-email-company="${e.email}"
                        onclick="{
                          const $modalEditData= document.getElementById('editData');
                          const modalEdit = new Modal($modalEditData)
                          modalEdit.show()
                          
                          idCompany = $(this).attr('data-id-company')

                          let name = $(this).attr('data-name-company')
                          let address = $(this).attr('data-address-company')
                          let email = $(this).attr('data-email-company')

                          $('#name_edit').val(name)
                          $('#address_edit').val(address)
                          $('#email_edit').val(email)
                        }"
                      >
                        Edit
                      </button>  

                      <button type="button" class="ms-8 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                        data-id-company="${e.id}"
                        data-name-company="${e.name}"
                        onclick="{
                          const $modalDeleteData= document.getElementById('deleteData');
                          const modalDelete = new Modal($modalDeleteData)
                          modalDelete.show()

                          idCompany = $(this).attr('data-id-company')

                          let name = $(this).attr('data-name-company')

                          $('#name_delete').html(name)
                        }"
                      >
                        Delete
                      </button>  
                </div>
              `
            }
          }
        ]
      })

      table.on('order.dt search.dt', function () {
          let i = 1;
  
          table
            .cells(null, 0, { search: 'applied', order: 'applied' })
            .every(function (cell) {
              this.data(i++);
          });

      }).draw();

      // Show add data modal function
      $("#addModal").click(function(){
        modalAdd.show()
      })

      // Function Form create / add employee
      $("#form").on("submit", async function(event){
        event.preventDefault();

        let data = {
          name: $("#name").val(),
          address: $("#address").val(),
          email: $("#email").val(),
        }

        const response = await axios.post('/api/company/', data)
        
        if(response.data.message === 'success'){
          table.ajax.reload()
          modalAdd.hide()
          $("#name").val("")
          $("#address").val("")
          $("#email").val("")
        } else {
          alert("Failed!")
        }
      })
      
      // Function Form create / add employee
      $("#formEdit").on("submit", async function(event){
        event.preventDefault();
        // Define edit data modal
        const $modalEditData= document.getElementById('editData');
        const modalEdit = new Modal($modalEditData)

        let data = {
          name: $("#name_edit").val(),
          address: $("#address_edit").val(),
          email: $("#email_edit").val(),
        }

        const response = await axios.post(`/api/company/${idCompany}`, data)
        
        if(response.data.message === 'success'){
          table.ajax.reload()
          modalEdit.hide()
          $("#name_edit").val("")
          $("#address_edit").val("")
          $("#email_edit").val("")
        } else {
          alert("Failed!")
        }
      })


      // Variable setInterval
      let timer
      
      // Function delete company
      $("#deleteCompany").click(function(){
        $("#decisionBtn").addClass("hidden")
        $("#cancelDeteleBtn").removeClass("hidden")
        $("#time").removeClass('hidden')
        
        // Time duration
        let time = 11

        // Play setInterval
        timer = setInterval(() => {
          time--
          $("#time").html(time)

          if(time === 1){
            clearInterval(timer)
            
            axios.delete(`/api/company/${idCompany}`)
            .then(response => {
              // Define delete modal
              const $modalDeleteData= document.getElementById('deleteData');
              const modalDelete = new Modal($modalDeleteData)

              // Hiding modal
              modalDelete.hide()
              $("#decisionBtn").removeClass("hidden")
              $("#cancelDeteleBtn").addClass("hidden")
              $("#time").addClass('hidden').html('')

              // Reload Table
              table.ajax.reload()
            })
            .catch(error => {
              console.log(error);
            })
          }
        }, 1000);
      })

      // Cancel delete function
      $("#cancelDeteleBtn").click(function(){
        // Define delete modal
        const $modalDeleteData= document.getElementById('deleteData');
        const modalDelete = new Modal($modalDeleteData)

        // Hiding modal
        modalDelete.hide()
        $("#decisionBtn").removeClass("hidden")
        $("#cancelDeteleBtn").addClass("hidden")
        $("#time").addClass('hidden').html('')

        // Stop interval
        clearInterval(timer)

        // Re-null timer variable
        timer = null
      })
    })

</script>