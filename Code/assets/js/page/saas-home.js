"use strict";

var ctx = document.getElementById("all_in_one").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: JSON.parse(trans),
    datasets: [
        {
            label: currency_code,
            borderColor: "#63ed7a",
            backgroundColor: theme_color,
            data: JSON.parse(trans_values)
        },
    ]
  },
  options: {
    maintainAspectRatio: false,
    responsive: true,
    legend: false,
    tooltips: {
      mode: 'index',
      intersect: false,
  },
  }
});

var ctx = document.getElementById("users_chart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    datasets: [{
      data: JSON.parse(users_values),
      backgroundColor: [
        '#63ed7a',
        '#fc544b',
        '#3abaf4',
        theme_color,
      ],
    }],
    labels: [Active, Deactive, Free, Paid],
  },
  options: {
    responsive: true,
    legend: {
      position: 'bottom',
    },
  }
});

var ctx = document.getElementById("users_plan").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: JSON.parse(plans),
    datasets: [{
      label: subscribers,
      data: JSON.parse(plans_values),
      borderWidth: 2,
      backgroundColor: theme_color,
    }]
  },
  options: {
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        gridLines: {
          drawBorder: false,
          color: '#f2f2f2',
        },
        ticks: {
          beginAtZero: true,
          stepSize: 1
        }
      }],
      xAxes: [{
        gridLines: {
          display: false
        }
      }]
    },
  }
});