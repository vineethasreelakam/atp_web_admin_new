
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
                <div class="col-md-4 mb-1 form-group"style="float:right;">
                    <form class="" action="{{route('formview')}}" method="GET">
                    <input type="hidden" name="selectedYear" value="{{date('Y',strtotime($listData[0]['tournament_date']))}}">
                    <input class="form-control" type="search" name="search" placeholder="Search..." style="width:65%;float:right;">
                    <button class="ml-0 mr-0 btn btn-primary" style="float:right;" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-md-2 mb-1 mr-0 form-group" >
                    <form id="tournamentForm"  action="" method="post">
                    <input name="_method" type="hidden" value="get">
                        <select name="year" id="tournament" data-url="{{route('formview')}}" class="form-control" style="text-align:center;">
                            <?php
                            // Define the range of years you want to display
                            $startYear = date("Y") - 10; // Start from 10 years ago
                            $endYear = date("Y") + 10;   // End 10 years into the future

                            // Loop through the range of years
                            for ($year = $startYear; $year <= $endYear; $year++) {
                                if(isset($listData)){
                                    $selectedYear=date('Y',strtotime($listData[0]['tournament_date']));
                                }
                                // Output each year as an option in the dropdown
                            ?>
                                <option value="{{$year}}" {{isset($selectedYear) && $selectedYear==$year ? 'selected' : ''}}>{{$year}}</option>
                            <?php
                                }
                            ?>
                        </select>
                    </form>
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
                                    Please choose the tournament you'd like to view form submissions for. 
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
                                            <th>Category</th>
                                            <th>Tournament Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($listData))
                                            @foreach($listData as $key=>$row)
                                            
                                                <tr>
                                                    <td>{{(($listData->currentPage()-1)*$listData->perPage())+$key+1 }}</td>
                                                    <td>{{$row->title}}</td>
                                                    <td>{{$row->category}}</td>
                                                    <td>{{date('d-m-Y',strtotime($row->tournament_date))}}</td>
                                                    <td>
                                                        <a class="btn btn-primary" href="{{route('formview.list',['id'=>$row->id])}}">
                                                            <i data-feather="eye" class="mr-50"></i>
                                                            <span>View</span>
                                                        </a>
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

            $("#tournament").change(function(){
                var url=$("#tournament").attr('data-url');
                $('#tournamentForm').attr('action', url);
                $('#tournamentForm').submit();
                
            });
        });
    </script>    
@stop

