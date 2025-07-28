<?php

use Livewire\Volt\Component;

new class extends Component {
    //
    public function with(): array
    {
        return [
            'profil' => \App\Models\ProfilModel::first(),
        ];
    }
}; ?>

<a class="navbar-brand" href="{{ route('users.index') }}">
    <img src="{{ asset($profil->foto_path) }}" width="120" alt="logo" class="img-fluid" />
</a>

