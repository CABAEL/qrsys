
// -- Bar Chart 
var applicants_data = document.getElementById("applicants");

var active_employees_data = document.getElementById("active_employees");


var currentTime = new Date();
var Onloadyear = currentTime.getFullYear();
$('#applicant_year').val(Onloadyear);
$('#activeEmployeeYr').val(Onloadyear);

show_loader();

$.ajax({
  url: base_url("applicant_chart/"+Onloadyear),
  type: 'get', 
  dataType: 'json',
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
  },
  success: function(response) {
    console.log(response);
    var myLineChart1 = new Chart(applicants_data, {
      type: 'bar',
      data: {
        labels: ["January"
        , "February"
        , "March"
        , "April"
        , "May"
        , "June"
        ,"July"
        ,"August"
        ,"September"
        ,"October"
        ,"November",
        ,"December"
      ],
        datasets: [{
          label: "Hired",
          backgroundColor: "rgba(2,117,216,1)",
          borderColor: "rgba(2,117,216,1)",
          data:response.hired,
        },
        {
          label: "Pending",
          backgroundColor: "rgba(87, 10, 19)",
          borderColor: "rgba(38, 38, 1,1)",
          data: response.pending,
        }],
      },
      options: {
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: true
            },
            ticks: {
              maxTicksLimit: 12
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: 100,
              maxTicksLimit: 10
            },
            gridLines: {
              display: true
            }
          }],
        },
        legend: {
          display: true
        }
      }
    });
    hide_loader();
  },
  error: function(e) {

  }
});



$.ajax({
  url: base_url("active_employee/"+Onloadyear),
  type: 'get', 
  dataType: 'json',
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
  },
  success: function(response) {
    //console.log(response);

    var  jan,feb,mar,apr,may,jun,jul,aug,sep,oct,nov,dec;
    jan = feb = mar = apr = may = jun = jul = aug = sep = oct = nov = dec =  0;
    
    var data = [];

    $.each(response,function(k,v) {
      var total_per_month = v.months;
      var target = 15;
      data[0] = jan += (v.months[0] >= target) ? 1 : 0 ; 
      data[1] = feb += (v.months[1] >= target) ? 1 : 0 ; 
      data[2] = mar += (v.months[2] >= target) ? 1 : 0 ; 
      data[3] = apr += (v.months[3] >= target) ? 1 : 0 ; 
      data[4] = may += (v.months[4] >= target) ? 1 : 0 ; 
      data[5] = jun += (v.months[5] >= target) ? 1 : 0 ; 
      data[6] = jul += (v.months[6] >= target) ? 1 : 0 ; 
      data[7] = aug += (v.months[7] >= target) ? 1 : 0 ; 
      data[8] = sep += (v.months[8] >= target) ? 1 : 0 ; 
      data[9] = oct += (v.months[9] >= target) ? 1 : 0 ; 
      data[10] = nov += (v.months[10] >= target) ? 1 : 0 ; 
      data[11] = dec += (v.months[11] >= target) ? 1 : 0 ; 

    });

    var active_employee = data;

    console.log(active_employee);

    var myLineChart = new Chart(active_employees_data, {
      type: 'bar',
      data: {
        labels: ["January"
        , "February"
        , "March"
        , "April"
        , "May"
        , "June"
        ,"July"
        ,"August"
        ,"September"
        ,"October"
        ,"November",
        ,"December"
      ],
        datasets: [
        {
          label: "Active",
          backgroundColor: "#ace",
          borderColor: "rgba(38, 38, 1,1)",
          data:active_employee,
        }],
      },
      options: {
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: true
            },
            ticks: {
              maxTicksLimit: 12
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: 100,
              maxTicksLimit: 10
            },
            gridLines: {
              display: true
            }
          }],
        },
        legend: {
          display: false
        }
      }
    });


    hide_loader();
  },
  error: function(e) {

  }
});







$(document).on('click','#activeEmployeeBtn',function () {
  var clickyearvalue = $('#activeEmployeeYr').val();
  $.ajax({
    url: base_url("active_employee/"+clickyearvalue),
    type: 'get', 
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(response) {
      //console.log(response);
  
      var  jan,feb,mar,apr,may,jun,jul,aug,sep,oct,nov,dec;
      jan = feb = mar = apr = may = jun = jul = aug = sep = oct = nov = dec =  0;
      
      var data = [];
  
      $.each(response,function(k,v) {
        var total_per_month = v.months;
        var target = 15;
        data[0] = jan += (v.months[0] >= target) ? 1 : 0 ; 
        data[1] = feb += (v.months[1] >= target) ? 1 : 0 ; 
        data[2] = mar += (v.months[2] >= target) ? 1 : 0 ; 
        data[3] = apr += (v.months[3] >= target) ? 1 : 0 ; 
        data[4] = may += (v.months[4] >= target) ? 1 : 0 ; 
        data[5] = jun += (v.months[5] >= target) ? 1 : 0 ; 
        data[6] = jul += (v.months[6] >= target) ? 1 : 0 ; 
        data[7] = aug += (v.months[7] >= target) ? 1 : 0 ; 
        data[8] = sep += (v.months[8] >= target) ? 1 : 0 ; 
        data[9] = oct += (v.months[9] >= target) ? 1 : 0 ; 
        data[10] = nov += (v.months[10] >= target) ? 1 : 0 ; 
        data[11] = dec += (v.months[11] >= target) ? 1 : 0 ; 
  
      });
  
      var active_employee = data;
  
      console.log(active_employee);
  
      var myLineChart = new Chart(active_employees_data, {
        type: 'bar',
        data: {
          labels: ["January"
          , "February"
          , "March"
          , "April"
          , "May"
          , "June"
          ,"July"
          ,"August"
          ,"September"
          ,"October"
          ,"November",
          ,"December"
        ],
          datasets: [
          {
            label: "Active",
            backgroundColor: "#ace",
            borderColor: "rgba(38, 38, 1,1)",
            data:active_employee,
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'month'
              },
              gridLines: {
                display: true
              },
              ticks: {
                maxTicksLimit: 12
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: 100,
                maxTicksLimit: 10
              },
              gridLines: {
                display: true
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });
  
  
      hide_loader();
    },
    error: function(e) {
  
    }
  });
});

$(document).on('click','#ApplicantChart',function () {
  var clickyear = $('#applicant_year').val();
  show_loader();
  $.ajax({
    url: base_url("applicant_chart/"+clickyear),
    type: 'get', 
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(response) {

      var myLineChart2 = new Chart(applicants_data, {
        type: 'bar',
        data: {
          labels: ["January"
          , "February"
          , "March"
          , "April"
          , "May"
          , "June"
          ,"July"
          ,"August"
          ,"September"
          ,"October"
          ,"November",
          ,"December"
        ],
          datasets: [{
            label: "Hired",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: response.hired,
          },
          {
            label: "Pending",
            backgroundColor: "rgba(87, 10, 19)",
            borderColor: "rgba(38, 38, 1,1)",
            data: response.pending,
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'month'
              },
              gridLines: {
                display: true
              },
              ticks: {
                maxTicksLimit: 12
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: 100,
                maxTicksLimit: 10
              },
              gridLines: {
                display: true
              }
            }],
          },
          legend: {
            display: true
          }
        }
      });
      hide_loader();

    },
    error: function(e) {

    }
  });

})



var year2 = $('#activeEmployeeYr').val();
$.ajax({
  url: base_url("active_employee/"+year2),
  type: 'get', 
  dataType: 'json',
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
  },
  success: function(response) {

  },
  error: function(e) {

  }
});