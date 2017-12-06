<script type="text/javascript">
	// DISPLAY REAL TIME
	$(document).ready(function(){
	  function clickClock () {

	     var time = moment(new Date()).format('hh:mm:ss A');
	     var date = moment(new Date()).format('MMMM DD, YYYY');
	     var day = moment(new Date()).format('dddd')+",";
	     
	     $("nav.navbar .day").html(day);
	     $("nav.navbar .date").html(date);
	     $("nav.navbar .time").html(time);
	     setTimeout(clickClock,1000);
	  }
	  clickClock();
	});

	function showMessage(title, msg, type){
		new PNotify({
		    title: title,
		    text: msg,
		    type: type,
		});
	}
</script>