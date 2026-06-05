<?php

namespace App\Http\Controllers\Vin;

use App\Http\Controllers\Controller;
use App\Mail\RegionImageSubmitted;
use App\Models\Region;
use App\Models\RegionImage;
use App\Rules\Turnstile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class RegionImageController extends Controller
{
    public function create()
    {
        $regions = Region::orderBy('name')->pluck('name', 'id');

        return view('vin.region-image', compact('regions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_id' => ['required', 'exists:regions,id'],
            'images' => ['required', 'array', 'min:1', 'max:5'], // 5 max pictures
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'], // 10MB max
            'author_name' => ['required', 'string', 'max:255'],
            'author_email' => ['required', 'email', 'max:255'],
            'author_link' => ['nullable', 'url', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'cf-turnstile-response' => ['required', 'string', new Turnstile],
        ]);

        $manager = new ImageManager(new Driver);
        $createdImages = collect();

        foreach ($request->file('images') as $image) {
            $filename = uniqid('region_').'.webp';
            $path = "content/regions/{$filename}";

            // Convert to webp and 16:9 ratio using Intervention Image
            $img = $manager->read($image);

            // Calculate 16:9 dimensions
            $width = $img->width();
            $height = $img->height();
            $targetRatio = 16 / 9;
            $currentRatio = $width / $height;

            if ($currentRatio > $targetRatio) {
                // Image is too wide
                $cropWidth = (int) ($height * $targetRatio);
                $img->cover($cropWidth, $height);
            } else {
                // Image is too tall
                $cropHeight = (int) ($width / $targetRatio);
                $img->cover($width, $cropHeight);
            }

            // Save image
            $fullPath = storage_path('app/public/'.$path);

            // Ensure directory exists
            $dir = dirname($fullPath);
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $img->toWebp(90)->save($fullPath);

            $regionImage = RegionImage::create([
                'region_id' => $validated['region_id'],
                'image_path' => $path,
                'author_name' => $validated['author_name'],
                'author_email' => $validated['author_email'],
                'author_link' => $validated['author_link'],
                'description' => $validated['description'],
            ]);

            $createdImages->push($regionImage);
        }

        $adminEmail = config('transittracker.admin_email');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new RegionImageSubmitted($createdImages));
        }

        return back()->with('status', 'Thanks for your submission! It will be reviewed shortly.');
    }
}
