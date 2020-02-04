<?php init_head();  ?>
<link rel="stylesheet" href="<?php echo static_url(); ?>assets/css/trumbowyg.css">
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<style type="text/css">
  .multi-select-trans1 .form-control {
    padding: 0px 0 !important;
  }
  #agent_table_wrapper .btn  {
    height: 27px;
    font-size: 12px;
    line-height: 28px;
    background: #009688;
    margin: 1px;
  }
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
   .multi-select-trans .select-wrapper input.select-dropdown, .dropdown-content.select-dropdown.multiple-select-dropdown{
        display: none !important;
    }

    .multi-select-trans .multiselect.dropdown-toggle.btn.btn-default {
        border-color: transparent !important;
        transform: translateY(-8px) !important;
        padding: 0 !important;
        overflow: hidden !important;
    }
    .multi-select-trans .form-control {
        padding: 6px 0 !important;
    }
    .multi-select-trans1 .form-control {
        padding: 0px 0 !important;
    }
    .multi-select-mod button {
        background-color: transparent;
        color: #ccc;
        box-shadow: none;
        border: 1px solid #ccc;
        height: 34px;
        font-size: 14px;
        font-weight: normal;
        text-transform: capitalize;
        padding: 0 1rem;
    }

    .multi-select-mod button:hover {
        background-color: transparent;
        box-shadow: none;
        color: #ccc;
        border: 1px solid #ccc;
    }

    .multi-select-mod .dropdown-menu {
        left: 0;
        top: 34px;
    }

    .multi-select-mod label {
        color: black;
    }
    .multi-select-mod li.active a, .multi-select-mod li.active a:hover {
        background-color: #f1f1f1;
    }

    .multi-select-mod li.active a label {
        color: #000;
    }
    .multi-select-mod [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
        left: auto !important;
        opacity: 1 !important;
    }

    .multi-select-mod .btn-group, .multi-select-mod button, .multi-select-mod .dropdown-menu {
        width: 100%;
    }
    .multi-select-trans .multiselect.dropdown-toggle.btn.btn-default {
        border: 1px solid #cccccc ! important;
        margin-top: 9px;
    }
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 63%;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
             -o-transform: translate3d(0%, 0, 0);
                transform: translate3d(0%, 0, 0);
    }
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
        margin-top: 50px;
    }
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }
    .modal-header {
      background-color: lightblue;
    }
        
/*Right*/
    .modal.right.fade .modal-dialog {
        right: -320px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
           -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
             -o-transition: opacity 0.3s linear, right 0.3s ease-out;
                transition: opacity 0.3s linear, right 0.3s ease-out;
    }
    
    .modal.right.fade.in .modal-dialog {
        right: 0;
    }

/* ----- MODAL STYLE ----- */
    .modal-content {
        border-radius: 0;
        border: none;
    }
    .modal{
        bottom: unset;
    }
    .filepond--drop-label {
      color: #4c4e53;
    }

    .filepond--label-action {
      text-decoration-color: #babdc0;
    }

    .filepond--panel-root {
      border-radius: 2em;
      background-color: #edf0f4;
      height: 1em;
    }

    .filepond--item-panel {
      background-color: #595e68;
    }

    .filepond--drip-blob {
      background-color: #7f8a9a;
    }


