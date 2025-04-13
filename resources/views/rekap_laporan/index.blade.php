@extends('layouts.app')
@section('title', 'Rekap Laporan Data')

@section('content')
    <x-card>
        <div class="row">
            <div class="col pr-lg-2 m-1">
                <x-card class="text-center bg-success text-white cursor-pointer" data-role="">
                    <div class="d-flex align-items-center justify-content-center">
                        <strong class="fs-30 mb-2">{{formatUang($tepat_waktu)}}</strong>
                        <b><p class="d-inline-block ml-2">Tepat Waktu</p></b>
                    </div>
                </x-card>
            </div>

            <div class="col pr-lg-2 m-1">
                <x-card class="text-center bg-danger text-white cursor-pointer" data-role="">
                    <div class="d-flex align-items-center justify-content-center">
                        <strong class="fs-30 mb-2">{{formatUang($terlambat)}}</strong>
                        <b><p class="d-inline-block ml-2">Terlambat</p></b>
                    </div>
                </x-card>
            </div>

            <div class="col pr-lg-2 m-1">
                <x-card class="text-center bg-orange text-white cursor-pointer" data-role="">
                    <div class="d-flex align-items-center justify-content-center">
                        <strong class="fs-30 mb-2">{{formatUang($tidak_lapor)}}</strong>
                        <b><p class="d-inline-block ml-2">Tidak Lapor</p></b>
                    </div>
                </x-card>
            </div>

            <div class="col pr-lg-2 m-1">
                <x-card class="text-center bg-info text-white cursor-pointer" data-role="">
                    <div class="d-flex align-items-center justify-content-center">
                        <strong class="fs-30 mb-2">{{formatUang($terkirim)}}</strong>
                        <b><p class="d-inline-block ml-2">Terkirim</p></b>
                    </div>
                </x-card>
            </div>
        </div>
    </x-card>

    <x-card class="mt-3">
        <x-slot name="header" class="bg-white border-bottom-0 d-flex justify-content-between">
            <h5 class="card-title mt-3 mb-3">Rekap Laporan Table</h5>
        </x-slot>

        <x-table class="expandable-table table-responsive">
            <x-slot name="thead">
                <th width="5%">#</th>
                <th>Nama BPR</th>
                <th width="5%">Action</th>
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
                url: "{{ route('rekap_laporan.data') }}"
            },
            "columnDefs": [{
                    "orderable": false,
                    "targets": 0
                },
                {
                    width: 20,
                    targets: 0
                }
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'nama_ljk'
                },
                {
                    data: 'action',
                    searchable: false,
                    sortable: false
                },
            ]
        });
    </script>
@endpush
