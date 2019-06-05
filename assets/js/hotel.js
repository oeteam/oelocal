// $(document).ready(function() {
    $("#add_button").removeClass("hide");

   $('#hotel_contract').change(function () {
    var sText = $(this).find("option:selected").text();
    var sValue = hotel_contract.value;
    var filter = $("#filter").val();
    $('#hotel_id').val(sValue);
    var contract_table = $('#contract_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/contract_hotel?id='+sValue+'&filter='+filter,
            type : 'GET'
        },
      "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();          
      }
    });
  });
    $("#add_button").removeClass("hide");

  $('#add_button').click(function (e){
    var hotel_id = $('#hotel_id').val();
    $("#contract_model").load(base_url+'backend/hotels/contract_Modal?hotel_id='+hotel_id);
  });
  var room_type_table = $('#room_type_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/room_type_list',
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
   var contract_hotel_table = $('#contract_hotel_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/contract_hotel_table_list',
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
   var agent_hotel_table = $('#agent_hotel_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/contract_agent_hotel_table_list',
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });

  // $('#Discount').click(function (e){
  //   $("#DisModal").load(base_url+'backend/Sight_Seeing/newoffers');
  // });
  $('#permission_update_btn').click(function (e) {
    var url = $("#permission_settings_form").attr("action");
      e.preventDefault();
        $.ajax({
          dataType: 'json',
          type: 'post',
          url: 'user_validation',
          data: $('#permission_settings_form').serialize(),
          cache: false,
          success: function (respose) {
            if (respose.status == "1") {
              addToast(respose.error,respose.color);
              window.setTimeout(function(){
                 $("#user_form").submit();
              }, 4000);
            } else {
              addToast(respose.error,respose.color);
            }
          },
           error: function (xhr,status,error) {
             alert("Error: " + error);
          }
        });
    }); 

  var hotel_facility_table = $('#hotel_facility_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/hotel_facility_list',
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
  var room_facility_table = $('#room_facility_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/room_facility_list',
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  }); 
  var hotel_table = $('#hotel_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/hotel_list',
            data: $('#hotel_filter_form').serialize(),
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
  var hotel_id = $("#hotel_id").val();
  var hotel_room_table = $('#hotel_room_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/hotel_room_list?id='+hotel_id,
            data: $('#hotel_filter_form').serialize(),
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
  var hotel_id = $("#hotel_id").val();
  var hotel_room_table_excel = $('#hotel_room_table_excel').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/hotel_room_list_excel?id='+hotel_id,
            data: $('#hotel_filter_form').serialize(),
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
//   function per_check_all_permission() {
//     alert("ljhjgug");
//   if ($("#per_check_all").is(":checked")) {
//     $(".per_childs").attr("checked","checked");
//   } else {
//     $(".per_childs").removeAttr("checked","checked");
//   }
// }
 // $("#permission_update_btn").click(function() {
 //    $("#permission_settings_form").attr("action",base_url+"backend/hotels/agent_permission_update");
 //    $("#permission_settings_form").submit();
 //  });

var hotel_id = $("#hotel_id").val();
 var agent_permission_table = $('#agent_permission_table').dataTable({
        "bDestroy": true,
        "lengthMenu": [[-1,10, 25, 50], ["All",10, 25, 50]],
        "ajax": {
            url : base_url+'/backend/hotels/permission_agent_list?id='+hotel_id,
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  }); 

	$('#room_type_form_button').click(function (e) {
      e.preventDefault();
      $.ajax({
      	dataType: 'json',
        type: 'post',
        url: 'add_room_type',
        data: $('#room_type_form').serialize(),
		cache: false,
        success: function (response) {
        	if (response.status == "1") {
            addToast(response.error,response.color);
            window.setTimeout(function(){
               $("#room_type_form").submit();
            }, 1500);
        	} else {
        		addToast(response.error,response.color);
        	}
        },
         error: function (xhr,status,error) {
           alert("Error: " + error);
        }
      });

    });

  
  $('#hotel_tab_8').click(function (e) {
    var from_date = $("#from_date").val();
    var to_date   = $("#to_date").val();
    if(from_date=="" || to_date=="" || from_date>to_date==1){

    if (from_date=="") {
        addToast('From Date Is Required',"orange");
        $("#from_date").focus();
          }
    if (to_date=="") {
        addToast('To Date Is Required',"orange");
        $("#to_date").focus();
          }
    if (from_date>to_date){
        addToast('To Date Must be After From Date',"orange")
        $("#to_date").focus();
          }
        }  
      else{
          $("#add_close_hotel").submit();
          addToast("Updated Successfully","green");
      }    
    });
  $('#hotel_facility_form_button').click(function (e) {
      e.preventDefault();
      $.ajax({
        dataType: 'json',
        type: 'post',
        url: 'add_hotel_facility',
        data: $('#hotel_facility_form').serialize(),
    cache: false,
        success: function (response) {
          if (response.status == "1") {
            addToast(response.error,response.color);
            window.setTimeout(function(){
               $("#hotel_facility_form").submit();
            }, 1500);
          } else {
            addToast(response.error,response.color);
          }
        },
         error: function (xhr,status,error) {
           alert("Error: " + error);
        }
      });

    });
  /*Room Facility*/
  $('#room_facility_form_button').click(function (e) {
      e.preventDefault();
      $.ajax({
        dataType: 'json',
        type: 'post',
        url: 'add_room_facility',
        data: $('#room_facility_form').serialize(),
    cache: false,
        success: function (response) {
          if (response.status == "1") {
            addToast(response.error,response.color);
            window.setTimeout(function(){
               $("#room_facility_form").submit();
            }, 1500);
          } else {
            addToast(response.error,response.color);
          }
        },
         error: function (xhr,status,error) {
           alert("Error: " + error);
        }
      });

    });
  $('#contract_submit').click(function () {
    var amount          = $("#amount").val();
    var application     = $("#application").val();
    var classification  = $("#classification").val();
    var rate_type       = $("#rate_type").val();
    var tax             = $("#tax").val();
    var markup          = $("#markup").val();
    var max_age         = $("#max_age").val();
    var date_picker     = $("#date_picker").val();
    var date_picker1    = $("#date_picker1").val();
    var board           = $("#board").val();
    var hotel_id        = $("#id").val();
    var contract_type   = $("#contract_type").val();
    var contract_name   = $("#contract_name").val();
    var linked_contract = $("#linked_contract").val();
    if(amount=="")
    {
      addToast('Amount field is required!',"orange");
      $("#amount").focus();
    } 
    else if (application=="") 
    {
      addToast('Application field is required!',"orange");
      $("#application").focus();
    }
    else if(classification=="")
    {
      addToast('Classification field is required!',"orange");
      $("#classification").focus();
    } 
    else if(rate_type=="") 
    {
      addToast('Rate type field is required!',"orange");
      $("#rate_type").focus();
    }
     else if(tax=="")
    {
       addToast('Tax % field is required!',"orange");
      $("#tax").focus();
    }
    else if (markup=="") {
      addToast('Markup field is required!',"orange");
      $("#markup").focus();
    }
     else if(max_age=="")
    {
       addToast('Max. child age field is required!',"orange");
      $("#max_age").focus();
    }
    else if (date_picker=="")
     {
      addToast('From date field is required!',"orange");
      $("#date_picker").focus();
    }
    else if(date_picker1=="")
    {
      addToast('To Date field is required!',"orange");
      $("#date_picker1").focus();
    } else if (contract_name=="") {
      addToast('Contract Name field is required!',"orange");
      $("#contract_name").focus();
    } else if(contract_type=="Sub" && linked_contract=="") {
      addToast('Linked Contract field is required!',"orange");
      $("#linked_contract").focus();
    } else {
       addToast('Contract added successfully',"green");
       $("#add_contract").attr('action',base_url+'backend/hotels/add_contract');
       $("#add_contract").submit();
     }
   });

  $('#contract_update').click(function () {
    var tax             = $("#tax").val();
    var markup          = $("#markup").val();
    var max_age         = $("#max_age").val();
    var date_picker     = $("#date_picker").val();
    var date_picker1    = $("#date_picker1").val();
    var board           = $("#board").val();
    var hotel_id        = $("#id").val();
    var contract_type   = $("#contract_type").val();
    var contract_name   = $("#contract_name").val();
    var linked_contract   = $("#linked_contract").val();
    if (date_picker=="")
     {
      addToast('From date field is required!',"orange");
      $("#date_picker").focus();
    }
    else if(date_picker1=="")
    {
      addToast('To Date field is required!',"orange");
      $("#date_picker1").focus();
    } else if(tax=="")
    {
      addToast('Tax % field is required!',"orange");
      $("#tax").focus();
    }
    else if (markup=="") {
      addToast('Markup field is required!',"orange");
      $("#markup").focus();
    }
     else if(max_age=="")
    {
       addToast('Max. child age field is required!',"orange");
      $("#max_age").focus();
    }
    else  if (contract_name=="") {
      addToast('Contract Name field is required!',"orange");
      $("#contract_name").focus();
    } else if(contract_type=="Sub" && linked_contract=="") {
      addToast('Linked Contract field is required!',"orange");
      $("#linked_contract").focus();
    } else {
       addToast('Contract Updated successfully',"green");
       $("#add_contract").attr('action',base_url+'backend/hotels/update_contract');
       $("#add_contract").submit();
     }
   });


  $('#room_rate_date_update').click(function () {
    var from_height1    = $("#from_high1").val();
    var from_height2    = $("#from_high2").val();
    var from_shoulder1  = $("#from_shoulder1").val();
    var from_shoulder2  = $("#from_shoulder2").val();
    var from_peak1      = $("#from_peak1").val();
    var from_peak2      = $("#from_peak2").val();
    var from_low        = $("#from_low").val();
    var to_height1      = $("#to_high1").val();
    var to_height2      = $("#to_high2").val();
    var to_shoulder1    = $("#to_shoulder1").val();
    var to_shoulder2    = $("#to_shoulder2").val();
    var to_peak1        = $("#to_peak1").val();
    var to_peak2        = $("#to_peak2").val();
    var to_low          = $("#to_low").val();
    if(from_height1!="" && to_height1=="")
    {
      addToast('Season 1 To Date field is required!',"orange");
      $("#to_high1").focus();
    } 
    else if (to_height1!="" && from_height1=="") 
    {
      addToast('Season 1 From Date field is required!',"orange");
      $("#from_high1").focus();
    }
    else if(from_shoulder1!="" && to_shoulder1=="")
    {
      addToast('Season 2 To Date field is required!',"orange");
      $("#to_shoulder1").focus();
    } 
    else if(to_shoulder1!="" && from_shoulder1=="") 
    {
      addToast('Season 2 From Date field is required!',"orange");
      $("#from_shoulder1").focus();
    }
     else if(from_peak1!="" && to_peak1=="")
    {
       addToast('Season 3 To Date field is required!',"orange");
      $("#to_peak1").focus();
    }
    else if (to_peak1!="" && from_peak1=="") {
      addToast('Season 3 From Date field is required!',"orange");
      $("#from_peak1").focus();
    }
     else if(from_low!="" && to_low=="")
    {
       addToast('Season 7 To Date field is required!',"orange");
      $("#to_low").focus();
    }
    else if (to_low!="" && from_low=="")
     {
      addToast('Season 7 From Date field is required!',"orange");
      $("#from_low").focus();
    }
    else if(from_height2!="" && to_height2=="")
    {
       addToast('Season 6 To Date field is required!',"orange");
      $("#to_height2").focus();
    }
    else if (to_height2!="" && from_height2=="") 
    {
      addToast('Season 6 From Date field is required!',"orange");
      $("#from_height2").focus();
    }
    else if(from_shoulder2!="" && to_shoulder2=="")
    {
       addToast('Season 5 To Date field is required!',"orange");
      $("#to_shoulder2").focus();
    }
    else if (to_shoulder2!="" && from_shoulder2=="") 
    {
      addToast('Season 5 From Date field is required!',"orange");
      $("#from_shoulder2").focus();
    }
    else if(from_peak2!="" && to_peak2=="")
    {
       addToast('Season 4 To Date field is required!',"orange");
      $("#to_peak2").focus();
    }
    else if (to_peak2!="" && from_peak2=="") {
      addToast('Season 4 From Date field is required!',"orange");
      $("#from_peak2").focus();
    }
     else
      {
       addToast('Roon Rate update Successfully',"green");
      $("#hotel_excel_form").submit();
     }
   });
  /* Delete data */
  function commonDelete() {
      $.ajax({
      dataType: 'json',
      type: "POST",
      url: $("#delete_form").attr("action"),
      data: $("#delete_form").serialize(),
      cache: false,
      success: function (response) {
        if (response.status==1) {
          close_delete_modal();
          if (response.table == "MinimumStay_table") {
            addToast(response.error,response.color);
            MinimumStay_contract_id = $('#contract_id').val();
            MinimumStay_hotel_id = $('#hotel_id').val();
            var MinimumStay_table = $('#MinimumStay_table').dataTable({
                    "bDestroy": true,
                    "ajax": {
                        url : base_url+'/backend/hotels/MinimumStayList?hotel_id='+MinimumStay_hotel_id+'&contract_id='+MinimumStay_contract_id,
                        type : 'GET'
                    },
                  "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                  }
              });
          } else if(response.table == "hotel_facility_table") {
            hotel_facility_table.api().ajax.reload(function(){ 
                addToast(response.error,response.color);
              }, true); 
          } else if(response.table == "room_facility_table") {
            room_facility_table.api().ajax.reload(function(){ 
                addToast(response.error,response.color);
              }, true); 
          } else if(response.table == "hotel_table") {
            hotel_table.api().ajax.reload(function(){ 
               //$(".Rejected").trigger('click');
                addToast(response.error,response.color);
              }, true); 
          } else if(response.table == "room_table") {
            hotel_room_table.api().ajax.reload(function(){ 
                addToast(response.error,response.color);
              }, true); 
          
          }else if(response.table == "hotel_contract") {
                addToast(response.error,response.color);
                window.location = base_url+"backend/hotels/contract_menu?hotel_id="+$("#hotel_id").val();
          } else if (response.table ==  "stopSale_table") {
              addToast(response.error,response.color);
              var sText = $("#hotel_stopSale").find("option:selected").text();
              var sValue = hotel_stopSale.value;
              $('#hotel_id').val(sValue);
               var contract_table = $('#stopSale_table').dataTable({
                  "bDestroy": true,
                  "ajax": {
                      url : base_url+'/backend/hotels/hotels_stopSale_list?id='+sValue,
                      type : 'GET'
                  },
              "fnDrawCallback": function(settings){
              $('[data-toggle="tooltip"]').tooltip();          
              }
            });
          } else if(response.table == "childPolicy_table") {
              addToast(response.error,response.color);
              var hotel_id = $("#hotel_id").val();
              var contract_id = $("#contract_id").val();
              var childPolicy_table = $('#childPolicy_table').dataTable({
                    "bDestroy": true,
                    "ajax": {
                        url : base_url+'/backend/hotels/childPolicy_list?id='+hotel_id+'&con_id='+contract_id,
                        type : 'GET'
                    },
                "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
                }

              });
          } else if (response.table == "BoardSupplement_table") {
              addToast(response.error,response.color);
              board_contract_id = $('#contract_id').val();
              board_hotel_id = $('#hotel_id').val();
              var BoardSupplement_table = $('#BoardSupplement_table').dataTable({
                    "bDestroy": true,
                    "ajax": {
                        url : base_url+'/backend/hotels/BoardSupplementList?hotel_id='+board_hotel_id+'&contract_id='+board_contract_id,
                        type : 'GET'
                    },
                  "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                  }
                });
          } else if (response.table == "GeneralSupplement_table") {
              addToast(response.error,response.color);
              GeneralSupplement_contract_id = $('#contract_id').val();
              GeneralSupplement_hotel_id = $('#hotel_id').val();
              var GeneralSupplement_table = $('#GeneralSupplement_table').dataTable({
                    "bDestroy": true,
                    "ajax": {
                        url : base_url+'/backend/hotels/GeneralSupplementList?hotel_id='+GeneralSupplement_hotel_id+'&contract_id='+GeneralSupplement_contract_id,
                        type : 'GET'
                    },
                  "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                  }
                });
          } else if (response.table == "CancelationFee_table") {
              addToast(response.error,response.color);
              CancelationFee_contract_id = $('#contract_id').val();
              CancelationFee_hotel_id = $('#hotel_id').val();
              var CancelationFee_table = $('#CancelationFee_table').dataTable({
                    "bDestroy": true,
                    "ajax": {
                        url : base_url+'/backend/hotels/CancelationFeeList?hotel_id='+CancelationFee_hotel_id+'&contract_id='+CancelationFee_contract_id,
                        type : 'GET'
                    },
                  "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                  }
              });
          } else if(response.table == "hotel_closeout_table") {
            addToast(response.error,response.color);
            var closeouthotel_id = $("#hotel_id").val();
            var closeoutcontract_id = $("#contract_id").val();
            var hotel_closeout_table = $('#hotel_closeout_table').dataTable({
                  "bDestroy": true,
                  "ajax": {
                      url : base_url+'/backend/hotels/hotel_closeout_list?id='+closeouthotel_id+'&contract_id='+closeoutcontract_id,
                      type : 'GET'
                  },
              "fnDrawCallback": function(settings){
              $('[data-toggle="tooltip"]').tooltip();          
              }
            });
          } else if(response.table == "discountTable") {
              addToast(response.error,response.color);
              var filter = $("#filter").val();
              var discountTable = $("#discountTable").dataTable({
                  "bDestroy": true,
                  "ajax": {
                      url : base_url+'/backend/Hotels/DiscountoffList?filter='+filter,
                      type : 'POST'

                  },
              "fnDrawCallback": function(settings){
              $('[data-toggle="tooltip"]').tooltip();          
              }
            });
          } else if (response.table == "extrabed_table") {
            addToast(response.error,response.color);
              extrabed_contract_id = $('#contract_id').val();
              extrabed_hotel_id = $('#hotel_id').val();
              var extrabed_table = $('#extrabed_table').dataTable({
                    "bDestroy": true,
                    "ajax": {
                        url : base_url+'/backend/hotels/extrabedList?hotel_id='+extrabed_hotel_id+'&con_id='+extrabed_contract_id,
                        type : 'GET'
                    },
                  "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                  }
              });
          } else if (response.table == "season_table") {
            addToast(response.error,response.color);
            var seasonhotel_id = $("#hotel_id").val();
            var seasoncontract_id = $("#contract_id").val();
            var season_table = $('#season_table').dataTable({
                  "bDestroy": true,
                  "ajax": {
                      url : base_url+'/backend/hotels/seasonList?hotel_id='+seasonhotel_id+'&contract_id='+seasoncontract_id,
                      type : 'GET'
                  },
                "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
                }
              });
          } else if(response.table == "room_aminities_table") {
             addToast(response.error,response.color);
             var room_aminities_table = $('#room_aminities_table').dataTable({
                "bDestroy": true,
                "ajax": {
                    url : base_url+'/backend/hotels/roomAminitiesList',
                    type : 'GET'
                },
              "fnDrawCallback": function(settings){
              $('[data-toggle="tooltip"]').tooltip();          
              }
            });
          } else if(response.table == "Revenue_Seasonlist_table") {
             addToast(response.error,response.color);
              var Revenue_Seasonlist_table = $("#Revenue_Seasonlist_table").dataTable({
                  "bDestroy": true,
                  "ajax": {
                      url : base_url+'/backend/Hotels/RevenueSeasonlist',
                      type : 'POST'

                  },
              "fnDrawCallback": function(settings){
              $('[data-toggle="tooltip"]').tooltip();          
              }
            });
          } else if(response.table == "Revenue_list_table") {
            var Revenue_list_table = $("#Revenue_list_table").dataTable({
                    "bDestroy": true,
                    "ajax": {
                        url : base_url+'/backend/Hotels/Revenuelist?filter=1',
                        type : 'POST'

                    },
                "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
                }
              });
          } else if (response.table == "ranking_table") {
              addToast(response.error,response.color);
              var rankingTable = $('#rankingTable').dataTable({
                "bDestroy": true,
                "ajax": {
                    url : base_url+'/backend/hotels/ranking_list?filter=1',
                    type : 'GET'
                },
                "fnDrawCallback": function(settings){
                  $('[data-toggle="tooltip"]').tooltip();          
                }
              });
          } else if(response.table == "Display_list_table") {
            var Display_list_table = $("#Display_list_table").dataTable({
                    "bDestroy": true,
                    "ajax": {
                        url : base_url+'/backend/Hotels/Displaylist',
                        type : 'POST'

                    },
                "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
                }
              });
          } else {
              room_type_table.api().ajax.reload(function(){ 
                addToast(response.error,response.color);
              }, true); 
          }
        } else {
          addToast(response.error,response.color);
        }
      }
    });

  }
