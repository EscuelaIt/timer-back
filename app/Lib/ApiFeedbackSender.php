<?php

namespace App\Lib;

trait ApiFeedbackSender {

  protected function sendSuccess($message, $data, $status = 200) {
    return response()->json([
      'message' => $message,
      'data' => $data,
    ], $status);
  }

  protected function sendError($message, $errors, $status = 400) {
    return response()->json([
      'message' => $message,
      'errors' => $errors,
    ], $status);
  }
}