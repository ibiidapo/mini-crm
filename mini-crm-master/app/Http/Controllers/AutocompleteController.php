<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Client;
use App\Http\Resources\AutocompleteResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutocompleteController extends Controller
{
    public function searchClients(Request $request)
    {
        if (!$request->filled('query')) {
            return response('No query found', \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
        $search = $request->input('query');
        $query  = Client::query();
        $query->where(function (Builder $builder) use ($search) {
            $builder->where('first_name', 'LIKE', '%' . $search . '%');
            $builder->orWhere('last_name', 'LIKE', '%' . $search . '%');
            $builder->orWhere('email', 'LIKE', '%' . $search . '%');
        });
        
        JsonResource::withoutWrapping();
        return AutocompleteResource::collection($query->get());
    }
}
