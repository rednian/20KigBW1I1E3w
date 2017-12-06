<style type="text/css">
  #modalSubjectScheduling .modal-dialog.modal-lg{
    width:1300px!important;
  }
  .fc-toolbar {
    margin-bottom: 0px!important;
  }
  .select2-container.select2-container-multi.form-control {
    
     width: 100%!important; 
  }
  .tbl_subject td{
    border-top:none!important;
  }
  .tbl_subject tr{
    cursor: pointer
  }
</style>
<div id="content" class="content">

	
	<!-- <div class="form-group m-l-0">
		<button onclick="loadScheduleList();$('#modalScheduleList').modal('show')" class="btn btn-info ">Schedule List</button> 
	</div> -->
	<div id="setScheduleContent" class="row p-t-10 p-b-10 m-b-10" style="background: #154360;border-radius: 5px;color:#FFF!important">
		<div class="col-md-3 border-r">
			<small>Schedule is set for:</small><br>
			<span class="schedDetailsProgram">...</span>
		</div>
		<div class="col-md-2 border-r">
			<small>Major</small><br>
			<span class="schedDetailsMajor">...</span>
		</div>
		<div class="col-md-1 border-r">
			<small>Year Level</small><br>
			<span class="schedDetailsYear">...</span>
		</div>
		<div class="col-md-1 border-r">
			<small>Semester</small><br>
			<span class="schedDetailsSemister">...</span>
		</div>
		<div class="col-md-1 border-r">
			<small>School year</small><br>
			<span class="schedDetailsSY">...</span>
		</div>
		<div class="col-md-1 border-r">
			<small>Section Code</small><br>
			<span class="schedDetailsSection">...</span>
		</div>
		<!-- <div class="col-md-1">
			<small>Curriculum</small><br>
			<span>2014-2015</span>
		</div> -->
		<div class="col-md-1">
			<button onclick="loadScheduleList();$('#modalScheduleList').modal('show')" class="btn btn-info btn-sm">Sections Schedules</button> 
		</div>
		<div class="col-md-2" id="buttonContainer">
			<button onclick="$('#setSchedModal').modal('show');" class="btn btn-sm btn-success pull-right m-l-5">Set Section</button>
		</div>			
	</div>
	<div class="row">
		<!-- LEFT -->
		<!-- <div class="col-lg-6">
			<div class="row p-t-5 p-b-5" style="background: #154360;color:#FFF;border-radius:5px">
				<div class="col-md-12 clearfix">Lecture Room <small class="pull-right">Total Rooms: <?php echo count($lectureRooms); ?></small></div>
			</div>
			<div class="row m-t-5">
				<div class="col-md-12 p-l-0 p-r-5">

		            <?php //foreach ($lectureRooms as $key => $value): ?>
		            	<div class="panel panel-info">
			                <div class="panel-heading clearfix">
			                    <span class="panel-title"><?php echo $value->room_code ?></span>
			                    <small class="pull-right">Available Time Percentage: 27%</small>
			                </div>
			                <div class="panel-body p-t-10 p-l-10 p-r-10 p-b-10">
			                	<div class="roomCalendar" id="<?php echo $value->room_code ?>"></div>
			                </div>
			                <div class="panel-footer clearfix">
			                	<small class="pull-right">Total Unit Plotted: 27</small>
			                </div>
			            </div>
		            <?php //endforeach ?>
		            
				</div>
			</div>
		</div> -->
		<!-- RIGHT -->
		<!-- <div class="col-lg-6">
			<div class="row p-t-5 p-b-5" style="background: #154360;color:#FFF;border-radius:5px">
				<div class="col-md-12 clearfix">Laboratory Room <small class="pull-right">Total Rooms: <?php echo count($labRooms); ?></small></div>
			</div>
			<div class="row m-t-5">
				<div class="col-md-12 p-l-5 p-r-0">
					<?php //foreach ($labRooms as $key => $value): ?>	
		            	<div class="panel panel-info">
			                <div class="panel-heading clearfix">
			                    <span class="panel-title"><?php echo $value->room_code ?></span>
			                    <small class="pull-right">Available Time Percentage: 27%</small>
			                </div>
			                <div class="panel-body p-t-10 p-l-10 p-r-10 p-b-10">
			                	<div class="roomCalendar" id="<?php echo $value->room_code ?>"></div>
			                </div>
			                <div class="panel-footer clearfix">
			                	<small class="pull-right">Total Unit Plotted: 27</small>
			                </div>
			            </div>
		            <?php// endforeach ?>
				</div>
			</div>
		</div> -->
	</div>