</style>
    <div class="sb2-2">
        <div class="sb2-2-add-blog sb2-2-1">
            <div class="col s12">
                <?php if (isset($edit[0]->id) && $edit[0]->id!="") { ?>
                    <h2>Edit Package</h2>
                <?php } else { ?>
                <h2>Add New Package</h2>
                <?php } ?>
                <span class="pull-right"><a href="<?php echo base_url(); ?>backend/package" class="btn-sm btn-primary">Back</a></span>
                <p class="text-danger err-msg hide">Must fill all mandatory feilds!</p>
            </div>
            <form action="<?php echo base_url(); ?>backend/tour/addcontract" name="PackageForm" id="PackageForm" method="post" enctype="multipart/form-data">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
            </br>
            </br>
            </br>
            <input type="hidden" name="edit_id" value="<?php echo isset($edit[0]->id) ? $edit[0]->id : '' ?>">
                <div class="row">
                  <div class="form-group col-md-6">
                      <label for="from_date">Country</label>
                      <select name="ConSelect" id="ConSelect" onchange ="ConSelectFun();">
                      <option value=" "> Country </option>
                      <?php $count=count($contry);
                      for ($i=0; $i <$count ; $i++) { ?>
                      <option  value="<?php echo $contry[$i]->id;?>" sortname="<?php echo  $contry[$i]->sortname; ?>"><?php echo $contry[$i]->name; ?></option>
                      <?php  } ?>
                      </select>
                  </div>
                  <div class="form-group col-md-6">
                      <label for="stateSelect">State</label>
                      <div class="multi-select-mod multi-select-trans multi-select-trans1">
                        <select name="stateSelect" id="stateSelect" class="form-control">
                            <option value="">Select</option>
                        </select> 
                      </div>
                  </div>
                </div>
                <div class="row">
                  <table class="table-responsive" id="PackageTable">
                      <thead>
                          <th width="100">Title</th>
                          <th>Supplier</th>
                          <th >From date</th>
                          <th>To date</th>
                          <th>Type</th>
                          <th>Min pax</th>
                          <th>Max pax</th>
                          <th title="Adult Cost">A.c</th>
                          <th title="Child Cost">C.c</th>
                          <th title="Adult Selling">A.s</th>
                          <th title="Child Selling">C.s</th>
                          <th style="width: 10%">Action</th>
                      </thead>
                      <tbody class="tbody">
                          <tr id="row1">
                              <td>
                                  <textarea  name="title[]" style="height: 20%"></textarea>
                              </td>
                              <td>
                                  <select name="supplier[]">
                                      <?php foreach ($supplier as $key => $value) { ?>
                                          <option value="<?php echo $value->id ?>" ><?php echo $value->Name ?></option>
                                      <?php } ?>
                                  </select>
                              </td>
                              <td>
                                  <input type="text"  readonly name="from_date[]">
                              </td>
                              <td>
                                  <input type="text"  readonly name="to_date[]">
                              </td>
                              <td>
                                  <select name="type[]">
                                      <option value="SIC" >SIC</option>
                                      <option value="Tickets" >Tickets</option>
                                      <option value="Private" >Private</option>
                                      <option value="Others" >Others</option>
                                  </select>
                              </td>
                              <td>
                                 <input type="number" name="MinPax[]">
                              </td>
                              <td>
                                 <input type="number" name="MaxPax[]">
                              </td>
                              <td>
                                  <input type="text" name="adultCost[]">
                              </td>
                              <td>
                                  <input type="text" name="childCost[]">
                              </td>
                              <td>
                                  <input type="text" name="adultSelling[]">
                              </td>
                              <td>
                                  <input type="text" class="ChildSelling" name="ChildSelling[]">
                              </td>
                              <td>
                                <p>
                                  <a class="btn-small add-tr"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                  <a class="btn-small bg-rebeccapurple copy-tr"><i class="fa fa-files-o" aria-hidden="true"></i></a>
                                  <a class="btn-small bg-red delete-tr hide" disabled="disabled"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </p><br>
                                  <span><a href="#" style="font-size: smaller"  id="add_details" data-toggle="modal" data-target="#addDetails">Add more details</a></span>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                </div>
                <div class="row">                  
                  <div class="form-group col-md-6 col-md-offset-6">
                      <?php  if (isset($edit[0]->id) && $edit[0]->id!="") { ?>
                            <button type="button" id="submit_package" style="margin-top: 25px" class="waves-effect waves-light btn-sm btn-success pull-right">Update</button>
                      <?php } else { ?>
                          <button type="button" style="margin-top: 25px" id="submit_package" class="waves-effect waves-light btn-sm btn-success pull-right">Submit</button>
                      <?php } ?>
                  </div>
                </div>                  
                <hr/>
            </form> 
        </div>
    </div>
    <div id="addDetails" class="modal right fade" tabindex="-1" role="dialog">
 
    </div>
<script type="text/javascript">
$('#add_details').click(function (e){
    $("#addDetails").load(base_url+'backend/package/detailsModal/'+$("#add_details").closest('tr').attr('id'));
});
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
    // CitySelectFun();
}

