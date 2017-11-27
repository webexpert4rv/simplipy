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
                            {{--<h2>
                                <small>{!! $page_title !!}</small>
                            </h2>--}}
                            <div class="pull-right" style="float: left!important;">
                                @if(\Auth::user()->role_id == \App\User::ROLE_AGENT)
                                    <a class="btn btn-success cr_btn" href="{{ url('user/reports/create') }}">Nouveau
                                        Message</a>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content report_table">
                            <p class="text-muted font-13 m-b-30">
                                {{--  DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>--}}
                            </p>
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                <tr class="headings">
                                    <th class="column-title" style="display: none">Sr.No.</th>
                                    <th class="column-title">Date Appel</th>
                                    <th class="column-title">Nom Complet du Patient</th>

                                    <th class="column-title">Société</th>
                                    <th class="column-title">Mobile</th>
                                    <th class="column-title">Centre</th>
                                    <th class="column-title">Médecin</th>
                                    <th class="column-title">
                                        Actions </a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($models as $model)
                                    <tr>
                                        <td style="display: none">{{ $loop->iteration}}</td>
                                        <td>{{ @$model->created_at  }}</td>
                                        <td>{{ \App\Report::getCivilOptions((int)$model->civil_id) }} {{$model->name}} {{$model->first_name}}</td>
                                        <td>{{ @$model->company }}</td>
                                        <td>{{ @$model->mobile }}</td>
                                        <td>{{ \App\Report::getCenterOptions($model->center_id) }}</td>
                                        <td>{{\App\Report::getPhysicianOptions($model->physician_id)}}</td>
                                        <td>
                                            <a href="{{ url("user/reports/".$model->id.'/edit') }}"><i
                                                        class="fa fa-eye"></i> </a>


                                            {{-- {!! Form::open(['style' => 'display: inline;', 'method' => 'DELETE', 'onsubmit' => 'return confirm(\'Are you sure you want to delete ? \');',  'route' => array('reports.destroy', $model->id)]) !!}
                                             <button type="submit" class="btn btn-xs btn-danger"><i
                                                         class="fa fa-remove"></i></button>
                                             {!! Form::close() !!}--}}
                                            @if(\Auth::user()->role_id == \App\User::ROLE_AGENT)
                                                <a href="{{ url("user/reports/".$model->id.'/duplicate') }}">
                                                    Dupliquer</a>
                                            @endif

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
    {{--
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>--}}
@endsection