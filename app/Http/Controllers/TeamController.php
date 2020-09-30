<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        return response()->json([
            'teams' => Auth::user()->teams,
        ], 200);
    }

    public function store()
    {
        $this->validateRequest();

        $team = Auth::user()->teams()->create([
            'name' => request('name'),
        ]);

        return response()->json([
            'message' => __('teams.created'),
            'team' => $team,
        ], 200);
    }

    public function update(Team $team)
    {
        $this->validateRequest();

        $this->authorize('owner', $team);

        $team->update([
            'name' => request('name'),
        ]);

        return response()->json([
            'message' => __('teams.updated'),
            'team' => $team,
        ], 200);
    }

    public function destroy(Team $team)
    {
        $this->authorize('owner', $team);

        $team->delete();

        return response()->json([
            'message' => __('teams.deleted'),
        ], 200);
    }

    protected function validateRequest()
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
    }
}