</div>

<!-- MODAL -->
<?php //include("addSchedModal.php") ?>	

<!-- CONTEXT MENU EVENT -->
<div id="moveEventModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Move to room</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
        	Select Room
        	<select name="rooms" class="form-control input-sm">
        	</select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button onclick="moveConfirm()" type="button" class="btn btn-primary">OK</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style type="text/css">
  .list-group-item {
      background-color: #333;
      color:#fff!important;
      font-size:12px;
      border:none!important;
      padding-top: 7px!important;
      padding-bottom: 7px!important;
  }
  .list-group-item:hover{
      background-color: #00698C !important;
      color:#FFF !important;
  }
  .list-group-item:hover{
  	background-color: #00698C !important;
      color:#FFF !important;
  }
</style>

<div class="list-group" id="contextMenu" style="display:none;z-index:1000;width:150px">
  <!-- <a href="#" onclick="duplicateEvent()" class="list-group-item"><i class="fa fa-copy"></i> Duplicate</a> -->
  <a href="#" onclick="moveEvent()" class="list-group-item"><i class="fa fa-mail-forward"></i> Move</a>
  <!-- <a href="#" onclick="" class="list-group-item"><i class="fa fa-times"></i> Remove</a> -->
</div>

<div id="modalScheduleList" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Schedule List</h4>
      </div>
      <div class="modal-body">
        <table id="tblSchedule" class="table table-bordered table-hover table-striped">
        	<thead>
        		<tr>
        			<th>Section Code</th>
        			<th>Program</th>
        			<th>Year</th>
        			<th>Semester</th>
        			<th>SY</th>
        			<th>Status</th>
        			<th></th>
        		</tr>
        	</thead>
        	<tbody>
        		<tr>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        		<tr>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        			<td></td>
        		</tr>
        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- MODAL SUBJECT SCHEDULING -->