function blockHotel() {
      $.ajax({
      dataType: 'json',
      type: "POST",
      url: base_url+"backend/hotels/delete_hotel",
      data: $("#delete_formhotel").serialize(),
      cache: false,
      success: function (response) {
        if (response.status==1) {
          close_delete_modal();
          if(response.table == "hotel_table") {
              hotel_table.api().ajax.reload(function(){ 
              $(".Rejected").trigger('click');
                addToast(response.error,response.color);
              }, true);  
          
          } else {
              room_type_table.api().ajax.reload(function(){ 
                addToast(response.error,response.color);
              }, true); 
          }

          } else {
          addToast(response.error,response.color);
        }
      }
    });

  }
   
  $("#hotel_tab_1").click(function() {
    ConSelectFun();
    var map_location = $("#us3-address").val();
    var map_error = "Map location field is required!";
    if (map_location=="") {
      addToast(map_error,"orange");
    } else if(map_location!="") {
      $("#menu1").addClass("in active")
      $("#home").removeClass("in active")
      $(".menu1").addClass("active")
      $(".home").removeClass("active")
    }
  });
  $("#hotel_tab_2").click(function() {
    $("#room_aminities").val($("#chip1").text());
    $("#keywords").val($("#chip2").text());
    var hotel_name = $("#hotel_name").val();
    var city = $("#city").val();
    var citydes = $("#citydes").val();
    var citynearby = $("#citynearby").val();
    var contry = $("#ConSelect").val();
    var state = $("#stateSelect").val();
    // var room_aminities = $("#room_aminities").val();
    var room_aminities=$("#chip1").material_chip('data');
    var keywords=$("#chip2").material_chip('data');
    var hotel_facilties = $("#hotel_facilties").val();
    var room_facilties1 = $("#room_facilties1").val();
    var hotel_description = $("#hotel_description").val();
    var total_no_of_rooms = $("#total_no_of_rooms").val();
    // var Website = $("#Website").val();
    var sell_currency = $("#sell_currency").val();
    if (hotel_name=="") {
      addToast("Hotel Name field is required!","orange");
      $("#hotel_name").focus();
    }   else if (city=="") {
      addToast("City field is required!","orange");
      $("#city").focus();
    } else if (citydes=="") {
      addToast("City description field is required!","orange");
      $("#citydes").focus();
    } else if (citynearby=="") {
      addToast("City near by places field is required!","orange");
      $("#citynearby").focus();
    } else if (hotel_facilties=="") {
      addToast("Hotel facilities field is required!","orange");
      $("#hotel_facilties").focus();
    } else if (room_facilties1=="") {
      addToast("Room facilities field is required!","orange");
      $("#hotel_facilties").focus();
    } else if (room_aminities=="") {
      addToast("Room aminities field is required!","orange");
      $("#chip1").focus();
    } else if (keywords=="") {
      addToast("Keywords field is required!","orange");
      $("#chip2").focus();
    } else if (hotel_description=="") {
      addToast("Hotel description field is required!","orange");
      $("#hotel_description").focus();
    } else if (total_no_of_rooms=="") {
      addToast("No of Rooms field is required!","orange");
      $("#total_no_of_rooms").focus();
    } else if (Website=="") {
      addToast("Website field is required!","orange");
      $("#Website").focus();
    }  else if (sell_currency=="") {
      addToast("Selling Currency field is required!","orange");
      $("#sell_currency").focus();
    }  else if (contry=="") {
      addToast("Country field is required!","orange");
      $("#sell_currency").focus();
    }  else if (state=="") {
      addToast("State field is required!","orange");
      $("#sell_currency").focus();
    }
    else {
      $("#menu3").addClass("in active")
      $("#menu1").removeClass("in active")
      $("#home").removeClass("in active")
      $(".menu3").addClass("active")
      $(".menu1").removeClass("active")
      $(".home").removeClass("active")
    }
  });
  $("#hotel_tab_2_prev").click(function() {
    $("#menu1").removeClass("in active")
    $("#home").addClass("in active")
    $(".menu1").removeClass("active")
    $(".home").addClass("active")
  });
  $("#voucher_type_id").val($("#voucher_type").val());

  $("#voucher_settings_btn").click(function() {
    $("#voucher_settings_form").attr("action",base_url+"backend/hotels/agent_permission_update");
    $("#voucher_settings_form").submit();
  });
  // $("#room_type_add").click(function() {
  //   var room_name = $("#room_name").val();
  //   var room_type_select = $("#room_type_select").val();
  //   var room_type_select_val = $("#room_type_select option:selected").val();
  //   var room_type_select_text = $("#room_type_select option:selected").text();
  //   var price = $("#price").val();
  //   var room_facilties = $("#room_facilties").val();
  //   var occupancy = $("#occupancy").val();
  //   var occupancy_selected = $("#occupancy option:selected").val();
  //   var occupancy_selected_text = $("#room_type_select option:selected").text();
  //   var occupancy_child_selected = $("#occupancy_child option:selected").val();
  //   var no_of_rooms = $("#no_of_rooms option:selected").val();
  //   if (room_name=="") {
  //     addToast("Room Name field is required!","orange");
  //     $("#room_type_select").focus();
  //   } else if (room_type_select=="") {
  //     addToast("Room type field is required!","orange");
  //     $("#room_type_select").focus();
  //   } else if (price=="") {
  //     addToast("price field is required!","orange");
  //     $("#price").focus();
  //   } else if (room_facilties=="") {
  //     addToast("Room Facilities field is required!","orange");
  //     $("#room_facilties").focus();
  //   } else if (occupancy_selected=="") {
  //     addToast("Max Occupancy field is required!","orange");
  //     $("#occupancy").focus();
  //   } else if (no_of_rooms=="") {
  //     addToast("No of room's field is required!","orange");
  //     $("#no_of_rooms").focus();
  //   } else {
  //     if (occupancy_child_selected!="") {
  //       var child_occupancy = occupancy_child_selected;
  //     } else {
  //       var child_occupancy = "0";
  //     }
  //     $(".dataTables_empty").hide();
  //     add_value_in_table(room_type_select_val,room_type_select_text,price,room_facilties,occupancy_selected,occupancy_selected_text,child_occupancy,no_of_rooms,room_name);
  //     clear_value_from_form();
  //   }
  // });
  // $("#hotel_tab_3").click(function() {
  //   var room_type_val = $("#room_type_val").val();
  //     if (room_type_val==undefined) {
  //       addToast("Must add room type","orange");
  //     } else if (room_type_val=="") {
  //       addToast("Must add room type","orange");
  //     } else {
  //       $("#menu3").addClass("in active")
  //       $("#menu2").removeClass("in active")
  //       $("#menu1").removeClass("in active")
  //       $("#home").removeClass("in active")
  //       $(".menu3").addClass("active")
  //       $(".menu2").removeClass("active")
  //       $(".menu1").removeClass("active")
  //       $(".home").removeClass("active")
  //     }
  // });
  // $("#hotel_tab_3_prev").click(function() {
  //   $("#menu1").addClass("in active")
  //   $("#menu3").removeClass("in active")
  //   $("#menu2").removeClass("in active")
  //   $("#home").removeClass("in active")
  //   $(".menu1").addClass("active")
  //   $(".menu3").removeClass("active")
  //   $(".menu2").removeClass("active")
  //   $(".home").removeClass("active")
  // });
  $("#hotel_tab_4").click(function() {
    //var multiple_image = $("#multiple_image").val();
    var img1 = $("#img1").val();
    var img2 = $("#img2").val();
    var img3 = $("#img3").val();
    var img4 = $("#img4").val();
    var img5 = $("#img5").val();
    if (gallery_edit_image!="") {
      $("#menu4").addClass("in active")
      $("#menu3").removeClass("in active")
      $("#menu2").removeClass("in active")
      $("#menu1").removeClass("in active")
      $("#home").removeClass("in active")
      $(".menu4").addClass("active")
      $(".menu3").removeClass("active")
      $(".menu2").removeClass("active")
      $(".menu1").removeClass("active")
      $(".home").removeClass("active")
    } else {
      // if (multiple_image=="") {
      //   addToast("Gallery images field is required!","orange");
      // if( img1==""){

      //   addToast("Gallery images field is required!","orange");
      // } else {
        $("#menu4").addClass("in active")
        $("#menu3").removeClass("in active")
        $("#menu2").removeClass("in active")
        $("#menu1").removeClass("in active")
        $("#home").removeClass("in active")
        $(".menu4").addClass("active")
        $(".menu3").removeClass("active")
        $(".menu2").removeClass("active")
        $(".menu1").removeClass("active")
        $(".home").removeClass("active")
      //}
    }
  });
  $("#hotel_tab_4_prev").click(function() {
    $("#menu1").addClass("in active")
    $("#menu4").removeClass("in active")
    $("#menu3").removeClass("in active")
    $("#home").removeClass("in active")
    $(".menu1").addClass("active")
    $(".menu4").removeClass("active")
    $(".menu3").removeClass("active")
    $(".home").removeClass("active")
  });
  $("#hotel_tab_5").click(function() {
      $("#menu5").addClass("in active")
      $("#menu4").removeClass("in active")
      $("#menu3").removeClass("in active")
      $("#menu2").removeClass("in active")
      $("#menu1").removeClass("in active")
      $("#home").removeClass("in active")
      $(".menu5").addClass("active")
      $(".menu4").removeClass("active")
      $(".menu3").removeClass("active")
      $(".menu2").removeClass("active")
      $(".menu1").removeClass("active")
      $(".home").removeClass("active")
  });
  $("#hotel_tab_5_prev").click(function() {
    $("#menu3").addClass("in active")
    $("#menu5").removeClass("in active")
    $("#menu4").removeClass("in active")
    $("#menu2").removeClass("in active")
    $("#menu1").removeClass("in active")
    $("#home").removeClass("in active")
    $(".menu3").addClass("active")
    $(".menu5").removeClass("active")
    $(".menu4").removeClass("active")
    $(".menu2").removeClass("active")
    $(".menu1").removeClass("active")
    $(".home").removeClass("active")
  });

  $("#check1").click(function(){
    if($(this).is(':checked')){     
    var sales_fname = $(".sales_fname").val();
    var sales_lname = $(".sales_lname").val();
    var sales_phone = $(".sales_phone").val();
    var sales_mobile = $(".sales_mobile").val();
    var sales_mail = $(".sales_mail").val();
    var sales_address = $(".sales_address").val();
    var sales_password=$(".sales_password").val();
    $(".revenue_fname").val(sales_fname);
    $(".revenue_lname").val(sales_lname);
    $(".revenue_mail").val(sales_mail);
    $(".revenue_phone").val(sales_phone);
    $(".revenue_mobile").val(sales_mobile);
    $(".revenue_address").val(sales_address);
    $(".revenue_password").val(sales_password);
    // document.getElementById("revenue_address").value("sales_address");
    }
  });
  $("#check2").click(function(){
    if($(this).is(':checked')){
    var revenue_fname = $(".revenue_fname").val();
    var revenue_lname = $(".revenue_lname").val();
    var revenue_mail = $(".revenue_mail").val();
    var revenue_phone = $(".revenue_phone").val();
    var revenue_mobile = $(".revenue_mobile").val();
    var revenue_address = $(".revenue_address").val();
    var revenue_password = $(".revenue_password").val();
    $(".contract_fname").val(revenue_fname);
    $(".contract_lname").val(revenue_lname);
    $(".contract_mail").val(revenue_mail);
    $(".contract_phone").val(revenue_phone);
    $(".contract_mobile").val(revenue_mobile);
    $(".contracts_address").val(revenue_address);
    $(".contract_password").val(revenue_password);
    }
  });
  $("#check3").click(function(){
    if($(this).is(':checked')){
    var contract_fname = $(".contract_fname").val();
    var contract_lname = $(".contract_lname").val();
    var contract_mail = $(".contract_mail").val();
    var contract_phone = $(".contract_phone").val();
    var contract_mobile = $(".contract_mobile").val();
    var contracts_address = $(".contracts_address").val();
    var contract_password = $(".contract_password").val();
    $(".finance_fname").val(contract_fname);
    $(".finance_lname").val(contract_lname);
    $(".finance_mail").val(contract_mail);
    $(".finance_phone").val(contract_phone);
    $(".finance_mobile").val(contract_mobile);
    $(".finance_address").val(contracts_address);
    $(".finance_password").val(contract_password);
    }
  });

  $("#hotel_tab_6").click(function() {
    var sales_fname = $(".sales_fname").val();
    var sales_phone = $(".sales_phone").val();
    var sales_mobile = $(".sales_mobile").val();
    var sales_mail = $(".sales_mail").val();
    var sales_address = $(".sales_address").val();
    var sales_password  = $(".sales_password").val();
    var revenue_fname = $(".revenue_fname").val();
    var revenue_mail = $(".revenue_mail").val();
    var revenue_phone = $(".revenue_phone").val();
    var revenue_mobile = $(".revenue_mobile").val();
    var revenue_address = $(".revenue_address").val();
    var contract_fname = $(".contract_fname").val();
    var contract_mail = $(".contract_mail").val();
    var contract_phone = $(".contract_phone").val();
    var contract_mobile = $(".contract_mobile").val();
    var contracts_address = $(".contracts_address").val();
    var finance_fname = $(".finance_fname").val();
    var finance_mail = $(".finance_mail").val();
    var finance_phone = $(".finance_phone").val();
    var finance_mobile = $(".finance_mobile").val();
    var finance_address = $(".finance_address").val();
    var finance_password = $(".finance_password").val();
    var revenue_password  = $(".revenue_password").val();
    var contract_password  = $(".contract_password").val();
      if (sales_fname=="") {
        addToast("Sales Team First name field is required!","orange");
        $("#sales_fname").focus();
      }  else if (sales_phone=="") {
        addToast("Sales Team Phone field is required!","orange");
        $("#sales_phone").focus();
      } else if (sales_mobile=="") {
        addToast("Sales Team Mobile field is required!","orange");
        $("#sales_mobile").focus();
      } else if (sales_mail=="") {
        addToast("Sales Team Email field is required!","orange");
        $("#sales_mail").focus();
      } else if (sales_address=="") {
        addToast("Sales Team Address field is required!","orange");
        $("#sales_address").focus();
      } else if (sales_password=="") {
        addToast("Sales Team Password field is required!","orange");
        $("#sales_password").focus();
      }else if (revenue_fname=="") {
        addToast("Revenue Team First name field is required!","orange");
        $("#revenue_fname").focus();
      }  else if (revenue_phone=="") {
        addToast("Revenue Team Phone field is required!","orange");
        $("#revenue_phone").focus();
      } else if (revenue_mobile=="") {
        addToast("Revenue Team Mobile field is required!","orange");
        $("#revenue_mobile").focus();
      } else if (revenue_mail=="") {
        addToast("Revenue Team Email field is required!","orange");
        $("#revenue_mail").focus();
      } else if (revenue_address=="") {
        addToast("Revenue Team Address field is required!","orange");
        $("#revenue_address").focus();
      } else if (contract_fname=="") {
        addToast("Reservation team First name field is required!","orange");
        $("#contract_fname").focus();
      }  else if (contract_phone=="") {
        addToast("Reservation team Phone field is required!","orange");
        $("#contract_phone").focus();
      } else if (contract_mobile=="") {
        addToast("Reservation team Mobile field is required!","orange");
        $("#contract_mobile").focus();
      } else if (contract_mail=="") {
        addToast("Reservation team Email field is required!","orange");
        $("#contract_mail").focus();
      } else if (contracts_address=="") {
        addToast("Reservation team Address field is required!","orange");
        $("#contracts_address").focus();
      } else if (finance_fname=="") {
        addToast("Finance Team First name field is required!","orange");
        $("#finance_fname").focus();
      } else if (finance_phone=="") {
        addToast("Finance Team Phone field is required!","orange");
        $("#finance_phone").focus();
      } else if (finance_mobile=="") {
        addToast("Finance Team Mobile field is required!","orange");
        $("#finance_mobile").focus();
      } else if (finance_mail=="") {
        addToast("Finance Team Email field is required!","orange");
        $("#finance_mail").focus();
      } else if (finance_address=="") {
        addToast("Finance Team Address field is required!","orange");
        $("#finance_address").focus();
      }else if (revenue_password=="") {
        addToast("Revenue Team Password field is required!","orange");
        $("#revenue_password").focus();
      }else if (contract_password=="") {
        addToast("Reservation Team Password field is required!","orange");
        $("#contract_password").focus();
      }else if (finance_password=="") {
        addToast("Finance Team Password field is required!","orange");
        $("#finance_password").focus();
      }

      else {
        
        $("#new_hotel_form").submit();
      }
  });
  $("#hotel_tab_6_prev").click(function() {
    $("#menu4").addClass("in active")
    $("#menu6").removeClass("in active")
    $("#menu5").removeClass("in active")
    $("#menu3").removeClass("in active")
    $("#menu2").removeClass("in active")
    $("#menu1").removeClass("in active")
    $("#home").removeClass("in active")
    $(".menu4").addClass("active")
    $(".menu5").removeClass("active")
    $(".menu5").removeClass("active")
    $(".menu3").removeClass("active")
    $(".menu2").removeClass("active")
    $(".menu1").removeClass("active")
    $(".home").removeClass("active")
  });
  $("#hotel_tab_7").click(function() {
    var contract_type = $("#contract_type").val();
    var classification = $("#classification").val();
    var application = $("#application").val();
    var max_child_age = $("#max_child_age").val();
    var rate_type = $("#rate_type").val();
    var tax_percentage = $("#tax_percentage").val();
    var markup = $("#markup").val();
    var credit_limit = $("#credit_limit").val();
    var credit_period = $("#credit_period").val();
    var pay_mode = $("#pay_mode").val();
    var hotel_admin_name = $("#hotel_admin_name").val();
    var hotel_admin_email = $("#hotel_admin_email").val();
    var filter        = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (contract_type=="") {
      addToast("Contract type field is required!","orange");
      $("#contract_type").focus();
    } else if (classification=="") {
      addToast("Classification field is required!","orange");
      $("#classification").focus();
    } else if (application=="") {
      addToast("Application field is required!","orange");
      $("#application").focus();
    } else if (max_child_age=="") {
      addToast("Max child age field is required!","orange");
      $("#max_child_age").focus();
    } else if (rate_type=="") {
      addToast("Rate type field is required!","orange");
      $("#rate_type").focus();
    } else if (tax_percentage=="") {
      addToast("Tax percentage field is required!","orange");
      $("#tax_percentage").focus();
    } else if (markup=="") {
      addToast("Markup field is required!","orange");
      $("#markup").focus();
    } else if (credit_limit=="") {
      addToast("Credit limit field is required!","orange");
      $("#credit_limit").focus();
    } else if (credit_period=="") {
      addToast("Credit period field is required!","orange");
      $("#credit_period").focus();
    } else if (pay_mode=="") {
      addToast("Pay mode field is required!","orange");
      $("#pay_mode").focus();
    }  else if (hotel_admin_name=="") {
      addToast("Hotel admin name field is required!","orange");
      $("#hotel_admin_name").focus();
    } else if (hotel_admin_email=="") {
      addToast("Hotel admin email field is required!","orange");
      $("#hotel_admin_email").focus();
    } else if(!filter.test(hotel_admin_email)) {
      addToast("Invalid email address","orange");
      $("#hotel_admin_email").focus();
    } else {
      $("#menu7").addClass("in active")
      $("#menu4").removeClass("in active")
      $("#menu6").removeClass("in active")
      $("#menu5").removeClass("in active")
      $("#menu3").removeClass("in active")
      $("#menu2").removeClass("in active")
      $("#menu1").removeClass("in active")
      $("#home").removeClass("in active")
      $(".menu7").addClass("active")
      $(".menu4").removeClass("active")
      $(".menu6").removeClass("active")
      $(".menu5").removeClass("active")
      $(".menu3").removeClass("active")
      $(".menu2").removeClass("active")
      $(".menu1").removeClass("active")
      $(".home").removeClass("active")
    }
  });
  $("#hotel_tab_8").click(function() {
    var imp_remarks = $(".imp_remarks .trumbowyg-editor").html();
    var cancel_policy = $(".cancel_policy .trumbowyg-editor").html();
    var imp_notes = $(".imp_notes .trumbowyg-editor").html();
    if (imp_remarks=="") {
        addToast("Important Remarks & Policies field is required!","orange");
    } else if (cancel_policy=="") {
        addToast("Cancellation Policy field is required!","orange");
    } else if (imp_notes=="") {
        addToast("Important Notes & Conditions field is required!","orange");
    } else {
        $("#imp_remarks").val(imp_remarks);
        $("#cancel_policy").val(cancel_policy);
        $("#imp_notes").val(imp_notes);
        $("#new_hotel_form").submit();
    }
  });
  $("#hotel_tab_7_prev").click(function() {
    $("#menu5").addClass("in active")
    $("#menu4").removeClass("in active")
    $("#menu6").removeClass("in active")
    $("#menu3").removeClass("in active")
    $("#menu2").removeClass("in active")
    $("#menu1").removeClass("in active")
    $("#home").removeClass("in active")
    $(".menu5").addClass("active")
    $(".menu6").removeClass("active")
    $(".menu4").removeClass("active")
    $(".menu3").removeClass("active")
    $(".menu2").removeClass("active")
    $(".menu1").removeClass("active")
    $(".home").removeClass("active")
  });
  // $(".close_edit_modal").click(function() {
  //   clear_value_from_modal();
  // });
  $("#hotel_tab_8_prev").click(function() {
    $("#menu6").addClass("in active")
    $("#menu7").removeClass("in active")
    $("#menu5").removeClass("in active")
    $("#menu4").removeClass("in active")
    $("#menu3").removeClass("in active")
    $("#menu2").removeClass("in active")
    $("#menu1").removeClass("in active")
    $("#home").removeClass("in active")
    $(".menu6").addClass("active")
    $(".menu7").removeClass("active")
    $(".menu5").removeClass("active")
    $(".menu4").removeClass("active")
    $(".menu3").removeClass("active")
    $(".menu2").removeClass("active")
    $(".menu1").removeClass("active")
    $(".home").removeClass("active")
  });
  $('#room_minimum_stay_update').click(function () { 
    var from1 = $("#from1").val();
    var from2 = $("#from2").val();
    var from3 = $("#from3").val();
    var from4 = $("#from4").val();
    var from5 = $("#from5").val();
    var from6 = $("#from6").val();
    var to1   = $("#to1").val();
    var to2   = $("#to2").val();
    var to3   = $("#to3").val();
    var to4   = $("#to4").val();
    var to5   = $("#to5").val();
    var to6   = $("#to6").val();
    var close_from1   = $("#close_from1").val();
    var close_from2   = $("#close_from2").val();
    var close_from3   = $("#close_from3").val();
    var close_from4   = $("#close_from4").val();
    var close_from5   = $("#close_from5").val();
    var close_from6   = $("#close_from6").val();
    var close_to1  = $("#close_to1").val();
    var close_to2   = $("#close_to2").val();
    var close_to3  = $("#close_to3").val();
    var close_to4   = $("#close_to4").val();
    var close_to5  = $("#close_to5").val();
    var close_to6   = $("#close_to6").val();
  if(from1!="" && to1=="")
    {
      addToast('event1 To Date field is required!',"orange");
      $("#to1").focus();
    } 
    else if(to1!="" && from1=="") 
    {
      addToast('event1 From Date field is required!',"orange");
      $("#from1").focus();
    }
    else if(from2!="" && to2=="")
    {
      addToast('event2 To Date field is required!',"orange");
      $("#to2").focus();
    } 
    else if (to2!="" && from2=="") 
    {
      addToast('event2 From Date field is required!',"orange");
      $("#from2").focus();
    }
   else if(from3!="" && to3=="")
    {
      addToast('event3 To Date field is required!',"orange");
      $("#to3").focus();
    } 
    else if(to3!="" && from3=="") 
    {
      addToast('event3 From Date field is required!',"orange");
      $("#from3").focus();
    }
     else if(from4!="" && to4=="")
    {
      addToast('event4 To Date field is required!',"orange");
      $("#to4").focus();
    } 
    else if(to4!="" && from4=="") 
    {
      addToast('event4 From Date field is required!',"orange");
      $("#from4").focus();
    }
    else if(from5!="" && to5=="")
    {
      addToast('event5 To Date field is required!',"orange");
      $("#to5").focus();
    } 
    else if(to5!="" && from5=="") 
    {
      addToast('event5 From Date field is required!',"orange");
      $("#from5").focus();
    }
    else if(from6!="" && to6=="")
    {
      addToast('event6 To Date field is required!',"orange");
      $("#to6").focus();
    } 
    else if(to6!="" && from6=="") 
    {
      addToast('event6 From Date field is required!',"orange");
      $("#from6").focus();
    }
    else if(close_from1!="" && close_to1=="")
    {
      addToast('Close Period event1 To Date field is required!',"orange");
      $("#close_to1").focus();
    } 
    else if(close_to1!="" && close_from1=="") 
    {
      addToast('Close Period event1 From Date field is required!',"orange");
      $("#close_from1").focus();
    }
    else if(close_from2!="" && close_to2=="")
    {
      addToast('Close Period event2 To Date field is required!',"orange");
      $("#close_to2").focus();
    } 
    else if(close_to2!="" && close_from2=="") 
    {
      addToast('Close Period event2 From Date field is required!',"orange");
      $("#close_from2").focus();
    }
    else if(close_from3!="" && close_to3=="")
    {
      addToast('Close Period event3 To Date field is required!',"orange");
      $("#close_to3").focus();
    } 
    else if(close_to3!="" && close_from3=="") 
    {
      addToast('Close Period event3 From Date field is required!',"orange");
      $("#close_from3").focus();
    }
    else if(close_from4!="" && close_to4=="")
    {
      addToast('Close Period event4 To Date field is required!',"orange");
      $("#close_to4").focus();
    } 
    else if(close_to4!="" && close_from4=="") 
    {
      addToast('Close Period event4 From Date field is required!',"orange");
      $("#close_from4").focus();
    }
    else if(close_from5!="" && close_to5=="")
    {
      addToast('Close Period event5 To Date field is required!',"orange");
      $("#close_to5").focus();
    } 
    else if(close_to5!="" && close_from5=="") 
    {
      addToast('Close Period event5 From Date field is required!',"orange");
      $("#close_from5").focus();
    }
    else if(close_from6!="" && close_to6=="")
    {
      addToast('Close Period event6 To Date field is required!',"orange");
      $("#close_to6").focus();
    } 
    else if(close_to6!="" && close_from6=="") 
    {
      addToast('Close Period event6 From Date field is required!',"orange");
      $("#close_from6").focus();
    }
    else
      {
      $("#hotel_minimum_stay_form").submit();
     }
 });
  
  $('#change_password').click(function() {
   var password =  $('#password').val();
   var hotel_id =  $('#hotel_id').val();
   if (password=="") {
      addToast('Password field is required!',"orange");
      $("#password").focus();
   } else {
      $.ajax({
        dataType: 'json',
        type: 'post',
        url: base_url+'/backend/hotels/password_update?hotel_id='+hotel_id+'&&password='+password,
        cache: false,
        success: function (response) {
          if (response==true) {
            addToast('Password Updated Successfully',"green");
            $(".close").trigger("click");
          } else {
            addToast('Password Updated Failed',"red");
          }
        },
         error: function (xhr,status,error) {
           alert("Error: " + error);
        }
      });
   }
  });
  $('#checkedit').click(function(){
      this.value = this.checked ? 1 : 0;
      var hotel_id =  $('#hotels_edit_id').val();
      $.ajax({
          dataType: 'json',
          type: 'post',
          url: base_url+'/backend/hotels/menu_checkbox_modal_on?val='+this.value+'&&hotel_id='+hotel_id,
          data: $('#menu_form').serialize(),
          cache: false,
          success: function (response) {

          addToast(' Updated Successfully',"green");
                  
          }
        
      });
}).change();

  $('#checksales').click(function(){
      this.value = this.checked ? 1 : 0;
      var hotel_id =  $('#hotel_id').val();
      var ConId    =  $('#contract_id').val();
      $.ajax({
          dataType: 'json',
          type: 'post',
          url: base_url+'/backend/hotels/SalePermission?val3='+this.value+'&&hotel_id='+hotel_id+'&&ConId='+ConId,
          data: $('#menu_form').serialize(),
          cache: false,
          success: function (response) {
          addToast(' Updated Successfully',"green");
                  
          }
        
      });
    //alert(base_url+'/backend/hotels/menu_checkbox_modal_on?val2='+this.value+'&&hotel_id='+hotel_id,)
   
}).change();

  $('#checkrate').click(function(){
      this.value = this.checked ? 1 : 0;
      var hotel_id =  $('#hotel_id').val();
      var ConId    =  $('#contract_id').val();
      $.ajax({
          dataType: 'json',
          type: 'post',
          url: base_url+'/backend/hotels/check_edit?val='+this.value+'&&hotel_id='+hotel_id+'&&ConId='+ConId,
          data: $('#menu_form').serialize(),
          cache: false,
          success: function (response) {
          addToast(' Updated Successfully',"green");
          }
      });
}).change();

  $("#policy_click").click(function() {
    var hotel_id = $("#hotel_id").val();
    var imp_remarks = $(".imp_remarks .trumbowyg-editor").html();
    //var cancel_policy = $(".cancel_policy .trumbowyg-editor").html();
    var imp_notes = $(".imp_notes .trumbowyg-editor").html();
    if (imp_remarks=="") {
        addToast("Important Remarks & Policies field is required!","orange");
    // } else if (cancel_policy=="") {
    //     addToast("Cancellation Policy field is required!","orange");
    } else if (imp_notes=="") {
        addToast("Important Notes & Conditions field is required!","orange");
    } else {
        $("#imp_remarks").val(imp_remarks);
        //$("#cancel_policy").val(cancel_policy);
        $("#imp_notes").val(imp_notes);
        $.ajax({
        dataType: 'json',
        type: 'post',
        url: base_url+'/backend/hotels/policiesSubmit',
        data: $('#contract-policy-form').serialize(),
        cache: false,
        success: function (response) {
          addToast("Inserted Successfully","green");
          // window.location.href = base_url+"backend/hotels/contract_menu";
          setTimeout(function(){ window.location = base_url+"backend/hotels/contract_menu?hotel_id="+hotel_id; }, 2000); 
        }
      });

        // $("#contract-policy-form").attr("action",base_url+"backend/hotels/policiesSubmit");
        // $("#contract-policy-form").submit();
    }
  });
  $("#update_agent_permission").click(function() {
      $("#agent_permission_form").attr("action",base_url+"backend/hotels/agent_permission_update");
      $("#agent_permission_form").submit();
  });
  $("#update_country_permission").click(function() {
      $("#country_permission_form").attr("action",base_url+"backend/hotels/country_permission_update");
      $("#country_permission_form").submit();
  });
  $('#stopSaleadd_button').click(function (e){
    var hotel_id = hotel_stopSale.value;
    $("#stopSale_modal").load(base_url+'backend/hotels/stopSale_Modal?hotel_id='+hotel_id);
  });
  $("#stopsale_submit").click(function() {
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    if (from_date=="") {
      addToast("This field is required!","orange");
      $("#from_date").focus();
    } else if (to_date=="") {
      addToast("This field is required!","orange");
      $("#to_date").focus();
    } else {
      if ($("#id").val()!="") {
        addToast("Updated Successfully","green");
      } else {
        addToast("Inserted Successfully","green");
      }
      $("#add_stopSale").attr("action",base_url+"backend/hotels/stopsaleSubmit");
      $("#add_stopSale").submit();
    }
  });
  $('#hotel_stopSale').change(function () {
      var sText = $("#hotel_stopSale").find("option:selected").text();
      var sValue = hotel_stopSale.value;
      $('#hotel_id').val(sValue);
       var contract_table = $('#stopSale_table').dataTable({
          "bDestroy": true,
          "ajax": {
              url : base_url+'/backend/hotels/hotels_stopSale_list?id='+sValue,
              type : 'GET'
          },
      "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();          
      }

    });
  });

  /*Child policy start*/
  $("#childPolicy_button").click(function() {
  var contract_id = $("#contract_id").val();
    var hotel_id = $("#hotel_id").val();
    $("#childPolicy_modal").load(base_url+'backend/hotels/childPolicy_Modal?hotel_id='+hotel_id+'&contract_id='+contract_id);
  }); 

  $("#childPolicy_submit").off().click(function() {
    var age_from = $("#age_from").val();
    var age_to = $("#age_to").val();
    var room_type = $("#room_type").val();
    var board = $("#board").val();  
    if (age_from=="") {
      addToast("Age From field is required!","orange");
      $("#age_from").focus();
    } else if (age_to=="") {
      addToast("Age To field is required!","orange");
      $("#age_to").focus();
    } else if (Number(age_from) >= Number(age_to)) {
      addToast("Age To should be greater than age from !","orange");
      $("#age_to").focus();
    } else if (room_type=="") {
      addToast("Room type field is required!","orange");
      $("#room_type").focus();
    } else if (board=="") {
      addToast("Board field is required!","orange");
      $("#board").focus();
    } else {
        $("#childPolicy_submit").attr("disabled","disabled");
      $.ajax({
        dataType: 'json',
        type: 'post',
        url: base_url+'/backend/hotels/childPolicySubmit',
        data:$("#add_childPolicy").serialize(),
        cache: false,
        success: function (response) {
          if (response!=true) {
            $("#childPolicy_submit").removeAttr("disabled");
          } else {
            $(".close").trigger("click");
            if ($("#id").val()!="") {
              addToast("Updated Successfully","green");
            } else {
              addToast("Inserted Successfully","green");
            }
            var hotel_id = $("#hotel_id").val();
            var contract_id = $("#contract_id").val();
            var childPolicy_table = $('#childPolicy_table').dataTable({
                  "bDestroy": true,
                  "ajax": {
                      url : base_url+'/backend/hotels/childPolicy_list?id='+hotel_id+'&con_id='+contract_id,
                      type : 'GET'
                  },
              "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
              }

            });
          }
          
        }
      });
    }
  });
  /*Child policy end*/
  
  /*Season start*/
 
  $("#season_modal_btn").click(function() {
    var hotel_id = $("#hotel_id").val();
    var contract_id  = $("#contract_id").val(); 
     $("#season_modal").load(base_url+'backend/hotels/season_modal?hotel_id='+hotel_id+'&contract_id='+contract_id);
  });

  $("#SeasonSubmit").off().click(function() {
    var SeasonName = $("#SeasonName").val();
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    if(SeasonName=="") {
      addToast("Season Name field is required!","orange");
      $("#SeasonName").focus();
    } else if (fromDate=="") {
      addToast("From Date field is required!","orange");
      $("#fromDate").focus();
    } else if (toDate=="") {
      addToast("To Date field is required!","orange");
      $("#toDate").focus();
    } else {
      $.ajax({
        dataType: 'json',
        type: 'post',
        url: base_url+'/backend/hotels/SeasonSubmit',
        data: $('#Season_form').serialize(),
        cache: false,
        success: function (response) {
          if (response==true) {
             $(".close").trigger("click");
                if ($("#season_id").val()!="") {
                  addToast("Updated Successfully","green");
                } else {
                  addToast("Inserted Successfully","green");
                }
                var seasonhotel_id = $("#hotel_id").val();
                var seasoncontract_id = $("#contract_id").val();
                var season_table = $('#season_table').dataTable({
                      "bDestroy": true,
                      "ajax": {
                          url : base_url+'/backend/hotels/seasonList?hotel_id='+seasonhotel_id+'&contract_id='+seasoncontract_id,
                          type : 'GET'
                      },
                    "fnDrawCallback": function(settings){
                    $('[data-toggle="tooltip"]').tooltip();          
                    }
                  });
          } else {
            alert(response);
          }
        }
      });
      // $("#Season_form").attr("action",base_url+"backend/hotels/SeasonSubmit");
      // $("#Season_form").submit();
    }
  });
  /*Season end*/
  /*BoardSupplement start*/

  $("#BoardSupplement_button").click(function() {
    var hotel_id = $("#hotel_id").val();
    var contract_id = $("#contract_id").val();
     $("#childPolicy_modal").load(base_url+'backend/hotels/BoardSupplement_modal?hotel_id='+hotel_id+'&contract_id='+contract_id);
  });
  $("#discountUpdate").click(function() {
            var hotel = $("#hoteltext").val();
            var con   = $("#context").val();
            var room  = $("#roomtext").val();
            var from  = $("#from_date").val();
            var to    = $("#to_date").val();
            var styfrm= $("#stay1").val();
            var styto = $("#stay2").val(); 
            var minimum_stay = $("#minimum_stay").val();
            var stay_night = $("#stay_night").val();
            var pay_night = $("#pay_night").val();
            var BkBef = $("#bookBefore").val();
            var dis   = $("#discount").val();
            var discount_type = $('#discount_type').val();
            if (hotel=="") {
              addToast(" Hotel field is required !","orange");
              $("#hotel_undo_redo_to").focus();
            } else if (con=="") {
              addToast("Contract field is required !","orange");
              $("#contract_undo_redo").focus();
            // } else if ((from=="" && to=="") || BkBef=="") {
            //   addToast("Valid field is required !","orange");
            // } else if (to=="") {
            //   addToast("Valid Untill field is required !","orange");
            //   $("#to_date").focus();
            } else if (styfrm=="") {
              addToast("Stay From field is required !","orange");
              $("#stay1").focus();
            } else if (styto=="") {
              addToast("Stay till field is required !","orange");
              $("#stay2").focus();
            // } else if (BkBef=="") {
            //   addToast("Valid Before  field is required !","orange");
            //   $("#bookBefore").focus();
            } else if (dis=="" && discount_type=="") {
              addToast("Discount field is required !","orange");
              $("#discount").focus();
            } else {
              addToast('Discount Updated successfully',"green");
              $("#disForm").attr('action',base_url+'backend/Hotels/add_new_discount');
              $("#disForm").submit();
            }
    });

  $("#boardSupplement_submit").off().click(function() {
    var board     = $("#board").val();
    var room_type = $("#room_type").val();
    var Season    = $("#season").val();
    var StartAge  = $("#StartAge").val();
    var FinalAge  = $("#FinalAge").val();
    var Amount    = $("#Amount").val();    
    var fromDate  = $("#fromDate").val();    
    var toDate  = $("#toDate").val();   
    if (board=="") {
      addToast("Board field is required !","orange");
      $("#board").focus();
    } else if (room_type=="" || room_type==null) {
      addToast("Room type field is required !","orange");
      $("#room_type").focus();
    } else if ($("#other_season").is(":checked")==true) {
      if (fromDate=="") {
        addToast("From Date field is required !","orange");
        $("#fromDate").focus();
      } else if (toDate=="") {
        addToast("To date field is required !","orange");
        $("#toDate").focus();
      } else if (StartAge=="") {
      addToast("Start Age field is required !","orange");
        $("#StartAge").focus();
      } else if(FinalAge=="") {
        addToast("Final Age field is required !","orange");
        $("#FinalAge").focus();
      } else if (Number(FinalAge) < Number(StartAge)) {
        addToast("Final Age should greater than Start age!","orange");
        $("#FinalAge").focus();
      } else if (Amount=="") {
        addToast("Amount field is required !","orange");
        $("#Amount").focus();
      } else {
      $("#boardSupplement_submit").attr("disabled","disabled");
        BoardSubmitfun();
      }
    } else if(Season=="" || Season==null) {
      addToast("Season field is required !","orange");
      $("#season").focus();
    } else if (StartAge=="") {
      addToast("Start Age field is required !","orange");
      $("#StartAge").focus();
    } else if(FinalAge=="") {
      addToast("Final Age field is required !","orange");
      $("#FinalAge").focus();
    } else if (Number(FinalAge) < Number(StartAge)) {
        addToast("Final Age should greater than Start age!","orange");
        $("#FinalAge").focus();
    } else if (Amount=="") {
      addToast("Amount field is required !","orange");
      $("#Amount").focus();
    } else {
      $("#boardSupplement_submit").attr("disabled","disabled");
      BoardSubmitfun();
    }
  });
  board_contract_id = $('#contract_id').val();
  board_hotel_id = $('#hotel_id').val();
  var BoardSupplement_table = $('#BoardSupplement_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/BoardSupplementList?hotel_id='+board_hotel_id+'&contract_id='+board_contract_id,
            type : 'GET'
        },
      "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();          
      }
    });
    
    var filter = $("#filter").val();

    var discountTable = $("#discountTable").dataTable({

        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/Hotels/DiscountoffList?filter='+filter,
            type : 'POST'

        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
  /*BoardSupplement end*/
  /*GeneralSupplement end*/

  $("#GeneralSupplement_button").click(function() {
    var hotel_id = $("#hotel_id").val();
    var contract_id = $("#contract_id").val();
     $("#childPolicy_modal").load(base_url+'backend/hotels/GeneralSupplement_modal?hotel_id='+hotel_id+'&contract_id='+contract_id);
  });

  GeneralSupplement_contract_id = $('#contract_id').val();
  GeneralSupplement_hotel_id = $('#hotel_id').val();
  var GeneralSupplement_table = $('#GeneralSupplement_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/GeneralSupplementList?hotel_id='+GeneralSupplement_hotel_id+'&contract_id='+GeneralSupplement_contract_id,
            type : 'GET'
        },
      "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();          
      }
    });

  $("#generalSupplement_submit").off().click(function() {
    var type      =  $("#type").val();
    var room_type =  $("#room_type").val();
    var Season    =  $("#season").val();
    var fromDate  =  $("#fromDate").val();
    var toDate    =  $("#toDate").val();
    var adultAmount =  $("#adultAmount").val();
    var childAmount =  $("#childAmount").val();
    var MinChildAge =  $("#MinChildAge").val();
    if (type=="") {
      addToast("Type field is required !","orange");
      $("#type").focus();
    } else if (room_type=="" || room_type==null) {
      addToast("Room type field is required !","orange");
      $("#room_type").focus();
    } else if ($("#other_season").is(":checked")==true) {
      if (fromDate=="") {
        addToast("From date field is required !","orange");
        $("#fromDate").focus();
      } else if (toDate=="") {
        addToast("To date field is required !","orange");
        $("#toDate").focus();
      } else if(MinChildAge=="") {
         addToast("Min Child Age field is required !","orange");
        $("#MinChildAge").focus();
      } else if (adultAmount=="") {
        addToast("Adult amount field is required !","orange");
        $("#adultAmount").focus();
      } else if (childAmount=="") {
        addToast("Child amount field is required !","orange");
        $("#childAmount").focus();
      } else {
        $("#generalSupplement_submit").attr("disabled","disabled");
        GeneralSupplementSubmitfun();
      }

    } else if (Season=="" || Season==null) {
      addToast("Season field is required !","orange");
      $("#season").focus();
    } else if(MinChildAge=="") {
         addToast("Min Child Age field is required !","orange");
        $("#MinChildAge").focus();
    }  else if (adultAmount=="") {
      addToast("Adult amount field is required !","orange");
      $("#adultAmount").focus();
    } else if (childAmount=="") {
      addToast("Child amount field is required !","orange");
      $("#childAmount").focus();
    } else {
      $("#generalSupplement_submit").attr("disabled","disabled");
      GeneralSupplementSubmitfun();
    }
    
  });

  // $("#hotel_undo_redo_to").change(function(){
  // var optionValues = [];

  //   $('#hotel_undo_redo_to option').each(function() {
  //         optionValues.push($(this).val());
  //     });
  //   alert(optionValues)
  //   $('#result').html(optionValues);
  // });
  /*GeneralSupplement end*/
  /*Cancellation fee start*/
    $("#Discount").click(function() {
      $("#DisModal").load(base_url+'backend/Sight_Seeing/newoffers');
    });
    $("#CancellationFee_button").click(function() {
      var hotel_id = $("#hotel_id").val();
      var contract_id = $("#contract_id").val();
      $("#childPolicy_modal").load(base_url+'backend/hotels/CancellationFee_modal?hotel_id='+hotel_id+'&contract_id='+contract_id);
    });

    $("#CancelationFee_submit").off().click(function() {
      var Season= $("#Season").val();
      var fromDate= $("#fromDate").val();
      var toDate= $("#toDate").val();
      var room_type= $("#room_type").val();
      // var daysInAdvance= $("#daysInAdvance").val();
      var daysFrom= $("#daysFrom").val();
      var daysTo= $("#daysTo").val();
      var CancellationPercentage= $("#CancellationPercentage").val();
      var other_season  = $("#other_season").val();
      if ($("#other_season").is(":checked")==true) {
        if (fromDate=="") {
          addToast("From date field is required !","orange");
          $("#fromDate").focus();
        } else if (toDate=="") {
          addToast("To date field is required !","orange");
          $("#toDate").focus();
        } else if (room_type=="" || room_type==null) {
          addToast("Room type field is required !","orange");
          $("#room_type").focus();
        // } else if (daysInAdvance=="") {
        //   addToast("Days in advance field is required !","orange");
        //   $("#daysInAdvance").focus();
        } else if (daysFrom=="") {
          addToast("Days from field is required !","orange");
          $("#daysFrom").focus();
        } else if (daysTo=="") {
          addToast("Days to field is required !","orange");
          $("#daysTo").focus();
        } else if (CancellationPercentage=="") {
          addToast("Cancellation % field is required !","orange");
          $("#CancellationPercentage").focus();
        } else {
        $("#CancelationFee_submit").attr("disabled","disabled");
          CancelationFeeSubmitfun();
        }
      } else if (Season=="" || Season==null) {
        addToast("Season field is required !","orange");
        $("#Season").focus();
      } else  if (room_type=="" || room_type==null) {
        addToast("Room type field is required !","orange");
        $("#room_type").focus();
      // } else if (daysInAdvance=="") {
      //   addToast("Days in advance field is required !","orange");
      //   $("#daysInAdvance").focus();
      } else if (daysFrom=="") {
        addToast("Days from field is required !","orange");
        $("#daysFrom").focus();
      } else if (daysTo=="") {
        addToast("Days to field is required !","orange");
        $("#daysTo").focus();
      } else if (CancellationPercentage=="") {
        addToast("Cancellation % field is required !","orange");
        $("#CancellationPercentage").focus();
      } else {
      $("#CancelationFee_submit").attr("disabled","disabled");
        CancelationFeeSubmitfun();
      }
    });

    

  /*Cancellation fee end*/
  /*Minimum stay start*/
  $("#MinimumStay_button").click(function() {
    var hotel_id = $("#hotel_id").val();
    var contract_id = $("#contract_id").val();
    $("#childPolicy_modal").load(base_url+'backend/hotels/MinimumStay_modal?hotel_id='+hotel_id+'&contract_id='+contract_id);
  });

  MinimumStay_contract_id = $('#contract_id').val();
  MinimumStay_hotel_id = $('#hotel_id').val();
  var MinimumStay_table = $('#MinimumStay_table').dataTable({
          "bDestroy": true,
          "ajax": {
              url : base_url+'/backend/hotels/MinimumStayList?hotel_id='+MinimumStay_hotel_id+'&contract_id='+MinimumStay_contract_id,
              type : 'GET'
          },
        "fnDrawCallback": function(settings){
        $('[data-toggle="tooltip"]').tooltip();          
        }
    });

  $("#MinimumStay_submit").off().click(function() {
    var Season= $("#season").val();
    var fromDate= $("#fromDate").val();
    var toDate= $("#toDate").val();
    var minDay= $("#minDay").val();
    var Otherseason =  $("#other_season").is(":checked"); 
    if (Otherseason==true) {
      if (fromDate=="") {
        addToast("From date field is required !","orange");
        $("#fromDate").focus();
      } else if (toDate=="") {
        addToast("To date field is required !","orange");
        $("#toDate").focus();
      } else if (minDay=="") {
        addToast("Day field is required !","orange");
        $("#minDay").focus();
      } else {
        $("#MinimumStay_submit").attr("disabled","disabled");
        MinimumStaySubmitfun();
      }
    } else {
      if(Season=="" || Season==null) { 
        addToast("Season field is required !","orange");
        $("#Season").focus();
      } else if (minDay=="") {
        addToast("Day field is required !","orange");
        $("#minDay").focus();
      } else {
        $("#MinimumStay_submit").attr("disabled","disabled");
        MinimumStaySubmitfun();
      }
    }
  });
  /*Minimum stay end*/
  /*Close out start*/
  var closeouthotel_id = $("#hotel_id").val();
  var closeoutcontract_id = $("#contract_id").val();
  var hotel_closeout_table = $('#hotel_closeout_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/hotel_closeout_list?id='+closeouthotel_id+'&contract_id='+closeoutcontract_id,
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });

  $("#closeOutModal").click(function() {
     $("#childPolicy_modal").load(base_url+'backend/hotels/close_out_update?hotel_id='+closeouthotel_id+'&contract_id='+closeoutcontract_id);
  });

  $('#update_close_out').off().click(function (e) {
    var from_date_edit = $("#from_date_edit").val();
    var to_date_edit   = $("#to_date_edit").val();
    var room_type   = $("#room_type").val();
    
    if (from_date_edit=="") {
      addToast('From Date Is Required',"orange");
      $("#from_date_edit").focus();
    } else if (to_date_edit=="") {
      addToast('To Date Is Required',"orange");
      $("#to_date_edit").focus();
    } else  if (from_date_edit>to_date_edit){
      addToast('To Date Must be After From Date',"orange")
      $("#to_date_edit").focus();
    } else if(room_type=="" || room_type==null) {
      addToast('Room type field is required!',"orange")
      $("#room_type").focus();
    } else {
      $("#update_close_out").attr("disabled","disabled");
      closeoutSubmitfun();
    }     
  });
  $("#refCopyUpdate").click(function() {
    var conid= $("#contract_id").val();
        $.ajax({
          dataType: 'json',
          type: 'post',
          url: base_url+'/backend/hotels/RefreshCopyUpdate?conid='+conid,
          data: $('#refform').serialize(),
          cache: false,
          success: function (response) {
          addToast(' Updated Successfully',"green");
                  
          }
        
      });

    });
  
  /*Close out end*/
  /*Room aminities start*/
    var room_aminities_table = $('#room_aminities_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/roomAminitiesList',
            type : 'GET'
        },
      "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();          
      }
    });

    $("#AminitieSubmit").off().click(function() {
      var roomAminitie = $("#roomAminitie").val();
      if (roomAminitie=="") {
        addToast('Room Aminitie field is required!',"orange")
        $("#roomAminitie").focus();
      } else {
        $("#AminitieSubmit").attr("disabled","disabled");
        AminitieSubmitfun();
      }
    });
  /*Room aminities end*/

  $(".menu7").click(function() {
    CancellationPolicySelectfun();
  });


  /*Extra bed function start */
   $('#extrabed_modal_button').click(function (){
    var hotel_id = $("#hotel_id").val();
    var contract_id = $("#contract_id").val();
    $("#childPolicy_modal").load(base_url+'backend/hotels/extrabed_modal?hotel_id='+hotel_id+'&contract_id='+contract_id);
  });

    extrabed_contract_id = $('#contract_id').val();
    extrabed_hotel_id = $('#hotel_id').val();
    var extrabed_table = $('#extrabed_table').dataTable({
          "bDestroy": true,
          "ajax": {
              url : base_url+'/backend/hotels/extrabedList?hotel_id='+extrabed_hotel_id+'&con_id='+extrabed_contract_id,
              type : 'GET'
          },
        "fnDrawCallback": function(settings){
        $('[data-toggle="tooltip"]').tooltip();          
        }
    });

  /*Extra bed function end */
   $('#bulkUpdate').click(function (){
    var hotel_id = $("#hotel_id").val();
    var contract_id = $("#contract_id").val();
    var room_id = $("#room_id").val();
    $("#childPolicy_modal").load(base_url+'backend/hotels/bulkupdatemodal1?hotel_id='+hotel_id+'&contract_id='+contract_id+'&room_id='+room_id);
  });

  // datewise bulk update start
  
  $("#bulkUpdate1").click(function() {
    var hotel_id = $("#hotel_id").val();
    var contract_id = $("#contract_id").val();
    var room_id = $("#room_id").val();
    $("#datewise_modal").load(base_url+'backend/hotels/MultipleDateBulkModal?hotel_id='+hotel_id+'&contract_id='+contract_id+'&room_id='+room_id);
  });
  String.prototype.replaceAt=function(index, replacement) {
      return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
  }
  function clonebulUpdateRow() {
     let rowCount = $(".dw-tbody").find('tr').length;
     inputKey = '0'+rowCount;
     if(inputKey.length > 2) {
      inputKey = rowCount;
     } 
     let inputArray = $(".dw-tbody tr:last-child").find('input');
     $.each(inputArray,function(i,v){ 
      $(v).attr('name',$(v).attr('name').replaceAt($(v).attr('name').indexOf('[') + 1, (inputKey).toString()));
     })
     for (var i = 1; i <= rowCount; i++) {
        $(".dw-tbody").find('tr:nth-child('+ i +')').find('td:first-child').text(i);
        $(".dw-tbody").find('tr:nth-child('+ i +')').find('td:nth-child(2) input:first').removeAttr('class').addClass('FromDate'+i);
        $(".dw-tbody").find('tr:nth-child('+ i +')').find('td:nth-child(2) input:first').removeAttr('id');
        $(".dw-tbody").find('tr:nth-child('+ i +')').find('td:nth-child(3) input').removeAttr('id');
        $(".dw-tbody").find('tr:nth-child('+ i +')').find('td:nth-child(3) input').removeAttr('class').addClass('FromDate'+i);
        
        // var ISBN = [];
        // $(".dw-tbody").find('tr:nth-child('+ i +')').find('td:nth-child(5) .room_type option:selected').each(function() {
        //     ISBN.push($(this).val());                  
        // });
        // $(".dw-tbody").find('tr:nth-child('+ i +')').find("td:nth-child(5) .bulk-alt-room_id").val(ISBN.join(','));         

        $(".dw-tbody").find('tr:nth-child('+ i +')').find('.FromDate'+i).datepicker({
            dateFormat: "yy-mm-dd",
            altFormat: "dd/mm/yy",
            minDate: contract_start,
            maxDate: contract_end,
            changeYear : true,
            changeMonth : true,
        });
        $(".dw-tbody").find('tr:nth-child('+ i +')').find('.ToDate'+i).datepicker({
            dateFormat: "yy-mm-dd",
            altFormat: "dd/mm/yy",
            minDate: contract_start,
            maxDate: contract_end,
            changeYear : true,
            changeMonth : true,
        });

     }
  }

  

  $(".dw-tbody").on('click', '.copyClick', function() {
    $(this).closest('tr').clone().appendTo('.dw-tbody');
    // $(".dw-tbody").find('tr:last').find('td:nth-child(5) .room_type').multiselect({
    //     includeSelectAllOption: true,
    //     selectAllValue: 0,
    // });
    $(".dw-tbody").find('tr:last').find('td:nth-child(5) .btn-group:nth-child(3)').remove();
    clonebulUpdateRow();
  });

  $(".dw-tbody").on('click', '.addClick', function() {
    $(this).closest('tr').clone().appendTo('.dw-tbody');
    $(".dw-tbody").find('tr:last').find('td:nth-child(2) input:first-child').val("");
    $(".dw-tbody").find('tr:last').find('td:nth-child(2) input:last').removeAttr('checked');
    $(".dw-tbody").find('tr:last').find('td:nth-child(3) input').val("");
    $(".dw-tbody").find('tr:last').find('td:nth-child(4) input').val("");
    $(".dw-tbody").find('tr:last').find('td:nth-child(5) input').removeAttr('checked');
    $(".dw-tbody").find('tr:last').find('td:nth-child(5) .btn-group:nth-child(3)').remove();
    $(".dw-tbody").find('tr:last').find('td:nth-child(6) input').val("");
    $(".dw-tbody").find('tr:last').find('td:nth-child(7) input').val("");
    $(".dw-tbody").find('tr:last').find('td:nth-child(8) input').val("");
    clonebulUpdateRow();
  });

  $(".dw-tbody").on('click', '.removeClick', function() {
   $(this).parent().parent('tr').remove();
    clonebulUpdateRow();
  });
  $(".dw-tbody").on('click', '.select-All-Check' ,function() { 
    if (this.checked==true) {
      $(this).closest('tr').find('td:nth-child(5)').find('input').prop('checked',true);
    } else {
      $(this).closest('tr').find('td:nth-child(5)').find('input').prop('checked',false);
    }
  })

  $("#DW-bulk-allotement").click(function() {
    clonebulUpdateRow();
    let rowCount = $(".dw-tbody").find('tr').length;
    var FDT = [];
    var TDT = [];
    var SDT = [];
    var RDT = [];
    for (var i = 1; i <= rowCount; i++) {
      if ($(".dw-tbody").find('tr:nth-child('+ i +')').find('td:nth-child(2) input').val()=="") {
        FDT.push(1);
      }
      if ($(".dw-tbody").find('tr:nth-child('+ i +')').find('td:nth-child(3) input').val()=="") {
        TDT.push(1);
      }
      if ($(".dw-tbody").find('tr:nth-child('+ i +')').find('td:nth-child(4) input').val()=="") {
        SDT.push(1);
      }
      if ($(".dw-tbody").find('tr:nth-child('+ i +')').find('td:nth-child(5) input:checked').length==0) {
        RDT.push(1);
      }
    }
    if (FDT.length!=0) {
      addToast("Must fill all from date field","orange");
    } else if (TDT.length!=0) {
      addToast("Must fill all to date field","orange");
    } else if (SDT.length!=0) {
      addToast("Must fill all season field","orange");
    } else if (RDT.length!=0) {
      addToast("Must fill all room field","orange");
    } else {
      $("#DW-bulk-update-form").submit();
    }

  });
  // datewise bulk update end


