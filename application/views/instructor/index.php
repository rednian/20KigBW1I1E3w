<div id="content" class="content">
  <div class="row p-t-10 p-b-10 m-b-10" style="background: #154360;">
    <div class="col-lg-3 text-white">
      <span class="f-s-20">School Year:</span>
      <select id="selectSY" class="f-s-20" style="background:none;outline: none;border:none;color:#348fe2">
        <?php $this->load->view('includes/school-year'); ?>
      </select>
    </div>
    <div class="col-lg-3 text-white">
      <span class="f-s-20">Semester</span>
      <select id="selectSem" class="f-s-20" style="background:none;outline: none;border:none;color:#348fe2">
        <option value="First Semester">First Semester</option>
        <option value="Second Semester">Second Semester</option>
      </select>
    </div>
    <!-- <div class="col-lg-3 col-lg-offset-2">
      <div class="form-group m-b-0">
        <div class="input-group input-group-sm">
          <input type="text" class="form-control" placeholder="general search">
          <span class="input-group-btn">
            <button class="btn btn-primary"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </div>
    </div> -->
  </div>

  <div class="row">
    <div class="col-md-4 p-l-0" style="position:relative;">
      <div class="numLeft">1</div>
      <div class="panel panel-info m-l-30">
        <div class="panel-heading no-radius">
          <div class="row">
            <div class="col-md-3">
              <h4 class="panel-title">Instructor List</h4>
            </div>
            <div class="col-md-9">
              <div class="input-group input-group-sm">
                				<span class="input-group-addon">
									<i class="fa fa-search"></i>
								</span>
                <input onkeyup="searchInstructor($(this).val())" type="text" class="form-control" placeholder="Search instructor">
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body p-t-10 p-l-10 p-r-10 p-b-10">
          <table id="tblInstructorList" class="table table-hover m-t-0" style="margin-top:0px!important">
            <thead class="hide">
            <tr>
              <th>Name</th>
              <th>Department</th>
            </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>


    <div class="col-md-3 p-l-3 p-r-3" style="vertical-align:bottom">

      <div class="row">
        <div class="col-md-12" style="position:relative;">
          <div class="numLeft">2</div>
          <div class="panel panel-info m-b-10 m-l-30">
            <div class="panel-heading no-radius">
              <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <h4 class="panel-title">Active Curriculum</h4>
            </div>
            <div class="panel-body p-l-5 p-t-5 p-r-5 p-b-5" style="display: block">
              <table id="tblCurriculum" class="table table-hover" style="margin-top:0px!important">
                <thead class="hide">
                <tr>
                  <td>

                  </td>
                </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12" style="position:relative;">
          <div class="numLeft">3</div>
          <div class="panel panel-info m-b-10 m-l-30">
            <div class="panel-heading no-radius">
              <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
              </div>
              <ul id="navPillsMenu" class="nav nav-pills pull-right">
                <li class="active"><a href="#nav-pills-tab-1" data-toggle="tab">Block Section</a></li>
                <li><a href="#nav-pills-tab-2" data-toggle="tab">Off Sem Section</a></li>
              </ul>
              <h4 class="panel-title">Section List</h4>
            </div>
            <div class="panel-body p-t-0" style="display:block">

              <div class="tab-content p-t-0 p-l-0 p-r-0 p-b-0 m-b-0">
                <div class="tab-pane fade active in" id="nav-pills-tab-1">
                  <table id="tblSectionList" class="table table-hover m-b-0">
                    <thead class="hide">
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="nav-pills-tab-2">
                  <table id="tblOffSectionList" class="table table-hover m-b-0">
                    <thead class="hide">
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12" style="position:relative;">
          <div class="numLeft">4</div>
          <div class="panel panel-info m-b-10 m-l-30">
            <div class="panel-heading no-radius">
              <ul id="navPillsMenuSection" class="nav nav-pills pull-right">
                <li class="active"><a onclick="loadSubject(pubBsID)" href="#blockSubjectTab" data-toggle="tab">Block Subject</a></li>
                <li><a onclick="loadAllSubject()" href="#allSubjectTab" data-toggle="tab">All</a></li>
              </ul>
              <h4 class="panel-title">Courses</h4>
            </div>
            <div class="panel-body p-l-5 p-t-5 p-r-5 p-b-5">
              <!-- <table id="tblCourse" class="table table-hover" style="margin-top:0px!important">
                <thead class="hide">
                  <tr>
            <td style="visibility:hidden">Code</td>
            <td style="visibility:hidden">Subj</td>
            <td>Lec</td>
            <td>Lab</td>
            <td></td>
          </tr>
                </thead>
                <tbody></tbody>
              </table> -->
              <div class="tab-content p-t-0 p-l-0 p-r-0 p-b-0 m-b-0">
                <div class="tab-pane fade active in" id="blockSubjectTab">
                  <table id="tblCourse" class="table table-hover" style="margin-top:0px!important">
                    <thead class="hide">
                    <tr>
                      <td style="visibility:hidden">Code</td>
                      <td style="visibility:hidden">Subj</td>
                      <td>Lec</td>
                      <td>Lab</td>
                      <td></td>
                    </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="allSubjectTab">
                  <table id="tblAllCourse" class="table table-hover" style="margin-top:0px!important">
                    <thead class="hide">
                    <tr>
                      <td></td>
                      <td style="visibility:hidden">Code</td>
                      <td style="visibility:hidden">Subj</td>
                      <td>Lec</td>
                      <td>Lab</td>
                      <td></td>
                    </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12" style="position:relative;">
          <div class="numLeft">5</div>
          <div id="panelSubSched" class="panel panel-info m-l-30">
            <div class="panel-heading no-radius">
              <h4 class="panel-title">Course Schedule Preview</h4>
            </div>
            <div class="panel-body p-l-5 p-t-5 p-r-5 p-b-5">
              <div class="row">
                <div id="shedContainer" class="col-md-8">
                  <p>Schedule List ....</p>
                </div>
                <div class="col-md-4 clearfix">
                  <button id="btnGiveIn" onclick="giveScheduleInstructorSched()" class="btn btn-sm btn-success pull-right">
                    Add Subject <i class="fa fa-caret-right m-l-5"></i>
                  </button>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-5 p-r-0">
      <div class="panel panel-info">
        <div class="panel-heading clearfix">
          <button
            onclick="window.open('<?php echo base_url("instructor/printCalendar?sem='+pubSem+'&sy='+pubSY+'&ins='+pubInsID+'") ?>','','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,width=1000,height=600')"
            class="btn btn-primary btn-sm pull-right"><i class="fa fa-print"></i> Print
          </button>
          <h4 class="panel-title">Instructors Schedule Preview</h4>
        </div>
        <div class="panel-body">
          <div id="calendar"></div>
        </div>
        <div class="panel-footer clearfix">
          <small class="pull-right">Total Unit Plotted: 27</small>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CONTEXT MENU -->


<div class="list-group" id="contextMenu" style="display:none;z-index:1000;width:150px">
  <a href="#" onclick="removeSubjectFromInstructor()" class="list-group-item"><i class="fa fa-copy"></i> Remove subject</a>
</div>

<style type="text/css">

  .list-group-item {
    background-color: #333;
    color: #fff !important;
    font-size: 12px;
    border: none !important;
    padding-top: 7px !important;
    padding-bottom: 7px !important;
  }

  .list-group-item:hover {
    background-color: #00698C !important;
    color: #FFF !important;
  }

  .list-group-item:hover {
    background-color: #00698C !important;
    color: #FFF !important;
  }

  #navPillsMenu li a {
    background: none !important;
    color: #FFF;
  }

  #navPillsMenu li.active a {
    background: none !important;
    color: #FFF;
    text-decoration: underline;
  }

  #navPillsMenuSection li a {
    background: none !important;
    color: #FFF;
  }

  #navPillsMenuSection li.active a {
    background: none !important;
    color: #FFF;
    text-decoration: underline;
  }
</style>