$(".tbody").find('tr:eq(0)').find('td:eq(2)').find('input').datepicker({
    dateFormat: "yy-mm-dd",
    altFormat: "dd/mm/yy",
    changeYear : true,
    changeMonth : true,
});
$(".tbody").find('tr:eq(0)').find('td:eq(3)').find('input').datepicker({
    dateFormat: "yy-mm-dd",
    altFormat: "dd/mm/yy",
    changeYear : true,
    changeMonth : true,
});


$(".tbody").on('keydown', '.ChildSelling', function(e) {
    var prelength = $("#PackageTable").find('tbody').find('tr').length;
    if (e.keyCode == '9') {
       if (($(this).closest('tr').index()+1)==prelength) {
            $("#PackageTable").find('tbody').append('<tr>'+$(".ChildSelling").closest('tr').html()+'</tr>');
            $("#PackageTable").find('tbody').last('tr').find('td:eq(0)');
            $(".delete-tr").removeClass("hide");
            $(".delete-tr:eq(0)").addClass("hide");

            $(".tbody").find('tr:eq('+($(this).closest('tr').index()+1)+')').find('td:eq(2)').find('input').remove().html('<input type="text" readonly name="from_date[]">');
            $(".tbody").find('tr:eq('+($(this).closest('tr').index()+1)+')').find('td:eq(2)').html('<input type="text" name="from_date[]">');

            $(".tbody").find('tr:eq('+($(this).closest('tr').index()+1)+')').find('td:eq(3)').find('input').remove().html('<input type="text" readonly name="to_date[]">');
            $(".tbody").find('tr:eq('+($(this).closest('tr').index()+1)+')').find('td:eq(3)').html('<input type="text" name="to_date[]">');

            $(".tbody").find('tr:eq('+($(this).closest('tr').index()+1)+')').find('td:eq(2)').find('input').datepicker({
                dateFormat: "yy-mm-dd",
                altFormat: "dd/mm/yy",
                changeYear : true,
                changeMonth : true,
            });
            $(".tbody").find('tr:eq('+($(this).closest('tr').index()+1)+')').find('td:eq(3)').find('input').datepicker({
                dateFormat: "yy-mm-dd",
                altFormat: "dd/mm/yy",
                changeYear : true,
                changeMonth : true,
            });
        } 
    }
})

$(".tbody").on('click', '.add-tr', function(e) {
    var index = $("#PackageTable").find('tbody').find('tr').length+1;
    var row = "row"+index;
    $("#PackageTable").find('tbody').append('<tr id="'+row+'">'+$(".ChildSelling").closest('tr').html()+'</tr>');
    $("#PackageTable").find('tbody').last('tr').find('td:eq(0)');
    $(".delete-tr").removeClass("hide");
    $(".delete-tr:eq(0)").addClass("hide");

    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(2)').find('input').remove().html('<input type="text" readonly name="from_date[]">');
    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(2)').html('<input type="text" name="from_date[]">');

    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(3)').find('input').remove().html('<input type="text" readonly name="to_date[]">');
    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(3)').html('<input type="text" name="to_date[]">');

    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(2)').find('input').datepicker({
        dateFormat: "yy-mm-dd",
        altFormat: "dd/mm/yy",
        changeYear : true,
        changeMonth : true,
    });
    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(3)').find('input').datepicker({
        dateFormat: "yy-mm-dd",
        altFormat: "dd/mm/yy",
        changeYear : true,
        changeMonth : true,
    });

})

$(".tbody").on('click', '.copy-tr', function(e) {
    $(this).closest('tr').clone().appendTo('.tbody');
    $(".delete-tr").removeClass("hide");
    $(".delete-tr:eq(0)").addClass("hide");

    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(2)').find('input').remove().html('<input type="text" readonly name="from_date[]">');
    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(2)').html('<input type="text" name="from_date[]">');

    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(3)').find('input').remove().html('<input type="text" readonly name="to_date[]">');
    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(3)').html('<input type="text" name="to_date[]">');

    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(2)').find('input').datepicker({
        dateFormat: "yy-mm-dd",
        altFormat: "dd/mm/yy",
        changeYear : true,
        changeMonth : true,
    });
    $(".tbody").find('tr:eq('+($("#PackageTable").find('tbody').find('tr').length-1)+')').find('td:eq(3)').find('input').datepicker({
        dateFormat: "yy-mm-dd",
        altFormat: "dd/mm/yy",
        changeYear : true,
        changeMonth : true,
    });
})

