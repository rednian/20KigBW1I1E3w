<div id="modalScheduleList" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Schedule List</h4>
            </div>
            <div class="modal-body">
                <table id="tblSchedule" class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>div Code</th>
                        <th>Program</th>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>SY</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">


    function loadScheduleList() {

        var tblSchedule = $('#tblSchedule').DataTable({
            "bSort": false,
            "bLength": false,
            "bInfo": false,
            destroy: true,
            processing: true,
            ajax: '<?php echo base_url('course/getSectionList') ?>',
            columns: [
                {'data': 'sec_code'},
                {'data': 'prog_name'},
                {'data': 'year_lvl'},
                {'data': 'semister'},
                {'data': 'sy'},
                {'data': 'activation'},
                {
                    'data': 'bs_id', render: function (id) {
                    return '<button onclick="viewScheduleSection(' + id + ')" class="btn btn-xs pull-right"><span class="fa fa-folder-open-o"></span> view</button>';
                }
                }
            ]
        });

    }

</script>