
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
                            <h2 class="content-header-title float-left mb-0">Form</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1"style="float:right;">
                    <a href="{{route('form')}}">
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
                                
                                <form id="admin_form" class="form-validate" method="POST" action="{{route('form.store')}}" enctype="multipart/form-data">
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
                                                    <label for="">Image<span style="color:red">*</span></label>
                                                    @if($formData->image!='')
                                                        </br>
                                                        <img src="{{asset('public/uploads/form/'.$formData->image)}}" height="100px" width="100px"><a href="{{route('form.imageDelete',$formData->id)}}" class="btn btn-danger">Delete</a>
                                                        <input type="hidden" name="image" value="{{$formData->image}}">
                                                    @else
                                                        <input type="file" name="image"  class="form-control image" id="image">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" placeholder="Description" name="description" id="description">{{$formData->description}}</textarea>
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
                        title:"required",
                        image:"required",
                        description:"required",
                    },
                    // In 'messages' user have to specify message as per rules
                    messages: {
                        title:"Please enter Title",
                        image:"Please upload an Image",
                        description:"Please enter description",
                    }
                });
            })
        </script>            
@endsection