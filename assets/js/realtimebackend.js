// $(document).ready(function() {
	socket.on('activestatus', function(msg) {
		$(".circle-status").removeClass("circle-success").addClass("circle-warning");
		if (msg!="") {
			$.each(msg,function(i,v) {
				console.log(v);
				$(".admin-"+v).find('.circle-status').addClass("circle-success").removeClass("circle-warning");
			})
		}
    });
// })