
@extends('layouts.app-master')

@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Transfer User</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3 mb-1"style="float:right;">
                    <a href="{{route('tournament')}}">
                        <button class="dt-button btn btn-primary btn-add-record ml-2" tabindex="0" aria-controls="DataTables_Table_0" type="button" style="float:right;">
                            <span><i data-feather="list"></i> List All</span>
                        </button> 
                    </a>
                </div> -->
            </div>
         
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card ">

                            <div class="card-header">
                            </div>

                            <div class="card-body">
                                
                                <form id="admin_form" class="form-validate" method="POST" action="{{route('user.transferStore')}}" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="{{$formData->id}}">

                                    @csrf    
                                    <div class="row">
                                            

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="category">User</label>
                                                    <select class="form-control" name="userId" id="userId">
                                                        <option value="">Select</option>
                                                        @if(isset($users))
                                                            @foreach($users as $val)
                                                                <option value="{{$val->id}}" {{$formData->id==$val->id ? "selected" : ''}}>{{$val->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save</button>
                                            </div>

                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    
@endsection

@section('javascript')
        <script>
            $(document).ready(function(){

                $("#admin_form").validate({
                    
                    // In 'rules' user have to specify all the
                    // constraints for respective fields
                    rules: {
                        userId:"required",
                       
                    },
                    // In 'messages' user have to specify message as per rules
                    messages: {
                        userId:"Please select User.",
                       
                    }
                });

 
            })
        </script>            
@endsection