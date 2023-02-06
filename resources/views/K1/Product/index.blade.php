@extends('K1.Layout.app_admin')
@section('title')
 Product
@endsection

@section('table_content')

<div class="tables">
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

