<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\Store;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    public function view(Store $store, Service $service): bool
    {
        return $service->store_id === $store->id;
    }

    public function update(Store $store, Service $service): bool
    {
        return $service->store_id === $store->id;
    }

    public function delete(Store $store, Service $service): bool
    {
        return $service->store_id === $store->id;
    }

    // Optional: for show/edit
    public function show(Store $store, Service $service): bool
    {
        return $service->store_id === $store->id;
    }
}