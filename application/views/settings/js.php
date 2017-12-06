<script type="text/javascript">
	
	function resetEdit(){
		$(".editFormContainer").addClass("hide");
		$(".rowEdit").removeClass("hide");
	}

	function editName(){
		resetEdit();
		$("#divEditName").removeClass("hide");
		$(".rowEditName").addClass("hide");
	}

	function cancelEditName(){
		resetEdit();
		$("#divEditName").addClass("hide");
		$(".rowEditName").removeClass("hide");
	}

	function editUsername(){
		resetEdit();
		$("#divEditUsername").removeClass("hide");
		$(".rowEditUsername").addClass("hide");
	}

	function cancelEditUsername(){
		resetEdit();
		$("#divEditUsername").addClass("hide");
		$(".rowEditUsername").removeClass("hide");
	}

	function editPassword(){
		resetEdit();
		$("#divEditPassword").removeClass("hide");
		$(".rowEditPassword").addClass("hide");
	}

	function cancelEditPassword(){
		resetEdit();
		$("#divEditPassword").addClass("hide");
		$(".rowEditPassword").removeClass("hide");
	}

	var userInfo = {};
	function loadUserInformation(){
		$.ajax({
			url: "<?php echo base_url('settings/getUserInformation') ?>",
			dataType: "json",
			success: function(data){
				userInfo = data;
			},
			error: function(){

			}
		});
	}
</script>