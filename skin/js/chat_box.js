Array.remove = function(array, from, to) {
                var rest = array.slice((to || from) + 1 || array.length);
                array.length = from < 0 ? array.length + from : from;
                return array.push.apply(array, rest);
            };
        
//this variable represents the total number of popups can be displayed according to the viewport width
var total_popups = 0;

//arrays of popups ids
var popups = [];

//this is used to close a popup
function close_popup(id) {
    for(var iii = 0; iii < popups.length; iii++) {
        if(id == popups[iii]) {
            Array.remove(popups, iii);
            
            document.getElementById(id).style.display = "none";
            
            calculate_popups();
            
            return;
        }
    }   
}

//displays the popups. Displays based on the maximum number of popups that can be displayed on the current viewport width
function display_popups() {
    var right = 290;

    var iii = 0;
    for(iii; iii < total_popups; iii++) {
        if(popups[iii] != undefined) {
            var element = document.getElementById(popups[iii]);
            element.style.right = right + "px";
            right = right + 290;
            element.style.display = "block";
        }
    }

    for(var jjj = iii; jjj < popups.length; jjj++) {
        var element = document.getElementById(popups[jjj]);
        element.style.display = "none";
    }
}

//creates markup for a new popup. Adds the id to popups array.
function register_popup(id, name) {
    for(var iii = 0; iii < popups.length; iii++) {   
        //already registered. Bring it to front.
        if(id == popups[iii]) {
            Array.remove(popups, iii);
        
            popups.unshift(id);
            
            calculate_popups();
            
            
            return;
        }
    }  
    getMessages(id);              
    var element = '<div class="popup-box chat-popup" id="'+ id +'">';
    element = element + '<div class="popup-head">';
    element = element + '<div class="popup-head-left">'+ name +'</div>';
    element = element + '<div class="popup-head-right"><a href="javascript:close_popup(\''+ id +'\');">&#10005;</a></div>';
    element = element + '<div style="clear: both"></div></div><div class="popup-messages">';
    element = element + '<div class="chat-history"><ul class="messages'+id+'">';
    // element = element + '<li class="clearfix"><div class="other-message-data"><span class="other-message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp;<span class="message-data-name" >Olia</span></div><div class="message other-message">Hi Vincent, how are you? How is the project coming along?</div></li>';
     // element = element + '<li class="clearfix"><div class="other-message-data"><span class="other-message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp;<span class="message-data-name" >Olia</span></div><div class="message other-message">Hi Vincent, how are you? How is the project coming along?</div></li>';
     //  element = element + '<li class="clearfix"><div class="other-message-data"><span class="other-message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp;<span class="message-data-name" >Olia</span></div><div class="message other-message">Hi Vincent, how are you? How is the project coming along?</div></li>';
     // element = element + '<li><div class="my-message-data"><span class="my-message-data-time">10:12 AM, Today&nbsp; &nbsp;</span><span class="message-data-name">Me</span></div><div class="message my-message">Are we meeting today? Project has been already finished and I have results to show you.</div></li>';
    element = element + '</ul></div</div></div></div>';
    // element = element + '<div class="chat-message clearfix"><textarea name="message-to-send" id="message-to-send" placeholder ="Type your message" rows="3"></textarea><button>Send</button></div>';


    document.getElementsByTagName("body")[0].innerHTML = document.getElementsByTagName("body")[0].innerHTML + element;  

    popups.unshift(id);
            
    calculate_popups();

}

//calculate the total number of popups suitable and then populate the toatal_popups variable.
function calculate_popups() {
    var width = window.innerWidth;
    if(width < 540) {
        total_popups = 0;
    }
    else {
        width = width - 200;
        //320 is width of a single popup box
        total_popups = parseInt(width/320);
    }
    display_popups();

}
function getMessages(id) {
    $.ajax({
      dataType: 'json',
      type: "POST",
      url: base_url+'backend/Chat/getMessages/'+id,
      cache: false,
      success: function (response) { 
        $(".messages"+id).html(response.list);
      }
    });
}

//recalculate when window is loaded and also when window is resized.
window.addEventListener("resize", calculate_popups);
window.addEventListener("load", calculate_popups);
