$(function () {
    sessionStorage.clear();

    $("#clientterritory").select2();

    $('#clientterritory').on('select2:select', function (e) {
      $('#clientlist').val(null).trigger('change');
      $('#contactlist').val(null).trigger('change');
      $('#contactlocation').val(null).trigger('change');

      sessionStorage.removeItem('select_territory_id');
      sessionStorage.removeItem('select_location_id');
      sessionStorage.removeItem('select_contact_id');
      sessionStorage.removeItem('select_cl_id');

      var select_territory_id = e.params.data.id;
      sessionStorage.setItem(
        'select_territory_id', select_territory_id,
      )
      $("#clientlist").select2({
      ajax: {
          url: "/v1/clientlist",
          type: "POST",
          dataType: 'json',
          delay: 250,
          data: function (params) {
             return {
                _token : $('#token').val(),
                select_territory_id:sessionStorage.getItem('select_territory_id'),
                searchTerm: params.term // search term
             };
          },
          processResults: function (response) {
             return {
                results: response
             };
          },
          cache: true
        }
     });

     clientitemtype();
     
    });

    $("#clientlist").select2({
        minimumInputLength: 3,
        ajax: {
          url: "/v1/clientlist",
          type: "POST",
          dataType: 'json',
          delay: 250,
          data: function (params) {
             return {
                _token : $('#token').val(),
                select_territory_id:sessionStorage.getItem('select_territory_id'),
                searchTerm: params.term // search term
             };
          },
          processResults: function (response) {
             return {
                results: response
             };
          },
          cache: true
        }
    });

    $('#clientlist').on('select2:select', function (e) {
      $('#contactlist').val(null).trigger('change');
      $('#contactlocation').val(null).trigger('change');
      var select_cl_id = e.params.data.id;
      sessionStorage.setItem(
        'select_cl_id', select_cl_id,
      )
      $("#contactlist").select2({
      ajax: {
          url: "/v1/contactlist",
          type: "POST",
          dataType: 'json',
          delay: 250,
          data: function (params) {
             return {
                _token : $('#token').val(),
                clientid:sessionStorage.getItem('select_cl_id'),
                searchTerm: params.term // search term
             };
          },
          processResults: function (response) {
             return {
                results: response
             };
          },
          cache: true
        }
     });
     getTotalRevenue();
     getTotalAsset();
     clientitemtype();
    });

    $("#contactlist").select2({
      minimumInputLength: 3,
      ajax: {
          url: "/v1/contactlist",
          type: "POST",
          dataType: 'json',
          delay: 250,
          data: function (params) {
             return {
                _token : $('#token').val(),
                clientid:sessionStorage.getItem('select_cl_id'),
                searchTerm: params.term // search term
             };
          },
          processResults: function (response) {
             return {
                results: response
             };
          },
          cache: true
        }
    });

    $('#contactlist').on('select2:select', function (e) {
      $('#contactlocation').val(null).trigger('change');
      var select_contact_id = e.params.data.id;
      sessionStorage.setItem(
        'select_contact_id', select_contact_id,
      )
      $("#contactlocation").select2({
      ajax: {
          url: "/v1/contactlocation",
          type: "POST",
          dataType: 'json',
          delay: 250,
          data: function (params) {
             return {
                _token : $('#token').val(),
                clientid:sessionStorage.getItem('select_cl_id'),
                contactid:sessionStorage.getItem('select_contact_id'),
                searchTerm: params.term // search term
             };
          },
          processResults: function (response) {
             return {
                results: response
             };
          },
          cache: true
        }
     });
     clientitemtype();
    });

    $("#contactlocation").select2({
        minimumInputLength: 3,
        ajax: {
          url: "/v1/contactlocation",
          type: "POST",
          dataType: 'json',
          delay: 250,
          data: function (params) {
             return {
                _token : $('#token').val(),
                clientid:sessionStorage.getItem('select_cl_id'),
                contactid:sessionStorage.getItem('select_contact_id'),
                searchTerm: params.term // search term
             };
          },
          processResults: function (response) {
             return {
                results: response
             };
          },
          cache: true
        }
    });

    $('#contactlocation').on('select2:select', function (e) {
      var select_location_id = e.params.data.id;
      sessionStorage.setItem(
        'select_location_id', select_location_id,
      )
      clientitemtype();
    });

    $("#clientiteamtype").select2();

    $('#clientiteamtype').on('select2:select', function (e) {
      var select_item_type_id = e.params.data.id;
      sessionStorage.setItem(
        'select_item_type_id', select_item_type_id,
      )
    });

    //Date range picker
    $('#reservation').daterangepicker();
    /*START Load Estimation propsal in datatable*/
    $('#example1').DataTable().destroy();
    var table = $('#example1').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "v1/getEstimateProposal",
        type: "POST",
        async: false,
        data: function (d) {
          d.startdate = $("#reservation").data('daterangepicker').startDate.format('YYYY-MM-DD');
          d.enddate = $("#reservation").data('daterangepicker').endDate.format('YYYY-MM-DD');
          d.select_cl_id = sessionStorage.getItem('select_cl_id');
          d.select_location_id = sessionStorage.getItem('select_location_id');
          d.select_contact_id = sessionStorage.getItem('select_contact_id');
          d.select_territory_id = sessionStorage.getItem('select_territory_id');
          d.select_item_type_id = sessionStorage.getItem('select_item_type_id');
          d._token = $('#token').val();
        }
      },
      columns: [
        { data: 'est_no', name: 'No.',orderable: true, searchable: true },
        { data: 'office', name: 'Territory',orderable: true, searchable: true },
        { data: 'est_date', name: 'Date', orderable: true, searchable: true },
        { data: 'company', name: 'Client', orderable: true, searchable: true },
        { data: 'loc_street_address', name: 'Location', orderable: true, searchable: true },
        { data: 'first', name: 'Contact', orderable: true, searchable: true },
        { data: 'ec_rate', name: 'ec_rate', orderable: true, searchable: true },
      ],
      columnDefs: [{
        "defaultContent": "-",
        "targets": "_all"
      }],
      rowCallback: function(row, data, index){
        if(data["ec_rate"] != "0.00"){
            $('td', row).css('background-color', '#99ab8c');
        }
      }
    });

  /*  $('#reservation').on('hide.daterangepicker', function (ev, picker) {
      table.draw();
      var startdate = $("#reservation").data('daterangepicker').startDate.format('YYYY-MM-DD');
      var enddate = $("#reservation").data('daterangepicker').endDate.format('YYYY-MM-DD');
      myMap1(startdate,enddate);

      barchart(startdate,enddate);
    });*/
    $("#SearchEstimation").on("click", function() {
      
      table.draw();
      var startdate = $("#reservation").data('daterangepicker').startDate.format('YYYY-MM-DD');
      var enddate = $("#reservation").data('daterangepicker').endDate.format('YYYY-MM-DD');
      $("#spinner-div").show();
      //getlistmetercount();
      //getlistmeterimages();
      myMap1(startdate,enddate);
      barchart(startdate,enddate);
      BarChartTotalRevenue(startdate,enddate);
      getTotalRevenueT();
      getTotalAssetT();
      //sessionStorage.removeItem('select_item_type_id');

      $("#spinner-div").hide();
    });  
    /*END Load Estimation propsal in datatable*/
    $("#WinReload").on("click", function() {
      location.reload();
    });  

  
    $('#datacollection').DataTable({
      seraching: true,
    });

    $("#condition").select2();

    $("#asset").select2();
    $('#asset').on('select2:select', function (e) {
      var data = $(".select2 option:selected").val();
      if(data == 1){
        $("#addnewasset").show();
      }else{
        $("#addnewasset").hide();
      }
    });   

    
    $("#status").select2();
    $('#status').on('select2:select', function (e) {
      var data = $(".select3 option:selected").val();
      if(data == 1){
        $("#addnewstatus").show();
      }else{
        $("#addnewstatus").hide();
      }
    });   

    $("#action").select2();
    $('#action').on('select2:select', function (e) {
      var data = $(".select4 option:selected").val();
      if(data == 1){
        $("#addnewaction").show();
      }else{
        $("#addnewaction").hide();
      }
    });

    $("#client").select2();
    $('#client').on('select2:select', function (e) {
      var data = $(".select5 option:selected").val();
      if(data == 1){
        $("#addnewclient").show();
      }else{
        $("#addnewclient").hide();
      }
    });
});
/* END BAR CHART */