// }); 
$('#comment_click').click(function () {
  var comment=$("#comment").val();
  if (comment=="") {
      addToast("comment field is required!","orange");
      $("#comment").focus();
    }
    else
    {
      $("#observation_form").submit();
    }
});
$("#bulk-allotement").click(function() {
    
            var season = $("#bulk-alt-season").val();
            var Otherseason =  $("#other_season").is(":checked");
            var rooms = $("#bulk-alt-room_id").val();
            var from_date = $("#bulk-alt-fromDate").val();
            var to_date = $("#bulk-alt-toDate").val();
            var amount = $("#bulk-alt-amount").val();
            var total_rooms = $("#tot-rooms").val();
            var allotement = $("#bulk-alt-allotment").val();
            var Cut_off = $("#bulk-alt-cut-off").val();
            var closedOut = $("#bulk-alt-closedout").is(":checked"); 
            var dayss = $("#bulk-alt-days").val();
            if ((season=="" || season==null) && Otherseason==false) {
                addToast('Must select a season!','orange');
            } else {
               if (Otherseason==true) {
                    if (from_date=="") {
                        addToast('From date field is required!','orange');
                        $("#bulk-alt-fromDate").focus();
                    } else if(to_date=="") {
                        addToast('To date field is required!','orange');
                        $("#bulk-alt-toDate").focus();
                    } else if(dayss=="") {
                        addToast('Days field is required!','orange');
                        $("#bulk-alt-days").focus();
                    } else if(rooms=="" || rooms==null) {
                        addToast('Must select a room!','orange');
                        $("#bulk-alt-room_id").focus();
                    } else if(amount!="" &&  amount==0) {
                        addToast('Amount must greater than 0','orange');
                        $("#bulk-alt-amount").focus();
                    } else {
                       $("#bulk-update-form").attr('action',base_url+'backend/hotels/RoomwiseBulkUpdate');
                       $("#bulk-update-form").submit();
                    }
               } else {
                    if(dayss=="") {
                        addToast('Days field is required!','orange');
                        $("#bulk-alt-days").focus();
                    } else if(rooms=="" || rooms==null) {
                        addToast('Must select a room!','orange');
                        $("#bulk-alt-room_id").focus();
                    } else {
                        $("#bulk-update-form").attr('action',base_url+'backend/hotels/RoomwiseBulkUpdate');
                        $("#bulk-update-form").submit();
                    }
               }
            }
            
      });
