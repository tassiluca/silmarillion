const UPDATE = 0;
const data = {
    action: [UPDATE]
}
$(document).ready(function () {
    //TODO get all data needed
    var dataChart;
    $.post("utils/manage-statistics.php", data,
        function (data,status) {
            dataChart = JSON.parse(data);
            
            var labelMonthIn = [];
            var valueMonthIn = [];
            var valueCountOrder = [];

            for(var i =0; i < dataChart['monthIn'].length; i++){
                valueMonthIn.push(dataChart['monthIn'][i].Total);
                labelMonthIn.push(dataChart['monthIn'][i].Month);
            }
            for(var i =0; i < dataChart['countOrder'].length; i++){
                valueCountOrder.push(dataChart['countOrder'][i].Count);
            }
            updateChart("collChart",labelMonthIn,valueMonthIn,"Incassi annui a mese");
            updateChart("orderChart",labelMonthIn,valueCountOrder,"Ordini Annui per mese");
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