/* START OnLoad show default lat and lng in GoogleMap */
let curr_lat = 43.651070
let curr_lng = -79.347015
function myMap() {
  var mapProp= {
    center:new google.maps.LatLng(curr_lat,curr_lng),
    zoom:8
  };
  var map = new google.maps.Map(document.getElementById("map"),mapProp);
}
/* END OnLoad show default lat and lng in GoogleMap */

/*START On Select ItemType load map markers*/
function myMap1(startdate,enddate) {

  var mapOptions7 = {
    center: new google.maps.LatLng(curr_lat,curr_lng),
    zoom: 8
  };

  var map7 = new google.maps.Map(document.getElementById('map'), mapOptions7);
  var lat_lng = new Array();
  var latlngbounds = new google.maps.LatLngBounds();

  var startdate = startdate;
  var enddate = enddate;
  var select_cl_id = sessionStorage.getItem('select_cl_id');
  var select_location_id = sessionStorage.getItem('select_location_id');
  var select_contact_id = sessionStorage.getItem('select_contact_id');
  var select_territory_id = sessionStorage.getItem('select_territory_id');
  var select_item_type_id = sessionStorage.getItem('select_item_type_id');

  var _token = $('#token').val();
  $.ajax({
      url: "v1/getGoogleMap",
      type: "POST",
      async: false,
      dataType: "JSON",
      data: { 
        _token: _token, 
        startdate: startdate,
        enddate: enddate,
        select_territory_id: select_territory_id,
        select_cl_id: select_cl_id,
        select_location_id: select_location_id,
        select_contact_id: select_contact_id,
        select_item_type_id: select_item_type_id, 
      },
      success: function(markers7) {
        var countProposal = markers7.length;
          for (i = 0; i < markers7.length; i++) {
            var data = markers7[i]
            var myLatlng7 = new google.maps.LatLng(data.lat, data.lng);
            lat_lng.push(myLatlng7);
            var marker7 = new google.maps.Marker({
                  position: myLatlng7,
                  map: map7,
                  title: data.title,
                  animation: google.maps.Animation.DROP
            });
            latlngbounds.extend(marker7.position);
        }
        map7.fitBounds(latlngbounds);
        //(optional) restore the zoom level after the map is done scaling
        var listener = google.maps.event.addListener(map7, "idle", function () {
            map7.setZoom(10);
            google.maps.event.removeListener(listener);
        });
      }
  });
}
/*END On Select ItemType load map markers*/

