<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'company']);
    }
    /*
   * To get all tickets
     *
   *@
   */
    public function index(Request $request)
    {

        $count = 0;
        $tickets = request()->company->tickets();
        if (request()->type != null) {
            $tickets =  $tickets->where('issued_type_id', request()->type);
        }
        if (request()->status != null) {
            $tickets =  $tickets->where('status_type_id', request()->status);
        }
        if (request()->search_keyword) {
            $tickets =  $tickets->where('title', 'LIKE', '%' . request()->search_keyword . '%')
                ->orWhere('description', 'LIKE', '%' . request()->search_keyword . '%');
        }

        if (request()->page && request()->rowsPerPage) {
            $count =  $tickets->count();
            $tickets =  $tickets->paginate(request()->rowsPerPage)->toArray();
            $tickets =  $tickets['data'];
        } else {
            $tickets =  $tickets->get();
            $count =  $tickets->count();
        }
        return response()->json([
            'data'     =>  $tickets,
            'count' => $count,
            'success'   =>  true
        ], 200);
    }

    /*
   * To store a new ticket
   *
   *@
   */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title'        =>  'required',
        //     'issued_type_id' =>  'required',
        //     'status_type_id' =>  'required',
        //     'created_by_id' =>  'required',
        // ]);

        $ticket = new Ticket(request()->all());
        $request->company->tickets()->save($ticket);
        return response()->json([
            'data'    => $ticket
        ], 201);
    }

    /*
   * To view a single ticket
   *
   *@
   */
  public function updateTicketAssignments(Request $request)
  {
      $technicianId = $request->input('technicianId');
      $ticketIds = $request->input('ticketIds');
  
      try {
          // Update the ticket records in the database with the new technician ID
          Ticket::whereIn('id', $ticketIds)
                ->update(['assigned_to_id' => $technicianId]);
  
          return response()->json(['message' => 'Ticket assignments updated successfully']);
      } catch (\Exception $e) {
          return response()->json(['error' => 'Failed to update ticket assignments'], 500);
      }
  }
  
    public function show(Ticket $ticket)
    {
      
        return response()->json([
            'data'   => $ticket
        ], 200);
    }

    /**
     * To update a ticket
     *
    
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'title'        =>  'required',
            'issued_type_id' =>  'required',
            'status_type_id' =>  'required',
            'created_by_id' =>  'required',
        ]);


        $ticket->update($request->all());
        return response()->json([
            'data'  =>  $ticket,
        ], 200);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
