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
                                        <option value=""> -- Select Agent --</option>
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
                                    <option value=""> -- Select Center --</option>
                                    @foreach(\App\Report::getCenterOptions() as $key => $center)
                                        <option value="{{ $key }}"> {{ $center }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" style="width: 20%">
                                <label for="material_field">Daily: </label>
                                <input class="form-control datepicker" type="text" id="daily_field"
                                       value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                {{--<p>(aaaa-mm-jj)</p>--}}
                            </div>
                            <div class="col-md-2" style="width: 20%">
                                <label for="material_field">Monthly: </label>
                                <select class="form-control" id="monthly_field">
                                    <option value=""> -- Select Month --</option>
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
        $(".datepicker").datepicker({format: "yyyy-mm-dd", autoclose: true, endDate: new Date()});
        $(".datepicker").datepicker('clearDates');
    </script>
    <script>
        function reload_table() {
            $('.jambo_table').DataTable().ajax.reload(null, false); // Reload datatable ajax
        }

        $(document).ready(function () {

            $("#agent_field").on("change",function () {

                var filter_agent = $(this).val();

                if(filter_agent != null){
                    reload_table();
                }
            });

            $("#center_field").on("change",function () {

                var filter_center = $(this).val();

                if(filter_center != null){
                    reload_table();
                }
            });

            $("#monthly_field").on("change",function () {

                var filter_monthly = $(this).val();

                if(filter_monthly!= null){
                    reload_table();
                }
            });

            $('.datepicker').datepicker().on('changeDate', function(e) {

                var filter_daily = e.date;
                if(filter_daily != null){
                    reload_table();
                }
            });

        });

        $('.jambo_table').DataTable({
            "language": {
                "search": "Rechercher",
                "sLengthMenu": "Afficher _MENU_ entrées",
                "sInfo": "Affichage _START_ de _END_ sur _TOTAL_ entrées",
                paginate: {
                    previous: 'Précédent',
                    next: 'Suivant'
                }
            },
            "columnDefs": [ {
                "targets": 7,
                "orderable": false
            }],
            "order": [[ 1, "desc" ]],
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "{{ route('reports-optimize') }}",
            /*"fnServerData": function ( sSource, aoData, fnCallback ) {
                /!* Add some extra data to the sender *!/
                aoData.push( { "name": "filter_agent", "value": "my_value" } );
                $.getJSON( sSource, aoData, function (json) {
                    /!* Do whatever additional processing you want on the callback, then tell DataTables *!/
                    fnCallback(json)
                } );
            },*/
            "fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {

                if($("#agent_field").val() != null){
                    aoData.push( { "name": "filter_agent", "value": $("#agent_field").val() } );
                }

                if($("#center_field").val() != null){
                    aoData.push( { "name": "filter_center", "value": $("#center_field").val() } );
                }

                if($("#daily_field").val() != null){
                    aoData.push( { "name": "filter_daily", "value": $("#daily_field").val() } );
                }

                if($("#monthly_field").val() != null){
                    aoData.push( { "name": "filter_monthly", "value": $("#monthly_field").val() } );
                }

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
                { "mData": "agent" },
                { "mData": "created_at" },
                { "mData": "report" },
                { "mData": "company" },
                { "mData": "mobile" },
                { "mData": "center" },
                { "mData": "physician" },
                { "mData": "options" }
            ]

        });


    </script>
    <script>
        $(document).ready(function () {
            $('.report_table').find('.row:first').addClass('search_report');
        });
    </script>

    <script type="text/javascript">
        /*$(document).ready(function () {
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
        });*/


        $(document).on("click",".deleteConfirm",function () {
            if(confirm('Supprimer ?')){
                $('#deleteReport').submit();
            }else {
                return false;
            }
        });
    </script>
    {{--
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>--}}
@endsection