/*START on selct ItemType show data in chart*/
var barGraph;
function barchart(startdate,enddate){
  var startdate = startdate;
  var enddate = enddate;
  var select_cl_id = sessionStorage.getItem('select_cl_id');
  var select_location_id = sessionStorage.getItem('select_location_id');
  var select_contact_id = sessionStorage.getItem('select_contact_id');
  var select_item_type_id = sessionStorage.getItem('select_item_type_id');
  var select_territory_id = sessionStorage.getItem('select_territory_id');

  var _token = $('#token').val();
  $.ajax({
      url: "v1/getBarChart",
      type: "POST",
      async: false,
      dataType: "JSON",
      data: { 
        _token: _token, 
        startdate: startdate,
        enddate: enddate,
        select_territory_id: select_territory_id,
        select_cl_id: select_cl_id,
        select_location_id: select_location_id,
        select_contact_id: select_contact_id,
        select_item_type_id: select_item_type_id, 
      },
      success: function(data) {
        $("#barChart").hide();
        $("#barChartOnAjax").show();
        
        data = JSON.parse(data);
        var monthno = [];
        var countno = [];

        $.each(data, function(i, item) {
            monthno.push(data[i].monthno);
            countno.push(data[i].countno);
        });

        var chartdata = {
          labels: monthno,
          datasets : [
            {
              label: 'Number of Assets per Month',
              backgroundColor: '#66bd9d',
              borderColor: '#66bd9d',
              hoverBackgroundColor: '#10523a',
              hoverBorderColor: '#10523a',
              data: countno
            }
          ]
        };
        if (barGraph) {
          barGraph.destroy();
        }

        var ctx = $("#barChartOnAjax");

        barGraph = new Chart(ctx, {
          type: 'bar',
          data: chartdata,
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  callback: function(value) {if (value % 1 === 0) {return addCommas(value);}}
                }
              }]
            }
          }
        });
      }
  });
}
/*END on selct ItemType show data in chart*/

