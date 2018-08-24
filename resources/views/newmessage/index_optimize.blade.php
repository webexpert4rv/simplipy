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
                        <div class="x_content report_table">
                            <p class="text-muted font-13 m-b-30">
                                {{--  DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>--}}
                            </p>
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                <tr class="headings">
                                    <th class="column-title">Client</th>
                                    <th class="column-title">Nom</th>
                                    <th class="column-title">Prénom</th>
                                    <th class="column-title">Date Appel</th>
                                    <th class="column-title">Adresse Postale</th>
                                    <th class="column-title">Numéro de téléphone</th>
                                    <th class="column-title">Adresse e-mail</th>

                                    <th class="column-title">Type d'examen</th>
                                    <th class="column-title">
                                        Actions </a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--@foreach($models as $model)
                                    <tr>

                                        <td>{{ @$model->created_at  }}</td>
                                        <td>{{ \App\Report::getCivilOptions((int)$model->civil_id) }} {{$model->name}} {{$model->first_name}}</td>
                                        <td>{{ @$model->company }}</td>
                                        <td>{{ @$model->mobile }}</td>
                                        <td>{{ \App\Report::getCenterOptions($model->center_id) }}</td>
                                        <td>{{\App\Report::getPhysicianOptions($model->physician_id)}}</td>
                                        <td>
                                            <a href="{{ url("user/reports/".$model->id.'/edit') }}"><i
                                                        class="fa fa-eye"></i> </a>


                                             {!! Form::open(['style' => 'display: inline;', 'method' => 'DELETE', 'onsubmit' => 'return confirm(\'Are you sure you want to delete ? \');',  'route' => array('reports.destroy', $model->id)]) !!}
                                             <button type="submit" class="btn btn-xs btn-danger"><i
                                                         class="fa fa-remove"></i></button>
                                             {!! Form::close() !!}
                                            @if(\Auth::user()->role_id == \App\User::ROLE_AGENT)
                                                <a href="{{ url("user/reports/".$model->id.'/duplicate') }}">
                                                    Dupliquer</a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach--}}
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
        $(document).ready(function () {

            $('.jambo_table').DataTable({
                "language": {
                    "search": "Rechercher",
                    "sLengthMenu": "Afficher _MENU_ entrées",
                    "sInfo": "Affichage _START_ de _END_ sur _TOTAL_ entrées",
                    paginate: {
                        previous: 'Précédent',
                        next: 'Suivant'
                    },

                },
                "columnDefs": [ {
                    "targets": 8,
                    "orderable": false
                }],
                "order": [[ 0, "desc" ]],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "{{ route('message.search.optimize') }}",

                "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

                    oSettings.jqXHR = $.ajax({
                        "dataType": 'json',
                        "type": "GET",
                        "url": sSource,
                        "data": aoData,
                        "success": fnCallback,
                        "error": function (e) {
                            console.log(e.message);
                        }
                    });
                },
                "aoColumns": [
                    {"mData": "client_name"},
                    {"mData": "lastname"},
                    {"mData": "name"},
                    {"mData": "date"},
                    {"mData": "address"},
                    {"mData": "phone"},
                    {"mData": "email"},
                    {"mData": "exam"},
                    {"mData": "options"}
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function () {
           $('.report_table').find('.row:first').addClass('search_report');

           /*$(document).on("click",".deleteConfirm",function () {
              if(confirm('Supprimer ?')){
                  $('#deleteReport').submit();
              }else {
                  return false;
              }
           });*/
        });
    </script>
    {{--
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>--}}
@endsection