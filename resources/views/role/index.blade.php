@extends('admin.layouts.app')


@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="col-lg-12 grid-margin stretch-card py-3">
        <div class="card">
            <div class="card-body">
                @can('role-create')
                <div class="float-right px-2 py-2">
                    <a role="button" href="{{ route('admin.role.create') }}" class="btn btn-primary">Add
                        Role</a>
                </div>
                @endcan
                <h4 class="card-title">Roles Table</h4>
                <div class="table-responsive">
                    <div class="table table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    {!! $dataTable->scripts() !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).on('click', '#delete', function() {
            var id = $(this).val();
            var url = "{{ route('admin.role.delete', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Data!..",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                })
                .then((willDelete) => {
                    if (willDelete) {
                        js_delete(url);
                    }
                });
        });
    </script>
@endpush
