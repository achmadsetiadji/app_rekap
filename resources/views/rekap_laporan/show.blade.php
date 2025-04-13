@extends('layouts.app')
@section('title', 'Rekap Laporan Data')

@section('content')
    <x-card>
        <x-slot name="header" class="bg-white border-bottom-0 d-flex justify-content-between">
            <h5 class="card-title mt-3 mb-3">
                <a href="{{ route('rekap_laporan.index') }}">Rekap Laporan</a> / Rekap Laporan {{ $rekap_laporan->nama_ljk }}
            </h5>
        </x-slot>

        <x-table class="table expandable-table table-responsive">
            <x-slot name="thead">
                <th width="5%">#</th>
                <th>Jenis Laporan</th>
                <th>Status Submit Laporan</th>
                <th>Tanggal Upload</th>
                <th>Batas Akhir</th>
                <th width="5%">Action</th>
            </x-slot>
        </x-table>
    </x-card>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let table;

        let dataUrl = "{{ route('rekap_laporan.show_data', ['nama_ljk' => $rekap_laporan->nama_ljk]) }}";

        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: dataUrl
            },
            columnDefs: [{
                    orderable: false,
                    targets: 0
                },
                {
                    width: '20px',
                    targets: 0
                }
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'jenis_laporan'
                },
                {
                    data: 'status_submit_laporan'
                },
                {
                    data: 'tgl_upload',
                    render: function(data, type, row) {
                        return data ? formatDate(data) : '-'; // Format the upload date
                    }
                },
                {
                    data: 'tgl_batas_akhir',
                    render: function(data, type, row) {
                        return data ? formatDate(data) : '-'; // Format the due date
                    }
                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false
                }
            ]
        });

        // Helper function to format date (e.g., "YYYY-MM-DD" to "DD MMM YYYY")
        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return date.toLocaleDateString('id-ID', options); // Use Indonesian locale
        }

        // Event listener to open modal and fetch data
        $(document).on('click', '.open-modal-btn', function() {
            const jenis_laporan = $(this).data('jenis_laporan');
            const status_submit_laporan = $(this).data('status_submit_laporan');

            $('#modalContent').html('Loading...');

            $.get("{{ url('rekap_laporan_detail') }}/" + encodeURIComponent(jenis_laporan), function(data) {
                // Determine the correct value for sanksi
                const sanksiContent = (status_submit_laporan === "Tidak Lapor" || status_submit_laporan ===
                        "Terlambat") ?
                    data.sanksi :
                    "-";

                let html = `
        <strong>Nama Laporan:</strong> ${data.nama_laporan}<br>
        <strong>Kategori:</strong> ${data.kategori}<br>
        <strong>Periodasi:</strong> ${data.periodasi}<br>
        <strong>Deadline:</strong> ${data.deadline_pengiriman}<br>
        <strong>Ketentuan POJK:</strong> ${data.ketentuan_pojk}<br>
        <strong>Ketentuan Pasal:</strong> ${data.ketentuan_pasal}<br>
        <strong>Sanksi:</strong>
        <pre class="mb-0" style="white-space: pre-wrap; word-break: break-word;">${sanksiContent}</pre>
    `;

                $('#modalContent').html(html);

                const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                modal.show();
            }).fail(function() {
                $('#modalContent').html('<div class="text-danger">Gagal memuat data laporan.</div>');
            });

        });
    </script>
@endpush