<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tickets = Ticket::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10); // Adjust the number to how many tickets you want per page

        return view('ticket.index', compact('tickets', 'search'));
    }

    public function create(){
        return view('ticket.create');
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required|string|max:125',
            'problem_description' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'name.required' => 'Customer name is required.',
            'problem_description.required' => 'Problem description is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Phone Number is required.',
            'phone.numeric' => 'Phone Number must be numeric.',
            'phone.digits' => 'Phone Number must be exactly 10 digits.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $ticket = new Ticket();
        $ticket->name = $request->name;
        $ticket->problem_description = $request->problem_description;
        $ticket->email = $request->email;
        $ticket->reference_number = Str::uuid()->toString();
        $ticket->phone = $request->phone;
        $ticket->status = 'pending';
        $ticket->save();

        return ('Ticket submitted successfully. Your reference number is ' . $ticket->reference_number);
    }

    public function edit($id)
    {
        $ticket = Ticket::where("id", $id)->first();
        return view('ticket.edit', compact('ticket'));
    }

    public function update(Request $request, $ticket_id)
    {
        $rules = [
            'name' => 'required|string|max:125',
            'problem_description' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'reply' => 'required|string|max:225',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'name.required' => 'Customer name is required.',
            'problem_description.required' => 'Problem description is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Phone Number is required.',
            'phone.numeric' => 'Phone Number must be numeric.',
            'phone.digits' => 'Phone Number must be exactly 10 digits.',
            'reply.required' => 'Reply is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ticket = Ticket::where("id", $ticket_id)->first();
        $ticket->name = $request->name;
        $ticket->problem_description = $request->problem_description;
        $ticket->email = $request->email;
        $ticket->phone = $request->phone;
        $ticket->status = 'resolved';
        $ticket->reply = $request->reply;
        $ticket->save();

        return redirect()->route('ticket.index');
    }

    public function destroy($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        $ticket->delete();

        return redirect()->route('ticket.index');
    }
}
