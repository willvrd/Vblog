<?php

namespace Modules\Vblog\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Vcore\Http\Controllers\Api\VcoreApiController;

use Modules\Vblog\Http\Requests\CreateCategoryRequest;
use Modules\Vblog\Repositories\CategoryRepository;
use Modules\Vblog\Transformers\CategoryTransformer;

class CategoryApiController extends VcoreApiController
{

    private $category;

    public function __construct(
        CategoryRepository $category
    ){
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

        try {

            //Request to Repository
            $categorys = $this->category->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => CategoryTransformer::collection($categorys)];

            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($categorys)] : false;


        } catch (\Exception $e) {
            \Log::error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response, $status ?? 200);

    }

     /** SHOW
   * @param Request $request
   *  URL GET:
   *  &fields = type string
   *  &include = type string
   */
    public function show($criteria, Request $request)
    {
        try {
            //Request to Repository
            $category = $this->category->getItem($criteria,$this->getParamsRequest($request));

            //Break if no found item
            if (!$category) throw new \Exception('Item not found', 204);

            $response = [
                'data' => $category ? new CategoryTransformer($category) : '',
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response, $status ?? 200);
    }

      /**
     * Create.
     * @param  Request $request
     * @return Response
     */
    public function create(Request $request)
    {

        \DB::beginTransaction();

        try{

            $data = $request['attributes'] ?? [];

            $this->validateRequestApi(new CreateCategoryRequest($data));

            $category = $this->category->create($data);

            $response = ["data" => new CategoryTransformer($category)];

            \DB::commit();

        } catch (\Exception $e) {
            \Log::error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);

    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction();

        try {

            $data = $request['attributes'] ?? [];

            $this->validateRequestApi(new CreateCategoryRequest($data));

            $params = $this->getParamsRequest($request);

            // Search entity
            $entity = $this->category->getItem($criteria,$params);

            //Break if no found item
            if (!$entity) throw new \Exception('Item not found', 204);

            $category = $this->category->update($entity,$data);

            $response = ['data' => new CategoryTransformer($category)];

            \DB::commit();

        } catch (\Exception $e) {
            \Log::error($e);
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete($criteria, Request $request)
    {
        try {

            $params = $this->getParamsRequest($request);

            // Search entity
            $entity = $this->category->getItem($criteria,$params);

            //Break if no found item
            if (!$entity) throw new \Exception('Item not found', 204);

            $this->category->destroy($entity);

            $response = ['data' => 'Item deleted'];

        } catch (\Exception $e) {
            \Log::Error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);

    }



}
