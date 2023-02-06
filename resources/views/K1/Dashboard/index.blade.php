@extends('K1.Layout.app_admin')
@section('title')
 Dashboard
@endsection
@section('dashboard')
    <div class="cards">
        <div class="card">
            <div class="card-container">
                <div class="number">105</div>
                <div class="card-name">Appointment</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-briefcase-medical"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-container">
                <div class="number">14</div>
                <div class="card-name">Pattient</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-wheelchair"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-container">
                <div class="number">8</div>
                <div class="card-name">Operations</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-bed"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-container">
                <div class="number">$1438</div>
                <div class="card-name">Earning</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
@endsection

@section('table_content')
    <div class="tables" style="margin-top:-80px;">
        <div class="last-appointments">
            <div class="heading">
                <h2>Last Appointments.....</h2>
                <a href="#" class="btn">View all</a>
            </div>
            <table class="appointmens">
                <thead>
                    <td>Name</td>
                    <td>Doctor</td>
                    <td>Conditions</td>
                    <td>Actions</td>
                </thead>
                <tbody>
                    <tr>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>
                            <a href=""><i class="far fa-eye"></i></a>
                            <a href=""><i class="far fa-edit"></i></a>
                            <a href=""><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>
                            <a href=""><i class="far fa-eye"></i></a>
                            <a href=""><i class="far fa-edit"></i></a>
                            <a href=""><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>Sam boker</td>
                        <td>
                            <i class="far fa-eye"></i>
                            <i class="far fa-edit"></i>
                            <i class="far fa-trash-alt"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="doctor-visiting">
            <div class="heading">
                <h2>Last Visiting.....</h2>
                <a href="#" class="btn">View all</a>
            </div>
            <table class="visiting">
                <thead>
                    <td>Photo</td>
                    <td>Name</td>
                    <td>Visit Time</td>
                    <td>Details</td>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="img-box-small">
                                <img src="{{asset('css/img/user3.png')}}" alt="">
                            </div>
                        </td>
                        <td>Ddddd</td>
                        <td>03.23</td>
                        <td>
                            <i class="far fa-eye"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="img-box-small">
                                <img src="{{asset('css/img/user3.png')}}" alt="">
                            </div>
                        </td>
                        <td>Ddddd</td>
                        <td>03.23</td>
                        <td>
                            <i class="far fa-eye"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection