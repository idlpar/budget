<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RestrictToHierarchy
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            Log::warning('Unauthorized access attempt: User not authenticated', [
                'url' => $request->url(),
                'ip' => $request->ip(),
            ]);
            abort(401, 'Authentication required.');
        }

        if ($user->isAdmin()) {
            return $next($request); // Admins have unrestricted access
        }

        // Determine the resource being accessed (division, department, or section)
        $divisionId = $request->route('division') ? $request->route('division')->id : null;
        $departmentId = $request->route('department') ? $request->route('department')->id : null;
        $sectionId = $request->route('section') ? $request->route('section')->id : null;

        // Non-admins must have a section_id to access hierarchical data
        if (! $user->section_id) {
            Log::warning('Non-admin user lacks section assignment', [
                'user_id' => $user->id,
                'url' => $request->url(),
                'ip' => $request->ip(),
            ]);
            abort(403, 'You must be assigned to a section to access this resource.');
        }

        // Scope access based on user's section (and its department and division)
        $isAuthorized = false;

        if ($sectionId && $user->section_id === $sectionId) {
            $isAuthorized = true;
        } elseif ($departmentId && $user->department_id === $departmentId) {
            $isAuthorized = true;
        } elseif ($divisionId && $user->division_id === $divisionId) {
            $isAuthorized = true;
        }

        if (! $isAuthorized) {
            Log::warning('Unauthorized access attempt to hierarchical data', [
                'user_id' => $user->id,
                'division_id' => $divisionId,
                'department_id' => $departmentId,
                'section_id' => $sectionId,
                'user_division_id' => $user->division_id,
                'user_department_id' => $user->department_id,
                'user_section_id' => $user->section_id,
                'url' => $request->url(),
                'ip' => $request->ip(),
            ]);
            abort(403, 'Unauthorized access to this resource.');
        }

        return $next($request);
    }
}
