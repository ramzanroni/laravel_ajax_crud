<html>
    <head>
        <title>Ajax CRUD</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        {{-- <script src="sweetalert2.all.min.js"></script> --}}
        {{-- <script src="sweetalert2.min.js"></script>
        <link rel="stylesheet" href="sweetalert2.min.css"> --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-8 float-left">
                    <div class="card">
                        <div class="card-header">
                            Teacher List
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Institute</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 float-left">
                    <div class="card">
                        <div class="card-header">
                            <span id="add_teacher">Add Teacher</span>
                            <span id="up_teacher">Update Teacher</span>
                        </div>
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="name" placeholder="Enter Your Name">
                                <label for="floatingInput">Name</label>
                                <span class="text-danger" id="errorName"></span>
                              </div>
                              <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="title" placeholder="Enter Your Title">
                                <label for="title">Title</label>
                                <span class="text-danger" id="errorTitle"></span>
                              </div>
                              <input type="text" id="id" hidden>
                              <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Enter Your Institute Info" id="institute" style="height: 100px"></textarea>
                                <label for="institute">Institute</label>
                                <span class="text-danger" id="errorInstitute"></span>
                              </div>
                              <button type="submit" id="add_btn" class="btn btn-primary" onclick="addData()">Add</button>
                              <button type="submit" id="update_btn" class="btn btn-primary" onclick="update_btn()">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("#add_teacher").show();
            $("#up_teacher").hide();
            $("#add_btn").show();
            $("#update_btn").hide();

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            function allData(){
                $.ajax({
                    type: "GET",
                    url: "/teacher/all",
                    success: function(respons){
                        var data='';
                        $.each(respons, function(key, value){
                            data= data+"<tr>";
                                data= data+"<td>"+value.name+"</td>";
                                data= data+"<td>"+value.title+"</td>";
                                data= data+"<td>"+value.institute+"</td>";
                                data= data+"<td>"
                                data= data+"<button class='btn btn-primary m-1' onclick='update_data("+value.id+")'>Edit</button>";
                                data=data+"<button class='btn btn-danger' onclick=delete_data("+value.id+")>Delete</button>"
                                data=data+"</td>";
                            data=data+"</tr>"
                        })
                        
                       $("tbody").html(data);
                    }

                })
            }
            allData();
            function clearData()
            {
                $("#name").val('');
                $("#title").val('');
                $("#institute").val('');
                $("#errorName").text('');
                $("#errorTitle").text('');
                $("#errorInstitute").text('');
            }
            function addData()
            {
                let name=$("#name").val();
                let title=$("#title").val();
                let institute=$("#institute").val();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    data: {
                        name:name,
                        title:title,
                        institute:institute
                    },
                    url: "/teacher/store",
                    success: function(data)
                    {
                        console.log(data);
                        clearData();
                        allData();
                        Swal.fire({
                            toast:true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data Add Success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        
                    },
                    error:function(error)
                    {
                        $("#errorName").text(error.responseJSON.errors.name);
                        $("#errorTitle").text(error.responseJSON.errors.title);
                        $("#errorInstitute").text(error.responseJSON.errors.institute);
                    }

                })
            }
            function update_data(id)
            {
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: '/edit_data/'+id,
                    success: function(data){
                        $("#add_teacher").hide();
                        $("#up_teacher").show();
                        $("#add_btn").hide();
                        $("#update_btn").show();
                        $("#id").val(data.id);
                        $("#name").val(data.name);
                        $("#title").val(data.title);
                        $("#institute").val(data.institute);
                    }
                })
            }
            function update_btn()
            {
                let name=$("#name").val();
                let title=$("#title").val();
                let institute=$("#institute").val();
                let id=$("#id").val();
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: '/add_edit_data',
                    data: {
                        id:id,
                        name:name,
                        title:title,
                        institute:institute
                    },
                    success: function(response)
                    {
                        $("#add_teacher").show();
                        $("#up_teacher").hide();
                        $("#add_btn").show();
                        $("#update_btn").hide();
                        clearData();
                        allData();
                        Swal.fire({
                            toast:true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data Update Success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        //console.log(response);
                    },
                    error: function(error)
                    {
                        $("#errorName").text(error.responseJSON.errors.name);
                        $("#errorTitle").text(error.responseJSON.errors.title);
                        $("#errorInstitute").text(error.responseJSON.errors.institute);
                    }
                })
            }
            function  delete_data(id) {           
                Swal.fire({
                toast:true,
                
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: '/delete_data/'+id,
                    success: function(data){
                        console.log(data);
                        allData();
                    }
                })
                Swal.fire({
                            toast:true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data Update Success',
                            showConfirmButton: false,
                            timer: 1500
                })
            }     
        })
              
    }

            
        </script>
    </body>
</html>