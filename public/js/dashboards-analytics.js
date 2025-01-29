/**
 * Dashboard Analytics
 */

"use strict";

(function () {
    let cardColor, headingColor, axisColor, shadeColor, borderColor;

    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;

    // Total WO Chart - Bar Chart
    // --------------------------------------------------------------------
    var options = {
        series: [
            {
                name: "Not Started",
                data: notStartedData,
            },
            {
                name: "Progress",
                data: inProgressData,
            },
            {
                name: "Finish",
                data: finishData,
            },
        ],
        chart: {
            type: "bar",
            height: 350,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "55%",
                endingShape: "rounded",
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
        },
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
        },
        fill: {
            opacity: 1,
        },
    };

    var statusWoChart = new ApexCharts(
        document.querySelector("#statusWoChart"),
        options
    );
    statusWoChart.render();
    // --------------------------------------------------------------------
    // Total Manhours Per WO
    var options = {
        series: [
            {
                name: "Operator 1",
                data: [44, 55, 41, 67, 22, 43],
            },
            {
                name: "Operator 2",
                data: [13, 23, 20, 8, 13, 27],
            },
            {
                name: "Operator 3",
                data: [11, 17, 15, 15, 21, 14],
            },
            {
                name: "Operator 4",
                data: [21, 7, 25, 13, 22, 8],
            },
        ],
        chart: {
            type: "bar",
            height: 350,
            stacked: true,
            toolbar: {
                show: true,
            },
            zoom: {
                enabled: true,
            },
        },
        responsive: [
            {
                breakpoint: 480,
                options: {
                    legend: {
                        position: "bottom",
                        offsetX: -10,
                        offsetY: 0,
                    },
                },
            },
        ],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 10,
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: "13px",
                            fontWeight: 900,
                        },
                    },
                },
            },
        },
        xaxis: {
            categories: ["WO 1", "WO 2", "WO 3", "WO 4", "WO 5", "WO 6"],
        },
        legend: {
            position: "right",
            offset: 40,
        },
        fill: {
            opacity: 1,
        },
    };

    var manhoursWoChart = new ApexCharts(
        document.querySelector("#manhoursWoChart"),
        options
    );
    manhoursWoChart.render();
    // --------------------------------------------------------------------
    // Employees Statistics Chart
    // --------------------------------------------------------------------
    const chartEmployeesStatistics = document.querySelector(
        "#employeesStatisticsChart"
    ),
        employeesChartConfig = {
            chart: {
                height: 200,
                width: 200,
                type: "pie",
            },
            labels: ["Finish", "Active", "Inactive"],
            series: [totalFinishEmployees, totalRunEmployees, totalStopEmployees],
            colors: [config.colors.success, config.colors.primary, config.colors.danger],
            stroke: {
                width: 2,
                colors: cardColor,
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '14px',
                    fontFamily: 'Helvetica, Arial, sans-serif',
                    fontWeight: 'bold',
                    colors: undefined
                },
                background: {
                  enabled: true,
                  foreColor: '#fff',
                  padding: 7,
                  borderRadius: 5,
                  borderWidth: 1,
                  borderColor: '#fff',
                  opacity: 0.9,
                },
            },
            legend: {
                show: false,
            },
            // grid: {
            //     padding: {
            //         top: 0,
            //         bottom: 0,
            //         right: 15,
            //     },
            // },
            plotOptions: {
                pie: {
                },
            },
        };
    if (
        typeof chartEmployeesStatistics !== undefined &&
        chartEmployeesStatistics !== null
    ) {
        const statisticsChart = new ApexCharts(
            chartEmployeesStatistics,
            employeesChartConfig
        );
        statisticsChart.render();
    }
})();