/*START on total revenue per Months */
var barGraph1;
function BarChartTotalRevenue(startdate,enddate){
  var startdate = startdate;
  var enddate = enddate;
  var select_cl_id = sessionStorage.getItem('select_cl_id');
  var select_location_id = sessionStorage.getItem('select_location_id');
  var select_contact_id = sessionStorage.getItem('select_contact_id');
  var select_item_type_id = sessionStorage.getItem('select_item_type_id');
  var select_territory_id = sessionStorage.getItem('select_territory_id');

  var _token = $('#token').val();
  $.ajax({
      url: "v1/getBarChartTotalRevenue",
      type: "POST",
      async: false,
      dataType: "JSON",
      data: { 
        _token: _token, 
        startdate: startdate,
        enddate: enddate,
        select_territory_id: select_territory_id,
        select_cl_id: select_cl_id,
        select_location_id: select_location_id,
        select_contact_id: select_contact_id,
        select_item_type_id: select_item_type_id, 
      },
      success: function(data) {
        $("#clientrevenuepermonthAjax").show();
        
        data = JSON.parse(data);
        var monthno = [];
        var countno = [];

        $.each(data, function(i, item) {
            monthno.push(data[i].monthno);
            countno.push(data[i].countno);
        });

        var chartdata = {
          labels: monthno,
          datasets : [
            {
              label: 'Total Revenue per Client per Month',
              backgroundColor: '#66bd9d',
              borderColor: '#66bd9d',
              hoverBackgroundColor: '#10523a',
              hoverBorderColor: '#10523a',
              data: countno,
            }
          ]
        };
        if (barGraph1) {
          barGraph1.destroy();
        }

        var ctx = $("#clientrevenuepermonthAjax");

        barGraph1 = new Chart(ctx, {
          type: 'bar',
          data: chartdata,
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  callback: function(value) {if (value % 1 === 0) {return '$'+addCommas(value);}}
                }
              }]
            }
          }
        });
      }
  });
}
/*END on total revenue per Months */

function clientitemtype(){
  $("#clientiteamtype").select2({
  ajax: {
      url: "/v1/clientiteamtype",
      type: "POST",
      dataType: 'json',
      delay: 250,
      data: function (params) {
         return {
            searchTerm: params.term, // search term
            startdate: $("#reservation").data('daterangepicker').startDate.format('YYYY-MM-DD'),
            enddate: $("#reservation").data('daterangepicker').endDate.format('YYYY-MM-DD'),
            select_cl_id: sessionStorage.getItem('select_cl_id'),
            select_location_id: sessionStorage.getItem('select_location_id'),
            select_contact_id: sessionStorage.getItem('select_contact_id'),
            select_territory_id: sessionStorage.getItem('select_territory_id'),
            select_item_type_id: sessionStorage.getItem('select_item_type_id'),
            _token: $('#token').val()
         };
      },
      processResults: function (response) {
         return {
            results: response
         };
      },
      cache: true
    }
 });
}

