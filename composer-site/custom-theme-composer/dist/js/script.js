/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire, audiojs*/

(function($) {
  // Pagination Ajax.
  var pagination_ajax = function () {
    var parent_views = $(this).parents('.views');
    var name = parent_views.find('input[name="name"]').val();
    var post_type = parent_views.find('input[name="post_type"]').val();
    var per_page = parent_views.find('input[name="per_page"]').val();
    var cat_id = parent_views.find('input[name="cat_id"]').val();
    var custom_fields = parent_views.find('input[name="custom_fields"]').val();
    var use_pagination = parent_views.find('input[name="use_pagination"]').val();
    var paged_index = $(this).parent('li').attr('data-value');
    //alert(name);
    $(this).parents('ul.pager').find('> li').removeClass('current');
    $(this).parent('li').addClass('current');

    $.ajax({
      type : "post",
      dataType : "json",
      url : paginationAjax.ajaxurl,
      data : {action: "pagination", name: name, post_type: post_type, per_page: per_page, cat_id: cat_id, custom_fields: custom_fields, paged_index: paged_index, use_pagination: '' },
      beforeSend: function() {
        //parent_views.find('.load-views').empty();
        parent_views.find('.tool-pagination.ajax-pagination').before('<div class="ajax-load-icon">load items</div>');
      },
      success: function(response) {
        parent_views.find('.ajax_views').fadeOut("normal", function() {
          $(this).remove();
        });
        parent_views.find('.load-views').fadeOut("normal", function() {
          $(this).remove();
        });
        parent_views.find('.ajax-load-icon').fadeOut("normal", function() {
          $(this).remove();
        });
        parent_views.find('.tool-pagination.ajax-pagination').before('<div class="load-views"></div>');
        parent_views.find('.load-views').fadeIn("normal", function() {
          $(this).html(response.markup);
        });
        $("select").chosen();
        popupDownload();
      },
      error: function(response) {

      }
    });

    return false;

  };

  function get_location_info() {
    $.get("http://ipinfo.io", function (response) {
      $("#ip").html("IP: " + response.ip);
      $("#address").html("Address: " + response.city + ", " + response.region);
      $("#city").html("City: " + response.city);
      $("#region").html("Region: " + response.region);
      $("#country").html("Country: " + response.country);
      $("#loc").html("Location: " + response.loc);
      $("#org").html("Org: " + response.org);
      //$("#details").html(JSON.stringify(response, null, 4));
    }, "jsonp");
  }

  $(document).ready(function() {
    get_location_info();
    $('.ajax-pagination .pager-item a').on('click', pagination_ajax);
  });

  $(window).load(function() {
    // Call to function
  });

  $(window).resize(function() {
    // Call to function
  });
})(jQuery);
