


// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

const fp = flatpickr("#monthId", {
  plugins: [
        new monthSelectPlugin({
          shorthand: true, //defaults to false
          dateFormat: "Y-m", //defaults to "F Y"
          altFormat: "F Y", //defaults to "F Y"
          theme: "dark" // defaults to "light"
        })
    ]
});

var ctx = document.getElementById("chartForWeek");
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [],
      datasets: [{
        label: "Count",
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius: 5,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: [],
      }],
    },
    options: {
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false
          },
          ticks: {
            maxTicksLimit: 7
          }
        }],
        yAxes: [{
          ticks: {
            min: 0,
            max: 24,
            ticks: {
              stepSize: 5
            }
          },
          gridLines: {
            color: "rgba(0, 0, 0, .125)",
          }
        }],
      },
      legend: {
        display: false
      }
    }
  });


var machineName = '';
var chartDate = [];
var duplicatedDates = [];
function getAllLabs(){
    select = document.getElementById('labSelect');
    $.ajax({
        url: "../api/laboratory-api.php",
        type: "get",
        context: document.body,
        success: function(result){
            //document.getElementById("collapseNav").innerHTML = '';
            for (var i = 0; i < result.length; i++) {
                var opt = document.createElement('option');
                opt.value = result[i].id;
                opt.innerHTML = result[i].name;
                select.appendChild(opt);
            }

        }
    });
}

function labSelected(select){
  const labId = select.value;
  select = document.getElementById('machineSelect');
  var length = select.options.length;
  for (i = length-1; i >= 0; i--) {
    select.options[i] = null;
  }
  $.ajax({
      url: "../api/getMachinesById/machines-by-lab.php",
      type: "get",
      data: { 
          id: labId
        },
      context: document.body,
      success: function(result){
        var optDefault = document.createElement('option');
          optDefault.selected = 'selected';
          optDefault.disabled = 'disabled';
          optDefault.innerHTML = 'Choose a machine...';
          select.appendChild(optDefault);
        for (var i = 0; i < result.length; i++) {
          var opt = document.createElement('option');
          opt.value = result[i].name;
          opt.innerHTML = result[i].name;
          select.appendChild(opt);
        } 
      }
  });
}

function machineSelected(select){
  machineName = select.value
}

function mounthChanged(input){
  if (machineName === '') {
    alert("Please select the machine first")
  }else{
    $.ajax({
      url: "../api/charts/machine-data.php",
      type: "get",
      data: { 
          machineName: machineName,
          date: input.value
        },
      context: document.body,
      success: function(result){
          for (var i = 0; i < result.length; i++) {
            chartDate[i] = result[i].appointment_date.substring(0,10)
          }

          //let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) !== index)
          //duplicatedDates = [...new Set(findDuplicates(chartDate))]
          const counts = {};
          chartDate.forEach(function (x) { counts[x] = (counts[x] || 0) + 1; });
          renderChart(counts)
          chartDate = []
      }
  });
  }
}
function renderChart(data){
  let valArr = Object.values(data)
  let keyArr = Object.keys(data)
  let chartVal = []
  let chartkey = []
  let objarr = []
  for (var i = 0; i < valArr.length; i++) {
    let obj = Object.create({}); 
    obj.date = keyArr[i]
    obj.value = valArr[i]
    objarr.push(obj) 
  }
  const sortedData = objarr.sort(function(a, b) {
                          var dateA = new Date(a.date), dateB = new Date(b.date);
                          return dateA - dateB;
                      });
  for (var i = 0; i < sortedData.length; i++) {
    chartkey[i] = sortedData[i].date
    chartVal[i] = sortedData[i].value
  }
  for (var i = 0; i < chartVal.length; i++) {
    if (chartVal[i]>24) {
      chartVal[i] = 24
    }
  }
  myLineChart.destroy();
  ctx = document.getElementById("chartForWeek");
  myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: chartkey,
      datasets: [{
        label: "Count",
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius: 5,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: chartVal,
      }],
    },
    options: {
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false
          },
          ticks: {
            maxTicksLimit: 7
          }
        }],
        yAxes: [{
          ticks: {
            min: 0,
            max: 24,
            ticks: {
              stepSize: 5
            }
          },
          gridLines: {
            color: "rgba(0, 0, 0, .125)",
          }
        }],
      },
      legend: {
        display: false
      }
    }
  });
}