function getlistmeterimages() {
  var _token = $('#token').val();
  var select_cl_id = sessionStorage.getItem('select_cl_id');
  var select_location_id = sessionStorage.getItem('select_location_id');
  var select_contact_id = sessionStorage.getItem('select_contact_id');
  var select_territory_id = sessionStorage.getItem('select_territory_id');
  var select_item_type_id = sessionStorage.getItem('select_item_type_id');
  var startdate = $("#reservation").data('daterangepicker').startDate.format('YYYY-MM-DD');
  var enddate = $("#reservation").data('daterangepicker').endDate.format('YYYY-MM-DD');

  $.ajax({
      url: "/v1/listmeter",
      type: "POST",
      async: false,
      data: { 
        _token: _token, 
        select_cl_id: select_cl_id,
        select_location_id: select_location_id,
        select_contact_id: select_contact_id,
        select_territory_id: select_territory_id,
        select_item_type_id: select_item_type_id,
        startdate: startdate, 
        enddate: enddate 
      },
      dataType: "JSON",
      success: function(data) {
          $("#livenumer").show();
          $("#recentphoto").show();
          $("#imagesdata").show();
          var html="";
          html += '<div class="row">';
          $.each(data, function(i, item) {
              if(item.filename != null){
                html += '<div class="col-md-3">';
                  html += '<div class="thumbnail">';
                    html += "<img class='img-thumbnail' src='https://clickoff.goodbyegraffiti.com/"+item.filename+"' alt='Lights' style='width:100%;height:200px;'>";
                  html += '</div>';
                html += '</div>';
              }
          });
          html += '</div>';
          $("#imagesdata").html(html);
          
      }
  });
}

function getlistmetercount() {
  var _token = $('#token').val();
  var select_cl_id = sessionStorage.getItem('select_cl_id');
  var select_location_id = sessionStorage.getItem('select_location_id');
  var select_contact_id = sessionStorage.getItem('select_contact_id');
  var select_territory_id = sessionStorage.getItem('select_territory_id');
  var select_item_type_id = sessionStorage.getItem('select_item_type_id');
  var startdate = $("#reservation").data('daterangepicker').startDate.format('YYYY-MM-DD');
  var enddate = $("#reservation").data('daterangepicker').endDate.format('YYYY-MM-DD');

  $.ajax({
      url: "/v1/listmetercount",
      type: "POST",
      async: false,
      data: { 
        _token: _token, 
        select_cl_id: select_cl_id,
        select_location_id: select_location_id,
        select_contact_id: select_contact_id,
        select_territory_id: select_territory_id,
        select_item_type_id: select_item_type_id,
        startdate: startdate, 
        enddate: enddate 
      },
      dataType: "JSON",
      success: function(data) {

          var html="";
          $.each(data, function(i, item) {
              if(item.name != null){
                html += '<div class="form-group row text-center">';
                  html += '<div class="col-sm-12">';
                    html += '<label class="col-sm-8 col-form-label col-form-label-lg btn btn-success green-btn font-weight-normal">'+item.countitemtype +' '+ item.name +'</label>';
                  html += '</div>';
                html += '</div>';
              }
          });
          $("#livenocount").html(html);
          
      }
  });
}

