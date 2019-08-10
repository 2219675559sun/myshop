@extends('ceshi.real.commect')

@section('title', '添加车位信息')
<div clign="certen">
    @section('body')
        <form action="{{url('real/add_carport_do')}}">
            @csrf
            <input type="text" name="number" style="width:500px;height: 50px;"><br>
            <input type="submit" value="添加车位信息">
        </form>
    @endsection
</div>
