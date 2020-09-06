<?php

namespace Modules\Vblog\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Vcore\Http\Controllers\Api\VcoreApiController;

use Modules\Vblog\Http\Requests\CreatePostRequest;
use Modules\Vblog\Repositories\PostRepository;
use Modules\Vblog\Transformers\PostTransformer;

class PostApiController extends VcoreApiController
{

    private $post;

    public function __construct(
        PostRepository $post
    ){
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

        try {

            //Request to Repository
            $posts = $this->post->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => PostTransformer::collection($posts)];

            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($posts)] : false;


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
            $post = $this->post->getItem($criteria,$this->getParamsRequest($request));

            //Break if no found item
            if (!$post) throw new \Exception('Item not found', 204);

            $response = [
                'data' => $post ? new PostTransformer($post) : '',
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

            $this->validateRequestApi(new CreatePostRequest($data));

            $post = $this->post->create($data);

            $response = ["data" => new PostTransformer($post)];

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

            $this->validateRequestApi(new CreatePostRequest($data));

            $params = $this->getParamsRequest($request);

            // Search entity
            $entity = $this->post->getItem($criteria,$params);

            //Break if no found item
            if (!$entity) throw new \Exception('Item not found', 204);

            $post = $this->post->update($entity,$data);

            $response = ['data' => new PostTransformer($post)];

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
            $entity = $this->post->getItem($criteria,$params);

            //Break if no found item
            if (!$entity) throw new \Exception('Item not found', 204);

            $this->post->destroy($entity);

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
