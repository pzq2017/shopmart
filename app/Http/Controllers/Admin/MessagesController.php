<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\MessagesRequest;
use App\Models\Messages;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        if ($request->type == 'ajax_get_datas') {
            $request = $this->arrange($request);
            $messages = Messages::when($request->status, function ($query) use ($request) {
                    return $query->where('status', $request->status);
                })
                ->skip($request->offset)
                ->take($request->pagesize)
                ->orderBy($request->sortname, $request->sort)
                ->get()
                ->map(function ($message) {
                    if ($message->type == Messages::ADMIN_CREATED) {
                        $message->typeName = '平台消息';
                    } elseif ($message->type == Messages::SYSTEM_CREATED) {
                        $message->typeName = '系统消息';
                    }
                    if ($message->sendUserId > 0) {
                        $staff = $message->staff;
                        $message->staffName = $staff->loginName;
                    }
                    return $message;
                });
            return $this->handleSuccess($messages);
        } else {
            return view('admin.messages.index');
        }
    }

    public function create()
    {
        return view('admin.messages.create');
    }

    public function store(MessagesRequest $request)
    {
        $admin = admin_auth();
        $message = Messages::create([
            'type' => Messages::ADMIN_CREATED,
            'sendUserId' => $admin->id,
            'content' => $request->message,
        ]);
        return $this->handleSuccess([
            'id' => $message->id,
        ]);
    }

    public function edit(Messages $message)
    {
        return view('admin.messages.edit', compact('message'));
    }

    public function update(Messages $message, MessagesRequest $request)
    {
        $message->content = $request->message;
        $message->save();
        return $this->handleSuccess();
    }

    public function destroy(Messages $message)
    {
        $message->delete();
        return $this->handleSuccess();
    }

    public function sendMessage(Request $request)
    {
        return view('admin.messages.send');
    }
}
