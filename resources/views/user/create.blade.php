
@extends('layouts.app-master')
@section('css')
  <style>
    .select-checkbox option::before {
        content: "\2610";
        width: 1.3em;
        text-align: center;
        display: inline-block;
    }
    .select-checkbox option:checked::before {
        content: "\2611";
    }
  </style>
@endsection
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
                            <h2 class="content-header-title float-left mb-0">User</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1"style="float:right;">
                    <a href="{{route('user')}}">
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
                                
                                <form id="admin_form" class="form-validate" method="POST" action="{{route('user.store')}}" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="{{$formData->id}}">
                                    <input type="hidden" name="admin" value="{{$roleMaster->admin}}">
                                    <div id="tournamentIds"></div>
                                    @csrf    
                                    <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="title">Name</label>
                                                    <input type="text" class="form-control" placeholder="Name" value="{{$formData->name}}" name="name" id="name" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="title">Email</label>
                                                    <input type="email" class="form-control" placeholder="Email" value="{{$formData->email}}" name="email" id="email" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="title">Role</label>
                                                    <select name="role_id" id="role_id" class="form-control">
                                                        <option value="">Select</option>
                                                        @if(isset($role))
                                                            @foreach($role as $val)
                                                                <option value="{{$val->id}}" {{$roleMaster->id==$val->id ? "selected" : ''}}>{{$val->title}}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="title">Tournamets</label>
                                                    <select name="tournaments[]" id="tournaments" class="form-control select-checkbox" multiple="" style="height:200px;">
                                                        
                                                        @php
                                                            if(isset($formData->Tournaments)){
                                                                $tournamentArray=[];
                                                                foreach($formData->Tournaments as $val){
                                                                    $tournamentArray[]=$val->tournament_id;
                                                                    $accessIdArray[$val->tournament_id]=$val->id;
                                                                }
                                                            }
                                                        @endphp

                                                        @if(isset($tournaments))
                                                            @php
                                                                $category='';
                                                            @endphp
                                                            @foreach($tournaments as $val)
                                                                @if($val->category!=$category)
                                                                    @if($category!='')
                                                                        </optgroup>
                                                                    @endif
                                                                    <?php $category=$val->category;?>
                                                                    <optgroup label="{{$category}}">
                                                                @endif
                                                                <option value="{{$val->id}}" userAccessId="{{isset($accessIdArray[$val->id]) ? $accessIdArray[$val->id] : ''}}" <?php echo isset($tournamentArray) && in_array($val->id,$tournamentArray) ? 'selected' : ''?>>{{$val->title}}</option>

                                                            @endforeach
                                                            </optgroup>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            @if($roleMaster->id>0)
                                                <div class="col-12">
                                                    <div class="table-responsive border rounded mt-1">
                                                        <!-- <h6 class="py-1 mx-1 mb-0 font-medium-2">
                                                            <i data-feather="lock" class="font-medium-3 mr-25"></i>
                                                            <span class="align-middle">Permission</span>
                                                        </h6> -->
                                                        <table class="table table-striped table-borderless">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>Permissions</th>
                                                                    <th>Allow</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    if(isset($formData->Privilleges)){
                                                                        $privillegeArray=[];
                                                                        foreach($formData->Privilleges as $val){
                                                                            $privillegeArray[$val->privillege_id]=$val->id;
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if(isset($privilleges))
                                                                    @foreach($privilleges as $val)
                                                                        <tr>
                                                                            <td>{{$val->title}}</td>
                                                                            <td>
                                                                                <div>
                                                                                    <input name="privilleges[{{$val->id}}]" type="checkbox" value="{{$val->id}}" <?php  echo isset($privillegeArray) && array_key_exists($val->id,$privillegeArray) ? 'checked' : ''?>/>
                                                                                    <input type="hidden" name="userAccessId[{{$val->id}}]" value="{{isset($privillegeArray[$val->id]) ? $privillegeArray[$val->id] : ''}} ">
                                                                                    <label class="" for=""></label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="table-responsive border rounded mt-3">
                                                    <!--  <h6 class="py-1 mx-1 mb-0 font-medium-2">
                                                            <i data-feather="lock" class="font-medium-3 mr-25"></i>
                                                            <span class="align-middle">Permission</span>
                                                        </h6> -->
                                                        <table class="table table-striped table-borderless">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>Form Access</th>
                                                                    <th>Allow</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    if(isset($formData->Forms)){
                                                                        $formsArray=[];
                                                                        foreach($formData->Forms as $val){
                                                                            $formsArray[$val->form_id]=$val->id;
                                                                @endphp 
                                                                            <input type="hidden" name="userFormId[{{$val->tournament_id}}][{{$val->form_id}}]" value="{{isset($val->id) ? $val->id : ''}} ">
                                                                @php       
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if(isset($forms))
                                                                    @foreach($forms as $val)
                                                                        <tr>
                                                                            <td>{{$val->title}}</td>
                                                                            <td>
                                                                                <div>
                                                                                    <input name="forms[]" type="checkbox" value="{{$val->id}}" <?php  echo isset($formsArray) && array_key_exists($val->id,$formsArray) ? 'checked' : ''?>/>
                                                                                    <label class="" for=""></label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif
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
                        name:"required",
                        email:"required",
                        role_id:"required",
                    },
                    // In 'messages' user have to specify message as per rules
                    messages: {
                        name:"Please enter Name",
                        email:"Please enter Email",
                        role_id:"Please Select Role",
                    }
                });
                $('option').mousedown(function(e) {
                    //e.preventDefault();
                    var originalScrollTop = $(this).parent().parent().scrollTop();
                    $(this).prop('selected', $(this).prop('selected') ? false : true);
                    var self = this;
                    $(this).parent().parent().focus();
                    setTimeout(function() {
                        $(self).parent().parent().scrollTop(originalScrollTop);
                    }, 0);
        
                    return false;
                });

                $('#tournaments').click(function() {
                    $("#tournamentIds").empty();
                    var count=$('#tournaments option:selected').length;
                    
                    $('#tournaments option:selected').each(function() {
                        if(count>1){
                            $(this:last).prop('selected',false);
                        }
                            var optionValue = $(this).val();
                            var userAccessId = $(this).attr('userAccessId');
                            var html="<input type='hidden' name='tournamentuserAccessId["+optionValue+"]' value='"+userAccessId+"'>"
                            $("#tournamentIds").append(html);
                    });
                    
                });

            })
        </script>            
@endsection