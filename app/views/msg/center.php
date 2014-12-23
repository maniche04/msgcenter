<!DOCTYPE html>
<html style="font-family:Calibri">
  <head>
  <title>Message Center</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <?php echo HTML::script('js/notify.min.js')?>
  <?php echo HTML::style('dist/semantic.min.css')?>
  <?php echo HTML::script('dist/semantic.min.js')?>

  <script>
  
 function notifyPerms() {
  // Let's check if the browser supports notifications
  
  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  }

  // Let's check if the user is okay to get some notification
  else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
    notifyMe("Hi <?php echo $firstname ?>","The notification system is now running, and you'll be receiving your messages here. Please do not close your browser window!",'<?php echo URL::asset("img/msgicon.png")?>');

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
        
        notifyMe("Hi <?php echo $firstname ?>","The notification system is now running, and you'll be receiving your messages here. Please do not close your browser window!",'<?php echo URL::asset("img/msgicon.png")?>');

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
      notifyMe(title,data.msg,'<?php echo URL::asset("img/msgicon.png")?>','normal');
    }

    if (document.getElementById('userlist')) {

    } else {
      var div = document.getElementById('messagehistory');
      div.innerHTML = div.innerHTML + '<br><div id = "userlist" class="ui top attached blue users inverted menu"></div>';
      div.innerHTML = div.innerHTML + '<div id = "userhistory"></div>';
    }

    if (document.getElementById(data.from + '.messages')) {
      var div = document.getElementById(data.from + '.messages')
      div.innerHTML = div.innerHTML + '<i class="angle right icon"></i>' + data.msg + '</br>';
    } else {
      
      var container = document.getElementById('userlist');
      container.innerHTML = container.innerHTML + '<a class="item " data-tab="' + data.from +'">' + data.from +'</a>'; 
      var container = document.getElementById('userhistory');
      container.innerHTML = container.innerHTML + '<div class="ui bottom attached tab segment" id= "' + data.from +'.messages" data-tab="' + data.from +'"></div>'; 
      var div = document.getElementById(data.from + '.messages');
      div.innerHTML = div.innerHTML + '<i class="angle right icon"></i>' + data.msg + '</br>';

      reloadtabs();
    }


    
  };
  
}, false);



  

  




$(document).ready(function(){

function confirmLogout() {
  $('.basic.test.modal')
  .modal({
    closable  : false,
    onDeny    : function(){
      //window.alert('Wait not yet!');
      //$.notify('Well choosen! ;)','success');
      
    },
    onApprove : function() {
      //window.alert('Approved!');
      window.location.href = '<?php echo URL::to('logout') ?>';
    }
  })
  .modal('show')
;
}

$("#logoutbtn").click(function(e){
  e.preventDefault();
  confirmLogout();
  
});
 

$(".close.icon").click(function(){
  $(this).parent().hide();
});


$('.ui.dropdown')
  .dropdown()
;


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
        $("#sendbtn").notify(
          " Message Sent!", 
          { position:"bottom", className:'success' }
        );

        //var div = document.getElementById('sen.messages');
        //div.innerHTML = div.innerHTML + "<b>" + "You" + "</b> :: " + $("#quickmsg textarea").val() + "</br>";
        $("#quickmsg textarea").val('');
        $("#mainmsgcounter" ).addClass( "hidden");
        $( "#mainmsgtext" ).removeClass( "error" );
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
  $('textarea').keyup(function(e) {
    var tval = $('textarea').val(),
        tlength = tval.length,
        set = 220,
        remain = parseInt(set - tlength);
        $('#mainmsgcounter').html(remain); 
        $("#mainmsgcounter" ).removeClass( "hidden");
             
    if (remain <= 0) {
        $('textarea').val((tval).substring(0, tlength - 1))
    }

    if (remain < 10){
      
      $( "#mainmsgtext" ).addClass( "error" );
      $( "#mainmsgcounter" ).removeClass( "green").addClass("red");
    }

    if (remain >= 10){
      $( "#mainmsgtext" ).removeClass( "error" );
      $( "#mainmsgcounter" ).removeClass( "red").addClass("green");

    }


    if (remain == 220) {
      $("#mainmsgcounter" ).addClass( "hidden");
    }

    if (e.keyCode == 13 || e.keyCode == 34 || e.keyCode == 39) return false;

  });
});

