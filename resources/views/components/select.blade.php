@props(['id', 'label', 'wireModel', 'options', 'defaultOption' => 'Pilih Kategori'])

<div class="mb-6">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <select 
        wire:model="{{ $wireModel }}" 
        id="{{ $id }}" 
        class="mt-1 block w-full border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
        <option value="" >{{ $defaultOption }}</option>
        @foreach ($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>
    @error($wireModel)
        <x-input-error :message="$message" />
    @enderror
</div>