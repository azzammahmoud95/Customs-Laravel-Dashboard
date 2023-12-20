<!-- resources/views/chart/multiple_charts.blade.php -->

@extends('layout.layout')

@section('content')
<h1 class="mb-4">Home</h1>

<div class="container my-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <canvas id="taxChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <canvas id="categoryChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <canvas id="productChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Add other canvas elements for additional charts -->

<script>
    var taxCtx = document.getElementById('taxChart').getContext('2d');
    var taxData = {
        labels: @json($taxChartData['labels']),
        datasets: [{
            label: 'Number of Products',
            data: @json($taxChartData['data']),
            backgroundColor: [
            'rgba(255, 99, 132, 0.2)',  // Red
            'rgba(54, 162, 235, 0.2)', // Blue
            'rgba(255, 206, 86, 0.2)', // Yellow
            'rgba(75, 192, 192, 0.2)', // Teal
            'rgba(153, 102, 255, 0.2)',// Purple
            'rgba(255, 159, 64, 0.2)'  // Orange
        ],            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    var taxOptions = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    var taxChart = new Chart(taxCtx, {
        type: 'bar',
        data: taxData,
        options: taxOptions
    });

    // Add similar code for other charts...
    var categoryCtx = document.getElementById('categoryChart').getContext('2d');
    var categoryData = {
        labels: @json($categoryChartData['labels']),
        datasets: [{
            label: 'Number of Categories',
            data: @json($categoryChartData['data']),
            backgroundColor: [
            'rgba(255, 99, 132, 0.2)',  // Red
            'rgba(54, 162, 235, 0.2)', // Blue
            'rgba(255, 206, 86, 0.2)', // Yellow
            'rgba(75, 192, 192, 0.2)', // Teal
            'rgba(153, 102, 255, 0.2)',// Purple
            'rgba(255, 159, 64, 0.2)'  // Orange
        ],            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    };

    var categoryOptions = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    var categoryChart = new Chart(categoryCtx, {
        type: 'scatter',
        data: categoryData,
        options: categoryOptions
    });

    // Code for productChart
    var productCtx = document.getElementById('productChart').getContext('2d');
    var productData = {
        labels: @json($productChartData['labels']),
        datasets: [{
            label: 'Number of Products',
            data: @json($productChartData['data']),
            backgroundColor: [
            'rgba(255, 99, 132, 0.2)',  // Red
            'rgba(54, 162, 235, 0.2)', // Blue
            'rgba(255, 206, 86, 0.2)', // Yellow
            'rgba(75, 192, 192, 0.2)', // Teal
            'rgba(153, 102, 255, 0.2)',// Purple
            'rgba(255, 159, 64, 0.2)'  // Orange
        ],
                borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
        }]
    };

    var productOptions = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    var productChart = new Chart(productCtx, {
        type: 'doughnut',
        data: productData,
        options: productOptions
    });
</script>
@endsection