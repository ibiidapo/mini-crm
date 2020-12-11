<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the client.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            //paginate clients order by last update date
            $clients = Client::with('transactions')
                             ->orderByDesc('updated_at')
                             ->paginate($request->input('perPage', 10));
            //return custom collection
            return ClientResource::collection($clients);
        }
        return view('entities.clients.index');
    }
    
    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('entities.clients.create');
    }
    
    /**
     * Store a newly created client in storage.
     *
     * @param \App\Http\Requests\StoreClientRequest $request
     *
     * @return \App\Client|\Illuminate\Database\Eloquent\Model
     */
    public function store(StoreClientRequest $request)
    {
        //get validated data
        $data = $request->validated();
        //save avatar image
        $data = $this->saveAvatar($request, $data);
        //create client and return response
        return Client::create($data);
    }
    
    /**
     * Save Avatar for client
     *
     * @param \App\Http\Requests\StoreClientRequest $request
     * @param                                       $data
     *
     * @return array
     */
    private function saveAvatar(StoreClientRequest $request, $data): array
    {
        if ($request->hasFile('avatar')) {
            //save avatar
            $file_name = 'image_' . time() . '.' . $request->file('avatar')
                                                           ->getClientOriginalExtension();
            $request->file('avatar')
                    ->storePubliclyAs('', $file_name, ['disk' => 'avatars']);
            //remove avatar from data
            array_forget($data, 'avatar');
            //add avatar path to data
            $data['avatar_path'] = '/storage/avatars/' . $file_name;
            return $data;
        }
        
        return [];
    }
    
    /**
     * Display the specified client.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Client             $client
     *
     * @return \App\Client|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Client $client)
    {
        if ($request->wantsJson()) {
            return $client;
        }
        return view('entities.clients.show', compact('client'));
    }
    
    /**
     * Show the form for editing the specified client.
     *
     * @param  \App\Client $client
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Client $client)
    {
        return view('entities.clients.edit', compact('client'));
    }
    
    /**
     * Update the specified client in storage.
     *
     * @param \App\Http\Requests\StoreClientRequest $request
     * @param  \App\Client                          $client
     *
     * @return \App\Http\Resources\ClientResource
     */
    public function update(StoreClientRequest $request, Client $client): ClientResource
    {
        $data = $request->validated();
        //save avatar image
        $data = $this->saveAvatar($request, $data);
        //update client
        $client->update($data);
        //return formatted response
        return ClientResource::make($client->load('transactions')
                                           ->refresh());
    }
    
    /**
     * Remove the specified client from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Client             $client
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Client $client)
    {
        $client->transactions->each->delete();
        $client->delete();
        
        return $this->returnSuccess($request);
    }
}
