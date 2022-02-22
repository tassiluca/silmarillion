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
function createEmptyChart(elementId){
    return new Chart(elementId, {
        type: "bar",
        data: {
        labels: [],
        datasets: [{
            backgroundColor: '#70bfff',
            data: []
        }]
        },
        options: {
        legend: {display: false},
        title: {
            display: true,
            text: ''
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
    const collChart = createEmptyChart('collChart');
    const orderChart = createEmptyChart('orderChart');
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

    function refreshData(){
        var viewSelected = $("aside > div > div > ul >li > input:checked").val();
        var dateSelected = document.getElementById("year_selector").value;
        requestData(viewSelected,dateSelected);
    }
/**
 * Request json data to be shown in charts
 * @param {int} periodView 
 * @param {int} year 
 */
    function requestData(periodView,year){
        data['period']= [parseInt(periodView)];
        data['year']= [parseInt(year)];
        $.post("utils/manage-statistics.php", data, 
            function (data,status) {
                var dataChart = JSON.parse(data);
                var labelPeriod = [];
                var valueCashIn = [];
                var valueCountOrder = [];
                var title = '';

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
            updateChart(collChart,labelPeriod,valueCashIn,"Incassi " + title);
            updateChart(orderChart,labelPeriod,valueCountOrder,"Ordini " + title);
        });
    }
/**
 * Update charts with all info from param
 * @param {*} chartObj Chart obj to be updated
 * @param {array} labels array of labels, asix-x
 * @param {array} values array of values, asix-y
 * @param {string} description Title of chart
 */
    function updateChart(chartObj,labels,values,description){
        values.forEach(val => {
            chartObj.data.datasets.forEach((dataset) => {
                dataset.data.push(val);
            });
        });
        chartObj.data.labels = labels;
        chartObj.options.title.text = description;
        chartObj.update();
    }
});