$("#extrabed_submit").off().click(function() {
  var Season= $("#Season").val();
  var fromDate= $("#fromDate").val();
  var toDate= $("#toDate").val();
  var room_type= $("#room_type").val();
  var ChildAmount= $("#ChildAmount").val();
  var ChildAgeFrom= $("#ChildAgeFrom").val();
  var ChildAgeTo= $("#ChildAgeTo").val();
  var Amount= $("#Amount").val();
  var other_season  = $("#other_season").val();
  if ($("#other_season").is(":checked")==true) {
    if(room_type=="" || room_type==null) {
      addToast("Room type is required !","orange");
      $("#room_type").focus();
    } else if (fromDate=="") {
      addToast("From date field is required !","orange");
      $("#fromDate").focus();
    } else if (toDate=="") {
      addToast("To date field is required !","orange");
      $("#toDate").focus();
    } else if(ChildAmount=="" && Amount=="") {
      addToast("Must fill Child amount or adult amount!","orange");
    // } else if(ChildAgeFrom=="") {
    //   addToast("Child age from field is required !","orange");
    //   $("#ChildAgeFrom").focus();
    // } else if(ChildAgeTo=="") {
    //   addToast("Child age to field is required !","orange");
    //   $("#ChildAgeTo").focus();
    // } else if(ChildAmount=="") {
    //   addToast("Child amount field is required !","orange");
    //   $("#ChildAmount").focus();
    // } else if (Amount=="") {
    //   addToast("Adult Amount is required !","orange");
    //   $("#Amount").focus();
    } else {
      $("#extrabed_submit").attr("disabled","disabled");
      extrabedsubmitfun();
    }
  } else {
      if(room_type=="" || room_type==null) {
        addToast("Room type is required !","orange");
        $("#room_type").focus();
      } else if (Season=="" || Season==null) {
        addToast("Season field is required !","orange");
        $("#Season").focus();
      } else if(ChildAmount=="" && Amount=="") {
        addToast("Must fill Child amount or adult amount!","orange");
      } else {
        $("#extrabed_submit").attr("disabled","disabled");
        extrabedsubmitfun();
      }
  }
  
});


