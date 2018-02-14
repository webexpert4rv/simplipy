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
                    <h3>Rapports Mensuels
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
                                <small>des rapports générés mensuellement</small>
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
                        {{--<div class="col-md-12 row">
                            <div class="col-md-3" style="width: 23%">
                                <label for="designer_field">Agent: </label><input type="text" id="agent_field">
                            </div>
                            <div class="col-md-3" style="width: 23%">
                                <label for="industry_field">Center: </label>
                                <input type="text" id="center_field">
                              --}}{{--  <input type="checkbox" id="center1" value="1">Cardif 1
                                <input type="checkbox" id="center2" value="2">Cardif 2--}}{{--
                            </div>
                            <div class="col-md-3" style="width: 23%">
                                <label for="material_field">Daily: </label><input type="text" id="daily_field">
                                <p>(aaaa-mm-jj)</p>
                            </div>
                            <div class="col-md-3" style="width: 23%">
                                <label for="material_field">Monthly: </label><input type="text" id="monthly_field">
                                <p>(aaaa-mm)</p>
                            </div>
                        </div>--}}
                        <div class="x_content report_table">
                            <p class="text-muted font-13 m-b-30">
                                {{--  DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>--}}
                            </p>

                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                <tr class="headings">
                                   {{-- <th class="column-title" style="display: none">Sr.No.</th>--}}
                                    <th class="column-title">Date</th>
                                    <th class="column-title">Cardif 1 ✓</th>
                                    <th class="column-title">Cardif 1 x</th>
                                    <th class="column-title">Total for Cardif 1</th>
                                    <th class="column-title">Cardif 2 ✓</th>
                                    <th class="column-title">Cardif 2 x</th>

                                    <th class="column-title">Total for Cardif 2</th>
                                    <th class="column-title">Grand Total</th>
                                    <th class="column-title">
                                        Actions </a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($total as $totalReport)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($totalReport['date'])->format('M-Y')  }}</td>
                                        <td>{{ number_format($totalReport['cardif1_comp'])  }}</td>
                                        <td>{{ number_format($totalReport['cardif1_drop']) }}</td>
                                        <td>{{ number_format($totalReport['cardif1_comp'] + $totalReport['cardif1_drop']) }}</td>

                                        <td>{{ number_format($totalReport['cardif2_comp'])  }}</td>
                                        <td>{{ number_format($totalReport['cardif2_drop']) }}</td>

                                        <td>{{ number_format($totalReport['cardif2_comp'] + $totalReport['cardif2_drop']) }}</td>
                                        <td>{{ number_format($totalReport['totalReport']) }}</td>
                                        <td>
                                            {!! Form::open(['style' => 'display: inline;', 'method' => 'POST', 'route' => array('status.monthlyResend')]) !!}
                                            <input type="hidden" name="date" value="{{$totalReport['date']}}">
                                            <button type="submit" class="btn btn-xs btn-success">Réenvoyer</button>
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
        $('.jambo_table').DataTable({
            order: [0, "desc"],
            "language": {
                "search": "Rechercher",
                "sLengthMenu": "Afficher _MENU_ entrées",
                "sInfo": "Affichage _START_ de _END_ sur _TOTAL_ entrées",
                paginate: {
                    previous: 'Précédent',
                    next:     'Suivant'
                },

            }

        });
    </script>
    <script>
        $(document).ready(function () {
            $('.report_table').find('.row:first').addClass('search_report');
        });
    </script>


    {{--<script type="text/javascript">
        $(document).ready(function () {
            oTable = $('.jambo_table').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
            $('#agent_field').keyup(function(){
                // oTable.search($(this).val()).draw() ;
                oTable.column(1).search($(this).val()).draw();
            });
            $('#center_field').keyup(function(){
                // oTable.search($(this).val()).draw() ;
                oTable.column(7).search($(this).val()).draw();
            });
            $('#daily_field').keyup(function(){
                oTable.columns(2).search($(this).val()).draw();
            });
            $('#monthly_field').keyup(function(){
                oTable.columns(2).search($(this).val()).draw();
            });
        });
    </script>--}}
    {{--
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>--}}
@endsection
