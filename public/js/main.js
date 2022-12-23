var skeletonId = 'skeleton';
var contentId = 'content';
var skipCounter = 0;
var takeAmount = 10;

function getRequests(mode) {

  if (mode == 'sent') {
    $('#load_more_sent_requests_btn_parent').addClass("d-none");
  } else {
    $('#load_more_received_requests_btn_parent').addClass("d-none");
  }

  $('#skeleton').removeClass("d-none");
  
  let args = { url: 'get-more-requests', method: 'post', data: { currentPage: 0, total: 0, mode: mode } };

  fetchData(function(data){
    $('#skeleton').addClass("d-none");

      if (mode == 'sent') {
        $('#sent_requests > #content').append(data.output);
        if (data.currentPage * 10 < data.total) {
          // Set Load More button attributes
          $('#load_more_sent_requests_btn_parent').removeClass("d-none");
          $('#load_more_sent_requests_btn').attr("data-currentPage", data.currentPage);
          $('#load_more_sent_requests_btn').attr("data-total", data.total);
        }
        // Set the Counter
        // let reqCount = $("#sent_requests > #content").children().length
        $("#get_sent_requests_btn").html("Sent Requests (" + data.total + ")")
      }
      else {
        $('#received_requests > #content').append(data.output);
        if (data.currentPage * 10 < data.total) {
          // Set Load More button attributes
          $('#load_more_received_requests_btn_parent').removeClass("d-none");
          $('#load_more_received_requests_btn').attr("data-currentPage", data.currentPage);
          $('#load_more_received_requests_btn').attr("data-total", data.total);
        }
        // Set the Counter
        // let reqCount = $("#received_requests > #content").children().length
        $("#get_received_requests_btn").html("Received Requests (" + data.total + ")")
      }
  }, args)

}

function getMoreRequests(mode) {

  if (mode == 'sent') {
    $('#load_more_sent_requests_btn_parent').addClass("d-none");
    var total = parseInt($("#load_more_sent_requests_btn").attr('data-total'))
    var currentPage = parseInt($("#load_more_sent_requests_btn").attr('data-currentPage'))
  } else {
    $('#load_more_received_requests_btn_parent').addClass("d-none");
    var total = parseInt($("#load_more_received_requests_btn").attr('data-total'))
    var currentPage = parseInt($("#load_more_received_requests_btn").attr('data-currentPage'))
  }


  $('#skeleton').removeClass("d-none");

  let args = { url: 'get-more-requests', method: 'post', data: { currentPage: currentPage + 1, total: total, mode: mode } };

  fetchData(function(data){
    if (mode == 'sent') {
      $('#sent_requests > #content').append(data.output);
      if (data.currentPage * 10 < data.total) {
        // Set Load More button attributes
        $('#load_more_sent_requests_btn_parent').removeClass("d-none");
        $('#load_more_sent_requests_btn').attr("data-currentPage", data.currentPage);
        $('#load_more_sent_requests_btn').attr("data-total", data.total);
      }

    }
    else {
      $('#received_requests > #content').append(data.output);
      if (data.currentPage * 10 < data.total) {
        // Set Load More button attributes
        $('#load_more_received_requests_btn_parent').removeClass("d-none");
        $('#load_more_received_requests_btn').attr("data-currentPage", data.currentPage);
        $('#load_more_received_requests_btn').attr("data-total", data.total);
      }
    
    }
  }, args)
}

function getConnections() {

  $('#load_more_connections_btn_parent').addClass("d-none");
  $('#skeleton').removeClass("d-none");

  let args = { url: 'get-more-connections', method: 'post', data: { currentPage: 0, total: 0 } };

    fetchData(function(data){
      $('#connections_data').append(data.output);
      $('#skeleton').addClass("d-none");

      if (data.currentPage * 10 < data.total) {
        $('#load_more_connections_btn_parent').removeClass("d-none");
        $('#load_more_connections_btn').attr("data-currentPage", data.currentPage);
        $('#load_more_connections_btn').attr("data-total", data.total);
      }
      // Set Counter
      $("#get_connections_btn").html("Connections (" + data.total + ")")
    }, args)

}

function getMoreConnections() {

  let total = parseInt($("#load_more_connections_btn").attr('data-total'))
  let currentPage = parseInt($("#load_more_connections_btn").attr('data-currentPage'))

  $('#load_more_connections_btn_parent').addClass("d-none");
  $('#skeleton').removeClass("d-none");

  let args = { url: 'get-more-connections', method: 'post', data: { currentPage: currentPage + 1, total: total } };

  fetchData(function(data){
    $('#connections_data').append(data.output);
    $('#skeleton').addClass("d-none");

    if (data.currentPage * 10 < total) {
      $('#load_more_connections_btn_parent').removeClass("d-none");
      $('#load_more_connections_btn').attr("data-currentPage", data.currentPage);
    }
  }, args)
}

