
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
                            <h2 class="content-header-title float-left mb-0">Admin</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1"style="float:right;">
                    <a href="{{route('admin')}}">
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
                                
                                <form id="admin_form" class="form-validate" method="POST" action="{{route('admin.store')}}" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="{{$formData->id}}">
                                    <input type="hidden" name="admin" value="{{$roleMaster->admin}}">
                                    @csrf    
                                        <div class="row" id="form">
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
                                            <div class="col-md-12" id="tournamentRow">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="title">Tournamet Category</label>
                                                            <select name="tournament_category[]" id="tournament_category" class="form-control">
                                                                @php
                                                                    if(isset($formData->Tournaments)){
                                                                        $tournamentCategoryArray=[];
                                                                        foreach($formData->Tournaments as $val){
                                                                            $cTournaments=DB::table('tournament_master')->where('id',$val->tournament_id)->first();
                                                                            //print_r($cTournaments);exit;
                                                                            $tournamentCategoryArray[]=$cTournaments->category;
                                                                        }
                                                                    }
                                                                @endphp
                                                                <option value="UNITED CUP" <?php echo isset($tournamentCategoryArray) && in_array('UNITED CUP',$tournamentCategoryArray) ? 'selected' : ''?>>UNITED CUP</option>
                                                                <option value="ATP 250" <?php echo isset($tournamentCategoryArray) && in_array('ATP 250',$tournamentCategoryArray) ? 'selected' : ''?>>ATP 250</option>
                                                                <option value="GRAND SLAM" <?php echo isset($tournamentCategoryArray) && in_array('GRAND SLAM',$tournamentCategoryArray) ? 'selected' : ''?>>GRAND SLAM</option>
                                                                <option value="DAVIS CUP" <?php echo isset($tournamentCategoryArray) && in_array('DAVIS CUP',$tournamentCategoryArray) ? 'selected' : ''?>>DAVIS CUP</option>
                                                                <option value="ATP MASTERS 1000" <?php echo isset($tournamentCategoryArray) && in_array('ATP MASTERS 1000',$tournamentCategoryArray) ? 'selected' : ''?>>ATP MASTERS 1000</option>
                                                                <option value="ATP 500" <?php echo isset($tournamentCategoryArray) && in_array('ATP 500',$tournamentCategoryArray) ? 'selected' : ''?>>ATP 500</option>
                                                                <option value="OLYMPICS" <?php echo isset($tournamentCategoryArray) && in_array('OLYMPICS',$tournamentCategoryArray) ? 'selected' : ''?>>OLYMPICS</option>
                                                                <option value="LAVER CUP" <?php echo isset($tournamentCategoryArray) && in_array('LAVER CUP',$tournamentCategoryArray) ? 'selected' : ''?>>LAVER CUP</option>
                                                                <option value="ATP FINALS" <?php echo isset($tournamentCategoryArray) && in_array('ATP FINALS',$tournamentCategoryArray) ? 'selected' : ''?>>ATP FINALS</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="title">Tournamets</label>
                                                            <select name="tournaments[]" class="form-control" id="tournaments" class="form-control">
                                                                
                                                                @php
                                                                    if(isset($formData->Tournaments)){
                                                                        $tournamentArray=[];
                                                                        foreach($formData->Tournaments as $val){
                                                                            $tournamentArray[]=$val->tournament_id;
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
                                                                        <option value="{{$val->id}}" <?php echo isset($tournamentArray) && in_array($val->id,$tournamentArray) ? 'selected' : ''?>>{{$val->title}}</option>
                                                                    @endforeach
                                                                    </optgroup>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div>
                                                            <label for="">&nbsp;</label><br/>
                                                            <span class="btn btn-info btn-sm" id="addMore" onclick="addMore()" style="height:40px;text-align:center;padding-top:12px;">+</span>
                                                        </div>
                                                    </div>
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
                                                                            $privillegeArray[]=$val->privillege_id;
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if(isset($privilleges))
                                                                    @foreach($privilleges as $val)
                                                                        <tr>
                                                                            <td>{{$val->title}}</td>
                                                                            <td>
                                                                                <div>
                                                                                    <input name="privilleges[]" type="checkbox" value="{{$val->id}}" <?php  echo isset($privillegeArray) && in_array($val->id,$privillegeArray) ? 'checked' : ''?>/>
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
                                                                            $formsArray[]=$val->form_id;
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if(isset($forms))
                                                                    @foreach($forms as $val)
                                                                        <tr>
                                                                            <td>{{$val->title}}</td>
                                                                            <td>
                                                                                <div>
                                                                                    <input name="forms[]" type="checkbox" value="{{$val->id}}" <?php  echo isset($formsArray) && in_array($val->id,$formsArray) ? 'checked' : ''?>/>
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
            var idNum = 1;
            function addMore()
            {
                idNum++;
                var form = document.getElementById('tournamentRow');
                var html="<div class='col-md-4'><div class='form-group'><label for='title'>Tournamet Category</label><select name='tournament_category[]' id='tournament_category"+idNum+"' class='form-control'><option value='UNITED CUP'>UNITED CUP</option><option value='GRAND SLAM'>GRAND SLAM</option><option value='DAVIS CUP'>DAVIS CUP</option><option value='ATP MASTERS 1000'>ATP MASTERS 1000</option><option value='ATP MASTERS 1000'>ATP MASTERS 1000</option></select></div></div>";
               /*  $.ajax({
                    url: "{{env('APP_URL')}}countryList",
                    type: "POST",
                    data: {
                        _token:  '{{csrf_token()}}',
                    },
                    dataType: 'json',
                    success: function (res) {
                     //  var  res.product_name
                       // $('#camera_id').html('<option value=""> Camera Id </option>');
                        var list ='';
                        $.each(res, function (key, value) {
                            list +='<option value="' + value.id + '">' + value.name + '</option>';
                        });
                       // console.log(list);

                       idNum++;
                         var objTo = document.getElementById('addContent1');
                         var divtest = document.createElement("div");
                         divtest.setAttribute("class", "row c_removeclass"+room2);
                         var rdiv = 'c_removeclass'+room2;
                         divtest.innerHTML = '<div class="col-lg-5"><div class="form-group"><label class="d-block" for="validationBioBootstrap">Country</label><select  class="form-control" name="country_id[]" id="country_id"><option selected>Select country</option>'+list+'</select></div></div><div class="col-lg-5"><div class="form-group"><label class="d-block" for="validationBioBootstrap">Price</label><input type="text" id="amount" name="price[]" class="form-control"></div></div><div class="col-lg-2"><div class="primary_input mb-15"><label for="">&nbsp;</label><br/><button class="btn btn-danger btn-sm" type="button" onclick="c_remove_imgicon_fields('+ room2+');">-</button></div></div>';
                         objTo.appendChild(divtest);

                    }
                }); */
            }


            $(document).ready(function(){
                $("#tournament_category").change(function(){
                    var category=$(this).val();//multiselect
                    //alert(category);
                    var url="{{route('admin.tournaments')}}";

                    $.ajax({
                        type: "get",
                        url:url,
                        data: {category:category},
                        cache: false,
                       dataType:'json',
                       success: function(data)
                        {
                            $("#tournaments").empty();
                            console.log(data);
                            if(data!=''){
                                // Process each item here
                                $("#tournaments").html("<option value=''>Select</option>");
                                var html="";
                                $.each(data, function(index, item) {
                                    html+="<option value='"+item.id+"'>"+item.title+"</option>";
                                });
                                $("#tournaments").append(html);
                            } 
                            else{
                                $("#tournaments").html("<option value=''>No Tournaments available</option>");
                            }
                        }
                    });
                });
                

                $("#admin_form").validate({
                    
                    // In 'rules' user have to specify all the
                    // constraints for respective fields
                    rules: {
                        name:"required",
                        email:"required",
                        role_id:"required",
                        tournament_category:"required",
                        tournaments:"required",
                    },
                    // In 'messages' user have to specify message as per rules
                    messages: {
                        name:"Please enter Name",
                        email:"Please enter Email",
                        role_id:"Please Select Role",
                        tournament_category:"Please Select Tournament Category",
                        tournaments:"Please Select Tournaments",

                    }
                });
            })
        </script>            
@endsection