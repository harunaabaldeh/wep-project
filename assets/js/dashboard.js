$(function () {
    'use strict'
  

    // use ajax to get the category data from the data base.
    // The goal is to graph categories against total businesses
    // labels? the categories
    // data ? verified, unverified
    let test = ''
		$.ajax({
			type: "POST",
			url: "../includes/handlers/graphs.php",
			data: {'type': 1},
			dataType: 'json',
			asyn: true,
			success: function(response){
      //  console.log(response)
      let categoryNames = Object.keys(response)
        
      let temp_data = Object.values(response)




      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }
    
      var mode      = 'index'
      var intersect = true
      // backgroundColor: ['rgb(147,130,250)', 'rgb(245,190,125)', 'rgb(124,208,252)','rgb(179,247,109)', ],
    
      var $categoriesChart = $('#categories-chart')
      var categoriesChart  = new Chart($categoriesChart, {
        type   : 'bar',
        data   : {
          labels  : categoryNames, // labels should be the category names
          datasets: [
            {
              backgroundColor: ['rgb(54,128,174, 0.8)', 'rgb(109,91,151, 0.8)', 'rgb(244,178,58, 0.8)','rgb(215,64,97, 0.8)',
             'rgb(237,122,40, 0.8)', 'rgb(182,107,163, 0.8)', 'rgb(210,179,86, 0.8)', 'rgb(197,145,105, 0.8)'],
              borderColor    : '#007bff',
              data           : temp_data
            },
            
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips           : {
            mode     : mode,
            intersect: intersect
          },
          hover              : {
            mode     : mode,
            intersect: intersect
          },
          legend             : {
            display: false
          },
          scales             : {
            yAxes: [{
              // display: false,
              gridLines: {
                display      : true,
                lineWidth    : '4px',
                color        : 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: {
                beginAtZero: true,
                stepSize: 1,
              },
            }],
            xAxes: [{
              display  : true,
              gridLines: {
                display: false
              },
              ticks    : ticksStyle
            }]
          }
        }
      })
    





        }


		});


    // Donut
		$.ajax({
			type: "POST",
			url: "../includes/handlers/graphs.php",
			data: {'type': 2},
			dataType: 'json',
			asyn: true,
			success: function(response){
      //  console.log(response)
      // Donut Chart
      var pieChartCanvas = $('#users-chart').get(0).getContext('2d')
      var pieData        = {
        labels: Object.keys(response),
        datasets: [
          {
            data: Object.values(response),
            backgroundColor : ['rgb(146,199,73)', 'rgb(221,81,67, 0.8)', 'rgb(244,209,97)'],
          }
        ]
      }
      var pieOptions = {
        legend: {
          display: false
        },
        maintainAspectRatio : false,
        responsive : true,
      }


      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: pieData,
        options: pieOptions      
      });



      }


		});




		$.ajax({
			type: "POST",
			url: "../includes/handlers/graphs.php",
			data: {'type': 3},
			dataType: 'json',
			asyn: true,
			success: function(response){
      //  console.log(response)
      // Sales graph chart
      var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d');
      //$('#revenue-chart').get(0).getContext('2d');

      var salesGraphChartData = {
        labels  : Object.keys(response),
        datasets: [
          {
            
            fill                : false,
            borderWidth         : 2,
            lineTension         : 0,
            spanGaps : true,
            borderColor         : 'rgb(231,113,34)',
            pointRadius         : 3,
            pointHoverRadius    : 7,
            pointColor          : 'rgb(231,113,34)',
            pointBackgroundColor: 'rgb(231,113,34)',
            data                : Object.values(response)
          }
        ]
      }

      var salesGraphChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
          display: false,
        },
        scales: {
          xAxes: [{
            ticks : {
              fontColor: '#efefef',
            },
            gridLines : {
              display : false,
              color: '#efefef',
              drawBorder: false,
            }
          }],
          yAxes: [{
            ticks : {
              stepSize: 10,
              fontColor: '#efefef',
            },
            gridLines : {
              display : true,
              color: '#efefef',
              drawBorder: false,
            }
          }]
        }
      }

      // This will get the first returned node in the jQuery collection.
      var salesGraphChart = new Chart(salesGraphChartCanvas, { 
          type: 'line', 
          data: salesGraphChartData, 
          options: salesGraphChartOptions
        }
      )


        }


		});





    $('.daterange').daterangepicker({
      ranges   : {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate  : moment()
    }, function (start, end) {
      window.alert('You chose: ' + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    })


  /* jQueryKnob */
  $('.knob').knob()

  // The Calender
  $('#calendar').datetimepicker({
    format: 'L',
    inline: true
  })

  // SLIMSCROLL FOR CHAT WIDGET
  $('#chat-box').overlayScrollbars({
    height: '250px'
  })






    
  })
  