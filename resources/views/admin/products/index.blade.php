@extends('admin.layouts.admin_layout')
@section('css')
        <!-- Datatables -->
        <link href="{{ asset('/css/admin_dist/dataTable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/admin_dist/dataTable/responsive.bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/admin_dist/dataTable/scroller.bootstrap.min.css') }}" rel="stylesheet">
@endsection
@section('content')
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Products <small></small></h3>
                    </div>

                    {{--<div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                            </div>
                        </div>
                    </div>--}}
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>List <small>Products</small></h2>
                                <div class="pull-right">
                                    <a class="btn btn-success" href="{{ url('admin/products/create') }}">Create Product</a>
                                </div>
                                {{--<ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ url('admin/user/create') }}">Create User</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>--}}
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <p class="text-muted font-13 m-b-30">
                                  {{--  DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>--}}
                                </p>
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                       {{-- <th>
                                       <input type="checkbox" id="check-all" class="flat">
                                        </th>--}}
                                        <th class="column-title">Name</th>
                                        <th class="column-title">Price ($)</th>
                                        <th class="column-title">Created On</th>
                                        <th class="column-title">Actions</th>
                                        <th class="bulk-actions" colspan="5">
                                            <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($models as $model)
                                        <tr>
                                            {{--<td class="a-center ">
                                                <input type="checkbox" class="flat" name="table_records">
                                            </td>--}}
                                            <td>{{ $model->name }}</td>
                                            <td>{{ $model->price }}</td>
                                            <td>{{ $model->created_at }}</td>
                                            <td>
                                                <a href="{{ url("admin/products/".$model->id."/edit/") }}"><i class="fa fa-pencil"></i> </a>
                                                {!! Form::open(['style' => 'display: inline;', 'method' => 'DELETE', 'onsubmit' => 'return confirm(\'Are you sure you want to delete ? \');',  'route' => array('products.destroy', $model->id)]) !!}
                                                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i></button>
                                                {!! Form::close() !!}

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /page content -->

@endsection
@section('scripts')
<!-- Datatables -->
<script src="{{ asset('js/admin_dist/dataTable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/admin_dist/dataTable/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/admin_dist/dataTable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/admin_dist/dataTable/responsive.bootstrap.js') }}"></script>
<script src="{{ asset('js/admin_dist/dataTable/dataTables.scroller.min.js') }}"></script>


<script>
    $('.jambo_table').DataTable();
</script>
{{--
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>--}}
@endsection