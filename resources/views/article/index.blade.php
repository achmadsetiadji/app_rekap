@extends('layouts.app')
@section('title', 'Fitness Data')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/jquery.fileupload.css') }}" />
@endpush

@section('content')
    <x-card>
        <x-slot name="header" class="bg-white border-bottom-0 d-flex justify-content-between">
            <h5 class="card-title mt-3 mb-3">Article Table</h5>
            @canany(['create data fitness'])
                <button class="btn btn-primary" onclick="addForm('{{ route('article.store') }}', 'Add Articles')">
                    Add Article
                    <i class="fa-solid fa-plus"></i>
                </button>
            @endcanany
        </x-slot>

        <x-table class="expandable-table table-responsive">
            <x-slot name="thead">
                <th width="5%">#</th>
                <th>Name</th>                
                <th>Description</th>                
                <th width="5%">Action</th>
            </x-slot>
        </x-table>
    </x-card>

    @include('article.form')
@endsection

@push('js')
    <script src="{{ asset('js/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-process.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload-ui.js') }}"></script>
    <script>
        let table;

        table = $('.table').DataTable({
            processing: true,
            serverside: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('article.data') }}"
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
                    data: 'name'
                },
                {
                    data: 'description'
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
