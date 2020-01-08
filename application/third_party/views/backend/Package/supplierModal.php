  <style type="text/css">
      .btn-small {
        width: 21px;
        height: 25px;
        background: #255a79;
        display: block;
        text-align: center;
        color: white;
        line-height: 25px;
        border-radius: 7px;
        float: left;
        margin-right: 5px;
        cursor: pointer;
      }
      .bg-rebeccapurple {
         background: rebeccapurple;
      }
      .bg-red {
        background: red;
      }
  </style>
  <div class="modal-content col-md-12">
        <div class="modal-header">
          <button type="button" class="close close_edit_modal" data-dismiss="modal">&times;</button>
             <h4 class="modal-title"><?php echo isset($_REQUEST['id']) ? 'Edit' : 'Add' ?> Supplier</h4>
        </div>
        <div class="modal-body">
            <form method="post" id="supplierForm">
                <input type="hidden" name="id" value="<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : '' ?>">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>First Name </label><span>*</span>
                        <input type="text" id="FirstName" name="FirstName" value="<?php echo isset($_REQUEST['id']) ? $view[0]->FirstName : '' ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Last Name</label><span>*</span>
                        <input type="text" name="LastName" id="LastName" value="<?php echo isset($_REQUEST['id']) ? $view[0]->LastName : '' ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Email</label><span>*</span>
                        <input type="text" name="email" id="email" value="<?php echo isset($_REQUEST['id']) ? $view[0]->email : '' ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Mobile</label><span>*</span>
                        <input type="text" name="Mobile" id="Mobile" value="<?php echo isset($_REQUEST['id']) ? $view[0]->Mobile : '' ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Sex</label>
                        <select class="form-control" name="sex">
                            <option <?php echo isset($_REQUEST['id']) && $view[0]->sex=='Male' ? 'selected' : '' ?> value="Male">Male</option>
                            <option <?php echo isset($_REQUEST['id']) && $view[0]->sex=='Female' ? 'selected' : '' ?> value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label title="Date of Birth">DOB</label>
                        <input type="text" class="datePicker-hide datepicker input-group-addon" id="datepicker" name="DOB" placeholder="dd/mm/yyyy" value="<?php echo isset($_REQUEST['id']) ? date('d/m/Y',strtotime( $view[0]->DOB)) : date('d/m/Y'); ?>" />
                         <?php $today=  isset($_REQUEST['id']) ? date('d/m/Y',strtotime( $view[0]->DOB)) : date('d/m/Y'); ?>
                        <div class="input-group">
                            <input class="form-control datepicker date-pic" id="alternate" name="" value="<?php echo $today ?>">
                            <label for="datepicker" class="input-group-addon"><i class="fa fa-calendar"></i></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="from_date">Country</label><span>*</span>
                        <select name="ConSelect" class="form-control" id="ConSelect" onchange ="ConSelectFun();">
                        <option value=" "> Country </option>
                        <?php $count=count($contry);
                        for ($i=0; $i <$count ; $i++) { ?>
                        <option <?php echo isset($_REQUEST['id']) && $view[0]->country==$contry[$i]->id ? 'selected' : '' ?> value="<?php echo $contry[$i]->id;?>" sortname="<?php echo  $contry[$i]->sortname; ?>"><?php echo $contry[$i]->name; ?></option>
                        <?php  } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="hidden" id="hiddenState" value="<?php echo isset($_REQUEST['id']) ? $view[0]->state : '' ?>">
                        <label for="stateSelect">State</label><span>*</span>
                        <select name="stateSelect" id="stateSelect"  class="form-control">
                            <option value="">Select</option>
                        </select> 
                    </div>
                    <div class="form-group col-md-4">
                        <label>City</label><span>*</span>
                        <input type="text" name="city" id="city" value="<?php echo isset($_REQUEST['id']) ? $view[0]->city : '' ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Address</label><span>*</span>
                        <textarea class="form-control" id="Address" name="Address"><?php echo isset($_REQUEST['id']) ? $view[0]->Address : '' ?></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <input type="button" id="update_supplier" class="no-border btn-sm btn-success" value="Update">
        </div>
    </div>

<script type="text/javascript">
function ConSelectFun(){
  var hiddenState = $("#hiddenState").val();
  $('#stateSelect option').remove();
    var ConSelect = $('#ConSelect').val();
    $.ajax({
        url: base_url+'/backend/Hotels/StateSelect?Conid='+ConSelect,
        type: "POST",
         data:{},
        dataType: "json",
        success:function(data) {
          $('#stateSelect').append('<option value="">Select</option>');
            $.each(data, function(i, v) {
                if (hiddenState==v.id) {
                  selected = 'selected';
                } else {
                  selected = '';
                }
                $('#stateSelect').append('<option '+selected+' value="'+ v.id +'">'+ v.name +'</option>');
            });
        }
    });
}

$("#datepicker").datepicker({
    yearRange: "1950:<?php echo date('Y') ?>",
    altField: "#alternate",
    // altField: "#alternate",
    dateFormat: "yy-mm-dd",
    altFormat: "dd/mm/yy",
    changeYear : true,
    changeMonth : true,
});
$("#alternate").click(function() {
    $( "#datepicker" ).trigger('focus');
});
$("#update_supplier").click(function()  {
    var FirstName = $("#FirstName").val();
    var LastName = $("#LastName").val();
    var email = $("#email").val();
    var Mobile = $("#Mobile").val();
    var ConSelect = $("#ConSelect").val();
    var stateSelect = $("#stateSelect").val();
    var city = $("#city").val();
    var Address = $("#Address").val();

    if (FirstName=="") {
        addToast('FirstName is required!','orange');
        $("#FirstName").focus();
    } else if (LastName=="") {
        addToast('LastName is required!','orange');
        $("#LastName").focus();
    } else if (email=="") {
        addToast('Email is required!','orange');
        $("#email").focus();
    } else if (Mobile=="") {
        addToast('Mobile is required!','orange');
        $("#Mobile").focus();
    } else if (ConSelect=="") {
        addToast('Country is required!','orange');
        $("#ConSelect").focus();
    } else if (stateSelect=="") {
        addToast('State is required!','orange');
        $("#stateSelect").focus();
    } else if (city=="") {
        addToast('City is required!','orange');
        $("#city").focus();
    } else if (Address=="") {
        addToast('Address is required!','orange');
        $("#Address").focus();
    } else {
        $("#update_supplier").prop("disabled",true);
        $.ajax({
            url: base_url+'/backend/Package/supliersubmit',
            type: "POST",
            data:$("#supplierForm").serialize(),
            dataType: "json",
            success:function(data) {
                if ($("#id").val()=="") {
                    addToast('Inserted successfully','green');
                } else {
                    addToast('Updated successfully','green');
                }
                $(".close").trigger('click');

                var packagesupplier_table = $('#packagesupplier_table').dataTable({
                    "bDestroy": true,
                     dom: 'lBfrtip',
                      buttons: [
                          'copy', 'csv', 'excel', 'pdf', 'print'
                      ],
                    "ajax": {
                        url : base_url+'/backend/package/packagesupplier_list?filter=0',
                        type : 'GET'
                    },
                "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
                }
              });
            }
        });
    }
})


if ($("#id").val()!="") {
    ConSelectFun();
}
</script>