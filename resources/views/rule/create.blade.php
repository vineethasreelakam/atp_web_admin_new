
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
                            <h2 class="content-header-title float-left mb-0">Rules</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1"style="float:right;">
                    <a href="{{route('rule')}}">
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
                                
                                <form id="admin_form" class="form-validate" method="POST" action="{{route('rule.store')}}" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="{{$formData->id}}">
                                    @csrf    
                                    <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="title">Rule Code</label>
                                                    <input type="text" class="form-control" placeholder="rule_code" value="{{$formData->rule_code}}" name="rule_code" id="rule_code" />
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="Section Type">Value 1</label>
                                                    <input type="text" class="form-control" placeholder="Value 1" value="{{$formData->value_1}}" name="value_1" id="value_1" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="Section Type">Value 2</label>
                                                    <input type="text" class="form-control" placeholder="Value 2" value="{{$formData->value_2}}" name="value_2" id="value_2" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="Section Type">Value 3</label>
                                                    <input type="text" class="form-control" placeholder="Value 3" value="{{$formData->value_3}}" name="value_3" id="value_3" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="Section Type">Value 4</label>
                                                    <input type="text" class="form-control" placeholder="Value 4" value="{{$formData->value_4}}" name="value_4" id="value_4" />
                                                </div>
                                            </div> -->
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="Section Type">Description</label>
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
               /*  $("#admin_form").validate({
                    
                    // In 'rules' user have to specify all the
                    // constraints for respective fields
                    rules: {
                        rule_code:"required",
                        value_1:"required",
                        value_2:"required",
                        value_3:"required",
                        value_4:"required",
                        description:"required",
                    },
                    // In 'messages' user have to specify message as per rules
                    messages: {
                        rule_code:"Please Enter Rule Code",
                        value_1:"Please Enter Value 1",
                        value_2:"Please Enter Value 2",
                        value_3:"Please Enter Value 3",
                        value_4:"Please Enter Value 4",
                        description:"Please Enter Description",
                    },
                }); */
            })
        </script>            
@endsection