<!DOCTYPE html>
<html style="font-family:Calibri">
  <head>
  <title>IC Dashboard</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <?php echo HTML::script('js/notify.min.js')?>

  <script>
  
 function notifyPerms() {
  // Let's check if the browser supports notifications
  
  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  }

  // Let's check if the user is okay to get some notification
  else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
    notifyMe("Hi <?php echo $firstname ?>","The notification system is now running, and you'll be receiving your messages here. Please do not close your browser window!",'https://cdn3.iconfinder.com/data/icons/defcon/512/mail-128.png');

    var thebutton = document.getElementById('permission');
    thebutton.style.display = 'none';
  }

  // Otherwise, we need to ask the user for permission
  // Note, Chrome does not implement the permission static property
  // So we have to check for NOT 'denied' instead of 'default'
  else if (Notification.permission !== 'denied') {
    
    Notification.requestPermission(function (permission) {

      // Whatever the user answers, we make sure we store the information
      if(!('permission' in Notification)) {
        Notification.permission = permission;
      }

      // If the user is okay, let's create a notification
      if (permission === "granted") {
        
        notifyMe("Hi <?php echo $firstname ?>","The notification system is now running, and you'll be receiving your messages here. Please do not close your browser window!",'http://png-3.findicons.com/files/icons/1035/human_o2/48/gnome_fs_executable.png');

        var thebutton = document.getElementById('permission');
    thebutton.style.display = 'none';

      }
    });
  }

  // At last, if the user already denied any notification, and you 
  // want to be respectful there is no need to bother him any more.
};

function notifyMe(text, bodytext, icontext, disptype) {
  // Let's check if the browser supports notifications
  var opttext = {body: bodytext,icon: icontext};

  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  }

  // Let's check if the user is okay to get some notification
  else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
    
    if (disptype == '3sec' ) {
        var opttext = {body: bodytext,icon: icontext};
        var notification = new Notification(text, opttext);
        notification.onshow = function () { 
          setTimeout(notification.close.bind(notification), 6000); 
        }
    } else {
        var opttext = {body: bodytext,icon: icontext};
        var notification = new Notification(text, opttext);
    }
    
  }

  // Otherwise, we need to ask the user for permission
  // Note, Chrome does not implement the permission static property
  // So we have to check for NOT 'denied' instead of 'default'
  else if (Notification.permission !== 'denied') {
    Notification.requestPermission(function (permission) {

      // Whatever the user answers, we make sure we store the information
      if(!('permission' in Notification)) {
        Notification.permission = permission;
      }

      // If the user is okay, let's create a notification
      if (permission === "granted") {
        var notification = new Notification(text, opttext);
      }
    });
  }

  // At last, if the user already denied any notification, and you 
  // want to be respectful there is no need to bother him any more.
};

if (!!window.EventSource) {
  var source = new EventSource('msg/get');
} else {
  // Result to xhr polling :(
}

source.addEventListener('message', function(e) {
  var data = JSON.parse(e.data);
  if (data.msg == 'none') {
    //do nothing
  } else {
    if (data.from == 'system') {
      var title = 'System notification....';
      notifyMe(title,data.msg,'http://www.iconarchive.com/download/i43008/oxygen-icons.org/oxygen/Apps-system-software-update.ico','normal');
    } else if (data.from == 'tasks'){
      var title = 'Tasks..';
      notifyMe(title,data.msg,'http://www.iconarchive.com/download/i78247/igh0zt/ios7-style-metro-ui/MetroUI-Other-Task.ico', 'normal');
      
      
    } else if (data.from == 'reminder'){
      var title = 'Reminder..';
      notifyMe(title,data.msg,'https://cdn1.iconfinder.com/data/icons/office-7/32/notepad-remove-128.png','normal');

    } else if (data.from == 'taskscons'){
      var title = 'Tasks..';
      notifyMe(title,data.msg,'http://192.168.1.56/intercity/public/img/tasks.ico', '3sec');
      
      
    } else if (data.from == 'remindercons'){
      var title = 'Reminder..';
      notifyMe(title,data.msg,'https://cdn1.iconfinder.com/data/icons/office-7/32/notepad-remove-128.png', '3sec');
      
      
    } else {

      var title = data.from + ' says....';
      notifyMe(title,data.msg,'https://cdn3.iconfinder.com/data/icons/defcon/512/mail-128.png','normal');
    }
    var div = document.getElementById('messages');
    div.innerHTML = div.innerHTML + "<b>" + data.from + "</b> :: " + data.msg + '</br>';
  };
  
}, false);

