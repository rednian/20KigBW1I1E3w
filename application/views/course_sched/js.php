<script type="text/javascript">
	
	$(function(){
		$(".select2").select2();

		generateSectionCode();

		$('input').iCheck({
		    checkboxClass: 'icheckbox_square-blue',
		    radioClass: 'iradio_square-blue',
		    increaseArea: '20%' // optional
		  });

		$('#modalSubjectScheduling').on('shown.bs.modal', function () {
		  	$("#subjectSchedulingCalendar").fullCalendar({
				defaultView: 'agendaWeek',
	            header: {
	                 left: '',
	                 right: ''
	            },
	            minTime: "<?php echo $time->time_start; ?>",
	   			maxTime: "<?php echo $time->time_end; ?>",	
	   			columnFormat: {
		             week: 'ddd'
		        },
		        slotDuration: "0:<?php echo $time->interval; ?>",
		        snapDuration: "0:<?php echo $time->interval; ?>",
		        allDaySlot: false,
		        editable: false,
	     		droppable: false,
	     		firstDay: 1,
			    eventDrop: function( event, delta, revertFunc, jsEvent, ui, view ){},
			    eventRightclick: function(event, jsEvent, view) {}
			});
			// alert("test");
		});

	});

	var activeTab;
	$(document).ready(function(){
		$('#setSchedModal').on('shown.bs.modal', function () {
			activeTab = $("li.active a[data-toggle=tab]").attr("tosave");
		  	$("li a[data-toggle=tab]").on("shown.bs.tab", function (e) {
				activeTab = $(this).attr("tosave");
			});
		});
	});

	var tblSchedule;
	var tblSubjectList;
	$(document).ready(function(){
		tblSchedule = $("#tblSchedule").dataTable({
			"bSort"   : false,
			"bLength" : false,
			"bInfo"   : false
		});

		tblSubjectList = $("#example").dataTable({
			paging: false,
        	"bInfo":false
		});
	});

	function searchSubject(key){
		tblSubjectList.fnFilter(key);
	}
	
	var eventsToSave = {};
	var schedObj;
	var sec;
	var subject = {};
	var pubSem;
	var pubSY;
	var pub_bs_id = 0;

	function setCurriculumSched(){
		if($("#setSchedModal input#ownsectioncode").val() == ""){
			sec = $("#setSchedModal span#sectioncode").html();
		}
		else{
			sec = $("#setSchedModal input#ownsectioncode").val();
		}

		if(activeTab == 'subject'){
			$.each($("input[type='checkbox'][name='subj_id']:checked"), function(){         
	            subject[$(this).val()] = {subj_id : $(this).val(), subj_code : $(this).attr('subjcode'), subj_name : $(this).attr('subjname'), lec_unit : $(this).attr('lecunit'), lab_unit : $(this).attr('labunit'), split : $(this).attr('split'), lab_hour : $(this).attr('labhour'), lec_hour : $(this).attr('lechour') };
	        });

	        schedObj  = {
						program : '...',
						prog_name : '...',
						major: '...',
						year: $("#setSchedModal select#yearlvl").val(),
						semister: $("#setSchedModal select#semister").val(),
						sy: $("#setSchedModal select#schoolyear").val(),
						section: sec,
						curryearlvl: $("#setSchedModal select#curryearlvl").val(),
						currsemister: $("#setSchedModal select#currsemister").val(),
						currsy: $("#setSchedModal select#currsy").val(),
						schedule: $("#setSchedModal input[type=radio][name=schedule]:checked").val(),
						subjects: subject,
					};
		}
		else if(activeTab != "subject"){
			schedObj  = {
						program : $("#setSchedModal select#program").val(),
						prog_name : $("#setSchedModal select#program option:selected").attr("progname"),
						major: $("#setSchedModal input#major").val(),
						year: $("#setSchedModal select#yearlvl").val(),
						semister: $("#setSchedModal select#semister").val(),
						sy: $("#setSchedModal select#schoolyear").val(),
						section: sec,
						curryearlvl: $("#setSchedModal select#curryearlvl").val(),
						currsemister: $("#setSchedModal select#currsemister").val(),
						currsy: $("#setSchedModal select#currsy").val(),
						schedule: $("#setSchedModal input[type=radio][name=schedule]:checked").val(),
						subjects: subject,
					};
		}

		$.ajax({
			url: "<?php echo base_url('course_schedule/subject_scheduling') ?>",
			data: {sched : schedObj, type : activeTab},
			type: "GET",
			dataType: "json",
			success: function(data){
				
				if(data.result == true){
					if(data.isExist == true){
						showMessage('Error', 'Section already exists.', 'error');
					}
					else{

						pubSem = schedObj.semister;
						pubSY = schedObj.sy;

						setDetails(schedObj);
						
						if(!jQuery.isEmptyObject(data)){
							var lec = "";
							var lab = "";

							$("#setSchedModal").modal("hide");
							
							if(!jQuery.isEmptyObject(data.lec)){
								$.each(data.lec, function(key, value){
									lec += "<tr onclick=\"select(this)\">\
												<td><input id=\"lec_"+value.subj_id+"\" required data-type=\"lec\" bss_id=\""+value.bss_id+"\" totalHour=\""+value.lec_hour+"\" type=\"radio\" value=\"lec-"+value.subj_id+"\" name=\"subj_id\"></td>\
												<td>"+value.subj_code+"</td>\
												<td>"+value.subj_name+"</td>\
												<td>";
											if(value.countSched > 0){
												lec += "<button type='button' class='btn btn-xs btn-danger'>"+value.countSched+" schedule/s</button>";
											}
									lec +=	"</td>\
											</tr>";
								});
							}
							else{
								lec = "<tr><td colspan='3'>No subject available</td></tr>";
							}

							if(!jQuery.isEmptyObject(data.lab)){
								$.each(data.lab, function(key, value){
									lab += "<tr onclick=\"select(this)\">\
												<td><input id=\"lab_"+value.subj_id+"\" required data-type=\"lab\" bss_id=\""+value.bss_id+"\" totalHour=\""+value.lab_hour+"\" type=\"radio\" value=\"lab-"+value.subj_id+"\" name=\"subj_id\"></td>\
												<td>"+value.subj_code+"</td>\
												<td>"+value.subj_name+"</td>\
												<td>";
												if(value.countSched > 0){
													lab += "<button type='button' class='btn btn-xs btn-danger'>"+value.countSched+" schedule/s</button>";
												}
									lab +=	"</td>\
											</tr>";
								});
							}
							else{
								lab = "<tr><td colspan='3'>No subject available</td></tr>";
							}
							
							$("#modalSubjectScheduling .modal-header div.section").html(schedObj.section);
							$("#modalSubjectScheduling .modal-header div.year").html(schedObj.year);
							$("#modalSubjectScheduling .modal-header div.course").html(schedObj.prog_name);
							$("#modalSubjectScheduling .modal-header small.major").html(schedObj.major);
							$("#modalSubjectScheduling .modal-header div.ysem").html(schedObj.semister+" - "+schedObj.sy);
							$("#modalSubjectScheduling #tblLecture").html(lec);
							$("#modalSubjectScheduling #tblLaboratory").html(lab);
							$("#modalSubjectScheduling input#bs_id").val(data.bs_id);
							$("#modalSubjectScheduling").modal("show");
						}
					}
				}
				else{
					showMessage('Error', 'Error in creating a section function.', 'error');
				}
				
			},
			error: function(){
				showMessage('Error', 'Function error.', 'error');
			}
		});
	}

	$(document).ready(function(){
		$("#formSubjectScheduling").on("submit", function(e){

			e.preventDefault();

			var section = sec;
			var yrlvl = schedObj.year;
			var sem = schedObj.semister;
			var sy = schedObj.sy;
			var pl_id = schedObj.program;
			var type = $("input[name=subj_id][type=radio]:checked").attr("data-type");
			var totalHour = parseFloat($("input[name=subj_id][type=radio]:checked").attr("totalHour"));
			var bss_id = parseFloat($("input[name=subj_id][type=radio]:checked").attr("bss_id"));

			$.ajax({
				url: "<?php echo base_url('course_schedule/saveSchedule')?>",
				data: $(this).serialize()+"&section="+section+"&year="+yrlvl+"&sem="+sem+"&sy="+sy+"&pl_id="+pl_id+"&type="+type+"&hours="+totalHour+"&bss_id="+bss_id,
				type: "POST",
				dataType: "JSON",
				success: function(data){

					if(data.result == true){

						// SUBTRACT SUBJECT TIME
						var diff = parseFloat(totalHour - data.hours);

						$("input[name=subj_id][type=radio]:checked").attr("totalHour", diff);

						if(diff == 0){
							$("input[name=subj_id][type=radio]:checked").attr("disabled", true);
							$("input[name=subj_id][type=radio]:checked").closest("tr").css("cursor", "not-allowed");
							$("input[name=subj_id][type=radio]:checked").closest("tr").css("background", "#f3f3f3");
							$("input[name=subj_id][type=radio]:checked").attr("checked", false);
						}

						pub_bs_id = data.bs_id;
						loadSectionSchedules(pub_bs_id);
						roomSchedule("#selectRoom");

						showMessage('Success', "Schedule has been saved.", 'success');
					}
					else if(data.result == false){

					}
					else if(data.result == "invalid time"){
						showMessage('Invalid Time', "Time end must be greater than the time start.", 'error');
					}
					else if(data.result == "hour exceeds"){
						showMessage('Invalid Time', "Time exceeds to the subject's total hours per week. It should have only "+totalHour+" hour/s per week.", 'error');
					}
					else{
						showMessage('Conflict', data.result, 'error');
					}
				},
				error: function(){

				}
			});
		});
	});

	function setDetails(data){
		$("#setScheduleContent span.schedDetailsProgram").html(data.prog_name);
		$("#setScheduleContent span.schedDetailsMajor").html(data.major);
		$("#setScheduleContent span.schedDetailsYear").html(data.year);
		$("#setScheduleContent span.schedDetailsSemister").html(data.semister);
		$("#setScheduleContent span.schedDetailsSY").html(data.sy);
		$("#setScheduleContent span.schedDetailsSection").html(data.section);
	}

	function generateSectionCode(){
		$.ajax({
			url: "<?php echo base_url('course_schedule/generateSectionCode'); ?>",
			dataType: "HTML",
			success: function(data){
				$("#setSchedModal span#sectioncode").html(data);
			},
			error: function(){

			}
		});
	}

	function select(el){
		var dis = $(el).children('td').children('input[type=radio]').attr("disabled");

		if(dis != "disabled"){
			$(el).children('td').children('input[type=radio]').attr("checked", true);
		}
	}

	function loadScheduleList(){
		$.ajax({
			url: "<?php echo base_url('course/getSectionList') ?>",
			dataType: "json",
			success: function(data){
				tblSchedule.fnClearTable();
				$.each(data, function(key, value){
					tblSchedule.fnAddData([
							value.sec_code,
							value.prog_name,
							value.year_lvl,
							value.semister,
							value.sy,
							value.activation,
							"<button onclick='viewScheduleSection("+value.bs_id+")' class='btn btn-xs btn-info pull-right'><i class='fa fa-eye'></i> View</button>"
						]);
				});
			},
			error: function(){

			}
		});
	}

	function sectionSubject(){

	}

	function roomSchedule(el){
		var rl_id = $(el).val();
		var r_name = $("option:selected", el).html();

		var str = "course_schedule/roomSched?rl_id="+rl_id+"&sem="+pubSem+"&sy="+pubSY;
		var url = "<?php echo base_url('"+str+"') ?>";
		
		$("#subjectSchedulingCalendar").fullCalendar('removeEvents');
		$("#subjectSchedulingCalendar").fullCalendar('addEventSource', url);

		$("#roomLabelName").html("<b>Room "+r_name+" Schedules</b>");
	}

	var tblSectionsSubjects;

	$(document).ready(function(){
		tblSectionsSubjects = $("table#tblSectionsSubjects").DataTable();
	});

	function loadSectionSchedules(bs_id){
		tblSectionsSubjects.ajax.url("<?php echo base_url('Course_schedule/getSectionSchedules?bs_id="+bs_id+"') ?>").load();
	}

	$(document).ready(function(){
		$("#cancelSectionScheduling").on("click", function(){
			var bs_id = $("#modalSubjectScheduling input#bs_id").val();
			cancelScheduling(bs_id);
		});
	});

	function cancelScheduling(bs_id){
		bootbox.confirm("Are you sure you want to cancel scheduling? The schedules that have been saved will be deleted.", function(result) {
			if(result == true){
				$.ajax({
					url: "<?php echo base_url('course_schedule/cancelScheduling') ?>",
					data: {bs_id : bs_id},
					type: "GET",
					dataType: "JSON",
					success: function(data){
						if(data.result == true){
							showMessage('Success', "Scheduling has been cancelled.", 'success');
							$("#modalSubjectScheduling").modal("hide");
						}
						else{

						}
					},
					error: function(){

					}
				});	
			}
		});
	}
</script>