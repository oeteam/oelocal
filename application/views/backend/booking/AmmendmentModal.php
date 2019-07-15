<div class="modal-content">
    <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Amendments</h4>
    </div>
    <div class="modal-body">
      <form id="amendmentForm" method="post"  action="<?php echo base_url() ?>backend/booking/amendmentUpdate" >
        <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
        <div class="row">
          <?php 
              $book_room_count = $view[0]->book_room_count;
              $tot_days = $view[0]->no_of_days;
              $totalamendcost = 0;
              $roomExp = explode(",", $view[0]->room_id);
              $individual_amount = explode(",", $view[0]->individual_amount);
              if(isset($amenddata[0])&&$amenddata[0]!="") {
                for($i=1;$i<=$book_room_count;$i++) {
                 $varIndividual = 'Room'.$i.'individual_amount';
                  if($amenddata[0]->$varIndividual!="") {
                    $amendindividual_amount = explode(",", $amenddata[0]->$varIndividual);
                    $totalamendcost = $totalamendcost + array_sum($amendindividual_amount);
                  }
                }
              }
              for ($i=1; $i <= $book_room_count; $i++) { 
                if (!isset($roomExp[$i-1])) {
                  $room_id = $roomExp[0];
                } else {
                  $room_id = $roomExp[$i-1];
                }
                $varIndividual = 'Room'.$i.'individual_amount';
                if(isset($amenddata[0])&&$amenddata[0]!="") {
                  if($amenddata[0]->$varIndividual!="") {
                    $amendindividual_amount = explode(",", $amenddata[0]->$varIndividual);
                  }
                }
                if($view[0]->$varIndividual!="") {
                  $individual_amount = explode(",", $view[0]->$varIndividual);
                }

                $RoomName = roomnameGET($room_id,$view[0]->hotel_id);
        ?>
        <div class="col-md-12">
          <h4 class="room-name">Room <?php echo $i; ?></h4>
          <table class="table-bordered Room-table">
            <thead style="background-color: #F2F2F2;">
              <tr>
                <th style="width: 85px;">Date</th>
                <th style="width: calc(100% - 265px);">Room Type</th>
                <th style="width: 60px; text-align: center">Board</th>
                <th style="width: 120px; text-align: center">Current Cost Rate</th>
                <th style="width: 120px; text-align: center">New Cost Rate</th>
                <th style="width: 120px; text-align: right">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($j=0; $j < $tot_days ; $j++) {  ?>
                <tr>
                  <td><?php echo date('d/m/Y', strtotime($view[0]->check_in. ' + '.$j.'  days')); ?></td>
                  <td><?php echo $RoomName ?></td>
                  <td style="text-align: center"><?php echo $view[0]->boardName; ?></td>
                  <td style="text-align: right" class="Cost"><?php echo $individual_amount[$j] ?></td>
                  <td style="text-align: right"><input type="text" class="newCost text-right" name="Room<?php echo $i; ?>[]" value="<?php echo isset($amendindividual_amount[$j]) && $amendindividual_amount!=''?$amendindividual_amount[$j]:0 ?>"></td>
                  <td style="text-align: right" class="ttl"><?php echo $individual_amount[$j] ?></td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" style="text-align: right"><strong class="text-blue">Total</strong></td>
                <td class="net-Cost text-right"><?php echo array_sum($individual_amount) ?></td>
                <td class="net-newCost text-right"><?php echo $totalamendcost ?></td>
                <td class="net-ttl text-right"><?php echo array_sum($individual_amount) ?></td>
              </tr>
            </tfoot>
        </table>
      </div>
      <?php } ?>
      </form>
      </div>
       <div class="modal-footer">
          <div class="row">
                <button type="button" id="amendmentUpdate" class="btn-sm btn-primary">Update</button>
          </div>
      </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $(".newCost").keyup(function() {
       var cost = $(this).closest('tr').find('.Cost').text();
       var Newcost = $(this).val();
       $(this).closest('tr').find('.ttl').text(Number(cost)+Number(Newcost));
       var ttl = 0;
       $.each($(this).closest('tbody').find('.newCost'),function(i,v) {
          ttl+= Number($(v).val()); 
       })
       $(this).closest('table').find('.net-newCost').text(ttl);
       var ttl1 = 0;
       $.each($(this).closest('tbody').find('.ttl'),function(i,v) {
          ttl1+= Number($(v).text()); 
       })
       $(this).closest('table').find('.net-ttl').text(ttl1);
    })

    $("#amendmentUpdate").click(function() {
      var tempttl = 0;
      $.each($('.newCost'),function(i,v) {
        tempttl+= Number($(v).val()); 
      })
      if (tempttl==0) {
        addToast('Please change the cost value!','orange');
      } else {
        addToast('Amendments updated successfully','green');
        $("#amendmentForm").submit();
      }
    })

  })
</script>

