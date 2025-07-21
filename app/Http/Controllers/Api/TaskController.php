<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Получить список всех задач
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();
        
        return response()->json([
            'status' => true,
            'message' => 'Список задач успешно получен',
            'data' => $tasks
        ]);
    }

    /**
     * Создать новую задачу
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ], 422);
        }

        $task = Task::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Задача успешно создана',
            'data' => $task
        ], 201);
    }

    /**
     * Получить информацию о конкретной задаче
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Задача не найдена'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Задача успешно получена',
            'data' => $task
        ]);
    }

    /**
     * Обновить существующую задачу
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Задача не найдена'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ], 422);
        }

        $task->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Задача успешно обновлена',
            'data' => $task
        ]);
    }

    /**
     * Удалить задачу
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Задача не найдена'
            ], 404);
        }

        $task->delete();

        return response()->json([
            'status' => true,
            'message' => 'Задача успешно удалена'
        ]);
    }
}
