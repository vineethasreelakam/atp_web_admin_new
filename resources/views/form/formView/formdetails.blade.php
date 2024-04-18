
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
                            <h2 class="content-header-title float-left mb-0">View Forms</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <div class="row">
                                        @if (session('message') || session('deleteMessage'))
                                            <div class="{{session('message') ? 'alert alert-success' : (session('deleteMessage') ? 'alert alert-danger' : '')}}">{{ session('message') ? session('message') : session('deleteMessage')}}</div>
                                        @endif
                                    </div>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                                
                <!-- <div class="col-md-2 mb-1"style="float:right;">
                    <a href="">
                        <button class="dt-button btn btn-primary btn-add-record ml-2" tabindex="0" aria-controls="DataTables_Table_0" type="button" style="float:right;">
                            <span><i data-feather="plus-square"></i> Add New</span>
                        </button> 
                    </a>
                </div> -->
            </div>
         
            <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                </p>
                            </div>
                            <form id="frm_delete" method="POST" action="">
                                {!! csrf_field() !!}
                                <input name="_method" type="hidden" value="delete">
                            </form>
                            <div class="table-responsive" style="min-height:150px !important;">
                                <table class="table">
                                    <thead>
                                        <div class="row" style="width:100%;text-align:center;">
                                            <div class="col-md-2 mb-3" style="margin-left:35%;margin-right:1px;">
                                                <a href="javascript:void(0);" id="submited" data-url="{{route('formview.details',['userId'=>$userId,'tournamentId'=>$tournamentId,'status'=>3])}}">
                                                    <button class="btn btn-success" id="btn_submit" style="float:left;">Submited</button>
                                                </a>
                                            </div>
                                            <div class="col-md-2 mb-3" style="margin-right:30%;">
                                                <a href="javascript:void(0);" id="reviewed" data-url="{{route('formview.details',['userId'=>$userId,'tournamentId'=>$tournamentId,'status'=>4])}}">
                                                    <button class="btn btn-primary" id="btn_reviewed" style="float:left;">Reviewed</button>
                                                </a>
                                            </div>
                                        </div>
                                    </thead>
                                    <tbody>
                                        <div class="row" style="width:100%;">
                                            <div class="col-md-12 Subdata">
                                            @if(isset($completedListData) && count($completedListData)>0)
                                                @foreach($completedListData as $key=>$rowS)
                                                        <div class="col-md-3 m-2 p-1 " style="border:1px solid;border-radius:1em;height:290px;text-align:center;">
                                                            <img src="{{$rowS->image}}" style="height:200px;width:100%;float:left;background-color:#ccc;">
                                                            <label style="background-color:#fff;width:100%;height:25px;padding-top:3px;;"><b>{{$rowS->title}}</b></label>
                                                            <!-- <a href="https://atp-frontend.vercel.app/{{$rowS->formId}}?form_id={{$rowS->id}}&name={{$rowS->title}}&status={{$rowS->status}}&user_id={{$rowS->user_id}}"><button class="btn btn-primary">View</button></a> -->
                                                            <a href="https://atpforms.com/{{$rowS->formId}}?form_id={{$rowS->id}}&name={{$rowS->title}}&status={{$rowS->status}}&user_id={{$rowS->user_id}}"><button class="btn btn-primary">View</button></a>
                                                        </div>
                                                    
                                                @endforeach  
                                            @else
                                                <div class="col-md-12" style="text-align: center;">There are no submitted forms present at the moment.</div>                  
                                            @endif
                                            </div>
                                            <div class="col-md-12 Revdata">
                                            @if(isset($reviewedListData) && count($reviewedListData)>0)
                                                @foreach($reviewedListData as $key=>$row)
                                                        <div class="col-md-3 m-2 p-1 "  style="border:1px solid;border-radius:1em;height:290px;text-align:center;">
                                                            <img src="{{$row->image}}" style="height:200px;width:100%;float:left;background-color:#ccc;">
                                                            <label style="background-color:#fff;width:100%;height:25px;padding-top:3px;;"><b>{{$row->title}}</b></label>
                                                            <a href="https://atp-frontend.vercel.app/{{$row->formId}}?form_id={{$row->id}}&name={{$row->title}}&status={{$row->status}}&user_id={{$row->user_id}}"><button class="btn btn-primary">View</button></a>
                                                        </div>
                                                    
                                                @endforeach
                                            @else
                                                <div class="col-md-12" style="text-align: center;">No forms have been reviewed at this time.</div>                  
                                            @endif
                                            </div>
                                        </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Basic Tables end -->
               
            </div>
        </div>
    </div>
    <!-- END: Content-->

    
@endsection

@section('javascript')
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script>
        $(document).ready(function(){
            $(".btn_delete").click(function(){
                var url=$(this).attr('data-url');

                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $('#frm_delete').attr('action', url);
                        $('#frm_delete').submit();
                    }
                })
                
            });

            $("#tournament").change(function(){
                var url=$("#tournament").attr('data-url');
                $('#tournamentForm').attr('action', url);
                $('#tournamentForm').submit();
                
            });

            
            $(".Subdata").show();
            $(".Revdata").hide();
           
            $("#submited").click(function(){
                $("#btn_submit").removeClass('btn-primary');
                $("#btn_reviewed").removeClass('btn-success');
                $("#btn_reviewed").addClass('btn-primary');
                $("#btn_submit").addClass('btn-success');
                $(".Subdata").show();
                $(".Revdata").hide();
            })

            $("#reviewed").click(function(){
                $("#btn_submit").addClass('btn-primary');
                $("#btn_submit").removeClass('btn-success');
                $("#btn_reviewed").removeClass('btn-primary');
                $("#btn_reviewed").addClass('btn-success');
                $(".Subdata").hide();
                $(".Revdata").show();
            })
        });
    </script>    
@stop

