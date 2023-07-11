function js_delete(route) {
    $.ajax({
        url: route,
        method: 'delete',
        dataType: 'JSON',
        success: function (response) {
            var tableId = response.data_table_id;
            var table = $('#' + tableId).DataTable();
            if (response.status == 200) {
                toastr.success('Record deleted successfully');
                table.ajax.reload(null, false);
            } else {
                toastr.error(response.data);
            }
        },
        error: function (response) {
            toastr.error('Data can not be deleted ');
        }
    })
};