function getTotalRevenue(){
  var _token = $('#token').val();
  var select_cl_id = sessionStorage.getItem('select_cl_id');
  var select_territory_id = sessionStorage.getItem('select_territory_id');
  var startdate = $("#reservation").data('daterangepicker').startDate.format('YYYY-MM-DD');
  var enddate = $("#reservation").data('daterangepicker').endDate.format('YYYY-MM-DD');

  $.ajax({
      url: "/v1/getTotalRevenue",
      type: "POST",
      async: false,
      data: { 
        _token: _token, 
        select_territory_id:select_territory_id,
        clientid: select_cl_id,
        startdate: startdate, 
        enddate: enddate 
      },
      dataType: "JSON",
      success: function(data) {
        $("#revenue").html(data[0].totalrevenue);
      }
  });
}
function getTotalAsset(){
  var _token = $('#token').val();
  var select_cl_id = sessionStorage.getItem('select_cl_id');
  var select_territory_id = sessionStorage.getItem('select_territory_id');
  var startdate = $("#reservation").data('daterangepicker').startDate.format('YYYY-MM-DD');
  var enddate = $("#reservation").data('daterangepicker').endDate.format('YYYY-MM-DD');

  $.ajax({
      url: "/v1/getTotalAsset",
      type: "POST",
      async: false,
      data: { 
        _token: _token, 
        select_territory_id:select_territory_id,
        clientid: select_cl_id,
        startdate: startdate, 
        enddate: enddate 
      },
      dataType: "JSON",
      success: function(data) {
        $("#assets").html(data[0].totalasset);
      }
  });
}

function getTotalRevenueT(){
  var _token = $('#token').val();
  var select_cl_id = sessionStorage.getItem('select_cl_id');
  var select_location_id = sessionStorage.getItem('select_location_id');
  var select_contact_id = sessionStorage.getItem('select_contact_id');
  var select_territory_id = sessionStorage.getItem('select_territory_id');
  var select_item_type_id = sessionStorage.getItem('select_item_type_id');
  var startdate = $("#reservation").data('daterangepicker').startDate.format('YYYY-MM-DD');
  var enddate = $("#reservation").data('daterangepicker').endDate.format('YYYY-MM-DD');

  $.ajax({
      url: "/v1/getTotalRevenueT",
      type: "POST",
      async: false,
      data: { 
        _token: _token, 
        select_cl_id: select_cl_id,
        select_location_id: select_location_id,
        select_contact_id: select_contact_id,
        select_territory_id: select_territory_id,
        select_item_type_id: select_item_type_id,
        startdate: startdate, 
        enddate: enddate 
      },
      dataType: "JSON",
      success: function(data) {
        
        if(data.length !== undefined){
          $("#revenue_btm").html(data[0].totalrevenue);
          if(select_item_type_id){
            $("#showassetdetails").show();
          }else{
            $("#showassetdetails").hide();
          }
        }      
      }
  });
}
function getTotalAssetT(){
  var _token = $('#token').val();
  var select_cl_id = sessionStorage.getItem('select_cl_id');
  var select_location_id = sessionStorage.getItem('select_location_id');
  var select_contact_id = sessionStorage.getItem('select_contact_id');
  var select_territory_id = sessionStorage.getItem('select_territory_id');
  var select_item_type_id = sessionStorage.getItem('select_item_type_id');
  var startdate = $("#reservation").data('daterangepicker').startDate.format('YYYY-MM-DD');
  var enddate = $("#reservation").data('daterangepicker').endDate.format('YYYY-MM-DD');

  $.ajax({
      url: "/v1/getTotalAssetT",
      type: "POST",
      async: false,
      data: { 
        _token: _token, 
        select_cl_id: select_cl_id,
        select_location_id: select_location_id,
        select_contact_id: select_contact_id,
        select_territory_id: select_territory_id,
        select_item_type_id: select_item_type_id,
        startdate: startdate, 
        enddate: enddate 
      },
      dataType: "JSON",
      success: function(data) {
        $("#assets_btm").html(data[0].totalasset)
      }
  });
}
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
var x = document.getElementById("demo");
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  $("#latitude").val(position.coords.latitude);
  $("#longitude").val(position.coords.longitude);
  loadaddress(position.coords.latitude,position.coords.longitude);
}
function loadaddress(latitude,longitude){
  var token =$('meta[name="csrf-token"]').attr('content');
  $.ajax({
    url: "/v1/location",
    type: "POST",
    dataType: 'json',
    data:{"latitude":latitude,"longitude":longitude,"_token":token},
    cache:!1,
    success: function(data){
      $("#autoaddress").val(data);
    }
    
  });
}