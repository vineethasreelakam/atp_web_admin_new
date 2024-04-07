
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
                            <h2 class="content-header-title float-left mb-0">User</h2>
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
                <div class="col-md-4 mb-1 form-group"style="float:right;">
                    <form class="" action="{{route('user')}}" method="GET">
                    <input class="form-control" type="search" name="search" placeholder="Search..." style="width:65%;float:right;">
                    <button class="ml-1 mr-0 btn btn-primary" style="float:right;" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-md-2 mb-1"style="float:right;">
                    <a href="{{route('user.create')}}">
                        <button class="dt-button btn btn-primary btn-add-record ml-2" tabindex="0" aria-controls="DataTables_Table_0" type="button" style="float:right;">
                            <span><i data-feather="plus-square"></i> Add New</span>
                        </button> 
                    </a>
                </div>
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
                                The administrator can utilize this page to create new user accounts, edit their information, and customize their access privileges as needed.
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
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($listData))
                                            @foreach($listData as $key=>$row)
                                            
                                                <tr>
                                                    <td>{{(($listData->currentPage()-1)*$listData->perPage())+$key+1 }}</td>
                                                    <td>{{$row->name}}</td>
                                                    <td>{{$row->email}}</td>
                                                    <td>{{$row->title}}</td>
                                                    <td><span class="badge badge-pill  mr-1 {{$row->status==1 ? 'badge-light-success' : 'badge-light-danger'}}">{{$row->status==1 ? 'Active' : 'Suspended'}}</span></td>
                                                    
                                                    <td>
                                                        <?php
                                                            if(isset($loginuserPrivilleges)){
                                                                $type=Auth::guard('web')->user()->type;
                                                                $loginUserprivillegs=[];
                                                                foreach($loginuserPrivilleges as $val){
                                                                    $loginUserprivillegs[$val->value]=$val->value;
                                                                }
                                                                
                                                            }
                                                        ?>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                                <i data-feather="more-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @php
                                                                    if((isset($loginUserprivillegs) && array_key_exists('user_edit',$loginUserprivillegs)) || $type=='super_admin'){
                                                                @endphp
                                                                    <a class="dropdown-item" href="{{route('user.create',['id'=>$row->id])}}">
                                                                        <i data-feather="edit-2" class="mr-50"></i>
                                                                        <span>Edit</span>
                                                                    </a>
                                                                @php
                                                                    }
                                                                @endphp
                                                                <a class="dropdown-item btn_delete" href="javascript:void(0);" data-url="{{route('user.delete',$row->id)}}">
                                                                    <i data-feather="trash" class="mr-50"></i>
                                                                    <span>Delete</span>
                                                                </a>
                                                                <a class="dropdown-item" href="{{route('user.status',$row->id)}}">
                                                                    <i data-feather="bar-chart-2" class="mr-50"></i>
                                                                    <span>{{$row->status==1 ? 'Suspend' : 'Activate'}}</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
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
        });
    </script>    
@stop

