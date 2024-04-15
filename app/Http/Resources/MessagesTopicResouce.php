<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MessagesTopicResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        $this->resource->loadMissing('messageable');

        return [
            'id' => $this->id,
            'submitted_by' => $this->messageable->name,
            'message' => $this->text,
            'shipped_in' => Carbon::parse($this->created_at)->format('d/m/Y H:i:s'),
            'updated_at' => $this->when(
                $this->updated_at->ne($this->created_at),
                Carbon::parse($this->updated_at)->format('d/m/Y H:i:s')
            ),
        ];
    }
}
