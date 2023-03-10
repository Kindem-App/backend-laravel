@extends('admin.layouts.app')
@section('title')
Users
@endsection
@section('header')
<style>
    .ik {
        cursor: pointer;
    }

    #trHover:hover {
        background-color: #e6e6e6;
    }

    .jq-icon-success {
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAADsSURBVEhLY2AYBfQMgf///3P8+/evAIgvA/FsIF+BavYDDWMBGroaSMMBiE8VC7AZDrIFaMFnii3AZTjUgsUUWUDA8OdAH6iQbQEhw4HyGsPEcKBXBIC4ARhex4G4BsjmweU1soIFaGg/WtoFZRIZdEvIMhxkCCjXIVsATV6gFGACs4Rsw0EGgIIH3QJYJgHSARQZDrWAB+jawzgs+Q2UO49D7jnRSRGoEFRILcdmEMWGI0cm0JJ2QpYA1RDvcmzJEWhABhD/pqrL0S0CWuABKgnRki9lLseS7g2AlqwHWQSKH4oKLrILpRGhEQCw2LiRUIa4lwAAAABJRU5ErkJggg==);
        color: #ffffff;
        background-color: #2dce89;
        border-color: #ffffff;
    }

    .jq-icon-warning {
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGYSURBVEhL5ZSvTsNQFMbXZGICMYGYmJhAQIJAICYQPAACiSDB8AiICQQJT4CqQEwgJvYASAQCiZiYmJhAIBATCARJy+9rTsldd8sKu1M0+dLb057v6/lbq/2rK0mS/TRNj9cWNAKPYIJII7gIxCcQ51cvqID+GIEX8ASG4B1bK5gIZFeQfoJdEXOfgX4QAQg7kH2A65yQ87lyxb27sggkAzAuFhbbg1K2kgCkB1bVwyIR9m2L7PRPIhDUIXgGtyKw575yz3lTNs6X4JXnjV+LKM/m3MydnTbtOKIjtz6VhCBq4vSm3ncdrD2lk0VgUXSVKjVDJXJzijW1RQdsU7F77He8u68koNZTz8Oz5yGa6J3H3lZ0xYgXBK2QymlWWA+RWnYhskLBv2vmE+hBMCtbA7KX5drWyRT/2JsqZ2IvfB9Y4bWDNMFbJRFmC9E74SoS0CqulwjkC0+5bpcV1CZ8NMej4pjy0U+doDQsGyo1hzVJttIjhQ7GnBtRFN1UarUlH8F3xict+HY07rEzoUGPlWcjRFRr4/gChZgc3ZL2d8oAAAAASUVORK5CYII=);
        background-color: #fb6340;
        color: #ffffff;
        border-color: #ffffff;
    }

    .loader {
        border: 5px solid #f3f3f3;
        -webkit-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
        border-top: 5px solid #007bff;
        border-radius: 50%;
        width: 50px;
        height: 50px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .ik-edit {

        background-color: #28a745;
        color: white;
        padding: 5px;
        font-size: 20px;
        border-radius: 5px;
        margin-right: 5px
    }

    .ik-plus-square {

        background-color: #007bff;
        color: white;
        padding: 5px;
        font-size: 20px;
        border-radius: 5px;
        margin-right: 5px
    }

    .ik-trash-2 {

        background-color: #dc3545;
        color: white;
        padding: 5px;
        font-size: 20px;
        border-radius: 5px;

    }

    .edit-table:hover{
        cursor: pointer;
    }

    .delete:hover{
        cursor: pointer;
    }

    .radial-bar-danger {
        background-image: linear-gradient(90deg, #d6d6d6 50%, transparent 50%, transparent),linear-gradient(126deg, #F5A720 50%, #d6d6d6 50%, #d6d6d6);
    }
    .bg-red {
        background-color: #F5A720 !important;
    }
</style>
@endsection
@section('iconHeader')
<i class="ik ik-user bg-icon"></i>
@endsection
@section('titleHeader')
Users
@endsection
@section('subtitleHeader')

@endsection
@section('breadcrumb')
Users
@endsection
@section('content-wrapper')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <i class="ik ik-plus-square" onclick="addUserPage()" data-toggle="modal" data-target="#demoModal"></i>Tambah Data
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <div class="dt-responsive">
                            <table class="table table-bordered" id="data-table" style="width: 102%">
                                <thead>
                                    <tr>
                                        <th style="width: 3%"></th>
                                        <th>Email</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Terakhir Dilihat</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td style="width: 3%"></td>
                                        <th>Email</th>
                                        <th>Nama</th>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form id="form-user" class="text-left border border-light p-5" action="{{route('users.store')}}" method="POST"
                            enctype="multipart/form-data" style="padding-bottom: 50px;">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="form-group" id="email-form">
                                <label>Email</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <label class="input-group-text"><i class="ik ik-edit-1"></i></label>
                                    </span>
                                    <input type="text" class="form-control  " placeholder="Email" id="email" name="email"
                                        required>
                                </div>
                            </div>

                            <div class="form-group" id="password-form">
                                <label>Password</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <label class="input-group-text"><i class="ik ik-edit-1"></i></label>
                                    </span>
                                    <input type="password" class="form-control  " placeholder="Password" id="password"
                                        name="password" required>
                                </div>
                            </div>

                            <div class="form-group" id="name-form">
                                <label>Nama</label>
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <label class="input-group-text"><i class="ik ik-edit-1"></i></label>
                                    </span>
                                    <input type="text" class="form-control  " placeholder="Nama" id="nama" name="name"
                                        required>
                                </div>
                            </div>

                            <div class="footer-buttons">
                                <br>
                                <div id="user-loader" class="loader d-none"></div>

                                @if(Auth::user()->email == 'guest@kindem.my.id')
                                <button id="user-btn-add" class="btn btn-primary tooltip" disabled>
                                    Tambah
                                    <span class="tooltiptext">Guest Forbidden</span>
                                </button>
                                <button id="user-btn-edit" class="btn btn-success tooltip d-none" disabled>
                                    Update
                                    <span class="tooltiptext">Guest Forbidden</span>
                                </button>
                                <button id="user-btn-delete" class="btn btn-danger tooltip d-none" disabled>
                                    Delete
                                    <span class="tooltiptext">Guest Forbidden</span>
                                </button>
                                @else
                                <button id="user-btn-add" type="button" class="btn btn-primary" onclick="addUser()">
                                    Tambah
                                </button>
                                <button id="user-btn-edit" type="button" class="btn btn-success d-none" onclick="updateUser()">
                                    Update
                                </button>
                                <button id="user-btn-delete" type="button" class="btn btn-danger d-none" onclick="deleteUser()">
                                    Delete
                                </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div id="stats-loader" class="row d-none" style="text-align: -webkit-center;margin-top:20px">
                    <div class="col-md-12">
                        <div class="loader"></div>
                    </div>
                </div>
                <div class="row d-none" id="user-stats">
                    <div class="col-md-12">
                        <form class="text-left border border-light p-3" style="margin-top:20px">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 style="background-color: #007bff;color: white;padding: 10px;border-radius: 15px;">Informasi User</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card sale-card ">
                                        <div class="card-header">
                                            <h3>Level User</h3>
                                        </div>
                                        <div class="card-block text-center">
                                            <div id="percent-level">
                                                <div class="radial-bar radial-bar-0 radial-bar-lg radial-bar-danger">
                                                    <img src="{{url('assets/admin/img/user.png')}}" alt="User-Image">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5>Level : <span id="user_level_name">loading..</span></h5>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="s-caption bg-default"></div>
                                                    <div class="s-cont d-inline-block">
                                                        <h5 class="fw-700 mb-0" id="sisa_point"></h5>
                                                        <p class="mb-0">Sisa Point Dibutuhkan</p>
                                                    </div>
                                                </div>
                                                <div class="col-6 border-left">
                                                    <div class="s-caption bg-red"></div>
                                                    <div class="s-cont d-inline-block">
                                                        <h5 class="fw-700 mb-0" id="user_point"></h5>
                                                        <p class="mb-0">Jumlah Point Terkumpul </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card ticket-card">
                                        <div class="card-body">
                                            <p class="mb-30 bg-primary lbl-card"><i class="fas fa-folder-open"></i> Chapter Dikerjakan</p>
                                            <div class="text-center">
                                                <h2 class="mb-0 d-inline-block text-primary" id="chapter_complete"></h2>
                                                <p class="mb-0 d-inline-block">Chapter</p>
                                                <p class="mb-0 mt-15"><span id="chapter_incomplete"></span> Chapter tersisa yang belum dikerjakan</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card ticket-card">
                                        <div class="card-body">
                                            <p class="mb-30 bg-blue lbl-card"><i class="fas fa-file-archive"></i> Materi Dikerjakan</p>
                                            <div class="text-center">
                                                <h2 class="mb-0 d-inline-block text-blue" id="materi_complete"></h2>
                                                <p class="mb-0 d-inline-block">Materi</p>
                                                <p class="mb-0 mt-15"><span id="materi_incomplete"></span> Materi sisa yang belum dikerjakan</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card ticket-card">
                                        <div class="card-body">
                                            <p class="mb-30 bg-green lbl-card"><i class="fa fa-check-square" aria-hidden="true"></i> Jumlah Benar</p>
                                            <div class="text-center">
                                                <h2 class="mb-0 d-inline-block text-green" id="jumlah_benar"></h2>
                                                <p class="mb-0 d-inline-block">Benar</p>
                                                <p class="mb-0 mt-15">Sangat menguasai di Materi <span id="nama_materi_dikuasai"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card ticket-card">
                                        <div class="card-body">
                                            <p class="mb-30 bg-warning lbl-card"><i class="fa fa-window-close" aria-hidden="true"></i> Jumlah Salah</p>
                                            <div class="text-center">
                                                <h2 class="mb-0 d-inline-block text-warning" id="jumlah_salah"></h2>
                                                <p class="mb-0 d-inline-block">Salah </p>
                                                <p class="mb-0 mt-15">Kurang menguasai di Materi <span id="nama_materi_tidak_dikuasai"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="chart-loader" class="row d-none" style="text-align: -webkit-center;margin-top:20px">
                                <div class="col-md-12">
                                    <div class="loader"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p style="background-color: #007bff;color: white;text-align: center;padding: 7px;">Total Membuka Aplikasi Pada : </p>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control select2" name="" id="date_chart"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p style="background-color: #28a745;color: white;text-align: center;padding: 7px;">Total Mengerjakan Soal Pada : </p>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control select2" name="" id="materi_chart_select"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="chart-data">
                                <div class="col-md-12">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <canvas id="chLine" height="100"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->
@endsection
@section('footer')
<script src="{{ url('assets/admin/dynamictable/dynamitable.jquery.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
var myChart
$('#date_chart').change(function(){
    myChart.destroy()
    initChart()
})

$('#materi_chart_select').change(function(){
    myChart.destroy()
    initChart()
})

function initSelectChart()
{
    var id = $('#id').val()
    $('#date_chart').html('')
    $.ajax({
            async: false,
            url: `{{url("/chart?user_id=`+id+`")}}`,
            type: "GET",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(jqXHR, settings) {
                // console.log(settings.url);
            },
            statusCode: {
                500: function (response) {
                    console.log(response)
                },
            },
            success: function (data) {
                var html = ``
                var materi = ``
                jQuery.each(data.data, function(value) {
                    html += `<option value='${value}'>${value}</option>`
                });
                jQuery.each(data.materi, function(value) {
                    materi += `<option value='${value}'>${value}</option>`
                });

                if(html == ''){
                    $('#date_chart').html('<option selected disabled>Data tidak tersedia</option>')
                }else{
                    $('#date_chart').html(html)
                }

                if(materi == ''){
                    $('#materi_chart_select').html('<option selected disabled>Data tidak tersedia</option>')
                }else{
                    $('#materi_chart_select').html(materi)
                }
            }
        });
}
function initChart(){
    $('#chart-loader').removeClass('d-none')
    $('#date_chart').addClass('d-none')
    $('#chart-data').addClass('d-none')
    var result_item = ""
    var minggu = ''
    var senin = ''
    var selasa = ''
    var rabu = ''
    var kamis = ''
    var jumat = ''
    var sabtu = ''

    var result_item_materi = ""
    var minggu_materi = ''
    var senin_materi = ''
    var selasa_materi = ''
    var rabu_materi = ''
    var kamis_materi = ''
    var jumat_materi = ''
    var sabtu_materi = ''

    var id = $('#id').val()
    // console.log(id)
    $.ajax({
            async: false,
            url: `{{url("/chart?user_id=`+id+`")}}`,
            type: "GET",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(jqXHR, settings) {
                // console.log(settings.url);
            },
            statusCode: {
                500: function (response) {
                    console.log(response)
                },
            },
            success: function (data) {
                // console.log(data.data)
                $('#chart-loader').addClass('d-none')
                $('#date_chart').removeClass('d-none')
                $('#chart-data').removeClass('d-none')

                result_item = data.data[$('#date_chart').val()]
                senin = result_item.find(o => o.week_day === 0) == null ? '0' : result_item.find(o => o.week_day === 0).count
                selasa = result_item.find(o => o.week_day === 1) == null ? '0' : result_item.find(o => o.week_day === 1).count
                rabu = result_item.find(o => o.week_day === 2) == null ? '0' : result_item.find(o => o.week_day === 2).count
                kamis = result_item.find(o => o.week_day === 3) == null ? '0' : result_item.find(o => o.week_day === 3).count
                jumat = result_item.find(o => o.week_day === 4) == null ? '0' : result_item.find(o => o.week_day === 4).count
                sabtu = result_item.find(o => o.week_day === 5) == null ? '0' : result_item.find(o => o.week_day === 5).count
                minggu = result_item.find(o => o.week_day === 6) == null ? '0' : result_item.find(o => o.week_day === 6).count

                result_item_materi = data.materi[$('#materi_chart_select').val()]
                senin_materi = result_item_materi.find(o => o.week_day === 0) == null ? '0' : result_item_materi.find(o => o.week_day === 0).count
                selasa_materi = result_item_materi.find(o => o.week_day === 1) == null ? '0' : result_item_materi.find(o => o.week_day === 1).count
                rabu_materi = result_item_materi.find(o => o.week_day === 2) == null ? '0' : result_item_materi.find(o => o.week_day === 2).count
                kamis_materi = result_item_materi.find(o => o.week_day === 3) == null ? '0' : result_item_materi.find(o => o.week_day === 3).count
                jumat_materi = result_item_materi.find(o => o.week_day === 4) == null ? '0' : result_item_materi.find(o => o.week_day === 4).count
                sabtu_materi = result_item_materi.find(o => o.week_day === 5) == null ? '0' : result_item_materi.find(o => o.week_day === 5).count
                minggu_materi = result_item_materi.find(o => o.week_day === 6) == null ? '0' : result_item_materi.find(o => o.week_day === 6).count
            }
        });


    var data_chart = [senin,selasa,rabu,kamis,jumat,sabtu,minggu]
    var data_materi = [senin_materi,selasa_materi,rabu_materi,kamis_materi,jumat_materi,sabtu_materi,minggu_materi]
    var colors = ['#007bff','#28a745','#333333','#c3e6cb','#dc3545','#6c757d'];
    var session = $('#date_chart').val()
    var materi = $('#materi_chart_select').val()
    var chartData = {
    labels: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
    datasets: [{
        label: ["Total Membuka Aplikasi (" + session + ")"],
        data: data_chart,
        backgroundColor:  colors[0],
        borderColor: colors[0],
        borderWidth: 4,
        pointBackgroundColor: colors[0]
    },{
        label: ["Total Mengerjakan Soal (" + materi + ")"],
        data: data_materi,
        backgroundColor: colors[1],
        borderColor: colors[1],
        borderWidth: 4,
        pointBackgroundColor: colors[1]
    }]
    };

    if (chLine) {
    myChart = new Chart(chLine, {
    type: 'line',
    data: chartData,
    options: {
        scales: {
        yAxes: [{
            ticks: {
            beginAtZero: false
            }
        }]
        },
        legend: {
        display: false
        }
    }
    });
    }
}

</script>

<script type="text/javascript">
var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            "initComplete": function (settings, json) {
                $("#data-table").wrap(
                    "<div class='scroll' style='overflow:auto; width:100%;position:relative;padding-left:20px;padding-bottom:20px'></div>"
                );
            },
            ajax: "{{ route('users.index') }}",
            columns: [{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'last_seen',
                    name: 'last_seen',
                    orderable: false,
                    searchable: false
                },

            ]
        });

    $(document).ready(function () {
        $('#data-table tfoot th').each(function () {
            var title = $('#data-table thead th').eq($(this).index()).text();
            $(this).html('<input type="text" class="form-control" placeholder="Search ' + title +
                '" />');
        });

        $('tfoot').each(function () {
            $(this).insertAfter($(this).siblings('thead'));
        });

        table.columns().eq(0).each(function (colIdx) {
            $('input', table.column(colIdx).footer()).on('keyup change', function () {
                // console.log(colIdx + '-' + this.value);
                table
                    .column(colIdx)
                    .search(this.value)
                    .draw();
            });
        });

    });

