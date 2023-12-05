<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>

    // Id Company (get from parameter route)
    let id = {{ Js::from($id) }}

    // Id Employee
    let idEmployee

    $(document).ready( async function(){
        // Define add data modal
        const $modalAddData = document.getElementById('addData');
        const modalAdd = new Modal($modalAddData)

        const response = await axios.get(`/api/company/${id}`)
        const data = response.data.data
        $("#company_name").html(response.data.data.name)
        
        var table = $('#myTable').DataTable({
            ajax: {
              url: `/api/company/${id}`,
              dataSrc: 'data.employees'
            },
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
                { data: 'first_name' },
                { data: 'last_name' },
                { data: 'email' },
                { data: 'phone' },
                {
                  data: null,
                  orderable: false,
                  render: function (e) {
                    return `
                      <div class="flex">
                            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                              data-id-employee="${e.id}"
                              data-fsName-employee="${e.first_name}"
                              data-lsName-employee="${e.last_name}"
                              data-email-employee="${e.email}"
                              data-phone-employee="${e.phone}"
                              onclick="{
                                const $modalEditData= document.getElementById('editData');
                                const modalEdit = new Modal($modalEditData)
                                modalEdit.show()

                                idEmployee = $(this).attr('data-id-employee')

                                let fs_name = $(this).attr('data-fsName-employee')
                                let lsName = $(this).attr('data-lsName-employee')
                                let email = $(this).attr('data-email-employee')
                                let phone = $(this).attr('data-phone-employee')

                                $('#first_name_edit').val(fs_name)
                                $('#last_name_edit').val(lsName)
                                $('#email_edit').val(email)
                                $('#phone_edit').val(phone)
                              }"
                            >
                              Edit
                            </button>

                            <button type="button" class="ms-8 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 ms-5"
                              data-id-employee="${e.id}"
                              data-fsName-employee="${e.first_name}"
                              data-lsName-employee="${e.last_name}"
                              onclick="{
                                const $modalDeleteData= document.getElementById('deleteData');
                                const modalDelete = new Modal($modalDeleteData)
                                modalDelete.show()

                                idEmployee = $(this).attr('data-id-employee')

                                let fs_name = $(this).attr('data-fsName-employee')
                                let lsName = $(this).attr('data-lsName-employee')

                                $('#first_name_delete').html(fs_name)
                                $('#last_name_delete').html(lsName)
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

        // Show add data modal
        $("#addModal").click(function(){
          modalAdd.show()
        })

        // Function Form create / add employee
        $("#form").on("submit", async function(event){
          event.preventDefault();

          let data = {
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            email: $("#email").val(),
            phone: $("#phone").val(),
            company_id: $("#company_id").val(),
          }
          
          const response = await axios.post('/api/employee/', data)
          
          if(response.data.message === 'success'){
            table.ajax.reload()
            modalAdd.hide()
            $("#first_name").val("")
            $("#last_name").val("")
            $("#email").val("")
            $("#phone").val("")
          } else {
            $("#alertAddData").removeClass('hidden')
            $("#msgError").html(response.data.message.phone[0])
          }
        })

        // Function Form Edit Employee
        $("#formEdit").on("submit", async function(event){
          event.preventDefault();
          const $modalEditData= document.getElementById('editData');
          const modalEdit = new Modal($modalEditData)

          let data = {
            first_name: $("#first_name_edit").val(),
            last_name: $("#last_name_edit").val(),
            email: $("#email_edit").val(),
            phone: $("#phone_edit").val(),
            company_id: $("#company_id_edit").val(),
          }
          
          const response = await axios.post(`/api/employee/${idEmployee}`, data)
          
          if(response.data.message === 'success'){
            table.ajax.reload()
            modalEdit.hide()
            $("#first_name_edit").val("")
            $("#last_name_edit").val("")
            $("#email_edit").val("")
            $("#phone_edit").val("")

          } else {
            alert("Failed!")
          }
        })

        // Function Form Delete Employee
        $("#deleteEmployee").click(async function(){
          // Define delete modal
          const $modalDeleteData= document.getElementById('deleteData');
          const modalDelete = new Modal($modalDeleteData)

          const response = await axios.delete(`/api/employee/${idEmployee}`)
              
          if(response.data.message === 'success'){
            table.ajax.reload()
            modalDelete.hide()
    
          } else {
            alert("Failed!")
          }
        })
    })

</script>