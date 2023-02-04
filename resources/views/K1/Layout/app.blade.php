<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/824/824727.png" />
    <link rel="stylesheet" href="{{ asset('bootstrap-5/css/bootstrap.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
</head>
<body>
    <style>
       
        .footer{
            background-color: pink;
        }
    </style>
    @section('sidebar')
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid" style="justify-content: flex-end !important;">
             <a href="#" id="" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</a>
        </div>
      </nav>
    @show
    <div class="container">
        @yield('content')
        
    </div>
    <div class="footer">
        @yield('footer')
    </div>
    <!-- ! modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <span class="text-danger d-none" id="notif_login">Email or password is failed</span><br>
                    <label for="email_k1" class="form-label">Email address</label>
                    <input type="email_k1" class="form-control" id="id_email" aria-describedby="email_k1">
                  </div>
                <div class="mb-3">
                    <label for="passowrd_k1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="id_password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_login" class="btn btn-primary">Login</button>
            </div>
            </div>
        </div>
    </div>
    <!--- !-->
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="{{ asset('bootstrap-5/js/bootstrap.min.js') }}"></script>
    <script>
        const btn_login = document.getElementById('btn_login')
        btn_login.addEventListener("click", function(){
            $.ajax({
                url: "{{route('login_userK1')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": $('#id_email').val(),
                    "password": $("#id_password").val(),
                },
                success(resp){
                   const msg = resp.message
                   if (msg == 'Login success') {
                        const notif = document.getElementById('notif_login');
                        notif.classList.add("d-none");
                        //set token, role_user with local storage
                        localStorage.setItem("token_login", resp.token);
                        window.location.href = '{{route("admin_k1_web")}}'
                   }else{
                        const notif = document.getElementById('notif_login');
                        notif.classList.remove("d-none");
                   }
                },
                error(err){
                    const notif = document.getElementById('notif_login');
                    notif.classList.remove("d-none");
                }
            });
        }); 
    </script>
</body>
</html>