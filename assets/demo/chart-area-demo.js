


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

var machineId = '';

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
          opt.value = result[i].id;
          opt.innerHTML = result[i].name;
          select.appendChild(opt);
        } 
      }
  });
}

function machineSelected(select){
  machineId = select.value
  console.log(machineId)
  console.log("machineId")
}
function mounthChanged(input){
  if (machineId === '') {
    alert("Please select the machine first")
  }else{
    console.log(input.value + machineId)
  }
}


var ctx = document.getElementById("chartForWeek");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 13"],
    datasets: [{
      label: "Sessions",
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
      data: [10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159, 32651, 31984, 38451],
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
          max: 40000,
          maxTicksLimit: 5
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

var ctx2 = document.getElementById("chartForMonth");
var myLineChart = new Chart(ctx2, {
  type: 'line',
  data: {
    labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 13"],
    datasets: [{
      label: "Sessions",
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
      data: [10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159, 32651, 31984, 38451],
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
          max: 40000,
          maxTicksLimit: 5
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




