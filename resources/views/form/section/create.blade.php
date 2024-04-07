
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
                            <h2 class="content-header-title float-left mb-0">Sections</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1"style="float:right;">
                    <a href="{{route('formQuestionSection',['formId'=>request()->input('formId')])}}">
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
                                
                                <form id="admin_form" class="form-validate" method="POST" action="{{route('formQuestionSection.store')}}" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="{{$formData->id}}">
                                    <input type="hidden" name="formId" value="{{request()->input('formId')}}">
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
                                                    <label for="Section Type">Section Type</label>
                                                    <input type="text" class="form-control" placeholder="Section Type" value="{{$formData->section_type}}" name="section_type" id="section_type" />
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
                        section_type:"required",
                    },
                    // In 'messages' user have to specify message as per rules
                    messages: {
                        title:"Please enter Title",
                        section_type:"Please enter Section Type",
                    },
                });
            })
        </script>            
@endsection