<div class="modal fade" id="modalSubjectScheduling" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="row">
          <div class="col-md-2">
            <small>Section:</small>
            <div class="section" style="font-size:15px;color:#337ab7">ITE2201</div>
          </div>
          <div class="col-md-1">
            <small>Year:</small>
            <div class="year" style="font-size:15px;color:#337ab7">4<sup>th</sup> Year</div>
          </div>
          <div class="col-md-4">
            <small>Curriculum:</small>
            <div class="course" style="font-size:15px;color:#337ab7">Bachelor of Science in Computer Science</div>
            <div><small class="major">Major: Software Engineering</small></div>
          </div>
          <div class="col-md-4">
            <small>Semester / School Year</small>
            <div class="ysem" style="font-size:15px;color:#337ab7">First Semester - 2016-2017</div>
          </div>
        </div>
      </div>
      <div class="modal-body" style="overflow-y:scroll;min-height:300px;max-height:450px">

        <div class="row">
          <div class="col-md-7">
            <form method="post" id="formSubjectScheduling" action="<?php echo base_url('course_schedule/saveSchedule') ?>">
              <input type="hidden" class="form-control" name="bs_id" id="bs_id">
              <div class="row">
                <div class="col-md-8">
                  <label><b>Subject List</b></label><br>
                  Lecture
                  <table id="tblLecture" class="table table-hover tbl_subject">
                    <tr><td colspan="3">No subject available</td></tr>
                  </table>
                  Laboratory
                  <table id="tblLaboratory" class="table table-hover tbl_subject">
                    <tr><td colspan="3">No subject available</td></tr>
                  </table>
                </div>
                <div class="col-md-4">
                  <label><b>Schedule</b></label>
                  <div class="form-group">
                    Day
                    <select  required name="sd_id[]" class="form-control input-sm select2" multiple="multiple" data-placeholder="Select days" style="width: 100%!important">
                        <?php foreach ($days as $key => $value): ?>
                          <option value="<?php echo $value->sd_id; ?>"><?php echo $value->composition; ?></option>
                        <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group">
                    Time Start
                    <select required name="time_start" class="form-control input-sm">
                      <option value="" selected class="hide">Select time</option>
                      <?php foreach ($plotted as $key => $value): ?>
                        <option value="<?php echo date("H:i:s", strtotime($value->time)) ?>"><?php echo $value->time; ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group">
                    Time End
                    <select required name="time_end" class="form-control input-sm">
                      <option value="" selected class="hide">Select time</option>
                      <?php foreach ($plotted as $key => $value): ?>
                        <option value="<?php echo date("H:i:s", strtotime($value->time)) ?>"><?php echo $value->time; ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group">
                    Room Suggestions
                    <select required id="selectRoom" onchange="roomSchedule(this)" name="rl_id" class="form-control input-sm">
                      <option value="" selected class="hide">Select room</option>
                      <?php foreach ($rooms as $key => $value): ?>
                        <option value="<?php echo $value->rl_id; ?>"><?php echo $value->room_code; ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <button style="width:100px" type="submit" class="btn btn-success pull-right">Save</button>
                  </div>
                
                </div>
                <div class="col-md-12">
                  <label><b>Section Schedules</b></label>
                  <table id="tblSectionsSubjects" class="table table-hover m-t-10">
                    <thead style="background:#f3f3f3">
                      <tr>
                        <th>Code</th>
                        <th>Subject</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Room</th>
                        <th>Type</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-5">
            <div class="panel panel-info">
                <div class="panel-heading clearfix">
                    <label id="roomLabelName" class="text-white">SELECT ROOM</label>
                </div>
                <div class="panel-body p-t-0 p-l-10 p-r-10 p-b-10" style="border:1px solid #CCC">
                  <div class="m-t-0" id="subjectSchedulingCalendar"></div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="cancelSectionScheduling">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- SET SECTION MODAL -->
<style type="text/css">
  #example_filter{
    display: none;
  }
