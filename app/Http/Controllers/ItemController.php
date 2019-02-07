<?php

namespace App\Http\Controllers;

use App\Exceptions\ItemSaveException;
use App\Models\Item;
use App\Services\Contracts\ItemServiceInterface;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createItem(Request $request)
    {
        $partNumber = $request->input('part_number');
        $status = $request->input('status');
        $brandId = $request->input('brand_id');
        $categoryId = $request->input('category_id');

        $item = new Item();
        $item->part_number  = $partNumber;
        $item->status = $status;
        $item->brand_id = $brandId;
        $item->category_id = $categoryId;

        $errorMessages = [];

        try {
            $item->save();
            $success = true;
        } catch (ItemSaveException $e) {
            $errorMessages[] = $e->getMessage();
            $success = false;
        } catch (\Exception $e) {
            $errorMessages[] = "Unable to create the item.";
            $success = false;
        }

        $response = ['success'=>$success];
        if ($success) {
            $response['item'] = $item;
        } else {
            $response['message'] = implode(", ", $errorMessages);
        }

        return response()->json($response);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItem(Request $request, $id)
    {
        $item = Item::with('category')->where('id',$id)->first();
        if (!$item) {
            return response()->json(['message' => 'Item id not found'], 404);
        }

        return response()->json($item);
    }

    /**
     * API to the a paginated list of the working items
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\JsonResponse
     */
    public function getWorkingItems(Request $request)
    {
        $perPage = $request->input('per_page', 25);
        $sortField = strtolower($request->input('sort_field', 'part_number'));
        $sortDir = strtolower($request->input('sort_dir', 'desc'));

        $query = Item::working()->with('category');

        if ($sortField) {
            $allowedFields = [
                'part_number',
                'brand_id',
            ];

            if (!in_array($sortField, $allowedFields)) {
                return response()->json(['message' => 'Can not sort by ' . $sortField], 400);
            }

            $allowedDirections = [
                'desc',
                'asc'
            ];

            if (!in_array($sortDir, $allowedDirections)) {
                return response()->json(['message' => 'Invalid sort direction ' . $sortDir . '. Must either be desc or asc'], 400);
            }
            $query = $query->orderBy($sortField, $sortDir);
        }
        return $query->paginate($perPage);
    }


    /**
     * @param Request $request
     * @param ItemServiceInterface $itemService
     * @return \Illuminate\Http\JsonResponse
     */
    public function partNumberLookup(Request $request, ItemServiceInterface $itemService)
    {
        $partNumber = $request->input('part_number');
        $results = $itemService->partNumberLookup($partNumber);

        return response()->json($results);
    }

    /**
     * @param Request $request
     * @param $itemId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateItem(Request $request, $itemId)
    {
        $partNumber = $request->input('part_number');
        $status = $request->input('status');
        $brandId = $request->input('brand_id');

        $item = Item::find($itemId);
        if (!$item) {
            return response()->json(['message' => 'Item id not found'], 404);
        }

        $item->part_number  = $partNumber;
        $item->status = $status;
        $item->brand_id = $brandId;

        $errorMessages = [];

        try {
            $item->save();
            $success = true;
        } catch (ItemSaveException $e) {
            $errorMessages[] = $e->getMessage();
            $success = false;
        } catch (\Exception $e) {
            $errorMessages[] = "Unable to create the item.";
            $success = false;
        }

        $response = ['success'=>$success];
        if ($success) {
            $response['item'] = $item;
        } else {
            $response['message'] = implode(", ", $errorMessages);
        }

        return response()->json($response);
    }
}