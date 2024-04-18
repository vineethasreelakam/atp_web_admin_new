
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
                            <h2 class="content-header-title float-left mb-0">Assign Tournament</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-1"style="float:right;">
                   <!--  <a href="{{route('user')}}">
                        <button class="dt-button btn btn-primary btn-add-record ml-2" tabindex="0" aria-controls="DataTables_Table_0" type="button" style="float:right;">
                            <span><i data-feather="list"></i> List All</span>
                        </button> 
                    </a> -->
                </div>
            </div>
         
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card ">

                            <div class="card-header">
                            </div>

                            <div class="card-body">
                                
                                <form id="admin_form" class="form-validate" method="POST" action="{{route('change_tournament')}}" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="{{$formData->id}}">
                                    
                                    <div id="tournamentIds"></div>
                                    @csrf    
                                    <div class="row">
                                            
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
                        'tournaments[]':"required",
                    },
                    // In 'messages' user have to specify message as per rules
                    messages: {
                        'tournaments[]':"Please Select Tournaments",
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
                    
                    $('#tournaments option:selected').each(function(index,value) {
                        if(count>1){
                            if(index === 1) {
                                $(this).prop('selected',false);
                            }
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