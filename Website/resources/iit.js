/* eslint-disable vars-on-top */
/* eslint-disable no-var */
/* eslint-disable no-unused-vars */
/* eslint-disable yoda */
/* eslint-disable no-undef */
function validate(formObj) {
  
  if (formObj.name.value === '') {
    alert('Please enter an assignment name');
    formObj.name.focus();
    return false;
  }
  
  
  if (formObj.difficulty.value === '') {
    alert('Please enter a difficulty');
    formObj.difficulty.focus();
    return false;
  }

  if (formObj.deadline.value === '') {
    alert('Please enter a data of deadline');
    formObj.deadline.focus();
    return false;
  }

  
    
  return true;
}


$(document).ready(function() {
  
  // focus the name field on first load of the page
  $('#name').focus();
     
  $('#suggestion').click(function() {
      alert('You\'ve clicked the suggestion button');
   });

  $('.deleteAssignment').click(function removeAss() {
    // if(confirm('Are you sure you want to remove this task?')) {
      
      var num = $(this).parent().parent().find(".amount");
      var amount = parseInt(num);
      amount = 100;
      $(this).parent().find(".amount").html(amount);

      // get the id of the clicked element's row
      var curId = $(this).closest('tr').attr('id');
      // Extract the db id of the actor from the dom id of the clicked element
      var assignmentId = curId.substr(curId.indexOf('-')+1);
      // Build the data to send. 
      var postData = 'id=' + assignmentId;
      // we could also format this as json ... jQuery will (by default) 
      // convert it into a query string anyway, e.g. 
      // var postData = { "id" : actorId };
      
      $.ajax({
        type: 'post',
        url: 'assignment-delete.php',
        dataType: 'json',
        data: postData,
        success: function(responseData, status){
          if (responseData.errors) {
            alert(responseData.errno + ' ' + responseData.error);
          } else {
            // Uncomment the following line to see the repsonse message from the server
            // alert(responseData.message);
            
            // remove the table row in which the image was clicked
            $('#' + curId).closest('tr').remove();
            
            // if a php generated message box is up, hide it:
            $('.messages').hide();
            
            // populate the js message box and show it:
            $('#jsMessages').html('<h4>Assignment deleted</h4>').show();
            
            // re-zebra the table
            $('#assignmentTable tr').each(function(i){
              if (i % 2 === 0) {
                // we must compensate for the header row...
                $(this).addClass('odd'); 
              } else {
                $(this).removeClass('odd');
              }
            });
          }
          window.location.reload();
        },
        error: function(msg) {
          // there was a problem
          alert(msg.status + ' ' + msg.statusText);
        }
      });
      
    // }
  });


  $('.returnAssignment').click(function returnAss() {
    // if(confirm('Are you sure you want to reassign this task?')) {

      var num = $(this).parent().parent().find(".amount");
      var amount = parseInt(num);
      amount -= 5;
      $(this).parent().find(".amount").html(amount);
      
      var curId = $(this).closest('tr').attr('id');
      var assignmentId = curId.substr(curId.indexOf('-')+1);

      var postData = 'id=' + assignmentId;
      
      $.ajax({
        type: 'post',
        url: 'assignment-return.php',
        dataType: 'json',
        data: postData,
        success: function(responseData, status){
          if (responseData.errors) {
            alert(responseData.errno + ' ' + responseData.error);
          } else {
            // Uncomment the following line to see the repsonse message from the server
            // alert(responseData.message);
            
            // remove the table row in which the image was clicked
            $('#' + curId).closest('tr').remove();
            
            // if a php generated message box is up, hide it:
            $('.messages').hide();
            
            // populate the js message box and show it:
            $('#jsMessages').html('<h4>Assignment Returned</h4>').show();
            
            // re-zebra the table
            $('#assignmentTable tr').each(function(i){
              if (i % 2 === 0) {
                // we must compensate for the header row...
                $(this).addClass('odd'); 
              } else {
                $(this).removeClass('odd');
              }
            });
            window.location.reload();
          }
        },
        error: function(msg) {
          // there was a problem
          alert(msg.status + ' ' + msg.statusText);
        }
      });
      
    // }
  });


    $('.plus').click(function() {

      // get the id of the clicked element's row
      var curId = $(this).closest('tr').attr('id');
      // Extract the db id of the actor from the dom id of the clicked element
      var assignmentId = curId.substr(curId.indexOf('-')+1);
      // Build the data to send. 
      var postData = 'id=' + assignmentId;
      // we could also format this as json ... jQuery will (by default) 
      // convert it into a query string anyway, e.g. 
      // var postData = { "id" : actorId };
      
      $.ajax({
        type: 'post',
        url: 'plus.php',
        dataType: 'json',
        data: postData,
        success: function(responseData, status){
          
          if (responseData.errors) {
            alert(responseData.errno + ' ' + responseData.error);
          } else {

          }
        },
        error: function(msg) {
          // there was a problem
          
          alert(msg.status + ' ' + msg.statusText);
        }
      });   
  });


  $('.minus').click(function() {
      
      
      // get the id of the clicked element's row
      var curId = $(this).closest('tr').attr('id');
      // Extract the db id of the actor from the dom id of the clicked element
      var assignmentId = curId.substr(curId.indexOf('-')+1);
      // Build the data to send. 
      var postData = 'id=' + assignmentId;
      // we could also format this as json ... jQuery will (by default) 
      // convert it into a query string anyway, e.g. 
      // var postData = { "id" : actorId };
      
      $.ajax({
        type: 'post',
        url: 'minus.php',
        dataType: 'json',
        data: postData,
        success: function(responseData, status){
          
          if (responseData.errors) {
            alert(responseData.errno + ' ' + responseData.error);
          } else {
            
          }
        },
        error: function(msg) {
          // there was a problem
          
          alert(msg.status + ' ' + msg.statusText);
        }
      });
      
    
  });
  
  
});