$(".tbody").on('click', '.delete-tr', function(e) {
    $(this).parent().parent('tr').remove();
})

$("#submit_package").click(function() {
    var Country = $("#ConSelect").val();
    var State = $("#stateSelect").val();

    var cnt = 0;
    if (Country==" ") {
        addToast("Country field is required!","orange");
        $("#ConSelect").focus();
        cnt+=1;
    } else if(State=="") {
        addToast("State field is required!","orange");
        $("#stateSelect").focus();
        cnt+=1;
    }

    var length = $(".tbody").find('tr').length;

    $.each($(".tbody").find('tr'), function( i, v ) {
        if ($(".tbody").find('tr:eq('+i+')').find('td:eq(0)').find('textarea').val()=="") {
            cnt+=1;
            $(".tbody").find('tr:eq('+i+')').find('td:eq(0)').find('textarea').css('border','1px solid red');
        } else {
            $(".tbody").find('tr:eq('+i+')').find('td:eq(0)').find('textarea').css('border','1px solid rgb(169, 169, 169)');
        }

        if ($(".tbody").find('tr:eq('+i+')').find('td:eq(2)').find('input').val()=="") {
            cnt+=1;
            $(".tbody").find('tr:eq('+i+')').find('td:eq(2)').find('input').css('border','1px solid red');
        } else {
            $(".tbody").find('tr:eq('+i+')').find('td:eq(2)').find('input').css('border','1px solid rgb(169, 169, 169)');
        }

        if ($(".tbody").find('tr:eq('+i+')').find('td:eq(3)').find('input').val()=="") {
            cnt+=1;
            $(".tbody").find('tr:eq('+i+')').find('td:eq(3)').find('input').css('border','1px solid red');
        } else {
            $(".tbody").find('tr:eq('+i+')').find('td:eq(3)').find('input').css('border','1px solid rgb(169, 169, 169)');
        }


        if ($(".tbody").find('tr:eq('+i+')').find('td:eq(7)').find('input').val()=="" && $(".tbody").find('tr:eq('+i+')').find('td:eq(8)').find('input').val()=="") {
            cnt+=1;
            $(".tbody").find('tr:eq('+i+')').find('td:eq(7)').find('input').css('border','1px solid red');
            $(".tbody").find('tr:eq('+i+')').find('td:eq(8)').find('input').css('border','1px solid red');
        } else {
            $(".tbody").find('tr:eq('+i+')').find('td:eq(7)').find('input').css('border','1px solid rgb(169, 169, 169)');
            $(".tbody").find('tr:eq('+i+')').find('td:eq(8)').find('input').css('border','1px solid rgb(169, 169, 169)');
        }

        if ($(".tbody").find('tr:eq('+i+')').find('td:eq(9)').find('input').val()=="" && $(".tbody").find('tr:eq('+i+')').find('td:eq(10)').find('input').val()=="") {
            cnt+=1;
            $(".tbody").find('tr:eq('+i+')').find('td:eq(9)').find('input').css('border','1px solid red');
            $(".tbody").find('tr:eq('+i+')').find('td:eq(10)').find('input').css('border','1px solid red');
        } else {
            $(".tbody").find('tr:eq('+i+')').find('td:eq(9)').find('input').css('border','1px solid rgb(169, 169, 169)');
            $(".tbody").find('tr:eq('+i+')').find('td:eq(10)').find('input').css('border','1px solid rgb(169, 169, 169)');
        }

    });

    if (cnt==0) {
        $("#submit_package").prop('disabled',true);
        $(".err-msg").addClass('hide');
        $.ajax({
            dataType: 'json',
            type: 'post',
            url: base_url+'/backend/Package/PackageSubmit',
            data: $('#PackageForm').serialize(),
            cache: false,
            success: function (response) {
              if(response==true) {
                location.href = "<?php echo base_url('backend/package')?>";
              }
            }
        });
    } else {
        $(".err-msg").removeClass('hide');
    }
})
</script>
<script type="text/javascript" src="<?php echo static_url(); ?>assets/js/trumbowyg.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<?php init_tail(); ?>


