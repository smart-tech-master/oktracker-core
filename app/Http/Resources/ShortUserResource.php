<?php

namespace App\Http\Resources;

use App\Models\Follower;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->profile_photo_path != null) {
            $pfp_path = env("APP_URL") . $this->profile_photo_path;
        } else {
            $pfp_path = "https://media.discordapp.net/attachments/825042681779716136/940698494094692362/default_pfp.png";
        }
        $followed = Follower::where("user_id", auth()->user()->id)->where("follow_id", $this->id)->count() > 0;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'pfp_path' => $pfp_path,
            'following' => $followed,
        ];
    }
}