</style>
<div id="setSchedModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body" style="padding-bottom:0px">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <br>
        <form class="form-horizontal">
          <small>Set Section</small>
          <hr class="m-t-5">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-md-5 control-label">Year lvl.</label>
                <div class="col-md-7">
                  <select id="yearlvl" required class="form-control input-sm" name="year_lvl">
                    <option value='' selected="selected" class="hide">Select year level</option>
                    <option value="First Year">1st</option>
                    <option value="Second Year">2nd</option>
                    <option value="Third Year">3rd</option>
                    <option value="Forth Year">4th</option>
                    <option value="Fifth Year">5th</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-md-3 control-label">Sem</label>
                <div class="col-md-9">
                  <select id="semister" required class="form-control input-sm" name="sem">
                    <option value='' selected="selected" class="hide">Select Semester</option>
                    <option value="First Semester">1st Semester</option>
                    <option value="Second Semester">2nd Semester</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-md-3 control-label">S.Y.</label>
                <div class="col-md-9">
                  <select id="schoolyear" required class="form-control input-sm" name="sy">
                    <option value='' selected="selected" class="hide">Select school year</option>
                    <?php for ($i=date('Y'); $i >= 2000 ; $i--) { 
                      echo "<option value='".$i."-".($i + 1)."'>".$i."-".($i + 1)."</option>";
                    } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <small>Set Course</small>
          <hr class="m-t-5">
          <ul class="nav nav-pills">
            <li class="active"><a href="#nav-pills-tab-1" tosave="subject" data-toggle="tab">Subject List</a></li>
            <li><a href="#nav-pills-tab-2" tosave="curriculum" data-toggle="tab">Curriculum</a></li>
          </ul>
          <div class="tab-content" style="margin-bottom:0px;padding:0px">

          <!-- SUBJECT LIST -->
            <div class="tab-pane fade active in" id="nav-pills-tab-1">
              <div class="row">
                <div class="col-md-4 col-md-offset-8">
                  <div class="form-group">
                    <div class="col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-search"></i>
                        </span>
                        <input onkeyup="searchSubject($(this).val())" type="text" placeholder="Search subject" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div style="overflow:auto;overflow-x:hidden;min-height:200px;max-height:300px;">
                <table id="example" class="table table-striped table-hover">
                  <thead class="hide">
                      <tr>
                          <th></th>
                          <th>Subject</th>
                      </tr>
                  </thead>
                  <tbody>
                      
                      <?php foreach ($subjectList as $key => $value): ?>
                        <tr>
                          <td class="col-md-2"><input type="checkbox" name="subj_id" subjname="<?php echo $value->subj_name; ?>" labunit="<?php echo $value->lab_unit; ?>" split="<?php echo $value->split; ?>" lecunit="<?php echo $value->lec_unit; ?>" lechour="<?php echo $value->lec_hour; ?>" labhour="<?php echo $value->lab_hour; ?>" subjcode="<?php echo $value->subj_code; ?>" value="<?php echo $value->subj_id; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value->subj_code; ?></td>
                          <td><?php echo $value->subj_name; ?></td>
                        </tr>
                      <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          <!--END  SUBJECT LIST -->
            <div class="tab-pane fade" id="nav-pills-tab-2">
              
                              <!-- MODAL CONTENT -->
              <div class="form-group">
                <label class="col-md-3 control-label">Program</label>
                <div class="col-md-9">
                  <select id="program" required class="form-control input-sm">
                    <option class="hide" selected value=''>Select program</option>
                    <?php foreach ($programList as $key => $value): ?>
                      <option progname="<?php echo $value->prog_name ?>" value="<?php echo $value->pl_id ?>"><?php echo $value->prog_name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Major</label>
                <div class="col-md-9">
                  <input value="Web Programming" required id="major" class="form-control input-sm text-primary" readonly type="text">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="col-md-5 control-label">Year lvl.</label>
                    <div class="col-md-7">
                      <select id="curryearlvl" required class="form-control input-sm" name="year_lvl">
                        <option value='' selected="selected" class="hide">Select year level</option>
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                        <option value="5th">5th</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Sem</label>
                    <div class="col-md-9">
                      <select id="currsemister" required class="form-control input-sm" name="sem">
                        <option value='' selected="selected" class="hide">Select Semester</option>
                        <option value="1st Semester">1st Semester</option>
                        <option value="2nd Semester">2nd Semester</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="col-md-3 control-label">S.Y.</label>
                    <div class="col-md-9">
                        <select id="currsy" class="form-control input-sm" name="sy">
                        <option value='' selected="selected" class="hide">Select school year</option>
                        <?php for ($i=date('Y'); $i >= 2000 ; $i--) { 
                          echo "<option value='".$i."-".($i + 1)."'>".$i."-".($i + 1)."</option>";
                        } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <!-- MODAL CONTENT -->
              
              <!-- MODAL CONTENT -->

            </div>
          </div>

          <label class="control-label">Section Code</label>
          <div class="row">
            <div class="col-md-3" style="border-right:1px solid #348fe2">
              <span id="sectioncode" class="text-primary text-bold" style="font-size:24px">CS001</span>
              <button onclick="generateSectionCode()" type="button" class="btn btn-xs btn-default pull-right">generate</button>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-8">
              <div class="form-group">
                <div class="col-md-12">
                  <input id="ownsectioncode" type="text" class="form-control input-sm text-primary" placeholder="Set your own code">
                </div>
              </div>
            </div>
          </div> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="setCurriculumSched()" class="btn btn-primary">Set</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modalScheduleList" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Schedule List</h4>
      </div>
      <div class="modal-body">
        <table id="tblSchedule" class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>Section Code</th>
              <th>Program</th>
              <th>Year</th>
              <th>Semester</th>
              <th>SY</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalSubjects" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Subject Schedules</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->         