// Revenue function start
function RevenueFilter(filter) {
  var Revenue_list_table = $("#Revenue_list_table").dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/Hotels/Revenuelist?filter='+filter,
            type : 'POST'

        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
}


var Revenue_Seasonlist_table = $("#Revenue_Seasonlist_table").dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/Hotels/RevenueSeasonlist',
            type : 'POST'

        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });


$("#RevenueSeasonSubmit").off().click(function() {
    var SeasonName = $("#SeasonName").val();
    var fromDate = $("#fromDate").val();
    var toDate = $("#toDate").val();
    if(SeasonName=="") {
      addToast("Season Name field is required!","orange");
      $("#SeasonName").focus();
    } else if (fromDate=="") {
      addToast("From Date field is required!","orange");
      $("#fromDate").focus();
    } else if (toDate=="") {
      addToast("To Date field is required!","orange");
      $("#toDate").focus();
    } else {
      $("#RevenueSeasonSubmit").removeAttr("disabled","disabled");
      $.ajax({
        dataType: 'json',
        type: 'post',
        url: base_url+'/backend/hotels/RevenueSeasonSubmit',
        data: $('#RevenueSeason_form').serialize(),
        cache: false,
        success: function (response) {
          if (response==true) {
             $(".close").trigger("click");
                if ($("#season_id").val()!="undefined") {
                  addToast("Updated Successfully","green");
                } else {
                  addToast("Inserted Successfully","green");
                }
                $(".close_edit_modal").trigger('click');
                var Revenue_Seasonlist_table = $("#Revenue_Seasonlist_table").dataTable({
                    "bDestroy": true,
                    "ajax": {
                        url : base_url+'/backend/Hotels/RevenueSeasonlist',
                        type : 'POST'

                    },
                "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
                }
              });
          } 
        }
      });
      // $("#Season_form").attr("action",base_url+"backend/hotels/SeasonSubmit");
      // $("#Season_form").submit();
    }
  });


  $("#RevenueUpdate").click(function() {
      var hotel = $("#hoteltext").val();
      var con   = $("#context").val();
      var agent = $("#Agentstext").val();
      var season = $("#season").val();
      var other_season = $("#other_season").is(":checked");
      var Markup = $("#Markup").val();
      if (hotel=="" && $("input[name=TBO]"). prop("checked")!=true) {
        addToast(" Hotel field is required !","orange");
        $("#hotel_undo_redo_to").focus();
      } else if (con=="" && $("input[name=TBO]"). prop("checked")!=true) {
        addToast("Contract field is required !","orange");
        $("#contract_undo_redo").focus();
      } else if(agent=="") {
        addToast("Agent field is required !","orange");
        $("#Agents_undo_redo").focus();
      } else if(season=="" && other_season==false) {
        addToast("Season/Other season field is required !","orange");
        $("#season").focus();
      } else if(Markup=="") {
        addToast("Markup field is required !","orange");
        $("#Markup").focus();
      } else {
        $("#RevenueForm").submit();
      }
    });
  

