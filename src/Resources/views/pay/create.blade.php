@extends('adminlte::master')
@section('body')
    @if( Session::has('success_message') )
        <div class="alert alert-success m-2">{{ Session::get('success_message') }}</div>
    @endif
    @if( Session::has('failed_message') )
        <div class="alert alert-danger m-2">{{ Session::get('failed_message') }}</div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-5">
                <form action="{{route('pay.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="amount">姓名</label>
                        <input type="number" name="amount" value="@error('amount'){{old('amount')}}@enderror" class="form-control @error('amount') is-invalid @else is-valid @enderror">
                        @error('amount')
                        <div id="amount_feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <input type="submit" value="保存" class="btn btn-success float-left">
                </form>
            </div>
        </div>
    </div>
@stop

