<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'logo', 'website'];
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            // $baseUrl = config('app.url');
            $baseUrl = url('/');
            $logoPath = Storage::url($this->logo);
            return $baseUrl . $logoPath;
        }
        return null;
    }
}
