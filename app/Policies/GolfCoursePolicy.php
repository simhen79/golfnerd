<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\GolfCourse;
use Illuminate\Auth\Access\HandlesAuthorization;

class GolfCoursePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:GolfCourse');
    }

    public function view(AuthUser $authUser, GolfCourse $golfCourse): bool
    {
        return $authUser->can('View:GolfCourse');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GolfCourse');
    }

    public function update(AuthUser $authUser, GolfCourse $golfCourse): bool
    {
        return $authUser->can('Update:GolfCourse');
    }

    public function delete(AuthUser $authUser, GolfCourse $golfCourse): bool
    {
        return $authUser->can('Delete:GolfCourse');
    }

    public function restore(AuthUser $authUser, GolfCourse $golfCourse): bool
    {
        return $authUser->can('Restore:GolfCourse');
    }

    public function forceDelete(AuthUser $authUser, GolfCourse $golfCourse): bool
    {
        return $authUser->can('ForceDelete:GolfCourse');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:GolfCourse');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:GolfCourse');
    }

    public function replicate(AuthUser $authUser, GolfCourse $golfCourse): bool
    {
        return $authUser->can('Replicate:GolfCourse');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:GolfCourse');
    }

}