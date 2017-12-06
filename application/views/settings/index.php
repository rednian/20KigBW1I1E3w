<div class="content" id="content">
	<h1 class="page-header">General Account Settings</h1>
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h4 class="panel-title">Set your credentials</h4>
				</div>
				<div class="panel-body">
					<?php
                    if(isset($_SESSION['sessChangePass'])){
                        $login_session = get_session('sessChangePass');
                    ?>
                        <div class="alert alert-danger fade in m-t-20">
                            <strong>Error!</strong>
                            <?php echo $login_session; ?>
                            <span class="close" data-dismiss="alert">&times;</span>
                        </div>
                    <?php
                        delete_session("sessChangePass");
                    }
                    ?>
					<table class="table table-hover">
						<tbody>
							<tr class="rowEdit rowEditName">
								<td>Personal Info</td>
								<td><?php echo $userInfo[$this->userInfo->user_id]->user_fname." ".$userInfo[$this->userInfo->user_id]->user_lname; ?></td>
								<td class="text-right"><a href="#" onclick="editName()">Edit</a></td>
							</tr>
							<tr class="editFormContainer hide" id="divEditName">
								<td colspan="3" class="p-t-0 p-l-0 p-r-0 p-b-0">
									<div style="width:100%;background:#F3f3f3;padding:5px;">
										<h4 class="m-t-0">Change Personal Info</h4>
										<div class="row">
											<div class="col-md-6">
												<form method="post" action="<?php echo base_url('settings/saveChangesPersonalInfo') ?>">
													<div class="form-group m-b-5">
														First Name
														<input autocomplete="off" name="user_fname" value="<?php echo $userInfo[$this->userInfo->user_id]->user_fname; ?>" class="form-control input-sm">
													</div>
													<div class="form-group">
														Last Name
														<input autocomplete="off" name="user_lname" value="<?php echo $userInfo[$this->userInfo->user_id]->user_lname; ?>" class="form-control input-sm">
													</div>
													<div class="form-group">
														Middle Name
														<input autocomplete="off" name="user_mname" value="<?php echo $userInfo[$this->userInfo->user_id]->user_mname; ?>" class="form-control input-sm">
													</div>
													<div class="form-group">
														Position
														<input autocomplete="off" name="user_position" value="<?php echo $userInfo[$this->userInfo->user_id]->user_position; ?>" class="form-control input-sm">
													</div>
													<div class="form-group">
														<button type="submit" class="btn btn-sm btn-success">Save changes</button> <button type="reset" onclick="cancelEditName()" class="btn btn-sm btn-default">Cancel</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr class="rowEdit rowEditUsername">
								<td>Username</td>
								<td><?php echo $userInfo[$this->userInfo->user_id]->username ?></td>
								<td class="text-right"><a href="#" onclick="editUsername()">Edit</a></td>
							</tr>
							<tr class="editFormContainer hide" id="divEditUsername">
								<td colspan="3" class="p-t-0 p-l-0 p-r-0 p-b-0">
									<div style="width:100%;background:#F3f3f3;padding:5px;">
										<h4 class="m-t-0">Change Username</h4>
										<div class="row">
											<div class="col-md-6">
												<small>Note: The username must be unique.</small>
												<form method="post" action="<?php echo base_url('settings/saveChangesPersonalInfo') ?>">
													<div class="form-group">
														Username
														<input name="username" value="<?php echo $userInfo[$this->userInfo->user_id]->username ?>" class="form-control input-sm">
													</div>
													<div class="form-group">
														<button type="submit" class="btn btn-sm btn-success">Save changes</button> <button type="reset" onclick="cancelEditUsername()" class="btn btn-sm btn-default">Cancel</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr class="rowEdit rowEditPassword">
								<td>Password</td>
								<td>********************</td>
								<td class="text-right"><a href="#" onclick="editPassword()">Edit</a></td>
							</tr>
							<tr class="editFormContainer hide" id="divEditPassword">
								<td colspan="3" class="p-t-0 p-l-0 p-r-0 p-b-0">
									<div style="width:100%;background:#F3f3f3;padding:5px;">
										<h4 class="m-t-0">Change Password</h4>
										<div class="row">
											<div class="col-md-6">
												<form method="post" action="<?php echo base_url('settings/changePassword') ?>">
													<div class="form-group m-b-5">
														Current
														<input name="old_password" class="form-control input-sm" type="password">
													</div>
													<div class="form-group m-b-5">
														New
														<input name="new_password" class="form-control input-sm" type="password">
													</div>
													<div class="form-group">
														Confirm new password
														<input name="retype_password" class="form-control input-sm" type="password">
													</div>
													<div class="form-group">
														<button type="submit" class="btn btn-sm btn-success">Save changes</button> <button type="reset" onclick="cancelEditPassword()" class="btn btn-sm btn-default">Cancel</button>
													</div>
												</form>
												
											</div>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>