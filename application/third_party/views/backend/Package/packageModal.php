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
             <h4 class="modal-title">Add Package</h4>
             <p class="text-danger err-msg hide">Must fill all mandatory feilds!</p>
        </div>
        <div class="modal-body">
            <form method="POST" id="PackageForm">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="from_date">Country</label>
                    <select name="ConSelect" class="form-control" id="ConSelect" onchange ="ConSelectFun();">
                    <option value=" "> Country </option>
                    <?php $count=count($contry);
                    for ($i=0; $i <$count ; $i++) { ?>
                    <option  value="<?php echo $contry[$i]->id;?>" sortname="<?php echo  $contry[$i]->sortname; ?>"><?php echo $contry[$i]->name; ?></option>
                    <?php  } ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="stateSelect">State</label>
                    <select name="stateSelect" id="stateSelect"  class="form-control">
                        <option value="">Select</option>
                    </select> 
                </div>
            </div>

            <div class="row">
                <table class="table-responsive" id="PackageTable">
                    <thead>
                        <th>Title</th>
                        <th>Supplier</th>
                        <th width="120">From date</th>
                        <th width="120">To date</th>
                        <th>Type</th>
                        <th width="90">Min pax</th>
                        <th width="90">Max pax</th>
                        <th width="100" title="Adult Cost">A.c</th>
                        <th width="100" title="Child Cost">C.c</th>
                        <th width="100" title="Adult Selling">A.s</th>
                        <th width="100" title="Child Selling">C.s</th>
                        <th width="100">Action</th>
                    </thead>
                    <tbody class="tbody">
                        <tr>
                            <td>
                                <textarea  name="title[]"></textarea>
                            </td>
                            <td>
                                <select class="form-control" name="supplier[]">
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
                                <select class="form-control" name="type[]">
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
                                <a class="btn-small add-tr"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                <a class="btn-small bg-rebeccapurple copy-tr"><i class="fa fa-files-o" aria-hidden="true"></i></a>
                                <a class="btn-small bg-red delete-tr hide" disabled="disabled"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <input type="button" id="submit_package" class="no-border btn-sm btn-success" value="Update">
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
    $("#PackageTable").find('tbody').append('<tr>'+$(".ChildSelling").closest('tr').html()+'</tr>');
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

            }
        });
    } else {
        $(".err-msg").removeClass('hide');
    }
})
</script>