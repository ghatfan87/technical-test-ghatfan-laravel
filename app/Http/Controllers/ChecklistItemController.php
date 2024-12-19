<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use App\Enums\ChecklistStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistItemController extends Controller
{
    public function index($checklistId)
    {
        try {
            $checklist = Checklist::where('id', $checklistId)
                ->where('user_id', Auth::user()->id)
                ->first();

            if (!$checklist) {
                return ApiFormatter::createAPI(404, 'Checklist Not Found');
            }

            $checklistItems = ChecklistItem::where('checklist_id', $checklistId)->get();

            return ApiFormatter::createAPI(200, 'Success', [
                'items' => $checklist,

            ]);
        } catch (Exception $error) {
            return ApiFormatter::createAPI(500, 'Internal Server Error', $error->getMessage());
        }
    }

    public function store(Request $request, $checklistId)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $checklist = Checklist::where('id', $checklistId)
                ->where('user_id', Auth::user()->id)
                ->first();

            if (!$checklist) {
                return ApiFormatter::createAPI(404, 'Checklist Not Found');
            }

            $item = ChecklistItem::create([
                'checklist_id' => $checklistId,
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status
            ]);

            $data = ChecklistItem::where('id', $item->id)->first();

            return ApiFormatter::createAPI(201, 'Item Created Successfully', $data);
        } catch (Exception $error) {
            return ApiFormatter::createAPI(500, 'Internal Server Error', $error->getMessage());
        }
    }

    public function show($checklistId, $itemId)
    {
        try {
            $checklist = Checklist::where('id', $checklistId)
                ->where('user_id', Auth::user()->id)
                ->first();

            if (!$checklist) {
                return ApiFormatter::createAPI(404, 'Checklist Not Found');
            }

            $item = ChecklistItem::where('id', $itemId)
                ->where('checklist_id', $checklistId)
                ->first();

            if (!$item) {
                return ApiFormatter::createAPI(404, 'Item Not Found');
            }

            return ApiFormatter::createAPI(200, 'Success', $item);
        } catch (Exception $error) {
            return ApiFormatter::createAPI(500, 'Internal Server Error', $error->getMessage());
        }
    }

    public function update(Request $request, $checklistId, $itemId)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'nullable|string|in:' . implode(',', ChecklistItem::VALID_STATUSES)
            ]);

            $checklist = Checklist::where('id', $checklistId)
                ->where('user_id', Auth::user()->id)
                ->first();

            if (!$checklist) {
                return ApiFormatter::createAPI(404, 'Checklist Not Found');
            }

            $item = ChecklistItem::where('id', $itemId)
                ->where('checklist_id', $checklistId)
                ->first();

            if (!$item) {
                return ApiFormatter::createAPI(404, 'Item Not Found');
            }

            $updateData = [
                'title' => $request->title,
                'description' => $request->description
            ];

            if ($request->has('status')) {
                $updateData['status'] = $request->status;
            }

            $item->update($updateData);

            $data = ChecklistItem::where('id', $item->id)->first();

            return ApiFormatter::createAPI(200, 'Item Updated Successfully', $data);
        } catch (Exception $error) {
            return ApiFormatter::createAPI(500, 'Internal Server Error', $error->getMessage());
        }
    }

    public function updateStatus(Request $request, $checklistId, $itemId)
{
    try {
        // Validasi status
        $request->validate([
            'status' => 'required|string|in:' . implode(',', ChecklistItem::VALID_STATUSES)
        ]);

        // Periksa apakah checklist tersebut dimiliki oleh user
        $checklist = Checklist::where('id', $checklistId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$checklist) {
            return ApiFormatter::createAPI(404, 'Checklist Not Found');
        }

        // Temukan item dalam checklist
        $item = ChecklistItem::where('id', $itemId)
            ->where('checklist_id', $checklistId)
            ->first();

        if (!$item) {
            return ApiFormatter::createAPI(404, 'Checklist Item Not Found');
        }

        // Update status item
        $item->update(['status' => $request->status]);

        return ApiFormatter::createAPI(200, 'Status Updated Successfully', $item);
    } catch (\Exception $error) {
        return ApiFormatter::createAPI(500, 'Internal Server Error', $error->getMessage());
    }
}


    public function destroy($checklistId, $itemId)
    {
        try {
            $checklist = Checklist::where('id', $checklistId)
                ->where('user_id', Auth::user()->id)
                ->first();

            if (!$checklist) {
                return ApiFormatter::createAPI(404, 'Checklist Not Found');
            }

            $item = ChecklistItem::where('id', $itemId)
                ->where('checklist_id', $checklistId)
                ->first();

            if (!$item) {
                return ApiFormatter::createAPI(404, 'Item Not Found');
            }

            $item->delete();

            return ApiFormatter::createAPI(200, 'Item Deleted Successfully');
        } catch (Exception $error) {
            return ApiFormatter::createAPI(500, 'Internal Server Error', $error->getMessage());
        }
    }
}
