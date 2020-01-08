<?php init_head(); 
$Payment = menuPermissionAvailability($this->session->userdata('id'),'General','Currency'); 
?>
    <div class="sb2-2">
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <span>City List</span>
                    </div>
                    <div class="tab-inn">
                        <div class="row"> 
                            <div class="col-md-8">
                                
                            <div class="table-responsive table-desi">
                                <table class="table table-condensed table-hover" id="city_list">
                                   <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>City Name</th>
                                        <th>City Code</th>
                                        <th>Country Name</th>
                                    </tr>
                                   </thead>
                                    <tbody>
                                    </tbody>
                                </table>             
                            </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group col-md-12">
                                    <form id="citylistForm" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"> 
                                        <label>Upload excel file</label>
                                         <span class="pull-right mar_left_10"><a href="<?php echo base_url(); ?>uploads/samplecityList.xlsx" ><i class="fa fa-download"></i> (Sample.xlsx*)</a></span>
                                        <input type="file" name="citylist" id="citylist"  onchange="return ValidateFileUpload();"/>
                                        <button type="button" id="CityUploadButton" class="waves-effect waves-light btn-sm btn-success pull-right">Update</button>
                                    </form>
                                </div>
                              </div> 
                        </div>
                    </div>
                    <br>
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var city_list = $('#city_list').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/common/city_list_data',
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });

    function ValidateFileUpload() {
        var fuData = document.getElementById('citylist');
        var FileUploadPath = fuData.value;

        //To check if user upload any file
      
        var Extension = FileUploadPath.substring(
        FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

        //The file uploaded is an image

        if (Extension == "xlsx" || Extension == "xls") {
        } else {
            error = "Excel file only allows file types of xlsx, xls. ";
              color = "red";
           $("#citylist").val("");
           addToast(error,color);
        }
    }

    $("#CityUploadButton").click(function() {
        var citylist = $("#citylist").val();
        if (citylist=="") {
           addToast("Must upload a excel file!",'orange');
        } else {
            addToast("Updated Successfully","green");
            window.setTimeout(function(){
              $("#citylistForm").attr("action",base_url+"backend/common/citylistupload");
              $("#citylistForm").submit();
            }, 1000); 
        }
    })
</script>
<?php init_tail(); ?>


