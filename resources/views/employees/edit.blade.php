@extends('employees.layout')
@section('content')
    <div class="card" style="margin: 20px;">
        <div class="card-header">Edit Employee</div>
        <div class="card-body">

            <form action="{{ route('employees.update', $employee->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label>Name</label></br>
                <input type="text" name="name" id="name" class="form-control" value="{{ $employee->name }}"></br>
                <label>Address</label></br>
                <input type="text" name="address" id="address" class="form-control" value="{{ $employee->address }}"></br>
                <label>Mobile</label></br>
                <input type="text" name="mobile" id="mobile" class="form-control" value="{{ $employee->mobile }}"></br>
                <input class="form-control" name="photo" type="file" id="photo">

                <input type="submit" value="Save" class="btn btn-success"></br>
            </form>

        </div>
    </div>
@stop