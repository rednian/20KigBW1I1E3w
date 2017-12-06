<?php $this->load->view('curriculum/modal/modal-set-curriculum'); ?>

<div id="content" class="content">

    <div class="row">
        <!-- LEFT SIDE -->
        <div class="col-lg-5">
            <div class="panel panel-primary">
                <div class="panel-heading clearfix">
                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="panel-title">Curriculum List</h4>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input onkeyup="searchCurriculum($(this).val())" type="text" class="form-control">
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="table-list-curr" class="table" style="margin-top:0px!important">
                        <thead class="hide">
                            <tr>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- RIGHT SIDE -->
        <div class="col-lg-7">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">Curriculum Preview</h4>
                </div>
                <div class="panel-body" id="currPreviewContainer">
                    <p>Please select curriculum to view . . .</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MODAL -->