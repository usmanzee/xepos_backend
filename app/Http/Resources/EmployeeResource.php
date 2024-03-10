<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'email' => $this->company->email,
                'logo' => $this->company->logo,
                'logo_url' => $this->company->logo_url,
            ],
        ];
    }
}
