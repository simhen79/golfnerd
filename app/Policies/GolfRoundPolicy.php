<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\GolfRound;
use Illuminate\Auth\Access\HandlesAuthorization;

class GolfRoundPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:GolfRound');
    }

    public function view(AuthUser $authUser, GolfRound $golfRound): bool
    {
        return $authUser->can('View:GolfRound');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GolfRound');
    }

    public function update(AuthUser $authUser, GolfRound $golfRound): bool
    {
        return $authUser->can('Update:GolfRound');
    }

    public function delete(AuthUser $authUser, GolfRound $golfRound): bool
    {
        return $authUser->can('Delete:GolfRound');
    }

    public function restore(AuthUser $authUser, GolfRound $golfRound): bool
    {
        return $authUser->can('Restore:GolfRound');
    }

    public function forceDelete(AuthUser $authUser, GolfRound $golfRound): bool
    {
        return $authUser->can('ForceDelete:GolfRound');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:GolfRound');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:GolfRound');
    }

    public function replicate(AuthUser $authUser, GolfRound $golfRound): bool
    {
        return $authUser->can('Replicate:GolfRound');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:GolfRound');
    }

}