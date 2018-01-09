<?php

namespace App\Http\Controllers\Admin;

use App\Attraction;
use App\Http\Controllers\Controller;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PhotoController extends Controller
{
    public function update(Attraction $attraction, Request $request, Photo $photo)
    {
        $input = $request->validate([
            'photos' => 'required|array|max:5',
            'photos.*.id' => ['sometimes', Rule::exists($photo->getTable())],
            'photos.*.file' => 'image',
        ]);

        $new = [];
        $retained = [];

        foreach ($input['photos'] as $index => $row) {

            if (!isset($row['id'])) {
                $path = $request->file("photos.{$index}.file")->store(
                    'photos/attraction', 'public'
                );
                $new[] = ['filename' => $path, 'caption' => '/'];
            } else {
                $retained[] = $row['id'];
            }
        }

        $attraction->photos->each(function ($item) use ($retained) {
            if (!in_array($item->id, $retained)) {
                $item->delete();
            }
        });

        if (!empty($new)) {
            $attraction->photos()->createMany($new);
        }

        return response()->json([
            'result' => true,
        ]);
    }

}
