<?php

use Livewire\Volt\Component;

new class extends Component {

    public $value;
    public $height;
    public $title;
    public $namaChart;

}; ?>

<div>
    <div id="{{ $this->namaChart }}"></div>
</div>

<script>

    var data = @json($this->value);

    var categories = data.map(item => item.kategori);
    var seriesData = data.map(item => item.jumlah);

    var options = {
         series: seriesData,
          chart: {
          height: {{ $this->height }},
          type: 'donut',
        },
        title: {
          text: '{{ $this->title }}',
          align: 'center'
        },
        grid: {
          borderColor: '#e7e7e7',
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        legend: {
            show: true,
            position: 'bottom',
        },
        dataLabels: {
          enabled: true, // Aktifkan datalabels
        },
        labels: categories
        };

        var chart = new ApexCharts(document.querySelector("#{{ $this->namaChart }}"), options);
        chart.render();
</script>