$(document).ready(function(){
  // variable to hold request
var request;
// bind to the submit event of our form
$("#quickmsg").submit(function(event){
    // abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);
    // let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");
    // serialize the data in the form
    var serializedData = $form.serialize();

    // let's disable the inputs for the duration of the ajax request
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // fire off the request to /form.php
    request = $.ajax({
        url: "msg/send",
        type: "post",
        data: serializedData
    });

    // callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // log a message to the console
        //alert("Message Sent!");
        $(".mainmsg").notify(
          " Message Sent!", 
          { position:"bottom", className:'success' }
        );

        var div = document.getElementById('messages');
        div.innerHTML = div.innerHTML + "<b>" + "You" + "</b> :: " + $("#quickmsg textarea").val() + "</br>";
        $("#quickmsg textarea").val('');
    });

    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // log the error to the console
        $(".mainmsg").notify(
          " ErrorOccured : " + textStatus + ' ' + errorThrown, 
          { position:"bottom", className:'error' }
        );

    });

    // callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // reenable the inputs
        $inputs.prop("disabled", false);
    });

    // prevent default posting of form
    event.preventDefault();
});
  $('textarea').keypress(function(e) {
    var tval = $('textarea').val(),
        tlength = tval.length,
        set = 220,
        remain = parseInt(set - tlength);
    
    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
        $('textarea').val((tval).substring(0, tlength - 1))
    }

    if (remain <= 10){
      $('textarea').css({'color':'red'});
    }

    if (remain > 10){
      $('textarea').css({'color':'black'});
    }

    if (e.keyCode == 13 || e.keyCode == 34 || e.keyCode == 39) return false;

  });
});

window.onbeforeunload = function(e) {
    return 'You will not receive further desktop notifications if you close this browser window.';
};


</script>
  
  
  </head>
  <body onload= 'notifyPerms()'>
      <div id = "permission" style="font-family:Cambria">
        <h3>Permission Required</h3>
        <p>This site makes the use of notifications for better user interaction. Please grant access to the feature
        by clicking on the button bellow. Thanks!</p>
        <button style="font-family:Cambria" onclick="notifyPerms()">Grant Permission!</button>
      </div>
     
      
      
       
      
      <style type="text/css">
      #QuickMsg {
        float:left;
        width: 40%;
        font-family: Calibri;
      }

      #QuickMsg input {
        width: 85%;
        font-family: Calibri;
      }

      #QuickMsg textarea {
        width: 90%;
        font-family: Calibri;
      }

      </style>
        <div id = "QuickMsg" class = 'mainmsg'>
           <h5>Welcome <?php echo $firstname ?>,</h5>

            <h3 style="font-family:Calibri">PLEASE DO NOT CLOSE THIS WINDOW!</h3> 

          <span style="padding-left:3px">Quick Message</span>
          <form id="quickmsg" class = 'messagebox'>
            <table width="95%">
              
              <tr>
                
                <td colspan=3><textarea rows="10" cols="15" name="msg"></textarea></td>
                <td>
                  <select style='font-family:Calibri; width:110%;height:75%' name="to[]" multiple="multiple">
                    
                    <?php foreach ($users as $user) {?>
                    <option value='<?php echo $user->username;?>'><?php echo $user->username;?></option>
                    <?php }?>

                  </select>
                </td>
              </tr>
              
              <tr>
                <td width=20%><input style='margin-right:60%' type="submit" value="Send" /></td>
                <td width=60%></td>
              </tr>

            </table>
          </form>
        </div>
        
        

       <!--  <tr>
                <td width="20%"><label for="to">To</label></td>
                <td><input id="to" name="to" type="text" value="" /></td>
                <td width="64%"></td>
              </tr>
       -->
       <style>
        #messages {
          font-family: Calibri;
          font-size: 0.9em;
        }

        #messagehistory {
          border-left: 2px solid;
          float: left;
          margin-left: 10px;
          padding-left: 30px;
          font-family: Cambria;
        }
       </style>
       <div id = 'messagehistory'>
          <h3> Message History</h3>
          <div id="messages">

          </div>
      </div>
      
              


  </body>
</html>
