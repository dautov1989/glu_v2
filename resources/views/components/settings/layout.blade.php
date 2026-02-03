@php
    $isAdmin = str_starts_with(request()->path(), 'admin/');
    $prefix = $isAdmin ? 'admin.settings.' : '';

    // Mapping frontend route names to admin route names
    $profileRoute = $isAdmin ? route('admin.settings.profile') : route('profile.edit');
    $passwordRoute = $isAdmin ? route('admin.settings.password') : route('user-password.edit');
    $appearanceRoute = $isAdmin ? route('admin.settings.appearance') : route('appearance.edit');
    $twoFactorRoute = $isAdmin ? route('admin.settings.two-factor') : route('two-factor.show');
@endphp

<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item :href="$profileRoute" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
            <flux:navlist.item :href="$passwordRoute" wire:navigate>{{ __('Password') }}</flux:navlist.item>
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <flux:navlist.item :href="$twoFactorRoute" wire:navigate>{{ __('Two-Factor Auth') }}</flux:navlist.item>
            @endif
            <flux:navlist.item :href="$appearanceRoute" wire:navigate>{{ __('Appearance') }}</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div
        class="flex-1 self-stretch max-md:pt-6 {{ $isAdmin ? 'bg-white border border-gray-200 shadow-sm p-6 rounded-sm' : '' }}">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>