<?php
use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public $value;
    public $icon;
    public $color = 'blue'; // Default color
}; ?>

<div class="p-5 rounded-2xl border border-gray-200 bg-white transition-all hover:shadow-md group">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 group-hover:text-gray-600 transition">{{ $title }}</p>
            <p class="mt-1 text-2xl font-semibold text-gray-800">{{ $value }}</p>
        </div>
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-{{ $color }}-100 text-{{ $color }}-600">
            <i class="fas fa-{{ $icon }} text-lg"></i>
        </div>
    </div>
</div>
