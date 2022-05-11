const DAY = 0;
const MONTH = 1;
const YEAR = 2;

const data = {
    period: [],
    year: []
}
/**
 * Create an empty chart in div container specified by elementId
 * @param {string} elementId 
 * @returns empty chart object
 */
function createChart(elementId,labels,values,description){
    return new Chart(elementId, {
        type: "bar",
        data: {
        labels: labels,
        datasets: [{
            backgroundColor: '#70bfff',
            data: values
        }]
        },
        options: {
        legend: {display: false},
        title: {
            display: true,
            text: description
        },
        scales:{
            y: {
                beginAtZero: true
            }
        }
        }
    });
}


$(document).ready(function () {
    var cashChart = createChart('cashChart',[],[],'');
    var orderChart = createChart('orderChart',[],[],'');
    refreshData();

    $('aside > div > div > ul >li > input').click(function (e) {
        if($(this).attr('value') == YEAR){
            document.getElementById("year_selector").disabled = true;
        }
        else{
            document.getElementById("year_selector").disabled = false;
        }
        refreshData();
    });

    $('aside > div > div > select').change(function (){
        refreshData();
    });

    /**
     * Get selected setting of view mode then refresh charts
     */
    function refreshData(){
        var viewSelected = $("aside > div > div > ul >li > input:checked").val();
        var dateSelected = document.getElementById("year_selector").value;
        requestData(viewSelected,dateSelected);
    }
   
    /**
     * Request json data to be shown in charts
     * @param {int} periodView 
     * @param {int} year
     * @return {array} return an array with all data of charts
     */
    function requestData(periodView,year){
        data['period']= [parseInt(periodView)];
        data['year']= [parseInt(year)];

        var labelPeriod = [];
        var valueCashIn = [];
        var valueCountOrder = [];
        var titleOrder = '';
        var titleCash = '';

        $.post("./engines/manage-statistics.php", data,
            function (data,status) {
                var dataChart = JSON.parse(data);
                
                for(var i = 0; i < dataChart.length; i++){
                    valueCashIn.push(dataChart[i].Total);
                    valueCountOrder.push(dataChart[i].Count);

                    switch(parseInt(periodView)){
                        case DAY:
                            labelPeriod.push(dataChart[i].Day);
                            title = 'Giornalieri anno ' + parseInt(year) ;
                            break;
                        case MONTH:
                            labelPeriod.push(dataChart[i].Month);
                            title = 'Mensili anno ' + parseInt(year) ;
                            break;
                        case YEAR:
                            labelPeriod.push(dataChart[i].Year);
                            title = 'Annuali';
                            break;
                    }
                }
                titleOrder = "Ordini " + title;
                titleCash = "Incassi " + title;
                console.log(valueCashIn);

                orderChart = updateChart(orderChart,'orderChart',labelPeriod,valueCountOrder,titleOrder);
                cashChart = updateChart(cashChart,'cashChart',labelPeriod,valueCashIn,titleCash);
                
        });//end ajax request
    }

    /**
 * Update (remove all data then add new) charts with all info from param
 * @param {*} chartObj Chart obj to be updated
 * @param {array} labels array of labels, asix-x
 * @param {array} values array of values, asix-y
 * @param {string} description Title of chart
 * @return {chartObj} return new chart object
 */
 function updateChart(chartObj,elementId,labels,values,description){
    chartObj.destroy();
    return createChart(elementId,labels,values,description);
}

//-------END DOCUMENT READY-----------//
});