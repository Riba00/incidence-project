<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incidence;
use Illuminate\Http\Request;

class IncidenceController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();

        $query = Incidence::query();

        // Filter by status
        if ($request->has('status')) {
            $statuses = is_array($request->query('status'))
                ? $request->query('status')
                : explode(',', $request->query('status'));

            $query->whereIn('status', $statuses);
        }

        if ($user->hasRole('support')) {
            $query->where('user_id', $user->id);
        } elseif ($user->hasRole('admin')) {
        } else {
            return response()->json(['error' => 'Unauthorized role'], 403);
        }

        $incidences = $query->get();

        return response()->json($incidences);
    }
}
