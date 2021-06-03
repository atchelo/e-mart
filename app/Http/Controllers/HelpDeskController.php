<?php
namespace App\Http\Controllers;

use App\HelpDesk;
use App\Mail\SendTicketReplay;
use App\Mail\SendTicketToAdmin;
use App\Mail\SendTicketToUser;
use App\Notifications\SendTicket;
use App\Notifications\SendTicketStatus;
use App\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Image;
use Mail;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class HelpDeskController extends Controller
{
    public function get()
    {
        require_once 'price.php';
        return view('front.helpdesk.get', compact('conversion_rate'));
    }

    public function store(Request $request)
    {
        $request->validate(['issue_title' => 'required|min:6', 'issue' => 'required|max:5000', 'image' => 'mimes:png,jpeg,jpg,bmp,gif']);

        $hd = new HelpDesk;
        $hd->ticket_no = mt_rand(10, 100000);
        $hd->issue_title = $request->issue_title;
        $hd->issue = clean($request->issue);
        $hd->user_id = Auth::user()->id;
        $hd->status = "open";

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/helpDesk/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image, 72);

            $hd->image = $image;

        }

        $get_user_email = User::find($hd->user_id)->email;
        $get_user_name = User::find($hd->user_id)->name;

        $hd->save();

        $get_admins = User::where('role_id', '=', 'a')->get();

        /*Sending notifcation to admins*/
        \Notification::send($get_admins, new SendTicket($hd));

        /*Mail*/

        foreach ($get_admins as $admin) {
            try {
                Mail::to($admin->email)->send(new SendTicketToAdmin($hd, $get_user_name));
            } catch (\Swift_TransportException $e) {

            }
        }

        try {
            Mail::to($get_user_email)->send(new SendTicketToUser($hd));
        } catch (\Swift_TransportException $e) {

        }

        notify()->success('Ticket has been created ! You can view status of your ticket under MyAccount');
        return back();
    }

    public function userticket()
    {
        require_once 'price.php';
        return view('user.myticket', compact('conversion_rate'));
    }

    public function viewbyadmin(Request $request)
    {
        $data = \DB::table('help_desks')->join('users', 'users.id', '=', 'help_desks.user_id')
            ->select('help_desks.ticket_no as ticket', 'help_desks.issue_title as title', 'help_desks.status as status', 'users.name as username')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($data)->addIndexColumn()->addColumn('ticketno', function ($row) {
                $btn = '<p class="label label-info">' . $row->ticket . '</p>';
                return $btn;
            })->addColumn('title', function ($row) {
                return $row->title;
            })->addColumn('from', function ($row) {
                return $row->username;
            })->addColumn('status', function ($row) {

                if ($row->status == "open") {
                    $btn = '<p class="label label-info"><i class="fa fa-bullhorn" aria-hidden="true"></i>' . ucfirst($row->status) . '</p>';
                } elseif ($row->status == "pending") {
                    $btn = '<p class="label label-default"><i class="fa fa-clock-o"></i>' . ucfirst($row->status) . '</p>';
                } elseif ($row->status == "closed") {
                    $btn = '<p class="label label-danger"><i class="fa fa-ban"></i>' . ucfirst($row->status) . '</p>';
                } elseif ($row->status == "solved") {
                    $btn = '<p class="label label-success"><i class="fa fa-check"></i>' . ucfirst($row->status) . '</p>';
                }

                return $btn;
            })->editColumn('view', function ($row) {
                $btn = '<a href=' . url("admindesk/ticket/" . $row->ticket) . ' class="btn btn-sm btn-primary">View</a>';

                return $btn;
            })->rawColumns(['ticketno', 'title', 'from', 'status', 'view'])
                ->make(true);
        }

        return view('admindesk.ticket.index');
    }

    public function updateTicket(Request $request, $id)
    {
        $status = $request->ticketstatus;

        $ticket = HelpDesk::findorfail($id);

        $update = HelpDesk::where('id', '=', $id)->update(['status' => $status]);

        $data1 = "Your Ticket Status has been changed to " . $status;

        $data2 = $ticket->ticket_no;

        User::find($ticket->user_id)
            ->notify(new SendTicketStatus($data1, $data2));

        return 'Ticket status has been changed to ' . ucfirst($status);

    }

    public function show($id)
    {
        $ticket = HelpDesk::where('ticket_no', '=', $id)->first();

        return view('admindesk.ticket.show', compact('ticket'));
    }

    public function replay(Request $request, $id)
    {
        $hd = HelpDesk::where('ticket_no', '=', $id)->first();
        $newmsg = clean($request->msg);
        $get_user_email = User::find($hd->user_id)->email;

        try {
            Mail::to($get_user_email)->send(new SendTicketReplay($hd, $newmsg));
        } catch (\Swift_TransportException $e) {

        }

        notify()->success('Replied Successfully !');

        return back();
    }
}