function revenueSeasonEdit_fun(id) {
  $("#Revenueseason_modal").load(base_url+'backend/hotels/revenueSeason_modal?id='+id);
}
function RevenueSeasondeletefun(id) {
  deletepopupfun(base_url+"backend/hotels/RevenueSeasondelete",id);
}
function Revenuedeletefun(id) {
  deletepopupfun(base_url+"backend/hotels/Revenuedelete",id);
}
// Revenue function end

function rankingdeletefun(id) {
  deletepopupfun("delete_ranking",id);
}
function deletefun(id) {
  deletepopupfun("delete_room_type",id);
}
function deletehotelfun(id) {
  deletepopupfundel("hotels/delete_hotel",id);
}
function deletehotelper(id) {
  deletepopupfun("hotels/delete_hotelper",id);
}
function hotel_facility_deletefun(id) {
  deletepopupfun("delete_hotel_facility",id);
}
function room_facility_deletefun(id) {
  deletepopupfun("delete_room_facility",id);
}
function closeout_period_delete(id) {
  deletepopupfun(base_url+"backend/hotels/dlt_closeout_period",id);
}
function discountdeletefun(id) {
  deletepopupfun(base_url+"backend/hotels/discountDelete",id);
}
function Displaydeletefun(id) {
  deletepopupfun(base_url+"backend/hotels/Displaydelete",id);
}
function ValidateFileUpload() {
        var fuData = document.getElementById('room_image');
        var FileUploadPath = fuData.value;

//To check if user upload any file
      
        var Extension = FileUploadPath.substring(
        FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

if (Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {

// To Display
          if (fuData.files && fuData.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
              }

              reader.readAsDataURL(fuData.files[0]);
          }

      } 
//The file upload is NOT an image
else {
      error = "Photo only allows file types of JPG, JPEG and BMP. ";
      color = "red";
      $("#room_image").val("");
      addToast(error,color);
      }
}
// function add_value_in_table(room_type_select_val,room_type_select_text,price,room_facilties,occupancy_selected,occupancy_selected_text,child_occupancy,no_of_rooms,room_name) {
//   var sno=1;
//     $('#room_add_table > tbody tr').each(function(){
//        $(this).find('.sno').html(sno++);
//     });
//   $("#room_add_table > tbody").append('<tr class="tr'+sno+'"><td class="sno" >'+sno+'<input type="hidden" id="room_edit_id'+sno+'" name="room_edit_id[]" value="" ><input type="hidden" name="edit_room_img[]" value=""></td><td><div class="mar_top_0 file-field input-field"><span class="img_change_span'+sno+'">empty </span><label class="btn-floating img_change_'+sno+' fa fa-upload grey darken-2"><input type="file" id="room_img'+sno+'" onchange="return ValidateimageUpload(event,'+sno+');" class="hide" name="room_img[]" ></label></div></td><td>'+room_name+'</td><td>' + room_type_select_text+ 
//         '</td><td>' +price +'</td><td><a class="btn-floating" data-toggle="modal" data-target="#edit_modal" onclick="room_type_edit('+sno+')">' + '<i class="fa fa-pencil-square" aria-hidden="true"></i>'+ 
//         '</a><a class="red accent-4 btn-floating mar_left_5" href="javascript:room_type_delete('+sno+')">' + '<i class="fa fa-trash" aria-hidden="true"></i>'+ 
//         '</a></td><input type="hidden" name="room_name_val[]" id="room_name_val'+sno+'" value="'+room_name+'"><input type="hidden" name="no_of_rooms[]" id="no_of_rooms" value="'+no_of_rooms+'"><input type="hidden" class="room_type_val'+sno+'" name="room_type_val[]" id="room_type_val" value="'+room_type_select_val+'"><input type="hidden" class="room_type_price'+sno+'" name="room_type_price[]" value="'+price+'"><input type="hidden" class="room_type_facilities'+sno+'" name="room_type_facilities[]" value="'+room_facilties+'"><input type="hidden" class="room_type_occupancy'+sno+'" name="room_type_occupancy[]" value="'+occupancy_selected+'"><input type="hidden" class="child_occupancy'+sno+'" name="child_occupancy[]" value="'+child_occupancy+'"></tr>');
// }
// function clear_value_from_form() {
//       var type_val = $("#room_type_select").val();
//       // $("#room_type_select option[value=" + type_val + "]").remove();
//       $("#room_name").val("");
//       $('#room_type_select').prop('selectedIndex', 0); 
//       $('#room_type_select').material_select();
//       $("#price").val("");
//       $('#room_facilties').prop('selectedIndex', 0); 
//       $('#room_facilties').material_select();     
//       $('#room_facilties').val("");
//       $('#occupancy').prop('selectedIndex', 0); 
//       $('#occupancy').material_select();   
//       $('#occupancy_child').prop('selectedIndex', 0); 
//       $('#occupancy_child').material_select();
//       $('#no_of_rooms').prop('selectedIndex', 0); 
//       $('#no_of_rooms').material_select();   
// }
function multipleimagevalidation() {
   var formData = new FormData();
 
    var file = document.getElementById("multiple_image").files[0];
 
    formData.append("Filedata", file);
    var t = file.type.split('/').pop().toLowerCase();
    if (t != "jpeg" && t != "jpg" &&  t != "bmp") {
        addToast('Please select a valid image file','orange');
        document.getElementById("multiple_image").value = '';
        return false;
    }
    if (file.size > 1024000) {
        addToast('Max Upload size is 1MB only');
        document.getElementById("multiple_image").value = '';
        return false;
    }
    return true;

}
function room_detail_viewing(id) {
  $("#large_modal").load(base_url+'backend/hotels/room_detail_viewing?id='+id);
}
function hotelpermissionfun(id,val) {
  addToast("Unblocked Successfully","green");
  if (val==1) {
    $(".Accepted").trigger('click');
  } 
  $.ajax({
        dataType: 'json',
        type: 'post',
        url: base_url+'/backend/hotels/hotelpermission?id='+id+'&&flag='+1,
        //data: $('#room_facility_form').serialize(),
        cache: false,
        success: function (response) {
          var hotel_table = $('#hotel_table').dataTable({
            "bDestroy": true,
            "ajax": {
                url : base_url+'/backend/hotels/hotel_list?filter='+val,
                type : 'GET'
            },
            "fnDrawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();          
            }
          });
        },
         error: function (xhr,status,error) {
           alert("Error: " + error);
        }
      });
  
}
  var val = [];

