<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * @OA\Get(
     *     path="/tickets",
     *     summary="Get all tickets",
     *     description="Retrieve all IT support tickets",
     *     tags={"Tickets"},
     *     @OA\Response(
     *         response=200,
     *         description="List of tickets",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="ticket_id", type="integer", example=2372),
     *                 @OA\Property(property="subject", type="string", example="Update Unifi Equipment"),
     *                 @OA\Property(property="status", type="string", example="Closed"),
     *                 @OA\Property(property="priority", type="string", example="Low")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $tickets = DB::table('tickets')->get();
        return response()->json($tickets);
    }

    /**
     * @OA\Get(
     *     path="/tickets/{id}",
     *     summary="Get single ticket",
     *     description="Retrieve a specific ticket by ID",
     *     tags={"Tickets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Ticket ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket details"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket not found"
     *     )
     * )
     */
    public function show($id)
    {
        $ticket = DB::table('tickets')->where('ticket_id', $id)->first();

        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        return response()->json($ticket);
    }

    /**
     * @OA\Get(
     *     path="/stats",
     *     summary="Get ticket statistics",
     *     tags={"Statistics"},
     *     @OA\Response(
     *         response=200,
     *         description="Ticket statistics"
     *     )
     * )
     */
    public function stats()
    {
        $stats = [
            'total_tickets' => DB::table('tickets')->count(),
            'by_status' => DB::table('tickets')
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get(),
            'by_priority' => DB::table('tickets')
                ->select('priority', DB::raw('count(*) as count'))
                ->groupBy('priority')
                ->get(),
        ];

        return response()->json($stats);
    }
}
