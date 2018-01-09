<?php

namespace App\Http\Controllers\Admin;

use App\Attraction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    public function update(Attraction $attraction, Request $request)
    {
        $input = $request->validate([
            'item.*.description' => 'required',
            'item.*.start_point' => 'required',
            'item.*.end_point' => 'required',
            'item.*.fare' => 'required|numeric',
        ], [
            'item.*.description.required' => 'You need to fill this up',
            'item.*.start_point.required' => 'You need to fill this up',
            'item.*.end_point.required' => 'You need to fill this up',
            'item.*.fare.required' => 'You need to fill this up',
        ]);

        $new = [];
        $updated = [];

        foreach ($input['item'] as $row) {
            if (!isset($row['id'])) {
                $new[] = $row;
            } else {
                $updated[$row['id']] = array_except($row, ['id']);
            }
        }

        $attraction->transportations->each(function ($item) use ($updated) {
            if (in_array($item->id, array_keys($updated))) {
                $item->fill($updated[$item->id]);
                $item->save();
            } else {
                $item->delete();
            }
        });

        if (!empty($new)) {
            $attraction->transportations()->createMany($new);
        }

        return response()->json([
            'result' => true,
        ]);
    }
}
