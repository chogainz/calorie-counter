@include('layouts.app') 
@section('content') 
@stop
<div class="container container-full-height  d-flex justify-content-center align-items-center">
    <div class="row d-flex justify-content-center">
        <div class="card card-default">
            <div class="form-group">
                <div class="container-fluid">
                    <div class="media_box">
                        <div class="row media_box">
                            <div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Current Calories</th>
                                            <th>Monthly Target</th>
                                            <th>Difference</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$calories_results->monthlyCaloriesTotal}}</td>
                                            <td id="monthly-target"></td>
                                            <td id="monthly-difference"></td>

                                        </tr>
                                    </tbody>
                                </table>
                                <?=$calendar_display?>
                                    <div data-all="{{$calories_results}}" id="allData"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var allDays = document.getElementsByClassName('available-day'),
    monthlyTargetOutput = document.getElementById('monthly-target'),
    differenceOutput = document.getElementById('monthly-difference'),
    calendarHeader = document.getElementById('calendar-header'),

    totalCals = 0,
    count = 0,
    days = [],
    currentDay = "",
    caloriesTarget = 0,
    allData = $('#allData').data('all');

window.addEventListener('load', getAllDays(), false);


function getAllDays(){

    for(date in allData.dailyTotals){

        for(id in allDays){

            if(allDays[id].id == allData.dailyTotals[date][0]['date_consumed']){

                count++;

                validateDay(allData.dailyTotals[date][allData.dailyTotals[date].length - 1]['totalFoodCalories'],
                allData.dailyCaloriesTarget,
                allDays[id]);

            }
        }
    }

    $monthlyTarget = (count * allData.dailyCaloriesTarget);
    monthlyTargetOutput.innerHTML = $monthlyTarget;
    validateMonth(allData.monthlyCaloriesTotal, $monthlyTarget, calendarHeader);

    count = 0;

}

    function validateDay(total,target,id){


        var backgroundC,
            borderC;

        switch(true){
            case total > target:
            backgroundC = "#efdada";
            borderC = "#ebcccc";
            break;
            case total < target:
            backgroundC = "#d0e9c6";
            borderC = "#3c763d";
            break;
            case total == target:
            backgroundC = "white";
            borderC = "#ebcccc";
            break;

        }

        id.style.background = backgroundC;
        id.style.borderColor =  borderC;
    }

    function validateMonth(total,target,id){


        var difference = total - target;

        if(difference > 0 && target!=0){

            backgroundC = "#efdada";

            
            } else {

            backgroundC = "#d0e9c6";
           
            }

        id.style.background = backgroundC
        differenceOutput.innerHTML = difference;
    }
</script>