function getConnectionsInCommon(userId, connectionId) {
  // your code here...
}

function getMoreConnectionsInCommon(userId, connectionId) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getSuggestions() {

  $('#load_more_suggestions_btn_parent').addClass("d-none");
  $('#skeleton').removeClass("d-none");

  let args = { url: 'get-more-suggestions', method: 'post', data: { currentPage: 0, total: 0 } };

  fetchData(function (data) {
    $('#suggestion_data').append(data.output);
    $('#skeleton').addClass("d-none");
    if (data.currentPage * 10 < data.total) {
      // Set Load More button attributes
      $('#load_more_suggestions_btn_parent').removeClass("d-none");
      $('#load_more_suggestions_btn').attr("data-currentPage", data.currentPage);
      $('#load_more_suggestions_btn').attr("data-total", data.total);
    }
    // Set the Counter
    // let segCount = $("#suggestion_data").children().length
    $("#get_suggestions_btn").html("Suggestions (" + data.total + ")")
  }, args);

}

function getMoreSuggestions() {

  let total = parseInt($("#load_more_suggestions_btn").attr('data-total'))
  let currentPage = parseInt($("#load_more_suggestions_btn").attr('data-currentPage'))

  $('#load_more_suggestions_btn_parent').addClass("d-none");
  $('#skeleton').removeClass("d-none");

  let args = { url: 'get-more-suggestions', method: 'post', data: { currentPage: currentPage + 1, total: total } };

  fetchData(function(data){
      $('#suggestion_data').append(data.output);
      $('#skeleton').addClass("d-none");

      if (data.currentPage * 10 < total) {
        // Set Load More button attributes
        $('#load_more_suggestions_btn_parent').removeClass("d-none");
        $('#load_more_suggestions_btn').attr("data-currentPage", data.currentPage);
      }
  },args)
}

function sendRequest(userId, suggestionId) {

  // userId is SenderID (Current LoggedIn User)
  // and suggestionId is ReceiverID
  let args = { url: 'requests', method: 'post', data: { senderID: userId, receiverID: suggestionId } };

  fetchData(function(data){
    location.reload();
  }, args)
}

function deleteRequest(id) {

  let args = { url: 'requests/'+id, method: 'delete', data: { } };

  fetchData(function(data){
    location.reload();
  }, args)
}


function acceptRequest(recordID) {

  let args = { url: 'requests/'+recordID, method: 'put', data: {  } };

  fetchData(function(data){
    location.reload();
  }, args)

}

function removeConnection(userId, connectionId) {

  let args = { url: 'remove-connection', method: 'post', data: { userID: userId, connectionID: connectionId } };

  fetchData(function(data){
    location.reload();
  }, args)

}

function fetchData(callback, args) {

  $.ajax({
    url: args.url,
    method: args.method,
    data: args.data,
    success: function (responseData) {
      responseData = JSON.parse(responseData)
      callback(responseData)
    },
    error: function (err) {
      callback(err)
    }
  });
}

$(function () {

  // Setting Ajax headers for all Ajax calls CSRF Token
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  getSuggestions();

  $("#get_suggestions_btn").on('click', function () {

    $('.suggestions_tab').removeClass('d-none')
    $('.sent_requests_tab').addClass('d-none')
    $('.received_requests_tab').addClass('d-none')
    $('.connections_tab').addClass('d-none')
  });

  $("#get_sent_requests_btn").on('click', function () {

    $('.suggestions_tab').addClass('d-none')
    $('.sent_requests_tab').removeClass('d-none')
    $('.received_requests_tab').addClass('d-none')
    $('.connections_tab').addClass('d-none')

    // If Sent Requests div is empty only then fetch data 
    if (!$.trim($('#sent_requests > #content').html()).length) {
      getRequests('sent')
    }

  });

  $("#get_received_requests_btn").on('click', function () {

    $('.suggestions_tab').addClass('d-none')
    $('.sent_requests_tab').addClass('d-none')
    $('.received_requests_tab').removeClass('d-none')
    $('.connections_tab').addClass('d-none')

    // If Sent Requests div is empty only then fetch data
    if (!$.trim($('#received_requests > #content').html()).length) {
      getRequests('received')
    }
  });

  $("#get_connections_btn").on('click', function () {

    $('.suggestions_tab').addClass('d-none')
    $('.sent_requests_tab').addClass('d-none')
    $('.received_requests_tab').addClass('d-none')
    $('.connections_tab').removeClass('d-none')

    // If Connections div is empty only then fetch data
    if (!$.trim($('#connections_data').html()).length) {
      getConnections()
    }
  });

});