window.onbeforeunload = function(e) {
    //return 'You will not receive further desktop notifications if you close this browser window.';
};


</script>
  
  
  </head>
  <body onload= 'notifyPerms()'>
    
    <div class="ui large inverted blue menu">
      <a class="item">
        <i class="home icon"></i> Home
      </a>
      <a class="active item">
        <i class="mail icon"></i> Messages
      </a>
      <a class="item">
        <i class="info icon"></i> About
      </a>
      <div class="right menu">
        
        <div class="ui dropdown item">
          <i class="user icon"></i><?php echo $firstname ?> <i class="dropdown icon"></i>
          <div class="menu">
            
            <a class="item"><i class="edit icon"></i>Edit Profile</a>
            <a class="item"><i class="options icon"></i>Settings</a>
            <a class="item" id="logoutbtn" href="<?php echo URL::to('logout') ?>"><i class="shutdown icon"></i>Log Out</a>
          </div>
        </div>
      </div>
    </div>


      <div id = "permission" style="font-family:Cambria">
        <h3>Permission Required</h3>
        <p>This site makes the use of notifications for better user interaction. Please grant access to the feature
        by clicking on the button bellow. Thanks!</p>
        <button style="font-family:Cambria" onclick="notifyPerms()">Grant Permission!</button>
      </div>
     
      
      
       
      
      <style type="text/css">
      #QuickMsg {
        
        width: 40%;
        
      }

        
      
      </style>

        <div class="ui middle info icon message">
            <i class="close icon"></i>
            <div class="content">
            <div class="header closable">Please Note</div>
              <i class="warning icon"></i>To continue receiving further notifications, kindly leave this browser window open!
            </div>
            </div>



        <div class = "ui grid">


        <div class = "ui six wide column" id = "QuickMsg">
           

            
                   
          <form id="quickmsg" class = 'ui form segment blue messagebox'>
            <h2 class="ui header">
            <i class="mail icon"></i>
            <div class="content">
              Quick Message
            <div class="sub header">Please enter your message here!</div>
            </div>
          </h2>

            <div id='mainmsgtext' class="field">
              <div id="mainmsgcounter" class="floating ui hidden blue label"></div>
              <textarea  rows="10" cols="15" name="msg"></textarea>
              

              
            </div>

            
            

            <select class = 'ui dropdown blue' style='font-family:Calibri; width:110%;height:75%' name="to[]" multiple="multiple">
                    
                    <?php foreach ($users as $user) {?>
                    <option value='<?php echo $user->username;?>'><?php echo $user->username;?></option>
                    <?php }?>

                  </select>
                  <button id = "sendbtn" class="ui labeled icon button blue submit"><i class="send icon"></i>Send</button>

            
          </form>
        </div>
        
        

       <!--  <tr>
                <td width="20%"><label for="to">To</label></td>
                <td><input id="to" name="to" type="text" value="" /></td>
                <td width="64%"></td>
              </tr>
       -->
       <style>
       #QuickMsg {
        margin: 10px;
        margin-top:0px;
       }

        #messages {
          
          font-size: 1em;
        }

        #messagehistory {
          
          float: left;
          
          
        }
       </style>

      
       <div class = "ui six wide column">
       <div class = "ui raised blue segment" id = 'messagehistory'>
          

          <h2 class="ui header">
            <i class="history icon"></i>
            <div class="content">
              Message History
            <div class="sub header">The messages you receive will be displayed here!</div>
            </div>
          </h2>

      <script>

      function reloadtabs() {
        $('.users.menu .item').tab({history:false});
      }


        $(document).ready(function(){
            $('.users.menu .item').tab({history:false});
        });
      </script>

          </div>
          
          </div>
      </div>

      </div>


      <br>
      <br>


      <div class="ui basic test modal">
  
  <div class="header">
    Please Confirm!
  </div>
  <div class="content">
    <div class="image">
      <i class="shutdown icon"></i>
    </div>
    <div class="description">
      <p>Are you sure you want to Logout?</p>
    </div>
  </div>
  <div class="actions">
    <div class="two fluid ui inverted buttons">
      <div class="ui red basic inverted deny button" data-value="No">
        <i class="remove icon"></i>
        No
      </div>
      <div class="ui green basic inverted approve button" data-value = "Yes">
        <i class="checkmark icon"></i>
        Yes
      </div>
    </div>
  </div>
</div>

</body>
</html>
