<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
 
$user = User::with('roles')->first();
 
return $user->toArray();


$user = User::find(1);

return $user->toJson();

return $user->toJson(JSON_PRETTY_PRINT);