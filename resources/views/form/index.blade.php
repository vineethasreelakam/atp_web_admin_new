
@extends('layouts.app-master')

@section('content')




    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Form</h2>
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
                <div class="col-md-4 mb-1">
                    <a href="{{route('rule')}}">
                        <button class="dt-button btn btn-primary btn-add-record ml-0 mr-0" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                            <span><i data-feather="command"></i> Manage Rule</span>
                        </button> 
                    </a>
                    <a href="{{route('form.create')}}">
                        <button class="dt-button btn btn-primary btn-add-record ml-0" tabindex="0" aria-controls="DataTables_Table_0" type="button" style="float:right;">
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
                                    A forms management page simplifies form creation, editing, and oversight for administrators, enabling smooth data collection and processing while enhancing user experience.
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
                                            <th>Title</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($listData))
                                            @foreach($listData as $key=>$row)
                                            
                                                <tr>
                                                    <td>{{(($listData->currentPage()-1)*$listData->perPage())+$key+1 }}</td>
                                                    <td>{{$row->title}}</td>
                                                    
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                                <i data-feather="more-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{route('form.create',['id'=>$row->id])}}">
                                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                                    <span>Edit</span>
                                                                </a>
                                                                <a class="dropdown-item" href="{{route('formQuestionSection',['formId'=>$row->id])}}" >
                                                                    <i data-feather="layers" class="mr-50"></i>
                                                                    <span>Sections</span>
                                                                </a>
                                                                <a class="dropdown-item" href="{{route('formQuestion',['formId'=>$row->id])}}" >
                                                                    <i data-feather="message-circle" class="mr-50"></i>
                                                                    <span>Questions</span>
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

