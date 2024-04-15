<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowTopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        $this->resource->loadMissing('admin');

        return [
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'name' => $this->name,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y H:i:s'),
            'admin' => [
                'name' => $this->admin->name,
            ]
        ];
    }
}
