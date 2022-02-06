<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Owner {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <br>
    <div class="container">
        <a href="/add-employee" class="btn btn-primary">Add Employee</a>
        <br><br>
        <div>
            <table class="table table-active">
                @foreach($employee_list as $employee)
                    <tr>
                        <td>
                            <a href="/employee/record/{{$employee->id}}">{{$employee->username}}</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <br><br>
    <div class="container">
        @if ($single_employee_record)
            <div>
                <div>
                    <label for="username">User Name:</label>
                    <h4><b>{{$name->username}}<b></h4>
                </div>
                <table class="table table-striped" style="align-items: center;">
                    <tr>
                        <th>Date</td>
                        <th>Check in</td>
                        <th>Check out</td>
                        <th>Office Hour</td>
                    </tr>
                    @for($i = 0; $i< sizeof($all_record); $i++)
                        <tr>
                            <td>{{$all_record[$i][0]}}</td>
                            <td>{{$all_record[$i][1]}}</td>
                            <td>{{$all_record[$i][2]}}</td>
                            <td>{{$all_record[$i][3]}}</td>
                        </tr>
                    @endfor
                </table>
            </div>
        @else
            <div class="dropdown" aria-labelledby="navbarDropdown">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    {{$selected_date}}
                </button>
                <div class="dropdown-menu pull-center">
                    @foreach ($date_list as $date)
                        @if ($selected_date != $date->date)
                            <a class="dropdown-item" href="/employees/records/{{$date->date}}">{{$date->date}}</a>
                        @endif 
                    @endforeach
                </div>
            </div>
            <br>
            <div>
                <table class="table table-striped" style="align-items: center;">
                    <tr>
                        <th>User Name</td>
                        <th>Check in</td>
                        <th>Check out</td>
                        <th>Office Hour</td>
                    </tr>
                    @for($i = 0; $i< sizeof($all_record); $i++)
                        <tr>
                            <td>{{$all_record[$i][0]->username}}</td>
                            <td>{{$all_record[$i][1]}}</td>
                            <td>{{$all_record[$i][2]}}</td>
                            <td>{{$all_record[$i][3]}}</td>
                        </tr>
                    @endfor
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
