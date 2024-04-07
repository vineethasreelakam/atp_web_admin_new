
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
                            <h2 class="content-header-title float-left mb-0">Tournament</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1"style="float:right;">
                    <a href="{{route('tournament')}}">
                        <button class="dt-button btn btn-primary btn-add-record ml-2" tabindex="0" aria-controls="DataTables_Table_0" type="button" style="float:right;">
                            <span><i data-feather="list"></i> List All</span>
                        </button> 
                    </a>
                </div>
            </div>
         
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card ">

                            <div class="card-header">
                            </div>

                            <div class="card-body">
                                
                                <form id="admin_form" class="form-validate" method="POST" action="{{route('tournament.store')}}" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="{{$formData->id}}">

                                    @csrf    
                                    <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" placeholder="Title" value="{{$formData->title}}" name="title" id="title" />
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="tournament_date">Tournament Date</label>
                                                    <input type="text" class="form-control date" placeholder="dd/mm/yy" value="{{isset($formData->tournament_date) ? date('d-m-Y',strtotime($formData->tournament_date)) : ''}}" name="tournament_date" id="tournament_date" />
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="category">Category</label>
                                                    <select class="form-control" name="category" id="category">
                                                        <option value="">Select</option>
                                                        <option value="UNITED CUP" {{$formData->category=='UNITED CUP' ? 'selected' : ''}}>UNITED CUP</option>
                                                        <option value="ATP 250" {{$formData->category=='ATP 250' ? 'selected' : ''}}>ATP 250</option>
                                                        <option value="GRAND SLAM" {{$formData->category=='GRAND SLAM' ? 'selected' : ''}}>GRAND SLAM</option>
                                                        <option value="DAVIS CUP" {{$formData->category=='DAVIS CUP' ? 'selected' : ''}}>DAVIS CUP</option>
                                                        <option value="ATP MASTERS 1000" {{$formData->category=='ATP MASTERS 1000' ? 'selected' : ''}}>ATP MASTERS 1000</option>
                                                        <option value="ATP 500" {{$formData->category=='ATP 500' ? 'selected' : ''}}>ATP 500</option>
                                                        <option value="OLYMPICS" {{$formData->category=='OLYMPICS' ? 'selected' : ''}}>OLYMPICS</option>
                                                        <option value="LAVER CUP" {{$formData->category=='LAVER CUP' ? 'selected' : ''}}>LAVER CUP</option>
                                                        <option value="ATP FINALS" {{$formData->category=='ATP FINALS' ? 'selected' : ''}}>ATP FINALS</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" placeholder="Description" name="description" id="description" >{{$formData->description}}</textarea>
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

                
                $('.date').datepicker({
                    dateFormat: 'dd-mm-yy',
                });
               

             
                
                $("#admin_form").validate({
                    
                    // In 'rules' user have to specify all the
                    // constraints for respective fields
                    rules: {
                        title:"required",
                        
                        category:"required",
                        description:"required",
                    },
                    // In 'messages' user have to specify message as per rules
                    messages: {
                        title:"Please enter Title.",
                        
                        category:"Please enter Category.",
                        description:"Please enter Description.",
                    }
                });

 
            })
        </script>            
@endsection