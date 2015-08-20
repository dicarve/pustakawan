var regChosen2 = function(el) {
  $(el).each(function(i) {
    var ajaxURL = $(this).attr('data-ajax-source');
    // alert(ajaxURL);
    $(this).ajaxChosen({
        jsonTermKey: 'keywords',
        type: 'GET',
        url: ajaxURL,
        dataType: 'json'
    }, function (data) {
        var results = [];
    
        $.each(data, function (i, val) {
          $.each(data, function (i, val) {
            results.push({ value: val.text, text: val.text });
          });
        });
    
        return results;
    });
    
  }); 
}

$(document).ready(function() {
  $('.chosen').chosen();
  
  $('.chosen-ajax').each(function(i) {
    var ajaxURL = $(this).attr('data-ajax-source');
    // alert(ajaxURL);
    $(this).ajaxChosen({
        jsonTermKey: 'keywords',
        type: 'GET',
        url: ajaxURL,
        dataType: 'json'
    }, function (data) {
        var results = [];
    
        $.each(data, function (i, val) {
          $.each(data, function (i, val) {
            results.push({ value: val.text, text: val.text });
          });
        });
    
        return results;
    });
  
  });
  
  $('.add-resource-btn').bind('click', function(e) {
    e.preventDefault();
    var btn = $(this);
    var modalTitle = btn.attr('data-title');
    var ajaxURL = btn.attr('href');
    var pathfinderID = btn.attr('data-pathfinder');
    var resourceID = btn.attr('data-resource-id');
    $('#modalDialog .modal-title').text(modalTitle);
    // inject form
    $('#modalDialog').modal();

    $.ajax({
      url: ajaxURL,
      cache: false
    }).done(function( html ) {
      $('#modalDialog .modal-body').html(html);
      regChosen2('#modalDialog .modal-body .chosen-ajax');
      $('#modalDialog .modal-body .chosen-container-multi').css('width', '100%');
    });
    
  });
  
  // add-resource-btn
  
})