</script>
<script>
    function addUserPage()
    {
        if(myChart){
            myChart.destroy()
        }else{
            // console.log('kosong')
        }
        $('#user-btn-add').removeClass('d-none')
        $('#user-btn-edit').addClass('d-none')
        $('#user-btn-delete').addClass('d-none')

        $('#password-form').removeClass('d-none')
        $('#user-stats').addClass('d-none')

        $('#id').val('')
        $('#email').val('')
        $('#nama').val('')
    }

    function editUserPage(id,email,name)
    {
        if(myChart){
            myChart.destroy()
        }else{
            // console.log('kosong')
        }
        $('#user-btn-add').addClass('d-none')
        $('#user-btn-edit').removeClass('d-none')
        $('#user-btn-delete').addClass('d-none')

        $('#password-form').removeClass('d-none')
        $('#id').val(id)
        $('#email').val(email)
        $('#nama').val(name)

        userStatistic(id)
    }

    function deleteUserPage(id,email,name)
    {
        if(myChart){
            myChart.destroy()
        }else{
            // console.log('kosong')
        }
        $('#user-btn-add').addClass('d-none')
        $('#user-btn-edit').addClass('d-none')
        $('#user-btn-delete').removeClass('d-none')
        $('#user-stats').addClass('d-none')
        $('#password-form').addClass('d-none')
        $('#id').val(id)
        $('#email').val(email)
        $('#nama').val(name)
    }

    function addUser(){
        $('#user-loader').removeClass('d-none')
        $('#user-btn-add').addClass('d-none')
        var data = new FormData($('#form-user')[0]);
        // console.log(data)
        $.ajax({
            url: '{{route('users.store')}}',
            type: "POST",
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            data: data,
            statusCode: {
                500: function (response) {
                    console.log(response)
                    $.toast({
                        heading: 'Error',
                        text: 'Pastikan data sudah diisi semua dan tidak ada yang kosong',
                        showHideTransition: 'slide',
                        icon: 'error',
                        loaderBg: '#f2a654',
                        position: 'bottom-right'
                    })
                    $('#user-loader').addClass('d-none')
                    $('#user-btn-add').removeClass('d-none')
                },
            },
            success: function (data) {
                $("#form-user")[0].reset()
                $.toast({
                    heading: 'User Ditambahkan',
                    text: 'Data user berhasil ditambahkan',
                    position: 'bottom-right',
                    icon: 'success',
                    stack: false,
                    loaderBg: '#f96868'
                })
                $('#user-loader').addClass('d-none')
                $('#user-btn-add').removeClass('d-none')
                table.ajax.reload()
            }
        });
    }

    function updateUser() {
        $('#user-loader').removeClass('d-none')
        $('#user-btn-edit').addClass('d-none')
        var data = new FormData($('#form-user')[0]);
        $.ajax({
            url: '{{route('updateUser')}}',
            type: "POST",
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            statusCode: {
                500: function (response) {
                    console.log(response)
                },
            },
            success: function (data) {
                $('#user-loader').addClass('d-none')
                $('#user-btn-edit').removeClass('d-none')
                $("#form-user")[0].reset()
                $.toast({
                    heading: 'User Diperbarui',
                    text: 'Data user berhasil diperbarui',
                    position: 'bottom-right',
                    icon: 'success',
                    stack: false,
                    loaderBg: '#f96868'
                })
                addUserPage()

                table.ajax.reload();
            }
        });
    }

    function deleteUser()
    {
        $('#user-loader').removeClass('d-none')
        $('#user-btn-delete').addClass('d-none')
        $.ajax({
            url: '{{route('users.destroy',"id")}}',
            type: "DELETE",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': $('#id').val(),
            },
            statusCode: {
                500: function (response) {
                    console.log(response)
                },
            },
            success: function (data) {
                    $.toast({
                        heading: 'User Dihapus',
                        text: 'Data user berhasil dihapus',
                        position: 'bottom-right',
                        icon: 'success',
                        stack: false,
                        loaderBg: '#f96868'
                    })
                    $('#user-loader').addClass('d-none')
                    addUserPage()
                table.ajax.reload()
            }
        });
    }

    function userStatistic(user_id)
    {
        $('#user-stats').addClass('d-none')
        $('#stats-loader').removeClass('d-none')
        $.ajax({
            url: `{{url("/userStatistic?user_id=`+user_id+`")}}`,
            type: "GET",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(jqXHR, settings) {
                console.log(settings.url);
            },
            statusCode: {
                500: function (response) {
                    console.log(response)
                },
            },
            success: function (data) {
                $('#user-stats').removeClass('d-none')
                $('#chapter_complete').text(data.data[0].chapter_complete)
                $('#chapter_incomplete').text(data.data[0].chapter_incomplete)
                $('#jumlah_benar').text(data.data[0].jumlah_benar)
                $('#jumlah_salah').text(data.data[0].jumlah_salah)
                $('#materi_complete').text(data.data[0].materi_complete)
                $('#materi_incomplete').text(data.data[0].materi_incomplete)
                $('#nama_materi_dikuasai').text(data.data[0].nama_materi_dikuasai)
                $('#nama_materi_tidak_dikuasai').text(data.data[0].nama_materi_tidak_dikuasai)
                $('#sisa_point').text(data.data[0].sisa_point)
                $('#user_level_name').text(data.data[0].user_level_name)
                $('#user_point').text(data.data[0].user_point)
                $('#percent-level').html('')
                var percent_level = `<div class="radial-bar radial-bar-${data.data[0].percent} radial-bar-lg radial-bar-danger">
                    <img src="{{url('assets/admin/img/user.png')}}" alt="User-Image">
                    </div>`
                $('#percent-level').html(percent_level)
                $('#stats-loader').addClass('d-none')

                initSelectChart()
                initChart()
            }
        });
    }
</script>

@endsection
