<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new 
#[Layout('components.layouts.guest')]
class extends Component {

    public $value;
    public $height;
    public $title;
    public $namaChart;

}; ?>

<div>
   <div id="chart" height="80"></div>
</div>

<script>

var data = @json($this->value);

var categories = data.map(item => item.kategori);
var seriesData = data.map(item => item.jumlah);

var options = {
          series: [{
          data: seriesData
        }],
          chart: {
          type: 'bar',
          height: {{ $this->height }}
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            borderRadiusApplication: 'end',
            horizontal: true,
          }
        },
        title: {
          text: '{{ $this->title }}',
          align: 'left'
        },
        dataLabels: {
          enabled: false
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
          categories: categories
        },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      
</script>
