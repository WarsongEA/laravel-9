<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailsRequest;
use App\Mapping\EmailsMapping;
use App\Models\EmailRecord;
use App\Service\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class EmailController extends Controller
{
    public function send(SendEmailsRequest $request, EmailService $sendEmailService): JsonResponse
    {
        try {
            $emailCollectionDto = EmailsMapping::requestToDtoList($request);

            $sendEmailService->dispatchList($emailCollectionDto);

            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            Log::error('EmailController::send', ['e' => $e->getMessage(), 't' => $e->getTraceAsString()]);

            return response()->json(['error' => 'Something went wrong']);
        }

    }

    public function list(): JsonResponse
    {
        $emailRecord = resolve(EmailRecord::class);
        $emails = $emailRecord->all();

        return response()->json($emails);
    }
}
