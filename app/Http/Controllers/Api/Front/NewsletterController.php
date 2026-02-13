<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Front\Newsletter\StoreRequest;
use App\Mail\Newsletter as MailNewsletter;
use App\Models\Newsletter;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            Newsletter::create($request->sanitized());
            DB::commit();

            Mail::to($request?->email)->send(new MailNewsletter($request->sanitized()));
            return response()->json([
                'status' => true,
                'message' => 'successfull !',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // function contact() : Returntype {

    // }
}
