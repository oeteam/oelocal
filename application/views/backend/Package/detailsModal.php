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
   <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="overview">Overview :</label><span>*</span>
                        <textarea class="form-control" name="overview" id="overview"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="address">Address :</label><span>*</span>
                        <textarea class="form-control" name="address" id="address"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="duration">Duration :</label><span>*</span>
                        <input type="text" class="form-control" name="duration" id="duration"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inclusion">Inclusions :</label><span>*</span>
                        <textarea class="form-control" name="inclusion" id="inclusion"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exclusion">Exclusions :</label><span>*</span>
                        <textarea class="form-control" name="exclusion" id="exclusion"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="terms">Terms and Conditions :</label><span>*</span>
                        <textarea class="form-control" name="terms" id="terms"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="hours">Operational Hours</label><span>*</span>
                        <textarea class="form-control" name="hours" id="hours"></textarea>
                    </div>
                </div>
                <div class="row"><br>
                    <h5>Booking Policy</h5><br>
                    <div class="form-group col-md-6">
                        <label for="cancelPolicy">Cancellation Policy</label><span>*</span>
                        <textarea class="form-control" name="cancelPolicy" id="cancelPolicy"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="childPolicy">Child Policy</label><span>*</span>
                        <textarea class="form-control" name="childPolicy" id="childPolicy"></textarea>
                    </div>
                </div>
                <div class="row"><br>
                    <h5>Images</h5><br>
                    <div class="form-group col-md-12">
                        <label for="images">Images</label><span>*</span>
                        <input type="file" class="filepond" name="images" data-max-files="3" />
                </div>
                <div class="row">
                    <div class="btn-toolbar pull-right">
                        <button type="button" class="btn btn-default nBtn nclose" data-dismiss="addDetails">close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

<script type="text/javascript">
$('#overview').trumbowyg();
$('#exclusion').trumbowyg();
$('#inclusion').trumbowyg();
$('#terms').trumbowyg();
$('#hours').trumbowyg();
$('#childPolicy').trumbowyg();
$('#cancelPolicy').trumbowyg();
$(function(){
    FilePond.registerPlugin(
      FilePondPluginImageExifOrientation,
      FilePondPluginImagePreview
    );
    // Turn input element into a pond
    $('.filepond').filepond();

    // Turn input element into a pond with configuration options
    $('.filepond').filepond({
        allowMultiple: true
    });

    // Set allowMultiple property to true
    $('.filepond').filepond('allowMultiple', true);
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