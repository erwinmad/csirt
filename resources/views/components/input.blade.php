@props(['id', 'label', 'type' => 'text', 'wireModel', 'placeholder' => '', 'class' => ''])

<div class="mb-6">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input 
        type="{{ $type }}" 
        wire:model="{{ $wireModel }}" 
        id="{{ $id }}" 
        class="mt-1 block w-full border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm {{ $class }}" 
        placeholder="{{ $placeholder }}">
    @error($wireModel)
        <x-input-error :message="$message" />
    @enderror
</div>