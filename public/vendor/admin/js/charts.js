(function($) {
    "use strict";

    let dashboardUsersChart = $('#users-chart');
    if (dashboardUsersChart.length) {
        window.Chart && new Chart(dashboardUsersChart, {
            type: 'line',
            data: {
                labels: chartsConfig.users.labels,
                datasets: [{
                    label: chartsConfig.users.title,
                    data: chartsConfig.users.data,
                    fill: false,
                    pointBackgroundColor: config.colors.primary_color,
                    borderColor: config.colors.primary_color,
                    borderWidth: 2,
                    lineTension: .10,
                    rtl: config.direction == "rtl" ? true : false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            drawBorder: true
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 17
                        }
                    },
                    y: {
                        suggestedMax: chartsConfig.users.max,
                    }
                }
            }
        });
    }

    let dashboardSalesChart = $('#sales-chart');
    if (dashboardSalesChart.length) {
        window.Chart && new Chart(dashboardSalesChart, {
            type: 'bar',
            data: {
                labels: chartsConfig.sales.labels,
                datasets: [{
                    label: chartsConfig.sales.title,
                    data: chartsConfig.sales.data,
                    fill: false,
                    backgroundColor: config.colors.primary_color,
                    borderColor: config.colors.primary_color,
                    borderWidth: 2,
                    lineTension: .10,
                    rtl: config.direction == "rtl" ? true : false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            drawBorder: true
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 17
                        }
                    },
                    y: {
                        suggestedMax: chartsConfig.sales.max,
                        grid: {
                            drawBorder: true
                        }
                    }
                }
            }
        });
    }

    let dashboardViewsChart = $('#views-chart');
    if (dashboardViewsChart.length) {
        window.Chart && new Chart(dashboardViewsChart, {
            type: 'line',
            data: {
                labels: chartsConfig.views.labels,
                datasets: [{
                    label: chartsConfig.views.title,
                    data: chartsConfig.views.data,
                    fill: false,
                    backgroundColor: config.colors.primary_color,
                    borderColor: config.colors.primary_color,
                    borderWidth: 2,
                    lineTension: .10,
                    rtl: config.direction == "rtl" ? true : false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            drawBorder: true
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 17
                        }
                    },
                    y: {
                        suggestedMax: chartsConfig.views.max,
                        grid: {
                            drawBorder: true
                        }
                    }
                }
            }
        });
    }

    let countriesChart = document.getElementById('countries-chart');
    if (countriesChart) {
        google.charts.load('current', { 'packages': ['geochart'] });
        google.charts.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable(chartsConfig.geo.data);
            var options = {
                colorAxis: {
                    colors: [
                        config.colors.primary_color,
                    ]
                },
            };
            var geoChart = new google.visualization.GeoChart(countriesChart);
            geoChart.draw(data, options);
        }
    }
})(jQuery);