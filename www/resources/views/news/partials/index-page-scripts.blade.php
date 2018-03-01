<script>
    var dtInit = {
        processing: true,
        serverSide: true,
        buttons: [
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [ 0,1,2,3,4,6,7,5],
                    orthogonal: 'export',
                    stripNewlines: false
                },
                customize : function(doc) {
                    doc.content[0].text = "",
                    doc.content[1].table.widths = [ '16%', '30%', '10%', '10%', '7%','6%','6%', '15%'],
                    doc.content[2].table.heights = ['100px'];
                }      
            }
        ],
        ajax: {
            url: '{!! route('news.datatables') !!}',
            type: "POST",
            data: function (filt) {
                filt.date_from = $('input[name="date_from"]').val();
                filt.date_to = $('input[name="date_to"]').val();
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columnDefs: [
            {"targets": [-1], "orderable": false, "searchable": false},
        ],
        columns: [
            {data: 'name'},
            {data: 'description', 
                render: function(data, type){
                    return type === 'export' ? data : data.length > 60 ? data.substr(0, 50)+"..." : data;
                }
            },
            {data: 'created_at',
                render: function(data, type){
                    return type === 'export' ? data.substr(0, 10) : data;
                }  
            },

            {data: 'actions', className:"text-center", defaultContent: "--------"}
        ],
        language: dtLanguage,
        lengthMenu: dtLengthMenu,
        dom: "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'row'<'col-md-6 col-sm-12'B>><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
    };

    $(document).ready(function () {
        var table = $('#table').DataTable(dtInit);
        Tooltip.init();
        table.on('draw.dt', function () {
            Tooltip.init();
        });
        DatePicker.init();

        $('.filter').change(function () {
            table.draw();
        });
        $('#container').css( 'display', 'block' );
        table.columns.adjust().draw();
});
</script>
