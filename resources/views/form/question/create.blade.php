
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
                            <h2 class="content-header-title float-left mb-0">Questions</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1"style="float:right;">
                    <a href="{{route('formQuestion',['formId'=>request()->input('formId')])}}">
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
                                
                                <form id="admin_form" class="form-validate" method="POST" action="{{route('formQuestion.store')}}" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="{{$formData->id}}">
                                    <input type="hidden" name="formId" value="{{request()->input('formId')}}">
                                    @csrf    
                                    <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="title">Question</label>
                                                    <input type="text" class="form-control" placeholder="Question" value="{{$formData->question}}" name="question" id="question" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="title">Question Number</label>
                                                    <input type="text" class="form-control" placeholder="Question" value="{{$formData->question_no}}" name="question_no" id="question_no" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="Section Type">Question Section</label>
                                                    <select name="section_id" id="section_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @if(isset($questionSection))
                                                            @foreach($questionSection as $val)
                                                                <option value="{{$val->id}}" {{$formData->section_id==$val->id ? "selected" : ''}}>{{$val->title}}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="Section Type">Question Type</label>
                                                    <select name="question_type_id" id="question_type_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @if(isset($questionType))
                                                            @foreach($questionType as $val)
                                                                <option value="{{$val->id}}" valueRequired="{{$val->values_required}}" {{$formData->question_type_id==$val->id ? "selected" : ''}}>{{$val->question_type}}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group valueSection">
                                                    <!-- <label for="Section Type">Values</label> -->

                                                    <?php 
                                                        if(isset($formData->Values) && count($formData->Values) > 0){
                                                           // print_r($formData->Values);exit;
                                                            foreach($formData->Values as $val){
                                                    ?>
                                                        <div class="questionTypeValue">
                                                            <div class="row typeValue mt-1">
                                                                <label for="Section Type">Value</label>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control question_type_value" placeholder="Value" value="{{$val->option_value}}" name="question_type_value[]" />
                                                                    <input type="hidden" class="form-control" value="{{$val->id}}" name="question_type_value_id[]" />

                                                                </div>
                                                            
                                                                <div class="col-md-4">
                                                                    <a class="btn btn-danger cancel" href="javascript:void(0);">
                                                                        <i data-feather="trash-2" class="mr-50"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php     
                                                            }
                                                        }
                                                    ?>
                                                        <div id="questionTypeValuerow" style="display:none;">
                                                            <label for="Section Type">Values</label>
                                                            <div class="row typeValueRow mt-1">
                                                                
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control question_type_value" placeholder="Value"  name="question_type_value[]"/>
                                                                </div>
                                                            
                                                                <div class="col-md-4">
                                                                    <a class="btn btn-danger cancel" href="javascript:void(0);">
                                                                        <i data-feather="trash-2" class="mr-50"></i>
                                                                    </a>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                    
                                                    <div class="col-md-8 mt-1" id="add_more_button">
                                                        <a class="btn btn-primary add" href="javascript:void(0);">
                                                            <i data-feather="disc" class="mr-50"></i>
                                                            <span>Add More Value</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="Section Type">Question Rule</label>
                                                    <select name="rule_id" id="rule_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @if(isset($questionRule))
                                                            @foreach($questionRule as $val)
                                                                <!-- <option value="{{$val->id}}" ruleValueRequired="{{$val->values_required}}" {{$formData->rule_id==$val->id ? "selected" : ''}}>{{$val->rule_code}}</option> -->
                                                                <option value="{{$val->ruleId}}" ruleValueRequired="{{$val->values_required}}" {{$val->id > 0 ? "selected" : ''}}>{{$val->rule_code}}</option>

                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group ruleValueSection">
                                                    <!-- <label for="Section Type">Values</label> -->

                                                    <?php 
                                                        if(isset($formRuleValues) && count($formRuleValues)>0){
                                                            
                                                            foreach($formRuleValues as $val){
                                                    ?>
                                                        <div class="questionruleValue">
                                                            <div class="row ruleValue mt-1">
                                                                
                                                                <div class="col-md-6">
                                                                <label for="value">Value Number</label>
                                                                    <input type="text" class="form-control" value="{{$val->rule_value_no}}" name="rule_value_no[]" placeholder="Value Number" />
                                                                    <label for="value">Value</label>
                                                                    <input type="text" class="form-control question_rule_value" placeholder="Value" value="{{$val->rule_value}}" name="rule_value[]" />
                                                                    <input type="hidden" class="form-control" value="{{$val->id}}" name="question_rule_value_id[]" />

                                                                </div>
                                                            
                                                                <div class="col-md-4">
                                                                    <a class="btn btn-danger cancel" href="javascript:void(0);">
                                                                        <i data-feather="trash-2" class="mr-50"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php     
                                                            }
                                                        }
                                                    ?>
                                                        <div id="questionRuleValuerow" style="display:none;">
                                                            <label for="Section Type">Values</label>
                                                            <div class="row ruleValueRow mt-1">
                                                                
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" placeholder="Value Number" name="rule_value_no[]" placeholder="Value Number"/>
                                                                    <input type="text" class="form-control question_rule_value" placeholder="Value"  name="rule_value[]"/>
                                                                </div>
                                                            
                                                                <div class="col-md-4">
                                                                    <a class="btn btn-danger cancel" href="javascript:void(0);">
                                                                        <i data-feather="trash-2" class="mr-50"></i>
                                                                    </a>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                    
                                                    <div class="col-md-8 mt-1" id="rule_add_more_button">
                                                        <a class="btn btn-primary ruleAdd" href="javascript:void(0);">
                                                            <i data-feather="disc" class="mr-50"></i>
                                                            <span>Add More Value</span>
                                                        </a>
                                                    </div>
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
                        question:"required",
                        question_no:"required",
                        //section_id:"required",
                        question_type_id:"required",
                        //rule_id:"required",
                    },
                    // In 'messages' user have to specify message as per rules
                    messages: {
                        question:"Please Enter Qquestion",
                        question_no:"Please Enter Qquestion Number",
                        //section_id:"Please Select Question Section",
                        question_type_id:"Please Select Question Type",
                        //rule_id:"Please Select Question Rule",
                    },
                });

                $(".questionTypeValue").hide();
                $("#add_more_button").hide();
                var formData="{{count($formData->Values)}}";
                if(formData>0){
                   $(".questionTypeValue").show();
                   $("#add_more_button").show();
                }
                

                $("#question_type_id").change(function(){
                    
                    var values_required=$("#question_type_id option:selected").attr('valueRequired');
                    //alert(values_required);
                    if(values_required==1){
                        $(".questionTypeValue").remove();
                        $("#questionTypeValuerow").show();
                        $("#add_more_button").show();
                    }
                    else{
                        $(".questionTypeValue").hide();
                        $("#questionTypeValuerow").hide();
                        $("#add_more_button").hide();
                    }
                });
                
                $(".add").click(function() {
                        if(formData>0){
                            $(".typeValue")
                            .eq(0)
                            .clone()
                            .find("input").val("").end() // ***
                            .show()
                            .insertAfter(".typeValue:last");
                        }
                        else{
                            $(".typeValueRow")
                            .eq(0)
                            .clone()
                            .find("input").val("").end() // ***
                            .show()
                            .insertAfter(".typeValueRow:last");
                        }
                });

                $('.valueSection').on('click', ".cancel", function() {
                    if(formData>0){
                        var rows=$(".typeValue").length;
                        if(rows>1){
                            $(this).closest('.typeValue').remove();
                        }
                    }
                    else{
                        var rows=$(".typeValueRow").length;
                        if(rows>1){
                            $(this).closest('.typeValueRow').remove();
                        }
                    }
                });




                $(".questionruleValue").hide();
                $("#rule_add_more_button").hide();
                var questionRule="{{isset($formRuleValues) ? count($formRuleValues) : ''}}";
                //alert(questionRule);
                if(questionRule>0){
                   $(".questionruleValue").show();
                   $("#rule_add_more_button").show();
                }


                $("#rule_id").change(function(){
                    
                    var values_required=$("#rule_id option:selected").attr('ruleValueRequired');
                    //alert(values_required);
                    if(values_required==1){
                        $(".questionruleValue").remove();
                        $("#questionRuleValuerow").show();
                        $("#rule_add_more_button").show();
                    }
                    else{
                        $(".questionruleValue").hide();
                        $("#questionRuleValuerow").hide();
                        $("#rule_add_more_button").hide();
                    }
                });
                
                $(".ruleAdd").click(function() {
                        if(questionRule>0){
                            $(".ruleValue")
                            .eq(0)
                            .clone()
                            .find("input").val("").end() // ***
                            .show()
                            .insertAfter(".ruleValue:last");
                        }
                        else{
                            $(".ruleValueRow")
                            .eq(0)
                            .clone()
                            .find("input").val("").end() // ***
                            .show()
                            .insertAfter(".ruleValueRow:last");
                        }
                });

                $('.ruleValueSection').on('click', ".cancel", function() {
                    if(questionRule>0){
                        var rows1=$(".ruleValue").length;
                        if(rows1>1){
                            $(this).closest('.ruleValue').remove();
                        }      
                    }
                    else{
                        var rows=$(".ruleValueRow").length;
                        if(rows>1){
                            $(this).closest('.ruleValueRow').remove();
                        }   
                    }
                });

                
            })
        </script>            
@endsection