@extends('admin.layouts.admin_layout')
@section('css')
    <!-- Datatables -->
    <link href="{{ asset('/css/admin_dist/dataTable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/admin_dist/dataTable/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/admin_dist/dataTable/scroller.bootstrap.min.css') }}" rel="stylesheet">
@endsection
@section('title', $page_title)
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>{!! $page_title !!}
                        <small></small>
                    </h3>
                </div>

                {{--  <div class="title_right">
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
                            <h2>
                                <small>{!! $page_title !!}</small>
                            </h2>
                            <div class="pull-right">

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
                        <div class="x_content report_table">
                            <p class="text-muted font-13 m-b-30">
                                {{--  DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>--}}
                            </p>
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                <tr class="headings">
                                    {{-- <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                     </th>--}}
                                    <th class="column-title">Sr.No.</th>
                                    <th class="column-title">Date of Call</th>
                                    <th class="column-title">Full Name</th>
                                    <th class="column-title">Company</th>
                                    <th class="column-title">Mobile</th>
                                    <th class="column-title">Physician</th>

                                    {{--<th class="column-title">City</th>

                                    <th class="column-title">Email</th>
                                    <th class="column-title">Mobile</th>--}}

                                {{--    <th class="column-title">Physician</th>


                                    <th class="column-title">Emergency</th>
                                    <th class="column-title">Attempts</th>--}}
                                    <th class="column-title">
                                        Bulk Actions </a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($models as $model)
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>{{ @$model->created_at  }}</td>
                                        <td>{{ \App\Report::getCivilOptions((int)$model->civil_id) }} {{$model->name}} {{$model->first_name}}</td>

                                        <td>{{ @$model->company }}</td>
                                        <td>{{ @$model->mobile }}</td>
                                        <td>{{\App\Report::getPhysicianOptions($model->physician_id)}}</td>
                                        {{--<td>{{ @$model->city }}</td>

                                        <td>{{ @$model->email }}</td>--}}


                                        {{--<td>{{ $model->physician_id != null ? $model->getPhysicianOptions($model->physician_id) : ""}}</td>


                                        <td>{{ $model->emergency_id != null ? $model->getEmergencyOptions($model->emergency_id) : ""}}</td>
                                        <td>{{ @$model->attempt }}</td>--}}
                                        <td>

                                                <a href="{{ url("admin/adminReports/".$model->id.'/edit') }}">View Report</a>

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
    <script>
        $(document).ready(function () {
            $('.report_table').find('.row:first').addClass('search_report');
        });
    </script>
    {{--
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>--}}
@endsection