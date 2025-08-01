<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('admin-index') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo class="size-8" href="#"></x-app-logo>
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group heading="Platform" class="grid">
                    <flux:navlist.item icon="home" :href="route('admin-index')" :current="request()->routeIs('admin-index')" wire:navigate>Dashboard</flux:navlist.item>
                    <flux:navlist.item icon="document-magnifying-glass" :href="route('pentest-list')" :current="request()->routeIs('pentest-list')" wire:navigate>Pentesting</flux:navlist.item>
                    <flux:navlist.item icon="shield-check" :href="route('insiden-list')" :current="request()->routeIs('insiden-list')" wire:navigate>Insiden</flux:navlist.item>
                    <flux:navlist.item icon="sparkles" :href="route('aplikasi-list')" :current="request()->routeIs('aplikasi-list')" wire:navigate>Aset IT</flux:navlist.item>
                    {{-- <flux:navlist.item icon="globe-alt" :href="route('website-list')" :current="request()->routeIs('website-list')" wire:navigate>Website</flux:navlist.item> --}}
                    <flux:navlist.item icon="building-library" :href="route('skpd-list')" :current="request()->routeIs('skpd-list')" wire:navigate>Perangkat Daerah</flux:navlist.item>
                    <flux:navlist.item icon="paper-clip" :href="route('pages-list')" :current="request()->routeIs('pages-list')" wire:navigate>Halaman</flux:navlist.item>
                    <flux:navlist.item icon="newspaper" :href="route('berita-list')" :current="request()->routeIs('berita-list')" wire:navigate>Berita</flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('team-kami-list')" :current="request()->routeIs('team-kami-list')" wire:navigate>Team</flux:navlist.item>
                    <flux:navlist.item icon="queue-list" :href="route('logs-list')" :current="request()->routeIs('logs-list')" wire:navigate>Logs</flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('profil')" :current="request()->routeIs('profil')" wire:navigate>Profil</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        

        @fluxScripts

        
    </body>
</html>
