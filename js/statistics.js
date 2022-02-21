const UPDATE = 0;
const DAY = 0;
const MONTH = 1;
const YEAR = 2;

const data = {
    action: [UPDATE],
    period: [YEAR],
    year: [2019]
}
$(document).ready(function () {
    //TODO: set period value and year after selection in html, to get data of selected period format
    //-----HERE ADD THE BELOW THINGS----

    var dataChart;
    $.post("utils/manage-statistics.php", data,
        function (data,status) {
            console.log(data);
            dataChart = JSON.parse(data);
            
            var labelPeriod = [];
            var valueCashIn = [];
            var valueCountOrder = [];

            for(var i = 0; i < dataChart.length; i++){
                valueCashIn.push(dataChart[i].Total);
                valueCountOrder.push(dataChart[i].Count);
                labelPeriod.push(dataChart[i].Month);
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



