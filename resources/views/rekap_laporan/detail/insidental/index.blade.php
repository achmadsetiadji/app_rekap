@extends('layouts.app')
@section('title', 'Ketentuan Insidental Data')

@section('content')
    <x-card class="mt-3">
        <x-slot name="header" class="bg-white border-bottom-0 d-flex justify-content-between">
            <h5 class="card-title mt-3 mb-3">Ketentuan Insidental Table</h5>
        </x-slot>

        <x-table class="expandable-table table-responsive">
            <x-slot name="thead">
                <th width="5%">#</th>                
                <th>Periodasi</th>
                <th>Kategori</th>
                <th>Nama Laporan</th>
                <th>Deadline Pengiriman</th>
                <th>Ketentuan POJK</th>
                <th>Ketentuan Pasal</th>
                <th>Sanksi</th>
            </x-slot>
        </x-table>
    </x-card>
@endsection

@push('js')
    <script>
        let table;

        table = $('.table').DataTable({
            processing: true,
            serverside: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('rekap_laporan.detail.insidental.data') }}"
            },
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": 0
                },
                {
                    width: 20,
                    targets: 0
                },
                // Add text wrapping for content columns
                {
                    "targets": [1, 2, 3, 4, 5, 6, 7],
                    "className": "text-wrap",
                    "width": "auto",
                    "render": function(data, type, full, meta) {
                        if (type === 'display' && data != null) {
                            return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
                        }
                        return data;
                    }
                }
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'periodasi'
                },
                {
                    data: 'kategori'
                },
                {
                    data: 'nama_laporan'
                },
                {
                    data: 'deadline_pengiriman'
                },
                {
                    data: 'ketentuan_pojk'
                },
                {
                    data: 'ketentuan_pasal'
                },
                {
                    data: 'sanksi'
                }
            ],
            // Add these options to improve responsiveness
            responsive: true,
            scrollX: false,
            // Define a reasonable width for the table
            "dom": '<"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        });
    </script>

    <style>
        /* Add custom styles to improve text wrapping */
        .dataTables_wrapper .text-wrap {
            white-space: normal !important;
        }
        
        .table td {
            max-width: 200px; /* Set a maximum width for all cells */
            vertical-align: top;
            word-break: break-word;
        }
    </style>
@endpush