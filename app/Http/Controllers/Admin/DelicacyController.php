<?php

namespace App\Http\Controllers\Admin;

use App\Attraction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class DelicacyController extends Controller
{
    public function update(Attraction $attraction, Request $request)
    {
        $input = $request->validate([
            'item.*.description' => 'required',
            'item.*.remarks' => 'present',
            'item.*.cost' => 'required|numeric',
        ], [
            'item.*.description.required' => 'You need to fill this up',
            'item.*.cost.required' => 'You need to fill this up',
            'item.*.cost.numeric' => 'Only numeric fields are allowed',
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

        $attraction->delicacies->each(function ($item) use ($updated) {
            if (in_array($item->id, array_keys($updated))) {
                $item->fill($updated[$item->id]);
                $item->save();
            } else {
                $item->delete();
            }
        });

        if (!empty($new)) {
            $attraction->delicacies()->createMany($new);
        }

        Session::flash('growl', 'Delicacies successfully updated');

        return response()->json([
            'result' => true,
        ]);
    }
}
