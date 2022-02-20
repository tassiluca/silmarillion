const UPDATE = 0;
const DAY = 0;
const MONTH = 1;
const YEAR = 2;

const data = {
    action: [UPDATE],
    period: [MONTH]
}
$(document).ready(function () {
    //TODO: set period value after selection in html, to get data of selected period format
    //-----HERE ADD THE BELOW THINGS----
    var dataChart;
    $.post("utils/manage-statistics.php", data,
        function (data,status) {
            dataChart = JSON.parse(data);
            
            var labelPeriod = [];
            var valueCashIn = [];
            var valueCountOrder = [];

            for(var i = 0; i < dataChart['monthIn'].length; i++){
                valueCashIn.push(dataChart['monthIn'][i].Total);
                labelPeriod.push(dataChart['monthIn'][i].Month);
            }
            for(var i = 0; i < dataChart['countOrder'].length; i++){
                valueCountOrder.push(dataChart['countOrder'][i].Count);
            }
            updateChart("collChart",labelPeriod,valueCashIn,"Incassi mensili");
            updateChart("orderChart",labelPeriod,valueCountOrder,"Ordini mensili");
        });

        function updateChart(elementId,label,value,description){
            new Chart(elementId, {
                type: "bar",
                data: {
                  labels: label,
                  datasets: [{
                    backgroundColor: '#70bfff',
                    data: value
                  }]
                },
                options: {
                  legend: {display: false},
                  title: {
                    display: true,
                    text: description
                  }
                }
              });
        }
});



