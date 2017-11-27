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
                    <h3>Historique Messages
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
                            <h2>Liste
                                <small>de la totalité des messages traités</small>
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
                        <div class="col-md-12 row">
                            <div class="col-md-3" style="width: 20%">
                                <label for="designer_field">Agent: </label>
                                <select id="agent_field" class="form-control">
                                    @if(!empty($agents))
                                        <option> -- Select Agent --</option>
                                        @foreach($agents as $agent)
                                            {{--<input type="text" id="agent_field">--}}
                                            <option value="{{ $agent->userProfile->first_name }} {{ $agent->userProfile->last_name }}">{{ $agent->userProfile->first_name }} {{ $agent->userProfile->last_name }}</option>
                                        @endforeach

                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2" style="width: 20%">
                                <label for="industry_field">Centre: </label>
                                {{--<input type="text" id="center_field">--}}
                                <select id="center_field" class="form-control">
                                    <option> -- Select Center --</option>
                                    @foreach(\App\Report::getCenterOptions() as $key => $center)
                                        <option value="{{ $center }}"> {{ $center }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" style="width: 20%">
                                <label for="material_field">Daily: </label>
                                <input class="form-control datepicker" type="text" id="daily_field"
                                       value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                <p>(aaaa-mm-jj)</p>
                            </div>
                            <div class="col-md-2" style="width: 20%">
                                <label for="material_field">Monthly: </label>
                                <select class="form-control" id="monthly_field">
                                    <option> -- Select Month --</option>
                                    @foreach(\App\User::months() as $key => $month)
                                        <option value="{{ $key }}"> {{ $month }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" id="monthly_field">--}}
                                {{--<p>(aaaa-mm)</p>--}}
                            </div>
                            <div class="col-md-2" style="width: 20%; padding-top: 5px;">
                                <label for="material_field"></label>
                                <button type="button" class="form-control" onclick="window.location.reload();" style="background: #52b30c;
    color: white;">Reset
                                </button>
                            </div>

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
                                    <th class="column-title" style="display: none">Sr.No.</th>
                                    <th class="column-title">Agent Concerné</th>
                                    <th class="column-title">Date Appel</th>
                                    <th class="column-title">Nom Complet du Patient</th>

                                    <th class="column-title">Société</th>
                                    <th class="column-title">Mobile</th>
                                    <th class="column-title">Centre</th>
                                    <th class="column-title">Médecin</th>


                                    {{--<th class="column-title">City</th>

                                    <th class="column-title">Email</th>
                                    <th class="column-title">Mobile</th>--}}

                                    {{--    <th class="column-title">Physician</th>


                                        <th class="column-title">Emergency</th>
                                        <th class="column-title">Attempts</th>--}}
                                    <th class="column-title">
                                        Actions </a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($models as $model)
                                    <tr>
                                        <td style="display: none">{{ $loop->iteration}}</td>
                                        <td>{{\App\User::getFullName($model->user_id)}}</td>
                                        <td>{{ @$model->created_at  }}</td>
                                        <td>{{ \App\Report::getCivilOptions((int)$model->civil_id) }} {{$model->name}} {{$model->first_name}}</td>

                                        <td>{{ @$model->company }}</td>
                                        <td>{{ @$model->mobile }}</td>
                                        <td>{{ \App\Report::getCenterOptions($model->center_id) }}</td>
                                        <td>{{\App\Report::getPhysicianOptions($model->physician_id)}}</td>
                                        {{--<td>{{ @$model->city }}</td>

                                        <td>{{ @$model->email }}</td>--}}


                                        {{--<td>{{ $model->physician_id != null ? $model->getPhysicianOptions($model->physician_id) : ""}}</td>


                                        <td>{{ $model->emergency_id != null ? $model->getEmergencyOptions($model->emergency_id) : ""}}</td>
                                        <td>{{ @$model->attempt }}</td>--}}


                                        <td>
                                            <a href=" {{route('adminReports.edit',[$model->id])}} ">Voir</a>
                                            {!! Form::open(['style' => 'display: inline;', 'method' => 'DELETE', 'onsubmit' => 'return confirm(\'Supprimer ? \');',  'route' => array('adminReports.destroy', $model->id)]) !!}
                                            <button type="submit" class="btn btn-xs btn-danger"><i
                                                        class="fa fa-remove"></i></button>
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
    <script type="text/javascript" src="<?php echo(asset('js/admin_dist/bootstrap-datepicker.js')); ?>"></script>

    <script>
        $('.jambo_table').DataTable({
            "language": {
                "search": "Rechercher",
                "sLengthMenu": "Afficher _MENU_ entrées",
                "sInfo": "Affichage _START_ de _END_ sur _TOTAL_ entrées",
                paginate: {
                    previous: 'Précédent',
                    next: 'Suivant'
                },

            }

        });


    </script>
    <script>
        $(document).ready(function () {
            $('.report_table').find('.row:first').addClass('search_report');
        });
    </script>

    <script>
        $(".datepicker").datepicker({format: "yyyy-mm-dd", autoclose: true, endDate: new Date()});

    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('.jambo_table').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
            $('#agent_field').change(function () {
                // oTable.search($(this).val()).draw() ;
                oTable.column(1).search($(this).val()).draw();
            });
            $('#center_field').change(function () {
                // oTable.search($(this).val()).draw() ;
                oTable.column(6).search($(this).val()).draw();
            });
            $('#daily_field').change(function () {
                oTable.columns(2).search($(this).val()).draw();
            });
            $('#monthly_field').change(function () {
                var year = new Date().getFullYear();
                console.log(year + '-' + $(this).val());
                oTable.columns(2).search(year + '-' + $(this).val()).draw();
            });
        });
    </script>
    {{--
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>--}}
@endsection
