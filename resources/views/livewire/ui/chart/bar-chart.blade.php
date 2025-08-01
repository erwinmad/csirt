<?php

use Livewire\Volt\Component;

new class extends Component {
    
    public $value;
    public $height;
    public $title;

}; ?>

<div>
    <div id="bar-chart"></div>
</div>


<script type="text/javascript">

    var data = @json($this->value);

    var categories = data.map(item => item.kategori);
    var seriesData = data.map(item => item.jumlah);

    var options = {
        series: [{
            name: 'Jumlah',
            data: seriesData // Menggunakan data jumlah
        }],
        chart: {
            height: {{ $this->height }},
            type: 'bar',
        },
        title: {
          text: '{{ $this->title }}',
          align: 'left'
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                columnWidth: '50%',
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            width: 0
        },
        grid: {
            row: {
                colors: ['#fff', '#f2f2f2']
            }
        },
        xaxis: {
            labels: {
                rotate: -45
            },
            categories: categories, 
            tickPlacement: 'on'
        },
        yaxis: {
            title: {
                text: 'Jumlah',
            },
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                inverseColors: true,
                opacityFrom: 0.85,
                opacityTo: 0.85,
                stops: [50, 0, 100]
            },
        }
    };

    var chart = new ApexCharts(document.querySelector("#bar-chart"), options);
    chart.render();
</script>