function room_type_delete(id) {
  var room_edit_id = $('#room_add_table > tbody .tr'+id+' #room_edit_id'+id).val();
    $('#room_add_table > tbody .tr'+id+' #room_edit_id'+id).each(function () {
        val.push(this.value);
    });
    $("#deleted_id").val(val.join(','));
  $('#room_add_table > tbody .tr'+id).remove();
}
function room_type_edit(id) {
  /*get data*/
  $("#edit_modal").load(base_url+'backend/hotels/edit_modal');
  var room_name_val = $('#room_name_val'+id).val();
  var room_type_val = $('.room_type_val'+id).val();
  var room_type_price = $('.room_type_price'+id).val();
  var room_type_occupancy = $('.room_type_occupancy'+id).val();
  var child_occupancy = $('.child_occupancy'+id).val();
  var no_of_rooms = $('.no_of_rooms'+id).val();
  var room_type_facilities = $('.room_type_facilities'+id).val();
  
  /*set data*/

  $('#get_room_name').val(room_name_val);
  $('#get_room_type_select option[value='+room_type_val+']').attr('selected',true);
  $('#get_room_type_select').material_select();
  $('#get_price').val(room_type_price);
  var res = room_type_facilities.split(",");
    $.each(res, function(i, v) {
    $('#get_room_facilties option[value='+v+']').attr('selected','selected');
  });
  $('#get_room_facilties').material_select();
  $('#get_occupancy option[value='+room_type_occupancy+']').attr('selected','selected');
  $('#get_occupancy').material_select();
  $('#get_occupancy_child option[value='+room_type_occupancy+']').attr('selected','selected');
  $('#get_occupancy_child').material_select();
  $('#get_no_of_rooms option[value='+room_type_occupancy+']').attr('selected','selected');
  $('#get_no_of_rooms').material_select();

  $(".update_button").attr("onclick","update_room_details("+id+")");
}
function update_room_details(id) {
  /*get data*/
  var get_room_name = $('#get_room_name').val();
  var get_room_type_select = $('#get_room_type_select option:selected').val();
  var get_room_type_select_text = $('#get_room_type_select option:selected').text();
  var get_price = $('#get_price').val();
  var get_room_facilties = $('#get_room_facilties').val();
  var get_occupancy = $('#get_occupancy option:selected').val();
  var get_occupancy_child = $('#get_occupancy_child option:selected').val();
  var get_no_of_rooms = $('#get_no_of_rooms option:selected').val();
  /*set data*/
  $('#room_name_val'+id).val(get_room_name);
  $(".tr"+id+" td:nth-child(3)").text(get_room_name);
  $('#room_type_val'+id).val(get_room_type_select);
  $(".tr"+id+" td:nth-child(4)").text(get_room_type_select_text);
  $('.room_type_price'+id).val(get_price);
  $(".tr"+id+" td:nth-child(5)").text(get_price);
  $('.room_type_facilities'+id).val(get_room_facilties);
  $('.room_type_occupancy'+id).val(get_occupancy);
  $('.child_occupancy'+id).val(get_occupancy_child);
  $('.no_of_rooms'+id).val(get_no_of_rooms);
}
function add_new_room() {
  var hotel_id = $("#hotel_id").val();
  $("#large_modal").load(base_url+'backend/hotels/room_add_popup?id='+hotel_id);
}
// function observation_pop() {
//   var hotel_id = $("#hotel_id").val();
//   $("#large_modal").load(base_url+'backend/hotels/hotel_observation?id='+hotel_id);
// }
function allotement_change() {
  var allotement = $("#allotement").val();
  var hotel_id = $("#hotel_id").val();
   $.ajax({
      dataType: 'json',
      type: 'post',
      url: base_url+'/backend/hotels/hotels_room_allotement_room_name?hotel_id='+hotel_id,
      cache: false,
      success: function (response) {
        linked_room_name(response.room_names);
        allotement_name_change();
      },
       error: function (xhr,status,error) {
         alert("Error: " + error);
      }
    });
}
function linked_room_name(room_names) {
  $("#allotement_room_name option").remove();
   $.each(room_names, function(i, v) {
    $("#allotement_room_name").append('<option>'+v.room_name+'</option>');
  });
}
function allotement_name_change() {
  allotement_type_change();
  var allotement_room_name = $("#allotement_room_name").val();
  var hotel_id = $("#hotel_id").val();
  $.ajax({
    dataType: 'json',
    type: 'post',
    url: base_url+'/backend/hotels/hotels_room_allotement_room_type?hotel_id='+hotel_id+'&room_name='+allotement_room_name,
    cache: false,
    success: function (response) {
      linked_room_type(response.room_type);
    }
  });
}
function linked_room_type(room_type) {
  $("#allotement_room_type option").remove();
   $.each(room_type, function(i, v) {
    $("#allotement_room_type").append('<option value='+v.id+'>'+v.Room_Type+'</option>');
  });
   allotement_type_change();
}
function room_allotement_add_fun() {
    var room_name     = $("#room_name").val();
    var room_type     = $("#room_type").val();
    // var price = $("#price").val();
    var room_facilties = $("#room_facilties").val();
    var occupancy = $("#occupancy").val();
    var occupancy_child = $("#occupancy_child").val();
    var no_of_rooms = $("#no_of_rooms").val();
    // var allotement = $("#allotement").val();
    var allotement_room_name = $("#allotement_room_name").val();
    var allotement_room_type = $("#allotement_room_type").val();
    var max_total = $("#max_total").val();
    var standarad = $("#standarad").val();
     if (room_name=="") {
      addToast("Room name field is required!","orange");
      $("#room_name").focus();
    } else if(room_type=="") {
      addToast("Room type field is required!","orange");
      $("#room_type").focus();
    }  else if(room_facilties=="") {
      addToast("Room facilities field is required!","orange");
      $("#room_facilties").focus();
    } else if(occupancy==null) {
      addToast("Occupancy  Adult field is required!","orange");
      $("#room_facilties").focus();
    } else if(occupancy_child==null) {
      addToast("Occupancy Child field is required!","orange");
      $("#room_facilties").focus();
    } else if(no_of_rooms==null) {
      addToast("No of rooms field is required!","orange");
      $("#no_of_rooms").focus();
    } else if(max_total=="") {
      addToast("max_total field is required!","orange");
      $("#max_total").focus();

    }
    else if(standarad=="") {
      addToast("Standarad Capacity field is required!","orange");
      $("#standarad").focus();

    } else {

      if ($("#room_id").val()!="") {
        $('.yourmodalid').trigger('click');
      } else {
        addToast("Inserted Successfully","green");
        $("#allotement_form").attr('action',base_url+'backend/hotels/add_room_allotement');
        $("#allotement_form").submit();
      }
        
    }
}
function allotement_type_change() {
  var allotement_room_name = $("#allotement_room_name").val();
  var allotement_room_type = $("#allotement_room_type").val();
  var hotel_id = $("#hotel_id").val();
  $.ajax({
    dataType: 'json',
    type: 'post',
    url: base_url+'/backend/hotels/hotels_room_allotement_room_id?hotel_id='+hotel_id+'&room_name='+allotement_room_name+'&room_type='+allotement_room_type,
    cache: false,
    success: function (response) {
      $("#allotement_id").val(response.room_id);
    }
  });
}
function edit_room(room_id) {
  var hotel_id = $("#hotel_id").val();
  $("#large_modal").load(base_url+'backend/hotels/room_add_popup?id='+hotel_id+'&room_id='+room_id);
}
function deleteroomfun(id) {
  deletepopupfun(base_url+"backend/hotels/delete_room",id);
}
function date_calculate() {
  var company_select = $("#one_company").val();
    $.ajax({
      dataType: 'json',
      type: "Post",
      url: base_url+'/backend/finance/copmany_select?id='+company_select,
      success: function(data) {
        fetch_one_company_data(data);
      }
  });
}
function room_change_allotement() {
  $("#allotement_filter").submit();
  var hotel_id = $("#hotel_id").val();
  var contract_id = $("#con_id").val();
  var room_id = $("#room_id").val();
  var year = $("#year").val();
  var month =  $("#month").val();
  window.location = base_url+"backend/hotels/contractProcess?hotel_id="+hotel_id+"&room_id="+room_id+'&con_id='+contract_id+'&year='+year+'&month='+month;
}
function room_change(){
  // $("#allotement_filter").submit();
  // var hotel_id = $(this).find("option:selected").text();
  var hotel_id = hotel_stopSale.value;
  // $('#hotel_id').val(hotel_id);
  // var hotel_id = $("#hotel_id").val();
  var contract_id = $("#con_id").val();
  var room_id = $("#room_id").val();
  var year = $("#year").val();
  var month =  $("#month").val();
  // alert(hotel_id);
  // alert(month);
  // alert(contract_id);
  // alert(room_id);
  window.location = base_url+"backend/hotels/hotels_stopSale?hotel_id="+hotel_id+'&con_id='+contract_id+'&room_id='+room_id+'&year='+year+'&month='+month;
}
function hotel_select(){
  var hotel_id = hotel_stopSale.value;
  $("#allotement_filter").attr("action",base_url+"backend/hotels/hotels_stopSale_id?hotel_id="+hotel_id);
  $("#allotement_filter").submit();
  // alert(hotel_id);

  // var hotel_id = $("#hotel_id").val();
  // var contract_id = $("#con_id").val();
  // var room_id = $("#room_id").val();
  // var year = $("#year").val();
  // var month =  $("#month").val();
  // window.location = base_url+"backend/hotels/hotels_stopSale?hotel_id="+hotel_id+'&room_id='+room_id+'&con_id='+contract_id+'&year='+year+'&month='+month;
}
function per_change_check_all_permission() {
  if ($("#per_check_all").is(":checked")) {
    $(".per_childs").attr("checked","checked");
  } else {
    $(".per_childs").removeAttr("checked","checked");
  }
  $("#permission_settings_form").attr("action",base_url+'/backend/hotels/agent_permission_update');
  $("#permission_settings_form").submit();
}
function per_childs_change_check_all_permission() {
  addToast("Updated Successfully","green");
  $("#permission_settings_form").attr("action",base_url+'/backend/hotels/agent_permission_update');
  $("#permission_settings_form").submit();
}
function allotement_update() {
  $.ajax({
      dataType: 'json',
      type: "Post",
      url: base_url+'/backend/hotels/allotement_update',
      data: $('#calEditForm').serialize(),
      success: function(data) {
        addToast("Updated Successfully","green");
        document.location.reload(true);
      }
  });
  // $('#allotement_update_form').attr("action",base_url+'/backend/hotels/allotement_update');
  // $('#allotement_update_form').submit();
}
function allot_update() {
    $.ajax({
      dataType: 'json',
      type: "Post",
      url: base_url+'/backend/hotels/allot_update',
      data: $('#calEditForm').serialize(),
      success: function(data) {
        addToast("Updated Successfully","green");
        document.location.reload(true);
      }
  });
}
  function contract_copy(hotel_id,id){
    $("#contract_model").load(base_url+'backend/hotels/contract_Modal?hotel_id='+hotel_id+'&id='+id+'&copy=1');
  }
  function contract_edit(hotel_id,id){
    $("#contract_model").load(base_url+'backend/hotels/contract_Modal?hotel_id='+hotel_id+'&id='+id);
  }
  function contract_delete(id){
    deletepopupfun(base_url+"backend/hotels/delete_contract",id);
  }
  function policy_view(hotel_id,id){
    $('#policy_model').modal({backdrop: 'static'});
    $("#policy_model").load(base_url+'backend/hotels/policies?hotel_id='+hotel_id+'&id='+id);
  }
  function myFunction_sales() {
    var x = document.getElementById("sales_password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
function myFunction_revenue() {
    var x = document.getElementById("revenue_password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
function myFunction_contract() {
    var x = document.getElementById("contract_password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
function myFunction_finance() {
    var x = document.getElementById("finance_password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
function allotment_select(hotel_id,id) {
    $("#contract_model").load(base_url+'backend/hotels/allotment_select_modal?hotel_id='+hotel_id+'&id='+id);
}
function allotement_redirect(hotel_id,id) {
  var change_val = $("#cnt_alt_select").val();
  window.location = base_url+'backend/hotels/allotement?id='+hotel_id+'&room_id='+change_val+'&con_id='+id;
}
function close_out_hotelChange() {
  var hotel_id = $("#hotel_id").val();
  $("#hotelid").val(hotel_id);
  var close_out_hotelChange = $('#hotel_closeout_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/hotel_closeout_list?id='+hotel_id,
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
}
function accessible_modal(hotel_id,id) {
    $("#accessible_modal").load(base_url+'backend/hotels/accessible_modal?hotel_id='+hotel_id+'&id='+id);
}
function country_accessible_modal(hotel_id,id) {
    $("#accessible_modal").load(base_url+'backend/hotels/country_accessible_modal?hotel_id='+hotel_id+'&id='+id);
}
function StopSale_delete(id) {
  deletepopupfun(base_url+"backend/hotels/delete_StopSale",id);
}
function StopSale_edit(id) {
  var hotel_id = hotel_stopSale.value;
  $("#stopSale_modal").load(base_url+'backend/hotels/stopSale_Modal?hotel_id='+hotel_id+'&id='+id);
}
function ChildPolicy_delete(id) {
  deletepopupfun(base_url+"backend/hotels/ChildPolicy_delete",id);
}
function ChildPolicy_edit(id) {
  var contract_id = $("#contract_id").val();
  var hotel_id = $("#hotel_id").val();
  $("#childPolicy_modal").load(base_url+'backend/hotels/childPolicy_Modal?hotel_id='+hotel_id+'&contract_id='+contract_id+'&id='+id);
}
function season_edit(id) {
  var hotel_id = $("#hotel_id").val();
  var contract_id  = $("#contract_id").val(); 
  $("#season_modal").load(base_url+'backend/hotels/season_modal?id='+id+'&hotel_id='+hotel_id+'&contract_id='+contract_id);
}
function season_delete(id){

  deletepopupfun(base_url+"backend/hotels/season_delete",id);

}
function contractChangefun() {
  $("#contractChangeForm").submit();
}
/*Board supplement function Start*/
function BoardSubmitfun() {
   $.ajax({
        dataType: 'json',
        type: "Post",
        url: base_url+'/backend/hotels/BoardSupplementSubmit',
        data: $('#boardSupplement_form').serialize(),
        success: function(data) {
          $(".close").trigger("click");
          if ($("#id").val()!="") {
            addToast("Updated Successfully","green");
          } else {
            addToast("Inserted Successfully","green");
          }
          board_contract_id = $('#contract_id').val();
          board_hotel_id = $('#hotel_id').val();
          var BoardSupplement_table = $('#BoardSupplement_table').dataTable({
                "bDestroy": true,
                "ajax": {
                    url : base_url+'/backend/hotels/BoardSupplementList?hotel_id='+board_hotel_id+'&contract_id='+board_contract_id,
                    type : 'GET'
                },
              "fnDrawCallback": function(settings){
              $('[data-toggle="tooltip"]').tooltip();          
              }
            });
        }
    });
}
function BoardSupplement_edit(id) {
  var hotel_id = $("#hotel_id").val();
  var contract_id = $("#contract_id").val();
  $("#childPolicy_modal").load(base_url+'backend/hotels/BoardSupplement_modal?hotel_id='+hotel_id+'&contract_id='+contract_id+'&id='+id);
}
function BoardSupplement_delete(id) {
  deletepopupfun(base_url+"backend/hotels/BoardSupplement_delete",id);
}
/*Board supplement function end*/
/*General supplement function start*/

function GeneralSupplementSubmitfun() {
   $.ajax({
        dataType: 'json',
        type: "Post",
        url: base_url+'/backend/hotels/GeneralSupplementSubmit',
        data: $('#generalSupplement_form').serialize(),
        success: function(data) {
          $(".close").trigger("click");
          if ($("#id").val()!="") {
            addToast("Updated Successfully","green");
          } else {
            addToast("Inserted Successfully","green");
          }
          GeneralSupplement_contract_id = $('#contract_id').val();
          GeneralSupplement_hotel_id = $('#hotel_id').val();
          var GeneralSupplement_table = $('#GeneralSupplement_table').dataTable({
                "bDestroy": true,
                "ajax": {
                    url : base_url+'/backend/hotels/GeneralSupplementList?hotel_id='+GeneralSupplement_hotel_id+'&contract_id='+GeneralSupplement_contract_id,
                    type : 'GET'
                },
              "fnDrawCallback": function(settings){
              $('[data-toggle="tooltip"]').tooltip();          
              }
            });
          $("#generalSupplement_submit").removeAttr("disabled","disabled");
        }
    }, 'JSON');
}
function GeneralSupplement_edit(id) {
  var hotel_id      = $("#hotel_id").val();
  var contract_id   = $("#contract_id").val();
     $("#childPolicy_modal").load(base_url+'backend/hotels/GeneralSupplement_modal?hotel_id='+hotel_id+'&contract_id='+contract_id+'&id='+id);
}
function GeneralSupplement_delete(id) {
  deletepopupfun(base_url+"backend/hotels/GeneralSupplement_delete",id);
}
/*General supplement function end*/
/*Cancellation fee function start*/
function CancelationFeeSubmitfun() {
   $.ajax({
        dataType: 'json',
        type: "Post",
        url: base_url+'/backend/hotels/CancelationFeeSubmit',
        data: $('#CancelationFee_form').serialize(),
        success: function(data) {
          $(".close").trigger("click");
          if ($("#id").val()!="") {
            addToast("Updated Successfully","green");
          } else {
            addToast("Inserted Successfully","green");
          }
          CancelationFee_contract_id = $('#contract_id').val();
          CancelationFee_hotel_id    = $('#hotel_id').val();
          var CancelationFee_table   = $('#CancelationFee_table').dataTable({
                "bDestroy": true,
                "ajax": {
                    url : base_url+'/backend/hotels/CancelationFeeList?hotel_id='+CancelationFee_hotel_id+'&contract_id='+CancelationFee_contract_id,
                    type : 'GET'
                },
              "fnDrawCallback": function(settings){
              $('[data-toggle="tooltip"]').tooltip();          
              }
          });
        }
    }, 'JSON');
}
function CancelationFee_edit(id) {
  var hotel_id = $("#hotel_id").val();
  var contract_id = $("#contract_id").val();
  $("#childPolicy_modal").load(base_url+'backend/hotels/CancellationFee_modal?hotel_id='+hotel_id+'&contract_id='+contract_id+'&id='+id);
}
function CancelationFee_delete(id) {
  deletepopupfun(base_url+"backend/hotels/CancelationFee_delete",id);
}
/*Cancellation fee function end*/
/*Minimum stay function start*/
function MinimumStaySubmitfun() {
  $.ajax({
        dataType: 'json',
        type: "Post",
        url: base_url+'/backend/hotels/MinimumStaySubmit',
        data: $('#MinimumStay_form').serialize(),
        success: function(data) {
          $(".close").trigger("click");
          if ($("#id").val()!="") {
            addToast("Updated Successfully","green");
          } else {
            addToast("Inserted Successfully","green");
          }
          MinimumStay_contract_id = $('#contract_id').val();
          MinimumStay_hotel_id = $('#hotel_id').val();
          var MinimumStay_table = $('#MinimumStay_table').dataTable({
                  "bDestroy": true,
                  "ajax": {
                      url : base_url+'/backend/hotels/MinimumStayList?hotel_id='+MinimumStay_hotel_id+'&contract_id='+MinimumStay_contract_id,
                      type : 'GET'
                  },
                "fnDrawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();          
                }
            });
        }
    }, 'JSON');
}
function MinimumStay_edit(id) {
  var hotel_id = $("#hotel_id").val();
  var contract_id = $("#contract_id").val();
  $("#childPolicy_modal").load(base_url+'backend/hotels/MinimumStay_modal?hotel_id='+hotel_id+'&contract_id='+contract_id+'&id='+id);
}
function MinimumStay_delete(id) {
  deletepopupfun(base_url+"backend/hotels/MinimumStay_delete",id);
}
/*Minimum stay function end*/
/*Close out period start*/
function closeoutSubmitfun() {
  $.ajax({
        dataType: 'json',
        type: "Post",
        url: base_url+'/backend/hotels/update_close_hotel',
        data: $('#update_closeout_hotel').serialize(),
        success: function(data) {
          $(".close").trigger("click");
          if ($("#id").val()!="") {
            addToast("Updated Successfully","green");
          } else {
            addToast("Inserted Successfully","green");
          }
          var closeouthotel_id = $("#hotel_id").val();
          var closeoutcontract_id = $("#contract_id").val();
          var hotel_closeout_table = $('#hotel_closeout_table').dataTable({
                "bDestroy": true,
                "ajax": {
                    url : base_url+'/backend/hotels/hotel_closeout_list?id='+closeouthotel_id+'&contract_id='+closeoutcontract_id,
                    type : 'GET'
                },
            "fnDrawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();          
            }
          });
        }
    }, 'JSON');
}
function close_out_edit(id) {
  var closeouthotel_id = $("#hotel_id").val();
  var closeoutcontract_id = $("#contract_id").val();
  $("#childPolicy_modal").load(base_url+'backend/hotels/close_out_update?hotel_id='+closeouthotel_id+'&contract_id='+closeoutcontract_id+'&id='+id);
}
/*Close out period end*/
function cancellationCheck(days,daysto,percent,date,season,application) {
    if (application=="FREE OF CHARGE") {
      application = 'F'; 
    }
    // alert(encodeURI(base_url+"backend/hotels/cancellationCheck_modal?days="+days+'&percent='+percent+'&date='+date+'&season='+season+'&application='+application));
    $("#canModal").load(encodeURI(base_url+"backend/hotels/cancellationCheck_modal?days="+days+'&daysTo='+daysto+'&percent='+percent+'&date='+date+'&season='+season+'&application='+application));
}
function contractPermission(con_id) {
  var contractPermission = $("#contractPermission"+con_id).val();
  if($("#contractPermission"+con_id).is(':checked')) { 
    var permission = '1';
  } else {
    var permission = '0';
  }
  $.ajax({
      dataType: 'json',
      type: "Post",
      url: base_url+'/backend/hotels/contractPermission?contract_id='+con_id+'&permission='+permission,
      success: function(data) {
        addToast("Updated Successfully","green");
      }
  });
}

// function update_fun(){
//    var room_name = $("#room_name").val();
//     var room_type = $("#room_type").val();
//     var price = $("#price").val();
//     var room_facilties = $("#room_facilties").val();
//     var occupancy = $("#occupancy").val();
//     var occupancy_child = $("#occupancy_child").val();
//     var no_of_rooms = $("#no_of_rooms").val();
//     var allotement = $("#allotement").val();
//     var allotement_room_name = $("#allotement_room_name").val();
//     var allotement_room_type = $("#allotement_room_type").val();
//     var max_total = $("#max_total").val();
//      if (room_name=="") {
//       addToast("Room name field is required!","orange");
//       $("#room_name").focus();
//     } else if(room_type=="") {
//       addToast("Room type field is required!","orange");
//       $("#room_type").focus();
//     } else if(price=="") {
//       addToast("Price field is required!","orange");
//       $("#price").focus();
//     } else if(room_facilties=="") {
//       addToast("Room facilities field is required!","orange");
//       $("#room_facilties").focus();
//     } else if(occupancy==null) {
//       addToast("Occupancy field is required!","orange");
//       $("#room_facilties").focus();
//     } else if(occupancy_child==null) {
//       addToast("Occupancy Child field is required!","orange");
//       $("#room_facilties").focus();
//     } else if(no_of_rooms==null) {
//       addToast("No of rooms field is required!","orange");
//       $("#no_of_rooms").focus();
//     } else if(max_total=="") {
//       //alert("fdz")
//       addToast("max_total field is required!","orange");
//       $("#max_total").focus();
//     } else {
//      $('#room_allotement_button').modal('show');
//         // $("#allotement_form").attr('action',base_url+'backend/hotels/add_room_allotement');
//         //  $("#allotement_form").submit();
//       }
  
//   }
  function room_allotement_update_fun(){
    if ($("#room_id").val()!="") {
       addToast("Updated Successfully","green");
     }
       
     $("#allotement_form").attr('action',base_url+'backend/hotels/add_room_allotement');
         $("#allotement_form").submit();
  }
   function menu_per_checkbox(){

   var check = $("#check").val();
    var hotel_id = $("#hotels_edit_id").val();
    if(check=="0"){
      alert("0")
    }
    
    }

/*Room aminities fun start*/
function AminitieSubmitfun() {
  $.ajax({
        dataType: 'json',
        type: "Post",
        url: base_url+'/backend/hotels/roomAminitieSubmit',
        data: $('#roomAminitieForm').serialize(),
        success: function(data) {
          $(".close").trigger("click");
          if ($("#id").val()!="") {
            addToast("Updated Successfully","green");
          } else {
            addToast("Inserted Successfully","green");
          }
          var room_aminities_table = $('#room_aminities_table').dataTable({
              "bDestroy": true,
              "ajax": {
                  url : base_url+'/backend/hotels/roomAminitiesList',
                  type : 'GET'
              },
            "fnDrawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();          
            }
          });
        }
    }, 'JSON');
}
function roomAminities_Modal(id) {
  if (id==undefined) {
    id = "";
  } else {
    id = id;
  }
  $("#AminitiesModal").load(base_url+'backend/hotels/roomAminities_Modal?id='+id);
}
function roomAminities_delete(id) {
  deletepopupfun(base_url+'backend/hotels/delete_ro omAminities',id);
}
/*Room aminites fun end*/
/*Season based cancellation policy start*/
function CancellationPolicySelectfun() {
  $("#CancellationPolicySelect option").remove();
  var contract_id = $("#contract_id").val();
  var hotel_id = $("#hotel_id").val();
  $.ajax({
        dataType: 'json',
        type: "Post",
        url: base_url+'/backend/hotels/cancellationPolicySelect?hotel_id='+hotel_id+'&contract_id='+contract_id,
        success: function(data) {
          $.each(data, function(i, v) {
                $("#CancellationPolicySelect").append('<option value="'+v.id+'">'+v.SeasonName+' - daysInAdvance : '+v.daysInAdvance+' ,'+v.application+' : '+v.cancellationPercentage+'%</option>');
          });
    CancellationPolicyContentfun();
        }
    }, 'JSON');
}
function CancellationPolicyContentfun() {
  var valId = $("#CancellationPolicySelect").val();
  var contract_id = $("#contract_id").val();
  var hotel_id = $("#hotel_id").val();
  $.ajax({
        dataType: 'json',
        type: "Post",
        url: base_url+'/backend/hotels/CancellationPolicyContentget?hotel_id='+hotel_id+'&contract_id='+contract_id+'&id='+valId,
        success: function(data) {
          $(".cancel_policy .trumbowyg-editor").html(data.cancelation_policy);
          // $("#cancel_policy").val(data.cancelation_policy);
        }
    }, 'JSON');
}
/*Season based cancellation policy end*/
function extrabedsubmitfun() {
  $.ajax({
    dataType: 'json',
    type: "Post",
    url: base_url+'/backend/hotels/extrabedsubmit',
    data: $('#extrabed_form').serialize(),
    success: function(data) {
      $(".close").trigger("click");
      if ($("#id").val()!="") {
        addToast("Updated Successfully","green");
      } else {
        addToast("Inserted Successfully","green");
      }
      extrabed_contract_id = $('#contract_id').val();
      extrabed_hotel_id = $('#hotel_id').val();
      var extrabed_table = $('#extrabed_table').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/extrabedList?hotel_id='+extrabed_hotel_id+'&con_id='+extrabed_contract_id,
            type : 'GET'
        },
      "fnDrawCallback": function(settings){
        $('[data-toggle="tooltip"]').tooltip();          
        }
      });
    }
  }, 'JSON');
}
function extrabed_edit(id) {
  var hotel_id = $("#hotel_id").val();
  var contract_id = $("#contract_id").val();
  $("#childPolicy_modal").load(base_url+'backend/hotels/extrabed_modal?hotel_id='+hotel_id+'&contract_id='+contract_id+'&id='+id);
}
function RefreshCopy(hotel_id,id){
  $("#refresh_modal").load(base_url+'backend/hotels/RefreshModal?hotel_id='+hotel_id+'&id='+id);
 }
function extrabed_delete(id) {
  deletepopupfun(base_url+"backend/hotels/extrabed_delete",id);
}
// function refreshCopy(con_id) {
//   var refCopy = $("#refreshCopy"+con_id).val();
//   if($("#refreshCopy"+con_id).is(':checked')) { 
//     var ref = '1';
//   } else {
//     var ref = '0';
//   }
//   $.ajax({
//       dataType: 'json',
//       type: "Post",
//       url: base_url+'/backend/hotels/refreshCopy?contract_id='+con_id+'&refresh='+ref,
//       success: function(data) {
//         addToast("Updated Successfully","green");
//       }
//   });
// }
 function ValidateImageFileUpload(inputId) {
        var fuData = document.getElementById(inputId);
        var FileUploadPath = fuData.value;

//To check if user upload any file
      
        var Extension = FileUploadPath.substring(
        FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

//The file uploaded is an image

  if (Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {

// To Display
          if (fuData.files && fuData.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                  $('.'+inputId+'preview').attr('src', e.target.result);
              }
              reader.readAsDataURL(fuData.files[0]);
          }

      } 
    }
function selecthotel(){
  $('#contract_undo_redo option').remove();
  $('#contract_undo_redo optgroup').remove();
  $('#contract_undo_redo_to option').remove();
  $('#contract_undo_redo_to optgroup').remove();
    var agreement = $('#contract_agreement').val();
    var hotelValues = [];
    $('#hotel_undo_redo_to option').each(function() {
          hotelValues.push($(this).val());
    });
    $('[name="hoteltext"]').val(hotelValues);
    $.ajax({
      url: base_url+'/backend/hotels/HotelSel?hotel='+hotelValues+'&con_agreement='+agreement,
      type: "POST",
      // dataType: "json",
      success:function(data) {
        $('#contract_undo_redo').append(data);
        var context = $("#context").val().split(",");
        $.each(context, function(i, v) {
            $('#contract_undo_redo option[value='+v+']').attr('selected','selected');
         });
        $("#contract_undo_redo_rightSelected").trigger('click');
        $('#contract_undo_redo_to').prop('selectedIndex', 0).focus(); 
      }
    });


}

function ContractSelect() {
  
  //  $("#disForm").attr('action',base_url+'/backend/hotels/ConSel?contract_id='+hotelValues);
  // $("#disForm").submit();
  $('#Room_undo_redo option').remove();
  $('#Room_undo_redo optgroup').remove();
  $('#Room_undo_redo_to option').remove();
  $('#Room_undo_redo_to optgroup').remove();

    var hotelValues = [];
    $('#contract_undo_redo_to option').each(function() {
          hotelValues.push($(this).val());
    });
   $('[name="context"]').val(hotelValues);
   selectseason(hotelValues);
    $.ajax({
      url: base_url+'/backend/hotels/ConSel?contract_id='+hotelValues,
      type: "POST",
      // dataType: "json",
      success:function(data) {
       $('#Room_undo_redo option').remove();
        $('#Room_undo_redo optgroup').remove();
        $('#Room_undo_redo_to option').remove();
        $('#Room_undo_redo_to optgroup').remove();
      $('#Room_undo_redo').append(data);
      var roomtext = $("#roomtext").val().split(",");
      $.each(roomtext, function(i, v) {
            $('#Room_undo_redo option[value='+v+']').attr('selected','selected');
      });
      $("#Room_undo_redo_rightSelected").trigger('click');
      $('#Room_undo_redo_to').prop('selectedIndex', 0).focus(); 
     
      }
    });
  
}

function RoomSelect(){
  
  var roomValues = [];
    $('#Room_undo_redo_to option').each(function() {
          roomValues.push($(this).val());
    });
   $('[name="roomtext"]').val(roomValues);
}
function Offersfilter(filter) {
  $("#filter").val(filter);
  var discountTable = $("#discountTable").dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/Hotels/DiscountoffList?filter='+filter,
            type : 'POST'

        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
  });
}
function RoomSelectFun(){
    var room = $('#bulk-alt-room_id').val();
    $(".blk-Rw-Update-tbody tr").remove();
    var contract_type = $(".contract_type").val();
    //alert(room)
    $.ajax({
        url: base_url+'/backend/Hotels/roomnameGet?room='+room,
        type: "POST",
        data: $('#bulk-update-form').serialize(),
        dataType: "json",
        success:function(data) {
              ReadOnly = '';
            if (contract_type=="Sub") {
              ReadOnly = 'ReadOnly';
            }
            $.each(data, function(i, v) {
              $(".blk-Rw-Update-tbody").append('<tr>'+
                '<td>'+ data[i][0].room_name+' '+data[i][0].Room_Type +'</td>'+
                '<td><input type="number"   name="RwAmount[]" id="RWAmount" /></td>'+
                '<td><input type="number" '+ReadOnly+' name="RwAllotment[]" id="RwAllotment" /></td>'+
                '<td><input type="number" '+ReadOnly+' name="RwCutoff[]" id="RwCutoff" /></td>'+
                '<input type="hidden"     name="RwRoomId[]" value="'+data[i][0].id+'"/>'+
                '</tr>');
                
            });

        }
    });
}
   
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
// function CitySelectFun() {
//   var hiddencity = $("#hiddencity").val();
//   $('#city option').remove();
//     var ConSelect = $('#ConSelect option:selected').attr('sortname');
//     $.ajax({
//         url: base_url+'/backend/Hotels/CitySelect?Conid='+ConSelect,
//         type: "POST",
//         data:{},
//         dataType: "json",
//         success:function(data) {
//           $('#city').append('<option value="">Select</option>');
//             $.each(data, function(i, v) {
//                 if (hiddencity==v.id) {
//                   selected = 'selected';
//                 } else {
//                   selected = '';
//                 }
//                 $('#city').append('<option '+selected+' value="'+ v.id +'">'+ v.CityName +'</option>');
//             });
//         }
//     });
// }
function selectseason(hotelvalues){
  $.ajax({
        url: base_url+'/backend/Hotels/SeasonSelect?Conid='+hotelvalues,
        type: "POST",
        data:{},
        dataType: "json",
        success:function(data) {
            $.each(data, function(i, v) {
                $('#season').append('<option fromdate="'+v.fromdate+'" alternate_fromdate="'+v.alternate_fromdate+'" todate="'+v.todate+'" alternate_todate="'+v.alternate_todate+'" value="'+ v.id +'">'+ v.SeasonName +'</option>');
            });
        }
    });
}
$('#season').on("change",function() {
  var fromdate = $('#season option:selected').attr('fromdate');
  var alt_fromdate = $('#season option:selected').attr('alternate_fromdate');
  var todate = $('#season option:selected').attr('todate');
  var alt_todate = $('#season option:selected').attr('alternate_todate');
  $('#alternate1').val(fromdate);
  $('#from_date').val(alt_fromdate);
  $('#alternate2').val(todate);
  $('#to_date').val(alt_todate);

});
var filter = $("#filter").val();
var rankingTable = $('#rankingTable').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/ranking_list?filter='+filter,
            type : 'GET'
        },
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
});

function Rankingfilter(filter) {
  var rankingTable = $('#rankingTable').dataTable({
        "bDestroy": true,
        "ajax": {
            url : base_url+'/backend/hotels/ranking_list?filter='+filter,
            type : 'GET'
        },
      "fnDrawCallback": function(settings){
      $('[data-toggle="tooltip"]').tooltip();          
      }
  });
}
$("#DisplayUpdate").click(function() {
      var hotel = $("#hoteltext").val();
      var con   = $("#context").val();
      var agent = $("#Agentstext").val();
      var Markup = $("#Markup").val();
      if (hotel=="") {
        addToast(" Hotel field is required !","orange");
        $("#hotel_undo_redo_to").focus();
      } else if (con=="") {
        addToast("Contract field is required !","orange");
        $("#contract_undo_redo").focus();
      } else if(agent=="") {
        addToast("Agent field is required !","orange");
        $("#Agents_undo_redo").focus();
      } else if(Markup=="") {
        addToast("Markup field is required !","orange");
        $("#Markup").focus();
      } else {
        $("#DisplayForm").submit();
      }
    });


  

