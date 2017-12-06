<!-- <form method="post" id="formAddRoom" action="<?php echo base_url('gen_info/roomSave') ?>"> -->
<div class="error_message_room text-danger"><?php echo validation_errors(); ?></div>
<?php echo form_open('gen_info/roomSave', 'id="formAddRoom"'); ?>
<input type="hidden" name="rl_id">
<div class="form-group m-b-5">
  Code
  <input data-parsley-required="true" autocomplete="off" name="room_code" type="text" class="form-control input-sm">
</div>
<div class="form-group m-b-5">
  Name
  <input data-parsley-required="true" autocomplete="off" name="room_name" type="text" class="form-control input-sm">
</div>
<div class="form-group m-b-5">
  Capacity
  <input data-parsley-required="true" data-parsley-type="digits" min="1" autocomplete="off" name="capacity" type="text" class="form-control input-sm">
</div>
<div class="form-group m-b-5">
  Type
  <!-- <input autocomplete="off" name="type" type="text" class="form-control input-sm"> -->
  <select data-parsley-required="true" class="form-control input-sm" name="type">
    <option value='' selected class="hide">Select type</option>
    <option value="Lecture">Lecture</option>
    <option value="Laboratory">Laboratory</option>
  </select>
</div>
<div class="form-group m-b-5">
  Location
  <input autocomplete="off" name="location" type="text" class="form-control input-sm">
</div>
<div class="form-group">
  Description
  <textarea autocomplete="off" name="desc" class="form-control"></textarea>
</div>
<div class="form-group clearfix">
  <button type="reset" class="hide">reset</button>
  <button style="width:100px" class="btn btn-sm btn-success pull-right">Save</button>
</div>
</form>

<script type="text/javascript">
  $(document).ready(function(){
    add_room();
  });

  function add_room() {
    $('form#formAddRoom').formValidation({
      message: 'This value is not valid',
      //live: 'disabled',
      icon: {
       // valid: 'glyphicon glyphicon-ok',
       // invalid: 'glyphicon glyphicon-remove',
        validating: 'fa fa-refresh fa-spin'
      },
      fields: {
        room_code: {
          validators: {
            notEmpty: {
              message: 'The room code is required and cannot be empty'
            },
            stringLength: {
              min: 1,
              message: 'The room code  must be more than 1 characters long'
            },
            regexp: {
              regexp: /^[a-zA-Z0-9\-]+$/,
              message: 'The room code  can only consist of charaacter, number and dashes.'
            },
            remote: {
              url: '<?php echo base_url("gen_info/is_room_code_exist"); ?>',
              type: 'post',
              // data: {room_code: $(this).val()},
              message: 'The room code is not available',
              delay: 1000
            }
          }
        },
        room_name: {
          validators: {
            notEmpty: {
              message: 'The room name is required and cannot be empty'
            },
            stringLength: {
              max: 60,
              message: 'The room name must be more than 3 characters long'
            }
          }
        },
        capacity: {
          validators: {
             notEmpty: {
              message: 'The capacity is required and cannot be empty'
            },
            stringLength: {
              max: 3,
              message: 'The capacity must be more than 1 characters long'
            },
            regexp: {
              regexp: /^[0-9]+$/,
              message: 'The capacity can only consist of number'
            }
          }
        },
        type: {
          validators: {
             notEmpty: {
              message: 'The type is required and cannot be empty'
            },
            stringLength: {
              max: 3,
              message: 'The type must be more than 1 characters long'
            }
          }
        },
        location: {
          validators: {
            stringLength: {
              max: 6,
              message: 'The location must be more than 1 characters long'
            },
            regexp: {
              regexp: /^[a-zA-Z0-9]+$/,
              message: 'The capacity can only consist of character and number'
            }
          }
        },
        desc: {
          validators: {
            stringLength: {
              max: 3,
              message: 'The description must be more than 1 character long'
            },
            regexp: {
              regexp: /^[a-zA-Z0-9]+$/,
              message: 'The description can only consist of character and number'
            }
          }
        },
      }/*end of fields*/
    }).on('success.form.fv', function (e) {

      e.preventDefault();
      var $form = $(e.target);

      $.ajax({
        url: $(this).attr('action'),
        data: new FormData(this),
        type: $(this).attr('method'),
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'html',
        success: function (data) {

          if (data == 1) {

            new PNotify({
              type: "success",
              text: "Product Successfully Created."
            });
            $form
              .formValidation('disableSubmitButtons', false)  // Enable the submit buttons
              .formValidation('resetForm', true);
          }
          if (data == 2) {
            new PNotify({
              type: "success",
              text: "Quantity Successfully Updated."
            });
          }
          if (data == 3) {
            new PNotify({
              type: "error",
              text: "Quantity Failed to  Update."
            });
          }
          if (data == 0) {
            new PNotify({
              type: "error",
              text: "Failed to Create new Product."
            });
          }

        }

      });
    }).on('err.form.fv', function(e) {

      // Active the panel element containing the first invalid element
      var $form         = $(e.target),
        validator     = $form.data('formValidation'),
        $invalidField = validator.getInvalidFields().eq(0),
        $collapse     = $invalidField.parents('.collapse');

      $collapse.collapse('show');
    });

  }
</script>