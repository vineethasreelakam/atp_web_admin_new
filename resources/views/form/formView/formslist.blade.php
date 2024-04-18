
@extends('layouts.app-master')

@section('content')




    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
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
                                    Please tap the "View" button to access the submitted form.  
                                </p>
                            </div>
                            <form id="frm_delete" method="POST" action="">
                                {!! csrf_field() !!}
                                <input name="_method" type="hidden" value="delete">
                            </form>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Allocated Form No</th>
                                            <th>Submitted Form No</th>
                                            <th>Reviewed Form No</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($listData))
                                            
                                            <tr><th class="card-title" style="background-Color:#ccc;">Supervisors</th></tr>
                                              
                                                    
                                                @foreach($listData as $key=>$row)
                                                
                                                @if($row->admin==1)
                                                    <?php
                                                        $userFormDatas=DB::table('user_form')->where('tournament_id',$row->tournament_id)->where('user_id',$row->userId)->where('active','1')->get();
                                                        $adminAllocatedCount=count($userFormDatas);

                                                        $userFormsubmitedDatas=DB::table('user_form')->where('tournament_id',$row->tournament_id)->where('user_id',$row->userId)->where('status','completed')->where('active','1')->get();
                                                        $adminSubmitedCount=count($userFormsubmitedDatas);

                                                        $userFormReviewesDatas=DB::table('user_form')->where('tournament_id',$row->tournament_id)->where('user_id',$row->userId)->where('status','reviewed')->where('active','1')->get();
                                                        $adminReviewedCount=count($userFormReviewesDatas);
                                                    ?>
                                                
                                                    <tr>
                                                        <td>{{isset($row) ? $row->name : ''}}</td>
                                                        <td>{{isset($row->title) ? $row->title : ''}}</td>
                                                        <td>{{$adminAllocatedCount}}</td>
                                                        <td>{{$adminSubmitedCount}}</td>
                                                        <td>{{$adminReviewedCount}}</td>
                                                        
                                                        <td>
                                                            <a class="btn btn-primary" href="{{route('formview.details',['userId'=>$row->userId,'tournamentId'=>$row->tournament_id])}}">
                                                                <i data-feather="eye" class="mr-50"></i>
                                                                <span>View</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @endforeach

                                                <tr><th class="card-title" style="background-Color:#ccc;">Users</th></tr>
                                              
                                                    
                                                @foreach($listData as $key=>$row)
                                                @if($row->admin==0)
                                                  <?php
                                                      $userFormDatas=DB::table('user_form')->where('tournament_id',$row->tournament_id)->where('user_id',$row->userId)->where('active','1')->get();
                                                      $userAllocatedCount=count($userFormDatas);

                                                      $userFormSubmitedDatas=DB::table('user_form')->where('tournament_id',$row->tournament_id)->where('user_id',$row->userId)->where('status','completed')->where('active','1')->get();
                                                      $userSubmitedCount=count($userFormSubmitedDatas);

                                                      $userFormReviewedDatas=DB::table('user_form')->where('tournament_id',$row->tournament_id)->where('user_id',$row->userId)->where('status','reviewed')->where('active','1')->get();
                                                      $userReviewedCount=count($userFormReviewedDatas);
                                                  ?>
                                              
                                                  <tr>
                                                      <td>{{isset($row) ? $row->name : ''}}</td>
                                                      <td>{{isset($row->title) ? $row->title : ''}}</td>
                                                      <td>{{$userAllocatedCount}}</td>
                                                      <td>{{$userSubmitedCount}}</td>
                                                      <td>{{$userReviewedCount}}</td>
                                                      
                                                      <td>
                                                            <a class="btn btn-primary" href="{{route('formview.details',['userId'=>$row->userId,'tournamentId'=>$row->tournament_id])}}">
                                                                <i data-feather="eye" class="mr-50"></i>
                                                                <span>View</span>
                                                            </a>
                                                      </td>
                                                  </tr>
                                                @endif
                                                @endforeach

                                        @endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Basic Tables end -->
                @include('pagination')
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
        });
    </script>    
@stop

