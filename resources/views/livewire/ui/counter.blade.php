<?php

use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public $value;
    public $icon;
    public $color = 'blue'; // Default color
    
}; ?>

<div class="group transition-all duration-300 hover:scale-[1.02]">
    <div class="relative overflow-hidden p-6 rounded-xl border border-gray-200 shadow-sm bg-white hover:shadow-md transition-shadow duration-300">
        <!-- Gradient background effect -->
        <div class="absolute inset-0 bg-gradient-to-br opacity-10 group-hover:opacity-20 transition-opacity duration-500 from-{{ $this->color }}-300 to-{{ $this->color }}-500"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div class="space-y-2">
                <h3 class="text-lg font-medium text-gray-600">{{ $this->title }}</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $this->value }}</p>
            </div>
            <div class="p-4 bg-{{ $this->color }}-100 rounded-xl group-hover:rotate-12 transition-transform duration-500">
                <i class="fas fa-{{ $this->icon }} text-{{ $this->color }}-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>