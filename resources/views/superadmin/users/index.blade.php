@extends('layouts.app')
@section('title', 'Data User')

@section('content')
    <x-card>
        <div class="row">
            <div class="col pr-lg-2 m-1">
                <x-card class="text-center bg-f2f2f2 cursor-pointer" data-role="">
                    <div class="d-flex align-items-center justify-content-center">
                        <strong class="fs-30 mb-2 text-black">{{ formatUang($countAllUsersByRoles) }}</strong>
                        <p class="d-inline-block ml-2">Total User</p>
                    </div>
                </x-card>
            </div>

            @foreach ($usersByRoles as $role)
                <div class="col pr-lg-2 m-1">
                    <x-card class="text-center bg-f2f2f2 cursor-pointer" data-role="{{ $role->name }}">
                        <div class="d-flex align-items-center justify-content-center">
                            <strong
                                class="fs-30 mb-2 text-{{ auth()->user()->getRoleColor($role->name) }}">{{ formatUang($role->users_count) }}</strong>
                            <p class="d-inline-block ml-2 text-capitalize">{{ $role->name }}</p>
                        </div>
                    </x-card>
                </div>
            @endforeach
        </div>
    </x-card>

    <x-card class="mt-3">
        <x-slot name="header" class="bg-white border-bottom-0 d-flex justify-content-between">
            <h5 class="card-title mt-3 mb-3">Data User</h5>
            <button class="btn btn-primary"
                onclick="addForm('{{ route(auth()->user()->role . '.user.store') }}', 'Add User')">
                Add User
                <i class="fa-solid fa-plus"></i>
            </button>
        </x-slot>

        <x-table class="expandable-table table-responsive">
            <x-slot name="thead">
                <th width="5%">#</th>
                <th>Nama User</th>
                <th>Email</th>
                <th>Peranan User</th>
                <th width="15%">Aksi</th>
            </x-slot>
        </x-table>
    </x-card>

    @include('superadmin.users.form')
@endsection

@push('js')
    <script>
        let table;

        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route(auth()->user()->role . '.user.data') }}',
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
                    name: 'DT_RowIndex',
                    className: 'text-center',
                    searchable: false
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'role',
                    searchable: false,
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'action',
                    searchable: false,
                    sortable: false
                },
            ]
        });

        $('[data-role]').on('click', function() {
            table.ajax.url(`{{ route(auth()->user()->role . '.user.data') }}?role=${this.dataset.role}`).load()
        })
    </script>
@endpush
